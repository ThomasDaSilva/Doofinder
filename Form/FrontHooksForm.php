<?php

namespace Doofinder\Form;

use Doofinder\Doofinder;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class FrontHooksForm extends BaseForm
{
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add(
                'search_script',
                TextareaType::class, [
                    'required' => false,
                    'label' => Translator::getInstance()->trans('Search script', [], Doofinder::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'search_script',
                        'help' => Translator::getInstance()->trans('Paste here the full Doofinder script provided in your Doofinder admin. It will be rendered as-is in the configured hook.', [], Doofinder::DOMAIN_NAME),
                        'rows' => 12,
                    ],
                    'data' => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_SCRIPT_CONFIG_KEY)
                ]
            )
            ->add(
                'hook_search_script',
                TextType::class, [
                    'required' => false,
                    'label' => Translator::getInstance()->trans('Hook Search Script', [], Doofinder::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'search_zone',
                        'help' => Translator::getInstance()->trans("hook of doofinder search script", [], Doofinder::DOMAIN_NAME),
                    ],
                    'data' => Doofinder::getConfigValue(Doofinder::DOOFINDER_HOOK_SEARCH_SCRIPT_CONFIG_KEY)
                ]
            )
        ;
    }
}