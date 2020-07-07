<?php

namespace KGas\CustomExtensionAttribute\Model\ResourceModel\VipAttributesCollection;

use KGas\CustomExtensionAttribute\Model\ResourceModel\VipAttributesResourceModel;
use KGas\CustomExtensionAttribute\Model\VipAttributesModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    /**
     *
     */
    protected function _construct()
    {
        $this->_init(VipAttributesModel::class, VipAttributesResourceModel::class);
    }
}
