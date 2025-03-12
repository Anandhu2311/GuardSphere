<?php
session_start();

// Add this after session_start() and before the redirect check
$logout_message = '';
if (isset($_SESSION['logout_success'])) {
    $logout_message = $_SESSION['logout_success'];
    unset($_SESSION['logout_success']); // Clear the message after displaying
}

// Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Database connection
        require_once 'DBS.inc.php';

        // Prepare SQL statement
        $sql = "INSERT INTO emergency_contacts (email, emergency_name, emergency_email, em_number, relationship) 
                VALUES (:email, :emergency_name, :emergency_email, :em_number, :relationship)";
        
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':email', $_SESSION['email']); // Use email from session instead of user_id
        $stmt->bindParam(':emergency_name', $_POST['contact_name']);
        $stmt->bindParam(':emergency_email', $_POST['contact_email']);
        $stmt->bindParam(':em_number', $_POST['phone_number']);
        $stmt->bindParam(':relationship', $_POST['relationship']);
        
        // Execute the statement
        $stmt->execute();
        
        // Set success message
        $_SESSION['success_message'] = "Emergency contact added successfully!";
        
    } catch(PDOException $e) {
        // Set error message
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
    }
    
    // Redirect back to emergency contacts page
    header("Location: emergency_contacts.php");
    exit();
}
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
            background-color:rgb(33, 29, 105);
            min-height: 80vh;
            padding: 4rem 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4rem;
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
            transition: transform 0.3s ease;
        }

        .primary-btn {
            background: black;
            color: white;
        }

        .secondary-btn {
            background: transparent;
            color: white;
            border: 2px solid white;
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
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #663399;
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
            color: #663399;
            transform: translateX(5px);
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

        /* Add these new styles */
        .profile-sidebar {
            background: #1a1a1a;
            padding: 2rem;
            border-radius: 15px;
            width: 250px;
            color: #ffffff;
        }

        .profile-photo {
            width: 100px;
            height: 100px;
            background: #663399;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .profile-name {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #ffffff;
        }

        .sidebar-btn {
            width: 100%;
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            background: transparent;
            border: 1px solid #663399;
            color: #ffffff;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .sidebar-btn:hover {
            background: #663399;
            transform: translateY(-2px);
        }

        .profile-details {
            flex: 1;
            margin-left: 2rem;
        }

        .card {
            background: #1a1a1a;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .card-title {
            color: #ffffff;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .input-group label {
            color: #cccccc;
        }

        .input-group input {
            padding: 0.8rem;
            border-radius: 8px;
            border: 1px solid #663399;
            background: #2a2a2a;
            color: #ffffff;
        }

        .input-group input:focus {
            outline: none;
            border-color: #9932CC;
        }

        .contact-list {
            background: #2a2a2a;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #ffffff;
        }

        .add-btn {
            background: #663399;
            color: white;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-btn:hover {
            background: #9932CC;
            transform: translateY(-2px);
        }

        .activity-item {
            padding: 1rem;
            border-bottom: 1px solid #333;
            color: #ffffff;
        }

        .activity-title {
            color: #ffffff;
            margin-bottom: 0.5rem;
        }

        .activity-time {
            color: #888888;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .main-content {
                flex-direction: column;
            }

            .profile-sidebar {
                width: 100%;
                margin-bottom: 2rem;
            }

            .profile-details {
                margin-left: 0;
            }

            .form-group {
                grid-template-columns: 1fr;
            }
        }

        /* Update these styles */
        .main-content {
            gap: 2rem;
            align-items: flex-start;
        }

        .profile-sidebar {
            position: sticky;
            top: 2rem;
            height: fit-content;
        }

        .sidebar-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .sidebar-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            font-size: 1rem;
        }

        .sidebar-btn i {
            width: 20px;
        }

        .profile-details {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            flex: 1;
            max-width: 800px;
        }

        .card {
            margin-bottom: 0;
        }

        .form-input {
            width: 100%;
            padding: 0.8rem;
            border-radius: 8px;
            border: 1px solid #663399;
            background: #2a2a2a;
            color: #ffffff;
            font-size: 1rem;
        }

        .form-input:focus {
            outline: none;
            border-color: #9932CC;
            box-shadow: 0 0 0 2px rgba(153, 50, 204, 0.2);
        }

        .form-input::placeholder {
            color: #666;
        }

        .profile-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }
            
            .profile-sidebar {
                position: relative;
                top: 0;
            }
        }

        .profile-info, .contact-info {
            padding: 1rem 0;
        }

        .info-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-item label {
            color: #cccccc;
            font-size: 0.9rem;
        }

        .info-value {
            color: #ffffff;
            font-size: 1.1rem;
            padding: 0.8rem;
            background: #2a2a2a;
            border-radius: 8px;
            border: 1px solid #663399;
        }

        @media (max-width: 768px) {
            .info-group {
                grid-template-columns: 1fr;
            }
        }

        /* Add these new form styles */
        .button-group {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .success-message {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
            animation: slideIn 0.5s ease-out forwards, fadeOut 0.5s ease-in forwards 2.5s;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }

        /* Replace the existing success-message and logout-message styles with these new styles */
        .popup-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            max-width: 400px;
            animation: slideIn 0.5s ease-out forwards, fadeOut 0.5s ease-in forwards 2.5s;
            font-weight: 500;
        }

        .popup-message.success {
            background-color: #4CAF50;
            color: white;
            border-left: 4px solid #2E7D32;
        }

        .popup-message.error {
            background-color: #f44336;
            color: white;
            border-left: 4px solid #c62828;
        }

        .popup-message i {
            font-size: 20px;
        }

        .popup-message .message-content {
            flex: 1;
        }

        .popup-message .close-btn {
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .popup-message .close-btn:hover {
            opacity: 1;
        }

        @keyframes slideIn {
            from {
                transform: translateX(120%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(120%);
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php if ($logout_message): ?>
    <div class="popup-message success">
        <i class="fas fa-check-circle"></i>
        <div class="message-content"><?php echo htmlspecialchars($logout_message); ?></div>
        <i class="fas fa-times close-btn"></i>
    </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="popup-message success">
        <i class="fas fa-check-circle"></i>
        <div class="message-content"><?php echo htmlspecialchars($_SESSION['success_message']); ?></div>
        <i class="fas fa-times close-btn"></i>
    </div>
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
    <div class="popup-message error">
        <i class="fas fa-exclamation-circle"></i>
        <div class="message-content"><?php echo htmlspecialchars($_SESSION['error_message']); ?></div>
        <i class="fas fa-times close-btn"></i>
    </div>
    <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <nav style="background: #1a1a1a;">
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
            <a href="home.php" style="color: #ffffff;">Home</a>
            <a href="Aboutus.php" style="color: #ffffff;">About Us</a>
            <a href="#service" style="color: #ffffff;">Service</a>
            <a href="#location" style="color: #ffffff;">Location</a>
            <a href="#evidence" style="color: #ffffff;">Evidence</a>
            <div class="profile-section">
                <div class="user-avatar" onclick="toggleDropdown()">
                    <?php 
                    
                    if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
                        echo strtoupper(substr($_SESSION['email'], 0, 1));
                    } else {
                        echo 'G'; // Default letter if no user is logged in
                    }
                    ?>
                </div>
                <div class="dropdown-content" id="profileDropdown">
                    <a href="pro_update.php"><i class="fas fa-user-cog"></i> Manage Profile</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="main-content" style="padding: 2rem 5%;">
        <div class="profile-sidebar">
            <div class="profile-photo">US</div>
            <div class="profile-name">User Name</div>
            <div class="sidebar-buttons">
                <a href="edit_profile.php" class="sidebar-btn"><i class="fas fa-user-edit"></i> Edit Profile</a>
                <a href="security_settings.php" class="sidebar-btn"><i class="fas fa-shield-alt"></i> Security Settings</a>
                <a href="emergency_contacts.php" class="sidebar-btn"><i class="fas fa-phone-alt"></i> Emergency Contacts</a>
                <a href="privacy_settings.php" class="sidebar-btn"><i class="fas fa-lock"></i> Privacy Settings</a>
            </div>
        </div>
            
            <div class="card">
                <div class="card-title">
                    <i>📞</i> Emergency Contacts
                </div>
                <form class="contact-info" method="POST" action="emergency_contacts.php" id="emergencyContactForm">
                    <div class="info-group">
                        <div class="info-item">
                            <label for="contact_name">Contact Name</label>
                            <input type="text" 
                                   id="contact_name" 
                                   name="contact_name" 
                                   class="form-input" 
                                   placeholder="Enter contact name"
                                   required>
                        </div>
                        <div class="info-item">
                            <label for="contact_email">Email</label>
                            <input type="email" 
                                   id="contact_email" 
                                   name="contact_email" 
                                   class="form-input" 
                                   placeholder="Enter gmail address"
                                   pattern="[a-zA-Z0-9._%+-]+@gmail\.com$"
                                   title="Please enter a valid Gmail address"
                                   required>
                            <span id="emailError" style="color: #ff4444; font-size: 0.8rem; display: none;">Please enter a valid Gmail address</span>
                        </div>
                    </div>
                    <div class="info-group">
                        <div class="info-item">
                            <label for="phone_number">Phone Number</label>
                            <input type="tel" 
                                   id="phone_number" 
                                   name="phone_number" 
                                   class="form-input" 
                                   placeholder="Enter phone number"
                                   pattern="[0-9]{10}"
                                   title="Please enter a valid 10-digit phone number"
                                   required>
                            <span id="phoneError" style="color: #ff4444; font-size: 0.8rem; display: none;">Please enter a valid 10-digit phone number</span>
                        </div>
                        <div class="info-item">
                            <label for="relationship">Relationship</label>
                            <input type="text" 
                                   id="relationship" 
                                   name="relationship" 
                                   class="form-input" 
                                   placeholder="Enter relationship"
                                   required>
                        </div>
                    </div>
                    <div class="button-group">
                        <button type="submit" class="add-btn" id="submitBtn">Add Contact</button>
                    </div>
                </form>
            </div>
            
            <div class="card">
                <div class="card-title">
                    <i>🕒</i> Recent Activity
                </div>
                <div class="activity-item">
                    <div class="activity-title">Emergency Contact Updated</div>
                    <div class="activity-time">Yesterday, 3:45 PM</div>
                </div>
                <div class="activity-item">
                    <div class="activity-title">Location Shared</div>
                    <div class="activity-time">Today, 10:30 AM</div>
                </div>
            </div>
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
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
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

        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('passwordInput');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the eye icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Add this to handle the success and error messages
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            const errorMessage = document.getElementById('errorMessage');
            
            if (successMessage) {
                successMessage.style.display = 'block';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000);
            }
            
            if (errorMessage) {
                errorMessage.style.display = 'block';
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 3000);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('emergencyContactForm');
            const emailInput = document.getElementById('contact_email');
            const phoneInput = document.getElementById('phone_number');
            const emailError = document.getElementById('emailError');
            const phoneError = document.getElementById('phoneError');
            const submitBtn = document.getElementById('submitBtn');

            // Email validation
            emailInput.addEventListener('input', function() {
                const isValidEmail = /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(this.value);
                emailError.style.display = isValidEmail ? 'none' : 'block';
                this.style.borderColor = isValidEmail ? '#663399' : '#ff4444';
                validateForm();
            });

            // Phone validation
            phoneInput.addEventListener('input', function() {
                // Remove any non-numeric characters
                this.value = this.value.replace(/\D/g, '');
                
                const isValidPhone = /^[0-9]{10}$/.test(this.value);
                phoneError.style.display = isValidPhone ? 'none' : 'block';
                this.style.borderColor = isValidPhone ? '#663399' : '#ff4444';
                validateForm();
            });

            // Form validation
            function validateForm() {
                const isValidEmail = /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(emailInput.value);
                const isValidPhone = /^[0-9]{10}$/.test(phoneInput.value);
                submitBtn.disabled = !(isValidEmail && isValidPhone);
                submitBtn.style.opacity = (isValidEmail && isValidPhone) ? '1' : '0.5';
            }

            // Form submission
            form.addEventListener('submit', function(e) {
                const isValidEmail = /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(emailInput.value);
                const isValidPhone = /^[0-9]{10}$/.test(phoneInput.value);

                if (!isValidEmail || !isValidPhone) {
                    e.preventDefault();
                    if (!isValidEmail) emailError.style.display = 'block';
                    if (!isValidPhone) phoneError.style.display = 'block';
                }
            });
        });

        // Add this to handle the success message
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                // Remove the message from DOM after animation completes
                setTimeout(() => {
                    successMessage.remove();
                }, 3000);
            }
        });

        // Add this to your existing script section
        document.addEventListener('DOMContentLoaded', function() {
            // Handle all popup messages
            const popupMessages = document.querySelectorAll('.popup-message');
            
            popupMessages.forEach(message => {
                // Handle close button clicks
                const closeBtn = message.querySelector('.close-btn');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        message.style.animation = 'fadeOut 0.5s ease-in forwards';
                        setTimeout(() => {
                            message.remove();
                        }, 500);
                    });
                }

                // Automatically remove the message after 3 seconds
                setTimeout(() => {
                    if (message && message.parentElement) {
                        message.style.animation = 'fadeOut 0.5s ease-in forwards';
                        setTimeout(() => {
                            message.remove();
                        }, 500);
                    }
                }, 3000);
            });
        });
    </script>
</body>

</html>