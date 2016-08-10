<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/REST_Controller.php';
require_once APPPATH.'entity/User.php';
require_once APPPATH.'manager/UserManager.php';

class UserApi extends REST_Controller {

    private $userManager;

    public function __construct()
    {
        parent::__construct();
        $this->userManager = new UserManager();
    }

    /**
     * [POST] /user/
     *
     * Register user
     */
    public function index_post()
    {
        $user = new User();

        $user->setPhone($this->post('phoneNumber'));
        $user->setUsername($this->post('deviceId'));
        $user->setActive(false);

        $token = $this->userManager->register($user);

        return $this->response([
            $this->config->item('rest_status_field_name') => true,
            'uri' => '/user/'.$user->getUsername().'/activate?token='.$token,
        ]);
    }

    /**
     * [GET] /user/{username}/activation?token={$token}
     *
     * Activate user
     */
    public function activate_user_get($username)
    {
        $this->userManager->activate($username, $this->get('token'));

        return $this->response([
            $this->config->item('rest_status_field_name') => true
        ]);
    }

    /**
     * [DELETE] /user/{username}/activation
     *
     * Deactivate user
     */
    public function activate_user_delete($username)
    {
        $this->userManager->deactivate($username);

        return $this->response([
            $this->config->item('rest_status_field_name') => true
        ]);
    }
}
