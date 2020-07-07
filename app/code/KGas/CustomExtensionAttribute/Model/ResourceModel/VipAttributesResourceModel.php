<?php

namespace KGas\CustomExtensionAttribute\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class VipAttributesResourceModel extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('vip_extension_attributes', 'id');
    }
}
