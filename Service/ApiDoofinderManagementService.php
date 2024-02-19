<?php

namespace Doofinder\Service;

use Doofinder\Doofinder;
use Doofinder\Management\ManagementClient;
use Doofinder\Shared\Exceptions\ApiException;

class ApiDoofinderManagementService
{
    private const DOOFINDER_URL = 'https://%s-api.doofinder.com';
    private ManagementClient $managementClient;

    public function __construct()
    {
        $host = sprintf(
            self::DOOFINDER_URL,
            Doofinder::getConfigValue(Doofinder::DOOFINDER_SEARCH_ZONE_CONFIG_KEY) ?? "eu1",
        );

        $this->managementClient = ManagementClient::create(
            $host,
            Doofinder::getConfigValue(Doofinder::DOOFINDER_USER_TOKEN_CONFIG_KEY),
            Doofinder::getConfigValue(Doofinder::DOOFINDER_USER_ID_CONFIG_KEY)
        );
    }

    /**
     * @throws ApiException
     */
    public function getSearchEngine(): ?array
    {
        $response = $this->managementClient->getSearchEngine(Doofinder::getConfigValue(Doofinder::DOOFINDER_HASH_ID_CONFIG_KEY));

        return $response->getBody()->jsonSerialize();
    }
}