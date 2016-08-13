<?php

require_once APPPATH.'entity/User.php';

class UserFactory
{
    public function createNew($username, $phoneNumber, $activate = false)
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPhone($phoneNumber);
        $user->setActive($activate);

        return $user;
    }
}