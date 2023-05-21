<?php
/**
 * @var array $post
 */
?>

<?php include("view/inc/" . "header.php"); ?>

<title>Main menu</title>

<body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>


<div class="container-lg my-4">
    <div class="row mb-4">
        <div class="col-12 bg-primary">
            <p class="lead text-white display-6 p-3 text-center fw-normal"><?= $post["title"] ?></p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <ul class="list-group list-group-horizontal d-flex">
                <?php if (!empty($_SESSION["user"]) && $_SESSION["user"]["uid"] === $post["uid"]): ?>
                    <li class="list-group-item d-flex align-items-center">
                        <a href="<?= BASE_URL . "post/edit?pid=" . $post["pid"] ?>"
                           class="text-decoration-none">Edit</a>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <a href="<?= BASE_URL . "post/delete?pid=" . $post["pid"] ?>"
                           class="text-decoration-none">Remove</a>
                    </li>
                <?php endif; ?>
                <?php if (!empty($_SESSION["user"])): ?>
                    <form action="<?= BASE_URL . "favourite/add" ?>" class="list-group-item" method="POST">
                        <input type="hidden" name="pid" value="<?= $post["pid"] ?>">
                        <button class="btn text-primary">Favourite</button>
                    </form>
                    <li class="list-group-item ms-auto border-start d-flex align-items-center">
                        <p class="mb-0">▼</p>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        0
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <p class="mb-0">▲</p>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="row border-bottom">
        <div class="col-lg-8 col-12">
            <p class="lead fw-bold fs-4">By: <?= $post["user"]["username"] ?></p>
        </div>
        <div class="col-lg-4 col-12">
            <p class="lead fw-bold fs-4 text-lg-end"><span class="d-lg-none">Published: </span><?= $post["post_date"] ?>
            </p>
        </div>
    </div>

    <div class="row mt-3 border-bottom">
        <div class="col-12">
            <p class="fs-5"><?= $post["content"] ?></p>
        </div>
    </div>
</div>


<?php include(INC_URL . "footer.php") ?>