<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Finder</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            min-height: 100vh;
            color: #2c3e50;
            line-height: 1.6;
        }

        .container {
            padding: 2rem 1rem;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 800px;
            margin: 0 auto;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        h1 {
            color: #2c3e50;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.5rem;
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
            background: linear-gradient(90deg, #4caf50, #45a049);
            border-radius: 2px;
        }

        .form-group label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: #4caf50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
            background: #fff;
        }

        select[multiple] {
            height: auto;
            min-height: 200px;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn:hover::after {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #5a6268 0%, #4e555b 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }

        .hospital-list {
            margin-top: 3rem;
        }

        .hospital-item {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .hospital-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .hospital-item h3 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .hospital-info {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .info-item {
            background: #f8f9fa;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rating {
            color: #f1c40f;
            font-weight: 600;
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #138496 0%, #117a8b 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
        }

        .alert {
            border-radius: 15px;
            padding: 1rem 1.5rem;
            margin-top: 2rem;
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            font-weight: 500;
            text-align: center;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            h1 {
                font-size: 2rem;
            }

            .hospital-item {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL); 
    include 'db.php';

    $hospitals = [];
    $message = '';
    $query_states = "SELECT DISTINCT state FROM hospitals ORDER BY state";
    $result_states = pg_query($conn, $query_states);
    $states = pg_fetch_all($result_states);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['state'], $_POST['city'], $_POST['specialties'])) {
        $state = $_POST['state'];
        $city = $_POST['city'];
        $specialties = $_POST['specialties'];

        $where_clause = "WHERE state = $1 AND city = $2";

        if (!empty($specialties)) {
            if (!in_array('All Specialties', $specialties)) {
                $where_clause .= " AND (";
                $conditions = [];
                foreach ($specialties as $specialty) {
                    $conditions[] = "specialties LIKE '%$specialty%'";
                }
                $where_clause .= implode(" OR ", $conditions);
                $where_clause .= ")";
            }
        }

        $query_hospitals = "SELECT id, name, specialties, rating, phone_number, address FROM hospitals $where_clause";
        $result_hospitals = pg_query_params($conn, $query_hospitals, array($state, $city));
        $hospitals = pg_fetch_all($result_hospitals);
    }

    $specialties_display = (!empty($specialties) && !in_array('All Specialties', $specialties)) ? implode(", ", $specialties) : 'All Specialties';
    $state_display = !empty($state) ? htmlspecialchars($state) : 'Any State';
    $city_display = !empty($city) ? htmlspecialchars($city) : 'Any City';
    $specialties_display = !empty($specialties_display) ? htmlspecialchars($specialties_display) : 'All Specialties';
    ?>

    <div class="container">
        <div class="form-container">
            <h1>🏥 Find Your Perfect Hospital</h1>

            <?php if (!empty($message)): ?>
                <div class="alert alert-info">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="state">📍 Select State</label>
                    <select id="state" name="state" class="form-control" required>
                        <option value="Maharashtra">Maharashtra</option>
                        <?php foreach ($states as $state): ?>
                            <option value="<?php echo htmlspecialchars($state['state']); ?>">
                                <?php echo htmlspecialchars($state['state']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="city">🌆 Select City</label>
                    <select id="city" name="city" class="form-control" required>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Pune">Pune</option>
                        <option value="Nagpur">Nagpur</option>
                        <option value="Sangamner">Sangamner</option>
                        <option value="Ahmednagar">Ahmednagar</option>
                        <option value="Ahmedabad">Ahmedabad</option>
                        <option value="nashik">Nashik</option>
                        <option value="Chennai">Chennai</option>
                        <option value="Coimbatore">Coimbatore</option>
                        <option value="Lucknow">Lucknow</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="specialties">👨‍⚕️ Select Specialties (Multiple)</label>
                    <select id="specialties" name="specialties[]" class="form-control" multiple required>
                        <option value="Cardiology">Cardiology (Heart) ❤️</option>
                        <option value="Orthopedics">Orthopedics (Bones) 🦵</option>
                        <option value="Neurology">Neurology (Brain, Spinal) 🧠</option>
                        <option value="Pediatrics">Pediatrics (Children) 👶</option>
                        <option value="Dermatology">Dermatology (Cancer) 🧴</option>
                        <option value="Gynecology">Gynecology (Women's Health) 🩺</option>
                        <option value="General Surgery">General Surgery 🏥</option>
                        <option value="Ophthalmology">Ophthalmology (Eye) 👁️</option>
                        <option value="Psychiatry">Psychiatry (Mental Health) 🧠</option>
                        <option value="All Specialties">All Specialties 💉</option>
                    </select>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-block">🔍 Find Hospitals</button>
                    <a href="healthhub.php" class="btn btn-secondary btn-block">🔙 Back to Home</a>
                </div>
            </form>
        </div>

        <?php if (!empty($hospitals)): ?>
            <div class="hospital-list">
                <h2 class="text-center mb-4">
                    Hospitals in <?php echo $state_display; ?>, <?php echo $city_display; ?>
                    <small class="d-block text-muted mt-2">Specializing in: <?php echo $specialties_display; ?></small>
                </h2>
                
                <?php foreach ($hospitals as $hospital): ?>
                    <div class="hospital-item">
                        <h3><?php echo htmlspecialchars($hospital['name']); ?></h3>
                        <div class="hospital-info">
                            <div class="info-item">
                                <span>🏥</span>
                                <?php echo htmlspecialchars($hospital['specialties']); ?>
                            </div>
                            <div class="info-item">
                                <span>⭐</span>
                                <span class="rating"><?php echo htmlspecialchars($hospital['rating']); ?>/5</span>
                            </div>
                            <div class="info-item">
                                <span>📞</span>
                                <?php echo htmlspecialchars($hospital['phone_number']); ?>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="hos_info.php?id=<?php echo htmlspecialchars($hospital['id']); ?>" 
                               class="btn btn-info">
                                More Information 📋
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <div class="alert">
                <strong>No hospitals found!</strong> Try different search criteria.
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
