<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand text-white" href="<?= BASE_URL . "home" ?>">Zentalk</a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav"
                aria-label="Expand Navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <form action="<?= BASE_URL . "post" ?>" method="GET" role="search"
                  class="input-group custom-width mt-3 mt-lg-0">
                <input class="form-control me-2" name="q" type="search" placeholder="Search" aria-label="Search">
            </form>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="<?= BASE_URL . "post" ?>" class="nav-link text-white">Posts</a>
                </li>
                <?php if (isset($_SESSION["user"])): ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL . "post/add" ?>" class="nav-link text-white">Publish</a>
                    </li>
                <?php endif; ?>
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
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL . "home" ?>">My profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL . "user/favourites" ?>">Favourites</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL . "user/logout" ?>">Logout</a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>