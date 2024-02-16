<?php

namespace Doofinder\Service;

use Doofinder\Doofinder;
use Doofinder\Management\ManagementClient;
use Doofinder\Shared\Exceptions\ApiException;

class ApiDoofinderManagementService
{
    private const DOOFINDER_URL = 'https://%s-api.doofinder.com';

    public function getSearchEngine(): ?array
    {
        $host = sprintf(
            self::DOOFINDER_URL,
            Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ZONE) ?? "eu1",
        );

        $managementClient = ManagementClient::create(
            $host,
            Doofinder::getConfigValue(Doofinder::DOOFINDER_USER_TOKEN),
            Doofinder::getConfigValue(Doofinder::DOOFINDER_USER_ID)
        );

        try {
            $response = $managementClient->getSearchEngine(Doofinder::getConfigValue(Doofinder::DOOFINDER_HASH_ID));

            return $response->getBody()->jsonSerialize();
        } catch (ApiException $exception) {
            // configuration is possibly wrong
        }

        return null;
    }
}