'use strict';

if (typeof Modernizr != 'undefined') {
    if (Modernizr.svg) $('html').removeClass('no-svg').addClass('svg');
    if (Modernizr.bgsizecover) $('html').removeClass('no-bgsizecover').addClass('bgsizecover');
}


$(function () {
    // Magic mouse screen width
    var deviceWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;

    //Hoisted variables
    var $form = $('#loan-form'),
        root = $('html');


    // Validate form and rules
    $form.validate({
        rules: {
            // compound rule
            email: {
                required: true,
                email: true
            }
        },
        // custom messages
        messages: {
            email: {
                required: "Email address must not be empty",
                email: "Email address is not valid"
            }
        },
        onfocusout: false,
        onkeyup: false
    });


    // Ajax submit form
    $form.submit(function(){
    if($form.valid() == false) return false;
        var data = {
            "action": "test"
        };
        data = $(this).serialize() + "&" + $.param(data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "ajax.php",
            data: data,
            success: function(data) {
                $(".the-return").html(
                    "Email: " + data.email + "<br />Total Loan: " + data.loan
                );
            }
        });
        return false;
    });


    // Replace the validation UI for all forms
    var forms = document.querySelectorAll( "form" );
    for ( var i = 0; i < forms.length; i++ ) {
        replaceBubbleFormUI( forms[ i ] );
    }

});
// end ready



/**
 * Update constraint form input validation
 * @param form
 */

function replaceBubbleFormUI( form ) {
    // Suppress the default bubbles
    form.addEventListener( "invalid", function( event ) {
        event.preventDefault();
    }, true );

    // Support Safari, iOS Safari, and the Android browser—each of which do not prevent
    // form submissions by default
    form.addEventListener( "submit", function( event ) {
        if ( !this.checkValidity() ) {

            event.preventDefault();
        }
    });

    var submitButton = form.querySelector( "button:not([type=button]), input[type=submit]" );
    if(submitButton !== null) {
        submitButton.addEventListener( "click", function( event ) {
            var invalidFields = form.querySelectorAll( ":invalid" ),
                errorMessages = form.querySelectorAll( ".error-message" ), parent;
            // Remove any existing messages
            for ( var i = 0; i < errorMessages.length; i++ ) {
                errorMessages[ i ].parentNode.removeChild( errorMessages[ i ] );
            }
            for ( var i = 0; i < invalidFields.length; i++ ) {
                parent = invalidFields[ i ].parentN
            }
            // If there are errors, give focus to the first invalid field
            if ( invalidFields.length > 0 ) invalidFields[ 0 ].focus();

        });
    }
}