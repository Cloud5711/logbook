<?php
include("../../CONFIG/connection.php");

?>

<!DOCTYPE html>
<html>
<head>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <canvas id="dailyVisitorsChart" width="400" height="200"></canvas>
    
    <script>
        fetch('fetch.php')
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
                                barThickness: 100,
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
                                window.location.href = `nextPage.php?selectedDay=${selectedDay}&visitorsCount=${visitorsCount}`;

                            }
                        },
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>
</body>
</html>
