<?php

namespace App\Repositories;

use App\Client;

/**
 * Class ClientRepository
 * @package App\Repositories
 */
class ClientRepository extends CrudRepository
{
    /**
     * ClientRepository constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        parent::__construct($client);
    }

    public function update(array $pks, array $data)
    {
        $client = parent::update($pks, $data);
        $client->clientDetails()->update($data['client_details']);
        return $client->clientDetails   ;
    }
}
