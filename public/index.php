<?php
session_start();
require_once '../classes/Student.php';
require_once '../config/Database.php';

$db = new Database();
$conn = $db->connect();
$student = new Student($conn);
$students = $student->getAll();

// Search & Pagination
$search = $_GET['search'] ?? "";
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 5; // students per page
$offset = ($page - 1) * $limit;

// Fetch data
$students = $student->getAll($search, $limit, $offset);
$total = $student->countAll($search);
$totalPages = ceil($total / $limit);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <div class="container mt-5">
        <h2 class="mb-4 text-center text-white">Student Management System</h2>

        <!-- Search Form -->
        <form method="get" class="d-flex mb-3">
            <input type="text" name="search" class="rounded me-2" placeholder="Search"
                value="<?php echo htmlspecialchars($search) ?>">
            <button class="btn btn-primary">Search</button>
             <a href="index.php" class="btn btn-info ms-2">Reset</a>
        </form>

        <a href="add.php" class="btn btn-success mb-3">+ Add Student</a>

        <?php
        if (!empty($_SESSION['success'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        ?>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success">Student deleted successfully!</div>
        <?php endif; ?>

        <?php if ($students->num_rows > 0): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $students->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">EDIT</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>"
                                    onclick="return_confirm('Are you sure delete this?');"
                                    class="btn btn-sm btn-danger">DELETE</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav>
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?search=<?php echo urlencode($search) ?>&page=<?php echo $i ?>">
                                <?php echo $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>

        <?php else: ?>
            <div class="alert alert-info">No students found.</div>
        <?php endif; ?>
    </div>
</body>

</html>