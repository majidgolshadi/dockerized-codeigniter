<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends REST_Controller {

	public function get_index()
	{
		$this->response([
		    'message' => 'message content'
        ]);
	}
}
