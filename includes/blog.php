<main>
<section>
        <div class="container">
          <div class="section-head">
            <h2>Latest Blogs</h2>
            <p>Read useful guides, articles, and current scheme news.</p>
          </div>
<div class="grid-3">
<?php
require_once './db.php';
$sql = "SELECT * FROM blogs ORDER BY blog_id DESC";
$result = mysqli_query($conn, $sql);
require_once 'config/config.php';
require_once 'includes/functions.php';
while($row = mysqli_fetch_assoc($result)) {

?>


          
            <article class="card">
              <span class="tag">Blog</span>
              <h3><?php echo $row['blog_title']; ?></h3>
              <p><?php echo $row['blog_post']; ?></p>
              <a href="blog.html">Read more</a>
            </article>
          

    <?php
    }
    ?>
</div>
            </div>
      </section>
    </main>