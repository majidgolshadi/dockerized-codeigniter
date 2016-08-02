<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'libraries/REST_Controller.php';

class WelcomeApi extends REST_Controller {

	public function index_get()
	{
		$this->response([
		    'message' => 'Welcome'
        ]);
	}
}
