<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/REST_Controller.php';

class UserApi extends REST_Controller {

    /**
     * [GET] /user/
     *
     * Get users list
     */
	public function index_get()
	{

	}

    /**
     * [POST] /user/
     *
     * Register user
     */
    public function index_post()
    {

    }

    /**
     * [POST] /user/{id}/activate
     *
     * Activate user
     */
    public function activate_user_post($id)
    {
        $this->response([
            'method' => 'Activate',
            'id' => $id,
        ]);
    }

    /**
     * [DELETE] /user/{id}/activate
     *
     * Deactivate user
     */
    public function activate_user_delete($id)
    {

    }

    /**
     * [POST] /user/{id}/profile
     *
     * Set user profile information
     */
    public function profile_post()
    {

    }

    /**
     * [GET] /user/{id}/profile
     *
     * Get user profile information
     */
    public function profile_get()
    {

    }
}
