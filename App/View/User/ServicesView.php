<!DOCTYPE html>

<head>
    <title>View Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\..\..\public\css\Styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>


<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="py-3 ps-4 pe-5 border-bottom">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-center">
                <img class="pt-1 px-3" src="https://github.com/kylehellstrom-22343261/Scholarly/blob/main/App/scholarly%20logo.png?raw=true" alt="Scholarly Logo" height="40" width="auto">
                <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li><a href="#" class="nav-link px-2 link-secondary">Restaurants</a></li>
                    <li><a href="#" class="nav-link px-2 link-body-emphasis">Services</a></li>
                    <li><a href="#" class="nav-link px-2 link-body-emphasis">Events</a></li>
                    <li><a href="#" class="nav-link px-2 link-body-emphasis">Activities</a></li>
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

                    <li><a href="#" class="nav-link link-body-emphasis">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="22" height="22" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                            </svg>
                        </a></li>
                </ul>


                <!-- Profile and Dropdown Section -->
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle p-2 ms-1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="..\..\default_pfp_128.png" class="border" height="34" width="34" alt="pfp" style="border-radius: 50%;">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
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
                    <a href="#" class="nav-link active" aria-current="page">Restaurants</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link link-body-emphasis">Active Orders</a>
                </li>
                <li>
                    <a href="#" class="nav-link link-body-emphasis">Past Orders</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="px-5 py-3" style="width: 100%;">
            <!-- TODO: Create Services Info -->
            <div class="row p-4 pb-0 pe-lg-0 pt-lg-0 align-items-center rounded-3 border shadow-lg">
                <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
                    <h1 class=" fw-bold lh-1 text-body-emphasis">Pavilion</h1>
                    <p class="lead">The pavilion is across the living bridge near the UL student accomodation Cappavilla and Quigley.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                        <button type="button" class="btn btn-outline-secondary btn-lg px-4">Menu</button>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
                    <img class="rounded-lg-3" 
                    src="data:image/jpeg;base64,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" 
                    alt="pavillion" width="720">
                </div>
            </div>
        </div>
    </div>

</body>

<!-- Search Bar Funcitonality -->
<!-- <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
    <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
</form> -->