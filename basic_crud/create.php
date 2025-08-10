<?php
include 'db.php';
include 'header.php';

if(!isset($_SESSION['user_id'])){
  header('Location: login.php'); exit;
}

if($_SERVER['REQUEST_METHOD']==='POST'){
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);

  if($title==='') $error = 'Title required';
  else {
    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $_SESSION['user_id'], $title, $content);
    if($stmt->execute()){
      header('Location: index.php'); exit;
    } else $error = 'DB error: ' . $stmt->error;
  }
}
?>
<h1>Create Post</h1>
<?php if(!empty($error)) echo '<p class="error">'.esc($error).'</p>'; ?>
<form method="post">
  <label>Title<br><input type="text" name="title" required></label>
  <label>Content<br><textarea name="content" rows="8" required></textarea></label>
  <button type="submit">Create</button>
</form>

<?php include 'footer.php'; ?>