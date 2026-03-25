<?php
/**
 * MageMe
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageMe.com license that is
 * available through the world-wide-web at this URL:
 * https://mageme.com/license
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to a newer
 * version in the future.
 *
 * Copyright (c) MageMe (https://mageme.com)
 **/

namespace MageMe\WebFormsKlaviyo\Helper\Klaviyo;

use Exception;
use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;

class Api
{
    const API_URL = 'https://a.klaviyo.com/api';
    const API_REVISION = '2024-05-15';

    const CLIENT_ERROR = 'Client error';
    const SERVER_ERROR = 'Server error';
    const UNEXPECTED_ERROR = 'Unexpected error';

    /**
     * @var string|null
     */
    private $publicToken;
    /**
     * @var string|null
     */
    private $privateToken;
    /**
     * @var Curl
     */
    private $curl;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     * @param Curl $curl
     */
    public function __construct(
        LoggerInterface $logger,
        Curl            $curl
    ) {
        $this->curl   = $curl;
        $this->logger = $logger;
    }

    #region Getters\Setters

    /**
     * @return string
     */
    public function getPublicToken(): string
    {
        return $this->publicToken;
    }

    /**
     * @param string|null $token
     * @return Api
     */
    public function setPublicToken(?string $token): Api
    {
        $this->publicToken = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrivateToken(): string
    {
        return $this->privateToken;
    }

    /**
     * @param string|null $token
     * @return Api
     */
    public function setPrivateToken(?string $token): Api
    {
        $this->privateToken = $token;
        return $this;
    }
    #endregion

    /**
     * @return array
     * @throws Exception
     */
    public function getLists(): array
    {
        $allLists = [];
        $url = self::API_URL . '/lists';

        do {
            $this->curl->setHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $this->getPrivateToken(),
                'revision' => self::API_REVISION
            ]);
            $this->curl->setOptions([
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
            ]);

            $this->curl->get($url);
            $status = $this->curl->getStatus();

            if ($status == 200) {
                $response = json_decode($this->curl->getBody(), true);
                if (isset($response['data']) && is_array($response['data'])) {
                    $allLists = array_merge($allLists, $response['data']);
                }

                // Check for next page
                $url = $response['links']['next'] ?? null;
            } else {
                // Handle error (your existing error handling)
                break;
            }
        } while ($url);

        usort($allLists, function($a, $b) {
            return strcasecmp($a['attributes']['name'], $b['attributes']['name']);
        });

        return $allLists;
    }

    /**
     * @param array $attributes
     * @return void
     * @throws Exception
     */
    public function createUpdateProfile(array $attributes)
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getPrivateToken(),
            'revision' => self::API_REVISION
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $data = [
            'data' => [
                'type' => 'profile',
                'attributes' => $attributes,
            ]
        ];
        $this->curl->post(self::API_URL . '/profile-import', json_encode($data));
        $status = $this->curl->getStatus();
        if (in_array($status, [200, 201])) {
            return;
        }
        $error = self::UNEXPECTED_ERROR;
        if (str_starts_with($status, 4)) {
            $error = self::CLIENT_ERROR;
        }
        else if (str_starts_with($status, 5)) {
            $error = self::SERVER_ERROR;
        }
        $this->logger->error($error . ' body: ' . $this->curl->getBody());
        throw new Exception(__($this->getErrorText($error, $this->curl->getBody())));
    }

    /**
     * @param string $event
     * @param array $attributes
     * @return void
     * @throws Exception
     */
    public function createEvent(string $event, array $attributes)
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getPrivateToken(),
            'revision' => self::API_REVISION
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $data = [
            'data' => [
                'type' => 'event',
                'attributes' => [
                    'properties' => [],
                    'metric' => [
                        'data' => [
                            'type' => 'metric',
                            'attributes' => [
                                'name' => $event
                            ],
                        ]
                    ],
                    'profile' => [
                        'data' => [
                            'type' => 'profile',
                            'attributes' => $attributes,
                        ]
                    ]
                ],
            ]
        ];
        $this->curl->post(self::API_URL . '/events', json_encode($data));
        $status = $this->curl->getStatus();
        if ($status == 202) {
            return;
        }
        $error = self::UNEXPECTED_ERROR;
        if (str_starts_with($status, 4)) {
            $error = self::CLIENT_ERROR;
        }
        else if (str_starts_with($status, 5)) {
            $error = self::SERVER_ERROR;
        }
        $this->logger->error($error . ' body: ' . $this->curl->getBody());
        throw new Exception(__($this->getErrorText($error, $this->curl->getBody())));
    }

    /**
     * @param array $attributes
     * @param array $subscriptions
     * @param string|null $list
     * @return void
     * @throws Exception
     */
    public function subscribe(array $attributes, array $subscriptions = [], ?string $list = null)
    {
        $this->curl->setHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $this->getPrivateToken(),
            'revision' => self::API_REVISION
        ]);
        $this->curl->setOptions([
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ]);
        $profileData = [];
        if (!empty($attributes['email'])) {
            $profileData['email'] = $attributes['email'];
        }
        if (!empty($attributes['phone_number'])) {
            $profileData['phone_number'] = $attributes['phone_number'];
        }
        if (!empty($subscriptions)) {
            $profileData['subscriptions'] = $subscriptions;
        }
        $data = [
            'data' => [
                'type' => 'profile-subscription-bulk-create-job',
                'attributes' => [
                    'profiles' => [
                        'data' => [
                            [
                                'type' => 'profile',
                                'attributes' => $profileData
                            ]
                        ]
                    ]
                ]
            ]
        ];
        if (!empty($list)) {
            $data['data']['relationships'] = [
                'list' => [
                    'data' => [
                        'type' => 'list',
                        'id' => $list
                    ]
                ]
            ];
        }
        $this->curl->post(self::API_URL . '/profile-subscription-bulk-create-jobs', json_encode($data));
        $status = $this->curl->getStatus();
        if ($status == 202) {
            return;
        }
        $error = self::UNEXPECTED_ERROR;
        if (str_starts_with($status, 4)) {
            $error = self::CLIENT_ERROR;
        }
        else if (str_starts_with($status, 5)) {
            $error = self::SERVER_ERROR;
        }
        $this->logger->error($error . ' body: ' . $this->curl->getBody());
        throw new Exception(__($this->getErrorText($error, $this->curl->getBody())));
    }

    private function getErrorText($title, $body) {
        $response = json_decode($body, true);
        if (!isset($response['errors']) || !is_array($response['errors'])) {
            return $title;
        }
        $error = [];
        foreach ($response['errors'] as $errorData) {
            if (!empty($errorData['detail'])) {
                $error[] = $errorData['detail'];
            }
        }
        return empty($error) ? $title : implode("\n ", $error);
    }
}