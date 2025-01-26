<?php
include 'db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $specialties = implode(", ", $_POST['specialties']);
    $rating = $_POST['rating'];
    $website_link = $_POST['website_link'];
    $password = $_POST['password'];

    if (empty($name) || empty($address) || empty($city) || empty($state) || empty($phone_number) || empty($email) || empty($specialties) || empty($rating) || empty($password)) {
        $message = "⚠️ All fields are required!";
    } elseif (strlen($phone_number) !== 10 || !ctype_digit($phone_number)) {
        $message = "❌ Please enter a valid 10-digit phone number!";
    } else {
        if (!$conn) {
            $message = "❌ Database connection failed!";
        } else {
            $query = "INSERT INTO hospitals (name, address, city, state, phone_number, email, specialties, rating, website_link, password) 
                      VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
            
            $result = pg_query_params($conn, $query, array($name, $address, $city, $state, $phone_number, $email, $specialties, $rating, $website_link, $password));

            if ($result) {
                $message = "✅ Hospital details added successfully!";
            } else {
                $error = pg_last_error($conn);
                $message = "❌ Error adding hospital: " . $error;
                error_log("PostgreSQL Error: " . $error);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Hospital - HealthHubFinder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            min-height: 100vh;
            padding: 2rem 0;
            color: #2c3e50;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 800px;
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

        .form-control, select {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, select:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
            background: #fff;
        }

        select[multiple] {
            height: auto;
            min-height: 200px;
        }

        .rating-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 12px;
            margin-top: 0.5rem;
        }

        .rating-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rating-option input[type="radio"] {
            display: none;
        }

        .rating-option label {
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: white;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .rating-option input[type="radio"]:checked + label {
            background: #4CAF50;
            color: white;
            border-color: #4CAF50;
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

        .btn-back {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
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

        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
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

            .rating-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>🏥 Register Your Hospital</h1>

            <?php if (!empty($message)): ?>
                <div class="alert alert-info">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="name">🏢 Hospital Name</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="state">🗺️ State</label>
                    <select id="state" name="state" class="form-control" required>
                        <option value="Maharashtra">Maharashtra 🇮🇳</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="city">🌆 City</label>
                    <select id="city" name="city" class="form-control" required>
                        <option value="Mumbai">Mumbai 🌆</option>
                        <option value="Pune">Pune 🌇</option>
                        <option value="Nashik">Nashik 🏙️</option>
                        <option value="Sangamner">Sangamner 🌳</option>
                        <option value="Ahmednagar">Ahmednagar 🏞️</option>
                        <option value="Ahmedabad">Ahmedabad 🏙️</option>
                        <option value="Surat">Surat 🌴</option>
                        <option value="Chennai">Chennai 🌅</option>
                        <option value="Coimbatore">Coimbatore 🏞️</option>
                        <option value="Lucknow">Lucknow 🏙️</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="address">📍 Address</label>
                    <input type="text" id="address" name="address" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">📱 Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" 
                           pattern="\d{10}" title="Please enter a valid 10-digit phone number" required>
                </div>

                <div class="form-group">
                    <label for="email">📧 Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="specialties">👨‍⚕️ Specialties</label>
                    <select id="specialties" name="specialties[]" class="form-control" multiple required>
                        <option value="Cardiology">Cardiology - Heart Care ❤️</option>
                        <option value="Orthopedics">Orthopedics - Bone & Joint Care 🦴</option>
                        <option value="Neurology">Neurology - Brain & Spine Care 🧠</option>
                        <option value="Pediatrics">Pediatrics - Child Care 👶</option>
                        <option value="Dermatology">Dermatology - Skin Care 🧴</option>
                        <option value="Gynecology">Gynecology - Women's Health 👩‍⚕️</option>
                        <option value="General Surgery">General Surgery 🏥</option>
                        <option value="Ophthalmology">Ophthalmology - Eye Care 👁️</option>
                        <option value="Psychiatry">Psychiatry - Mental Health 🧠</option>
                        <option value="All Specialties">All Specialties 💉</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>⭐ Hospital Rating</label>
                    <div class="rating-group">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <div class="rating-option">
                            <input type="radio" id="rating<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" required>
                            <label for="rating<?php echo $i; ?>"><?php echo $i; ?> ⭐</label>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="website_link">🌐 Website URL</label>
                    <input type="url" id="website_link" name="website_link" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">🔒 Admin Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn-submit">Register Hospital 🏥</button>
                <a href="healthhub.php" class="btn-back">Back to Home 🏠</a>
            </form>
        </div>
    </div>
</body>
</html>
