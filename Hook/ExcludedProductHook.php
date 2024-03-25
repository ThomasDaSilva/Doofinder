<?php

namespace Doofinder\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class ExcludedProductHook extends BaseHook
{
    public function productModificationFormRightTop(HookRenderEvent $event): void
    {
        $event->add($this->render("hooks/excluded_product_form.html"));
    }

    public static function getSubscribedHooks(): array
    {
        return [
            "product.modification.form-right.top" => [
                [
                    "type" => "back",
                    "method" => "productModificationFormRightTop"
                ],
            ]
        ];
    }

}