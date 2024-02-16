<?php

namespace Doofinder\Hook;

use Doofinder\Doofinder;
use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class ConfigurationHook extends BaseHook
{
    public function onModuleConfiguration(HookRenderEvent $event): void
    {
        $event->add(
            $this->render(
                "module_configuration.html",
                [
                    'feeds' => json_decode(Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_FEED), true, 512, JSON_THROW_ON_ERROR),
                    "search_engine" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE),
                    "search_engine_lang" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_LANG),
                    "search_engine_server" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ZONE),
                    "search_engine_hash_id" => Doofinder::getConfigValue(Doofinder::DOOFINDER_HASH_ID),
                    "search_engine_currency" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_CURRENCY),
                    "search_engine_status" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_STATUS, false)
                ]
        ));
    }

    public static function getSubscribedHooks(): array
    {
        return [
            "module.configuration" => [
                [
                    "type" => "back",
                    "method" => "onModuleConfiguration"
                ],
            ]
        ];
    }
}