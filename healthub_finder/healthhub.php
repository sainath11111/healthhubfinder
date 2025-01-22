<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthHubFinder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            color: #2c3e50;
            overflow-x: hidden;
        }

        .navbar {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem 2rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
        }

        .navbar-brand::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #fff;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover::after {
            transform: scaleX(1);
        }

        .nav-link {
            font-weight: 500;
            position: relative;
            padding: 0.5rem 1rem;
            margin: 0 0.5rem;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #fff;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .nav-link:hover::before {
            transform: scaleX(1);
        }

        .hero-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 3rem;
            margin-top: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            min-height: 400px;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(40, 167, 69, 0.1) 0%, rgba(0, 123, 255, 0.1) 100%);
            z-index: 0;
        }

        .hero-section .text {
            position: relative;
            z-index: 1;
            max-width: 600px;
        }

        .hero-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            animation: slideInLeft 1s ease-out;
        }

        .hero-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #34495e;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .hero-section img {
            position: absolute;
            right: -50px;
            top: 50%;
            transform: translateY(-50%);
            max-width: 500px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: floatImage 6s ease-in-out infinite;
        }

        .btn-container {
            margin: 3rem 0;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 1px;
            border-radius: 50px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-lg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255,255,255,0.1), rgba(255,255,255,0.2));
            z-index: -1;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.5s ease;
        }

        .btn-lg:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #218838 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .choose-us-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin: 1rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .choose-us-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #28a745, #007bff);
        }

        .choose-us-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .choose-us-card h4 {
            color: #2c3e50;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .choose-us-card p {
            color: #34495e;
            font-size: 1rem;
            line-height: 1.6;
        }

        footer {
            background: linear-gradient(135deg, #2c3e50 0%, #1a252f 100%);
            color: white;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shine 3s linear infinite;
        }

        @keyframes shine {
            to {
                transform: translateX(100%);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes floatImage {
            0%, 100% {
                transform: translateY(-50%) translateX(0);
            }
            50% {
                transform: translateY(-50%) translateX(-20px);
            }
        }

        .img-fluid {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .img-fluid:hover {
            transform: scale(1.02);
        }

        @media (max-width: 768px) {
            .hero-section {
                text-align: center;
                padding: 2rem;
            }

            .hero-section img {
                position: relative;
                right: 0;
                top: 0;
                transform: none;
                margin-top: 2rem;
                width: 100%;
                max-width: 300px;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn-lg {
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <img src="image/logo.png" style="height: 60px; width: 60px; margin-right: 1rem;" alt="Logo">
    <a class="navbar-brand" href="#">
        HealthHub<br>Finder+
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="information.html">ℹ️ Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="admin.php">👨‍⚕️ Admin</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="hero-section">
        <div class="text">
            <h1>Welcome to HealthHubFinder</h1>
            <p>"Discover a trusted platform designed to help you find top-quality hospitals in our areas and healthcare services with ease. Whether you're seeking the best medical care or looking to contribute your own healthcare facility, HealthHubFinder connects you to reliable and verified health professionals worldwide. Your health journey starts here!" 🌍</p>
        </div>
        <img src="image/health.jpeg" alt="HealthHub Finder Image">
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5 btn-container">
            <a href="user.php" class="btn btn-primary btn-lg w-100">
                🔍 Search for Hospitals
            </a>
        </div>
        <div class="col-md-5 btn-container">
            <a href="add_hospital.php" class="btn btn-success btn-lg w-100">
                ➕ Add Your Own Hospital details
            </a>
        </div>
    </div>

    <div class="text-center mt-5">
        <h2 class="mb-4">Why Choose Us?</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="choose-us-card">
                    <h4>Easy Access 🚀</h4>
                    <p>Quickly find hospitals and health services across the state and cities.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="choose-us-card">
                    <h4>Verified Listings ✅</h4>
                    <p>All hospitals listed are verified to ensure quality service.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="choose-us-card">
                    <h4>Global Reach 🌎</h4>
                    <p>Access a wide range of hospitals and healthcare professionals worldwide.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 text-center">
        <img src="image/doctors.jpeg" alt="HealthHub Finder" class="img-fluid">
    </div>
</div>

<footer class="mt-5">
 
    <div class="container text-center">
    <marquee>
        <p class="mb-0">&copy; 2024 HealthHubFinder. All Rights Reserved. 🌟</p>
         </marquee>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
