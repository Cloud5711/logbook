
    function validateForm() {
      // You can add client-side validation here if needed
      return true; // Return true to submit the form
      
    }
 
  
  // JavaScript function to show the error box
function showErrorModal() {
  const errorModal = document.getElementById("error-modal");
  if (errorModal) {
    errorModal.style.display = "block";
  }
}

// JavaScript function to hide the error box
function hideErrorModal() {
  const errorModal = document.getElementById("error-modal");
  if (errorModal) {
    errorModal.style.display = "none";
  }
}
