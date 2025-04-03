<!DOCTYPE html>

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public\css\Styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>


<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header class="py-3 ps-4 pe-5 border-bottom">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-center">
                <img class="pt-1 px-3" src="Public\Images\scholarly logo.png" alt="Scholarly Logo" height="40" width="auto">
                <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li><a href="?controller=business&action=dashboard" class="nav-link px-2 link-secondary">Dashboard</a></li>
                    <li><a href="?controller=business&action=businessManager" class="nav-link px-2 link-body-emphasis">Business Management</a></li>
                </ul>

                <!-- Messages and Reviews Section -->
                <ul class="nav col-lg-auto justify-content-center">
                    <li>
                        <a href="?controller=business&action=businessMessagesView" class="nav-link link-body-emphasis">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="22" height="22" fill="currentColor"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M160 32a104 104 0 1 1 0 208 104 104 0 1 1 0-208zm320 0a104 104 0 1 1 0 208 104 104 0 1 1 0-208zM0 416c0-70.7 57.3-128 128-128l64 0c70.7 0 128 57.3 128 128l0 16c0 26.5-21.5 48-48 48L48 480c-26.5 0-48-21.5-48-48l0-16zm448 64c-38.3 0-72.7-16.8-96.1-43.5c.1-1.5 .1-3 .1-4.5l0-16c0-34.9-11.2-67.1-30.1-93.4c5.8-20 24.2-34.6 46.1-34.6l224 0c26.5 0 48 21.5 48 48l0 16c0 70.7-57.3 128-128 128l-64 0z" />
                            </svg>
                        </a>
                    </li>
                    <li><a href="?controller=business&action=responseToReview" class="nav-link link-body-emphasis">
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
    <main class="container-fluid px-5 py-3">
        <?php if (!empty($_SESSION['error'])) : ?>
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
                <div id="errorToast" class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?php echo $_SESSION['error'] ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"><?php unset($_SESSION['error']) ?></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['success'])) : ?>
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
                <div id="successToast" class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?php echo $_SESSION['success'] ?>
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"><?php unset($_SESSION['success']) ?></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2"><?php echo "Dashboard | " . htmlspecialchars($businessName) ?></h1>
        </div>

        <canvas class="my-4 w-100" id="myChart" style="display: block; box-sizing: border-box; height: 378px; width: 895px;"></canvas>

        <!-- TODO: Complete script to work with our database -->
        <script>
            // Fetch PHP data and convert it to JavaScript arrays
            var price = <?php echo json_encode(array_column($stats, 'OrderPrice')); ?>;
            var timeOfOrder = <?php echo json_encode(array_column($stats, 'TimeOfOrder')); ?>;

            // Initialize Chart.js
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: timeOfOrder, // X-axis labels from DB
                    datasets: [{
                        label: 'Monthly Sales',
                        data: price, // Y-axis data from DB
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <!-- Add filters? -->


        <div class = "row"
        <!-- Pending Orders -->
        <div class="col-md-6">
            <!-- Search Bar Functionality normal users -->
            <form class="py-2 mb-4" method="POST" role="search">
                <input type="hidden" name="controller" value="user">
                <input type="hidden" name="action" value="reviewView">
                <input type="search" class="form-control" name="searchUser" placeholder="Search Name"
                       value="<?= isset($_POST['searchUser']) ? htmlspecialchars($_POST['searchUser']) : '' ?>">
            </form>

            <h2 class="text-center">Pending Orders</h2>
            <?php if (isset($pendingStats) && count($pendingStats) > 0): ?>
                <table class="table table-striped align-middle rounded-3 overflow-hidden">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Order Price</th>
                        <th scope="col">Time Of Order</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pendingStats as $stat): ?>
                        <tr>
                            <td><?= htmlspecialchars($stat['UserID']) ?></td>
                            <td>
                                <form method="POST" action="?controller=business&action=updateOrderPrice">
                                    <input type="hidden" name="userID" value="<?= htmlspecialchars($stat['UserID']) ?>">
                                    <input type="number" name="orderPrice" value="<?= htmlspecialchars($stat['OrderPrice']) ?>" step="0.01" class="form-control">
                            </td>
                            <td><?= htmlspecialchars($stat['TimeOfOrder']) ?></td>
                            <td><?= htmlspecialchars($stat['OrderStatus']) ?></td>
                            <td>
                                <button type="submit" class="btn btn-success">Submit</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted text-center">No Users found.</p>
            <?php endif; ?>
        </div>
        <!-- Completed Orders -->
        <div class="col-md-6">

            <!-- Search Bar Functionality Business -->
            <form class="py-2 mb-4" method="POST" role="search">
                <input type="hidden" name="controller" value="user">
                <input type="hidden" name="action" value="reviewView">
                <input type="search" class="form-control" name="searchBusiness" placeholder="Search Business"
                       value="<?= isset($_POST['searchBusiness']) ? htmlspecialchars($_POST['searchBusiness']) : '' ?>">
            </form>

            <h2 class="text-center">Completed Orders</h2>
            <?php if (isset($completedStats) && count($completedStats) > 0): ?>
                <table class="table table-striped align-middle rounded-3 overflow-hidden">
                    <thead class="table-dark">
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Order Price</th>
                        <th scope="col">Time Of Order</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($completedStats as $stat): ?>
                        <tr>
                            <td><?= htmlspecialchars($stat['UserID']) ?></td>
                            <td><?= htmlspecialchars($stat['OrderPrice']) ?></td>
                            <td><?= htmlspecialchars($stat['TimeOfOrder']) ?></td>
                            <td><?= htmlspecialchars($stat['OrderStatus']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted text-center">No Business Users found.</p>
            <?php endif; ?>
            </div>
        </div>
    </main>
</body>