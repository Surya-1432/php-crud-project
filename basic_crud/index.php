<?php
include 'db.php';
include 'header.php';

// Pagination simple
$limit = 10;
$page = isset($_GET['page']) ? max(1,(int)$_GET['page']) : 1;
$offset = ($page-1)*$limit;

$sql = "SELECT p.*, u.username FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ii', $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()): ?>
  <article class="post">
    <h2><?php echo esc($row['title']); ?></h2>
    <p class="meta">By <?php echo esc($row['username']); ?> on <?php echo $row['created_at']; ?></p>
    <div class="content"><?php echo nl2br(esc($row['content'])); ?></div>
    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$row['user_id']): ?>
      <p>
        <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a> |
        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this post?')">Delete</a>
      </p>
    <?php endif; ?>
  </article>
<?php endwhile; ?>

<?php include 'footer.php'; ?>
