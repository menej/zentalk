<?php
/**
 * @var array $data
 * @var array $errors
 */
?>

<?php include(INC_URL . "header.php") ?>

<title>Login</title>

<body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>


<div class="container-lg my-5">
    <form action="<?= BASE_URL . "user/login" ?>" method="POST">
        <div class="form-floating mb-5">
            <input type="text" id="username" name="username" class="form-control" placeholder="Place username here"
                   autofocus>
            <label for="username" class="form-label">Username</label>
            <span class="text-danger"><?= $errors["username"] ?></span>
        </div>
        <div class="form-floating mb-4">
            <input type="password" id="password" name="password" class="form-control"
                   placeholder="Place password here">
            <label for="password" class="form-label">Password</label>
            <span class="text-danger"><?= $errors["password"] ?></span>
        </div>
        <?php if (isset($errors["errorMessage"])): ?>
            <p class="text-danger fs-5 mb-4"><?= $errors["errorMessage"] ?></p>
        <?php endif; ?>
        <div class="d-grid gap-2">
            <button class="btn btn-primary btn-outline-light fs-5">Login</button>
        </div>
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