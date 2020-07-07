<?php

namespace KGas\CustomExtensionAttribute\Model;

use KGas\CustomExtensionAttribute\Model\ResourceModel\VipAttributesResourceModel;
use Magento\Framework\Model\AbstractModel;

class VipAttributesModel extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(VipAttributesResourceModel::class);
    }

    /**
     * @return int
     */
    public function getCustomerId() : int
    {
        return (int)$this->getData('customer_id');
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
        return $this->getData('VIP_date_start');
    }

    /**
     * @param $vipDateStart
     * @return mixed
     */
    public function setVipDateStart($vipDateStart)
    {
        return $this->getData('VIP_date_start', $vipDateStart);
    }

    /**
     * @return mixed
     */
    public function getVipDateEnd()
    {
        return $this->getData('VIP_date_end');
    }

    /**
     * @param $vipDateEnd
     * @return mixed
     */
    public function setVipDateEnd($vipDateEnd)
    {
        return $this->setData('VIP_date_end', $vipDateEnd);
    }
}
