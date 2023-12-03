// script.js
const toggleButton = document.getElementById('toggleButton');
const nameList = document.getElementById('nameList');

toggleButton.addEventListener('click', () => {
    if (nameList.style.display === 'none' || nameList.style.display === '') {
        nameList.style.display = 'block'; // Show the list
    } else {
        nameList.style.display = 'none'; // Hide the list
    }
});
