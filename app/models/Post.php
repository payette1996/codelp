<?php
class Post {
    private int $id;
    private string $title;
    private string $description;
    private int $userId;
    private int $threadId;
    private string $createdAt;
    private string $username;
    private string $threadTitle;

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

    public function getTitle() : string {
        return $this->title;
    }

    public function setTitle(string $title) : void {
        $this->title = $title;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function setDescription(string $description) : void {
        $this->description = $description;
    }

    public function getUserId() : int {
        return $this->userId;
    }

    public function setUserId(int $userId) : void {
        $this->userId = $userId;
    }

    public function getThreadId() : int {
        return $this->threadId;
    }

    public function setThreadId(int $threadId) : void {
        $this->threadId = $threadId;
    }

    public function getCreatedAt() : string {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt) : void {
        $this->createdAt = $createdAt;
    }

    public function getUsername() : string {
        return $this->username;
    }

    public function setUsername(string $username) : void {
        $this->username = $username;
    }

    public function getThreadTitle() : string {
        return $this->threadTitle;
    }

    public function setThreadTitle(string $threadTitle) : void {
        $this->threadTitle = $threadTitle;
    }

    public function json(bool $decoded = false) : array|string {
        $data = get_object_vars($this);
        return $decoded ? $data : json_encode($data);
    }
}
?>