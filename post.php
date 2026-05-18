<?php
require_once 'db.php';
require_once 'config/config.php';
require_once 'includes/functions.php';
$page = $_GET['page'] ?? 'home';

$allowed_pages = [
    'home',
    'about',
    'contact'
];

if (!in_array($page, $allowed_pages)) {
    $page = '404';
}

require_once 'includes/header.php';

// Get blog_id from query parameters
$blog_id = 0;
$allowed_ids = ['blog_id', 'id', 'post_id'];
foreach ($allowed_ids as $key) {
    $value = filter_input(INPUT_GET, $key, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1]
    ]);
    if ($value !== false && $value !== null) {
        $blog_id = $value;
        break;
    }
}

if ($blog_id <= 0) {
    header('Location: blog.php');
    exit;
}
$query = "SELECT * FROM blogs WHERE blog_id = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $blog_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) == 0) {
    die("Blog post not found");
}
$row = mysqli_fetch_assoc($result);
$update = mysqli_prepare($conn,"UPDATE blogs SET blog_views = blog_views + 1 WHERE blog_id = ?");
mysqli_stmt_bind_param($update,"i",$row['blog_id']);
mysqli_stmt_execute($update);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($row['blog_title']); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($row['blog_short_description']); ?>" >
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($row['blog_title']); ?></h1>
        <p> <?php echo nl2br(htmlspecialchars($row['blog_post'])); ?></p>
        <p><strong>Category:</strong><?php echo htmlspecialchars($row['blog_category']); ?></p>
        <p><strong>Author:</strong><?php echo htmlspecialchars($row['blog_author']); ?></p>
        <p><strong>Views:</strong><?php echo $row['blog_views']; ?></p>
    </div>
</body>
</html>

<?php require_once 'includes/footer.php'; ?>