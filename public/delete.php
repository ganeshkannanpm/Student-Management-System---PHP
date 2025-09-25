<?php 
require_once '../config/Database.php';
require_once '../classes/Student.php';

$db = new Database();
$conn = $db->connect();
$student = new Student($conn);


if (!isset($_GET['id'])) {
    die("Invalid student ID");
}

$id = (int) $_GET['id'];

if ($student->delete($id)) {
    header("Location: index.php?msg=deleted");
    exit;
} else {
    echo "Failed to delete student.";
}