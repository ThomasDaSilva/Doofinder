<?php

namespace Doofinder;

use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Symfony\Component\Finder\Finder;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;

class Doofinder extends BaseModule
{
    public const DOMAIN_NAME = 'doofinder';

    // Doofinder Configuration
    public const DOOFINDER_SEARCH_ZONE_CONFIG_KEY = 'doofinder_search_zone';
    public const DOOFINDER_HASH_ID_CONFIG_KEY = 'doofinder_hash_id';
    public const DOOFINDER_USER_TOKEN_CONFIG_KEY = 'doofinder_user_token';
    public const DOOFINDER_USER_ID_CONFIG_KEY = 'doofinder_user_id';

    // Doofinder Search Engine Setting
    public const DOOFINDER_SEARCH_ENGINE_CONFIG_KEY = 'doofinder_search_engine';
    public const DOOFINDER_SEARCH_ENGINE_LANG_CONFIG_KEY = 'doofinder_search_engine_lang';
    public const DOOFINDER_SEARCH_ENGINE_STATUS_CONFIG_KEY = 'doofinder_search_engine_status';
    public const DOOFINDER_SEARCH_ENGINE_CURRENCY_CONFIG_KEY = 'doofinder_search_engine_currency';
    public const DOOFINDER_SEARCH_ENGINE_FEED_CONFIG_KEY = 'doofinder_search_engine_feed';


    // Doofinder Front Hooks
    public const DOOFINDER_HOOK_SEARCH_SCRIPT_CONFIG_KEY = 'doofinder_hook_search_script';
    public const DOOFINDER_BASIC_SEARCH_BAR_CONFIG_KEY = 'doofinder_basic_search_bar';
    public const DOOFINDER_QUERY_INPUT_ID_CONFIG_KEY = 'doofinder_query_input_id';


    /*
     * You may now override BaseModuleInterface methods, such as:
     * install, destroy, preActivation, postActivation, preDeactivation, postDeactivation
     *
     * Have fun !
     */

    /**
     * Defines how services are loaded in your modules
     *
     * @param ServicesConfigurator $servicesConfigurator
     */
    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([THELIA_MODULE_DIR . ucfirst(self::getModuleCode()). "/I18n/*"])
            ->autowire(true)
            ->autoconfigure(true);
    }

    /**
     * Execute sql files in Config/update/ folder named with module version (ex: 1.0.1.sql).
     *
     * @param $currentVersion
     * @param $newVersion
     * @param ConnectionInterface $con
     */
    public function update($currentVersion, $newVersion, ConnectionInterface $con = null): void
    {
        $updateDir = __DIR__.DS.'Config'.DS.'update';

        if (! is_dir($updateDir)) {
            return;
        }

        $finder = Finder::create()
            ->name('*.sql')
            ->depth(0)
            ->sortByName()
            ->in($updateDir);

        $database = new Database($con);

        /** @var \SplFileInfo $file */
        foreach ($finder as $file) {
            if (version_compare($currentVersion, $file->getBasename('.sql'), '<')) {
                $database->insertSql(null, [$file->getPathname()]);
            }
        }
    }
}
