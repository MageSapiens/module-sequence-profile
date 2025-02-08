<?php

namespace Sapiens\SequenceProfile\Model\ResourceModel\Profile;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\SalesSequence\Model\Profile;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Profile::class, \Magento\SalesSequence\Model\ResourceModel\Profile::class);
        parent::_construct();
    }
}
