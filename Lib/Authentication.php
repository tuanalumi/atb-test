<?php

namespace Lib;

class Authentication
{
    private $username;
    private $password;

    private $dbQuery;

    public function __construct()
    {
        $this->dbQuery = new Query();
    }

    public function getTokenFromCredential($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        // verify credential
        if (empty($this->getUserFromCredential())) {
            return false;
        }

        // generate token

    }

    /**
     * @return bool|mixed
     */
    private function getUserFromCredential()
    {
        try {
            $result = $this->dbQuery->query(
                "SELECT * FROM user WHERE email = :username AND password = :passwordHash",
                [
                    ':username' => $this->username,
                    ':password' => password_hash($this->password, PASSWORD_DEFAULT),
                ]
            )
                ->getFirstResult()
            ;
        } catch (\Exception $exception) {
            return false;
        }


        return $result;
    }
}
