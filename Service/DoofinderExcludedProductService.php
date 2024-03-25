<?php

namespace Doofinder\Service;

use Doofinder\Model\DoofinderExcludedProduct;
use Doofinder\Model\DoofinderExcludedProductQuery;
use Propel\Runtime\Exception\PropelException;

class DoofinderExcludedProductService
{
    /**
     * @throws PropelException
     */
    public function excludeProduct(int $productId): int
    {
        if (null === DoofinderExcludedProductQuery::create()->findOneByProductId($productId)) {
            $excludedProduct = new DoofinderExcludedProduct();
            $excludedProduct->setProductId($productId);
            $excludedProduct->save();

            return $productId;
        }

        return 0;
    }

    /**
     * @throws PropelException
     */
    public function includeProduct($productId): int
    {
        if (null !== $excludedProduct = DoofinderExcludedProductQuery::create()->findOneByProductId($productId)) {
            $excludedProduct->delete();

            return $productId;
        }

        return 0;
    }
}