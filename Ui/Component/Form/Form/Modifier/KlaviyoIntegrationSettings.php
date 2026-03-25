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

namespace MageMe\WebFormsKlaviyo\Ui\Component\Form\Form\Modifier;

use MageMe\WebForms\Api\Data\FieldInterface;
use MageMe\WebForms\Api\Data\FormInterface as FormInterfaceAlias;
use MageMe\WebForms\Api\FormRepositoryInterface;
use MageMe\WebForms\Model\Field\Type\Email;
use MageMe\WebFormsKlaviyo\Api\Data\FormInterface;
use MageMe\WebFormsKlaviyo\Config\Options\Endpoint;
use MageMe\WebFormsKlaviyo\Config\Options\KlaviyoList;
use MageMe\WebFormsKlaviyo\Config\Options\ProfileField;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Ui\Component\Container;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form;
use Magento\Ui\Component\Form\Element\ActionDelete;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class KlaviyoIntegrationSettings implements ModifierInterface
{
    const KLAVIYO_FIELD_ID = 'klaviyo_field_id';
    /**
     * @var FormRepositoryInterface
     */
    private $formRepository;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var Endpoint
     */
    private $endpoint;
    /**
     * @var ProfileField
     */
    private $profileField;
    /**
     * @var KlaviyoList
     */
    private $klaviyoList;

    /**
     * @param KlaviyoList $klaviyoList
     * @param ProfileField $profileField
     * @param Endpoint $endpoint
     * @param RequestInterface $request
     * @param FormRepositoryInterface $formRepository
     */
    public function __construct(
        KlaviyoList $klaviyoList,
        ProfileField            $profileField,
        Endpoint                $endpoint,
        RequestInterface        $request,
        FormRepositoryInterface $formRepository
    ) {
        $this->formRepository = $formRepository;
        $this->request        = $request;
        $this->endpoint       = $endpoint;
        $this->profileField   = $profileField;
        $this->klaviyoList   = $klaviyoList;
    }

    /**
     * @inheritDoc
     */
    public function modifyData(array $data): array
    {
        return $data;
    }

    /**
     * @inheritDoc
     */
    public function modifyMeta(array $meta): array
    {
        $meta['klaviyo_integration_settings'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Form\Fieldset::NAME,
                        'label' => __('Klaviyo Integration Settings'),
                        'sortOrder' => 170,
                        'collapsible' => true,
                        'opened' => false,
                    ]
                ]
            ],
            'children' => [
                FormInterface::IS_KLAVIYO_ENABLED => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Checkbox::NAME,
                                'dataType' => Form\Element\DataType\Boolean::NAME,
                                'visible' => 1,
                                'sortOrder' => 10,
                                'label' => __('Enable Klaviyo Integration'),
                                'default' => '0',
                                'prefer' => 'toggle',
                                'valueMap' => ['false' => '0', 'true' => '1'],
                            ]
                        ]
                    ]
                ],
                FormInterface::KLAVIYO_ENDPOINT => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Number::NAME,
                                'visible' => 1,
                                'sortOrder' => 20,
                                'label' => __('Endpoint'),
                                'options' => $this->endpoint->toOptionArray(),
                                'switcherConfig' => [
                                    'component' => 'Magento_Ui/js/form/switcher',
                                    'enabled' => true,
                                    'rules' => [
                                        [
                                            'value' => Endpoint::IDENTIFY,
                                            'actions' => [
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::KLAVIYO_EVENT,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'hide'
                                                ],
                                            ]
                                        ],
                                        [
                                            'value' => Endpoint::TRACK,
                                            'actions' => [
                                                [
                                                    'target' => '${ $.parentName }.' . FormInterface::KLAVIYO_EVENT,
                                                    '__disableTmpl' => false,
                                                    'callback' => 'show'
                                                ],
                                            ]
                                        ]
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
                FormInterface::KLAVIYO_EVENT => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Input::NAME,
                                'dataType' => Form\Element\DataType\Text::NAME,
                                'visible' => 0,
                                'sortOrder' => 30,
                                'label' => __('Event')
                            ]
                        ]
                    ]
                ],
                FormInterface::KLAVIYO_EMAIL_FIELD_ID => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\Select::NAME,
                                'dataType' => Form\Element\DataType\Number::NAME,
                                'visible' => 1,
                                'sortOrder' => 40,
                                'label' => __('Customer Email'),
                                'options' => $this->getFields(Email::class),
                                'caption' => __('Default'),
                            ]
                        ]
                    ]
                ],
                FormInterface::KLAVIYO_LISTS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Form\Field::NAME,
                                'formElement' => Form\Element\MultiSelect::NAME,
                                'visible' => 1,
                                'sortOrder' => 50,
                                'label' => __('Add Profile To Lists'),
                                'options' => $this->klaviyoList->toOptionArray(),
                            ]
                        ]
                    ]
                ],

                FormInterface::KLAVIYO_MAP_FIELDS => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => DynamicRows::NAME,
                                'visible' => 1,
                                'sortOrder' => 150,
                                'label' => __('Fields Mapping'),
                            ]
                        ]
                    ],
                    'children' => [
                        'record' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'componentType' => Container::NAME,
                                        'isTemplate' => true,
                                        'is_collection' => true,
                                    ]
                                ]
                            ],
                            'children' => [
                                self::KLAVIYO_FIELD_ID => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => Form\Field::NAME,
                                                'formElement' => Form\Element\Select::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'visible' => 1,
                                                'sortOrder' => 10,
                                                'label' => __('Klaviyo Attribute'),
                                                'options' => $this->profileField->toOptionArray(),
                                                'validation' => [
                                                    'required-entry' => true,
                                                ],
                                            ]
                                        ]
                                    ]
                                ],
                                FieldInterface::ID => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => Form\Field::NAME,
                                                'formElement' => Form\Element\Select::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'visible' => 1,
                                                'sortOrder' => 20,
                                                'label' => __('Field'),
                                                'options' => $this->getFields(),
                                                'validation' => [
                                                    'required-entry' => true,
                                                ],
                                            ]
                                        ]
                                    ]
                                ],
                                ActionDelete::NAME => [
                                    'arguments' => [
                                        'data' => [
                                            'config' => [
                                                'componentType' => ActionDelete::NAME,
                                                'dataType' => Form\Element\DataType\Text::NAME,
                                                'label' => '',
                                                'sortOrder' => 30,
                                            ],
                                        ],
                                    ],
                                ],
                            ]
                        ]
                    ]
                ],
            ]
        ];
        return $meta;
    }

    /**
     * @param mixed $type
     * @return array
     */
    protected function getFields($type = false): array
    {
        $formId = (int)$this->request->getParam(FormInterfaceAlias::ID);
        if (!$formId) {
            return [];
        }
        try {
            return $this->formRepository->getById($formId)->getFieldsAsOptions($type);
        } catch (NoSuchEntityException $e) {
            return [];
        }
    }
}