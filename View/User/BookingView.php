<!DOCTYPE html>
<html>

<head>
    <title><?= htmlspecialchars($items[0]["BusinessName"]) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Public/css/Styles.css" rel="stylesheet">
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
                        <a href="?controller=user&action=userMessagesView" class="nav-link link-body-emphasis">
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

        <!-- Main Content -->
        <div class="container my-5">
            <?php if (!empty($items)): ?>
                <!-- Business Info Section (Smaller) -->
                <div class="row align-items-center bg-light rounded shadow-sm p-3 mb-4">
                    <div class="col-md-4">
                        <h3 class="fw-bold"><?= htmlspecialchars($items[0]['BusinessName']) ?></h3>
                        <p class="small"><?= htmlspecialchars($business[0]['Description']) ?></p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="<?= htmlspecialchars($business[0]['Image']) ?>" class="img-fluid rounded shadow" alt="Business Image">
                    </div>
                </div>
            <?php endif; ?>

            <!-- Maximum Price Filter Form -->
            <form method="POST" class="mb-4 d-flex gap-2">
                <div class="input-group">
                    <input type="number" step="0.01" class="form-control" name="maxPrice" placeholder="Enter maximum price"
                        value="<?= isset($_POST['maxPrice']) ? htmlspecialchars($_POST['maxPrice']) : '' ?>">
                    <button type="submit" class="btn">Filter</button>
                </div>

                <a href="?controller=user&action=addDirectReviewView&businessName=<?= $business[0]['BusinessName'] ?>" class="btn">Review</a>
                <a href="?controller=user&action=sendMessageView&receiverID=<?= $business[0]['UserID'] ?>" class="btn">Message</a>

            </form>

            <!-- Menu Items Section -->
            <div class="row">
                <?php
                if (isset($_POST['maxPrice']) && $_POST['maxPrice'] !== '') {
                    $maxPrice = floatval($_POST['maxPrice']);
                    $items = array_filter($items, fn($item) => $item['ItemPrice'] <= $maxPrice);
                }
                ?>
                <?php foreach ($items as $item): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body position-relative" style="padding-right: 4rem;">
                                <h4 class="card-title"><?= htmlspecialchars($item['ItemName']) ?></h4>
                                <p class="card-text"><?= htmlspecialchars($item['Description']) ?></p>
                                <p class="fw-bold">Price: $<?= number_format($item['ItemPrice'], 2) ?></p>

                                <!-- Add to Cart Form -->
                                <form method="POST">
                                    <input type="hidden" name="item_name" value="<?= htmlspecialchars($item['ItemName']) ?>">
                                    <input type="hidden" name="item_price" value="<?= htmlspecialchars($item['ItemPrice']) ?>">
                                    <input type="hidden" name="form_token" value="<?= $_SESSION['form_token'] ?>">
                                    <button type="submit" class="btn position-absolute top-0 end-0 m-3">+</button>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- View Cart Section -->
            <h2 class="mt-5">Shopping Cart</h2>
            <?php if (!empty($_SESSION['cart'])): ?>
                <ul class="list-group">
                    <?php foreach ($_SESSION['cart'] as $cartItem): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($cartItem['name']) ?> -
                            $<?= number_format($cartItem['price'], 2) ?> × <?= $cartItem['quantity'] ?>
                            = <strong>$<?= number_format($cartItem['price'] * $cartItem['quantity'], 2) ?></strong>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
            <div class="sticky-bottom py-3">
                <div class="container-fluid d-flex justify-content-end">
                    <a href="?controller=user&action=orderConfirmView" class="btn w-100">Confirm Order</a>
                </div>
            </div>
        </div>
</body>

</html>