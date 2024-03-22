<?php

namespace Doofinder\EventListeners;

use Doofinder\Service\ApiDoofinderManagementService;
use Doofinder\Service\DoofinderFormatService;
use Doofinder\Shared\Exceptions\ApiException;
use Propel\Runtime\Event\ActiveRecordEvent;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Thelia\Log\Tlog;
use Thelia\Model\Event\AttributeAvEvent;
use Thelia\Model\Event\AttributeAvI18nEvent;
use Thelia\Model\Event\AttributeEvent;
use Thelia\Model\Event\AttributeI18nEvent;
use Thelia\Model\Event\BrandEvent;
use Thelia\Model\Event\BrandI18nEvent;
use Thelia\Model\Event\CategoryEvent;
use Thelia\Model\Event\CategoryI18nEvent;
use Thelia\Model\Event\FeatureAvEvent;
use Thelia\Model\Event\FeatureAvI18nEvent;
use Thelia\Model\Event\FeatureEvent;
use Thelia\Model\Event\FeatureI18nEvent;
use Thelia\Model\Event\FeatureProductEvent;
use Thelia\Model\Event\ProductCategoryEvent;
use Thelia\Model\Event\ProductEvent;
use Thelia\Model\Event\ProductI18nEvent;
use Thelia\Model\Event\ProductImageEvent;
use Thelia\Model\Event\ProductPriceEvent;
use Thelia\Model\Event\ProductSaleElementsEvent;
use Thelia\Model\ProductQuery;
use Thelia\Model\ProductSaleElementsQuery;

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
    public function createUpdateProduct(ActiveRecordEvent $event): void
    {
        $results = [];
        $model = $event->getModel();

        if (null !== $product = ProductQuery::create()->findOneById($model->getId())) {
            return;
        }

        try {
            if ($product->getVisible() === 1) {
                $results = $this->apiDoofinderManagementService->createDoofinderProductInBulk($product->getProductSaleElementss());
            }

            if ($product->getVisible() === 0) {
                $results = $this->apiDoofinderManagementService->deleteDoofinderProductInBulk($product->getProductSaleElementss());
            }

            $this->formatService->formatResponse($results);
        } catch (ApiException $e) {
            Tlog::getInstance()->error($e->getMessage());
        }
    }

    /**
     * @throws PropelException
     */
    public function createUpdateProductPrice(ProductPriceEvent $event): void
    {
        $results = [];
        $productPrice = $event->getModel();

        if (null === $pse = ProductSaleElementsQuery::create()->findOneById($productPrice->getProductSaleElementsId())) {
            return;
        }

        try {
            if ($pse->getProduct()->getVisible() === 1) {
                $results = $this->apiDoofinderManagementService->createDoofinderProductInBulk([$pse]);
            }

            if ($pse->getProduct()->getVisible() === 0) {
                $results = $this->apiDoofinderManagementService->deleteDoofinderProductInBulk([$pse]);
            }

            $this->formatService->formatResponse($results);
        } catch (ApiException $e) {
            Tlog::getInstance()->error($e->getMessage());
        }
    }

    /**
     * @throws PropelException
     */
    public function deleteProduct(ActiveRecordEvent $event): void
    {
        $model = $event->getModel();

        if (null === $product = ProductQuery::create()->findOneById($model->getId())) {
            return;
        }

        try {
            $results = $this->apiDoofinderManagementService->deleteDoofinderProductInBulk($product->getProductSaleElementss());

            $this->formatService->formatResponse($results);
        } catch (ApiException $e) {
            Tlog::getInstance()->error($e->getMessage());
        }
    }

    /**
     * @throws PropelException
     */
    public function deleteProductPrice(ProductPriceEvent $event): void
    {
        $productPrice = $event->getModel();

        if (null === $pse = ProductSaleElementsQuery::create()->findOneById($productPrice->getProductSaleElementsId())) {
            return;
        }

        try {
            $results = $this->apiDoofinderManagementService->deleteDoofinderProductInBulk([$pse]);

            $this->formatService->formatResponse($results);
        } catch (ApiException $e) {
            Tlog::getInstance()->error($e->getMessage());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            ProductEvent::POST_SAVE => ["createUpdateProduct", 200],
            ProductI18nEvent::POST_SAVE => ['createUpdateProduct', 200],
            ProductImageEvent::POST_SAVE => ['createUpdateProduct', 200],
            FeatureEvent::POST_SAVE => ['createUpdateProduct', 200],
            FeatureI18nEvent::POST_SAVE => ['createUpdateProduct', 200],
            FeatureAvEvent::POST_SAVE => ['createUpdateProduct', 200],
            FeatureAvI18nEvent::POST_SAVE => ['createUpdateProduct', 200],
            FeatureProductEvent::POST_SAVE => ['createUpdateProduct', 200],
            AttributeEvent::POST_SAVE => ['createUpdateProduct', 200],
            AttributeI18nEvent::POST_SAVE => ['createUpdateProduct', 200],
            AttributeAvEvent::POST_SAVE => ['createUpdateProduct', 200],
            AttributeAvI18nEvent::POST_SAVE => ['createUpdateProduct', 200],
            ProductSaleElementsEvent::POST_SAVE  => ['createUpdateProduct', 200],
            BrandEvent::POST_SAVE => ['createUpdateProduct', 200],
            BrandI18nEvent::POST_SAVE => ['createUpdateProduct', 200],
            CategoryEvent::POST_SAVE => ['createUpdateProduct', 200],
            CategoryI18nEvent::POST_SAVE => ['createUpdateProduct', 200],

            ProductPriceEvent::POST_SAVE  => ['createUpdateProductPrice', 200],
            ProductCategoryEvent::POST_SAVE  => ['createUpdateProductPrice', 200],

            ProductEvent::POST_DELETE => ["deleteProduct", 200],
            ProductI18nEvent::POST_DELETE => ['deleteProduct', 200],
            ProductImageEvent::POST_DELETE => ['deleteProduct', 200],
            FeatureEvent::POST_DELETE => ['deleteProduct', 200],
            FeatureI18nEvent::POST_DELETE => ['deleteProduct', 200],
            FeatureAvEvent::POST_DELETE => ['deleteProduct', 200],
            FeatureAvI18nEvent::POST_DELETE => ['deleteProduct', 200],
            FeatureProductEvent::POST_DELETE => ['deleteProduct', 200],
            AttributeEvent::POST_DELETE => ['deleteProduct', 200],
            AttributeI18nEvent::POST_DELETE => ['deleteProduct', 200],
            AttributeAvEvent::POST_DELETE => ['deleteProduct', 200],
            AttributeAvI18nEvent::POST_DELETE => ['deleteProduct', 200],
            ProductSaleElementsEvent::POST_DELETE  => ['deleteProduct', 200],
            BrandEvent::POST_DELETE => ['deleteProduct', 200],
            BrandI18nEvent::POST_DELETE => ['deleteProduct', 200],
            CategoryEvent::POST_DELETE => ['deleteProduct', 200],
            CategoryI18nEvent::POST_DELETE => ['deleteProduct', 200],

            ProductPriceEvent::POST_DELETE  => ['deleteProductPrice', 200],
            ProductCategoryEvent::POST_DELETE  => ['deleteProductPrice', 200]
        );
    }
}