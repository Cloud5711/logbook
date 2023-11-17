<?php
include("../../CONFIG/connection.php");
?>

<link rel="stylesheet" href="../RESOURCES/CSS/dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


                    <body>
                   <div class="sidebar">
                   <div class="logo"></div>
                    <ul class="menu">
                    <li class="active">
                    <a href="#">
                    <i class="fas fa-tachometer-alt"></i>
                      <span>Dashboard</span>
                    </a>
                    </li>
                    <li>
                    <a href="admin_profile.php">
                    <i class="fas fa-user"></i>
                    <span>Admin</span>
                      
                    </a>
                    </li>
                    <li>
                    <a href="#">
                    <i class="fa-solid fa-barcode"></i>
                    <span>Scan Barcode</span>
                    </a>
                    </li>
                    <li class="logout">
                    <a href="#">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                    </a>
                    </li>
                    </ul>
                </div>
                <div class="main--content">
                <div class="header--wrapper">
                <div class="header--title">
                <img src="image/image.png" alt="Avatar" class="avatar">
                <span>SAINT JOSEPH COLLEGE of BAGGAO</span>
                <h2>LIBRARY LOGBOOK SYSTEM</h2>
                </div>
                <div class="user--info">
                <div class="search--box">
                <i class="fa-solid fa-search"></i>
                <input type="text" placeholder="Search" />
                </div>
                    
                </div>
                </div> 