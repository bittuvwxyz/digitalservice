<?php
require_once __DIR__ . '/../config/db.php';
$limit = 1;
$blog_page = isset($_GET['blog_page']) ? (int) $_GET['blog_page'] : 1;
if ($blog_page < 1) {
    $blog_page = 1;
}

$route_page = isset($_GET['page']) ? $_GET['page'] : 'home';
$allowed_route_pages = ['home', 'about', 'contact'];
if (!in_array($route_page, $allowed_route_pages, true)) {
    $route_page = 'home';
}
$base_url = 'blog.php?page=' . urlencode($route_page);

$total_query = "SELECT COUNT(*) as total FROM blogs";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_posts = $total_row['total'];
$total_pages = $total_posts ? (int) ceil($total_posts / $limit) : 1;
$offset = ($blog_page - 1) * $limit;

$sql = "SELECT * FROM blogs ORDER BY blog_id DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql);
?>

<main>
    <section>
        <div class="container">
            <div class="section-head">
                <h2>Blogs</h2>
                <p>Explore the most viewed and popular articles trusted by thousands of readers and developers.</p>
            </div>

            <div class="grid-3">
                <?php if ($result && mysqli_num_rows($result) > 0) : ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <article class="card">
                            <span class="tag">Blog</span>
                            <h3><a href="post.php?blog_id=<?php echo urlencode($row['blog_id']); ?>"><?php echo htmlspecialchars($row['blog_title'], ENT_QUOTES, 'UTF-8'); ?></a></h3>
                            <p><?php echo htmlspecialchars($row['blog_short_description'] ?? $row['blog_post'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <a href="post.php?blog_id=<?php echo urlencode($row['blog_id']); ?>">Read more</a>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No blog posts found.</p>
                <?php endif; ?>
            </div>

            <div class="pagination">
                <?php if ($blog_page > 1) : ?>
                    <a href="<?php echo $base_url . '&blog_page=' . ($blog_page - 1); ?>">Prev</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a href="<?php echo $base_url . '&blog_page=' . $i; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($blog_page < $total_pages) : ?>
                    <a href="<?php echo $base_url . '&blog_page=' . ($blog_page + 1); ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
