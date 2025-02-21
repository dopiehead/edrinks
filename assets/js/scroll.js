// Function to scroll to the top of the page
function topFunction() {
  // Scroll to the top of the page smoothly
  $('html, body').animate({ scrollTop: 0 }, 'fast');
}

// Show the "Scroll to Top" button when the user scrolls down 20px, and hide it when near the top
$(document).scroll(function() {
  var y = $(this).scrollTop();
  if (y > 20) {
    $('.btn-down').fadeIn();  // Show the button
  } else {
    $('.btn-down').fadeOut();  // Hide the button
  }
});
