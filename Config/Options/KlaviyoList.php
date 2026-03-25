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

use Exception;
use MageMe\WebFormsKlaviyo\Helper\KlaviyoHelper;
use Magento\Framework\Data\OptionSourceInterface;

class KlaviyoList implements OptionSourceInterface
{
    /**
     * @var array
     */
    private $options;
    /**
     * @var KlaviyoHelper
     */
    private $klaviyoHelper;

    /**
     * @param KlaviyoHelper $klaviyoHelper
     */
    public function __construct(KlaviyoHelper $klaviyoHelper)
    {
        $this->klaviyoHelper = $klaviyoHelper;
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        if ($this->options) {
            return $this->options;
        }
        try {
            $lists = $this->klaviyoHelper->getApi()->getLists();
            foreach ($lists as $list) {
                $id = $list['id'];
                $name = $list['attributes']['name'] ?? __('Unnamed list');
                $this->options[] = [
                    'label' => __($name),
                    'value' => $id
                ];
            }
        } catch (Exception $exception) {
            $this->options = [];
        }
        return $this->options;

    }
}