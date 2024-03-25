<?php

namespace Doofinder\Smarty\Plugins;

use Doofinder\Model\DoofinderExcludedProductQuery;
use TheliaSmarty\Template\AbstractSmartyPlugin;
use TheliaSmarty\Template\SmartyPluginDescriptor;

class DoofinderExcludeProductPlugin extends AbstractSmartyPlugin
{

    public function getPluginDescriptors(): array
    {
        return [
            new SmartyPluginDescriptor('function', 'getExcludeProduct', $this, 'getExcludeProduct')
        ];
    }

    public function getExcludeProduct($param, $smarty): void
    {
        if (isset($param['product_id'])) {
            $excludeProduct = DoofinderExcludedProductQuery::create()->findOneByProductId($param['product_id']);

            if (null !== $excludeProduct) {
                $smarty->assign('isExclude', true);
                return;
            }
        }

        $smarty->assign('isExclude', false);
    }
}