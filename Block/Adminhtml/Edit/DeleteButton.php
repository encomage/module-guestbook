<?php

namespace Encomage\GuestBook\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class DeleteButton
 *
 * @package Encomage\GuestBook\Block\Adminhtml\Edit
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getId()) {
            $data = [
                'label'      => __('Delete'),
                'class'      => 'delete',
                'on_click'   => 'deleteConfirm(\'' . __('Are you sure you want to delete this post ?') . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['message_id' => $this->getId()]);
    }
}