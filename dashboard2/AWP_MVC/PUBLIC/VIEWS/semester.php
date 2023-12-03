<?php
include('../../CONFIG/DB_Configuration.php');
include('index.php');
?>

<body>
    <!-- Add Semester Button -->
    <button onclick="redirectToSemester()" type="button" class="btn btn-success" style="margin-top: 2px;">Monthly Chart</button>
    <canvas id="dailyVisitorsChart" style="margin-top:30px;" width="350" height="166"></canvas>

    <script>
        fetch('fetchsemester.php')
            .then(response => response.json())
            .then(data => {
                if (data && data.Semester) {
                    const colors = ['brown', 'red', 'green', 'purple', 'orange', 'black'];

                    const ctx = document.getElementById('dailyVisitorsChart').getContext('2d');

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
                                barThickness: 90,
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


        function redirectToSemester() {
            window.location.href = 'monthly.php';
        }
    </script>


  </body>
</html>