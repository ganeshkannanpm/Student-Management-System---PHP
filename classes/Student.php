<?php
class Student
{

    private $conn;
    private $table = "students";

    public function __construct($db)
    {

        $this->conn = $db;
    }

    public function getAll()
    {

        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        return $this->conn->query($sql);
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

        $sql = "UPDATE $this->table SET name='$name', email='$email', phone='$phone'";
        return $this->conn->query($sql);
    }

    public function delete($id)
    {
        $id = (int) $id;
        $sql = "DELETE FROM $this->table WHERE id=$id";
        return $this->conn->query($sql);
    }
}