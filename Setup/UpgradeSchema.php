<?php

namespace Encomage\GuestBook\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class UpgradeSchema
 *
 * @package Encomage\GuestBook\Setup
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $tableName = $setup->getTable('guest_book');
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $setup->getConnection()->addColumn(
                $tableName, 'customer_review',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'size'     => null,
                    'nullable' => true,
                    'comment'  => 'Customer Reviews',
                ]
            );
        }
        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $setup->getConnection()->addColumn(
                $tableName, 'admin_answer',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'size'     => 500,
                    'nullable' => true,
                    'comment'  => 'Admin Answer',
                ]
            );
            $setup->getConnection()->changeColumn(
                $tableName,
                'reply_to',
                'reply_path',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'size'     => 255,
                    'nullable' => true,
                    'comment'  => 'Reply Path',
                ]
            );
        }
        if (version_compare($context->getVersion(), '0.0.4', '<')) {
            $setup->getConnection()->changeColumn(
                $tableName,
                'updated_at',
                'updated_at',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'size'     => null,
                    'nullable' => true,
                    'default'  => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_UPDATE,
                    'comment'  => 'Updated At'
                ]

            );
            $setup->getConnection()->changeColumn(
                $tableName,
                'created_at',
                'created_at',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'size'     => null,
                    'nullable' => false,
                    'default'  => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
                    'comment'  => 'Created At'
                ]

            );
        }
    }
}