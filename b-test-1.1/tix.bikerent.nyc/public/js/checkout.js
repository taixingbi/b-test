var stripe = Stripe('pk_test_qxDJZS072og0j7HS8Fn1tG6g');
var elements = stripe.elements();

var card = elements.create('card', {
    iconStyle: 'solid',
    style: {
        base: {
            iconColor: '#8898AA',
            color: '#8798AB',
            lineHeight: '36px',
            fontWeight: 300,
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSize: '19px',

            '::placeholder': {
                color: '#8898AA',
            },
        },
        invalid: {
            iconColor: '#e85746',
            color: '#e85746',
        }
    },
    classes: {
        focus: 'is-focused',
        empty: 'is-empty',
    },
});
card.mount('#card-element');

var inputs = document.querySelectorAll('input.field');
Array.prototype.forEach.call(inputs, function(input) {
    input.addEventListener('focus', function() {
        input.classList.add('is-focused');
    });
    input.addEventListener('blur', function() {
        input.classList.remove('is-focused');
    });
    input.addEventListener('keyup', function() {
        if (input.value.length === 0) {
            input.classList.add('is-empty');
        } else {
            input.classList.remove('is-empty');
        }
    });
});

// function setOutcome(result) {
//     var successElement = document.querySelector('.success');
//     var errorElement = document.querySelector('.error');
//     successElement.classList.remove('visible');
//     errorElement.classList.remove('visible');
//
//     if (result.token) {
//         // Use the token to create a charge or a customer
//         // https://stripe.com/docs/charges
//         successElement.querySelector('.token').textContent = result.token.id;
//
//
//         successElement.classList.add('visible');
//     } else if (result.error) {
//         errorElement.textContent = result.error.message;
//         errorElement.classList.add('visible');
//     }
// }
//
// card.on('change', function(event) {
//     setOutcome(event);
// });
//
// document.querySelector('form').addEventListener('submit', function(e) {
//     e.preventDefault();
//     var form = document.querySelector('form');
//     var extraDetails = {
//         name: form.querySelector('input[name=cardholder-name]').value,
//     };
//     stripe.createToken(card, extraDetails).then(setOutcome);
// });

card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// var form = document.getElementById('payment-form');
// form.addEventListener('submit', function(event) {
//     event.preventDefault();
//
//     stripe.createToken(card).then(function(result) {
//         if (result.error) {
//             // Inform the user if there was an error
//             var errorElement = document.getElementById('card-errors');
//             errorElement.textContent = result.error.message;
//         } else {
//             // Send the token to your server
//             stripeTokenHandler(result.token);
//         }
//     });
// });

// function stripeTokenHandler(token) {
//     // Insert the token ID into the form so it gets submitted to the server
//     var form = document.getElementById('payment-form');
//     var hiddenInput = document.createElement('input');
//     hiddenInput.setAttribute('type', 'hidden');
//     hiddenInput.setAttribute('name', 'stripeToken');
//     hiddenInput.setAttribute('value', token.id);
//     form.appendChild(hiddenInput);
//
//     // Submit the form
//     form.submit();
// }


