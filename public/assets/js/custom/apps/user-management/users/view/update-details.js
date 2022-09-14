"use strict";

// Class definition
var KTUsersUpdateDetails = function () {
    // Shared variables
    const form = document.querySelector('#kt_update_user_form');

    // Init add schedule modal
    var initUpdateDetails = () => {

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        var validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'fname': {
                        validators: {
                            notEmpty: {
                                message: 'Le Nom est requis'
                            }
                        }
                    },
                    'lname': {
                        validators: {
                            notEmpty: {
                                message: 'Le Prénom est requis'
                            }
                        }
                    },
                    'birth': {
                        validators: {
                            notEmpty: {
                                message: 'La Date de Naissance est requise'
                            }
                        }
                    },
                    'contact': {
                        validators: {
                            notEmpty: {
                                message: 'Le Numéro de Téléphone est requis'
                            }
                        }
                    },
                },

                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        );

        // Submit button handler
        const submitButton = form.querySelector('[data-kt-users-modal-action="submit"]');
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

            // Show loading indication
            submitButton.setAttribute('data-kt-indicator', 'on');

            // Disable button to avoid multiple click 
            submitButton.disabled = true;

            // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
            setTimeout(function () {
                // Remove loading indication
                submitButton.removeAttribute('data-kt-indicator');

                // Enable button
                submitButton.disabled = false;

                // Show popup confirmation 
                Swal.fire({
                    text: "Le formulaire a été soumis avec succès!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, compris!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        // modal.hide();
                    }
                });

                form.submit(); // Submit form
            }, 2000);
        });
    }

    return {
        // Public functions
        init: function () {
            initUpdateDetails();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTUsersUpdateDetails.init();
});