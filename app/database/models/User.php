<?php

namespace app\database\models;

use app\database\Connect;

class User extends Model
{
    protected string $table = 'users';

    public function insert(array $data)
    {
        try {
            $connect = Connect::connect();
            $prepare = $connect->prepare("INSERT INTO $this->table(firstName,lastName,avatar,email) VALUES(:firstName,:lastName,:avatar,:email)");

            return $prepare->execute($data);
            var_dump($data);
        } catch (\PDOException $th) {
            var_dump($th->getMessage());
        }
    }
}