<!DOCTYPE html>

<head>
    <title>Dashboard</title>
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
                    <li><a href="?controller=business&action=businessDashboardView" class="nav-link px-2 link-secondary">Dashboard</a></li>
                    <li><a href="?controller=business&action=businessSettingsView" class="nav-link px-2 link-body-emphasis">Business Management</a></li>
                </ul>


                <!-- Profile and Dropdown Section -->
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle p-2 ms-1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="Public\Images\default_pfp_128.png" class="border" height="34" width="34" alt="pfp" style="border-radius: 50%;">
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="?controller=business&action=profile">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="?controller=auth&action=logout">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container-fluid d-flex flex-grow-1 px-5 py-3" style="width: 100%;">
        <!-- <?php foreach ($restaurants as $restaurant): ?>
            <div class="row px-4 pe-lg-0 align-items-center rounded-3 border shadow-lg">
                <div class="col-lg-7 p-5 p-lg-5">
                    <h1 class="display-5 fw-bold lh-1 text-body-emphasis"><?= htmlspecialchars($restaurant['BusinessName']) ?></h1>
                    <p class="lead"><?= htmlspecialchars($restaurant['Description']) ?></p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                        <a href="<?= '?controller=business&action=bookingView&businessName=' . htmlspecialchars($restaurant['BusinessName'])?>">
                            <button type="button" class="btn btn-lg px-4">Menu</button>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
                    <img class="rounded-lg-3" src="<?= htmlspecialchars($restaurant['Image']) ?>" alt="" height="320">
                </div>
            </div>
            <hr>
        <?php endforeach; ?> -->
    </div>
</body>

