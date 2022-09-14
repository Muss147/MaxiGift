"use strict";

// Class definition
var KTAppEcommerceSaveProduct = function () {

    // Submit form handler
    const handleSubmit = () => {
        // Define variables
        let validator;

        // Get elements
        const form = document.getElementById('kt_enquete_edit_form');
        const submitButton = document.getElementById('kt_enquete_edit_submit');
        const publishButton = document.getElementById('kt_enquete_edit_publish');

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    // 'cover': {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Veuillez sélectionner une image'
                    //         },
                    //         file: {
                    //             extension: 'jpg,jpeg,png',
                    //             type: 'image/jpeg,image/png',
                    //             message: "Le fichier selectionné n'est pas valide"
                    //         },
                    //     }
                    // },
                    'nom': {
                        validators: {
                            notEmpty: {
                                message: "Le Nom de l'enquête est requis"
                            }
                        }
                    },
                    'points': {
                        validators: {
                            notEmpty: {
                                message: "Le Nombre de Points est requis"
                            }
                        }
                    },
                    'entreprise': {
                        validators: {
                            notEmpty: {
                                message: "Veuillez selectionner une entreprise"
                            }
                        }
                    },
                    'description': {
                        validators: {
                            notEmpty: {
                                message: "La Description est requise"
                            }
                        }
                    },
                    "conditions[]['question']": {
                        validators: {
                            notEmpty: {
                                message: 'La Question est requise'
                            }
                        }
                    },
                    "conditions[]['reponse']": {
                        validators: {
                            notEmpty: {
                                message: 'La Réponse est requise'
                            }
                        }
                    },
                    "conditions[]['return']": {
                        validators: {
                            notEmpty: {
                                message: 'La Redirection est requise'
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

        // Handle submit button
        submitButton.addEventListener('click', e => {
            e.preventDefault();

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        submitButton.setAttribute('data-kt-indicator', 'on');

                        // Disable submit button whilst loading
                        submitButton.disabled = true;

                        setTimeout(function () {
                            submitButton.removeAttribute('data-kt-indicator');

                            Swal.fire({
                                text: "Form has been successfully submitted!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    // Enable submit button after loading
                                    submitButton.disabled = false;
                                    //window.location = form.getAttribute("data-kt-redirect");
                                }
                            });
                            // Redirect to list page
                            form.submit();
                        }, 2000);
                    } else {
                        Swal.fire({
                            html: "Sorry, looks like there are some errors detected, please try again. <br/><br/>Please note that there may be errors in the <strong>General</strong> or <strong>Advanced</strong> tabs",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        });
        // Handle publish button
        publishButton.addEventListener('click', e => {
            e.preventDefault();
            $('input[name=publish]').prop('disabled', false);

            // Validate form before submit
            if (validator) {
                validator.validate().then(function (status) {
                    console.log('validated!');

                    if (status == 'Valid') {
                        publishButton.setAttribute('data-kt-indicator', 'on');

                        // Disable submit button whilst loading
                        publishButton.disabled = true;

                        setTimeout(function () {
                            publishButton.removeAttribute('data-kt-indicator');

                            Swal.fire({
                                text: "Form has been successfully submitted!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            }).then(function (result) {
                                if (result.isConfirmed) {
                                    // Enable submit button after loading
                                    publishButton.disabled = false;
                                    //window.location = form.getAttribute("data-kt-redirect");
                                }
                            });
                            // Redirect to list page
                            form.submit();
                        }, 2000);
                    } else {
                        Swal.fire({
                            html: "Sorry, looks like there are some errors detected, please try again. <br/><br/>Please note that there may be errors in the <strong>General</strong> or <strong>Advanced</strong> tabs",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }
        })
    }

    // Public methods
    return {
        init: function () {
            // Handle forms
            handleSubmit();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceSaveProduct.init();
});