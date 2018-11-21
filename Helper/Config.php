<?php

namespace Encomage\GuestBook\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Config
 *
 * @package Encomage\GuestBook\Helper
 */
class Config extends AbstractHelper
{
    const XML_PATH_FRONTEND_IS_ENABLED             = 'guest_book/guest_book_general/is_active',
          XML_PATH_AUTO_APPROVING                  = 'guest_book/message_settings/auto_approv',
          XML_PATH_ALLOW_GUEST                     = 'guest_book/message_settings/all_guest',
          XML_PATH_ADMINISTRATION_NAME             = 'guest_book/message_settings/admin_answer_name',
          XML_PATH_DIRECTION_SORT                  = 'guest_book/message_settings/sort',
          XML_PATH_NOTIFY_ADMIN_RECIPIENT          = 'guest_book/notify_admin/recipient',
          XML_PATH_NOTIFY_ADMIN_SENDER             = 'guest_book/notify_admin/sender',
          XML_PATH_NOTIFY_ADMIN_NEW_COMMENT        = 'guest_book/notify_admin/new_comment',
          XML_PATH_MESSAGE_SETTINGS_RECORDS        = 'guest_book/message_settings/records',
          XML_PATH_MESSAGE_SETTINGS_COUNT_MESSAGE  = 'guest_book/message_settings/count_message';

    /**
     * @return bool
     */
    public function isEnabledOnFront()
    {
        return $this->scopeConfig->isSetFlag(static::XML_PATH_FRONTEND_IS_ENABLED);
    }

    /**
     * @return mixed
     */
    public function isAutoApproving()
    {
        return $this->scopeConfig->getValue(static::XML_PATH_AUTO_APPROVING);
    }

    /**
     * @return mixed
     */
    public function isAllowGuests()
    {
        return $this->scopeConfig->getValue(static::XML_PATH_ALLOW_GUEST);
    }

    /**
     * @return mixed
     */
    public function getAdministrationName()
    {
        return $this->scopeConfig->getValue(static::XML_PATH_ADMINISTRATION_NAME);
    }

    /**
     * @return mixed
     */
    public function getCountMessage()
    {
        return $this->scopeConfig->getValue(static::XML_PATH_MESSAGE_SETTINGS_COUNT_MESSAGE);
    }

    /**
     * @return mixed
     */
    public function getSortDirection()
    {
        return $this->scopeConfig->getValue(static::XML_PATH_DIRECTION_SORT);
    }

    /**
     * @return mixed
     */
    public function getNotifyAdminRecipient()
    {
        return $this->scopeConfig->getValue(static::XML_PATH_NOTIFY_ADMIN_RECIPIENT);
    }

    /**
     * @return mixed
     */
    public function getNotifyAdminSender()
    {
        return $this->scopeConfig->getValue(static::XML_PATH_NOTIFY_ADMIN_SENDER);
    }

    /**
     * @return mixed
     */
    public function getNotifyAdminNewComment()
    {
        return $this->scopeConfig->getValue(static::XML_PATH_NOTIFY_ADMIN_NEW_COMMENT);
    }

    /**
     * @return mixed
     */
    public function getRecordsPerPage()
    {
        return $this->scopeConfig->getValue(static::XML_PATH_MESSAGE_SETTINGS_RECORDS);
    }
}