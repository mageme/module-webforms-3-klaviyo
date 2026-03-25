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

namespace MageMe\WebFormsKlaviyo\Plugin\Helper\Result\PostHelper;

use Exception;
use MageMe\WebForms\Api\Data\FormInterface;
use MageMe\WebForms\Api\Data\ResultInterface;
use MageMe\WebForms\Helper\Result\PostHelper;
use MageMe\WebFormsKlaviyo\Helper\Klaviyo\AddProfile;
use Magento\Framework\Message\ManagerInterface;

class PostResult
{
    /**
     * @var AddProfile
     */
    private $addProfile;
    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @param ManagerInterface $messageManager
     * @param AddProfile $addProfile
     */
    public function __construct(ManagerInterface $messageManager, AddProfile $addProfile)
    {
        $this->addProfile     = $addProfile;
        $this->messageManager = $messageManager;
    }

    /**
     * @param PostHelper $postHelper
     * @param array $data
     * @param FormInterface|\MageMe\WebFormsKlaviyo\Api\Data\FormInterface $form
     * @param array $config
     * @return array
     * @noinspection PhpUnusedParameterInspection
     */
    public function afterPostResult(PostHelper $postHelper, array $data, FormInterface $form, array $config = []): array
    {
        if (!$data['success'] || !($data['model'] instanceof ResultInterface)) {
            return $data;
        }
        if (!$form->getIsKlaviyoEnabled()) {
            return $data;
        }
        $result = $data['model'];
        try {
            $this->addProfile->execute($result);
        } catch (Exception $e) {
            $data['model']    = false;
            $data['success']  = false;
            $data['errors'][] = $e->getMessage();
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $data;
    }

}