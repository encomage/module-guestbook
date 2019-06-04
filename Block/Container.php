<?php
/**
 * GuestBook
 *
 * @category GuestBook-module
 * @package  Encomage
 * @author   Encomage <hello@encomage.com>
 * @license  OSL https://opensource.org/licenses/OSL-3.0
 * @link     http://encomage.com
 */

namespace Encomage\GuestBook\Block;

use Magento\Framework\View\Element\Template;
use Encomage\GuestBook\Helper\Config;
use Magento\Customer\Model\Session;

class Container extends Template
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * Container constructor.
     *
     * @param Template\Context $context
     * @param Config $config
     * @param Session $customerSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Config $config,
        Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = $config;
        $this->customerSession = $customerSession;
        $this->setTemplate('Encomage_GuestBook::container.phtml');
    }

    /**
     * @return bool|\Magento\Framework\View\Element\BlockInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getFormBlock()
    {
        return $this->getChildBlock('guest.book.form');
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return (bool)$this->config->isAllowGuests() || $this->customerSession->isLoggedIn();
    }

    /**
     * @return string
     */
    public function getListingUrl()
    {
        $params = ($p = (int)$this->getRequest()->getParam(Comments\Questions::CURRENT_PAGE_PARAM, 0))
            ? ['_query' => ['p' => $p]] : [];

        return $this->getUrl('guestbook/ajax/listing', $params);
    }
}