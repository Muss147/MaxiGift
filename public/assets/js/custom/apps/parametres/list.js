"use strict";

// Class definition
var KTAppEcommerceCategories = function () {
    // Shared variables
    var table;
    var datatable;

    // Private functions
    var initDatatable = function () {
        // Init datatable --- more info on datatables: https://datatables.net/manual/
        datatable = $(table).DataTable({
            "info": false,
            'order': [],
            'pageLength': 10,
            'columnDefs': [
                { orderable: false, targets: 0 }, // Disable ordering on column 0 (checkbox)
                { orderable: false, targets: 4 }, // Disable ordering on column 3 (actions)
            ]
        });

        // Re-init functions on datatable re-draws
        datatable.on('draw', function () {
            handleDeleteRows();
            initToggleToolbar();
            toggleToolbars();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = () => {
        const filterSearch = document.querySelector('[data-kt-ecommerce-category-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            datatable.search(e.target.value).draw();
        });
    }

    // Delete cateogry
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = table.querySelectorAll('[data-kt-ecommerce-category-filter="delete_row"]');
        const formDelete = document.querySelector('#kt_delete_param_form');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get category name
                const categoryName = parent.querySelector('[data-kt-ecommerce-category-filter="category_name"]').innerText;

                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Êtes-vous sûr de vouloir supprimer " + categoryName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Oui, supprimer!",
                    cancelButtonText: "Non, annuler",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        setTimeout(function () {
                            Swal.fire({
                                text: "Vous avez supprimé " + categoryName + "!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, compris!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function () {
                                // Remove current row
                                datatable.row($(parent)).remove().draw();
                            });
                            formDelete.submit(); // Submit form
                        }, 3000);
                    }
                });
            })
        });
    }

    // Init toggle toolbar
    var initToggleToolbar = () => {
        // Toggle selected action toolbar
        // Select all checkboxes
        const checkboxes = table.querySelectorAll('[type="checkbox"]');
        const formMultiDelete = document.querySelector('#kt_delete_multi_param_form');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-customer-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        // Deleted selected rows
        deleteSelected.addEventListener('click', function () {
            // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
            Swal.fire({
                text: "Êtes-vous sûr de vouloir supprimer la selection?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Non, annuler",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then(function (result) {
                if (result.value) {
                    // Remove all selected customers
                    var inputGroup = '';
                    Array.from(checkboxes).slice(1).forEach(c => {
                        if (c.checked) {
                            inputGroup += '<input type="hidden" name="paramsDeleted[]" value="'+c.value+'">';
                            datatable.row($(c.closest('tbody tr'))).remove().draw();
                        }
                    });
                    formMultiDelete.querySelector('.input-group').innerHTML = inputGroup;

                    // Remove header checked box
                    const headerCheckbox = table.querySelectorAll('[type="checkbox"]')[0];
                    headerCheckbox.checked = false;
                    
                    setTimeout(function () {
                        Swal.fire({
                            text: "Vous avez supprimer la selection!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, compris!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        }).then(function () {
                        });
                        formMultiDelete.submit(); // Submit form
                    }, 3000);
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "La selection n'a pas été supprimée.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, compris!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
        });
    }

    // Toggle toolbars
    const toggleToolbars = () => {
        // Define variables
        const toolbarBase = document.querySelector('[data-kt-customer-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-customer-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-customer-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements 
        const allCheckboxes = table.querySelectorAll('tbody [type="checkbox"]');

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    // Public methods
    return {
        init: function () {
            table = document.querySelector('#kt_ecommerce_category_table');

            if (!table) {
                return;
            }

            initDatatable();
            handleSearchDatatable();
            handleDeleteRows();
            initToggleToolbar();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTAppEcommerceCategories.init();
});