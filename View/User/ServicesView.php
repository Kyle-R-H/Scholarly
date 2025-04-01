<!DOCTYPE html>

<head>
    <title>Services</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public\css\Styles.css">
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
                    <li><a href="?controller=user&action=servicesView" class="nav-link px-2 link-secondary">Services</a></li>
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
        <div class="border-end d-flex flex-column p-3" style="width: 280px;">
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">Services</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link link-body-emphasis">Active Bookings</a>
                </li>
                <li>
                    <a href="#" class="nav-link link-body-emphasis">Past Bookings</a>
                </li>
                <hr>
                <!-- Search Bar Functionality -->
                <form method="POST" role="search">
                    <input type="hidden" name="controller" value="user">
                    <input type="hidden" name="action" value="restaurantView">
                    <input type="search" class="form-control" name="search" placeholder="Search..."
                        value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                </form>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="px-5 py-3" style="width: 100%;">
            <?php foreach ($services as $service): ?>
                <div class="row px-4 pe-lg-0 align-items-center rounded-3 border shadow-lg">
                    <div class="col-lg-7 p-5 p-lg-5">
                        <h1 class="display-5 fw-bold lh-1 text-body-emphasis"><?= htmlspecialchars($service['BusinessName']) ?></h1>
                        <p class="lead"><?= htmlspecialchars($service['Description']) ?></p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                            <a href="<?= '?controller=user&action=bookingView&businessName=' . htmlspecialchars($service['BusinessName']) ?>">
                                <button type="button" class="btn btn-lg px-4">Menu</button>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
                        <img class="rounded-lg-3" src="<?= htmlspecialchars($service['Image']) ?>" alt="" height="320">
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>



            <!-- TODO: Create Services Info
            <div class="row px-4 pe-lg-0 align-items-center rounded-3 border shadow-lg">
                <div class="col-lg-7 p-5 p-lg-5">
                    <h1 class="display-5 fw-bold lh-1 text-body-emphasis">House Cleaning</h1>
                    <p class="lead">UL House Cleaning allows the quick booking of a range of cleaning services to make the predrinks look like they never happened.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                        <button type="button" class="btn  btn-lg px-4">Book</button>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
                    <img class="rounded-lg-3" src="https://studyireland.ie/wp-content/uploads/2024/04/living-room-thomond-2.jpg" 
                    alt="" height="320" width="auto" >
                </div>
            </div>

            <hr>
            <div class="row px-4 pe-lg-0 align-items-center rounded-3 border shadow-lg">
                <div class="col-lg-7 p-5 p-lg-5">
                    <h1 class="display-5 fw-bold lh-1 text-body-emphasis">Bike Hire</h1>
                    <p class="lead">Places to go? Get there with UL Bike Hire. Book a bike and explore.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                        <button type="button" class="btn  btn-lg px-4">Book</button>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg" >
                    <img class="rounded-lg-3 flex" src="https://assets-eu-01.kc-usercontent.com/aa24ba70-9a12-01ae-259b-7ef588a0b2ef/1083fb38-ecbb-4411-8ad3-8eff07c2ffa8/carlingford-greenway-bicycle-hire-shop-front.jpg?w=1332&q=66&h=750&fit=crop&fm=jpg" 
                    alt="" height="320" >
                </div>
            </div> -->
        </div>
    </div>

</body>

<!-- Search Bar Funcitonality -->
<!-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
</form> -->