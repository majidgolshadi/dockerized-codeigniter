<?php

require_once APPPATH.'entity/User.php';

class UserManager
{
    /**
     * @var ModelInterface
     */
    protected $userModel;

    public function __construct(ModelInterface $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @param User $user
     *
     * @return string
     * @throws Exception
     */
    public function register(User $user)
    {
        if (null === $user->getUsername()) {
            throw new Exception('Username is not set');
        }

        if (null === $user->getPhone()) {
            throw new Exception('Phone number is not set');
        }

        /** @var User $regUser */
        $regUser = $this->userModel->findOneBy('phone', $user->getPhone());

        if ($regUser->getToken() && $user->getUsername() === $regUser->getUsername()) {
            return $regUser->getToken();
        }

        $token = $this->generateToken();
        $user->setToken($token);

        $this->userModel->insert($user);

        return $token;
    }

    /**
     * @param User $user
     *
     * @throws Exception
     */
    public function activate(User $user)
    {
        if (empty($user->getUsername())) {
            throw new Exception('Username is not set');
        }

        if (empty($user->getToken())) {
            throw new Exception('Token is not set');
        }

        /** @var User $fetchUser */
        $fetchUser = $this->userModel->findOneBy('username', $user->getUsername());

        if (empty($fetchUser->getUsername())) {
            throw new Exception(sprintf('Username %s does not exist', $user->getUsername()));
        }

        if ($fetchUser->getToken() != $user->getToken()) {
            throw new Exception('Invalid token');
        }

        $user->setActive(true);
        $this->userModel->update($user);
    }

    /**
     * @param User $user
     *
     * @throws Exception
     */
    public function deactivate(User $user)
    {
        /** @var User $user */
        $fetchUser = $this->userModel->findOneBy('username', $user->getUsername());

        if (empty($fetchUser->getUsername())) {
            throw new Exception('Invalid username');
        }

        if (!$fetchUser->isActive()) {
            throw new Exception('User was not activated');
        }

        $user->setActive(false);
        $this->userModel->update($user);
    }

    // TODO: generateToken It's not part of UserManager
    function generateToken($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}