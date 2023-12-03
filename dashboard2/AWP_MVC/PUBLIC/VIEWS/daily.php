<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Your Web Page Title</title>

</head>
<body>
<!--<a href='dashboard.php'><<</a>-->
    <canvas id="dailyVisitorsChart" style="margin-top:px;" margin="50" width="400" height="194"></canvas>
    
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
  </body>
</html>