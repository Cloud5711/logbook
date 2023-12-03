<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../RESOURCES/CSS/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="../RESOURCES/CSS/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type= "text/css" href="../RESOURCES/CSS/index.css"/>
    <title>Dashboard</title>
  </head>
  <body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="offcanvas"
          data-bs-target="#sidebar"
          aria-controls="offcanvasExample">
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a
          class="navbar-brand me-auto ms-lg-5 ms-3 text-uppercase fw-bold"
          >Library Logbook System</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#topNavBar"
          aria-controls="topNavBar"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="topNavBar">
        <form method="POST"action="search.php" class="d-flex ms-auto my-3 my-lg-0">
            <div class="input-group">
              <input name="search" type="text" placeholder="Search" aria-label="Search"/>
              <button  name="search_button" type="submit">
                <i class="bi bi-search"></i>
              </button>
            </div>
          </form>
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle ms-2"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-person-fill"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="login.php">Logout</a></li>
                <li>
                 
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- top navigation bar -->
    <!-- offcanvas -->
    <div
      class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
      <div class="offcanvas-body p-2" style="background-color: #2C3E50;">
        <nav class="navbar-dark">
          <ul class="navbar-nav">
          <div class="brand-logo">
                    <img src="../../PUBLIC/RESOURCES/IMAGES/sjcbaggao.png" alt="Company Brand Logo" height="30" class="me-2">
                </div> 
            <li>
              <a href="dashboard2.php" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-speedometer2"></i></span>
                <span>Dashboard</span>
              </a>
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
          
            <li>
            <a
                class="nav-link px-3 sidebar-link"
                data-bs-toggle="collapse"
                href="#layouts">
              <span class="me-2"><i class="bi bi-upc"></i></span>
                <span>Scan Barcode</span>
                <span class="ms-auto">
                  <span class="right-icon">
                    <i class="bi bi-barcode"></i>
                  </span>
                </span>
              </a>
              <div class="collapse" id="layouts">
                <ul class="navbar-nav ps-3">
                  <li>
                    <a href="scan.php" class="nav-link px-3">
                      <span class="me-2"
                        ><i class="'bi bi-alarm"></i
                      ></span>
                      <span>Time In & Time Out</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <a href="admin_profile.php" class="nav-link px-3 active">
                <span class="me-2"><i class="bi bi-person"></i></span>
                <span>Admin</span>
              </a>
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
          
          </ul>
        </nav>
      </div>
    </div>
   
    <script src="../RESOURCES/JS/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="../RESOURCES/JS/jquery-3.5.1.js"></script>
    <script src="../RESOURCES/JS/jquery.dataTables.min.js"></script>
    <script src="../RESOURCES/JS/dataTables.bootstrap5.min.js"></script>
    <script src="../RESOURCES/JS/script.js"></script>
  </body>
</html>
