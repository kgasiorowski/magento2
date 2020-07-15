<?php

namespace KGas\CustomExtensionAttribute\Command;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\App\State;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VipCommand extends Command
{

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * @var State
     */
    private $state;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        State $state,
        $name = null
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        $this->state = $state;
        parent::__construct($name);
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setName("vip:test");
        $this->setDescription("Tests if new VIP attributes are working");
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {



//        // Load and save a product
//        $customer = $this->loadSomeCustomer();
//        $this->setVipDates($customer);
//        $this->saveCustomer($customer);
//
//        // Load the same product twice but now from the database
//        $newProduct = $this->customerRepository->get($customer->getSku());
//
//        // Compare the result
//        $output->writeln((string)$customer->getExtensionAttributes()->getVipDateStart() . ' = ' . (string)$newProduct->getExtensionAttributes()->getVipDateStart());
    }

    /**
     * @return CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function loadSomeCustomer()
    {
        $productSku = $this->getFirstProductSkuFromCatalog();
        return $this->customerRepository->get($productSku);
    }

    /**
     * @param CustomerInterface $product
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    private function saveCustomer(CustomerInterface $product)
    {
        $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);
        $this->customerRepository->save($product);
    }

    /**
     * @param CustomerInterface $customer
     */
    private function setVipDates(CustomerInterface &$customer)
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime('tomorrow'));
        $customer->getExtensionAttributes()->setVipDateStart($startDate);
        $customer->getExtensionAttributes()->setVipDateEnd($endDate);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function getFirstProductSkuFromCatalog()
    {
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $searchCriteriaBuilder->setPageSize(1);
        $searchCriteria = $searchCriteriaBuilder->create();
        $searchResult = $this->customerRepository->getList($searchCriteria);
        $customers = $searchResult->getItems();
        $customer = array_pop($customers);

        die(get_class($customers));

        return $customer;
    }

}
