<?php
include('../../CONFIG/DB_Configuration.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../RESOURCES/CSS/bootstrap.min.css" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
    />
    <link rel="stylesheet" href="../RESOURCES/CSS/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" type= "text/css" href="../RESOURCES/CSS/index.css"/>
    <title>Dashboard</title>
  </head>
  <body>
    <!-- top navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="offcanvasExample">
          <span class="navbar-toggler-icon" data-bs-target="#sidebar"></span>
        </button>
        <a
          class="navbar-brand me-auto ms-lg-5 ms-3 text-uppercase fw-bold">Library Logbook System</a>
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

          <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search_button'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    $search_query = "SELECT person.person_ID, person.last_Name, person.first_Name, person.middle_Name, student.Course, student.student_Level, visitor_log.date_visited,
        visitor_log.time_In, visitor_log.time_Out 
        FROM person
        JOIN student ON person.person_ID = student.person_ID
        LEFT JOIN visitor_log ON person.person_ID = visitor_log.person_ID
        WHERE person.first_Name LIKE ? OR
            person.middle_Name LIKE ? OR
            person.last_Name LIKE ? OR
            visitor_log.date_visited LIKE ? OR
            visitor_log.time_In LIKE ? OR
            visitor_log.time_Out LIKE ? OR
            student.Course LIKE ? OR
            student.student_Level LIKE ?";

    $stmt = mysqli_prepare($conn, $search_query);

    
    mysqli_stmt_bind_param($stmt, "ssssssss", $search, $search, $search, $search, $search, $search, $search, $search);

    mysqli_stmt_execute($stmt);
    $search_result = mysqli_stmt_get_result($stmt);

    if (!$search_result) {
        die("Query failed: " . mysqli_error($conn));
    }

    $searchResultsData = [];
    while ($row = mysqli_fetch_assoc($search_result)) {
        $searchResultsData[] = $row;
    }

    // Display the search results
    echo "<table class='table table-bordered'>";
    echo "<tr>
            <th>Grade</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Course</th>
          </tr>";
    foreach ($searchResultsData as $row) {
        echo "<tr>";
        echo "<td>" . $row['student_Level'] . "</td>";
        echo "<td>" . $row['first_Name'] . "</td>";
        echo "<td>" . $row['middle_Name'] . "</td>";
        echo "<td>" . $row['last_Name'] . "</td>";
        echo "<td>" . $row['Course'] . "</td>";
        echo "</tr>";
    }

    echo "</table>";

    mysqli_stmt_close($stmt);
}
?>
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
 
    <!-- offcanvas -->   
    <div class="offcanvas offcanvas-start sidebar-nav bg-dark" tabindex="-1" id="sidebar">
      <div class="offcanvas-body p-2" style="background-color: #2C3E50;">
        <nav class="navbar-dark"  id="sidebar">
          <ul class="navbar-nav">
          <div class="brand-logo">
                    <img src="../../PUBLIC/RESOURCES/IMAGES/sjcbaggao.png" alt="Company Brand Logo" height="30" class="me-2">
                </div>   
            <li>
            <a href="#" class="nav-link px-3 active">
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
              <a href="admin_profile.php" class="nav-link px-3">
                <span class="me-2"><i class="bi bi-person"></i></span>
                <span>Admin</span>
              </a>
            </li>
            <li class="my-4"><hr class="dropdown-divider bg-light" /></li>
          </ul>
        </nav>
      </div>
    </div>
    <!-- offcanvas -->
    <main class="mt-5 pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h4>Statistical Report</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-3">
            <div class="card bg-secondary text-white h-100">
              <div class="card-body py-5">
              <i class="bi bi-person-fill" style="font-size: 1.5rem;"></i>
              Visitors Today</div>
              <div class="card-footer d-flex"><a href="daily_visitors.php">
               View Detail</a>
                <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-warning text-dark h-100">
              <div class="card-body py-5">
              <i class="bi bi-calendar" style="font-size: 1.5rem;"></i> Total Numbers of Visitors</div>
              <div class="card-footer d-flex"><a href="total_visitors.php">
                View Details</a>
                <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <div class="card bg-success text-white h-100">
              <div class="card-body py-5">
              <i class="bi bi-star" style="font-size: 1.5rem;"></i> Top Users</div>
              <div class="card-footer d-flex"><a href="top_users.php">
                View Details</a>
                <span class="ms-auto">
                  <i class="bi bi-chevron-right"></i>
                </span>
              </div>
            </div>
          </div>
        
              </div>
            </div>
          </div>
        <div class="row">
          <div class="col-md-12 mb-3">
            <div class="card">
              <div class="card-header">
              
                  <?php
