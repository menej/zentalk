<?php
/**
 * @var array $errors
 */
?>

<?php include(INC_URL . "header.php") ?>

<title>Document</title>

<body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>


<?php if($errors["incorrect"]): ?>
<p class="text-danger"><?= $errors["incorrect"] ?></p>

<?php endif; ?>

<form action="<?= BASE_URL . "user/login" ?>" method="POST">
    <label for="username">Username:
        <input id="username" type="text" name="username" autocomplete="off" required autofocus>
        <span class="text-danger"><?= $errors["username"] ?></span>
    </label><br>
    <label for="password">Password:
        <input id="password" type="password" name="password" required>
        <span class="text-danger"><?= $errors["password"] ?></span>
    </label><br>
    <button>Login in</button>
</form>

<a href="">Forgot password</a>
<a href="<?= BASE_URL . "user/register" ?>">New user</a>


</body>
