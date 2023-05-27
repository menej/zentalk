<?php
/**
 * @var array $data
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
                <input type="text" id="email" name="email" value="<?= $data["email"] ?>" class="form-control" placeholder="Place email here"
                       autofocus required>
                <label for="email" class="form-label">Email</label>
                <span class="text-danger"><?= $errors["email"] ?></span><br>
            </div>

            <div class="form-floating mb-5">
                <input type="text" id="username" name="username" value="<?= $data["username"] ?>" class="form-control" placeholder="Place username here" required>
                <label for="username" class="form-label">Username</label>
                <span class="text-danger"><?= $errors["username"] ?></span><br>
            </div>

            <div class="form-floating mb-5">
                <input type="password" id="password" name="password" class="form-control" placeholder="Place password here" required>
                <label for="password" class="form-label">Password</label>
                <span class="text-danger"><?= $errors["password"] ?></span><br>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 form-floating mb-5 ">
                    <input type="text" id="first-name" name="first_name" value="<?= $data["first_name"] ?>" class="form-control"
                           placeholder="Place first name here" required>
                    <label for="first-name" class="form-label ms-3">First name</label>
                    <span class="text-danger"><?= $errors["first_name"] ?></span><br>

                </div>
                <div class="col-12 col-lg-6 form-floating mb-5">
                    <input type="text" id="last-name" name="last_name" value="<?= $data["last_name"] ?>" class="form-control"
                           placeholder="Place last name here" required>
                    <label for="last-name" class="form-label ms-3">Last name</label>
                    <span class="text-danger"><?= $errors["last_name"] ?></span>
                </div>
            </div>

            <?php if (isset($errors["error_message"])): ?>
                <p class="text-danger fs-5 mb-4"><?= $errors["error_message"] ?></p>
            <?php endif; ?>

            <div class="d-grid gap-2">
                <button class="btn btn-primary btn-outline-light fs-5">Register</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let passwordInput = document.querySelector("#password");
            new bootstrap.Popover(passwordInput, {
                content: "Password length should be at least 8, contain a minimum of 1 uppercase letter, 1 special character and 1 number.",
                trigger: "focus",
                placement: "bottom"
            });
        });
    </script>

<?php include(INC_URL . "footer.php") ?>