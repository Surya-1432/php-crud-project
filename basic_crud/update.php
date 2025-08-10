<?php
include 'db.php';
include 'header.php';

if(!isset($_SESSION['user_id'])){ header('Location: login.php'); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// fetch
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param('i',$id);
$stmt->execute();
$res = $stmt->get_result();
$post = $res->fetch_assoc();
if(!$post) { echo '<p>Post not found</p>'; include 'footer.php'; exit; }
if($post['user_id'] != $_SESSION['user_id']) { echo '<p>Not allowed</p>'; include 'footer.php'; exit; }

if($_SERVER['REQUEST_METHOD']==='POST'){
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);
  $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
  $stmt->bind_param('ssi', $title, $content, $id);
  if($stmt->execute()) header('Location: index.php');
  else $error = 'Update failed: ' . $stmt->error;
}
?>
<h1>Edit Post</h1>
<?php if(!empty($error)) echo '<p class="error">'.esc($error).'</p>'; ?>
<form method="post">
  <label>Title<br><input type="text" name="title" value="<?php echo esc($post['title']); ?>" required></label>
  <label>Content<br><textarea name="content" rows="8" required><?php echo esc($post['content']); ?></textarea></label>
  <button type="submit">Update</button>
</form>

<?php include 'footer.php'; ?>