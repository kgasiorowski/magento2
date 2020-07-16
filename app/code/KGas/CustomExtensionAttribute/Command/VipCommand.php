<?php

namespace KGas\CustomExtensionAttribute\Command;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
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

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory,
        $name = null
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilderFactory = $searchCriteriaBuilderFactory;
        parent::__construct($name);
    }

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
        $customer = $this->loadSomeCustomer();
        $this->setVipDates($customer);
        $this->saveCustomer($customer);

        $newCustomer = $this->customerRepository->getById($customer->getId());

        $output->writeln($customer->getExtensionAttributes()->getVipDateStart() . ' = ' . $newCustomer->getExtensionAttributes()->getVipDateStart());
        $output->writeln($customer->getExtensionAttributes()->getVipDateEnd() . ' = ' . $newCustomer->getExtensionAttributes()->getVipDateEnd());
    }

    /**
     * @param CustomerInterface $customer
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    private function saveCustomer(CustomerInterface $customer)
    {
        $this->customerRepository->save($customer);
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
     * @return CustomerInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function loadSomeCustomer()
    {
        $searchCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $searchCriteria = $searchCriteriaBuilder->create();
        $searchResult = $this->customerRepository->getList($searchCriteria);
        $customers = $searchResult->getItems();
        return $customers[0];
    }
}
