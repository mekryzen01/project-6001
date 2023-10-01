<nav class="navbar navbar-expand-lg bg-secondary ">
    <ul class="navbar-nav">
        <li class="nav-item"><button id="toggleSidebar" class="btn">
                <i class="fas fa-bars" style="font-size: 20px;"></i>
            </button>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item"><img src="" alt="imageUser" id="imageUser" class="brand-image img-circle elevation-3" style="opacity: .8"> </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="fullnameNav">
            </a>
            <ul class="dropdown-menu">
                <li> <a class="dropdown-item" style="font-size: 16px;" href="http://localhost/project-6001/pages/profile">
                        <i class="fa-solid fa-user"></i><span class="menu-text"> Profile</span>
                    </a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a href="#" class="dropdown-item" style="font-size: 16px;" onclick="Logout()">
                        <i class="fa-solid fa-sign-out spani"></i><span class="menu-text">Logout</span>
                    </a></li>
            </ul>
        </li>
    </ul>
</nav>