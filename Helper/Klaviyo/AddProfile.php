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
use InvalidArgumentException;
use MageMe\WebForms\Api\Data\FieldInterface;
use MageMe\WebForms\Api\Data\FormInterface;
use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Api\FieldRepositoryInterface;
use MageMe\WebFormsKlaviyo\Config\Options\Endpoint;
use MageMe\WebFormsKlaviyo\Config\Options\ProfileField;
use MageMe\WebFormsKlaviyo\Helper\KlaviyoHelper;
use MageMe\WebFormsKlaviyo\Ui\Component\Form\Form\Modifier\KlaviyoIntegrationSettings;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;

class AddProfile
{

    /**
     * @var KlaviyoHelper
     */
    private $klaviyoHelper;
    /**
     * @var FieldRepositoryInterface
     */
    private $fieldRepository;

    /**
     * @param FieldRepositoryInterface $fieldRepository
     * @param KlaviyoHelper $klaviyoHelper
     */
    public function __construct(FieldRepositoryInterface $fieldRepository, KlaviyoHelper $klaviyoHelper)
    {
        $this->klaviyoHelper   = $klaviyoHelper;
        $this->fieldRepository = $fieldRepository;
    }

    /**
     * @param ResultInterface $result
     * @return void
     * @throws NoSuchEntityException
     * @throws Exception
     */
    public function execute(ResultInterface $result)
    {
        /** @var \MageMe\WebFormsKlaviyo\Api\Data\FormInterface $form */
        $form      = $result->getForm();
        $email     = $this->getEmail($form, $result);
        $firstName = '';
        $lastName  = $result->getCustomerName();
        $customer  = $result->getCustomer();
        if ($customer) {
            $firstName = $customer->getFirstname();
            $lastName  = $customer->getLastname();
        }
        $attributes = [];
        if ($email) {
            $attributes['email'] = $email;
        }
        if ($firstName) {
            $attributes['first_name'] = $firstName;
        }
        if ($lastName) {
            $attributes['last_name'] = $lastName;
        }
        $mapFields = $this->mapFields($form, $result);
        $attributes   = array_merge($attributes, $mapFields[ProfileField::ATTRIBUTES]);
        $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        $scopeId   = null;
        if ($result->getStoreId() != null) {
            $scopeType = ScopeInterface::SCOPE_STORE;
            $scopeId   = (int)$result->getStoreId();
        }
        $api = $this->klaviyoHelper->getApi($scopeType, $scopeId);
        if (empty($attributes['email']) && empty($attributes['phone_number'])) {
            throw new InvalidArgumentException(__('Email or phone required'));
        }
        if ($form->getKlaviyoEndpoint() == Endpoint::TRACK) {
            $api->createEvent($form->getKlaviyoEvent(), $attributes);
        } else {
            $api->createUpdateProfile($attributes);
        }

        // Subscribe
        if ($form->getKlaviyoLists()) {
            foreach ($form->getKlaviyoLists() as $listId) {
                $api->subscribe($attributes, $mapFields[ProfileField::CONSENT], $listId);
            }
        } else {
            if ($mapFields[ProfileField::CONSENT]) {
                $api->subscribe($attributes, $mapFields[ProfileField::CONSENT]);
            }
        }
    }

    /**
     * @param FormInterface|\MageMe\WebFormsKlaviyo\Api\Data\FormInterface $form
     * @param ResultInterface $result
     * @return string
     */
    protected function getEmail(FormInterface $form, ResultInterface $result): string
    {
        $values  = $result->getFieldArray();
        $emailId = $form->getKlaviyoEmailFieldId();
        $email   = $values[$emailId] ?? '';
        if ($email) {
            return $email;
        }
        $emailList = $result->getCustomerEmail();
        return $emailList[0] ?? '';
    }

    /**
     * @param FormInterface|\MageMe\WebFormsKlaviyo\Api\Data\FormInterface $form
     * @param ResultInterface $result
     * @return array
     * @throws NoSuchEntityException
     */
    protected function mapFields(FormInterface $form, ResultInterface $result): array
    {
        $attributes   = [];
        $location = [];
        $customProperties = [];
        $consent   = [];
        $values    = $result->getFieldArray();
        $mapFields = $form->getKlaviyoMapFields();
        foreach ($mapFields as $mapField) {
            if (empty($values[$mapField[FieldInterface::ID]])) {
                continue;
            }
            $field     = $this->fieldRepository->getById((int)$mapField[FieldInterface::ID]);
            $value     = $field->getValueForResultTemplate(
                $values[$mapField[FieldInterface::ID]],
                $result->getId(),
                ['date_format' => 'yyyy-MM-dd']
            );
            switch ($mapField[KlaviyoIntegrationSettings::KLAVIYO_FIELD_ID]) {
                case ProfileField::CUSTOM_PROPERTY: {
                    $fieldName = $field->getResultLabel();
                    $customProperties[$fieldName] = $value;
                    break;
                }
                case ProfileField::CONSENT: {
                    $value = strtolower($value);
                    if (!in_array($value, $this->getConsentArr())) {
                        break;
                    }
                    $consent[$value] = [
                        'marketing' => [
                            'consent' => 'SUBSCRIBED'
                        ]
                    ];
                    break;
                }
                default: {
                    $fieldName = $mapField[KlaviyoIntegrationSettings::KLAVIYO_FIELD_ID];
                    if (in_array($fieldName, $this->getLocationFieldsArr())) {
                        $location[$fieldName] = $value;
                    } else {
                        $attributes[$fieldName] = $value;
                    }
                }
            }
        }
        if (!empty($location)) {
            $attributes[ProfileField::LOCATION] = $location;
        }
        if (!empty($customProperties)) {
            $attributes[ProfileField::PROPERTIES] = $customProperties;
        }
        return [
            ProfileField::ATTRIBUTES => $attributes,
            ProfileField::CONSENT => $consent,
        ];
    }

    /**
     * @return array
     */
    private function getLocationFieldsArr(): array
    {
        return ['address1', 'address2', 'city', 'country', 'latitude', 'longitude', 'region', 'zip', 'timezone', 'ip'];
    }

    /**
     * @return array
     */
    private function getConsentArr(): array
    {
        return ['email', 'sms'];
    }
}