include('../../CONFIG/DB_Configuration.php');
?>
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
               Daily Visitors
               <a href="daily.php" class="btn btn-success btn-sm float-end">View</a>
              </div>
              <div class="card-body">
                <canvas id="dailyVisitorsChart" class="chart" width="400" height="200"></canvas>
                <script>
                  
        fetch('fetchdaily.php')
            .then(response => response.json())
            .then(data => {
                delete data['Sunday'];

                const colors = [
                    'brown', 'red', 'green', 'purple', 'orange', 'black'
                ];

                const ctx = document.getElementById('dailyVisitorsChart').getContext('2d');
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(data),
                        datasets: [
                            {
                                label: 'Total Visitors',
                                data: Object.values(data),
                                backgroundColor: colors,
                                barThickness: 90,
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: false,
                                max: 200,
                                title: {
                                    display: true,
                                    text: 'Visitors'
                                },
                                grid: {
                                    display: false // Remove grid lines
                                }
                            },
                            x: {
                                grid: {
                                    display: false // Remove grid lines
                                }
                            }
                        },
                        onClick: (e) => {
                            const activePoints = chart.getElementsAtEventForMode(e, 'point', chart.options);
                            if (activePoints.length > 0) {
                                const index = activePoints[0].index;
                                const selectedDay = Object.keys(data)[index];
                                const visitorsCount = Object.values(data)[index];
                                // Replace this line in your JavaScript code
                                window.location.href = `displaydaily.php?selectedDay=${selectedDay}&visitorsCount=${visitorsCount}`;

                            }
                        },
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
                <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
              Monthly Visitors
              <a href="monthly.php" class="btn btn-success btn-sm float-end">View</a>
              </div>
              <div class="card-body">
                <canvas id="monthlyVisitorChart" class="chart" width="387" height="200"></canvas> 
                <script>
      fetch('fetchmonthly.php')
    .then(response => response.json())
    .then(data => {
        if (data && data.Monthly) {
            // Extract unique months from the data
            const uniqueMonths = [...new Set(Object.keys(data.Monthly))];
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            // Create labels with month names
            const labels = uniqueMonths.map(month => {
                const [year, monthNumber] = month.split('-');
                const monthName = monthNames[parseInt(monthNumber, 10) - 1];
                return `${monthName} ${year}`;
            });

            const colors = ['brown', 'red', 'green', 'purple', 'orange', 'black'];

            const ctx = document.getElementById('monthlyVisitorChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Monthly Visitors',
                        data: uniqueMonths.map(month => data.Monthly[month] || 0),
                        backgroundColor: colors.slice(0, uniqueMonths.length),
                        barThickness: 40,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: false,
                            max: 500,
                            title: {
                                display: true,
                                text: 'Visitors'
                            },
                            grid: {
                                display: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    onClick: (event, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const selectedMonth = uniqueMonths[index];
                            window.location.href = `displaymonthly.php?selectedMonth=${selectedMonth}`;
                        }
                    }
                }
            });
        } else {
            console.error('Data or Monthly property is undefined or null.');
        }
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });

    </script>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="card h-100">
              <div class="card-header">
        <span class="me-2"><i class="bi bi-bar-chart-fill"></i></span>
               Semester Visitors
               <a href="semester.php" class="btn btn-success btn-sm float-end">View</a>
              </div>
              <div class="card-body">
                <canvas id="semesterVisitorsChart" class="chart" width="400" height="200"></canvas>
                <script>
                fetch('fetchsemester.php')
            .then(response => response.json())
            .then(data => {
                if (data && data.Semester) {
                    const colors = ['brown', 'red', 'green', 'purple', 'orange', 'black'];

                    const ctx = document.getElementById('semesterVisitorsChart').getContext('2d');

                    const sortedKeys = Object.keys(data.Semester).sort();

                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: sortedKeys.map(label => {
                                
                                const semesterLabel = label === '2023/1' ? '1st Sem' : '2nd Sem';
                                return semesterLabel;
                            }),
                            datasets: [{
                                label: 'Semester Visitors',
                                data: sortedKeys.map(label => data.Semester[label]),
                                backgroundColor: colors.slice(0, sortedKeys.length),
                                barThickness: 70,
                            }]
                        },
                        options: {
    responsive: true,
    maintainAspectRatio: true,
    scales: {
        y: {
            beginAtZero: true,
            max: 500,
            title: {
                display: true,
                text: 'Visitors'
            },
            grid: {
                display: false
            }
        },
        x: {
            grid: {
                display: false
            }
        }
    },
    onClick: (event, elements) => {
        if (elements.length > 0) {
            const index = elements[0].index;
            const selectedSemester = sortedKeys[index];

            // Determine the month range based on the selected semester
            let startMonth, endMonth;
            if (selectedSemester === '2023/1') {
                
                startMonth = 8; // August
                endMonth = 12; // December
            } else if (selectedSemester === '2023/2') {
                
                startMonth = 1; // January
                endMonth = 6; // June
            }

            // Construct the URL with the selected semester and month range
            const url = `displaysemester.php?selectedSemester=${selectedSemester}&startMonth=${startMonth}&endMonth=${endMonth}`;

            // Redirect to display1.php
            window.location.href = url;
        }
    }
}
                    });
                } else {
                    console.error('Data or Semester property is undefined or null.');
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });

        </script>
    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script src="../RESOURCES/JS/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.2/dist/chart.min.js"></script>
    <script src="../RESOURCES/JS/jquery-3.5.1.js"></script>
    <script src="../RESOURCES/JS/jquery.dataTables.min.js"></script>
    <script src="../RESOURCES/JS/dataTables.bootstrap5.min.js"></script>
  </body>
</html>
