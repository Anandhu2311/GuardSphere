<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuardSphere - Welcome Back</title>
    <script src="val2.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    body {
        background-color: #f5f5f5;
    }

    nav {
        background: linear-gradient(to right, #211d69, #ff69b4);
        padding: 1rem 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
    }

    .logo {
        height: 40px;
    }

    .nav-links {
        display: flex;
        gap: 2rem;
    }

    .nav-links a {
        text-decoration: none;
        color: white;
        padding: 0.7rem 1.2rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-weight: 500;
    }

    .nav-links a:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .main-content {
        background-color: rgb(33, 29, 105);
        min-height: 80vh;
        padding: 4rem 5%;
        display: flex;
        align-items: center;
        justify-content: space-around;
        gap: 2rem;
    }

    .login-form {
        background: rgba(255, 105, 180, 0.3);
        backdrop-filter: blur(10px);
        padding: 2rem;
        border-radius: 20px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .login-form h2 {
        color: white;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .login-form p {
        color: white;
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 0.9rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        color: white;
        margin-bottom: 0.5rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.8rem;
        border: none;
        border-radius: 8px;
        background: rgba(0, 0, 0, 0.2);
        color: white;
    }

    .form-group input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .form-group input.error {
        border: 2px solid red;
    }

    .error-message {
        color: red;
        font-size: 0.8rem;
        margin-top: 0.3rem;
    }

    /* Add new success message styles */
    .success-message {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: rgba(46, 213, 115, 0.9);
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: slideIn 0.5s ease-out, fadeOut 0.5s ease-out 2.5s forwards;
        z-index: 1000;
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

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 1rem 0;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
    }

    .forgot-password {
        color: white;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .signin-btn {
        width: 100%;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.2);
        border: none;
        border-radius: 8px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;
        margin-bottom: 1rem;
    }

    .signin-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .divider {
        text-align: center;
        color: white;
        margin: 1rem 0;
    }

    .social-login {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .social-btn {
        flex: 1;
        padding: 0.8rem;
        border: none;
        border-radius: 8px;
        background: rgba(0, 0, 0, 0.2);
        color: white;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
    }

    .social-btn:hover {
        background: rgba(0, 0, 0, 0.3);
        transform: scale(1.05);
    }

    .signup-link {
        display: block;
        text-align: center;
        color: white;
        text-decoration: none;
        font-size: 0.9rem;
    }

    footer {
        background: linear-gradient(to right, #211d69, #ff69b4);
        padding: 3rem 5%;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: rgba(255, 255, 255, 0.1);
    }

    footer p {
        font-size: 1.1rem;
        max-width: 400px;
        line-height: 1.6;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .quick-links {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .quick-links a {
        text-decoration: none;
        color: white;
        padding: 0.7rem 1.2rem;
        border-radius: 25px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .quick-links a:hover::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        z-index: -1;
    }

    .quick-links a:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .main-content {
            flex-direction: column;
            padding: 2rem;
        }

        .quick-links {
            justify-content: center;
            margin-top: 1rem;
        }

        footer {
            flex-direction: column;
            text-align: center;
            gap: 2rem;
            padding: 2rem;
        }

        footer p {
            max-width: 100%;
        }

        .social-login {
            flex-direction: column;
            gap: 1rem;
        }
    }

    /* Update logo text colors for better visibility on dark background */
    .logo text[y="80"] {
        fill: white;
    }

    .logo text[y="105"] {
        fill: rgba(255, 255, 255, 0.7);
    }

    .footer-content {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        align-items: center;
        justify-content: center;
        min-height: 200px;
    }

    .footer-tagline {
        max-width: 600px;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem 0;
    }

    .tagline-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .tagline-content h3 {
        font-size: 1.8rem;
        margin: 0;
        line-height: 1.2;
        color: white;
    }

    .tagline-content p {
        font-size: 1.2rem;
        margin: 0;
        line-height: 1.2;
        color: rgba(255, 255, 255, 0.9);
        text-align: center;
    }

    .footer-bottom {
        width: 100%;
        text-align: center;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .footer-bottom p {
        font-size: 0.9rem;
        opacity: 0.8;
        margin: 0;
    }

    @media (max-width: 768px) {
        .footer-content {
            gap: 1.5rem;
        }

        .footer-tagline {
            max-width: 100%;
            text-align: center;
        }

        .footer-bottom {
            padding-top: 1.5rem;
        }
    }

    /* Remove underline from links */
    a {
        text-decoration: none;
        /* Removes the underline */
    }

    /* Style for the button */
    .button {
        background-color: #4CAF50;
        /* Green background */
        border: none;
        /* No border */
        color: white;
        /* White text */
        padding: 15px 32px;
        /* Padding */
        text-align: center;
        /* Centered text */
        text-decoration: none;
        /* No underline */
        display: inline-block;
        /* Inline block */
        font-size: 16px;
        /* Font size */
        margin: 4px 2px;
        /* Margin */
        cursor: pointer;
        /* Pointer cursor on hover */
        border-radius: 12px;
        /* Rounded corners */
        transition: background-color 0.3s;
        /* Smooth transition */
    }

    /* Button hover effect */
    .button:hover {
        background-color: #45a049;
        /* Darker green on hover */
    }
    </style>
</head>

<body>

    <nav>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 120" class="logo">
            <g transform="translate(30, 10)">
                <path d="M50 35 C45 25, 30 25, 25 35 C20 45, 25 55, 50 75 C75 55, 80 45, 75 35 C70 25, 55 25, 50 35"
                    fill="#FF1493" />
                <path
                    d="M15 55 C12 55, 5 58, 5 75 C5 82, 8 87, 15 90 L25 92 C20 85, 18 80, 20 75 C22 70, 25 68, 30 70 C28 65, 25 62, 20 62 C15 62, 15 65, 15 55"
                    fill="#9932CC" />
                <path
                    d="M85 55 C88 55, 95 58, 95 75 C95 82, 92 87, 85 90 L75 92 C80 85, 82 80, 80 75 C78 70, 75 68, 70 70 C72 65, 75 62, 80 62 C85 62, 85 65, 85 55"
                    fill="#9932CC" />
                <path d="M45 40 Q50 45, 55 40 Q52 35, 45 40" fill="#FF69B4" opacity="0.5" />
            </g>
            <text x="150" y="80" font-family="Arial Black, sans-serif" font-weight="900" font-size="60"
                fill="#333">GUARDSPHERE</text>
            <text x="150" y="105" font-family="Arial, sans-serif" font-size="20" fill="#666">GUARDED BY
                GUARDSPHERE.</text>
        </svg>
        <div class="nav-links">
            <a href="land.php">About Us</a>
            <a href="#services">Services</a>
            <a href="#contact">Contact</a>
        </div>
    </nav>

    <div class="main-content">
        <div class="login-form">
            <h2>Welcome Back</h2>
            <p>Sign in to your GuardSphere account</p>

            <form id="loginForm" method="post" action="signin.inc.php" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    <span class="error-message" id="emailError"></span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <span class="error-message" id="passwordError"></span>
                </div>
                <a href="forgot.php" class="forgot-password">Forgot Password?</a>
                <button type="submit" class="signin-btn">Sign In</button>

                <div class="remember-forgot">
                    <button type="button" onclick="window.location.href='admin_log.php'" class="signin-btn">Admin
                        Login</button>
                </div>

                <!-- Add login icons for Advisor, Counselor, and Supporter -->
                <div class="social-login">
                    <button type="button" onclick="window.location.href='advisor_signin.php'" class="social-btn">
                        <i class="fas fa-user-tie"></i> Advisor Login
                    </button>
                    <button type="button" onclick="window.location.href='counselor_signin.php'" class="social-btn">
                        <i class="fas fa-user-graduate"></i> Counselor Login
                    </button>
                    <button type="button" onclick="window.location.href='supporter_signin.php'" class="social-btn">
                        <i class="fas fa-user-friends"></i> Supporter Login
                    </button>
                </div>




            </form>



            <a href="signup.php" class="signup-link">Don't have an account? Sign up now</a>
        </div>

        <img src="pics/Women-s-safety-at-workplace.jpg" alt="Diverse Women Illustration">
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-tagline">
                <div class="tagline-content">
                    <h3>GuardSphere</h3>
                    <p>Empowering women with safety and security solutions worldwide.</p>
                </div>
            </div>
            <div class="quick-links"
                style="width: 100%; padding-top: 2rem; border-top: 1px solid rgba(255, 255, 255, 0.1);">
                <a href="#about" style="font-size: 1.1rem;">About Us</a>
                <a href="#courses" style="font-size: 1.1rem;">Safety Courses</a>
                <a href="#products" style="font-size: 1.1rem;">Products</a>
                <a href="#help" style="font-size: 1.1rem;">Emergency Help</a>
                <a href="#plans" style="font-size: 1.1rem;">Subscription Plans</a>
            </div>
            <div class="footer-bottom">
                <p style="font-size: 1rem;">&copy; 2024 GuardSphere. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
    function validateForm() {
        let valid = true;

        // Email validation
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const emailValue = emailInput.value.trim();

        if (!emailValue.endsWith('@gmail.com')) {
            valid = false;
            emailError.textContent = 'Please enter a valid Gmail address.';
            emailInput.classList.add('error');
        } else {
            emailError.textContent = '';
            emailInput.classList.remove('error');
        }

        // Password validation
        const passwordInput = document.getElementById('password');
        const passwordError = document.getElementById('passwordError');
        const passwordValue = passwordInput.value.trim();

        if (passwordValue.length < 6) {
            valid = false;
            passwordError.textContent = 'Password must be at least 6 characters long.';
            passwordInput.classList.add('error');
        } else {
            passwordError.textContent = '';
            passwordInput.classList.remove('error');
        }

        if (valid) {
            fetch('signin.inc.php', {
                    method: 'POST',
                    body: new FormData(document.getElementById('loginForm'))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        const successMessage = document.createElement('div');
                        successMessage.className = 'success-message';
                        successMessage.textContent = 'Login successful! Redirecting...';
                        document.body.appendChild(successMessage);

                        // Redirect after 3 seconds
                        setTimeout(() => {
                            window.location.href = 'home.php';
                        }, 3000);
                    } else {
                        alert(data.message || 'Login failed. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }

        return false;
    }
    </script>
    <script>
    // Redirect if the back button is pressed after logout

    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function() {
        window.history.pushState(null, null, window.location.href);
        alert("You have been logged out. Please log in again.");
        window.location.href = "signin.php";
    };
    </script>
</body>

</html>