<?php

class User
{
    /**
     * @var \MongoDB\BSON\ObjectID
     */
    protected $id;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     */
    protected $photo;

    /**
     * @var string
     */
    protected $whatsUp;

    /**
     * @var bool
     */
    protected $active;

    /**
     * @return \MongoDB\BSON\ObjectID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \MongoDB\BSON\ObjectID $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getWhatsUp()
    {
        return $this->whatsUp;
    }

    /**
     * @param string $whatsUp
     */
    public function setWhatsUp($whatsUp)
    {
        $this->whatsUp = $whatsUp;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * TODO: Improve code with Extend form serializable class
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'username' => $this->username,
            'token' => $this->token,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'whatsUp' => $this->whatsUp,
            'active'  => $this->active,
        ];
    }


}