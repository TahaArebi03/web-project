<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">

    <style>
        .active {
            background-color: #2c3e50;
        }
        .main-content {
            flex: 1;
            padding: 20px;
        }

        .main-content h2 {
            margin-bottom: 20px;
        }

        .statistics {
            display: flex;
            gap: 20px;
            justify-content: space-around;
        }

        .stat-card {
            flex: 1;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .stat-card p {
            font-size: 18px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <div>
        <h1>Clinic Panel</h1>
        <ul>
            <li><a href="#" class="active">Dashboard</a></li>
            <li><a href="doctors/index.php">Doctors</a></li>
            <li><a href="#">Patients</a></li>
        </ul>
    </div>
    <div class="sidebar-footer">
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="main-content">
    <h2>Dashboard Statistics</h2>
    <div class="statistics">
        <div class="stat-card">
            <h3>50</h3>
            <p>Doctors</p>
        </div>
        <div class="stat-card">
            <h3>200</h3>
            <p>Patients</p>
        </div>
        <div class="stat-card">
            <h3>150</h3>
            <p>Appointments</p>
        </div>
    </div>
</div>
</body>
</html>
