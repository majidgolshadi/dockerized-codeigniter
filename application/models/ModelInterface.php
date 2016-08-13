<?php

interface ModelInterface
{
    public function insert(User $user);

    public function update(User $user);

    public function findOneBy($filed, $value);
}