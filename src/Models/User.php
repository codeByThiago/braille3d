<?php 

namespace Models;

class User {
    public int $id;
    public string $name;
    public string $email;
    public string $password;

    public function __construct(array $data) {
        $this->id = $data['id'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = password_hash($data['password'], PASSWORD_BCRYPT) ?? '';
    }

    // GETTERS E SETTERS
    public function getId() : string { return $this->id; }
    public function getName() : string { return $this->name; }
    public function getEmail() : string { return $this->email; }
    public function getPassword() : string { return $this->password; }
    
    public function setId(int $id) : void { $this->id = $id; }
    public function setName(string $name) : void { $this->name = $name; }
    public function setEmail(string $email) : void { $this->email = $email; }
    public function setPassword(string $password) : void {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    public function toArray() : array {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }

}

?>