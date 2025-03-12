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

$logout_message = '';
if (isset($_SESSION['logout_success'])) {
    $logout_message = $_SESSION['logout_success'];
    unset($_SESSION['logout_success']); // Clear the message after displaying
}

// Fetch all users and their emergency info
$sql = "SELECT users.id, users.name, users.email, users.phone_number, 
        GROUP_CONCAT(emergency_contacts.emergency_name SEPARATOR ', ') AS emergency_names,
        GROUP_CONCAT(emergency_contacts.em_number SEPARATOR ', ') AS emergency_numbers,
        GROUP_CONCAT(emergency_contacts.relationship SEPARATOR ', ') AS relationships
        FROM users
        LEFT JOIN emergency_contacts ON users.email = emergency_contacts.email
        GROUP BY users.id";

$result = $pdo->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuardSphere - Women's Safety</title>
    <script src="disable-navigation.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background: #1a1a1a;
        }

        .logo {
            height: 40px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: #ffffff;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .profile-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
        }

        .profile-btn {
            background: #663399;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            text-decoration: none;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 12px;
            min-width: 200px;
            z-index: 1;
            margin-top: 0.5rem;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
        }

        .dropdown-content.show {
            display: block;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.2s ease;
            cursor: pointer;
        }

        .dropdown-content a:hover {
            background: #f0f0f0;
        }

        .dropdown-content a i {
            font-size: 1.2rem;
            color: #663399;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #663399;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .main-content {
            margin-left: 270px; /* Space for the sidebar */
            padding: 20px; /* Padding for main content */
            overflow: hidden; /* Clear floats */
            background-color: #f4f4f4; /* Light background for contrast */
            margin-top: 80px; /* Add margin to prevent overlap with fixed header */
        }

        .hero-content {
            flex: 1;
            color: white;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-text {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero-description {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
        }

        .cta-btn {
            padding: 1rem 2rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .primary-btn {
            background: #FF1493; /* Primary button color */
            color: white;
        }

        .primary-btn:hover {
            background: #e6007e; /* Darker shade on hover */
        }

        .secondary-btn {
            background: transparent;
            color: #FF1493; /* Secondary button color */
            border: 2px solid #FF1493; /* Border color */
        }

        .secondary-btn:hover {
            background: #FF1493; /* Background on hover */
            color: white; /* Text color on hover */
        }

        .features-grid {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            max-width: 600px;
            perspective: 1000px;
        }

        .feature-card {
            background: rgba(102, 51, 153, 0.8);
            padding: 2rem 1.5rem;
            border-radius: 15px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            backdrop-filter: blur(10px);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #fff;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        .feature-card h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .feature-card p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .feature-hover {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(102, 51, 153, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover .feature-hover {
            opacity: 1;
        }

        .feature-hover p {
            font-size: 0.9rem;
            line-height: 1.4;
        }

        footer {
            background: #1a1a1a;
            padding: 4rem 5% 2rem;
            color: #ffffff;
            position: relative; /* Ensure footer is at the bottom */
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #FF1493; /* Change footer section title color */
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 50px;
            height: 2px;
            background: #663399;
        }

        .footer-section p {
            line-height: 1.6;
            margin-bottom: 1.5rem;
            color: #cccccc;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #cccccc;
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: #FF1493; /* Change color on hover */
            transform: translateX(5px); /* Slight movement on hover */
        }

        .contact-info {
            list-style: none;
        }

        .contact-info li {
            margin-bottom: 1rem;
            color: #cccccc;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .contact-info i {
            color: #663399;
            width: 20px;
        }

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            color: #ffffff;
            background: #663399;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(102, 51, 153, 0.3);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-bottom p {
            color: #888888;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-section h3::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .social-links {
                justify-content: center;
            }

            .contact-info li {
                justify-content: center;
            }
        }

        @media (max-width: 1024px) {
            .features-grid {
                max-width: 500px;
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
                max-width: 400px;
                margin: 0 auto;
            }

            .feature-card {
                padding: 1.5rem;
            }

            .feature-icon {
                font-size: 2rem;
            }

            .feature-card h3 {
                font-size: 1.5rem;
            }
        }

        /* Add these new styles */
        .logout-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
            display: none;
            animation: fadeOut 3s ease-in-out;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; }
        }
        .user-container {
            background: rgba(255, 255, 255, 0.9); /* Light background for contrast */
            padding: 1.5rem; /* Increased padding for better spacing */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            transition: transform 0.2s, box-shadow 0.2s; /* Smooth transition for hover effect */
            margin-bottom: 1rem; /* Space between user containers */
            border: 1px solid #ccc; /* Add a border for better definition */
        }
        .dropdown-content {
            display: none;
            margin-top: 5px;
            padding: 10px;
            background: #e9e9e9;
            border-radius: 5px;
        }
        .user-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem; /* Space between user containers */
        }

        .user-name, .user-email, .user-phone {
            margin: 0.5rem 0; /* Margin for spacing */
            font-size: 1.1rem; /* Slightly larger font size */
            width: 100%; /* Ensure full width for alignment */
        }

        .emergency-info {
            margin-top: 1rem; /* Space above emergency info */
            padding-top: 0.5rem; /* Padding for separation */
            border-top: 1px solid #ccc; /* Divider line */
            width: 100%; /* Ensure full width for alignment */
        }

        .user-container:hover {
            transform: scale(1.02); /* Slightly enlarge on hover */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
        }

        .sidebar {
            width: 250px; /* Fixed width for sidebar */
            background-color: #1a1a1a; /* Sidebar background */
            color: white; /* Text color */
            padding: 20px; /* Padding */
            float: left; /* Allow sidebar to blend with main content */
            height: 100vh; /* Full height */
            position: fixed; /* Fixed position */
        }

        .sidebar h2 {
            margin-bottom: 20px; /* Space below the heading */
        }

        .sidebar ul {
            list-style-type: none; /* Remove bullet points */
            padding: 0; /* Remove padding */
        }

        .sidebar ul li {
            margin: 15px 0; /* Space between items */
        }

        .sidebar ul li a {
            color: white; /* Link color */
            text-decoration: none; /* Remove underline */
            transition: color 0.3s; /* Transition for hover effect */
        }

        .sidebar ul li a:hover {
            color: #663399; /* Change color on hover */
        }

        .sidebar-link {
            color: white; /* Link color */
            text-decoration: none; /* Remove underline */
            padding: 10px; /* Padding for better spacing */
            display: block; /* Make the link fill the container */
            transition: background 0.3s, color 0.3s; /* Transition for hover effect */
        }

        .sidebar-link:hover {
            background-color: #663399; /* Background color on hover */
            color: #ffffff; /* Text color on hover */
        }

        .admin-dashboard-title {
            font-size: 3rem; /* Increase font size */
            color: #FF1493; /* Change text color */
            text-align: center; /* Center the heading */
            margin-bottom: 2rem; /* Add space below the heading */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Add shadow for depth */
            font-weight: bold; /* Make the text bold */
        }

        .sub-options {
            margin-left: 20px; /* Indent sub-options */
            display: flex;
            flex-direction: column;
        }

        .sub-option {
            color: #ffffff; /* Text color */
            text-decoration: none; /* Remove underline */
            padding: 5px 0; /* Padding for spacing */
            transition: color 0.3s; /* Transition for hover effect */
        }

        .sub-option:hover {
            color: #663399; /* Change color on hover */
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php if ($logout_message): ?>
    <div class="logout-message" id="logoutMessage">
        <?php echo htmlspecialchars($logout_message); ?>
    </div>
    <?php endif; ?>

    <header style="background: #1a1a1a; position: fixed; top: 0; width: 100%; z-index: 1000;">
        <nav>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 120" class="logo">
                <g transform="translate(30, 10)">
                    <path d="M50 35
                             C45 25, 30 25, 25 35
                             C20 45, 25 55, 50 75
                             C75 55, 80 45, 75 35
                             C70 25, 55 25, 50 35" 
                          fill="#FF1493"/>
                    <path d="M15 55
                             C12 55, 5 58, 5 75
                             C5 82, 8 87, 15 90
                             L25 92
                             C20 85, 18 80, 20 75
                             C22 70, 25 68, 30 70
                             C28 65, 25 62, 20 62
                             C15 62, 15 65, 15 55" 
                          fill="#9932CC"/>
                    <path d="M85 55
                             C88 55, 95 58, 95 75
                             C95 82, 92 87, 85 90
                             L75 92
                             C80 85, 82 80, 80 75
                             C78 70, 75 68, 70 70
                             C72 65, 75 62, 80 62
                             C85 62, 85 65, 85 55" 
                          fill="#9932CC"/>
                    <path d="M45 40
                             Q50 45, 55 40
                             Q52 35, 45 40" 
                          fill="#FF69B4" 
                          opacity="0.5"/>
                </g>
                <text x="150" y="80" font-family="Arial Black, sans-serif" font-weight="900" font-size="60" fill="#ffffff">GUARDSPHERE</text>
                <text x="150" y="105" font-family="Arial, sans-serif" font-size="20" fill="#ffffff">GUARDED BY GUARDSPHERE.</text>
            </svg>
            <div class="nav-links">
                <a href="#home" style="color: #ffffff;">Home</a>
                <a href="#Aboutus" style="color: #ffffff;">About Us</a>
                <a href="#service" style="color: #ffffff;">Service</a>
                <a href="#location" style="color: #ffffff;">Location</a>
                <a href="#evidence" style="color: #ffffff;">Evidence</a>
                <div class="profile-section">
                    <div class="user-avatar" onclick="toggleProfileDropdown()">
                        <?php 
                        
                        if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
                            echo strtoupper(substr($_SESSION['email'], 0, 1));
                        } else {
                            echo 'G'; // Default letter if no user is logged in
                        }
                        ?>
                    </div>
                    <div class="dropdown-content" id="profileDropdown">
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="sidebar">
        <h2>Manage Users</h2>
        <div>
            <a href="#" class="sidebar-link" onclick="toggleSubOptions(event)"><i class="fas fa-user-md"></i> Manage Counselors <i class="fas fa-chevron-down"></i></a>
            <div class="sub-options" style="display: none;">
                <div>
                    <a href="add_counselors.php" class="sub-option"><i class="fas fa-user-plus"></i> Add Counselor</a>
                </div>
                <div>
                    <a href="manage_counselors.php" class="sub-option"><i class="fas fa-eye"></i> View Counselors</a>
                </div>
            </div>
        </div>
        <div>
            <a href="manage_supporters.php" class="sidebar-link" onclick="toggleSubOptions(event)"><i class="fas fa-user-friends"></i> Manage Supporters <i class="fas fa-chevron-down"></i></a>
            <div class="sub-options" style="display: none;">
                <div>
                    <a href="add_supporter.php" class="sub-option"><i class="fas fa-user-plus"></i> Add Supporter</a>
                </div>
                <div>
                    <a href="manage_supporters.php" class="sub-option"><i class="fas fa-eye"></i> View Supporters</a>
                </div>
            </div>
        </div>
        <div>
            <div>
                <a href="manage_advisors.php" class="sidebar-link" onclick="toggleSubOptions(event)"><i class="fas fa-user-tie"></i> Manage Advisors <i class="fas fa-chevron-down"></i></a>
                <div class="sub-options" style="display: none;">
                    <div>
                        <a href="add_advisor.php" class="sub-option"><i class="fas fa-user-plus"></i> Add Advisor</a>
                    </div>
                    <div>
                        <a href="manage_advisors.php" class="sub-option"><i class="fas fa-eye"></i> View Advisors</a>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <a href="manage_users.php" class="sidebar-link"><i class="fas fa-users"></i> Manage Normal Users</a>
        </div>
    </div>
    <div class="main-content">

    <div class="user-list">
    <?php if ($result->rowCount() > 0): // Check if there are any users ?>
        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
            <div class="user-container">
                <p class="user-name"><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                <p class="user-email"><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                <p class="user-phone"><strong>Phone Number:</strong> <?php echo htmlspecialchars($row['phone_number'] ?? 'N/A'); ?></p>
                <div class="emergency-info">
                    <p><strong>Emergency Contacts:</strong> <?php echo htmlspecialchars($row['emergency_names'] ?? 'N/A'); ?></p>
                    <p><strong>Emergency Numbers:</strong> <?php echo htmlspecialchars($row['emergency_numbers'] ?? 'N/A'); ?></p>
                    <p><strong>Relationships:</strong> <?php echo htmlspecialchars($row['relationships'] ?? 'N/A'); ?></p>
                </div>
            </div>
        <?php } ?>
    <?php else: ?>
        <p>No users found.</p> <!-- Message if no users are available -->
    <?php endif; ?>
    </div>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3>About GuardSphere</h3>
                <p>Empowering women with safety and security solutions worldwide. Join our community to make a difference.</p>
                <div class="social-links">
                    <a href="#instagram" class="instagram" aria-label="Instagram" style="background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D);">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#facebook" class="facebook" aria-label="Facebook" style="background: #1877F2;">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#twitter" class="twitter" aria-label="Twitter" style="background: #000000;">
                        <i class="fab fa-twitter" style="color: #ffffff;"></i>
                    </a>
                    <a href="#snapchat" class="snapchat" aria-label="Snapchat" style="background: #FFFC00;">
                        <i class="fab fa-snapchat-ghost" style="color: #000;"></i>
                    </a>
                </div>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Safety Resources</h3>
                <ul class="footer-links">
                    <li><a href="#emergency">Emergency Contacts</a></li>
                    <li><a href="#guides">Safety Guides</a></li>
                    <li><a href="#community">Community Support</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul class="contact-info">
                    <li><i class="fas fa-phone"></i> Emergency: 911</li>
                    <li><i class="fas fa-envelope"></i> support@guardsphere.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> Global Headquarters</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 GuardSphere. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }

        function toggleSubOptions(event) {
            event.preventDefault(); // Prevent the default link behavior
            const subOptions = event.currentTarget.nextElementSibling; // Get the next sibling (sub-options)
            subOptions.style.display = subOptions.style.display === 'block' ? 'none' : 'block'; // Toggle display
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.user-avatar')) {
                const dropdowns = document.getElementsByClassName('dropdown-content');
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
        // Add this to handle the logout message
        document.addEventListener('DOMContentLoaded', function() {
            const logoutMessage = document.getElementById('logoutMessage');
            if (logoutMessage) {
                logoutMessage.style.display = 'block';
                setTimeout(() => {
                    logoutMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
    
</body>

</html>