<!DOCTYPE html>
<html lang="en">

<head>
    <title>Scholarly - Messages</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Public/css/Styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header (exactly as provided previously) -->
    <header class="py-3 ps-4 pe-5 border-bottom">
        <div class="container-fluid">
            <div class="d-flex flex-wrap align-items-center justify-content-center">
                <img class="pt-1 px-3" src="Public/Images/scholarly logo.png" alt="Scholarly Logo" height="40" width="auto">
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
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" width="22" height="22" fill="currentColor">
                                <path d="M160 32a104 104 0 1 1 0 208 104 104 0 1 1 0-208zm320 0a104 104 0 1 1 0 208 104 104 0 1 1 0-208zM0 416c0-70.7 57.3-128 128-128l64 0c70.7 0 128 57.3 128 128l0 16c0 26.5-21.5 48-48 48L48 480c-26.5 0-48-21.5-48-48l0-16zm448 64c-38.3 0-72.7-16.8-96.1-43.5c.1-1.5.1-3 .1-4.5l0-16c0-34.9-11.2-67.1-30.1-93.4c5.8-20 24.2-34.6 46.1-34.6l224 0c26.5 0 48 21.5 48 48l0 16c0 70.7-57.3 128-128 128l-64 0z" />
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a href="?controller=user&action=reviewView" class="nav-link link-body-emphasis">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="22" height="22" fill="currentColor">
                                <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z" />
                            </svg>
                        </a>
                    </li>
                </ul>
                <!-- Profile and Dropdown Section -->
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle p-2 ms-1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="Public/Images/default_pfp_128.png" class="border" height="34" width="34" alt="pfp" style="border-radius: 50%;">
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

    <!-- Main Messaging Layout -->
    <div class="container my-4 flex-grow-1 d-flex flex-column">
        <?php if (!empty($_SESSION['error']) && !isset($_POST['searchUser'])) : ?>
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

        <?php if (!empty($_SESSION['success']) && !isset($_POST['searchUser'])) : ?>
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

        <div class="row">
            <div class="col-12">
                <h3 class="mb-3">Conversation with 
                    <?php
                        if(empty($this->userModel->getBusinessByUserID($receiverID))) {
                            echo $this->userModel->getUserById($receiverID)['FirstName'] . " " . $this->userModel->getUserById($receiverID)['LastName'];
                        } else {
                            echo $this->userModel->getBusinessByUserID($receiverID)['BusinessName'];
                        }
                    ?>
                </h3>
            </div>
        </div>

        <!-- Conversation Container -->
        <div class="card flex-grow-1 mb-3">
            <div class="card-body chat-area d-flex flex-column">
                <?php if (!empty($previousMessages)): ?>
                    <?php foreach ($previousMessages as $msg): ?>
                        <?php
                        $isSender = ($msg['Sender'] == $this->userModel->getUserByEmail($_COOKIE['Login_Info'])['UserID']);
                        // $senderLabel = $isSender ? "You" : "User #" . htmlspecialchars($msg['Sender']);
                        if($isSender) {
                            $senderLabel = "You";
                        } else {
                            if(empty($this->userModel->getBusinessByUserID($receiverID))) {
                                $senderLabel = $this->userModel->getUserById($receiverID)['FirstName'] . " " . $this->userModel->getUserById($receiverID)['LastName'];
                            } else {
                                $senderLabel = $this->userModel->getBusinessByUserID($receiverID)['BusinessName'];
                            }
                        }
                        ?>
                        <div class="mb-3">
                            <div class="<?= $isSender ? 'text-end' : 'text-start' ?>">
                                <span class="fw-bold"><?= $senderLabel ?>:</span>
                                <?php if ($msg['Message'] !== ''): ?>
                                    <span class="chat-bubble <?= $isSender ? 'sent' : 'received' ?>">
                                        <?= htmlspecialchars($msg['Message']) ?>
                                    </span>
                                <?php else: ?>
                                    Request Sent!
                                <?php endif; ?>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($msg['TimeSent']) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php if (!$isUser): ?>
                        <p class="text-muted">No messages yet. Please request to send inquiry</p>
                    <?php else: ?>
                        <p class="text-muted">No messages yet. Start the conversation below!</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Message Input Form -->
        <!-- If you dont have to request -->
        <?php if (!$request): ?>
            <div class="card">
                <div class="card-body p-0">
                    <form method="POST" action="?controller=user&action=sendMessage">
                        <input type="hidden" name="receiverID" value="<?= htmlspecialchars($receiverID) ?>">
                        <div class="input-group" style="border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                            <textarea class="form-control border-0" name="messageText" placeholder="Type your message here..." rows="2" required style="resize: none;"></textarea>
                            <button class="btn btn-success border-0" type="submit" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <form method="POST" action="?controller=user&action=sendMessage">
                <input type="hidden" name="receiverID" value="<?= htmlspecialchars($receiverID) ?>">
                <input type="hidden" name="messageText" value="">
                <button class="btn btn-success" type="submit">Request</button>
            </form>
        <?php endif; ?>

        <!-- Report Section -->
        <div class="col-12 mt-3">
            <h3 class="mb-3">
                <a class="btn red" data-bs-toggle="collapse" href="#reportSection" role="button" aria-expanded="false" aria-controls="reportSection">
                    Report User
                </a>
            </h3>
        </div>

        <div class="collapse" id="reportSection">
            <div class="card">
                <div class="card-body p-0">
                    <form method="POST" action="?controller=user&action=sendReport">
                        <input type="hidden" name="receiverID" value="<?= htmlspecialchars($receiverID) ?>">
                        <div class="input-group" style="border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                            <textarea class="form-control border-0" name="reportMessage" placeholder="Reason of Report..." rows="1" required style="resize: none;"></textarea>
                            <button class="btn red border-0" type="submit" style="border-top-right-radius: 5px; border-bottom-right-radius: 5px;">Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>

</html>