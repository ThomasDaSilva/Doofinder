<?php

namespace Doofinder\Hook;

use Doofinder\Doofinder;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class FrontHook extends BaseHook
{
    public function addDoofinderSearchScript(HookRenderEvent $event): void
    {
        $event->add(
            $this->render("hooks/hook-search-script.html",
                [
                    'search_script' => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_SCRIPT_CONFIG_KEY),
                ]
            )
        );
    }

    public static function getSubscribedHooks(): array
    {
        return [
            Doofinder::getConfigValue(Doofinder::DOOFINDER_HOOK_SEARCH_SCRIPT_CONFIG_KEY, 'main.content-top') => [
                [
                    "type" => "front",
                    "method" => "addDoofinderSearchScript"
                ],
            ]
        ];
    }
}