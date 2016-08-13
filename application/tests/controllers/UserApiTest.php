<?php

class UserApiTest extends TestCase
{
    // Integration test
	public function test_register_user()
    {
        $output = $this->request('POST', '/user/', [
            'deviceId' => 'majidGolshadi',
            'phoneNumber' => '09307764010'
        ]);

        $this->assertContains('"status":true', $output);
        $this->assertResponseCode(201);
        $this->assertResponseHeader(
            'Content-Type', 'application/json; charset=utf-8'
        );

        return $output;
    }

    /**
     * @depends test_register_user
     */
    public function test_activate_user($response)
    {
        $output = $this->request('GET', json_decode($response)->uri);

        $this->assertContains('"status":true', $output);
        $this->assertResponseCode(200);
        $this->assertResponseHeader(
            'Content-Type', 'application/json; charset=utf-8'
        );

        return $output;
    }

    /**
     * @depends test_activate_user
     */
    public function test_deactivate_user($response)
    {
        $output = $this->request('DELETE', '/user/majidgolshadi/activation');

        $this->assertContains('"status":true', $output);
        $this->assertResponseCode(200);
        $this->assertResponseHeader(
            'Content-Type', 'application/json; charset=utf-8'
        );

        return $output;
    }
}
