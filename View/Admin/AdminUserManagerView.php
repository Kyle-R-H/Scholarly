<!DOCTYPE html>

<head>
    <title>User Management</title>
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
                    <li><a href="?controller=admin&action=dashboard" class="nav-link px-2 link-body-emphasis">Dashboard</a></li>
                    <li><a href="?controller=admin&action=adminManager" class="nav-link px-2 link-body-emphasis">Business Management</a></li>
                    <li><a href="?controller=admin&action=adminUserManager" class="nav-link px-2 link-secondary">User Management</a></li>
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
            <h1 class="h2">Users</h1>
        </div>

        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">User ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">Permission Level</th>
                        <th scope="col">Verified</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Ban/Unban</th>
                        <th scope="col">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user):
                            if($user['Email'] != $_COOKIE["Login_Info"]) {?>
                        <tr>

                            <td><?= htmlspecialchars($user['UserID']) ?></td>
                            <td><?= htmlspecialchars($user['Email']) ?></td>
                            <td><?= htmlspecialchars($user['PermissionLevel']) ?></td>
                            <td><?= htmlspecialchars($user['VerifiedCustomer']) ?></td>
                            <td><?= htmlspecialchars($user['FirstName']) ?></td>
                            <td><?= htmlspecialchars($user['LastName']) ?></td>

                            <td class="text-center">
                                <form id="BanUserForm" action="?controller=admin&action=banUser" method="post">
                                    <input type="hidden" name="BanUserID" value="<?= $user['UserID'] ?>">
                                    <input type="hidden" name="BanUserStatusToSet" value="<?= !$user['BanStatus'] ?>">
                                    <button class="btn <?= $user['BanStatus']? "primary" : "red" ?>" type="submit"> <?= $user['BanStatus']? "Unban" : "Ban" ?> </button>
                                </form>
                            </td>

                            <td class="text-center">
                                <form id="RemoveUserForm" action="?controller=admin&action=removeUser" method="post">
                                    <input type="hidden" name="RemoveUserID" value="<?= $user['UserID'] ?>">
                                    <button class="btn red" type="submit"> - </button>
                                </form>
                            </td>
                        </tr>
                    <?php } endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>