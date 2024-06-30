<?php include 'header.php'; ?>
<?php include 'config.php'; ?>
<div class="container mt-4">
    <h2>Aktualności</h2>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <form action="process_add_post.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Tytuł:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Treść:</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Zdjęcie:</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Dodaj post</button>
        </form>
    <?php endif; ?>
    <div class="posts mt-4">
        <?php
        $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="card dark-mode-toggle" id="posty_blog">';
                if (!empty($row['image'])) {
                    echo '<img src="images/' . htmlspecialchars($row['image']) . '" class="card-img-top" alt="..." style="width: 550px; display: block; margin: 0 auto;">';
                }
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
                echo '<p class="card-text">' . htmlspecialchars($row['content']) . '</p>';
                echo '<p class="card-text"><small class="text-muted">Opublikowane: ' . htmlspecialchars($row['created_at']) . '</small></p>';

                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                    echo '<a href="edit_post.php?id=' . $row['id'] . '" class="btn btn-warning">Edytuj</a>';
                    echo '<button class="btn btn-danger" onclick="confirmDelete(' . $row['id'] . ')">Usuń</button>';
                }

                echo '</div></div>';
            }
        } else {
            echo "<p>Brak postów.</p>";
        }
        ?>
    </div>
</div>
<script>
function confirmDelete(postId) {
    if (confirm("Czy na pewno chcesz usunąć ten post?")) {
        window.location.href = 'delete_post.php?id=' + postId;
    }
}
</script>
<?php include 'footer.php'; ?>