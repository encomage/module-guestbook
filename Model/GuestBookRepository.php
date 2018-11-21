<?php

namespace Encomage\GuestBook\Model;

use Encomage\GuestBook\Api\GuestBookRepositoryInterface;
use Encomage\GuestBook\Api\Data;
use Encomage\GuestBook\Api\Data\GuestBookInterface;
use Encomage\GuestBook\Api\Data\GuestBookSearchResultsInterfaceFactory;
use Encomage\GuestBook\Model\ResourceModel\GuestBook as ResourceGuestBook;
use Encomage\GuestBook\Model\ResourceModel\GuestBook\CollectionFactory as GuestBookCollectionFactory;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class GuestBookRepository
 *
 * @package Encomage\GuestBook\Model
 */
class GuestBookRepository implements GuestBookRepositoryInterface
{
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ResourceGuestBook
     */
    private $guestBookResource;

    /**
     * @var GuestBookCollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var GuestBookSearchResultsInterfaceFactory
     */
    private $bookSearchResultsInterfaceFactory;

    /**
     * @var \Encomage\GuestBook\Model\GuestBookFactory
     */
    private $guestBookFactory;

    /**
     * GuestBookRepository constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param ResourceGuestBook $guestBookResource
     * @param GuestBookCollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param GuestBookSearchResultsInterfaceFactory $bookSearchResultsInterfaceFactory
     * @param \Encomage\GuestBook\Model\GuestBookFactory $guestBookFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ResourceGuestBook $guestBookResource,
        GuestBookCollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        GuestBookSearchResultsInterfaceFactory $bookSearchResultsInterfaceFactory,
        GuestBookFactory $guestBookFactory
    ) {
        $this->storeManager = $storeManager;
        $this->guestBookResource = $guestBookResource;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->bookSearchResultsInterfaceFactory = $bookSearchResultsInterfaceFactory;
        $this->guestBookFactory = $guestBookFactory;
    }

    /**
     * @param GuestBookInterface $request
     * @return GuestBookInterface|mixed
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(GuestBookInterface $request)
    {
        if (empty($request->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $request->setStoreId($storeId);
        }
        try {
            $this->guestBookResource->save($request);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $request;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Encomage\GuestBook\Api\Data\GuestBookSearchResultsInterface|mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var \Encomage\GuestBook\Model\ResourceModel\GuestBook\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);
        /** @var \Encomage\GuestBook\Api\Data\GuestBookSearchResultsInterface $searchResults */
        $searchResults = $this->bookSearchResultsInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setCollection($collection);
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @param array $messageIds
     * @return mixed|void
     * @throws CouldNotDeleteException
     */
    public function massDeleteByMessageIds(array $messageIds)
    {
        foreach ($messageIds as $messageId) {
            try {
                $this->deleteByMessageId($messageId);
            } catch (NoSuchEntityException $e) {
                continue;
            }
        }
    }

    /**
     * @param $messageId
     * @return bool|mixed
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteByMessageId($messageId)
    {
        return $this->delete($this->getByMessageId($messageId));
    }

    /**
     * @param GuestBookInterface $request
     * @return bool|mixed
     * @throws CouldNotDeleteException
     */
    public function delete(Data\GuestBookInterface $request)
    {
        /** @var \Encomage\GuestBook\Model\ResourceModel\GuestBook\Collection $collection */
        $collection = $this->collectionFactory->create();
        $items = $collection->addFieldToFilter("reply_path", ["like" => '%' . $request->getMessageId() . '%'])->getItems();
        $items[] = $request;
        try {
            foreach ($items as $item) {
                $this->guestBookResource->delete($item);
            }
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * @param $messageId
     * @return GuestBook|mixed
     * @throws NoSuchEntityException
     */
    public function getByMessageId($messageId)
    {
        $item = $this->guestBookFactory->create();
        $this->guestBookResource->load($item, $messageId);
        if (!$item->getId()) {
            throw new NoSuchEntityException(__('Item id "%1" does not exist.', $messageId));
        }

        return $item;
    }
}