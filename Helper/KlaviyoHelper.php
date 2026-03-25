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

namespace MageMe\WebFormsKlaviyo\Helper;

use MageMe\WebFormsKlaviyo\Helper\Klaviyo\Api;
use Magento\Framework\App\Config\ScopeConfigInterface;
use InvalidArgumentException;

class KlaviyoHelper
{
    const CONFIG_PUBLIC_TOKEN = 'webforms/klaviyo/public_token';
    const CONFIG_PRIVATE_TOKEN = 'webforms/klaviyo/private_token';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var Api
     */
    private $api;
    /**
     * @var ScopeHelper
     */
    private $scopeHelper;

    /**
     * @param ScopeHelper $scopeHelper
     * @param Api $api
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeHelper $scopeHelper,
        Api                  $api,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->api         = $api;
        $this->scopeHelper         = $scopeHelper;
    }

    /**
     * @param string $scopeType
     * @param null $scopeCode
     * @return string|null
     */
    protected function getConfigPublicToken(string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                                            $scopeCode = null): ?string
    {
        return $this->scopeConfig->getValue(self::CONFIG_PUBLIC_TOKEN, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param null $scopeCode
     * @return string|null
     */
    protected function getConfigPrivateToken(string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                                             $scopeCode = null): ?string
    {
        return $this->scopeConfig->getValue(self::CONFIG_PRIVATE_TOKEN, $scopeType, $scopeCode);
    }

    /**
     * @param string $scopeType
     * @param null $scopeCode
     * @return string|null
     */
    protected function getConfigPrivateTokenWithPrefix(string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                                                    $scopeCode = null): ?string
    {
        $token = $this->getConfigPrivateToken( $scopeType, $scopeCode);
        if (!str_starts_with($token, 'Klaviyo-API-Key ')) {
            $token = 'Klaviyo-API-Key ' . $token;
        }
        return $token;
    }

    /**
     * @param string $scopeType
     * @param null $scopeCode
     * @return Api
     */
    public function getApi(string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                                  $scopeCode = null): Api
    {
        if ($scopeType == ScopeConfigInterface::SCOPE_TYPE_DEFAULT && $scopeCode == null) {
            $scope = $this->scopeHelper->getScope();
            $scopeType = $scope->getData('scope_type');
            $scopeCode = $scope->getData('scope_id');
        }
        $this->validateConfig($scopeType, $scopeCode);
        $this->api->setPublicToken($this->getConfigPublicToken($scopeType, $scopeCode));
        $this->api->setPrivateToken($this->getConfigPrivateTokenWithPrefix($scopeType, $scopeCode));
        return $this->api;
    }

    /**
     * @return void
     * @throws InvalidArgumentException
     */
    public function validateConfig(string $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
                                          $scopeCode = null)
    {
        if (empty($this->getConfigPublicToken($scopeType, $scopeCode))) {
            throw new InvalidArgumentException(__('Klaviyo public key not configured.'));
        }
        if (empty($this->getConfigPrivateToken($scopeType, $scopeCode))) {
            throw new InvalidArgumentException(__('Klaviyo private key not configured.'));
        }
    }
}