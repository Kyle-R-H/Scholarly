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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add a Business</h1>
        </div>

        <?php if (!empty($error)) : ?>
            <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050">
                <div id="errorToast" class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                        <!-- <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button> -->
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="?controller=admin&action=registerBusiness">
            <div class="form-floating mb-4">
                <input name="RegisterName" id="nameInput" type="name" class="form-control" value="<?php echo isset($_POST['RegisterName']) ? htmlspecialchars($_POST['RegisterName']) : ''; ?>" required>
                <label for="nameInput">Business Name</label>
            </div>
            
            <div class="form-floating mb-4">
                <input name="RegisterEmail" id="emailInput" type="email" class="form-control" placeholder="name@ul.ie" value="<?php echo isset($_POST['RegisterEmail']) ? htmlspecialchars($_POST['RegisterEmail']) : ''; ?>" required>
                <label for="emailInput">Business Email Address</label>
            </div>

            <div class="form-floating mb-4">
                <select name="RegisterBusinessType" id="businessTypeInput" class="form-select" required>
                    <option value="" disabled selected>Select Business Type</option>
                    <option value="Restaurant">Restaurant</option>
                    <option value="Event">Event</option>
                    <option value="Service">Service</option>
                    <option value="Activity">Activity</option>
                </select>
                <label for="businessTypeInput">Business Type</label>
            </div>

            <div class="form-floating mb-4">
                <input name="RegisterDescription" id="descriptionInput" class="form-control" placeholder="Description" value="<?php echo isset($_POST['RegisterDescription']) ? htmlspecialchars($_POST['RegisterDescription']) : ''; ?>" required>
                <label for="descriptionInput">Business Description</label>
            </div>

            <div class="form-floating mb-4">
                <input name="RegisterImage" id="imageInput" class="form-control" placeholder="Image" value="<?php echo isset($_POST['RegisterImage']) ? htmlspecialchars($_POST['RegisterImage']) : ''; ?>" required>
                <label for="imageInput">Business Image Link</label>
            </div>

            <div class="pt-4">
                <button class="position-relative start-50 translate-middle btn" type="submit">Submit</button>
            </div>
        </form>



    </main>
</body>