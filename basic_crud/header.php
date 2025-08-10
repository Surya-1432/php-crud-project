<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Basic CRUD</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="nav">
  <a href="index.php">Home</a>
  <?php if(isset($_SESSION['user'])): ?>
    <a href="create.php">Create Post</a>
    <span class="muted">Hello, <?php echo esc($_SESSION['user']); ?></span>
    <a href="logout.php">Logout</a>
  <?php else: ?>
    <a href="login.php">Login</a>
    <a href="register.php">Register</a>
  <?php endif; ?>
</nav>
<main class="container">
