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
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
          <div class="buttons">
              <?php if(isset($_SESSION['user']['name'])): ?>
                  <a href="auth/logout.php" class="login">Logout</a>
              <?php else: ?>
                  <a href="auth/login.php" class="login">Log In</a>
                  <a href="auth/register.php" class="signup">Sign Up</a>
              <?php endif; ?>
          </div>

      </nav>
    </header>
    <div class="card-list">
      <a href="#" class="card-item">
        <img src="photos/ibm2s2cn.png" alt="" />
        <span class="internal">Internal Medicine</span>
        <h3>
          Receive expert care and management for chronic illnesses in Internal
          Medicine, ensuring your long-term health.
        </h3>
      </a>
      <a href="#" class="card-item">
        <img src="photos/ny8yk62i.png" alt="" />
        <span class="surgery">General Surgery</span>
        <h3>
          Trust skilled hands for life-saving procedures and precision
          treatments in General Surgery.
        </h3>
      </a>
      <a href="#" class="card-item">
        <img src="photos/9d2tq81j.png" alt="" />
        <span class="ophthalmology">Ophthalmology</span>
        <h3>
          Preserve your eyesight and treat eye conditions effectively with our
          specialized Ophthalmology services.
        </h3>
      </a>
      <a href="#" class="card-item">
        <img src="photos/zdzjdv04.png" alt="" />
        <span class="otorhinolaryngology">Otorhinolaryngology</span>
        <h3>
          Find relief for ear, nose, and throat issues with personalized care in
          Otorhinolaryngology.
        </h3>
      </a>
      <a href="#" class="card-item">
        <img src="photos/37f0ilul.png" alt="" />
        <span class="radiology">Radiology</span>
        <h3>
          Rely on advanced imaging like X-rays and MRIs for quick and accurate
          results in Radiology.
        </h3>
      </a>
      <a href="#" class="card-item">
        <img src="photos/wmdrc5la.png" alt="" />
        <span class="psychiatry">Psychiatry</span>
        <h3>
          Improve your mental health and overall well-being with supportive and
          tailored care in Psychiatry.
        </h3>
      </a>
      <a href="#" class="card-item">
        <img src="photos/sgdcmymr.png" alt="" />
        <span class="Dermatology">Dermatology</span>
        <h3>
          Treat skin conditions, enhance your appearance, and regain confidence
          with our expert Dermatology team.
        </h3>
      </a>
      <a href="#" class="card-item">
        <img src="photos/8o9ywzds.png" alt="" />
        <span class="Pediatrics">Pediatrics</span>
        <h3>
          Keep your child healthy and thriving with compassionate and
          comprehensive care in Pediatrics.
        </h3>
      </a>
      <a href="#" class="card-item">
        <img src="photos/8p7qhwth.png" alt="" />
        <span class="Plastic surgery">Plastic surgery</span>
        <h3>
          Restore form and function or enhance your natural beauty with skilled
          procedures in Plastic Surgery.
        </h3>
      </a>
    </div>
  </body>
</html>
