<?php
include('db.php');

$sql = "SELECT review_id, rating, comments FROM review";
$result = pg_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reviews Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('image/com.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            z-index: 0;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            padding: 30px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 50px;
            animation: fadeInDown 0.8s ease-out;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        .review-stats {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            animation: fadeInUp 0.8s ease-out;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            text-align: center;
        }

        .stat-item {
            padding: 15px;
        }

        .stat-item h3 {
            font-size: 2rem;
            color: #2c3e50;
            margin: 0;
        }

        .stat-item p {
            color: #7f8c8d;
            margin: 5px 0 0;
        }

        .review-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease-out;
            animation-fill-mode: both;
        }

        .review-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .review-id {
            font-size: 0.9rem;
            color: #95a5a6;
        }

        .stars {
            color: #f1c40f;
            font-size: 1.2rem;
            letter-spacing: 2px;
        }

        .review-content {
            color: #34495e;
            line-height: 1.6;
            margin-top: 15px;
        }

        .empty-state {
            text-align: center;
            padding: 50px;
            color: #7f8c8d;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>User Reviews Dashboard</h1>
            <p>See what our community is saying</p>
        </div>

        <div class="review-stats">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3><?php echo pg_num_rows($result); ?></h3>
                    <p>Total Reviews</p>
                </div>
                <div class="stat-item">
                    <h3>4.8</h3>
                    <p>Average Rating</p>
                </div>
                <div class="stat-item">
                    <h3>92%</h3>
                    <p>Satisfaction Rate</p>
                </div>
            </div>
        </div>

        <?php
        if (pg_num_rows($result) > 0) {
            $delay = 0;
            while ($row = pg_fetch_assoc($result)) {
                $delay += 0.1;
                echo "<div class='review-card' style='animation-delay: {$delay}s'>";
                echo "<div class='review-header'>";
                echo "<span class='review-id'>Review #" . htmlspecialchars($row["review_id"]) . "</span>";
                echo "<div class='stars'>";
                $rating = (int)$row["rating"];
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $rating ? "★" : "☆";
                }
                echo "</div>";
                echo "</div>";
                echo "<div class='review-content'>" . htmlspecialchars($row["comments"]) . "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='empty-state'>";
            echo "<h3>No Reviews Yet</h3>";
            echo "<p>Be the first to share your experience!</p>";
            echo "</div>";
        }
        ?>
    </div>

    <script>
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.review-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>
<?php
pg_close($conn);
?>
