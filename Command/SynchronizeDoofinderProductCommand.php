<?php

namespace Doofinder\Command;

use Doofinder\Service\ApiDoofinderManagementService;
use Doofinder\Service\DoofinderFormatService;
use Doofinder\Shared\Exceptions\ApiException;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use Thelia\Log\Tlog;

class SynchronizeDoofinderProductCommand extends ContainerAwareCommand
{
    public function __construct(
        protected ApiDoofinderManagementService $apiDoofinderManagementService,
        protected DoofinderFormatService $formatService
    ) {
        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setName('module:doofinder:synchronize')
            ->setDescription('Synchronize product with Doofinder API');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->initRequest();

        $output->write("Product synchronization start\n");

        try {
            $results = $this->apiDoofinderManagementService->synchronizeDoofinderProducts();

            $output->write($this->formatService->formatResponse($results));
        } catch (ApiException|PropelException $e) {
            Tlog::getInstance()->error($e->getMessage());
            $output->write("Product synchronization Failed\n");
        }

        $output->write("End of Product synchronization\n");

        return 0;
    }
}