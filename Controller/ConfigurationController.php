<?php

namespace Doofinder\Controller;

use Doofinder\Doofinder;
use Doofinder\Form\ConfigurationForm;
use Doofinder\Form\FrontHooksForm;
use Doofinder\Service\ApiDoofinderManagementService;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Thelia\Controller\Admin\AdminController;
use Thelia\Core\Template\ParserContext;
use Thelia\Form\Exception\FormValidationException;

#[Route('/admin/module/Doofinder', name: 'admin_doofinder_config_')]
class ConfigurationController extends AdminController
{
    #[Route('/configuration', name: 'configuration', methods: 'POST')]
    public function saveConfiguration(
        ParserContext $parserContext,
        ApiDoofinderManagementService $apiDoofinderManagementService
    ): RedirectResponse|Response
    {
        $form = $this->createForm(ConfigurationForm::getName());
        try {
            $data = $this->validateForm($form)->getData();

            Doofinder::setConfigValue(Doofinder::DOOFINDER_SEARCH_ZONE, $data["search_zone"]);
            Doofinder::setConfigValue(Doofinder::DOOFINDER_HASH_ID, $data["hash_id"]);
            Doofinder::setConfigValue(Doofinder::DOOFINDER_USER_ID, $data["user_id"]);
            Doofinder::setConfigValue(Doofinder::DOOFINDER_USER_TOKEN, $data["user_token"]);

            $searchEngine = $apiDoofinderManagementService->getSearchEngine();

            Doofinder::setConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE, $searchEngine['name']);
            Doofinder::setConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_CURRENCY, $searchEngine['currency']);
            Doofinder::setConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_STATUS, !$searchEngine['inactive']);
            Doofinder::setConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_LANG, $searchEngine['language']);

            $indices = [];
            foreach ($searchEngine['indices'] as $indice) {
                foreach ($indice['datasources'] as $datasource) {
                    $indices[$indice['name']][] = $datasource['options']['url'];
                }
            }

            Doofinder::setConfigValue(Doofinder::DOOFINDER_SEARCH_ENGINE_FEED, json_encode($indices, JSON_THROW_ON_ERROR));

            return $this->generateSuccessRedirect($form);
        } catch (FormValidationException $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }

        $form->setErrorMessage($error_message);

        $parserContext
            ->addForm($form)
            ->setGeneralError($error_message);

        return $this->generateErrorRedirect($form);
    }

    #[Route('/front_hooks', name: 'front_hooks', methods: 'POST')]
    public function saveFrontHooksParameters(ParserContext $parserContext): RedirectResponse|Response
    {
        $form = $this->createForm(FrontHooksForm::getName());
        try {
            $data = $this->validateForm($form)->getData();

            Doofinder::setConfigValue(Doofinder::DOOFINDER_HOOK_SEARCH_SCRIPT, $data["hook_search_script"]);
            Doofinder::setConfigValue(Doofinder::DOOFINDER_BASIC_SEARCH_BAR, (bool) $data["basic_search_bar"]);
            Doofinder::setConfigValue(Doofinder::DOOFINDER_QUERY_INPUT_ID, $data["query_input_id"]);

            return $this->generateSuccessRedirect($form);
        } catch (FormValidationException $e) {
            $error_message = $this->createStandardFormValidationErrorMessage($e);
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }

        $form->setErrorMessage($error_message);

        $parserContext
            ->addForm($form)
            ->setGeneralError($error_message);

        return $this->generateErrorRedirect($form);
    }
}