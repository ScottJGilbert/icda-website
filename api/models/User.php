<?php

class User
{
    private $pdo;

    public function __construct()
    {
        // Load database config (you can move this later to a config file)
        $this->pdo = Database::getConnection();
    }

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC); // Returns false if not found

        return $user ?: null;
    }

    public function createUser($name, $username, $unhashedPassword, $accessLevel)
    {
        $password = password_hash($unhashedPassword, PASSWORD_DEFAULT);

        $uuid = $this->generateUUID();
        $sql = "INSERT INTO users VALUES(:uuid, :name, :username, :password, :accessLevel)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':accessLevel', $accessLevel, PDO::PARAM_STR);

        $stmt->execute();
    }

    public function deleteUser($uuid)
    {
        $sql = "DELETE FROM users WHERE uuid = :uuid";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":uuid", $uuid, PDO::PARAM_STR);
        $stmt->execute();
    }

    private function generateUUID()
    {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = random_bytes(16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
