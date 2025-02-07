
function add(button) {
  const input = button.parentElement.querySelector('.quantity-input');
  const subtractBtn = button.parentElement.querySelector('#subtractBtn');
  let value = parseInt(input.value);
  value++;
  input.value = value;
  
  // Enable subtract button if value > 1
  if (value > 1) {
      subtractBtn.disabled = false;
  }
}

function subtract(button) {
  const input = button.parentElement.querySelector('.quantity-input');
  let value = parseInt(input.value);
  if (value > 1) {
      value--;
      input.value = value;
      
      // Disable subtract button if value is 1
      if (value === 1) {
          button.disabled = true;
      }
  }
}

function checkValue(input) {
  const subtractBtn = input.parentElement.querySelector('#subtractBtn');
  let value = parseInt(input.value);
  
  // Ensure value is not less than 1
  if (value < 1 || isNaN(value)) {
      input.value = 1;
      value = 1;
  }
  
  // Update subtract button state
  subtractBtn.disabled = value === 1;

}
      
$('.numbering').load('engine/item-numbering.php');

