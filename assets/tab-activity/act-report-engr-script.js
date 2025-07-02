
  $(document).ready(function () {
    $('#engineername').select2({
        width: '100%',
        multiple: true,
        tags: true,
        ajax: {
            url: '/ldap',
            dataType: 'json',
            delay: 50,
            data: function (params) {
                return {
                    search: params.term // Search term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) { 
                        return {
                            id: item.engineer, 
                            text: item.engineer 
                        };
                    }).sort(function(a, b) {
                        // Compare the engineer names (text) to sort them alphabetically
                        return a.text.localeCompare(b.text);
                    })
                };
            }
        }
    });
});


$(document).ready(function () {
    $('#add_quick_activity').on('shown.bs.modal', function () {
        $('#quick_engineer').select2({
            width: '100%',
            dropdownParent: $('#add_quick_activity .modal-content'),
            multiple:true,
            ajax: {
                url: '/ldap',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        search: params.term // send the typed search term to the server
                    };
                },
                processResults: function (data) {
                    // processing data
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.engineer,
                                text: item.engineer
                            };
                        }).sort(function (a, b) {
                            return a.text.localeCompare(b.text);
                        })
                    };
                }
            }
        });
    });
});

$(document).ready(function () {
$('#add_quick_activity').on('shown.bs.modal', function () {
    $('#quick_product_line_select').select2({
        width: '100%',
        multiple: true,
        dropdownParent: $('#add_quick_activity .modal-content'),
        ajax: {
            url: '/tab-experience-center/productLine/getProductline',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term
                };
            },
            processResults: function (response) {
                if (Array.isArray(response.data)) {
                    return {
                        results: response.data.map(function (getProductline) {
                            return {
                                id: getProductline.flex_value_id,
                                text: getProductline.description,
                                code: getProductline.flex_value // Store the product code in a 'code' attribute
                            };
                        })
                    };
                } else {
                    console.error('Response data is not an array:', response.data);
                    return { results: [] };
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching product lines:', error);
            }
        }
    });
});
    // Event listener for changes in the selected product lines
    $('#quick_product_line_select').on('select2:select', function (e) {
        updateProductCode();
    });

    $('#quick_product_line_select').on('change', function() {
    updateProductLine();
    });

    //for passing data of productline and productCode
    function updateProductLine() {
    var selectedProductLines = $('#quick_product_line_select').select2('data');
    var productLineDescriptions = selectedProductLines.map(function(productLine) {
        return productLine.text; // Retrieve the description instead of the value
    }).join(', ');
    $('#quick_product_input').val(productLineDescriptions);
    }

    function updateProductCode() {
        var selectedProductLines = $('#quick_product_line_select').select2('data');
        var productCodes = selectedProductLines.map(function(productLine) {
            return productLine.code; // Extract the product code from the 'code' attribute
        }).join(', ');
        
        // Update the value of the 'prod_code' input field with the product codes of the selected product lines
        $('#prod_code_input').val(productCodes);

    }
});


function enableActivityTypeSelect() {
    $('#Act_Report_Activity_Type').prop('disabled', false);
}
function disableActivityTypeSelect() {
    $('#Act_Report_Activity_Type').prop('disabled', true);
}


$(document).ready(function() {
    $('#add_quick_activity').on('shown.bs.modal', function () {
        $('#reportDropdown').change(function() {
            var category = $(this).val();
  
            $('#Act_Report_Activity_Type').select2({
                width: '100%',
                dropdownParent: $('#add_quick_activity .modal-content'),
                ajax: {
                    url: `/getQuickActivityTypes/${encodeURIComponent(category)}`,
                    dataType: 'json',
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (activityType) {
                                return {
                                    id: activityType.type_id,
                                    text: activityType.type_name
                                };
                            })
                        };
                    }
                }
            });

            // Check if category value is not equal to 1
            if (category !== "1") {
                enableActivityTypeSelect();
            }else{
                disableActivityTypeSelect();
            }
            $('#Act_Report_Activity_Type').val(null).trigger('change');
        });
    });
});

$(document).ready(function () {
 $('#add_quick_activity').on('shown.bs.modal', function () {
    // Initialize Select2 for the engineers dropdown
    $('.quick_get_time').select2({
        width: '100%',
        dropdownParent: $('#add_quick_activity .modal-content'),
        // minimumInputLength: 1, // Minimum characters to start searching
        ajax: {
            url: '/tab-activity/create-activity/getTime',
            dataType: 'json',
            // delay: 250, // Delay in milliseconds before making the request
            data: function (params) {
                return {
                    term: params.term, // Pass the search term to the server
                };
            },
            processResults: function (response) {
              return {
                  results: response.data
              };
          }
        },
  
    });
 });
});

// document.addEventListener('DOMContentLoaded', function() {
//     var submitBtn = document.getElementById('submit_button');

//     submitBtn.addEventListener('click', function(event) {
//         event.preventDefault();

//         var engineerSelect = document.getElementById('quick_engineer');
//         var selectedOptions = Array.from(engineerSelect.selectedOptions);
//         if (selectedOptions.length === 0) {
//             Swal.fire({ text: "Please choose at least one option for engineer.", icon: "warning"});
//             return;
//         }

//         var fromTimeSelect = document.getElementById('from_time');
//         if (!fromTimeSelect.value) {
//             Swal.fire({ text: "Please select a Time Reported.", icon: "warning"});
//             return;
//         }

//         var toTimeSelect = document.getElementById('to_time');
//         if (!toTimeSelect.value) {
//             Swal.fire({ text: "Please select a Time Exited.", icon: "warning"});
//             return;
//         }

//         var reportDropdown = document.getElementById('reportDropdown');
//         if (!reportDropdown.value) {
//             Swal.fire({ text: "Please select a Category.", icon: "warning"});
//             return;
//         }

//         var activityTypeSelect = document.getElementById('Act_Report_Activity_Type');
//         if (!activityTypeSelect.value || activityTypeSelect.value === "--Select Activity Type--") {
//             Swal.fire({ text: "Please select an Activity Type.", icon: "warning"});
//             return;
//         }

//         var productLineSelect = document.getElementById('quick_product_line_select');
//         if (!productLineSelect.value) {
//             Swal.fire({ text: "Please select a Product Line.", icon: "warning"});
//             return;
//         }

//         var resellerInput = document.getElementById('quick_reseller_input');
//         if (!resellerInput.value) {
//             Swal.fire({ text: "Please fill out the Reseller field.", icon: "warning"});
//             return;
//         }

//         // If all fields are valid, allow form submission
//         document.getElementById('quick_add_activity').submit();
//     });
// });