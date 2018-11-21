<?php

namespace Encomage\GuestBook\Model\GuestBook\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Sort
 *
 * @package Encomage\GuestBook\Model\GuestBook\Source
 */
class Sort implements OptionSourceInterface
{
    const SORT_ORDER_ASC  = 'ASC',
          SORT_ORDER_DESC = 'DESC';

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
        $this->options[] =
            [
            'label' => __('Asc'),
            'value' => self::SORT_ORDER_ASC,
        ];
        $this->options[] = [
            'label' => __('Desc'),
            'value' => self::SORT_ORDER_DESC,
        ];

        return $this->options;
    }
}