<?php


namespace app\engine;

use app\traits\TSingletone;

class Db
{

    private $config = [
        'driver' => 'mysql',
        'host' => 'localhost:3306',
        'login' => 'store',
        'password' => '12345',
        'database' => 'store',
    ];

    use TSingletone;


    private $connection = null;

    private function getConnection()
    {

        if (is_null($this->connection)) {
            $this->connection = new \PDO($this->prepareDsnString(), $this->config['login'], $this->config['password']);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        }
        return $this->connection;
    }


    private function prepareDsnString()
    {
        return sprintf(
            "%s:host=%s;dbname=%s",
            $this->config['driver'],
            $this->config['host'],
            $this->config['database'],
        );
    }

    private function query($sql, $params)
    {
        $STH = $this->getConnection()->prepare($sql);
        $STH->execute($params);
        return $STH;
    }

    public function queryLimit($sql, $limit) {
        $STH = $this->getConnection()->prepare($sql);
        $STH->bindValue(1, $limit, \PDO::PARAM_INT);
        $STH->execute();
        return $STH;
    }

    public function queryOneObject($sql, $params, $class)
    {
        $STH = $this->query($sql, $params);
        $STH->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $class);
        return $STH->fetch();
    }

    public function queryOne($sql, $params = [])
    {
        return $this->query($sql, $params)->fetch();
    }

    public function queryAll($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll();
    }
    public function execute($sql, $params = [])
    {
        return $this->query($sql, $params)->rowCount();
    }
    public function lastInsertId()
    {
        return $this->getConnection()->lastInsertId();
    }
}
