///////////////////////////// Disable Formfields in Display ///////////////////////////
$(document).ready(function () {
    // Function to toggle the disabled attribute of input fields
    function toggleInputs(disabled) {
        $('.modal-body input, .modal-body textarea, .modal-body select').prop('disabled', disabled);
    }

    function toggleApproversInputs(disabled) {
        $('#approvers-container').find('input, button').prop('disabled', disabled);
        $('#add-approver').prop('disabled', disabled);
    }


    // Function to toggle visibility of buttons
    function toggleButtons(editMode) {
        if (editMode) {
            // Show save and cancel buttons
            $('#SaveChanges, #Cancel, #SendtoClient').show();
            $('#EditButton, #CloseButton').hide();
        } else {
            $('#SaveChanges, #Cancel, #SendtoClient').hide();
            $('#EditButton, #CloseButton').show();
        }
    }

    // Show modal event
    $('#edit_datatable_row').on('shown.bs.modal', function () {
        // Disable input fields initially
        toggleInputs(true);
        toggleButtons(false);
    });

    // Edit button click event
    $('#EditButton').click(function () {

        var completionStatus = $('#completionstatus .status').text().trim();

        if (completionStatus === "APPROVED") {
            Swal.fire({ text: "This Activity Completion is already approved and cannot be modified anymore.", icon: "error" });
            return false;
        }

        toggleInputs(true); // Enable inputs
        toggleButtons(true);

        toggleApproversInputs(false);
    });

    // Cancel button click event
    $('#Cancel').click(function () {
        toggleInputs(true); // Disable inputs
        toggleButtons(false); // Show forward and clone buttons
        toggleApproversInputs(true);
    });


});


///////////////////////////// Engineer Name ////////////////////

