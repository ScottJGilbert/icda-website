<?php

class UserController
{
    public function login($data)
    {
        $errors = Validators::validateLogin($data);

        if (!empty($errors)) {
            Response::error($errors[0], 422); // Return first error for simplicity
        }

        $username = trim($data['username']);
        $password = $data['password'];

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            Response::error('Invalid username or password', 401);
        }

        unset($user['password']);

        $sessionModel = new Session();
        $sessionModel->createSession($user['uuid']);

        Response::success([
            'user' => $user
        ]);
    }

    public function newUser($data)
    {
        $errors = Validators::validateNewUser($data);

        if (!empty($errors)) {
            Response::error($errors[0], 422);
        }
        $name = trim($data['name']);
        $username = trim($data['username']);
        $password = trim($data['password']);
        $accessLevel = trim($data['access_level']);

        $userModel = new User();
        $userModel->createUser($name, $username, $password, $accessLevel);
    }

}
