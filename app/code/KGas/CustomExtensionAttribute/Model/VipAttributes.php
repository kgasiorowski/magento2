<?php

namespace KGas\CustomExtensionAttribute\Model;

use KGas\CustomExtensionAttribute\Model\ResourceModel\VipAttributes as ResourceModel;
use Magento\Framework\Model\AbstractModel;

class VipAttributes extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * @param $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->setData('customer_id', $customerId);
    }

    /**
     * @return mixed
     */
    public function getVipDateStart()
    {
        return $this->getData('vip_date_start');
    }

    /**
     * @param $vipDateStart
     * @return mixed
     */
    public function setVipDateStart($vipDateStart)
    {
        return $this->setData('vip_date_start', $vipDateStart);
    }

    /**
     * @return mixed
     */
    public function getVipDateEnd()
    {
        return $this->getData('vip_date_end');
    }

    /**
     * @param $vipDateEnd
     * @return mixed
     */
    public function setVipDateEnd($vipDateEnd)
    {
        return $this->setData('vip_date_end', $vipDateEnd);
    }
}
