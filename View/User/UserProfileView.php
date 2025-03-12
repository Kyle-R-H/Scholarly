<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Profile</title>
</head>

<body>
    <!-- <h1>Welcome, <?= htmlspecialchars($user['name']); ?></h1>
    <p>Email: <?= htmlspecialchars($user['email']); ?></p> -->
    <?php if ($user): ?>
        <h1><?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?></h1>
        <p>Email: <?php echo htmlspecialchars($user['Email']); ?></p>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>

</html>