<?php
include 'db.php';

$hospital = [];
$message = '';

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $hospital_id = $_GET['id'];
    $query_hospital = "SELECT name, specialties, rating, phone_number, address, website_link FROM hospitals WHERE id = $1";
    $result_hospital = pg_query_params($conn, $query_hospital, array($hospital_id));

    if ($result_hospital) {
        $hospital = pg_fetch_assoc($result_hospital);
        if (!$hospital) {
            $message = "Hospital not found with ID: " . htmlspecialchars($hospital_id);
        }
    } else {
        $message = "Query failed. Error: " . pg_last_error($conn);
    }
} else {
    $message = 'Invalid or missing hospital ID.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Information - HealthHubFinder</title>
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

        .hospital-info-container {
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

        .hospital-info-container::before {
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
            margin-bottom: 2rem;
            text-align: center;
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

        .info-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .info-card:hover {
            transform: translateX(10px);
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .info-icon {
            font-size: 1.5rem;
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8f5e9;
            border-radius: 10px;
            color: #4CAF50;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .info-value {
            color: #34495e;
            font-size: 1.1rem;
        }

        .rating-stars {
            color: #f1c40f;
            font-size: 1.2rem;
            letter-spacing: 2px;
        }

        .website-link {
            color: #4CAF50;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .website-link:hover {
            color: #45a049;
            transform: translateX(5px);
            text-decoration: none;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn {
            flex: 1;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-back {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            border: none;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #5a6268 0%, #3d4246 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
            color: white;
        }

        .btn-review {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            border: none;
        }

        .btn-review:hover {
            background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
            color: white;
        }

        .alert {
            background: #fff3cd;
            border: none;
            border-radius: 15px;
            padding: 2rem;
            color: #856404;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .hospital-info-container {
                padding: 2rem;
            }

            h1 {
                font-size: 2rem;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hospital-info-container">
            <?php if (!empty($hospital)): ?>
                <h1>
                    <span class="hospital-icon">🏥</span>
                    <?php echo htmlspecialchars($hospital['name']); ?>
                </h1>

                <div class="info-card">
                    <div class="info-icon">👨‍⚕️</div>
                    <div class="info-content">
                        <div class="info-label">Specialties</div>
                        <div class="info-value"><?php echo htmlspecialchars($hospital['specialties']); ?></div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">⭐</div>
                    <div class="info-content">
                        <div class="info-label">Rating</div>
                        <div class="info-value">
                            <span class="rating-stars">
                                <?php
                                $rating = (int)$hospital['rating'];
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating ? "★" : "☆";
                                }
                                ?>
                            </span>
                            <span class="rating-text">(<?php echo htmlspecialchars($hospital['rating']); ?> out of 5)</span>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">📞</div>
                    <div class="info-content">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value"><?php echo htmlspecialchars($hospital['phone_number']); ?></div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-icon">📍</div>
                    <div class="info-content">
                        <div class="info-label">Address</div>
                        <div class="info-value"><?php echo htmlspecialchars($hospital['address']); ?></div>
                    </div>
                </div>

                <?php if (!empty($hospital['website_link'])): ?>
                    <div class="info-card">
                        <div class="info-icon">🌐</div>
                        <div class="info-content">
                            <div class="info-label">Website</div>
                            <div class="info-value">
                                <a href="<?php echo htmlspecialchars($hospital['website_link']); ?>" 
                                   target="_blank" 
                                   class="website-link">
                                    Visit Website
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="action-buttons">
                    <a href="find_hos.php" class="btn btn-back">
                        <span>←</span> Back to Search
                    </a>
                    <a href="review.php?id=<?php echo htmlspecialchars($hospital_id); ?>" 
                       class="btn btn-review">
                        Write a Review ✍️
                    </a>
                </div>
            <?php else: ?>
                <div class="alert">
                    ⚠️ <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
