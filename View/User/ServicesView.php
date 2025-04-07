<!DOCTYPE html>
<html lang="en">

<head>
    <title>Services</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/Styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="py-3 ps-4 pe-5 border-bottom">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-center">
                <img class="pt-1 px-3" src="Public/Images/scholarly logo.png" alt="Scholarly Logo" height="40" width="auto">
                <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li><a href="?controller=user&action=restaurantView" class="nav-link px-2 link-body-emphasis">Restaurants</a></li>
                    <li><a href="?controller=user&action=servicesView" class="nav-link px-2 link-secondary">Services</a></li>
                    <li><a href="?controller=user&action=eventsView" class="nav-link px-2 link-body-emphasis">Events</a></li>
                    <li><a href="?controller=user&action=activitiesView" class="nav-link px-2 link-body-emphasis">Activities</a></li>
                </ul>
                <ul class="nav col-lg-auto justify-content-center">
                    <li>
                        <a href="?controller=user&action=userMessagesView" class="nav-link link-body-emphasis">
                            <!-- icon omitted for brevity -->
                        </a>
                    </li>
                    <li>
                        <a href="?controller=user&action=reviewView" class="nav-link link-body-emphasis">
                            <!-- icon omitted for brevity -->
                        </a>
                    </li>
                </ul>
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle p-2 ms-1" data-bs-toggle="dropdown">
                        <img src="Public/Images/default_pfp_128.png" class="border" height="34" width="34" alt="pfp" style="border-radius: 50%;">
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

    <!-- Layout -->
    <div class="container-fluid d-flex flex-grow-1">
        <!-- Sidebar -->
        <div class="border-end d-flex flex-column p-3" style="width: 280px; min-width: 160px;">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">Services</a>
                </li>
                <li class="nav-item">
                    <a href="?controller=user&action=historyView" class="nav-link link-body-emphasis">Order History</a>
                </li>
                <hr>
                <!-- Filter + Search -->
                <form method="POST" action="?controller=user&action=servicesView">
                    <!-- Search input -->
                    <div class="mb-3">
                        <input type="search" class="form-control" name="search" placeholder="Search..."
                            value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>">
                    </div>
                    <hr>
                    <!-- Rating filter -->
                    <div class="mb-3">
                        <label for="minRating" class="form-label">
                            Minimum Rating: <span id="minRatingValue"><?= isset($_POST['minRating']) ? htmlspecialchars($_POST['minRating']) : '0' ?></span> ⭐
                        </label>
                        <input type="range" class="form-range" id="minRating" name="minRating" min="0" max="5" step="0.5"
                            value="<?= isset($_POST['minRating']) ? htmlspecialchars($_POST['minRating']) : '0' ?>"
                            oninput="document.getElementById('minRatingValue').innerText = this.value;">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="?controller=user&action=servicesView&all=true" class="btn btn-secondary">Clear</a>
                    </div>
                </form>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="px-5 py-3" style="width: 100%;">
            <?php
            if (isset($_POST['search']) && $_POST['search'] !== '') {
                $searchTerm = strtolower(trim($_POST['search']));
                $services = array_filter($services, fn($s) => str_contains(strtolower($s['BusinessName']), $searchTerm));
            }

            if (isset($_POST['minRating']) && !isset($_GET['all'])) {
                $minRating = floatval($_POST['minRating']);
                $services = array_filter($services, fn($s) => $s['Rating'] >= $minRating);
            }
            ?>

            <?php foreach ($services as $service): ?>
                <div class="row px-4 pe-lg-0 align-items-center rounded-3 border shadow-lg mb-4">
                    <div class="col-lg-7 p-5 p-lg-5">
                        <h1 class="display-5 fw-bold lh-1 text-body-emphasis">
                            <?= htmlspecialchars($service['BusinessName']) ?>
                            <span class="fs-4 text-muted d-inline-block" style="white-space: nowrap;">
                                <?= number_format($service['Rating'], 1) ?> ⭐
                            </span>
                        </h1>
                        <p class="lead"><?= htmlspecialchars($service['Description']) ?></p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                            <a href="<?= '?controller=user&action=bookingView&businessName=' . urlencode($service['BusinessName']) ?>">
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
        </div>
    </div>
</body>

</html>