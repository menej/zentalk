<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand text-white" href="<?= BASE_URL . "home" ?>">Zentalk</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav"
                aria-label="Expand Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <div class="input-group custom-width mt-3 mt-lg-0">
                <input type="text" class="form-control" placeholder="Search" aria-label="Search"
                       aria-describedby="basic-addon1">
            </div>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= BASE_URL . "post" ?>" class="nav-link text-white">Posts</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION["user"])): ?>
                        <a href="<?= BASE_URL . "post/add" ?>" class="nav-link text-white">Publish</a>
                    <?php endif; ?>
                </li>
            </ul>

            <ul class="navbar-nav align-content-end ms-auto">
                <?php if (!isset($_SESSION["user"])): ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL . "user/login" ?>" class="nav-link text-white">Login</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Profile
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">My profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="<?= BASE_URL . "user/profile" ?>">Logout</a></li>
                        </ul>
                    </li>

                <?php endif; ?>
            </ul>
        </div>
    </div>

</nav>