<?php

namespace Encomage\GuestBook\Model\GuestBook\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 * @package Encomage\GuestBook\Model\GuestBook\Source
 */
class Status implements OptionSourceInterface
{
    const
          STATUS_PENDING  = 1,
          STATUS_APPROVED = 2,
          STATUS_REJECTED = 3;
    const LABEL_STATUS_PENDING  = 'Pending',
          LABEL_STATUS_APPROVED = 'Approved',
          LABEL_STATUS_REJECTED = 'Rejected';

    /**
     * @var array
     */
    protected $options;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options) {
            return $this->options;
        }
        $this->options[] = [
            'label' => __(self::LABEL_STATUS_PENDING),
            'value' => self::STATUS_PENDING,
        ];
        $this->options[] = [
            'label' => __(self::LABEL_STATUS_APPROVED),
            'value' => self::STATUS_APPROVED,
        ];
        $this->options[] = [
            'label' => __(self::LABEL_STATUS_REJECTED),
            'value' => self::STATUS_REJECTED,
            ];
        return $this->options;
    }
}