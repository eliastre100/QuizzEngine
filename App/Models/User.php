<?php

namespace App\Models;

use Core\MVC\Model;

class User extends Model {
    protected $id;
    protected $username;
    protected $password;
    protected $firstName;
    protected $lastName;
    protected $passwordConfirmation;
    protected $role = 'ROLE_USER';
    protected $errors = [];

    public function getUsername() {
        return $this->username;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function validatePassword($password) {
        return password_verify($password, $this->password);
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function valid()
    {
        if (empty($this->username)) {
            $this->errors['username'][] = 'The username must be defined';
        }
        if (empty($this->password)) {
            $this->errors['password'][] = 'The password must be defined';
        }
        if ($this->password != $this->passwordConfirmation) {
            $this->errors['passwordConfirmation'][] = 'The password and it\'s confirmation doesn\'t match';
        }
        if (empty($this->firstName)) {
            $this->errors['firstName'][] = 'The first name must be defined';
        }
        if (empty($this->lastName)) {
            $this->errors['lastName'][] = 'The last name must be defined';
        }
        return count($this->errors) == 0;
    }

    public function getErrors($key = null) {
        if ($key == null)
            return $this->errors;
        else if (isset($this->errors[$key]))
            return $this->errors[$key];
        else
            return [];
    }

    public function save() {
        $this->encodePassword();
        $statement = $this->getPdo()->prepare("INSERT INTO users (username, firstName, lastName, password, role) VALUES (:username, :firstName, :lastName, :password, :role)");
        $statement->bindParam(':username', $this->username);
        $statement->bindParam(':firstName', $this->firstName);
        $statement->bindParam(':lastName', $this->lastName);
        $statement->bindParam(':password', $this->password);
        $statement->bindParam(':role', $this->role);
        $statement->execute();
        $this->id = $this->getPdo()->lastInsertId();
    }

    public function getRole() {
        return $this->role;
    }

    public function getId()
    {
        return $this->id;
    }

    private function encodePassword() {
        if (substr($this->password, 0, 4) != "$2y$") {
            $this->setPassword($this->password);
        }
    }
}