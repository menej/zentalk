<nav class="navbar navbar-expand-md bg-body-tertiary bg-accent">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav justify-content-center mb-2 mb-lg-0">
                <li class="nav-item">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn text-white bg-dark" type="submit">Search</button>
                    </form>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL . "post" ?>" class="nav-link text-white">Posts</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION["user"])): ?>
                        <a href="<?= BASE_URL . "user/profile" ?>" class="nav-link text-white">Profile</a>
                    <?php else : ?>
                        <a href="<?= BASE_URL . "user/login" ?>" class="nav-link text-white">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>