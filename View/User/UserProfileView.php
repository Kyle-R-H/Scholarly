<!DOCTYPE html>
<html>

<head>
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/css/Styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="py-3 ps-4 pe-5 border-bottom">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-center">
                <img class="pt-1 px-3" src="Public\Images\scholarly logo.png" alt="Scholarly Logo" height="40" width="auto">
                <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li><a href="?controller=user&action=restaurantView" class="nav-link px-2 link-body-emphasis">Restaurants</a></li>
                    <li><a href="?controller=user&action=servicesView" class="nav-link px-2 link-body-emphasis">Services</a></li>
                    <li><a href="?controller=user&action=eventsView" class="nav-link px-2 link-body-emphasis">Events</a></li>
                    <li><a href="?controller=user&action=activitiesView" class="nav-link px-2 link-body-emphasis">Activities</a></li>
                </ul>

                <!-- Messages and Reviews Section -->
                <ul class="nav col-lg-auto justify-content-center">
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="22" height="22" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M160 32a104 104 0 1 1 0 208 104 104 0 1 1 0-208zm320 0a104 104 0 1 1 0 208 104 104 0 1 1 0-208zM0 416c0-70.7 57.3-128 128-128l64 0c70.7 0 128 57.3 128 128l0 16c0 26.5-21.5 48-48 48L48 480c-26.5 0-48-21.5-48-48l0-16zm448 64c-38.3 0-72.7-16.8-96.1-43.5c.1-1.5 .1-3 .1-4.5l0-16c0-34.9-11.2-67.1-30.1-93.4c5.8-20 24.2-34.6 46.1-34.6l224 0c26.5 0 48 21.5 48 48l0 16c0 70.7-57.3 128-128 128l-64 0z" />
                            </svg>
                        </a>
                    </li>

                    <li><a href="?controller=user&action=reviewView" class="nav-link link-body-emphasis">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="22" height="22" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                            </svg>
                        </a></li>
                </ul>


                <!-- Profile and Dropdown Section -->
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle p-2 ms-1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="Public\Images\default_pfp_128.png" class="border" height="34" width="34" alt="pfp" style="border-radius: 50%;">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="?controller=user&action=profile">Profile</a></li>
                        <li><a class="dropdown-item" href="?controller=user&action=settings">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="?controller=auth&action=logout">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Layout -->
    <div class="container-fluid d-flex flex-grow-1">
        <!-- Sidebar -->
        <div class="border-end d-flex flex-column p-3" style="width: 280px; min-width: 160px;">
            <ul class="nav nav-pills flex-column ">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">Temp</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link link-body-emphasis">Temp</a>
                </li>
                <!-- <li>
                    <a href="#" class="nav-link delete-account">Delete Account</a>
                </li> -->
            </ul>
        </div>

        <!-- Main Content -->
        <div class="p-3">
            <?php if ($user): ?>
                <h1><?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?></h1>

                <p class="py-3"> Email: <?php echo htmlspecialchars($user['Email']); ?> </p>

                <form method="POST" action="?controller=user&action=updateProfile">
                    <div class="row pb-4">
                        <div class="col form pr-3">
                            <label class="labels"> First name </label>
                            <input name="FirstName" type="text" class="form-control" placeholder="<?php echo htmlspecialchars($user['FirstName'])?>">
                        </div>

                        <div class="col form">
                            <label class="labels"> Last name </label>
                            <input name="LastName" type="text" class="form-control" placeholder="<?php echo htmlspecialchars($user['LastName'])?>">
                        </div>
                    </div>

                    <button type="submit" class="btn"> Save changes </button>
                </form>
            <?php else: ?>
                <p>User not found.</p>
            <?php endif; ?>
        </div>
    </div>

</html>