<?php

class WelcomeApiTest extends TestCase
{
	public function test_index()
	{
		$output = $this->request('GET', '/');
		$this->assertContains('Welcome', $output);
	}

	public function test_method_404()
	{
		$this->request('GET', 'welcome/method_not_exist');
		$this->assertResponseCode(404);
	}
}
