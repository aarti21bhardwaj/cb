
var elements = stripe.elements();
var style = {
  base: {
    // Add your base input styles here. For example:
    fontSize: '20px',
    color: "#32325d",
  }
};

// Create an instance of the card Element
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>
console.log("$('#card-element')");
console.log($('#card-element'));
card.mount('#card-element');


card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  //var abc = $('#payment-form').validator('validate');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});


var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
  event.preventDefault();
  if($("#payment-form").valid()) {
      stripe.createToken(card).then(function(result) {
        if (result.error) {
          // Inform the customer that there was an error
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
        } else {
          // Send the token to your server
          console.log('hahaha');
          console.log(result.token);
          stripeTokenHandler(result.token);
        }
      });
  }
});


$('#payment-form-submit').on('click', function(){
	$("#payment-form").valid();
});

function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('payment-form');
  var hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);
  // Submit the form
  form.submit();
  $('#payment-form-submit').html('Processing ...');
  $('#payment-form-submit').attr("disabled", "disabled");
}
