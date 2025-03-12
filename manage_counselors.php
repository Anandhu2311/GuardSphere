<?php
session_start();
require 'DBS.inc.php'; // Database connection file

// Define the admin credentials
$admin_email = "admin@gmail.com"; // Change this to your actual admin email
$admin_password = "Admin@123"; // Change this to your actual admin password (hashed in production)

// Redirect to login if the user is not logged in
if (!isset($_SESSION['email']) || $_SESSION['email'] !== $admin_email) {
    header("Location: signin.php");
    exit();
}

// Fetch all counselors
$sql = "SELECT * FROM counselors"; // Adjust the query as needed
$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Counselors - GuardSphere</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS -->
</head>
<body>
    <header>
        <!-- ... existing header code ... -->
    </header>

    <div class="sidebar">
        <h2>Manage Counselors</h2>
        <!-- ... existing sidebar links ... -->
    </div>
    <div class="main-content">
        <div class="user-list">
        <?php if ($result->rowCount() > 0): ?>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <div class="user-container">
                    <p class="user-name"><strong>Name:</strong> <?php echo htmlspecialchars($row['coun_name']); ?></p>
                    <p class="user-email"><strong>Email:</strong> <?php echo htmlspecialchars($row['coun_email']); ?></p>
                    <p class="user-phone"><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['coun_phone_number'] ?? 'N/A'); ?></p>
                </div>
            <?php } ?>
        <?php else: ?>
            <p>No counselors found.</p>
        <?php endif; ?>
        </div>
    </div>

    <footer>
        <!-- ... existing footer code ... -->
    </footer>
</body>
</html> 