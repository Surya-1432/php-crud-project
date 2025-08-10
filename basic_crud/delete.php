<?php
include 'db.php';
include 'header.php';
if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ensure owner
$stmt = $conn->prepare('SELECT user_id FROM posts WHERE id=?');
$stmt->bind_param('i',$id); $stmt->execute(); $r = $stmt->get_result()->fetch_assoc();
if(!$r){ echo '<p>Post not found</p>'; include 'footer.php'; exit; }
if($r['user_id'] != $_SESSION['user_id']){ echo '<p>Not allowed</p>'; include 'footer.php'; exit; }

$stmt = $conn->prepare('DELETE FROM posts WHERE id=?');
$stmt->bind_param('i',$id);
$stmt->execute();
header('Location: index.php'); exit;
?>