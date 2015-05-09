<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="/content/styles.css">
    <script src="https://code.jquery.com/jquery-2.1.4.min.js" defer></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" defer></script>
    <title><?= htmlspecialchars($this->title) ?></title>
</head>

<body>
<div class="container well">
<div class="col-md-10 col-md-offset-1">
    <header>
        <ul class="nav navbar-nav navbar-default navbar col-md-12">
            <li><a href="/">Home</a></li>
            <?php if ($this->isAdmin()): ?>
            <li><a href="/posts/add">New Post</a></li>
            <?php endif; if ($this->isLoggedIn()): ?>
            <li class="navbar-right">
                <a href="/users/logout">Logout (<strong><?= htmlspecialchars($_SESSION['username']) ?></strong>)</a>
            </li>
            <li class="navbar-right"><a href="/users/changePassword">Change Password</a></li>
            <?php else: ?>
            <li><a href="/users/login">Login</a></li>
            <li><a href="/users/register">Register</a></li>
            <?php endif; ?>
        </ul>
        <?php include_once('messages.php'); ?>
        <h1 class="text-center col-md-12"><?= htmlspecialchars(urldecode($this->title)) ?></h1>
    </header>

    <div class="row">
    <main class="col-md-9">
