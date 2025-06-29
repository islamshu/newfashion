/*=========================================================================================
    File Name: wizard-steps.js
    Description: wizard steps page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Modern Admin - Clean Bootstrap 4 Dashboard HTML Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

// Wizard tabs with numbers setup
$(".number-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function(event, currentIndex) {
        alert("Form submitted.");
    }
});

// Wizard tabs with icons setup
$(".icons-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function(event, currentIndex) {
        alert("Form submitted.");
    }
});

// Vertical tabs form wizard setup
$(".vertical-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    stepsOrientation: "vertical",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onFinished: function(event, currentIndex) {
        alert("Form submitted.");
    }
});

// Validate steps wizard

// Show form
var form = $(".steps-validation").show();
var is_ok = 1;
function errorfunc(){
    alert('error');
     is_ok = 0;

    return false;
};
function successfun(){
    alert('success');
    $('.error_test').empty();

    // To remove error styles
    form.find(".body:eq(" + newIndex + ") label.error").remove();
    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
}


$(".steps-validation").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    labels: {
        finish: 'Submit'
    },
    onStepChanging: function(event, currentIndex, newIndex) {
        alert(currentIndex);
        if (currentIndex == 0) {
            event.preventDefault();
            let url = $('#validation_employee').val();
            var data = new FormData($('#validation_form_emp')[0]);

            $.ajax({
                type: 'Post',
                url: url,
                data: data,
                processData: false,
                contentType: false,
                success:function(response){
                    return successfun(); 
                },
                error: function(response) {

                    // If form submission fails, display validation errors in the modal

                    var errors = response.responseJSON.errors;
                    $('.error_test').empty();

                    $.each(errors, function(field, messages) {
                        // var input = $('#validation_form_emp').find([name="' + field + '"]');
                        // input.addClass('is-invalid');
                        // input.next('.invalid-feedback').html(messages[0]);
                        $('.error_test').append(messages + '<br>');

                    });
                    return errorfunc(); 

                    



                }

            });
        }
        // Allways allow previous action even if the current form is not valid!
        if (currentIndex > newIndex) {

            return true;
        }
        // Forbid next action on "Warning" step if the user is to young
        

        // Needed in some cases if the user went back (clean up)
        
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function(event, currentIndex) {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function(event, currentIndex) {
        document.querySelector('.steps-validation').submit()

    }
});

// Initialize validation
$(".steps-validation").validate({
    ignore: 'input[type=hidden]', // ignore hidden fields
    errorClass: 'danger',
    successClass: 'success',
    highlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass(errorClass);
    },
    errorPlacement: function(error, element) {
        error.insertAfter(element);
    },
    rules: {
        email: {
            email: true
        }
    }
});


