<form action="index.php?route=index&action=login" style="margin-top: 15px;"
      method="post">
    <div class="row mb-3">
        <label for="input-login" class="col-sm-2 col-form-label">Логин</label>
        <div class="col-sm-10">
            <input name="login" type="text" class="form-control" id="input-login"
                   placeholder="Логин">
        </div>
    </div>
    <div class="row mb-3">
        <label for="input-password" class="col-sm-2 col-form-label">Пароль</label>
        <div class="col-sm-10">
            <input name="password" type="password" class="form-control"
                   id="input-password" placeholder="Пароль">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Войти</button>
</form>