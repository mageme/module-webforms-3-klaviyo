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

namespace MageMe\WebFormsKlaviyo\Model;

use MageMe\WebFormsKlaviyo\Api\Data\FormInterface;

class Form extends \MageMe\WebForms\Model\Form implements FormInterface
{
    #region DB getters and setters
    /**
     * @inheritDoc
     */
    public function getIsKlaviyoEnabled(): bool
    {
        return (bool)$this->getData(self::IS_KLAVIYO_ENABLED);
    }

    /**
     * @inheritDoc
     */
    public function setIsKlaviyoEnabled(bool $isKlaviyoEnabled): FormInterface
    {
        return $this->setData(self::IS_KLAVIYO_ENABLED, $isKlaviyoEnabled);
    }

    /**
     * @inheritDoc
     */
    public function getKlaviyoEndpoint(): ?int
    {
        return $this->getData(self::KLAVIYO_ENDPOINT);
    }

    /**
     * @inheritDoc
     */
    public function setKlaviyoEndpoint(int $klaviyoEndpoint): FormInterface
    {
        return $this->setData(self::KLAVIYO_ENDPOINT, $klaviyoEndpoint);
    }

    /**
     * @inheritDoc
     */
    public function getKlaviyoEvent(): ?string
    {
        return $this->getData(self::KLAVIYO_EVENT);
    }

    /**
     * @inheritDoc
     */
    public function setKlaviyoEvent(string $klaviyoEvent): FormInterface
    {
        return $this->setData(self::KLAVIYO_EVENT, $klaviyoEvent);
    }

    /**
     * @inheritDoc
     */
    public function getKlaviyoEmailFieldId(): ?int
    {
        return $this->getData(self::KLAVIYO_EMAIL_FIELD_ID);
    }

    /**
     * @inheritDoc
     */
    public function setKlaviyoEmailFieldId(?int $klaviyoEmailFieldId): FormInterface
    {
        return $this->setData(self::KLAVIYO_EMAIL_FIELD_ID, $klaviyoEmailFieldId);
    }

    /**
     * @inheritDoc
     */
    public function getKlaviyoMapFieldsSerialized(): ?string
    {
        return $this->getData(self::KLAVIYO_MAP_FIELDS_SERIALIZED);
    }

    /**
     * @inheritDoc
     */
    public function setKlaviyoMapFieldsSerialized(string $klaviyoMapFieldsSerialized): FormInterface
    {
        return $this->setData(self::KLAVIYO_MAP_FIELDS_SERIALIZED, $klaviyoMapFieldsSerialized);
    }

    /**
     * @inheritDoc
     */
    public function getKlaviyoListsSerialized(): ?string
    {
        return $this->getData(self::KLAVIYO_LISTS_SERIALIZED);
    }

    /**
     * @inheritDoc
     */
    public function setKlaviyoListsSerialized(string $klaviyoListsSerialized): FormInterface
    {
        return $this->setData(self::KLAVIYO_LISTS_SERIALIZED, $klaviyoListsSerialized);
    }

    /**
     * @inheritDoc
     */
    public function getKlaviyoMapFields(): array
    {
        $data = $this->getData(self::KLAVIYO_MAP_FIELDS);
        return is_array($data) ? $data : [];
    }

    /**
     * @inheritDoc
     */
    public function setKlaviyoMapFields(array $klaviyoMapFields): FormInterface
    {
        return $this->setData(self::KLAVIYO_MAP_FIELDS, $klaviyoMapFields);
    }

    /**
     * @inheritDoc
     */
    public function getKlaviyoLists(): array
    {
        $data = $this->getData(self::KLAVIYO_LISTS);
        return is_array($data) ? $data : [];
    }

    /**
     * @inheritDoc
     */
    public function setKlaviyoLists(array $klaviyoLists): FormInterface
    {
        return $this->setData(self::KLAVIYO_LISTS, $klaviyoLists);
    }
    #endregion
}
