<?php
/**
 * @var array $posts
 */
?>

<?php include(INC_URL . "header.php") ?>

<title>All posts</title>

<body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>

<div class="container-lg my-5">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-3 border-bottom">Check out all of the posts</h1>
        </div>
    </div>

    <?php foreach ($posts as $post): ?>
        <div data-url="post/detail?pid=<?= $post["pid"] ?>" class="row mb-4 clickable-div user-select-none">
            <div class="col-2 bg-secondary d-flex align-items-center">
                <p class="fs-4 fw-bold my-auto"><?= $post["user"]["username"] ?></p>
            </div>
            <div class="col-10 bg-primary ">
                <p class="fs-4 text-white my-auto"><?= $post["title"] ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="<?= JS_URL . "clickable-div.js" ?>"></script>

<?php include(INC_URL . "footer.php") ?>


