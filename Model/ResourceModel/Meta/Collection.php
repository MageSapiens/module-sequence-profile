<?php

namespace Sapiens\SequenceProfile\Model\ResourceModel\Meta;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\SalesSequence\Model\Meta;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Meta::class, \Magento\SalesSequence\Model\ResourceModel\Meta::class);
        parent::_construct();
    }
}