$(document).ready(function () {
    $('#edit_datatable_row').on('shown.bs.modal', function () {
        $('#engineer').select2({
            width: '60%',
            dropdownParent: $('#edit_datatable_row .modal-content'),
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

// /////////////////////// -- Clickable Datatable -- //////////////////////
$(document).ready(function () {

    ///////////////////////// Auto-Populate Engineeer Dropdown //////////////////////////////
    function setEngineerName(clickedRow = null) {
        var EngrNameValue;
        if (clickedRow) {
            // If a row is clicked in the DataTable
            EngrNameValue = $(clickedRow).find('td').eq(1).text();
        } else {
            // Default to modal's context if no row is clicked
            EngrNameValue = $('#edit_datatable_row').find('td').eq(1).text();
        }

        if (EngrNameValue) {
            var engineerName = EngrNameValue.split(',');
            // Populate the second dropdown with ID #engineers_modal_two
            var engineersDropdownTwo = $('#engineer');
            engineersDropdownTwo.empty(); // Clear existing options
            engineerName.forEach(function (value) {
                engineersDropdownTwo.append(new Option(value.trim(), value.trim(), true, true));
            });
            engineersDropdownTwo.trigger('change'); // Update the Select2 dropdown

        }
    }

    /////////////////////// Display data from datatable into Modal /////////////////////
    $('#activity-accept-table tbody').on('click', 'tr', function () {
        // Get the column data
        var ActivityDate = $(this).find('td:eq(0)').text();
        // var engr = $(this).find('td:eq(1)').text();
        var Ref_No = $(this).find('td:eq(2)').text();
        var activ_details = $(this).find('td:eq(3)').text();
        var Reseller = $(this).find('td:eq(4)').text();
        var End_User = $(this).find('td:eq(5)').text();
        var Created_By = $(this).find('td:eq(10)').text();
        var proj_list = $(this).find('td:eq(11)').text();
        var Reseller_Contact = $(this).find('td:eq(12)').text();
        var EndUser_Contact = $(this).find('td:eq(13)').text();
        var Date_Created = $(this).find('td:eq(14)').text().trim();
        var act_Done = $(this).find('td:eq(15)').text();

        // Populate the modal with the captured project code and name
        $('#activity_date').val(ActivityDate);
        // $('#engineer').val(engr);
        setEngineerName(this);

        $('#refno').val(Ref_No);
        $('#activity_details').val(activ_details);
        $('#reseller').val(Reseller);
        $('#end_user').val(End_User);
        $('#created_by').val(Created_By);
        $('#Proj_Name').val(proj_list);
        $('#reseller_contact').val(Reseller_Contact);
        $('#EU_Contact').val(EndUser_Contact);
        $('#date').val(Date_Created);
        $('#Act_Done').val(act_Done);

        // Activate the modal
        $('#edit_datatable_row').modal('show');
    });
});


////////////////////////////////// Get Approvers /////////////////////////////////////

$(document).ready(function () {
    function generateApproverRow(index, data = {}, disabled = true) {
        const disableAttr = disabled ? 'disabled' : '';
        var approverStatusHtml = getStatusHtmlApprover(data.aaa_status || '');

        return `
            <div class="row approver-row mt-2">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="company_name_${index}" class="form-label mb-1 small-label">Company Name:</label>
                        <input type="text" class="form-control form-control-sm" id="company_name_${index}" value="${data.aaa_company || ''}" ${disableAttr} required >
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="approver_name_${index}" class="form-label mb-1 small-label">Approver Name:</label>
                        <input type="text" class="form-control form-control-sm" id="approver_name_${index}" value="${data.aaa_name || ''}" ${disableAttr} required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="position_${index}" class="form-label mb-1 small-label">Position:</label>
                        <input type="text" class="form-control form-control-sm" id="position_${index}" value="${data.aaa_position || ''}" ${disableAttr} required>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="email_add_${index}" class="form-label mb-1 small-label">Email:</label>
                        <input type="text" class="form-control form-control-sm" id="email_add_${index}" value="${data.aaa_email || ''}" ${disableAttr} required>
                    </div>
                </div>

            <div class="col-md-2">
            <div class="form-group text-center">
                 <label for="approver_status_${index}" class="form-label mb-1 small-label">Status:</label>
                ${approverStatusHtml}
                 </div>
            </div>

                <div class="col-md-2 mt-2 d-flex align-items-start justify-content-start pt-3">
                    <button type="button" class="btn btn-danger  btn-sm delete-approver" ${disableAttr}>Delete</button>
                </div>
            </div>
        `;
    }

    function getStatusHtmlApprover(Approverstatus) {
        switch (Approverstatus) {
            case 'PENDING':
                return "<div class='alert-primary'>Pending</div>";
            case 'FOR APPROVAL':
                return "<div class='alert-secondary'>Sent</div>";
            case 'APPROVED':
                return "<div class='alert-success'>Approved</div>";
            case 'DISAPPROVED':
                return "<div class='alert-warning'>Commented</div>";
            default:
                return "<div class='alert-info'>Unknown</div>";
        }
    }


    // Attach click event only once for the table rows
    $('#activity-accept-table tbody').on('click', 'tr', function () {
        var Ref_No = $(this).find('td:eq(2)').text();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/tab-activity/getRefNumber',
            method: 'POST',
            data: {
                refNumber: Ref_No
            },
            success: function (response) {
                var container = $('#approvers-container');
                container.empty();

                if (response && response.length > 0) {
                    var ar_id = response[0].ar_id;
                    $('#Ar_IdCompletion').val(ar_id).prop('disabled', true);

                    //-----------------------------------------------------------------
                    var status = response[0].aa_status;

                    var displayText = getStatusHtml(status);
                    $('#completionstatus .status').html(displayText);
                    //-----------------------------------------------------------------


                    response.forEach(function (data, index) {
                        container.append(generateApproverRow(index, data, true));
                    });
                } else {
                    container.append(generateApproverRow(0, {}, true));
                }

                // Disable the add button initially
                $('#add-approver').prop('disabled', true);
            },
            error: function (xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
        function getStatusHtml(status) {
            switch (status) {
                case '1':
                    return "<div class='alert-warning'>DRAFT</div>";
                case '2':
                    return "<div class='alert-info'>SENT</div>";
                case '3':
                    return "<div class='alert-success'>APPROVED</div>";
                default:
                    return "<div class='alert-danger'>DISAPPROVED</div>";
            }
        }

    });

    // Attach click event only once for the "Add Approver" button
    $('#add-approver').on('click', function () {
        var container = $('#approvers-container');
        var index = container.children('.approver-row').length;
        container.append(generateApproverRow(index, {}, false));
    });

    // Delegate event listener for delete buttons
    // $('#approvers-container').on('click', '.delete-approver', function () {
    //     $(this).closest('.approver-row').remove();
    // });

    // Delegate event listener for delete buttons
    $('#approvers-container').on('click', '.delete-approver', function () {
        const $approverRow = $(this).closest('.approver-row');

        // Show confirmation prompt
        Swal.fire({
            title: 'Delete',
            text: 'Are you sure you want to remove this approver?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                // If user confirms, remove the approver row
                $approverRow.remove();

                // Optional: show success message
                Swal.fire(
                    'Deleted!',
                    'The approver has been removed.',
                    'success'
                );
            }
        });
    });

});




////////////////////// Validation ////////////////////////////////

function validateFormData() {

    var requiredFields = [];


    // Reset all fields to remove previous error class
    $('input, select, textarea').removeClass('error');
    $('.select2-selection').removeClass('error');

    requiredFields.push(
        { element: $('#refno'), name: 'Reference Number' },

        { element: $('#company_name'), name: 'Company Name' },
        { element: $('#approver_name'), name: 'Approver Name' },
        { element: $('#position'), name: 'Position' },
        { element: $('#email_add'), name: 'Email' },
    );

    for (var i = 0; i < requiredFields.length; i++) {
        var field = requiredFields[i];
        var value = field.element.val();


        if (value === undefined || value === "" || (field.element.is("select") && !field.element.find("option:selected").val())) {
            Swal.fire({ text: field.name + " is required.", icon: "warning" });
            if (field.element.hasClass('select2-hidden-accessible')) {
                field.element.next('.select2-container').find('.select2-selection').addClass('error'); // Add error class to Select2
            } else {
                field.element.addClass('error'); // Add error class to regular elements
            }

            return false;
        }

        if ((field.name === 'Reseller Contact' || field.name === 'End User Contact')) {
            if (!/^\+?\d+$/.test(value)) {
                Swal.fire({ text: field.name + "  should contain only numbers", icon: "warning" });
                field.element.addClass('error');
                return false;
            }

            if (!/^\+?\d{0,12}$/.test(value)) { // Check if it has more than 12 digits after optional "+"
                Swal.fire({ text: field.name + "contains too many numbers.", icon: "warning" });
                field.element.addClass('error');
                return false;
            }
        }

        // Remove validation for valid email address to allow "N/A" input
    }

    return true;
}

$(document).ready(function () {

    $("#SaveChanges").off("click").on("click", function () {

        $("#loading-overlay").show();

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        // Remove the isValidDomain function as it's no longer needed
        
        function getValidEmails(input) {
            return input.split(',')
                .map(email => email.trim())
                .filter(email => email !== '' && validateEmail(email)); // Remove isValidDomain check here
        }

        // Function to check for duplicates in an array of Emails
        function hasDuplicates(array) {
            return new Set(array).size !== array.length;
        }

        // Capture the current time
        var currentTime = new Date().toLocaleTimeString('en-GB', { hour12: false });
        // Set the value of the hidden time input
        $('#time_completion').val(currentTime);

        var Ar_id = ($('#Ar_IdCompletion').val());

        var CreatedBy = ($('#created_by').val());
        var CreatedDate = ($('#date').val());
        var CreatedTime = ($('#time_completion').val());
        var CreatedDateTime = CreatedDate + ' ' + CreatedTime;

        // Collecting data from dynamic approver fields
        var Email = [];
        var Name = [];
        var ApproverCompanyName = [];
        var ApproverPosition = [];

        var hasEmptyFields = false;
        var invalidDomain = false;
        var invalidEmails = [];

        // Clear previous error messages
        $('.error-message').remove();

        $('.approver-row').each(function () {
            var company = $(this).find('input[id^="company_name"]').val();
            var name = $(this).find('input[id^="approver_name"]').val();
            var position = $(this).find('input[id^="position"]').val();
            var email = $(this).find('input[id^="email_add"]').val();

            // Check for empty fields and add error message if necessary
            if (!company || !name || !position || !email) {
                hasEmptyFields = true;
                $(this).find('input').each(function () {
                    if (!$(this).val()) {
                        $(this).after('<div class="error-message" style="color: red;">*Required Field</div>');
                    }
                });
                return false; // Exit the each loop
            }

            if (!validateEmail(email)) {
                invalidDomain = true;
                invalidEmails.push(email);
                return false; // Exit the each loop
            }

            ApproverCompanyName.push(company);
            Name.push(name);
            ApproverPosition.push(position);
            Email.push(email);
        });

        if (hasEmptyFields) {
            Swal.fire({ text: "All approver fields must be filled out", icon: "warning" });
            $("#loading-overlay").hide();
            return false; // Abort the process
        }

        if (invalidDomain) {
            Swal.fire({
                text: "Email addresses must end with @msi-ecs.com.ph",
                icon: "warning"
            }).then(() => {
                Swal.fire({
                    html: "Invalid Email:<br>" + invalidEmails.join('<br>'),
                    icon: "warning"
                });
            });
            $("#loading-overlay").hide();
            return false; // Abort the process
        }

        // Check for duplicate emails
        if (hasDuplicates(Email)) {
            Swal.fire({ text: "Duplicate Email for Approvers", icon: "warning" });
            $("#loading-overlay").hide();
            return false; // Abort the process
        }

        var StoreData = {
            Ar_id: Ar_id,
            Email: Email,
            Name: Name,
            ApproverCompanyName: ApproverCompanyName,
            ApproverPosition: ApproverPosition,
            CreatedBy: CreatedBy,
            CreatedDateTime: CreatedDateTime
        };

        $.ajax({
            type: 'POST',
            url: '/EmailTemplate/Act-Report-Email-Forward/EditforPendingActivityAcceptance',
            data: {
                StoreData: StoreData,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({ text: "Successfully Created for Completion Acceptance", icon: "success" });
                    $('#SendtoClient').prop('disabled', false);
                    $("#loading-overlay").hide();
                } else {
                    console.log('Server response error:', response);
                    Swal.fire({ text: "Error when Created for Completion Acceptance", icon: "error" });
                    $('#SendtoClient').prop('disabled', true);
                    $("#loading-overlay").hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({ text: "An error Occurred", icon: "error" });
                console.error('AJAX error:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);
                $("#loading-overlay").hide();
            }
        });

    });
});



$(document).ready(function () {
    $("#SendtoClient").off("click").on("click", function () {

        $("#loading-overlay").show();

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function getValidEmails(input) {
            return input.split(',')
                .map(email => email.trim())
                .filter(email => email !== '' && validateEmail(email));
        }

        // Function to check for duplicates in an array of Emails
        function hasDuplicates(array) {
            return new Set(array).size !== array.length;
        }


        var approval_refno = $('#refno').val();
        var Ar_id = ($('#Ar_IdCompletion').val());

        var Project_Name = $('#Proj_Name').val();
        var Reseller = $('#reseller').val();
        var Reseller_Contact = $('#reseller_contact').val();
        var ActivityDate = $('#activity_date').val();
        var EndUser = $('#end_user').val();
        var EndUser_Contact = $('#EU_Contact').val();
        var Activity_Details = $('#activity_details').val();

        var EngineerName = $('#engineer option:selected')
            .map(function () {
                return $(this).text().trim();
            })
            .get()
            .join(', ');


        var ActivityDone = $('#Act_Done').val();


        // Collecting data from dynamic approver fields
        var ApproverEmail = [];
        var ApproverName = [];
        var CompanyName = [];
        var Position = [];

        var hasEmptyFields = false;

        $('.approver-row').each(function () {
            var company = $(this).find('input[id^="company_name"]').val();
            var name = $(this).find('input[id^="approver_name"]').val();
            var position = $(this).find('input[id^="position"]').val();
            var email = $(this).find('input[id^="email_add"]').val();
            var validEmails = getValidEmails(email);


            if (!company || !name || !position || validEmails.length === 0) {
                hasEmptyFields = true;
                return false; // Exit the each loop
            }

            CompanyName.push(company);
            ApproverName.push(name);
            Position.push(position);
            ApproverEmail.push(email);
        });

        if (hasEmptyFields) {
            Swal.fire({ text: "All approver fields must be filled out", icon: "warning" });
            $("#loading-overlay").hide();
            return false; // Abort the process
        }

        /// Check for duplicate emails
        if (hasDuplicates(ApproverEmail)) {
            Swal.fire({ text: "Duplicate Email for Approvers", icon: "warning" });
            $("#loading-overlay").hide();
            return false; // Abort the process
        }


        // Storing data in sessionStorage
        var CompletionAcceptanceDataStore = {
            Project_Name, Reseller, Reseller_Contact, ActivityDate, EndUser, EndUser_Contact, Activity_Details,
            EngineerName, ActivityDone, ApproverEmail, ApproverName, CompanyName, Position, approval_refno, Ar_id
        };

        $.ajax({
            type: 'POST',
            url: '/EmailTemplate/Act-Report-Email-Forward/sendtoclient',
            data: {
                CompletionData: JSON.stringify(CompletionAcceptanceDataStore),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({ text: "Email sent successfully.", icon: "success" });
                    $("#loading-overlay").hide();
                    location.reload();
                } else {
                    console.log('Server response error:', response);
                    Swal.fire({ text: "Failed to send email.", icon: "error" });
                    $("#loading-overlay").hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({ text: "An error Occurred", icon: "error" });
                console.error('AJAX error:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);
                $("#loading-overlay").hide();
            }
        });
    });
});
