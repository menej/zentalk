<?php
/**
 * @var array $errors
 */
?>

<?php include(INC_URL . "header.php") ?>

<title>Register</title>

<body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>


<div class="container-lg my-5">
    <h1 class="mb-5">Make an account</h1>

    <form action="<?= BASE_URL . "user/register" ?>" method="POST">
        <div class="form-floating mb-5">
            <input type="email" id="email" name="email" class="form-control" placeholder="Place email here" required autofocus>
            <label for="email" class="form-label">Email</label>
        </div>

        <div class="form-floating mb-5">
            <input type="text" id="username" name="username" class="form-control" placeholder="Place username here" required>
            <label for="username" class="form-label">Username</label>
        </div>

        <div class="form-floating mb-5">
            <input type="password" id="password" name="password" class="form-control" placeholder="Place password here" required>
            <label for="password" class="form-label">Password</label>
        </div>

        <div class="row">
            <div class="col form-floating mb-5 ">
                <input type="text" id="first-name" name="first_name" class="form-control" placeholder="Place first name here" required>
                <label for="first-name" class="form-label ms-3">First name</label>
            </div>
            <div class="col form-floating mb-5">
                <input type="text" id="last-name" name="last_name" class="form-control" placeholder="Place last name here" required>
                <label for="last-name" class="form-label ms-3">Last name</label>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary btn-outline-light fs-5">Register</button>
        </div>
    </form>
</div>

<?php include(INC_URL . "footer.php") ?>