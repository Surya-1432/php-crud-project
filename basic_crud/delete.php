<?php
include __DIR__ . '/db.php';

if (!isset($_GET['id'])) {
    die("Post ID missing.");
}

$id = (int) $_GET['id'];

$sql = "DELETE FROM posts WHERE id = $id";
if ($conn->query($sql)) {
   header("Location: index.php?msg=Post+deleted+successfully");

    exit;
} else {
    echo "Error deleting post: " . $conn->error;
}
?>
