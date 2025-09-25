<?php
session_start();
require_once '../config/Database.php';
require_once '../classes/Student.php';

$db = new Database();
$conn = $db->connect();
$student = new Student($conn);

$errors = [];
$success = "";

if (!isset($_GET['id'])) {
    die("Invalid student ID");
}

$id = (int) $_GET['id'];
$data = $student->getById($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (empty($name))
        $errors[] = "Name is required.";
    if (empty($email))
        $errors[] = "Email is required.";
    if (empty($phone))
        $errors[] = "Phone is required.";

    if (empty($errors)) {

        $updated = $student->update($id, $name, $email, $phone);

        if ($updated) {
            $success = "Updated successfully";
            $_SESSION['success'] = "Student updated successfully";
            $data = $student->getById($id);
            header("Location:index.php");
            exit;
        } else {
            $errors[] = "Failed to update";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <div class="container mt-5">
        <h2 class="text-white text-center">Edit Student</h2>
        <a href="index.php" class="btn btn-secondary mb-3">← Back</a>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php echo implode('<br>', $errors); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="post" class="card p-4 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Name *</label>
                <input type="text" name="name" class="form-control"
                    value="<?php echo htmlspecialchars($data['name']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Email *</label>
                <input type="email" name="email" class="form-control"
                    value="<?php echo htmlspecialchars($data['email']); ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone *</label>
                <input type="text" name="phone" class="form-control"
                    value="<?php echo htmlspecialchars($data['phone']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
    </div>
</body>
</html>