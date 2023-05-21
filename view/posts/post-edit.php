<?php
/**
 * @var array $post
 * @var array $errors
 */
?>

<?php include("view/inc/" . "header.php"); ?>

<title>Main menu</title>

<body id="bootstrap-overrides">

<?php include(INC_URL . "navbar.php"); ?>


<div class="container-lg my-4">

    <div class="row">
        <div class="col-12">
            <h1>Edit the post</h1>
        </div>
    </div>


    <!--suppress DuplicatedCode -->
    <form action="<?= BASE_URL . "post/edit" ?>" method="POST">
        <input type="hidden" name="pid" value="<?= $post["pid"] ?>">
        <div class="form-group mb-3">
            <label for="title" class="form-label fs-5">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $post["title"] ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="content" class="form-label fs-5">Content</label>
            <textarea class="form-control" name="content" id="content" rows="10"
                      required><?= $post["content"] ?></textarea>
        </div>
        <div class="d-grid gap-2 d-md-block">
            <button class="btn btn-primary btn-lg btn-outline-light">Edit</button>
            <a class="btn btn-danger btn-lg btn-outline-light" href="<?= BASE_URL . "post?pid=" . $post["pid"] ?>">Cancel</a>
        </div>

    </form>
</div>

<?php include(INC_URL . "footer.php") ?>