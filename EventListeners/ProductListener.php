<?php

namespace Doofinder\EventListeners;

use Doofinder\Service\ApiDoofinderManagementService;
use Doofinder\Service\DoofinderFormatService;
use Doofinder\Shared\Exceptions\ApiException;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Core\Event\Product\ProductUpdateEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Log\Tlog;
use Thelia\Model\ProductQuery;

class ProductListener implements EventSubscriberInterface
{
    public function __construct(
        protected RequestStack                  $requestStack,
        protected DoofinderFormatService        $formatService,
        protected ApiDoofinderManagementService $apiDoofinderManagementService,
    ) {
    }

    /**
     * @throws PropelException
     */
    public function createUpdateProduct(ProductUpdateEvent $event): void
    {
        if (null === $product = ProductQuery::create()->findOneById($event->getProductId())) {
            return;
        }

        try {
            $results = $this->apiDoofinderManagementService->createDoofinderProductInBulk($product->getProductSaleElementss());

            $this->formatService->formatResponse($results);
        } catch (ApiException $e) {
            Tlog::getInstance()->error($e->getMessage());
        }
    }

    public function deleteProduct(ProductUpdateEvent $event): void
    {
        if (null === $product = ProductQuery::create()->findOneById($event->getProductId())) {
            return;
        }

        try {
            $results = $this->apiDoofinderManagementService->createDoofinderProductInBulk($product->getProductSaleElementss());

            $this->formatService->formatResponse($results);
        } catch (ApiException $e) {
            Tlog::getInstance()->error($e->getMessage());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            TheliaEvents::PRODUCT_CREATE => ["createUpdateProduct", 200],
            TheliaEvents::PRODUCT_UPDATE => ["createUpdateProduct", 200],
            TheliaEvents::PRODUCT_DELETE => ["deleteProduct", 200]
        );
    }
}