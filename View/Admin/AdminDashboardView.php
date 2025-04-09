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
                    <li><a href="?controller=admin&action=dashboard" class="nav-link px-2 link-secondary">Dashboard</a></li>
                    <li><a href="?controller=admin&action=adminManager" class="nav-link px-2 link-body-emphasis">Business Management</a></li>
                    <li><a href="?controller=admin&action=adminUserManager" class="nav-link px-2 link-body-emphasis">User Management</a></li>
                </ul>


                <!-- Profile and Dropdown Section -->
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle p-2 ms-1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="Public\Images\default_pfp_128.png" class="border" height="34" width="34" alt="pfp" style="border-radius: 50%;">
                    </a>
                    <ul class="dropdown-menu text-small">
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
            <h1 class="h2">Business Statistics</h1>
        </div>

        <div class="container mt-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-pill text-center shadow-sm">
                        <strong>Most Popular Item:</strong>
                        <?= htmlspecialchars($mostPopularItem['ItemName']) ?>
                        (Ordered <?= $mostPopularItem['OrderCount'] ?> times)
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-pill text-center shadow-sm">
                        <strong>Most Popular Business:</strong>
                        <?= htmlspecialchars($mostPopularBusiness['BusinessName']) ?>
                        (<?= $mostPopularBusiness['OrderCount'] ?> orders)
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-pill text-center shadow-sm">
                        <strong>Busiest Day:</strong>
                        <?= htmlspecialchars($mostPopularDay['OrderDate']) ?>
                        (<?= $mostPopularDay['OrderCount'] ?> orders)
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-pill text-center shadow-sm">
                        <strong>Largest Order by Price:</strong>
                        $<?= htmlspecialchars($largestOrderByPrice['TotalOrderValue']) ?>
                        (Order ID: <?= $largestOrderByPrice['Order_ID'] ?>)
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-pill text-center shadow-sm">
                        <strong>Largest Order by Items:</strong>
                        <?= $largestOrderByItems['TotalItems'] ?> items
                        (Order ID: <?= $largestOrderByItems['Order_ID'] ?>)
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-pill text-center shadow-sm">
                        <strong>Top Customer:</strong>
                        User ID <?= $topCustomer['UserID'] ?>
                        (Bought <?= $topCustomer['TotalItemsBought'] ?> items)
                    </div>
                </div>
            </div>
        </div>


        <!-- Add filters? -->
        <h2>Data</h2>
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Business</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Time Of Order</th>
                        <th scope="col">Total Price</th>
                        <th scope="col">Order ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['BusinessName']) ?></td>
                            <td><?= htmlspecialchars($order['UserID']) ?></td>
                            <td><?= htmlspecialchars($order['TimeOfOrder']) ?></td>
                            <td><?= htmlspecialchars($order['TotalPrice']) ?></td>
                            <td><?= htmlspecialchars($order['Order_ID']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>