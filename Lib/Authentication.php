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

    /**
     * @param $username
     * @param $password
     *
     * @return bool
     * @throws \Exception
     */
    public function getTokenFromCredential($username, $password)
    {
        if (empty($username) OR empty($password)) {
            throw new \Exception('Missing username/password');
        }

        $this->username = $username;
        $this->password = $password;

        // verify credential
        $user = $this->getUserFromCredential();

        if (empty($user)) {
            throw new \Exception('Incorrect username/password:');
        }

        if ($user['token']) {
            return $user['token'];
        }

        // generate token
        $token = Token::generate();

        $this->dbQuery->query(
            "INSERT INTO token (token, valid_until, user_id) VALUE(:token, :valid_until, :user_id)",
            [
                ':token'       => $token,
                ':valid_until' => date('Y-m-d H:i:s', strtotime('+6 hours')),
                ':user_id'     => $user['id'],
            ]
        );

        return $token;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    private function getUserFromCredential()
    {
        $result = $this->dbQuery
            ->query(
                "SELECT * 
                FROM user u 
                    LEFT JOIN token t ON t.user_id = u.id 
                WHERE email = :username",
                [
                    ':username' => $this->username
                ]
            )
            ->getFirstResult()
        ;

        if (password_verify($this->password, $result['password'])) {
            return $result;
        }

        return false;
    }

    /**
     * @param $token
     *
     * @return bool|mixed
     * @throws \Exception
     */
    public function getUserFromToken($token)
    {
        if (empty($token)) {
            return false;
        }

        $user = $this->dbQuery->query(
            "SELECT u.* 
            FROM token t
                INNER JOIN user u ON u.id = t.user_id 
            WHERE token = :token AND valid_until <= NOW()",
            [
                ':token'   => $token
            ]
        )->getFirstResult();

        if (empty($user)) {
            throw new \Exception('Invalid or expired token');
        }

        return $user;
    }
}
