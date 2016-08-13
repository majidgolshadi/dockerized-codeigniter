<?php

require_once APPPATH.'entity/User.php';

class UserManagerTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var UserManager
     */
    private $userManager;

    private $mockUserModel;

    public function setUp()
    {
        $this->user = new User();
        $this->mockUserModel = new MockUserModel();
        $this->userManager = new UserManager($this->mockUserModel);
    }

    public function test_throw_exception_on_missing_user_data()
    {
        $exception = new Exception();

        try {
            $this->userManager->register($this->user);
        } catch (Exception $e) {
            $exception = $e;
        }

        $this->assertContains('Username is not set', $exception->getMessage());
    }

    public function test_throw_exception_on_missing_username()
    {
        $exception = new Exception();
        $this->user->setPhone('989997774411');

        try {
            $this->userManager->register($this->user);
        } catch (Exception $e) {
            $exception = $e;
        }

        $this->assertContains('Username is not set', $exception->getMessage());
    }

    public function test_throw_exception_on_missing_phoneNumber()
    {
        $exception = new Exception();
        $this->user->setUsername('username');

        try {
            $this->userManager->register($this->user);
        } catch (Exception $e) {
            $exception = $e;
        }

        $this->assertContains('Phone number is not set', $exception->getMessage());
    }

    public function test_return_registered_user_token()
    {
        $this->user->setUsername('username');
        $this->user->setPhone('989997774411');

        $token = $this->userManager->register($this->user);

        $this->assertFalse($this->mockUserModel->isCalled('insert'));
        $this->assertContains('TOKEN', $token);
    }

    public function test_register_new_user()
    {
        $this->user->setUsername('new_username');
        $this->user->setPhone('989997774422');

        $this->userManager->register($this->user);

        $this->assertTrue($this->mockUserModel->isCalled('insert'));
    }

    public function test_user_register_multi_username_with_single_phoneNumber()
    {
        $this->user->setUsername('username');
        $this->user->setPhone('989997774411');

        $this->userManager->register($this->user);

        $this->user->setUsername('username2');
        $this->userManager->register($this->user);

        $this->assertTrue($this->mockUserModel->isCalled('insert'));
    }

    public function test_throw_exception_on_try_to_activate_unregistered_user()
    {
        $this->user->setUsername('unregistered');
        $this->user->setToken('TOKEN');
        $exception = new Exception();

        try {
            $this->userManager->activate($this->user);
        } catch (Exception $e) {
            $exception = $e;
        }

        $this->assertContains('Username unregistered does not exist', $exception->getMessage());
    }

    public function test_throw_exception_on_invalid_registered_user_token()
    {
        $this->user->setUsername('username');
        $this->user->setToken('INVALID_TOKEN');
        $exception = new Exception();

        try {
            $this->userManager->activate($this->user);
        } catch (Exception $e) {
            $exception = $e;
        }

        $this->assertContains('Invalid token', $exception->getMessage());
    }

    public function test_activate_registered_user()
    {
        $this->user->setUsername('username');
        $this->user->setToken('TOKEN');

        try {
            $this->userManager->activate($this->user);
        } catch (Exception $e) {}

        $this->assertTrue($this->mockUserModel->isCalled('update'));
    }

    public function test_deactivate_unregistered_user()
    {
        $this->user->setUsername('unregistered');
        $exception = new Exception();

        try {
            $this->userManager->deactivate($this->user);
        } catch (Exception $e) {
            $exception = $e;
        }

        $this->assertContains('Invalid username', $exception->getMessage());
    }

    public function test_deactivate_unactivated_user()
    {
        $this->user->setUsername('username');
        $exception = new Exception();

        try {
            $this->userManager->deactivate($this->user);
        } catch (Exception $e) {
            $exception = $e;
        }

        $this->assertContains('User was not activated', $exception->getMessage());
    }

    public function test_deactivate_activated_user()
    {
        $this->user->setUsername('activated_username');

        try {
            $this->userManager->deactivate($this->user);
        } catch (Exception $e) {}

        $this->assertTrue($this->mockUserModel->isCalled('update'));
    }
}

class MockUserModel implements ModelInterface
{
    /**
     * @var bool
     */
    private $insertMethodCalled;

    /**
     * @var bool
     */
    private $updateMethodCalled;

    public function __construct()
    {
        $this->insertMethodCalled = false;
        $this->updateMethodCalled = false;
    }

    public function insert(User $user)
    {
        $this->insertMethodCalled = true;

        return null;
    }

    public function update(User $user)
    {
        $this->updateMethodCalled = true;

        return null;
    }

    public function findOneBy($filed, $value)
    {
        $user = new User();

        if($value !== 'unregistered') {
            $user->setPhone('989997774411');
            $user->setUsername('username');
            $user->setToken('TOKEN');
            $user->setActive(false);
        }

        if ($value === 'activated_username') {
            $user->setActive(true);
        }

        return $user;
    }

    public function isCalled($methodName)
    {
        $property = $methodName.'MethodCalled';
        return $this->$property;
    }
}
