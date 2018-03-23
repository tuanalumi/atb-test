<?php

namespace Lib;

class Query
{
    /**
     * @var \PDOStatement
     */
    private $statement;
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host=localhost;dbname=atb-test', 'root', 'root');
    }

    /**
     * @param $queryToPrepare
     * @param $params
     *
     * @return $this
     * @throws \Exception
     */
    public function query($queryToPrepare, $params)
    {
        $this->statement = $this->pdo->prepare($queryToPrepare);

        if (!$this->statement->execute($params)) {
            throw new \Exception($this->statement->errorInfo()[2]);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstResult()
    {
        return $this->statement->fetch();
    }

    public function getAllResults()
    {
        return $this->statement->fetchAll();
    }
}
