<?php
session_start();
require_once '../config/Database.php';
require_once '../classes/Student.php';

$db = new Database();
$conn = $db->connect();
$student = new Student($conn);

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (empty($name))
        $errors[] = "Name is required";
    if (empty($email))
        $errors[] = "Email is required";
    if (empty($phone))
        $errors[] = "Phone is required";

    if (empty($errors)) {

        $result = $student->add($name, $email, $phone);

        if ($result) {
            $_SESSION['success'] = "Student added successfully";
            header("Location:index.php");
            exit;
        } else {
            $errors[] = "Failed to add student";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <div class="container mt-5">
        <h2 class="text-white text-center">Add New Student</h2>
        <a href="index.php" class="btn btn-secondary mb-3">← Back</a>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php echo implode('<br>', $errors); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text" name="name" class="form-control" value="<?php echo $_POST['name'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" name="email" class="form-control" value="<?php echo $_POST['email'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone *</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $_POST['phone'] ?? '' ?>">
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>
</body>

</html>