<?php
// Include the database connection
include 'db.php';

// Initialize a message variable
$message = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $city = $_POST['city'];  // Single city selected
    $state = $_POST['state'];  // Single state selected
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $specialties = implode(", ", $_POST['specialties']);  // Join selected specialties into a comma-separated string
    $rating = $_POST['rating']; // Capture the rating from the form
    $website_link = $_POST['website_link']; // Capture the website link
    $password = $_POST['password']; // Capture the password from the form

    // Validate required fields
    if (empty($name) || empty($address) || empty($city) || empty($state) || empty($phone_number) || empty($email) || empty($specialties) || empty($rating) || empty($password)) {
        $message = "⚠️ All fields are required!";
    } elseif (strlen($phone_number) !== 10 || !ctype_digit($phone_number)) {
        $message = "❌ Please enter a valid 10-digit phone number!";
    } else {
        // Check if connection is valid
        if (!$conn) {
            $message = "❌ Database connection failed!";
        } else {
            // Prepare the insert query using prepared statements to avoid SQL injection
            $query = "INSERT INTO hospitals (name, address, city, state, phone_number, email, specialties, rating, website_link, password) 
                      VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
            
            // Execute the query with parameters
            $result = pg_query_params($conn, $query, array($name, $address, $city, $state, $phone_number, $email, $specialties, $rating, $website_link, $password));

            // Check if the query was successful
            if ($result) {
                $message = "✅ Hospital details added successfully!";
            } else {
                // Fetch PostgreSQL error message and display it
                $error = pg_last_error($conn);
                $message = "❌ Error adding hospital: " . $error;
                // Log the error for debugging
                error_log("PostgreSQL Error: " . $error); // Log the error
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
    <title>Add Hospital Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Page background */
        body {
            background-image: url('image/bg2.webp'); /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            color: #333;
            font-family: 'Arial', sans-serif;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent white background for the form */
            padding: 50px;
            border-radius: 22px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            max-width: 800px;
            margin-left: auto; /* Center align */
            margin-right: auto;
        }

        .form-container h1 {
            color: #007bff; /* Bright blue color for the title */
            font-size: 36px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .form-group label {
            font-weight: bold;
            color: #000; /* Dark black text for labels */
        }

        .form-control, .btn {
            border-radius: 8px;
            font-size: 16px;
            padding: 10px;
            color: #000; /* Dark black text for form inputs */
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .alert-info {
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
            font-weight: bold;
        }

        .emoji {
            font-size: 30px;
            margin-right: 10px;
        }

        /* Adding hover effects */
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-block {
            font-size: 18px;
        }

        .form-group select, .form-group input {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h1 class="text-center mb-4">🏥 Add Hospital Details</h1>

            <!-- Display a message if the operation was successful or failed -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-info">
                    <span class="emoji">💬</span><?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Form to add hospital details -->
            <form method="POST">
                <div class="form-group">
                    <label for="name">Hospital Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="state">State:</label>
                    <select id="state" name="state" class="form-control" required>
                        <option value="Maharashtra">Maharashtra 🇮🇳</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
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
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" pattern="\d{10}" title="Phone number must be 10 digits" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="specialties">Specialties (Select multiple):</label>
                    <select id="specialties" name="specialties[]" class="form-control" multiple required>
                        <option value="Cardiology">Cardiology(heart) ❤️</option>
                        <option value="Orthopedics">Orthopedics(bones) 🦵</option>
                        <option value="Neurology">Neurology(brain,spinal) 🧠</option>
                        <option value="Pediatrics">Pediatrics(children) 👶</option>
                        <option value="Dermatology">Dermatology(cancer) 🧴</option>
                        <option value="Gynecology">Gynecology(women's diseases) 🩺</option>
                        <option value="General Surgery">General Surgery 🏥</option>
                        <option value="Ophthalmology">Ophthalmology(eye) 👁️</option>
                        <option value="Psychiatry">Psychiatry(kidney)</option>
                        <option value="All Specialties">All Specialties 💉</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="rating">Rating (1 to 5):</label>
                    <div>
                        <input type="radio" id="rating1" name="rating" value="1" required>
                        <label for="rating1">1 🌟</label>
                        <input type="radio" id="rating2" name="rating" value="2">
                        <label for="rating2">2 🌟</label>
                        <input type="radio" id="rating3" name="rating" value="3">
                        <label for="rating3">3 🌟</label>
                        <input type="radio" id="rating4" name="rating" value="4">
                        <label for="rating4">4 🌟</label>
                        <input type="radio" id="rating5" name="rating" value="5">
                        <label for="rating5">5 🌟</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="website_link">Website Link 🌐:</label>
                    <input type="url" id="website_link" name="website_link" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password 🔐:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">🔒 Add Hospital</button>
                <a href="healthhub.php" class="btn btn-secondary btn-block" style="margin-top: 10px;">🔙 Back</a>
            </form>
        </div>
    </div>
</body>
</html>

