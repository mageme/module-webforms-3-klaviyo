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

namespace MageMe\WebFormsKlaviyo\Config\Options;

use Magento\Framework\Data\OptionSourceInterface;

class ProfileField implements OptionSourceInterface
{
    const ATTRIBUTES = 'attributes';
    const LOCATION = 'location';
    const PROPERTIES = 'properties';
    const CONSENT = 'consent';
    const CUSTOM_PROPERTY = 'custom_property';

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => __('Email'),
                'value' => 'email',
            ],
            [
                'label' => __('Phone number in E.164 format (e.g., "+13239169023")'),
                'value' => 'phone_number',
            ],
//            [
//                'label' => __('id'),
//                'value' => 'external_id',
//            ],
//            [
//                'label' => __('id'),
//                'value' => 'anonymous_id',
//            ],
//            [
//                'label' => __('id'),
//                'value' => '_kx',
//            ],
            [
                'label' => __('First name'),
                'value' => 'first_name',
            ],
            [
                'label' => __('Last name'),
                'value' => 'last_name',
            ],

            [
                'label' => __('Organization'),
                'value' => 'organization',
            ],
            [
                'label' => __('Title'),
                'value' => 'title',
            ],
            [
                'label' => __('URL to a photo of a person'),
                'value' => 'image',
            ],

            [
                'label' => __('Location'),
                'value' => [
                    [
                        'label' => __('Street line 1'),
                        'value' => 'address1',
                    ],
                    [
                        'label' => __('Street line 2'),
                        'value' => 'address2',
                    ],
                    [
                        'label' => __('City'),
                        'value' => 'city',
                    ],
                    [
                        'label' => __('Country'),
                        'value' => 'country',
                    ],
                    [
                        'label' => __('Region'),
                        'value' => 'region',
                    ],
                    [
                        'label' => __('Postal code'),
                        'value' => 'zip',
                    ],
//                    [
//                        'label' => __('Latitude'),
//                        'value' => 'latitude',
//                    ],
//                    [
//                        'label' => __('Longitude'),
//                        'value' => 'longitude',
//                    ],
//                    [
//                        'label' => __('Timezone'),
//                        'value' => 'timezone',
//                    ],
//                    [
//                        'label' => __('IP address'),
//                        'value' => 'ip',
//                    ],
                ],
            ],
            [
                'label' => __("Consent (e.g. ['sms', 'email', 'web', 'directmail', 'mobile'])"),
                'value' => self::CONSENT,
            ],
            [
                'label' => __('Custom property (Field label)'),
                'value' => self::CUSTOM_PROPERTY,
            ],
        ];
    }
}