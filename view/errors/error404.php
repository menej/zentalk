<?php
/**
 * @var string $REQUEST_URI
 */
?>

<?php include("view/inc/" . "header.php"); ?>

    <title>Error 404: Page does not exist</title>

    <body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>

<div class="container-lg my-5">
    <div class="row gy-3">
        <div class="col-12">
            <div class="p-5 bg-primary text-light text-center">
                <h1>Error 404: Page does not exist</h1>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <h2 class="fs-3">
                The page <em><?= $REQUEST_URI ?> does not exist.
            </h2>
        </div>
    </div>
</div>


<?php include(INC_URL . "footer.php") ?>