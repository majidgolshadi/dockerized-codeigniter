<?php

require_once APPPATH.'entity/User.php';

class User_model extends MY_Model implements ModelInterface
{
    private $table = 'users';

    public function insert(User $user)
    {
        return $this->db->insert(
            $this->table,
            $this->NormalizedFieldName($user->toArray())
        );
    }

    public function update(User $user)
    {
        return $this->db->update(
            $this->table,
            $this->NormalizedFieldName($user->toArray())
        );
    }

    public function findOneBy($filed, $value)
    {
        $user = $this->db
                     ->from($this->table)
                     ->where($filed, $value)
                     ->get()->result_array();

        return $this->modelToEntityMapper(
            array_shift($user)
        );
    }

    // TODO: Define dataMapper method to map data from entity to model and vice versa
    private function modelToEntityMapper($userDataArray)
    {
        $user = new User();

        $user->setId($userDataArray['id']);
        $user->setFirstName($userDataArray['first_name']);
        $user->setLastName($userDataArray['last_name']);
        $user->setUsername($userDataArray['username']);
        $user->setToken($userDataArray['token']);
        $user->setPhone($userDataArray['phone']);
        $user->setPhoto($userDataArray['photo']);
        $user->setWhatsUp($userDataArray['whats_up']);
        $user->setActive($userDataArray['active']);

        return $user;
    }
}