<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars($user['name']); ?></h1>
    <p>Email: <?= htmlspecialchars($user['email']); ?></p>
</body>
</html>