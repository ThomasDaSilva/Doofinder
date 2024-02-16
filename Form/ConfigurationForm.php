<?php

namespace Doofinder\Form;

use Doofinder\Doofinder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

class ConfigurationForm extends BaseForm
{
    protected function buildForm(): void
    {
        $this->formBuilder
            ->add(
                'search_zone',
                TextType::class, [
                    'required' => true,
                    'label' => Translator::getInstance()->trans('Search Zone', [], Doofinder::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'search_zone',
                        'help' => Translator::getInstance()->trans("server zone of your search engine", [], Doofinder::DOMAIN_NAME),
                    ],
                    'data' => Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ZONE)
                ]
            )
            ->add(
                'hash_id',
                TextType::class, [
                    'required' => true,
                    'label' => Translator::getInstance()->trans('Hash ID', [], Doofinder::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'hash_id',
                        'help' => Translator::getInstance()->trans("hash ID of your search engine", [], Doofinder::DOMAIN_NAME),
                    ],
                    'data' => Doofinder::getConfigValue(Doofinder::DOOFINDER_HASH_ID)
                ]
            )
            ->add(
                'user_id',
                TextType::class, [
                    'required' => true,
                    'label' => Translator::getInstance()->trans('User ID', [], Doofinder::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'user_token',
                        'help' => Translator::getInstance()->trans("Your user Id", [], Doofinder::DOMAIN_NAME),
                    ],
                    'data' => Doofinder::getConfigValue(Doofinder::DOOFINDER_USER_ID)
                ]
            )
            ->add(
                'user_token',
                TextType::class, [
                    'required' => true,
                    'label' => Translator::getInstance()->trans('Token User', [], Doofinder::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => 'user_token',
                        'help' => Translator::getInstance()->trans("You can generate it in your user account -> Api Keys", [], Doofinder::DOMAIN_NAME),
                    ],
                    'data' => Doofinder::getConfigValue(Doofinder::DOOFINDER_USER_TOKEN)
                ]
            )
        ;
    }
}