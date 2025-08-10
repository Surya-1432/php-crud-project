<?php
include 'db.php';
include 'header.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
  $username = trim($_POST['username']);
  $password = $_POST['password'];
  $stmt = $conn->prepare('SELECT id, password FROM users WHERE username=?');
  $stmt->bind_param('s',$username);
  $stmt->execute();
  $res = $stmt->get_result();
  if($row = $res->fetch_assoc()){
    if(password_verify($password, $row['password'])){
      // login success
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['user'] = $username;
      header('Location: index.php'); exit;
    } else $error = 'Invalid credentials';
  } else $error = 'Invalid credentials';
}
?>
<h1>Login</h1>
<?php if(!empty($error)) echo '<p class="error">'.esc($error).'</p>'; ?>
<form method="post">
  <label>Username<br><input type="text" name="username" required></label>
  <label>Password<br><input type="password" name="password" required></label>
  <button type="submit">Login</button>
</form>

<?php include 'footer.php'; ?>
