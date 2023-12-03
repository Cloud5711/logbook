
    function updateTopUsers() {
        fetch('visitor.php?type=top')
            .then(response => response.json()) // Assuming PHP script returns JSON data
            .then(data => {
                const topUsersList = document.getElementById('dashboardbox');
                // Clear the existing list
                topUsersList.innerHTML = '';
                // Append the new list items
                data.forEach(user => {
                    const listItem = document.createElement('li');
                    listItem.textContent = user.name;
                    topUsersList.appendChild(listItem);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Add click event listeners to the boxes to trigger data updates
    document.getElementById('top-5-users').addEventListener('click', updateTopUsers);

    // Initial data update
    updateTopUsers();

