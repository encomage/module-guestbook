<?php

namespace Encomage\GuestBook\Block\Comments;

use Magento\Framework\View\Element\Template;
use Encomage\GuestBook\Helper\Config;
use Magento\Customer\Model\SessionFactory;

/**
 * Class Form
 *
 * @package Encomage\GuestBook\Block\Comments
 */
class Form extends Template
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var sessionFactory
     */
    protected $sessionFactory;

    /**
     * Form constructor.
     *
     * @param Template\Context $context
     * @param Config $config
     * @param SessionFactory $sessionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Config $config,
        SessionFactory $sessionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = $config;
        $this->sessionFactory = $sessionFactory->create();
        $this->setTemplate('Encomage_GuestBook::comments/form.phtml');
    }

    /**
     * @return string
     */
    public function getAddCommentUrl()
    {
        return $this->getUrl('guestbook/index/save');
    }

    /**
     * @return bool|string
     */
    public function getLoggedInCustomerId()
    {
        if ($this->sessionFactory->isLoggedIn()) {
            return $this->sessionFactory->getId();
        } else {
            if ($this->config->isAllowGuests()) {
                return 'guest';
            } else {
                return false;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getCustomerData()
    {
        return $this->sessionFactory->getCustomer()->getData();
    }
}