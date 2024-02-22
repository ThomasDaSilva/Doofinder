<?php

namespace Doofinder\Service;

use Doofinder\Doofinder;
use Doofinder\Event\DoofinderItemParamEvent;
use Doofinder\Event\DoofinderItemParamEvents;
use Doofinder\Management\ManagementClient;
use Doofinder\Shared\Exceptions\ApiException;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ApiDoofinderManagementService
{
    private ManagementClient $managementClient;

    public function __construct(
        protected EventDispatcherInterface $eventDispatcher,
        protected DoofinderFormatService $formatService
    ) {
        $host = sprintf(
            Doofinder::DOOFINDER_URL,
            Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ZONE_CONFIG_KEY) ?? "eu1",
        );

        $this->managementClient = ManagementClient::create(
            $host,
            Doofinder::getConfigValue(Doofinder::DOOFINDER_USER_TOKEN_CONFIG_KEY),
            Doofinder::getConfigValue(Doofinder::DOOFINDER_USER_ID_CONFIG_KEY)
        );
    }

    /**
     * @throws ApiException
     */
    public function getSearchEngine(): ?array
    {
        $response = $this->managementClient->getSearchEngine(Doofinder::getConfigValue(Doofinder::DOOFINDER_HASH_ID_CONFIG_KEY));

        return $response->getBody()->jsonSerialize();
    }

    /**
     * @throws PropelException|ApiException
     */
    public function createDoofinderProductInBulk($productSaleElements)
    {
        $itemParams = [];

        foreach ($productSaleElements as $pse) {
            $itemParams[] = $this->formatService->formatIndexImport($pse);
        }

        $event = new DoofinderItemParamEvent($itemParams);
        $this->eventDispatcher->dispatch($event, DoofinderItemParamEvents::DOOFINDER_ITEM_PARAM);

        $response = $this->managementClient->createItemsInBulk(
            Doofinder::getConfigValue(Doofinder::DOOFINDER_HASH_ID_CONFIG_KEY),
            "product",
            $itemParams
        );

        return $response->getBody();
    }

    /**
     * @throws PropelException|ApiException
     */
    public function deleteDoofinderProductInBulk($productSaleElements)
    {
        $itemParams = [];

        foreach ($productSaleElements as $pse) {
            $itemParams[] = $this->formatService->formatIndexImport($pse);
        }

        $response = $this->managementClient->deleteItemsInBulk(
            Doofinder::getConfigValue(Doofinder::DOOFINDER_HASH_ID_CONFIG_KEY),
            "product",
            $itemParams
        );

        return $response->getBody();
    }
}