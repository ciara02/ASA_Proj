$(document).ready(function(){
    $('#quick_add_activitybtn').click(function(){
        $('#exampleModal2').modal('show');
        
        $.ajax({
            url: '/tab-activity/index/getcloneReference',  // update this URL as per your route
            type: 'GET',
            success: function (response) {
                console.log('Response from server:', response);
                $('#reference_no1 .reference_no1').text(response);
                $('#Ref_No1').val(response);
                $('#hidden_reference_no1').val(response);
    
            },
            error: function (xhr, status, error) {
    
                console.error('AJAX error:', status, error);
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var dropdown = $("#reportDropdown2");
    var status = $("#statusDropdown2");
    const attachmentSection = document.getElementById('Attachment1');

    // Select all forms and hide them initially
    var formsToHide = document.querySelectorAll('.modal-body .card');
    formsToHide.forEach(card => card.style.display = 'none');
    attachmentSection.style.display = 'none';
    
    dropdown.add(status).on("change", function() {
        var selectedDropdown = dropdown.val();
        var selectedStatus = status.val();

         // Hide all forms before showing relevant ones
         formsToHide.forEach(card => card.style.display = 'none');
         attachmentSection.style.display = 'none';

             ///////////////////////////// Support Request //////////////////////////
        if (selectedDropdown === '1' && selectedStatus === '1') {
            document.getElementById('activity_details3').style.display = '';
            document.getElementById('Contract_Details2').style.display = '';

            $("#projtype_button2, #proj_name2").prop("disabled", true);
        }
        else if (selectedDropdown === '1' && (selectedStatus === '2' || selectedStatus === '3' || selectedStatus === '4')) {
            document.getElementById('activity_details3').style.display = '';
            document.getElementById('Contract_Details2').style.display = '';
            document.getElementById('Act_summary_report2').style.display = '';
            document.getElementById('Participant_Position2').style.display = '';
            document.getElementById('customer_requirements2').style.display = '';
            document.getElementById('Activity_Done2').style.display = '';
            document.getElementById('Agreements2').style.display = '';
            document.getElementById('action_plan_recommendation2').style.display = '';
            attachmentSection.style.display = '';

            $("#projtype_button2, #proj_name2").prop("disabled", true);
        }

        else if (selectedDropdown === "2" && selectedStatus === "1") {
            $("#projtype_button2, #proj_name2").prop("disabled", false);
            // Show the specific forms
            document.getElementById('quick_addActivity2').style.display = '';
            document.getElementById('Contract_Details2').style.display = '';
            document.getElementById('Act_summary_report2').style.display = '';
        } 
        else if ((selectedDropdown === '2' || selectedDropdown === '3' || selectedDropdown === '5' || selectedDropdown === '6') && (selectedStatus === '2' || selectedStatus === '3' || selectedStatus === '4')) {
            $("#projtype_button2, #proj_name2").prop("disabled", false);

            document.getElementById('quick_addActivity2').style.display = '';
            document.getElementById('Contract_Details2').style.display = '';
            document.getElementById('Act_summary_report2').style.display = '';
            document.getElementById('Participant_Position2').style.display = '';
            document.getElementById('customer_requirements2').style.display = '';
            document.getElementById('Activity_Done2').style.display = '';
            document.getElementById('Agreements2').style.display = '';
            document.getElementById('action_plan_recommendation2').style.display = '';
            attachmentSection.style.display = '';
        }
        else if ((selectedDropdown === '3' || selectedDropdown === '5' || selectedDropdown === '6') && selectedStatus === '1'){
            document.getElementById('quick_addActivity2').style.display = '';
            document.getElementById('Contract_Details2').style.display = '';
            document.getElementById('Act_summary_report2').style.display = '';

            $("#projtype_button2, #proj_name2").prop("disabled", true);
        }

            ///////////////////////////// Internal Enablement //////////////////////////

        else if (selectedDropdown === '4' && selectedStatus === '1') {
                document.getElementById('quick_addActivity2').style.display = '';
                document.getElementById('Act_summary_report2').style.display = '';

                $("#projtype_button2, #proj_name2").prop("disabled", true);
            }
    
        else if (selectedDropdown === '4' && (selectedStatus === '2' || selectedStatus === '3' || selectedStatus === '4')) {
                document.getElementById('quick_addActivity2').style.display = '';
                document.getElementById('Act_summary_report2').style.display = '';
                document.getElementById('Participant_Position2').style.display = '';
                document.getElementById('customer_requirements2').style.display = '';
                document.getElementById('Activity_Done2').style.display = '';
                document.getElementById('Agreements2').style.display = '';
                document.getElementById('action_plan_recommendation2').style.display = '';
                attachmentSection.style.display = '';

                $("#projtype_button2, #proj_name2").prop("disabled", true);
            }
               ///////////////////////////// Skills Development //////////////////////////
        if ((selectedDropdown === '7' || selectedDropdown === '8') && (selectedStatus === '1' || selectedStatus === '2' || selectedStatus === '3' || status === '4')) {
            document.getElementById('quick_addActivity2').style.display = '';
            document.getElementById('Act_summary_report2').style.display = '';
            attachmentSection.style.display = '';

            $("#projtype_button2, #proj_name2").prop("disabled", true);
        }

    });
});

$(document).ready(function () {
    $('#exampleModal2').on('shown.bs.modal', function () {
        $('#proj_name2').select2({
            width: '100%',
            dropdownParent: $('#exampleModal2 .modal-content'),
        });
    });

    $('#projtype_button2').change(function () {
        var projectType = $(this).val();
        var projecttypenumber = 0;

        if (projectType === "1") {
            projecttypenumber = 1;
        } else if (projectType === "2") {
            projecttypenumber = 2;
        }

        if (projecttypenumber !== '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/tab-activity/create-activity/getProjectName',
                type: 'GET',
                data: {
                    projecttypenumber: projecttypenumber
                },
                success: function (response) {
                    // Clear existing options
                    $('#proj_name2').empty();
                    // Append new options
                    $.each(response, function (index, value) {
                        $('#proj_name2').append('<option value="' + value.id + '">' + value.proj_name + '</option>');
                    });
                    // Enable the dropdown
                    $('#proj_name2').prop('disabled', false);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });

        } else {
            // If no project type selected, disable and empty the second dropdown
            $('#proj_name2').prop('disabled', true).empty();
        }
    });
});


////////////////////////// Select2 Engineer //////////////////////////////////

$(document).ready(function () {
    $('#exampleModal2').on('shown.bs.modal', function () {
        $('#engineers_modal1, #engineers_modal_two1').select2({
            width: '60%',
            dropdownParent: $('#exampleModal2 .modal-content'),
            multiple: true,
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

////////////////////////// Select2 Time  //////////////////////////////////

$(document).ready(function () {
    $('#exampleModal2').on('shown.bs.modal', function () {
        // Initialize Select2 for the engineers dropdown
        $('#time_exited, #time_expected, #time_reported').select2({
            width: '60%',
            dropdownParent: $('#exampleModal2 .modal-content'),
            ajax: {
                url: '/tab-activity/create-activity/getTime',
                dataType: 'json',
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
            }
        }).on('select2:select', function (e) {
            // On selection, get the ID and set it as the value of a hidden input field
            $('#time_exited_id').val(e.params.data.id);
        });
    });
});

/////////////////////////////////// Activity Type ////////////////////////////////////

$(document).ready(function () {
    $('#reportDropdown2').on('change', function () {
        var category = $(this).val(); // Retrieve the selected value when the dropdown changes
        console.log(category);
        $('#Activity_Type1').select2({
            width: '60%',
            dropdownParent: $('#exampleModal2 .modal-content'),
            ajax: {
                url: `/getActivityTypes/${encodeURIComponent(category)}`,
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: $.map(data, function (activityType) {
                            return {
                                id: activityType,
                                text: activityType
                            };
                        })
                    };
                }
            }
        });
    });
});

  
  /////////////////////////////////// Program ////////////////////////////////////

  $(document).ready(function () {
    $('#reportDropdown2').on('change', function () {
        var category = $(this).val(); // Retrieve the selected value when the dropdown changes
        console.log(category);
        $('#program1').select2({
            width: '60%',
            dropdownParent: $('#exampleModal2 .modal-content'),
            ajax: {
                url:`/getProgram/${encodeURIComponent(category)}`,
                dataType: 'json',
                processResults: function (data) {
                    return {
                        results: $.map(data, function (program) {
                            return {
                                id: program,
                                text: program
                            };
                        })
                    };
                }
            }
        });
    });
});

////////////////////// Product Code /////////////////

$(document).ready(function () {
    $('#exampleModal2').on('shown.bs.modal', function () {

        $('#product_line_select').select2({
            width: '100%',
            dropdownParent: $('#exampleModal2 .modal-content'),
            multiple: true,
            ajax: {
                url: '/tab-experience-center/productLine/getProductline',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term // Term entered by the user
                    };
                },
                processResults: function (response) {
                    // Check if response is an array
                    if (Array.isArray(response.data)) {
                        // Map the array data to Select2 format
                        return {
                            results: response.data.map(function (getProductline) {
                                return {
                                    id: getProductline.description, // Assuming 'flex_value_id' is the id
                                    text: getProductline.description,
                                    code: getProductline.flex_value // Store the product code in a 'code' attribute
                                };
                            })
                        };
                    } 
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching product lines:', error);
                }
            }
        });
    });
    // Event listener for changes in the selected product lines
  $('#product_line_select').on('select2:select', function (e) {
    updateProductCode();
    });

    $('#product_line_select').on('change', function() {
    updateProductLine();
    });


    //for passing data of productline and productCode
    function updateProductLine() {
    var selectedProductLines = $('#product_line_select').select2('data');
    var productLineDescriptions = selectedProductLines.map(function(productLine) {
        return productLine.text; // Retrieve the description instead of the value
    }).join(', ');
    $('#product_line_input').val(productLineDescriptions);
    }

    function updateProductCode() {
        var selectedProductLines = $('#product_line_select').select2('data');
        var productCodes = selectedProductLines.map(function(productLine) {
            return productLine.code; // Extract the product code from the 'code' attribute
        }).join(', ');
        
        // Update the value of the 'prod_code' input field with the product codes of the selected product lines
        $('#prod_code_input').val(productCodes);

    }
});

////////////////////////// Participants and Positions Cloning //////////////////////////////////

$(document).ready(function () {
    // Add new participant and position field
    $(".card-body").on("click", ".add-field", function () {
      var newFields = $(".cloned-fields:first").clone();
  
      // Show both "Add" and "Remove" buttons in the new clone
      newFields.find('.add-field, .remove-field').show();
  
      // Append the clones to their respective containers
      $(this).closest('.cloned-fields').after(newFields);
    });
  
    // Remove participant and position field
    $(".card-body").on("click", ".remove-field", function () {
      $(this).closest('.cloned-fields').remove();
    });
  
    // Initially hide the "Remove" button in the template
    $(".cloned-fields:first .remove-field").hide();
  });


  ////////////////////////// Action Plan / Recommendation Cloning//////////////////////////////////

$(document).ready(function () {
    // Add new participant and position field
    $(".card-body").on("click", ".add-field", function () {
      var clonefields = $(".cloned-action-plan-recommendation:first").clone();
  
      // Show both "Add" and "Remove" buttons in the new clone
      clonefields .find('.add-field, .remove-field').show();
  
      // Append the clones to their respective containers
      $(this).closest('.cloned-action-plan-recommendation').after(clonefields );
    });
  
    // Remove participant and position field
    $(".card-body").on("click", ".remove-field", function () {
      $(this).closest('.cloned-action-plan-recommendation').remove();
    });
  
    // Initially hide the "Remove" button in the template
    $(".cloned-action-plan-recommendation:first .remove-field").hide();
  });

  ////automatic close alert message
  $(document).ready(function() {
    // Auto hide the success message after 5 seconds (5000 milliseconds)
    $('#successAlert').delay(2000).fadeOut('slow');
});


  Filevalidation = () => {
    const fi = document.getElementById('act_reportFile');
    // Check if any file is selected.
    if (fi.files.length > 0) {
        for (const i = 0; i <= fi.files.length - 1; i++) {
  
            const fsize = fi.files.item(i).size;
            const file = Math.round((fsize / 1024));
            // The size of the file.
            if (file >= 10000) {
            Swal.fire({ text: "File too Big, please select a file less than 10mb", icon: "warning"});
            }else {
                document.getElementById('size').innerHTML = 
                  '<b>'+'Size: ' + file + '</b> KB';
            }
        }
    }
  }