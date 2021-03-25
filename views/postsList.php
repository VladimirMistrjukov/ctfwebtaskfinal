<?php if (!empty($posts)) : ?>
    <div class="container" style="margin-top: 15px;">
        <?php foreach ($posts as $post) : ?>
            <div class="card text-left" style="margin-top: 10px;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $post['title']; ?></h5>
                    <p class="card-text"><?php echo $post['text']; ?></p>
                </div>
                <div class="card-footer text-muted">
                    Автор <?php echo $post['login']; ?>
                    <?php if ($post['user_id'] == $user['id']) : ?>
                        <br>
                        <a href="index.php?route=index&action=post&actionType=edit&post_id=<?php echo $post['id']; ?>"
                           class="btn btn-primary">Редактировать</a>
                        <a href="index.php?route=index&action=post&actionType=delete&post_id=<?php echo $post['id']; ?>"
                           class="btn btn-warning">Удалить</a>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>