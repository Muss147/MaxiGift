"use strict";

// Class definition
var KTAccountSettingsSigninMethods = function () {
    // Private functions
    var initSettings = function () {
        // UI elements
        var signInMainEl = document.getElementById('kt_signin_email');

        if (!signInMainEl) {
            return;
        }

        var signInEditEl = document.getElementById('kt_signin_email_edit');
        var passwordMainEl = document.getElementById('kt_signin_password');
        var passwordEditEl = document.getElementById('kt_signin_password_edit');

        // button elements
        var signInChangeEmail = document.getElementById('kt_signin_email_button');
        var signInCancelEmail = document.getElementById('kt_signin_cancel');
        var passwordChange = document.getElementById('kt_signin_password_button');
        var passwordCancel = document.getElementById('kt_password_cancel');

        // toggle UI
        signInChangeEmail.querySelector('button').addEventListener('click', function () {
            toggleChangeEmail();
        });

        signInCancelEmail.addEventListener('click', function () {
            toggleChangeEmail();
        });

        passwordChange.querySelector('button').addEventListener('click', function () {
            toggleChangePassword();
        });

        passwordCancel.addEventListener('click', function () {
            toggleChangePassword();
        });

        var toggleChangeEmail = function () {
            signInMainEl.classList.toggle('d-none');
            signInChangeEmail.classList.toggle('d-none');
            signInEditEl.classList.toggle('d-none');
        }

        var toggleChangePassword = function () {
            passwordMainEl.classList.toggle('d-none');
            passwordChange.classList.toggle('d-none');
            passwordEditEl.classList.toggle('d-none');
        }
    }

    var handleChangeEmail = function (e) {
        var validation;

        // form elements
        var signInForm = document.getElementById('kt_signin_change_email');

        if (!signInForm) {
            return;
        }

        validation = FormValidation.formValidation(
            signInForm,
            {
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: "L'Email est requis"
                            },
                            emailAddress: {
                                message: "La valeur n'est pas une adresse Email valide"
                            }
                        }
                    },

                    confirmemailpassword: {
                        validators: {
                            notEmpty: {
                                message: 'Le Mot de Passe est requis'
                            }
                        }
                    }
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

        signInForm.querySelector('#kt_signin_submit').addEventListener('click', function (e) {
            e.preventDefault();
            console.log('click');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    // Show loading indication
                    signInForm.querySelector('#kt_signin_submit').setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click 
                    signInForm.querySelector('#kt_signin_submit').disabled = true;

                    setTimeout(function () {
                        // Remove loading indication
                        signInForm.querySelector('#kt_signin_submit').removeAttribute('data-kt-indicator');

                        // Enable button
                        signInForm.querySelector('#kt_signin_submit').disabled = false;
                        
                        swal.fire({
                            text: "L'adresse Email a été mise à jour",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, compris!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function(){
                            signInForm.reset();
                            validation.resetForm(); // Reset formvalidation --- more info: https://formvalidation.io/guide/api/reset-form/
                        });
                        signInForm.submit(); // Submit form
                    }, 2000);
                } else {
                    swal.fire({
                        text: "Désolé, il semble que des erreurs aient été détectées, veuillez réessayer.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, compris!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    });
                }
            });
        });
    }

    var handleChangePassword = function (e) {
        var validation;

        // form elements
        var passwordForm = document.getElementById('kt_signin_change_password');

        if (!passwordForm) {
            return;
        }

        validation = FormValidation.formValidation(
            passwordForm,
            {
                fields: {
                    currentpassword: {
                        validators: {
                            notEmpty: {
                                message: 'Le Mot de Passe actuel est requis'
                            }
                        }
                    },

                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Nouveau Mot de Passe requis'
                            }
                        }
                    },

                    confirmpassword: {
                        validators: {
                            notEmpty: {
                                message: 'Confirmation du Mot de Passe requise'
                            },
                            identical: {
                                compare: function() {
                                    return passwordForm.querySelector('[name="newpassword"]').value;
                                },
                                message: 'Le Mot de Passe et sa Confirmation ne sont pas les mêmes'
                            }
                        }
                    },
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

        passwordForm.querySelector('#kt_password_submit').addEventListener('click', function (e) {
            e.preventDefault();
            console.log('click');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    // Show loading indication
                    passwordForm.querySelector('#kt_password_submit').setAttribute('data-kt-indicator', 'on');

                    // Disable button to avoid multiple click 
                    passwordForm.querySelector('#kt_password_submit').disabled = true;

                    setTimeout(function () {
                        // Remove loading indication
                        passwordForm.querySelector('#kt_password_submit').removeAttribute('data-kt-indicator');

                        // Enable button
                        passwordForm.querySelector('#kt_password_submit').disabled = false;
                        
                        swal.fire({
                            text: "Mot de Passe mis à jour",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, compris!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light-primary"
                            }
                        }).then(function(){
                            passwordForm.reset();
                            validation.resetForm(); // Reset formvalidation --- more info: https://formvalidation.io/guide/api/reset-form/
                        });
                        passwordForm.submit(); // Submit form
                    }, 2000);
                } else {
                    swal.fire({
                        text: "Désolé, il semble que des erreurs aient été détectées, veuillez réessayer.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, compris!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    });
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            initSettings();
            handleChangeEmail();
            handleChangePassword();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTAccountSettingsSigninMethods.init();
});