<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/REST_Controller.php';
require_once APPPATH.'entity/User.php';
require_once APPPATH.'factory/UserFactory.php';
require_once APPPATH.'manager/UserManager.php';

class UserApi extends REST_Controller {

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var ModelInterface
     */
    private $userRepository;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');

        $this->userFactory = new UserFactory();
        $this->userRepository = $this->user_model;
        $this->userManager = new UserManager($this->userRepository);
    }

    /**
     * [POST] /user/
     *
     * Register user
     */
    public function index_post()
    {
        $user = $this->userFactory->createNew(
            $this->post('deviceId'),
            $this->post('phoneNumber')
        );

        $token = $this->userManager->register($user);

        return $this->response([
            $this->config->item('rest_status_field_name') => true,
            'uri' => '/user/'.$user->getUsername().'/activation?token='.$token,
        ], 201);
    }

    /**
     * [GET] /user/{username}/activation?token={$token}
     *
     * Activate user
     */
    public function activation_user_get($username)
    {
        $this->userManager->activate(
            $this->userRepository->findOneBy('username', $username)
        );

        return $this->response([
            $this->config->item('rest_status_field_name') => true
        ]);
    }

    /**
     * [DELETE] /user/{username}/activation
     *
     * Deactivate user
     */
    public function activation_user_delete($username)
    {
        $this->userManager->deactivate(
            $this->userRepository->findOneBy('username', $username)
        );

        return $this->response([
            $this->config->item('rest_status_field_name') => true
        ]);
    }

    public function response($data = NULL, $http_code = NULL, $continue = TRUE)
    {
        parent::response($data, $http_code, $continue);
    }
}
