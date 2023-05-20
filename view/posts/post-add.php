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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>
</body>