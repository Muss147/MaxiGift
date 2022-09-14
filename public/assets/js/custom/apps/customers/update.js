"use strict";

// Class definition
var KTModalUpdateCustomer = function () {
    var submitButton;
    var validator;
    var form;

    // Init form inputs
    var initForm = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validator = FormValidation.formValidation(
			form,
			{
				fields: {
                    'name': {
						validators: {
							notEmpty: {
								message: 'La Raison Sociale est requise'
							}
						}
					},
					'registre': {
						validators: {
							notEmpty: {
								message: 'Le Numéro de Régistre est requis'
							}
						}
					},
					'secteur': {
						validators: {
							notEmpty: {
								message: "Le Secteur d'Activité est requis"
							}
						}
					},
					'nomContact': {
						validators: {
							notEmpty: {
								message: 'Le Nom est requis'
							}
						}
					},
					'prenomContact': {
						validators: {
							notEmpty: {
								message: 'Le Prénom est requis'
							}
						}
					},
                    'emailContact': {
						validators: {
							notEmpty: {
								message: "L'Adresse Email est requise"
							}
						}
					},
					'tel': {
						validators: {
							notEmpty: {
								message: 'Le Téléphone Mobile est requis'
							}
						}
					}
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

        // Action buttons
        submitButton.addEventListener('click', function (e) {
            // Prevent default button action
            e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						submitButton.setAttribute('data-kt-indicator', 'on');

						// Disable submit button whilst loading
						submitButton.disabled = true;

                        // Simulate form submission
                        setTimeout(function () {
                            // Simulate form submission
                            submitButton.removeAttribute('data-kt-indicator');

                            // Show popup confirmation 
                            Swal.fire({
                                text: "Le formulaire a été soumis avec succès!!",
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
					} else {
						Swal.fire({
							text: "Désolé, il semble que des erreurs aient été détectées, veuillez réessayer.",
							icon: "error",
							buttonsStyling: false,
							confirmButtonText: "Ok, compris!",
							customClass: {
								confirmButton: "btn btn-primary"
							}
						});
					}
				});
			}
        });
    }

    return {
        // Public functions
        init: function () {

            form = document.querySelector('#kt_modal_update_customer_form');
            submitButton = form.querySelector('#kt_modal_update_customer_submit');
            initForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTModalUpdateCustomer.init();
});