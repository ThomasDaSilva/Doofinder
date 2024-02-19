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
                    'feeds' => json_decode(Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_FEED_CONFIG_KEY), true, 512, JSON_THROW_ON_ERROR),
                    "search_engine" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_CONFIG_KEY),
                    "search_engine_lang" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_LANG_CONFIG_KEY),
                    "search_engine_server" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ZONE_CONFIG_KEY),
                    "search_engine_hash_id" => Doofinder::getConfigValue(Doofinder::DOOFINDER_HASH_ID_CONFIG_KEY),
                    "search_engine_currency" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_CURRENCY_CONFIG_KEY),
                    "search_engine_status" => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_STATUS_CONFIG_KEY, false)
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