<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');
?>

<head>

</head>

<body>
    <canvas id="dailyVisitorsChart"style="margin-top:px;" margin="50" width="400" height="203"></canvas>


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

            const ctx = document.getElementById('dailyVisitorsChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Monthly Visitors',
                        data: uniqueMonths.map(month => data.Monthly[month] || 0),
                        backgroundColor: colors.slice(0, uniqueMonths.length),
                        barThickness: 100,
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

function redirectToSemester() {
    // Redirect to semester.php when the button is clicked
    window.location.href = 'semester.php';
}

    </script>
</body>
