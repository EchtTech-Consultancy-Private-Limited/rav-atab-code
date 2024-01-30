document.addEventListener('DOMContentLoaded', function () {
  var spocForm = document.getElementById('spocForm');
  var nextBtn = document.getElementById('nextBtn');
  var personNameInput = document.getElementById('person_name');
  var contactNumberInput = document.getElementById('Contact_Number');
  var emailInput = document.getElementById('emailId');
  var designationInput = document.querySelector('input[name="designation"]');
  var contactError = document.getElementById('contact_error');
  var emailError = document.getElementById('email_id_error');

  // Function to check if all fields are filled
  function checkForm() {
    var personName = personNameInput.value.trim();
    var contactNumber = contactNumberInput.value.trim();
    var email = emailInput.value.trim();
    var designation = designationInput.value.trim();
    var duplicateContact = contactError.textContent === 'Contact number is already in use.';
    var duplicateEmail = emailError.textContent === 'Email is already in use.';

    if (personName !== '' && (contactNumber !== '' && contactNumber.length>9 ) && email !== '' && designation !== '' && !duplicateContact && !duplicateEmail) {
      nextBtn.removeAttribute('disabled');
    } else {
      nextBtn.setAttribute('disabled', true);
    }
  }

  // Attach an event listener to each input to check the form on input change
  personNameInput.addEventListener('input', checkForm);
  contactNumberInput.addEventListener('input', checkForm);
  emailInput.addEventListener('input', checkForm);
  designationInput.addEventListener('input', checkForm);

   // Check email duplicacy
   function checkEmailDuplicacy(email) {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (emailRegex.test(email)) {
      if (email.includes('@@')) {
        emailError.textContent = 'Invalid email format.';
        $('#backendError').text = '';
        nextBtn.setAttribute('disabled', true);
      }else{
        const isApplicationEmailExist = window.location.pathname.split('/').length 
      if(isApplicationEmailExist<3){
        $.ajax({
          type: 'POST',
          url: routeEmailValidation, // Update with your Laravel route URL
          data: {
            email: email,
            _token: csrfToken // Replace with the way you generate CSRF token in your Blade view
          },
          success: function (response) {
            if (response.status === 'duplicate') {
              // Display the error message in the #email_id_error span
              $('#backendError').text = '';
              emailError.textContent = 'Email is already in use.';
            } else {
              // Clear the error message if the email is unique
              emailError.textContent = '';
            }
            checkForm();
          },
          error: function (xhr, status, error) {
            // Handle AJAX errors if needed
          }
        });
      }
      }
    } else {
      // Display an error message for an invalid email format
      emailError.textContent = 'Invalid email format.';
      checkForm();
    }
  }

  // Check contact number duplicacy
  function checkContactNumberDuplicacy(contactNumber) {
    if (/^\d{10}$/.test(contactNumber)) {
      // Send an AJAX request
      const isApplicationEmailExist = window.location.pathname.split('/').length 
      if(isApplicationEmailExist<3){
        $.ajax({
          type: 'POST',
          url: routePhoneValidation, // Update with your Laravel route URL
          data: {
            contact_number: contactNumber,
            _token: csrfToken // Replace with the way you generate CSRF token in your Blade view
          },
          success: function (response) {
            if (response.status === 'duplicate') {
              // Display the error message in the #contact_error span
              contactError.textContent = 'Contact number is already in use.';
            } else {
              // Clear the error message if the contact number is unique
              contactError.textContent = '';
            }
            checkForm();
          },
          error: function (xhr, status, error) {
            // Handle AJAX errors if needed
          }
        });
      }
      $("#nextBtn").attr("disabled",false);
    } else {
      // Display an error message for an invalid contact number
      contactError.textContent = 'Contact number must be 10 digits and numeric';
      $("#nextBtn").attr("disabled",true);
      checkForm();
    }
  }

 

  // Event listeners for contact number and email input fields
  contactNumberInput.addEventListener('keyup', function () {
    var contactNumber = this.value;
    contactError.textContent = ''; // Clear previous error message
    if (contactNumber.trim() !== '') {
      checkContactNumberDuplicacy(contactNumber);
    }
  });

  emailInput.addEventListener('keyup', function () {
    var email = this.value;
    emailError.textContent = ''; // Clear previous error message
    if (email.trim() !== '') {
      checkEmailDuplicacy(email);
    }
  });

  // Initial check when the page loads
  checkForm();
});