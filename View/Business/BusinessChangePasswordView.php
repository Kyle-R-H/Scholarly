<!DOCTYPE html>
<html>

<head>
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Public/css/Styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <!-- Header -->
    <header class="py-3 ps-4 pe-5 border-bottom">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-center">
                <img class="pt-1 px-3" src="Public\Images\scholarly logo.png" alt="Scholarly Logo" height="40" width="auto">
                <ul class="nav col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li><a href="?controller=business&action=dashboard" class="nav-link px-2 link-body-emphasis">Dashboard</a></li>
                    <li><a href="?controller=business&action=businessManager" class="nav-link px-2 link-body-emphasis">Business Management</a></li>
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

    <!-- Main Layout -->
    <div class="container-fluid d-flex flex-grow-1">
        <!-- Sidebar -->
        <div class="border-end d-flex flex-column p-3" style="width: 280px; min-width: 160px;">
            <ul class="nav nav-pills flex-column ">
                <li class="nav-item">
                    <a href="?controller=business&action=profile" class="nav-link link-body-emphasis" aria-current="page">Profile</a>
                </li>
                <li class="nav-item">
                    <a href="?controller=business&action=changePasswordView" class="nav-link active">Change Password</a>
                </li>
                <!-- <li>
                    <a href="#" class="nav-link delete-account">Delete Account</a>
                </li> -->
            </ul>
        </div>

        <!-- Main Content -->
        <div class="p-3">
            <form  action="?controller=business&action=changePassword" method="POST">
                <?php if ($business): ?>
                    <div class="row">
                        <div class="form-floating mb-3">
                            <input name="CurrentPassword" id="currentPasswordInput" type="password" class="form-control" placeholder="Current password">
                            <label for="currentPasswordInput" class="px-4">Current password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating mb-3">
                            <input name="NewPassword" id="newPasswordInput" type="password" class="form-control" placeholder="New password">
                            <label for="newPasswordInput" class="px-4">New password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-floating mb-3">
                            <input name="ConfirmNewPassword" id="confirmNewPasswordInput" type="password" class="form-control" placeholder="Confirm new password">
                            <label for="confirmNewPasswordInput" class="px-4">Confirm new password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="pt-3">
                            <button class="position-relative start-50 translate-middle btn" type="submit">Reset password</button>
                        </div>
                    </div>
                <?php else: ?>
                    <p>Business not found.</p>
                <?php endif; ?>
            </form>
        </div>
    </div>

</html>