fetch('fetch1.php')
    .then(response => response.json())
    .then(data => {
        const colors = [
            'brown', 'red', 'green', 'purple', 'orange', 'black'
        ];

        const ctx = document.getElementById('dailyVisitorsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data.Daily),
                datasets: [
                    {
                        label: 'Daily Visitors',
                        data: Object.values(data.Daily),
                        backgroundColor: colors.slice(0, Object.keys(data.Daily).length), // Match colors to data points
                    },
                    {
                        label: 'Weekly Visitors',
                        data: Object.values(data.Weekly),
                    },
                    {
                        label: 'Monthly Visitors',
                        data: Object.values(data.Monthly),
                        backgroundColor: colors.slice(0, Object.keys(data.Monthly).length), // Match colors to data points
                    },
                    {
                        label: 'Semester Visitors',
                        data: Object.values(data.Semester),
                    }
                ]
            },
            options: {
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
                }
            }
        });
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        
    });
