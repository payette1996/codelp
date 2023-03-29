<?php
class Post {
    private int $id;
    private string $title;
    private string $description;
    private int $userId;
    private int $threadId;
    private string $createdAt;

    public function __construct(array $data) {
        $requiredKeys = ["id", "title", "description", "userId", "threadId"];
        foreach ($requiredKeys as $key) {
            if (!isset($data[$key])) throw new Exception("$key is required.");
        }

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

    public function setTitle(int $title) : void {
        $this->title = $title;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function setDescription(int $description) : void {
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

    public function setCreatedAt(int $createdAt) : void {
        $this->createdAt = $createdAt;
    }

    public function json() {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
        foreach ($properties as $property) {
            $property->setAccessible(true);
            $data[$property->getName()] = $property->getValue($this);
        }
        return json_encode($data);
    }
}
?>