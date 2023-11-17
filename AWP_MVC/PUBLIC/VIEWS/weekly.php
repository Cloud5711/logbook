<?php
include('../../CONFIG/connection.php');
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Add Semester Button -->
    <button onclick="redirectToSemester()">Semester</button>

    <canvas id="dailyVisitorsChart" width="400" height="200"></canvas>

    <script>
        fetch('fetch2.php')
            .then(response => response.json())
            .then(data => {
                if (data && data.Semester) {
                    const colors = [
                        'brown', 'red', 'green', 'purple', 'orange', 'black'
                    ];

                    const ctx = document.getElementById('dailyVisitorsChart').getContext('2d');
                    const chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(data.Semester),
                            datasets: [{
                                label: 'Semester Visitors',
                                data: Object.values(data.Semester),
                                backgroundColor: colors.slice(0, Object.keys(data.Semester).length),
                                barThickness: 100,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    max: Math.max(...Object.values(data.Semester)) + 10, // Adjust the maximum value
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
                                    const selectedSemester = Object.keys(data.Semester)[index];
                                    window.location.href = `display1.php?selectedSemester=${selectedSemester}`;
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

        function redirectToSemester() {
            // Redirect to semester.php when the button is clicked
            window.location.href = 'semester.php';
        }
    </script>
</body>
