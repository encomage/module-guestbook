<?php

namespace Encomage\GuestBook\Controller\Adminhtml\Index;

use Encomage\GuestBook\Model\GuestBookFactory;
use Encomage\GuestBook\Api\GuestBookRepositoryInterface;
use Magento\Backend\App\Action;

/**
 * Class Delete
 *
 * @package Encomage\GuestBook\Controller\Adminhtml\Index
 */
class Delete extends Action
{
    /**
     * @var GuestBookFactory
     */
    private $guestBookFactory;

    /**
     * @var GuestBookRepositoryInterface
     */
    private $guestBookRepository;

    /**
     * Delete constructor.
     *
     * @param Action\Context $context
     * @param GuestBookFactory $guestBookFactory
     * @param GuestBookRepositoryInterface $guestBookRepository
     */
    public function __construct(
        Action\Context $context,
        GuestBookFactory $guestBookFactory,
        GuestBookRepositoryInterface $guestBookRepository
    ) {
        $this->guestBookFactory = $guestBookFactory;
        $this->guestBookRepository = $guestBookRepository;
        parent::__construct($context);
    }

    /**
     * @return $this|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('message_id', 0);
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->guestBookRepository->deleteByMessageId($id);
                $this->messageManager->addSuccessMessage(__('Removed successfully.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error while trying to delete item.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Error while trying to delete item.'));
        }

        return $resultRedirect->setPath('*/*/index');
    }
}