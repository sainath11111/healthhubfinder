<?php
ini_set('display_errors', 1);
error_reporting(E_ALL); 
include 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $is_verified = isset($_POST['is_verified']) ? 1 : 0;

    if (strlen($phone_number) != 10 || !ctype_digit($phone_number)) {
        $message = "❌ Please enter a valid 10-digit phone number!";
    } else {
        $query = "INSERT INTO \"User\" (name, email, phone_number, password, is_verified) VALUES ($1, $2, $3, $4, $5)";
        $result = pg_query_params($conn, $query, array($name, $email, $phone_number, $password, $is_verified));

        if ($result) {
            $message = "✅ User registered successfully!";
            header("Location: find_hos.php");
            exit();
        } else {
            $message = "❌ Error: " . pg_last_error($conn);
        }
        pg_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join HealthHubFinder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #4CAF50, #45a049);
        }

        h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            padding-bottom: 1rem;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #4CAF50, #45a049);
            border-radius: 2px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
            background: #fff;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .btn-submit {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            border: none;
            padding: 1rem;
            width: 100%;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }

        .btn-login {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            text-decoration: none;
            padding: 1rem;
            border-radius: 12px;
            display: block;
            text-align: center;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
            color: white;
            text-decoration: none;
        }

        .alert {
            border-radius: 12px;
            padding: 1rem;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideIn 0.5s ease-out;
        }

        .alert-info {
            background: #e1f5fe;
            border: 1px solid #b3e5fc;
            color: #0288d1;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .form-container {
                padding: 2rem;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>🏥 Join HealthHubFinder</h1>

            <?php if (!empty($message)): ?>
                <div class="alert alert-info">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="name">👤 Full Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">📧 Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">📱 Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" 
                           pattern="\d{10}" title="Please enter a valid 10-digit phone number" required>
                </div>

                <div class="form-group">
                    <label for="password">🔒 Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="checkbox-wrapper">
                    <input type="checkbox" id="is_verified" name="is_verified" class="form-check-input">
                    <label for="is_verified" class="form-check-label">✅ I verify that all information is correct</label>
                </div>

                <button type="submit" class="btn-submit">Create Account 🚀</button>
                <a href="login.php" class="btn-login">Already have an account? Sign in 🔑</a>
            </form>
        </div>
    </div>
</body>
</html>
