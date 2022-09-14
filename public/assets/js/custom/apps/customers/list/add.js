"use strict";

// Class definition
var KTModalCustomersAdd = function () {
    var submitButton;
    var cancelButton;
	var closeButton;
    var validator;
    var form;
    var modal;

    // Init form inputs
    var handleForm = function () {
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
			e.preventDefault();

			// Validate form before submit
			if (validator) {
				validator.validate().then(function (status) {
					console.log('validated!');

					if (status == 'Valid') {
						submitButton.setAttribute('data-kt-indicator', 'on');

						// Disable submit button whilst loading
						submitButton.disabled = true;

						setTimeout(function() {
							submitButton.removeAttribute('data-kt-indicator');
							
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
									// Hide modal
									modal.hide();

									// Enable submit button after loading
									submitButton.disabled = false;

									// Redirect to customers list page
									window.location = form.getAttribute("data-kt-redirect");
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

        cancelButton.addEventListener('click', function (e) {
            e.preventDefault();

            Swal.fire({
                text: "Êtes-vous sûr de vouloir annuler?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Oui, annuler!",
                cancelButtonText: "Non, fermer",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form	
                    modal.hide(); // Hide modal				
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Le formulaire n'a pas été annulé!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, compris!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
        });

		closeButton.addEventListener('click', function(e){
			e.preventDefault();

            Swal.fire({
                text: "Êtes-vous sûr de vouloir annuler?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Oui, annuler!",
                cancelButtonText: "Non, fermer",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    form.reset(); // Reset form	
                    modal.hide(); // Hide modal				
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Le formulaire n'a pas été annulé!.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, compris!",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        }
                    });
                }
            });
		})
    }

    return {
        // Public functions
        init: function () {
            // Elements
            modal = new bootstrap.Modal(document.querySelector('#kt_modal_add_customer'));

            form = document.querySelector('#kt_modal_add_customer_form');
            submitButton = form.querySelector('#kt_modal_add_customer_submit');
            cancelButton = form.querySelector('#kt_modal_add_customer_cancel');
			closeButton = form.querySelector('#kt_modal_add_customer_close');
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
	KTModalCustomersAdd.init();
});