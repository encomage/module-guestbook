<?php

namespace Encomage\GuestBook\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use Encomage\GuestBook\Model\ResourceModel\GuestBook\CollectionFactory;
use Encomage\GuestBook\Api\GuestBookRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class MassDelete
 *
 * @package Encomage\GuestBook\Controller\Adminhtml\Index
 */
class MassDelete extends Action
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var GuestBookRepositoryInterface
     */
    private $guestBookRepository;

    /**
     * MassDelete constructor.
     *
     * @param Action\Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param GuestBookRepositoryInterface $guestBookRepository
     */
    public function __construct(
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        GuestBookRepositoryInterface $guestBookRepository
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->guestBookRepository = $guestBookRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        try {
            $this->guestBookRepository->massDeleteByMessageIds($collection->getAllIds());
            $this->messageManager->addSuccessMessage(__('A total of %1 element(s) have been deleted.', (int)$collectionSize));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete item(s).'));
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/index');
    }
}