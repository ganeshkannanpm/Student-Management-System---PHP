<?php
class Student
{

    private $conn;
    private $table = "students";

    public function __construct($db)
    {

        $this->conn = $db;
    }

    // Get students with search & pagination
    public function getAll($search = "", $limit = 5, $offset = 0)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM $this->table 
                WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' 
                ORDER BY id ASC 
                LIMIT $limit OFFSET $offset";
        return $this->conn->query($sql);
    }

    // Count total students (for pagination)
    public function countAll($search = "")
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM $this->table 
                WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getById($id)
    {

        $sql = "SELECT * FROM $this->table WHERE id = $id";
        return $this->conn->query($sql)->fetch_assoc();
    }

    public function add($name, $email, $phone)
    {

        $name = $this->conn->real_escape_string($name);
        $email = $this->conn->real_escape_string($email);
        $phone = $this->conn->real_escape_string($phone);

        $sql = "INSERT INTO $this->table (name,email,phone) VALUES ('$name','$email','$phone')";
        return $this->conn->query($sql);
    }

    public function update($id, $name, $email, $phone)
    {

        $id = (int) $id;
        $name = $this->conn->real_escape_string($name);
        $email = $this->conn->real_escape_string($email);
        $phone = $this->conn->real_escape_string($phone);

        $sql = "UPDATE $this->table SET name='$name', email='$email', phone='$phone' WHERE id=$id";
        return $this->conn->query($sql);
    }

    public function delete($id)
    {
        $id = (int) $id;
        $sql = "DELETE FROM $this->table WHERE id=$id";
        return $this->conn->query($sql);
    }
}