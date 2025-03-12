<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuardSphere - Create Account</title>
    <script src="vall.js"></script>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background: linear-gradient(135deg, #211d69 0%, #FF1493 100%);
        }

        .logo {
            height: 40px;
        }

        .logo text {
            fill: #fff;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-links a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3), 
                       0 4px 8px rgba(255, 20, 147, 0.2);
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

        .signup-form {
            background: rgba(255, 105, 180, 0.3);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .signup-form h2 {
            color: white;
            margin-bottom: 0.5rem;
        }

        .signup-form p {
            color: white;
            margin-bottom: 1.5rem;
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

        .error {
            color:rgb(2, 11, 11);
            font-size: 0.8rem;
            margin-top: 0.3rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .checkbox-group label {
            color: white;
            font-size: 0.9rem;
        }

        .create-account-btn {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .create-account-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .login-link {
            display: block;
            text-align: center;
            color: white;
            margin-top: 1rem;
            text-decoration: none;
            font-size: 0.9rem;
        }

        footer {
            background: linear-gradient(135deg, #211d69 0%, #FF1493 100%);
            padding: 1rem 5%;
            color: white;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-tagline {
            text-align: center;
            margin-bottom: 1rem;
        }

        .footer-tagline h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            background: linear-gradient(to right, #fff, #ffd1e8);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            color: transparent;
        }

        .footer-tagline p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            justify-items: center;
            padding: 2rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .quick-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .quick-links a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 2rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        .error {
    color: red;
    font-size: 14px;
    margin-top: 5px;
        }

        @media (max-width: 768px) {
            footer {
                padding: 3rem 1.5rem;
            }
            
            .quick-links {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .footer-tagline h3 {
                font-size: 1.5rem;
            }
        }
        
    </style>
</head>
<body>
    <nav>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 600 120" class="logo">
            <g transform="translate(30, 10)">
                <path d="M50 35 C45 25, 30 25, 25 35 C20 45, 25 55, 50 75 C75 55, 80 45, 75 35 C70 25, 55 25, 50 35" fill="#FF1493"/>
                <path d="M15 55 C12 55, 5 58, 5 75 C5 82, 8 87, 15 90 L25 92 C20 85, 18 80, 20 75 C22 70, 25 68, 30 70 C28 65, 25 62, 20 62 C15 62, 15 65, 15 55" fill="#9932CC"/>
                <path d="M85 55 C88 55, 95 58, 95 75 C95 82, 92 87, 85 90 L75 92 C80 85, 82 80, 80 75 C78 70, 75 68, 70 70 C72 65, 75 62, 80 62 C85 62, 85 65, 85 55" fill="#9932CC"/>
                <path d="M45 40 Q50 45, 55 40 Q52 35, 45 40" fill="#FF69B4" opacity="0.5"/>
            </g>
            <text x="150" y="80" font-family="Arial Black, sans-serif" font-weight="900" font-size="60" fill="#333">GUARDSPHERE</text>
            <text x="150" y="105" font-family="Arial, sans-serif" font-size="20" fill="#666">GUARDED BY GUARDSPHERE.</text>
        </svg>
        <div class="nav-links">
            <a href="land.php">About Us</a>
            <a href="#services">Services</a>
            <a href="#contact">Contact</a>
        </div>
    </nav>

    <div class="main-content">
    <div class="signup-form">
        <h2>Create Account</h2>
        <p>Join GuardSphere for enhanced safety</p>

        <form id="signupForm" method="post" action="signup.inc.php">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <div class="error" id="emailError"></div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
                <div class="error" id="passwordError"></div>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm your password" required>
                <div class="error" id="confirmPasswordError"></div>
            </div>

            <button type="submit" class="create-account-btn">Create Account</button>
        </form>

        <a href="signin.php" class="login-link">Already have an account? Sign in now</a>
    </div>
    </div>


    <footer>
        <div class="footer-content">
            <div class="footer-tagline">
                <h3>GuardSphere</h3>
                <p>Empowering women with safety and security solutions worldwide.</p>
            </div>
            <div class="quick-links">
                <a href="#about">About Us</a>
                <a href="#courses">Safety Courses</a>
                <a href="#products">Products</a>
                <a href="#help">Emergency Help</a>
                <a href="#plans">Subscription Plans</a>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 GuardSphere. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission initially

            let valid = true;

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;

            // Email validation
            if (!email.endsWith('@gmail.com')) {
                document.getElementById('emailError').textContent = 'Email must end with @gmail.com';
                valid = false;
            } else {
                document.getElementById('emailError').textContent = '';
            }

            // Password validation
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasMinLength = password.length >= 6;

            let passwordError = '';
            if (!hasMinLength) {
                passwordError += 'Password must be at least 6 characters\n';
                valid = false;
            }
            if (!hasUpperCase) {
                passwordError += 'Password must contain at least one uppercase letter\n';
                valid = false;
            }
            if (!hasLowerCase) {
                passwordError += 'Password must contain at least one lowercase letter\n';
                valid = false;
            }
            if (!hasSpecialChar) {
                passwordError += 'Password must contain at least one special character\n';
                valid = false;
            }
            if (!hasNumber) {
                passwordError += 'Password must contain at least one number\n';
                valid = false;
            }
            
            document.getElementById('passwordError').textContent = passwordError;

            // Confirm password validation
            if (password !== confirmPassword) {
                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                valid = false;
            } else {
                document.getElementById('confirmPasswordError').textContent = '';
            }

            if (valid) {
                // If validation passes, actually submit the form
                this.submit();
            }
        });
    </script>
</body>
</html>
