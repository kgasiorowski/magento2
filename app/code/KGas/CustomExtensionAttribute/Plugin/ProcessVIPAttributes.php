<?php

namespace KGas\CustomExtensionAttribute\Plugin;

use KGas\CustomExtensionAttribute\Model\ResourceModel\VipAttributesCollection\CollectionFactory;
use KGas\CustomExtensionAttribute\Model\ResourceModel\VipAttributesResourceModel as ResourceModel;
use KGas\CustomExtensionAttribute\Model\VipAttributesModel as Model;
use KGas\CustomExtensionAttribute\Model\VipAttributesModelFactory as ModelFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;

class ProcessVIPAttributes
{

    /**
     * @var ResourceModel
     */
    private $resourceModel;

    /**
     * @var ModelFactory
     */
    private $modelFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * ProcessVIPAttributes constructor.
     * @param ResourceModel $resourceModel
     * @param ModelFactory $modelFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        ResourceModel $resourceModel,
        ModelFactory $modelFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->resourceModel = $resourceModel;
        $this->modelFactory = $modelFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInterface $customer
     */
    public function afterGet(
        CustomerRepositoryInterface $customerRepository,
        CustomerInterface $customer
    ) {
        $vipAttributesModel = $this->getVipAttributesByCustomer($customer);
        if ($vipAttributesModel === null) {
            return $customer;
        }

        $extensionAttributes = $customer->getExtensionAttributes();
        if (is_callable([$extensionAttributes, 'setVipDateStart'])) {
            $customer->getExtensionAttributes()->setVipDateStart($vipAttributesModel->getVipDateStart());
        }

        $extensionAttributes = $customer->getExtensionAttributes();
        if (is_callable([$extensionAttributes, 'setVipDateEnd'])) {
            $customer->getExtensionAttributes()->setVipDateEnd($vipAttributesModel->getVipDateEnd());
        }

        return $customer;
    }

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function afterGetById(
        CustomerRepositoryInterface $customerRepository,
        CustomerInterface $customer
    ) {
        $vipAttributesModel = $this->getVipAttributesByCustomer($customer);
        if ($vipAttributesModel === null) {
            return $customer;
        }

        $extensionAttributes = $customer->getExtensionAttributes();
        if (is_callable([$extensionAttributes, 'setVipDateStart'])) {
            $customer->getExtensionAttributes()->setVipDateStart($vipAttributesModel->getVipDateStart());
        }

        $extensionAttributes = $customer->getExtensionAttributes();
        if (is_callable([$extensionAttributes, 'setVipDateEnd'])) {
            $customer->getExtensionAttributes()->setVipDateEnd($vipAttributesModel->getVipDateEnd());
        }

        return $customer;
    }

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerInterface $customer
     * @param bool $saveOptions
     * @return array
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function beforeSave(
        CustomerRepositoryInterface $customerRepository,
        CustomerInterface $customer,
        $saveOptions = false
    ) {
        $vipAttributesModel = $this->getVipAttributesByCustomer($customer);
        if (!$vipAttributesModel) {
            $vipAttributesModel = $this->modelFactory->create();
        }

        $extensionAttributes = $customer->getExtensionAttributes();
        if ($extensionAttributes === null) {
            return [$customer, $saveOptions];
        }

        $vipAttributesModel->setCustomerId((int)$customer->getId());
        $vipAttributesModel->setVipDateStart((string)$customer->getExtensionAttributes()->getVipDateStart());
        $vipAttributesModel->setVipDateEnd((string)$customer->getExtensionAttributes()->getVipDateEnd());

        $this->resourceModel->save($vipAttributesModel);

        return [$customer, $saveOptions];
    }

    /**
     * @param CustomerInterface $customer
     * @return Model
     */
    private function getVipAttributesByCustomer(
        CustomerInterface $customer
    ) {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('customer_id', $customer->getId());

        /** @var Model $firstItem */
        $firstItem = $collection->getFirstItem();

        return $firstItem;
    }
}
