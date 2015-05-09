<form method="post" class="col-md-8 col-md-offset-4">
    <div class="form-group">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" class="form-control">
    </div>
    <div class="form-group">
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <input type="hidden" name="form-token" value="<?= $_SESSION['form-token'] ?>">
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </div>
</form>
