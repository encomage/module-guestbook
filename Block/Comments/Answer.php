<?php

namespace Encomage\GuestBook\Block\Comments;

use Magento\Framework\View\Element\Template;
use Encomage\GuestBook\Api\GuestBookRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Encomage\GuestBook\Helper\Config;
use Magento\Customer\Model\Session;
use Encomage\GuestBook\Model\GuestBook\Source\Status;
use Encomage\GuestBook\Api\Data\GuestBookInterface;
use Encomage\GuestBook\Model\GuestBook;

/**
 * Class Answer
 *
 * @package Encomage\GuestBook\Block\Comments
 */
class Answer extends Template
{
    /**
     * @var GuestBookRepositoryInterface
     */
    protected $guestBookRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var null
     */
    protected $loadedCollection = null;

    /**
     * @var null
     */
    protected $messageId = null;

    /**
     * Answer constructor.
     *
     * @param Template\Context $context
     * @param GuestBookRepositoryInterface $guestBookRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param Config $config
     * @param Session $session
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        GuestBookRepositoryInterface $guestBookRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        Config $config,
        Session $session,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->guestBookRepository = $guestBookRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->config = $config;
        $this->customerSession = $session;
        $this->setTemplate('Encomage_GuestBook::comments/answer-item.phtml');
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAnswerHtml()
    {
        $html = '';
        $collection = $this->_getGuestBookQuestionAnswerCollection();
        if ($collection) {
            $dataTree = $collection->asTree();
            foreach ($dataTree as $item) {
                $html .= $this->_prepareItemToRender($item);
            }
        }

        return $html;
    }

    /**
     * @return mixed
     */
    protected function _getGuestBookQuestionAnswerCollection()
    {
        $this->sortOrderBuilder->setField(GuestBookInterface::MESSAGE_ID);
        $direction = $this->config->getSortDirection();
        $sortOrder = $this->sortOrderBuilder->setDirection($direction)->create();
        if ($this->customerSession->isLoggedIn()) {
            $this->searchCriteriaBuilder->addFilter(
                'statusCustomFilter',
                $this->customerSession->getCustomer()->getRpToken()
            );
        } else {
            $this->searchCriteriaBuilder->addFilter('statusCustomFilter', null);
        }
        $this->searchCriteriaBuilder->addFilter('onlyAnswer', $this->getMessageId());
        $this->searchCriteriaBuilder->addSortOrder($sortOrder);
        $searchCriteria = $this->searchCriteriaBuilder->create();

        return $this->guestBookRepository->getList($searchCriteria);
    }

    /**
     * @return null
     */
    public function getMessageId()
    {
        return $this->messageId;
    }

    /**
     * @param $messageId
     * @return $this
     */
    public function setMessageId($messageId)
    {
        if (is_null($this->messageId)) {
            $this->messageId = $messageId;
        }

        return $this;
    }

    /**
     * @param GuestBook $item
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareItemToRender(GuestBook $item)
    {
        $html = '';
        $this->setAnswer($item);
        if ((int)$item->getStatus() !== (int)Status::STATUS_REJECTED) {
            $html .= $this->toHtml();
        }
        if (is_null($item->getReplyPath())) {
            $html = '';
        }
        if ($item->hasData('answer')) {
            foreach ($item->getAnswer() as $answer) {
                $html .= $this->_prepareItemToRender($answer);
            }
        }

        return $html;
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        if ($this->config->isAllowGuests() || $this->customerSession->isLoggedIn()) {
            return true;
        }

        return false;
    }

    /**
     * @return \Encomage\GuestBook\Block\Comments\Form
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getFormBlock()
    {
        return $this->getLayout()->createBlock(\Encomage\GuestBook\Block\Comments\Form::class);
    }
}