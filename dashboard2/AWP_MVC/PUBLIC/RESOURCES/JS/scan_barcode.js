document.getElementById('barcode').addEventListener('input', function (event) {
  // Check if the length of the input is equal to the expected barcode length
  if (event.target.value.length === 12) {
      // Automatically submit the form
      document.getElementById('barcodeForm').submit();
      // Clear the input field after submission
      event.target.value = '';
  }
});

// Automatically focus on the input field when the page loads
window.onload = function () {
  document.getElementById('barcode').focus();
};
