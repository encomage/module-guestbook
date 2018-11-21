<?php

namespace Encomage\GuestBook\Model\ResourceModel\GuestBook;

use Encomage\GuestBook\Model\GuestBook;
use Encomage\GuestBook\Model\ResourceModel\GuestBook as GuestBookResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Collection
 *
 * @package Encomage\GuestBook\Model\ResourceModel\GuestBook
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'message_id';

    /**
     * Collection constructor.
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Class construct.
     */
    protected function _construct()
    {
        $this->_init(GuestBook::class, GuestBookResource::class);
    }
}