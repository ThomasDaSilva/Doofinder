<?php

namespace Doofinder\LoopExtend;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Loop\LoopExtendsArgDefinitionsEvent;
use Thelia\Core\Event\Loop\LoopExtendsBuildModelCriteriaEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Model\ProductQuery;

class ProductLoopExtend implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            TheliaEvents::getLoopExtendsEvent(TheliaEvents::LOOP_EXTENDS_BUILD_MODEL_CRITERIA, 'product') => ['extendProductBuildModel', 100],
            TheliaEvents::getLoopExtendsEvent(TheliaEvents::LOOP_EXTENDS_ARG_DEFINITIONS, 'product') => ['extendProductArgDefinitions', 100],
        ];
    }

    public function extendProductArgDefinitions(LoopExtendsArgDefinitionsEvent $event): void
    {
        $argument = $event->getArgumentCollection();

        $argument->addArgument(Argument::createBooleanTypeArgument('is_excluded'));
    }

    public function extendProductBuildModel(LoopExtendsBuildModelCriteriaEvent $event): void
    {
        if (null !== $event->getLoop()?->getIsExcluded()) {
            /** @var ProductQuery $model */
            $model = $event->getModelCriteria();

            $model->useDoofinderExcludedProductExistsQuery();
        }
    }
}