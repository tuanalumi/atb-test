<?php

namespace Lib;

class FrontController
{
    private $action;
    private $token;

    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function run()
    {
        $auth = new Authentication();

        if ($this->action === 'get_token') {
            $this->getTokenAction($auth);

            return;
        }

        // validate token
        try {
            $user = $auth->getUserFromToken($this->token);
        } catch (\Exception $exception) {
            Response::error($exception->getMessage());
        }

        if ($this->action === 'info') {
            Response::generate([
                'data' => $user
            ]);

            return;
        }

        if ($this->action === 'update') {
            try {
                $this->updateAction($user);
            } catch (\Exception $exception) {
                Response::error($exception->getMessage());
            }

            return;
        }
    }

    public function getTokenAction(Authentication $auth)
    {
        try {
            // authenticate with username/password
            $token = $auth->getTokenFromCredential(
                $_GET['email'] ?? null,
                $_GET['password'] ?? null
            );

            Response::generate([
                'access_token' => $token
            ]);
        } catch (\Exception $e) {
            Response::error('Unable to get token: ' . $e->getMessage());
        }
    }

    /**
     * @param $user
     *
     * @throws \Exception
     */
    private function updateAction($user)
    {
        if (empty($_POST)) {
            Response::error('No data to update');
        }

        // build query
        $query  = [];
        $params = [
            ':userId' => $user['id']
        ];
        foreach ($_POST as $field => $value) {
            if ($field == 'email') {
                Response::error('Email can not be updated');
            }

            $query[] = "$field = :{$field}";

            $params[":{$field}"] = $value;
        }

        $q = new Query();

        $q->query(
            "UPDATE user
            SET " . implode(',', $query) . "
            WHERE id = :userId",
            $params
        );

        Response::generate([]);
    }
}
