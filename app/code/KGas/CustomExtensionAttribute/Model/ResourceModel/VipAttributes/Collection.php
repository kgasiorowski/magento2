<?php

namespace KGas\CustomExtensionAttribute\Model\ResourceModel\VipAttributes;

use KGas\CustomExtensionAttribute\Model\ResourceModel\VipAttributes as ResourceModel;
use KGas\CustomExtensionAttribute\Model\VipAttributes as Model;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    /**
     *
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
