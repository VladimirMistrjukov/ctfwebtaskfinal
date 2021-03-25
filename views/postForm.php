<form action="index.php?route=index&action=post&actionType=<?php echo (!empty($post['id'])) ? 'edit&post_id=' . $post['id'] : 'add'; ?>"
      style="margin-top: 15px;"
      method="post">

    <?php if (!empty($post['id'])) : ?>
        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
    <?php endif; ?>

    <div class="row mb-3">
        <label for="input-title" class="col-sm-2 col-form-label">Название</label>
        <div class="col-sm-10">
            <input name="title" type="text" class="form-control" id="input-title"
                   placeholder="Название" value="<?php echo $post['title']; ?>">
        </div>
    </div>
    <div class="row mb-3">
        <label for="input-password" class="col-sm-2 col-form-label">Текст</label>
        <div class="col-sm-10">
                                    <textarea name="text" class="form-control"
                                              id="input-password"
                                              placeholder="Текст"><?php echo $post['text']; ?></textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>