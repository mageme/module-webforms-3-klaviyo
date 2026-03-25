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

namespace MageMe\WebFormsKlaviyo\Api\Data;

interface FormInterface extends \MageMe\WebForms\Api\Data\FormInterface
{
    /** Klaviyo settings */
    const IS_KLAVIYO_ENABLED = 'is_klaviyo_enabled';
    const KLAVIYO_ENDPOINT = 'klaviyo_endpoint';
    const KLAVIYO_EVENT = 'klaviyo_event';
    const KLAVIYO_EMAIL_FIELD_ID = 'klaviyo_email_field_id';
    const KLAVIYO_MAP_FIELDS_SERIALIZED = 'klaviyo_map_fields_serialized';
    const KLAVIYO_LISTS_SERIALIZED = 'klaviyo_lists_serialized';

    /**
     * Additional constants for keys of data array.
     */
    const KLAVIYO_MAP_FIELDS = 'klaviyo_map_fields';
    const KLAVIYO_LISTS = 'klaviyo_lists';

    #region KLAVIYO
    /**
     * Get isKlaviyoEnabled
     *
     * @return bool
     */
    public function getIsKlaviyoEnabled(): bool;

    /**
     * Set isKlaviyoEnabled
     *
     * @param bool $isKlaviyoEnabled
     * @return $this
     */
    public function setIsKlaviyoEnabled(bool $isKlaviyoEnabled): FormInterface;

    /**
     * Get klaviyoEndpoint
     *
     * @return int|null
     */
    public function getKlaviyoEndpoint(): ?int;

    /**
     * Set klaviyoEndpoint
     *
     * @param int $klaviyoEndpoint
     * @return $this
     */
    public function setKlaviyoEndpoint(int $klaviyoEndpoint): FormInterface;

    /**
     * Get klaviyoEvent
     *
     * @return string|null
     */
    public function getKlaviyoEvent(): ?string;

    /**
     * Set klaviyoEventId
     *
     * @param string $klaviyoEvent
     * @return $this
     */
    public function setKlaviyoEvent(string $klaviyoEvent): FormInterface;

    /**
     * Get klaviyoEmailFieldId
     *
     * @return int|null
     */
    public function getKlaviyoEmailFieldId(): ?int;

    /**
     * Set klaviyoEmailFieldId
     *
     * @param int|null $klaviyoEmailFieldId
     * @return $this
     */
    public function setKlaviyoEmailFieldId(?int $klaviyoEmailFieldId): FormInterface;

    /**
     * Get klaviyoMapFieldsSerialized
     *
     * @return string|null
     */
    public function getKlaviyoMapFieldsSerialized(): ?string;

    /**
     * Set klaviyoMapFieldsSerialized
     *
     * @param string $klaviyoMapFieldsSerialized
     * @return $this
     */
    public function setKlaviyoMapFieldsSerialized(string $klaviyoMapFieldsSerialized): FormInterface;

    /**
     * Get klaviyoListsSerialized
     *
     * @return string|null
     */
    public function getKlaviyoListsSerialized(): ?string;

    /**
     * Set klaviyoListsSerialized
     *
     * @param string $klaviyoListsSerialized
     * @return $this
     */
    public function setKlaviyoListsSerialized(string $klaviyoListsSerialized): FormInterface;

    /**
     * Get klaviyoMapFields
     *
     * @return array
     */
    public function getKlaviyoMapFields(): array;

    /**
     * Set klaviyoMapFields
     *
     * @param array $klaviyoMapFields
     * @return $this
     */
    public function setKlaviyoMapFields(array $klaviyoMapFields): FormInterface;

    /**
     * Get klaviyoLists
     *
     * @return array
     */
    public function getKlaviyoLists(): array;

    /**
     * Set klaviyoLists
     *
     * @param array $klaviyoLists
     * @return $this
     */
    public function setKlaviyoLists(array $klaviyoLists): FormInterface;
    #endregion
}
