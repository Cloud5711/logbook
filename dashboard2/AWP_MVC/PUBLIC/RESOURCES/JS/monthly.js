fetch('fetchmonthly.php')
.then(response => response.json())
.then(data => {
    if (data && data.Monthly) {
        const colors = ['brown', 'red', 'green', 'purple', 'orange', 'black'];

        const ctx = document.getElementById('dailyVisitorChart').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ],
                datasets: [{
                    label: 'Monthly Visitors',
                    data: Object.values(data.Monthly),
                    backgroundColor: colors.slice(0, Object.keys(data.Monthly).length),
                    barThickness: 90,
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
                        const selectedMonth = Object.keys(data.Monthly)[index];
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