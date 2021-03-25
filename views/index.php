<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Блоги</title>
</head>
<body>
<div class="container">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php?route=index">Блоги</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="index.php?route=index">Главная</a>
                        <a class="nav-link" aria-current="page" href="index.php?route=index&action=logout">Выход</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container" style="margin-top: 20px;">
            <div class="col-md-12">
                <?php if (!empty($alert)) : ?>
                    <div class="alert alert-<?php echo $alert['type']; ?>"
                         style="margin-bottom: 15px;"><?php echo $alert['text']; ?></div>
                <?php endif; ?>

                <?php if (!empty($user['id'])) : ?>
                    <div class="container">
                        <?php if (empty($post['id'])) : ?>
                            <h2 style="margin-bottom: 10px;">Добавить свой пост</h2>

                            <?php include __DIR__ . "/postForm.php"; ?>
                            <?php include __DIR__ . "/postsList.php"; ?>
                        <?php else : ?>
                            <?php include __DIR__ . "/editPost.php"; ?>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="alert alert-warning">Для просмотра постов войдите или зарегистрируйтесь</div>

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Вход</h2>

                                <?php include __DIR__ . "/loginForm.php"; ?>
                            </div>
                            <div class="col-md-6">
                                <h2>Регистрация</h2>

                                <?php include __DIR__ . "/registerForm.php"; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <footer class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-12 text-center">Блоги &copy; 2021</div>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>

</body>
</html>