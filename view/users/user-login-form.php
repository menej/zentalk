<?php
/**
 * @var array $errors
 */
?>

<?php include(INC_URL . "header.php") ?>

<title>Login</title>

<body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>


<?php if ($errors["incorrect"]): ?>
    <p class="text-danger"><?= $errors["incorrect"] ?></p>
<?php endif; ?>


<div class="container-lg my-5">
    <form action="<?= BASE_URL . "user/login" ?>" method="POST">
        <div class="form-floating mb-5">
            <input type="text" id="username" name="username" class="form-control" placeholder="Place username here" required autofocus>
            <label for="username" class="form-label">Username</label>
        </div>

        <div class="form-floating mb-5">
            <input type="password" id="password" name="password" class="form-control" placeholder="Place password here" required>
            <label for="password" class="form-label">Password</label>
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary btn-outline-light fs-5">Login</button>
        </div>
        <!--
    <label for="username">Username:
        <input id="username" type="text" name="username" autocomplete="off" required autofocus>
        <span class="text-danger"><?= $errors["username"] ?></span>
    </label><br>
    <label for="password">Password:
        <input id="password" type="password" name="password" required>
        <span class="text-danger"><?= $errors["password"] ?></span>
    </label><br>
    <button>Login in</button>
     -->
    </form>

    <div class="row mt-4">
        <div class="col-sm-6 col-12 text-sm-end">
            <a href="" class="fs-5 link-success">Forgot password</a>
        </div>
        <div class="col-sm-6 col-12 text-sm-start">
            <a href="<?= BASE_URL . "user/register" ?>" class="fs-5 link-success">New user</a>
        </div>
    </div>
</div>

<?php include(INC_URL . "footer.php") ?>