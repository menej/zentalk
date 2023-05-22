<?php
/**
 * @var array $posts
 */
?>

<?php include("view/inc/" . "header.php"); ?>

<title>Main menu</title>

<body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>

<div class="container-lg my-5">
    <div class="row gy-3">
        <div class="col-12">
            <div class="p-5 bg-primary text-light"></div>
        </div>
    </div>
</div>

<div class="container-lg my-5 ">
    <div class="row">
        <div class="col-12">
            <h2 class="text-center display-1">Every <strong>calm person</strong> has a tab open to <strong>Zen
                    Talk</strong></h2>
        </div>
    </div>
</div>

<div class="container-lg my-5">
    <div id="one" class="row">
        <div class="col-12 bg-primary mb-4">
            <p class="lead text-white display-6 p-3 text-center">Check out some of the latest posts</p>
        </div>
    </div>

    <?php foreach ($posts as $post): ?>
        <div id="two" data-url="post/detail?pid=<?= $post["pid"] ?>" class="row mb-4 clickable-div user-select-none">
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