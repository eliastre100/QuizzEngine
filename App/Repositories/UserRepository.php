<?php

namespace App\Repositories;

use App\Models\User;
use Core\MVC\Repository;

class UserRepository extends Repository {

    public function findByUsername($username) {
        $statement = $this->getPdo()->prepare("SELECT * FROM users WHERE users.username LIKE :username");
        $statement->bindParam(':username', $username);
        $statement->execute();
        return $statement->fetchAll( \PDO::FETCH_CLASS, User::class);
    }

    public function findOneByUsername($username) {
        $statement = $this->getPdo()->prepare("SELECT * FROM users WHERE users.username LIKE :username LIMIT 1");
        $statement->bindParam(':username', $username);
        $statement->execute();
        return $statement->fetchObject(User::class);
    }

    public function find($id)
    {
        $statement = $this->getPdo()->prepare("SELECT * FROM users WHERE users.id = :id LIMIT 1");
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetchObject(User::class);
    }
}