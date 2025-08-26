<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include __DIR__ . '/db.php';

// --- Pagination setup ---
$limit = 5; // number of posts per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// --- Search setup ---
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : "";
$whereClause = $search ? "WHERE title LIKE '%$search%' OR content LIKE '%$search%'" : "";

// --- Count total posts for pagination ---
$countResult = $conn->query("SELECT COUNT(*) AS total FROM posts $whereClause");
$totalPosts = $countResult ? $countResult->fetch_assoc()['total'] : 0;
$totalPages = ceil($totalPosts / $limit);

// --- Fetch posts with search + pagination ---
$sql = "SELECT * FROM posts $whereClause ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php if (isset($_GET['msg'])): ?>
    <div id="alertBox" class="alert alert-success">
        <?php echo htmlspecialchars($_GET['msg']); ?>
    </div>
    <script>
        setTimeout(() => {
            const alertBox = document.getElementById('alertBox');
            if (alertBox) {
                alertBox.style.transition = "opacity 0.5s ease";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500); // remove from DOM after fade
            }
        }, 3000); // 3 seconds
    </script>
<?php endif; ?>



<body class="container mt-4">

    <h2>Posts</h2>
    <a href="create.php" class="btn btn-success mb-3">➕ Add New Post</a>


    <!-- Search Form -->
    <form method="get" class="mb-3 d-flex">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
               class="form-control me-2" placeholder="Search posts...">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <!-- Posts List -->
    <div class="list-group">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
               <div class="list-group-item">
    <h5><?php echo htmlspecialchars($row['title']); ?></h5>
    <p><?php echo htmlspecialchars($row['content']); ?></p>
    <small><?php echo $row['created_at']; ?></small>
    <div class="mt-2">
        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
           onclick="return confirm('Are you sure you want to delete this post?');">🗑️ Delete</a>
    </div>
</div>

            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning">No posts found.</div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <nav class="mt-3">
        <ul class="pagination">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Previous</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

</body>
</html>
