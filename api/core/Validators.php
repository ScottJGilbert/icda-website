<?php

class Validators
{

    public static function validateLogin($data): array
    {
        $errors = [];

        if (!isset($data['username']) || trim($data['username']) === '') {
            $errors[] = 'Username is required.';
        }

        if (!isset($data['password']) || trim($data['password']) === '') {
            $errors[] = 'Password is required.';
        }

        return $errors;
    }

    public static function validateNewUser($data): array
    {
        $errors = [];

        if (!isset($data['name']) || trim($data['name']) === '') {
            $errors[] = 'Name is required.';
        }

        if (!isset($data['username']) || trim($data['username']) === '') {
            $errors[] = 'Username is required.';
        }

        if (!isset($data['password']) || trim($data['password']) === '') {
            $errors[] = 'Password is required.';
        }

        if (!isset($data['permission']) || trim($data['permission']) === '') {
            $errors[] = 'Permission is required.';
        }

        return $errors;
    }
}
