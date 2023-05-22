<?php
/**
 * @var array $post
 */
?>

<?php include("view/inc/" . "header.php"); ?>

<title>Add a new post</title>

<body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>


<div class="container-lg my-4">

    <div class="row">
        <div class="col-12">
            <h1>Add new post</h1>
        </div>
    </div>


    <!--suppress DuplicatedCode -->
    <form action="<?= BASE_URL . "post/add" ?>" method="POST">
        <div class="form-group mb-3">
            <label for="title" class="form-label fs-5">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group mb-3">
            <label for="content" class="form-label fs-5">Content</label>
            <textarea class="form-control" name="content" id="content" rows="10" required></textarea>
        </div>
        <button class="btn-primary btn-lg btn-outline-light">Publish</button>
    </form>
</div>


<?php include(INC_URL . "footer.php") ?>