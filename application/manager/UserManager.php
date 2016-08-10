<?php

require_once APPPATH.'entity/User.php';

class UserManager
{
    protected $userModel;

    public function __construct()
    {
        $CI = &get_instance();

        $CI->load->model('user_model');
        $this->userModel = $CI->user_model;
    }

    /**
     * @param User $user
     *
     * @return string
     */
    public function register(User $user)
    {
        /** @var User $regUser */
        $regUser = $this->userModel->findOneBy('phone', $user->getPhone());

        if ($regUser->getToken() && $user->getUsername() == $regUser->getUsername()) {
            return $regUser->getToken();
        }

        $token = $this->generateToken();
        $user->setToken($token);

        $this->userModel->insert($user);

        return $token;
    }

    /**
     * @param $username
     * @param $token
     *
     * @throws Exception
     */
    public function activate($username, $token)
    {
        /** @var User $user */
        $user = $this->userModel->findOneBy('username', $username);

        if ($token != $user->getToken()) {
            throw new Exception('Invalid activation token');
        }

        $user->setActive(true);
        $this->userModel->update($user);
    }

    public function deactivate($username)
    {
        /** @var User $user */
        $user = $this->userModel->findOneBy('username', $username);

        if (empty($user->getUsername())) {
            throw new Exception('Invalid Username');
        }

        $user->setActive(false);
        $this->userModel->update($user);
    }

    // TODO: It's not part of UserManager
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