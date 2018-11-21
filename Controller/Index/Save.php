<?php

namespace Encomage\GuestBook\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Encomage\GuestBook\Model\GuestBookFactory;
use Encomage\GuestBook\Api\GuestBookRepositoryInterface;
use Encomage\GuestBook\Model\GuestBook\Source\Status;
use Encomage\GuestBook\Helper\Config;
use Encomage\GuestBook\Helper\Data as Helper;

/**
 * Class Comment
 *
 * @package Encomage\GuestBook\Controller\Index
 */
class Save extends Action
{
    /**
     * @var GuestBookFactory
     */
    protected $guestBookFactory;

    /**
     * @var GuestBookRepositoryInterface
     */
    protected $guestBookRepository;

    /**
     * @var Config
     */
    protected $configHelper;

    /**
     * @var Helper
     */
    protected $helper;

    /**
     * Save constructor.
     *
     * @param Context $context
     * @param GuestBookFactory $guestBookFactory
     * @param GuestBookRepositoryInterface $guestBookRepository
     * @param Config $configHelper
     * @param Helper $helper
     */
    public function __construct(
        Context $context,
        GuestBookFactory $guestBookFactory,
        GuestBookRepositoryInterface $guestBookRepository,
        Config $configHelper,
        Helper $helper
    ) {
        parent::__construct($context);
        $this->guestBookFactory = $guestBookFactory;
        $this->guestBookRepository = $guestBookRepository;
        $this->configHelper = $configHelper;
        $this->helper = $helper;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $post = $this->getRequest()->getPostValue();
        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        try {
            $this->_validate($post);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $result->setUrl($this->_redirect->getRefererUrl());

            return $result;
        }

        if (!empty($post['message_id'])) {
            $post['reply_path'] = (isset($post['reply_path']))
                ? (string)$post['reply_path'] . '/' . $post['message_id']
                : (string)$post['message_id'];

            unset($post['message_id']);
        }

        if ($this->configHelper->isAutoApproving()) {
            $post['status'] = Status::STATUS_APPROVED;
            $message = __('Thanks for your feedback');
        } else {
            $post['status'] = Status::STATUS_PENDING;
            $message = __('This post will become public after administrator approval');
        }
        $post['updated_at'] = null;
        $model = $this->guestBookFactory->create()
            ->setData($post);

        try {
            $this->guestBookRepository->save($model);
            $this->helper->notifyAboutPendingComment($model);
            $this->messageManager->addSuccessMessage($message);
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something wrong'));
        }

        return $result->setPath('guest_book');
    }

    protected function _validate($params)
    {
        if (!$params || empty($params)) {
            throw new \Exception(__('Incorrect params'));
        }
        foreach ($params as $key => $value) {
            if (empty($value)) {
                throw new \Exception(__('All fields is required'));
            }
        }
    }
}