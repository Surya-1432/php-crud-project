<?php
include 'db.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $username = trim($_POST['username']);
  $password = $_POST['password'];
  if($username==='' || $password==='') $error = 'Fill all fields';
  else {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO users (username, password) VALUES (?,?)');
    $stmt->bind_param('ss',$username,$hash);
    if($stmt->execute()){
      // auto-login
      $_SESSION['user_id'] = $stmt->insert_id;
      $_SESSION['user'] = $username;
      header('Location: index.php'); exit;
    } else $error = 'User exists or DB error: ' . $stmt->error;
  }
}
?>
<h1>Register</h1>
<?php if(!empty($error)) echo '<p class="error">'.esc($error).'</p>'; ?>
<form method="post">
  <label>Username<br><input type="text" name="username" required></label>
  <label>Password<br><input type="password" name="password" required></label>
  <button type="submit">Register</button>
</form>

<?php include 'footer.php'; ?>