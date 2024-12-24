<?php

session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Hospital Home Page</title>
    <link rel="stylesheet" href="css/home.css" />
  </head>
  <body>
    <header class="header">
      <nav class="navbar">
        <div class="logo">
          <a href="#">E-Hospital</a>
        </div>
        <input type="checkbox" id="menu-toggle" />
        <label for="menu-toggle" id="hamburger-btn">&#9776;</label>
        <ul class="links">
          <li><a href="#">Home</a></li>
          <li><a href="res.php">Booking</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
          <div class="buttons">
              <?php if(isset($_SESSION['user']['userName'])): ?>
                  <a href="auth/logout.php" class="login">Logout</a>
              <?php else: ?>
                  <a href="auth/login.php" class="login">Log In</a>
                  <a href="auth/register.php" class="signup">Sign Up</a>
              <?php endif; ?>
          </div>

      </nav>
    </header>
    <div class="card-list">
        <div class="card-item">
            <img src="photos/ibm2s2cn.png" alt="" />
            <span class="internal">Internal Medicine</span>
            <h3>
                Receive expert care and management for chronic illnesses in Internal
                Medicine, ensuring your long-term health.
            </h3>
            <form action="php/DoctorsList.php" method="GET">
                <input type="hidden" name="specialty" value="Internal Medicine" />
                <button type="submit" class="view-doctors-btn">View Doctors</button>
            </form>
        </div>

        <div class="card-item">
            <img src="photos/ny8yk62i.png" alt="" />
            <span class="surgery">General Surgery</span>
            <h3>
                Trust skilled hands for life-saving procedures and precision
                treatments in General Surgery.
            </h3>
            <form action="php/DoctorsList.php" method="GET">
                <input type="hidden" name="specialty" value="General Surgery" />
                <button type="submit" class="view-doctors-btn">View Doctors</button>
            </form>
        </div>

        <div class="card-item">
            <img src="photos/ny8yk62i.png" alt="" />
            <span class="Orthopedics">Orthopedics</span>
            <h3>
                Get advanced care for bones, joints, and muscles to stay active and pain-free.
            </h3>
            <form action="php/DoctorsList.php" method="GET">
                <input type="hidden" name="specialty" value="Orthopedics" />
                <button type="submit" class="view-doctors-btn">View Doctors</button>
            </form>
        </div>
        <div class="card-item">
            <img src="photos/ny8yk62i.png" alt="" />
            <span class="Cardiology">Cardiology</span>
            <h3>
                Ensure a healthy heart with expert diagnostics and treatments in Cardiology.
            </h3>
            <form action="php/DoctorsList.php" method="GET">
                <input type="hidden" name="specialty" value="Cardiology" />
                <button type="submit" class="view-doctors-btn">View Doctors</button>
            </form>
        </div>
        <div class="card-item">
            <img src="photos/ny8yk62i.png" alt="" />
            <span class="Neurology">Neurology</span>
            <h3>
                Receive specialized care for brain, spine, and nervous system conditions in Neurology.
            </h3>
            <form action="php/DoctorsList.php" method="GET">
                <input type="hidden" name="specialty" value="Neurology" />
                <button type="submit" class="view-doctors-btn">View Doctors</button>
            </form>
        </div>
        <div class="card-item">
            <img src="photos/ny8yk62i.png" alt="" />
            <span class="Oncology">Oncology</span>
            <h3>
                Access cutting-edge cancer treatments and compassionate care in Oncology.
            </h3>
            <form action="php/DoctorsList.php" method="GET">
                <input type="hidden" name="specialty" value="Oncology" />
                <button type="submit" class="view-doctors-btn">View Doctors</button>
            </form>
        </div>

        <!-- Add similar sections for other specialties -->
    </div>

  </body>
</html>
