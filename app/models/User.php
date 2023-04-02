<?php
class User {
    private int $id;
    private string $email;
    private string $password;
    private string $rawPassword;
    private string $firstname;
    private string $lastname;
    private string $createdAt;
    private string $username;
    
    public function __construct(array $data) {
        foreach ($data as $key => $value) {
            $setter = "set" . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }
    
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) : void {
        $this->id = $id;
    }
    
    public function getEmail() : string {
        return $this->email;
    }
    
    public function setEmail(string $email) : void {
        $this->email = $email;
    }

    public function getUsername() : string {
        return $this->username;
    }
    
    public function setUsername(string $username) : void {
        $this->username = $username;
    }
    
    public function getPassword() : string {
        return $this->password;
    }
    
    public function setPassword(string $password) : void {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getRawPassword() : string {
        return $this->password;
    }
    
    public function setRawPassword(string $password) : void {
        $this->password = $password;
    }

    public function getFirstname() : string {
        return $this->firstname;
    }
    
    public function setFirstname(string $firstname) : void {
        $this->firstname = $firstname;
    }
    
    public function getLastname() : string {
        return $this->lastname;
    }
    
    public function setLastname(string $lastname) : void {
        $this->lastname = $lastname;
    }
    
    public function getCreatedAt() : string {
        return $this->createdAt;
    }
    
    public function setCreatedAt(string $date) : void {
        $this->createdAt = $date;
    }

    public function json(bool $decoded = false) : array|string {
        $data = get_object_vars($this);
        unset($data["password"]);
        unset($data["rawPassword"]);
        return $decoded ? $data : json_encode($data);
    }
}
?>