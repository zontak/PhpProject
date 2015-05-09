<form method="post" class="col-md-8 col-md-offset-4">
    <div class="form-group">
        <label for="password">Current password: </label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <div class="form-group">
        <label for="new-password">New password: </label>
        <input type="password" name="new-password" id="new-password" class="form-control">
    </div>
    <div class="form-group">
        <label for="new-password-confirm">Confirm new password: </label>
        <input type="password" name="new-password-confirm" id="new-password-confirm" class="form-control">
    </div>
    <input type="hidden" name="form-token" value="<?= $_SESSION['form-token'] ?>">
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">Change Password</button>
    </div>
</form>
