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
                        label: 'Daily Visitors',
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
                        max: 100,
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

        const table = document.getElementById('data-table').getElementsByTagName('tbody')[0];

        document.getElementById('dailyVisitorsChart').addEventListener('click', function (event) {
            const activePoints = chart.getElementsAtEvent(event);
            if (activePoints.length > 0) {
                const index = activePoints[0]._index;
                const selectedDay = Object.keys(data)[index];
                const visitorsCount = Object.values(data)[index];

                // Update the table with the selected data
                table.innerHTML = '';
                const row = table.insertRow(0);
                const cell1 = row.insertCell(0);
                const cell2 = row.insertCell(1);
                cell1.innerHTML = selectedDay;
                cell2.innerHTML = visitorsCount;
            }
        });
    })
    .catch(error => console.error('Error fetching data:', error));
