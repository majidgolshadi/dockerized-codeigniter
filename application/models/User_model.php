<?php

use \MongoDB\Collection;

require_once APPPATH.'entity/User.php';
require_once APPPATH.'models/ModelInterface.php';

class User_model extends MY_Model implements ModelInterface
{
    /**
     * @var Collection
     */
    private $collection;

    public function __construct()
    {
        parent::__construct();
        $this->collection = new Collection($this->manager, $this->db, 'users');
    }

    public function insert(User $user)
    {
        $this->collection->insertOne(
            $this->NormalizedFieldName(
                $user->toArray()
            ),
            []
        );
    }

    public function update(User $user)
    {
        $this->collection->replaceOne(
            ['username' => $user->getUsername()],
            $this->NormalizedFieldName(
                $user->toArray()
            )
        );
    }

    public function findOneBy($filed, $value)
    {
        $user = $this->collection->findOne(
            [],
            [$filed => $value]
        );

        return $this->modelToEntityMapper(
            $user
        );
    }

    // TODO: Define dataMapper method to map data from entity to model and vice versa
    private function modelToEntityMapper($mongoUserObject)
    {
        $user = new User();

        if (isset($mongoUserObject)) {
            $user->setId($mongoUserObject['_id']);
            $user->setFirstName($mongoUserObject['first_name']);
            $user->setLastName($mongoUserObject['last_name']);
            $user->setUsername($mongoUserObject['username']);
            $user->setToken($mongoUserObject['token']);
            $user->setPhone($mongoUserObject['phone']);
            $user->setPhoto($mongoUserObject['photo']);
            $user->setWhatsUp($mongoUserObject['whats_up']);
            $user->setActive($mongoUserObject['active']);
        }

        return $user;
    }
}