function hidebutton() {
    $("#proj_completedBtn").hide();
}

function hideSaveBackbutton() {
    $("#backBtn, #saveBtn").hide();
}

function showSaveBackbutton() {
    $("#backBtn, #saveBtn").show();
}

function showbutton() {
    $("#edit_button, #proj_completedBtn").show();
}

function disableform() {
    // Disable text fields and dropdowns in modal body
    $('#implementation-modal .modal-body input[type="text"], #implementation-modal .modal-body input[type="number"], #implementation-modal .modal-body input[type="button"], #implementation-modal .modal-body textarea, #implementation-modal .modal-body input[type="file"], #implementation-modal .modal-body input[type="date"], #implementation-modal .modal-body select, #importDropdown').prop('disabled', true);
}

function enableform() {
    // Disable text fields and dropdowns in modal body
    $('#implementation-modal .modal-body input[type="text"], #implementation-modal .modal-body input[type="number"], #implementation-modal .modal-body input[type="button"], #implementation-modal .modal-body textarea, #implementation-modal .modal-body input[type="file"], #implementation-modal .modal-body input[type="date"], #implementation-modal .modal-body select, #importDropdown, #cashAdvanceReqBtn').not('#mondayUsed, #perMondayCost, #projectAmountNet, #projectMandays').prop('disabled', false);
}
$('#projectAmountGross').on('input', function() {
    // Allow numbers and one decimal point
    var inputVal = $(this).val().replace(/[^0-9.]/g, '');
    
    // Ensure only one decimal point is allowed
    var parts = inputVal.split('.');
    if (parts.length > 2) {
        inputVal = parts[0] + '.' + parts.slice(1).join('');
    }
    
    $(this).val(inputVal);
});

// When a row is clicked, store data in the button
$('#implementation-datatable tbody').on('click', 'tr', function () {
    var projectID = $(this).find('.proj_id').text().trim();
    var cashRequestStatus = $(this).data('cashreqstatus');
    console.log("Clicked Project ID:", projectID);

    $('#implementation-modal')
        .data('project-id', projectID);

    $('#cashAdvanceReqBtn')
        .data('project-id', projectID)
        .data('cashreqstatus', cashRequestStatus) // store status
        .prop('disabled', false);
});
$('#implementation-modal').on('show.bs.modal', function (event) {
    var projectId = $(this).data('project-id');

    if (!projectId) return;
    console.log("CA Project ID used:", projectId); // Fixed typo: projectID → projectId

    $.ajax({
        url: '/get-cash-advance-request/' + projectId,
        method: 'GET',
        success: function (response) {
            if (response && response.approved_total) {
                var approvedAmount = parseFloat(response.approved_total);
                $('#cashAdvance').val(approvedAmount.toFixed(2)).trigger('input');
                console.log("Expenses:", projectId);
            } else {
                // No cash request found – do nothing (no alert)
                console.log("No approved cash request for project:", projectId);
            }
        },
        error: function () {
            alert('Could not fetch approved cash requests.'); // AJAX error only
        }
    });
});


// Bind the button click handler **once**
$('#cashAdvanceReqBtn').on('click', function () {
    var projectID = $(this).data('project-id');
    var cashRequestStatus = $(this).data('cashreqstatus');
    
    if (!projectID) return; // Ensure projectID is defined
    
    console.log("Final Project ID used:", projectID);
    
    // Handle different cash request statuses
    if (cashRequestStatus === 'For Approval') {
    Swal.fire({
        icon: 'info',
        title: 'Already Requested',
        text: 'A request is already pending approval. Please wait for the current project to be approved before submitting a new one.',
    });
    return;
    }
    
   else {
        // Encode projectID with base64 before sending in URL
        var encodedProjectID = btoa(projectID.toString());
        
        // Open the cash advance request window with encoded ID
        window.open('/cash-advance-request?projectID=' + encodedProjectID, '_blank');
    }
    });

$(document).ready(function () {
    $('#implementation-datatable tbody').on('click', 'tr', function () {
        // Show the modal and disable inputs (assuming disableInputs function is defined)
        // $('#implementation-modal').modal('show');
        disableform();
        var status = $(this).find('.signoff-status').text().trim();
        var completed_status = $(this).find('.status').text().trim();
        console.log(status);

        if (status == "For Approval") {
            $("#proj_signOffBtn").show();
            $("#edit_button").show();
            $("#mandayrefCard").hide();
            hideSaveBackbutton();
            // edit_button
        } else if (status == "Approved") {
            $("#mandayrefCard").hide();
            $("#edit_button").show();
            $("#proj_signOffBtn").show();
            hidebutton();
            hideSaveBackbutton();
        }
        else if (status == "Disapproved") {
            $("#proj_signOffBtn").show();
            $("#edit_button").show();
            $("#mandayrefCard").hide();
            hidebutton();
            hideSaveBackbutton();
        }
        else if (status == "Draft") {
            $("#proj_signOffBtn").show();
            $("#edit_button").show();
            $("#mandayrefCard").hide();
            hidebutton();
            hideSaveBackbutton();
        }
        else {
            showbutton();
            $("#proj_signOffBtn").hide();
            $("#mandayrefCard").hide();
            hideSaveBackbutton();
        }
        
        if (completed_status == "Completed") {
            $("#proj_signOffBtn").hide();
            $("#proj_completedBtn").hide();
            $("#edit_button").hide();
            $("#mandayrefCard").show();
            hideSaveBackbutton();
            $("#backBtn").show();
            $("#signOffdocupload").show();
        }else {
            showbutton();
            $("#proj_signOffBtn").hide();
            $("#mandayrefCard").show();
            $("#signOffdocupload").hide();
            hideSaveBackbutton();
        }
        var projectPeriodFrom = $(this).find('.proj_startDate').text().trim();
        var projectPeriodTo = $(this).find('.proj_EndDate').text().trim();
        
        $("#projectPeriodFrom").val(projectPeriodFrom);
        $("#projectPeriodTo").val(projectPeriodTo);
        

        var data = $(this).data('createdby');
        var created_by = data;
        $("#createdBy").val(created_by);

        var projectCode = $(this).data('proj');
        projectCode = projectCode ? projectCode : "N/A";
        var projectCodeDropdown = $('#projectCode');
        // Remove existing options (if any)
        projectCodeDropdown.empty();
        // Add the new engineer option
        projectCodeDropdown.append(new Option(projectCode, projectCode, true, true));
        // Trigger change event to update Select2 dropdown
        projectCodeDropdown.trigger('change');
        $("#projectCode").val(projectCode);

        var projectID = $(this).data('id');
        console.log("Project ID: " + projectID);
        $('#projectID').val(projectID);

        var service_Cat = $(this).find('.service_category').text().trim();
        // Check if service_Cat is null or empty and replace with "N/A"
        service_Cat = service_Cat ? service_Cat : "N/A";
        
        var service_CatDropdown = $('#serviceCategory');
        
        // Check if the option already exists to avoid duplicates
        if ($("#serviceCategory option[value='" + service_Cat + "']").length === 0) {
            // Append the new option
            service_CatDropdown.append(new Option(service_Cat, service_Cat, true, true));
        }
        
        // Trigger change event to update Select2 dropdown
        service_CatDropdown.trigger('change');
        $("#serviceCategory").val(service_Cat);
        

        var proj_types = $(this).data('type');
        console.log("Project Type: " + proj_types);       
        // Check if proj_types is null or empty and replace with "N/A"
        proj_types = proj_types ? proj_types : "N/A";     
        var proj_typesDropdown = $('#projectType');        
        // Check if the option already exists by matching both text and value (to avoid conflicts with predefined options like '1' or '2')
        var existingOption = proj_typesDropdown.find("option").filter(function() {
            return $(this).text().trim() === proj_types;
        });     
        if (existingOption.length === 0) {
            // Append the new option if it doesn't exist
            proj_typesDropdown.append(new Option(proj_types, proj_types, true, true));
        } else {
            // If the option exists, select it
            existingOption.prop('selected', true);
        }       
        // Trigger change event to update Select2 dropdown (if applicable)
        proj_typesDropdown.trigger('change');

        $("#project_type").text(proj_types);

         

        var proj_Manager = $(this).data('manager');
        console.log("Project Manager: " + proj_Manager);
        // Check if service_Cat is null or empty and replace with "N/A"
        proj_Manager = proj_Manager ? proj_Manager : "N/A";
        var proj_ManagerDropdown = $('#projectManager');
        // Remove existing options (if any)
        proj_ManagerDropdown.empty();
        // Add the new engineer option
        proj_ManagerDropdown.append(new Option(proj_Manager, proj_Manager, true, true));
        // Trigger change event to update Select2 dropdown
        proj_ManagerDropdown.trigger('change');
        $("#projectManager").val(proj_Manager);

        ////////////////array team members display dropdown
        var proj_members = $(this).data('members');
        console.log("Raw Project Members:", proj_members);

        // Ensure proj_members is a valid array and remove any trailing commas/spaces
        proj_members = proj_members ? proj_members.split(',') : [];

        // Trim whitespace and remove empty entries
        proj_members = proj_members.map(member => member.trim()).filter(member => member !== "");

        // Remove duplicate names using a Set
        var uniqueNames = [...new Set(proj_members)];

        console.log("Unique Engineers:", uniqueNames); // Debugging output

        // Populate the Select2 dropdown
        var proj_membersDropdown = $('#engineers');
        proj_membersDropdown.empty(); // Remove existing options

        uniqueNames.forEach(function (name) {
            proj_membersDropdown.append(new Option(name, name, true, true));
        });

        // Trigger change event to update Select2 dropdown
        proj_membersDropdown.trigger('change');

        var projectName = $(this).find('.proj_name').text().trim();
        $("#projectName").val(projectName);

        ////////////Business unit////////////////
        var business_unit = $(this).find('.business_unit').text().trim();
        console.log("Business Unit: " + business_unit);
        // Check if service_Cat is null or empty and replace with "N/A"
        business_unit = business_unit ? business_unit : "N/A";
        var business_unitDropdown = $('#businessUnit');
        // Remove existing options (if any)
        business_unitDropdown.empty();
        // Add the new engineer option
        business_unitDropdown.append(new Option(business_unit, business_unit, true, true));
        // Trigger change event to update Select2 dropdown
        business_unitDropdown.trigger('change');
        $("#businessUnit").val(business_unit);

        ////////////Product Line////////////////
        var productLine = $(this).find('.prod_Line').text().trim();
        console.log("Product Line: " + productLine);
        // Check if service_Cat is null or empty and replace with "N/A"
        productLine = productLine ? productLine : "N/A";
        var productLineDropdown = $('#productLine');
        // Remove existing options (if any)
        productLineDropdown.empty();
        // Add the new engineer option
        productLineDropdown.append(new Option(productLine, productLine, true, true));
        // Trigger change event to update Select2 dropdown
        productLineDropdown.trigger('change');
        $("#productLine").val(productLine);

        ////////////OR////////////////////////
        var or = $(this).find('.or').text().trim();
        $("#or").val(or);

        ////////////MBS////////////////////////
        var mbs = $(this).find('.mbs').text().trim();
        $("#mbs").val(mbs);

        ////////////INV///////////////////////
        var inv = $(this).find('.inv').text().trim();
        $("#inv").val(inv);

        ///////////Manday////////////////////////
        var manday = $(this).find('.manday').text().trim();
        $("#projectMandays").val(manday);

        ////////////MBS////////////////////////
        var proj_amount = $(this).find('.proj_amount').text().trim();
        // // Remove commas from proj_amount
        // proj_amount = proj_amount.replace(/,/g, '');
        // console.log(proj_amount);
        $("#projectAmountGross").val(proj_amount);

        $('#edit_button').on('click', function() {
            // Get the text of the proj_amount element and remove commas
            proj_amount = proj_amount.replace(/,/g, '');
            console.log(proj_amount);
            
            // Update the value of #projectAmountGross without commas
            $("#projectAmountGross").val(proj_amount);
        });
    
        // When the modal or any other part of the UI is loaded or updated
        // Make sure to format the proj_amount value with commas
        function formatAmountWithCommas() {
            var proj_amount = $("#projectAmountGross").val();
            // Format the number with commas
            var formatted_amount = proj_amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            $("#projectAmountGross").val(formatted_amount);
        }
    
        // Call this function to format the amount when needed (e.g., when the page loads or after an update)
        formatAmountWithCommas();

        ////////////PO#///////////////////////
        var po_number = $(this).find('.po_number').text().trim();
        $("#poNumber").val(po_number);

        ////////////SO////////////////////////
        var or = $(this).find('.so_number').text().trim();
        $("#soNumber").val(or);

        ////////////FT////////////////////////
        var mbs = $(this).find('.ft_number').text().trim();
        $("#ftNumber").val(mbs);

        ////////////Special Instruction///////////////////////
        var inv = $(this).find('.special_ins').text().trim();
        $("#specialInstruction").val(inv);

        ////////////Reseller////////////////////////
        var reseller = $(this).find('.reseller').text().trim();
        $("#resellers").val(reseller);

        var value = $(this).data('value').split('|');
        var cashAdvance = value[0];
        var resellerContact = value[1];
        var resellerEmail = value[2];
        var endUser = value[3];
        var endUserContact = value[4];
        var endUserEmail = value[5];
        var projectNet = value[6];
        var projectCost = value[7];

        // console.log("Cash Advance: ", cashAdvance);

        $("#cashAdvance").val(cashAdvance);
        $("#resellers_Contact").val(resellerContact);
        $("#resellerPhoneEmail").val(resellerEmail);
        $("#endUser").val(endUser);
        $("#endUserContactNumber").val(endUserContact);
        $("#endUserPhoneEmail").val(endUserEmail);

        function formatNumberWithCommas(number) {
            if (number === 0 || number === '') {
                return '0';
            }
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }
        
        function removeCommas(number) {
            return number.replace(/,/g, '');
        }
        
        // Set initial values with commas for display
        function setDisplayValues(projectNet, projectCost) {
            if (projectNet === 0 || projectNet === '') {
                $("#projectAmountNet").val('0');
            } else {
                $("#projectAmountNet").val(formatNumberWithCommas(projectNet));
            }
        
            if (projectCost === 0 || projectCost === '') {
                $("#perMondayCost").val('0');
            } else {
                $("#perMondayCost").val(formatNumberWithCommas(projectCost));
            }
        }
        
        function formatNumberWithCommas(number) {
            // Convert the number to a string and format it with commas as thousand separators
            return parseFloat(number).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
        
        
        // Convert values to their original format when the edit button is clicked
        function handleEditButtonClick() {
            var projectNet = $("#projectAmountNet").val();
            var projectCost = $("#perMondayCost").val();
            
            // Remove commas for editing
            $("#projectAmountNet").val(removeCommas(projectNet));
            $("#perMondayCost").val(removeCommas(projectCost));
        }
        
        // Example usage
        setDisplayValues(projectNet, projectCost);
        
        // Attach the click event to your edit button
        $("#edit_button").on('click', function() {
            handleEditButtonClick();
        });
        
        

        var eu_loc = $(this).data('euloc');
        $("#endUserLocation").val(eu_loc);
        // console.log(endUserLocation);

// ////////////////////attachments/////////////////////

$("#implementAttachment").empty();

var attachmentImplement = $(this).data('attachments');
var attachmentArray = attachmentImplement
    .split(',')
    .map(function (item) {
        return item.trim(); // Remove any leading or trailing whitespace from each item
    })
    .filter(function (item) {
        return item !== ''; // Exclude empty strings
    });

// Create a container div for all attachments
var attachmentsWrapper = $('<div class="attachments-wrapper"></div>');
attachmentsWrapper.css({ display: 'flex' }); // Display all attachments in a single row

// Iterate over each attachment in the array
attachmentArray.forEach(function (attachment) {
    var attachmentParts = attachment.split('.');
    var attachmentName = attachmentParts.slice(0, -1).join('.'); // Join all parts except the last one
    var fileType = attachmentParts.slice(-1)[0];

    // Map file types to their corresponding image paths
    var imagePaths = {
        'pdf': '/assets/img/pdf.png',
        'png': '/assets/img/png.png',
        'jpg': '/assets/img/jpg.png',
        'jpeg': '/assets/img/jpeg.png',
        'xlsx': '/assets/img/excel.png',
        'xls': '/assets/img/excel.png',
        'doc': '/assets/img/doc.png',
        'docx': '/assets/img/doc.png',
        'txt': '/assets/img/txt.png'
        // Add more file types and image paths as needed
    };

    // Create a container div for the attachment with box styles
    var attachmentContainer = $('<div class="attachment-container"></div>');
    attachmentContainer.css({
        textAlign: "center",
        marginBottom: "10px",
        fontSize: "12px",
        marginRight: "20px",
        display: 'flex',
        flexDirection: 'column',  // Stack the elements vertically (image + delete button)
        alignItems: 'center',  // Center items horizontally
        justifyContent: 'center',
        width: '150px',  // Set width for the container
        border: '1px solid #ddd',  // Add a border to create the box effect
        borderRadius: '8px',  // Rounded corners for the box
        padding: '10px',  // Padding inside the box
        backgroundColor: '#f9f9f9'  // Light background color
    });

    // Create a download link
    var downloadLink = $('<a></a>');

    if (fileType in imagePaths) {
        // Create an image element
        var imageElement = $('<img>');

        // Set the source (URL) of the image based on the file type
        imageElement.attr('src', imagePaths[fileType]); // Set the image source based on file type

        // Set the width and height of the image
        imageElement.css({ width: '55px', height: '55px', transition: "transform 0.2s ease-in-out" }); // Adjust the width and height as needed
        imageElement.hover(
            function () {
                $(this).css("transform", "scale(1.2)"); // Increase size on hover
            },
            function () {
                $(this).css("transform", "scale(1)"); // Reset size when not hovered
            }
        );
        // Append the image element to the download link
        downloadLink.append(imageElement);
    }

    // Set download link attributes
    var filePath = '/uploads/Isupport-Attachments/' + attachment; // Update this to match your file path
    downloadLink.attr({ href: filePath, download: attachmentName });
    downloadLink.css({ display: 'block', textAlign: 'center', marginBottom: '10px' }); // Apply CSS styles to the download link

    // Append the download link to the container div
    attachmentContainer.append(downloadLink);

    // Create a span element for the attachment name
    var attachmentSpan = $('<span></span>').text(attachmentName);
    attachmentSpan.css('word-break', 'break-all');
    attachmentSpan.css('max-width', '100px'); // Adjust the width as needed
    attachmentSpan.css('font-weight', 'bold');
    attachmentSpan.css('font-size', '10px');
    // Shorten attachment name if necessary
    if (attachmentName.length > 25) {
        attachmentSpan.text(attachmentName.substring(0, 25) + "...");
    }

    // Set display property to inline-block to allow for width adjustments
    attachmentSpan.css('display', 'inline-block');
    // Append the attachment span to the container div
    attachmentContainer.append(attachmentSpan);

    var deleteButton = $('<button type="button">Delete</button>'); // Prevent form submission
    deleteButton.css({
        backgroundColor: '#f44336',
        color: '#fff',
        border: 'none',
        padding: '5px',
        cursor: 'pointer',
        fontSize: '10px',
        borderRadius: '4px',
        marginTop: '5px',
        display: 'none' // Initially hide the button
    }).on('click', function (event) {
        event.preventDefault(); // Prevent form submission if inside a form
        Swal.fire({
            text: `Are you sure you want to delete the file: "${attachmentName}"?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/EmailTemplate/Act-Report-Email-Forward/deleteAttachment', // Update URL as necessary
                    type: 'post',
                    data: { file_name: attachment },
                    success: function (response) {
                        Swal.fire("Deleted!", "Your file has been deleted.", "success");
                        attachmentContainer.remove(); // Remove the UI element
                    },
                    error: function () {
                        Swal.fire("Error!", "Failed to delete the file.", "error");
                    }
                });
            }
        });
    });
// Append the delete button to the attachment container
attachmentContainer.append(deleteButton);

// Trigger to show the delete button
$('#edit_button').click(function () {
    $('.attachment-container button').css('display', 'block'); // Show all delete buttons
});


    // Append the container div to the attachments wrapper
    attachmentsWrapper.append(attachmentContainer);
});

// Append the attachments wrapper to #implementAttachment
$('#implementAttachment').append(attachmentsWrapper);

////////////////////Proj Sign Off Attachments////////////////////////////////////////////////////////

$("#signOffSupportingDocument").empty();

var attachmentSignOff = $(this).data('signoffattachments');
var attachmentSignoffArray = attachmentSignOff .split(',')
    .map(function (item) {
        return item.trim(); // Remove any leading or trailing whitespace from each item
    })
    .filter(function (item) {
        return item !== ''; // Exclude empty strings
    });

// Create a container div for all attachments
var attachmentsSignOffWrapper = $('<div class="attachments-wrapper"></div>');
attachmentsSignOffWrapper.css({ display: 'flex' }); // Display all attachments in a single row

// Iterate over each attachment in the array
attachmentSignoffArray.forEach(function (signoffattachment) {
    var attachmentPartsSignoff = signoffattachment.split('.');
    var attachmentSignOffName = attachmentPartsSignoff.slice(0, -1).join('.'); // Join all parts except the last one
    var signOfffileType = attachmentPartsSignoff.slice(-1)[0];

    // Map file types to their corresponding image paths
    var imagePaths = {
        'pdf': '/assets/img/pdf.png',
        'png': '/assets/img/png.png',
        'jpg': '/assets/img/jpg.png',
        'jpeg': '/assets/img/jpeg.png',
        'xlsx': '/assets/img/excel.png',
        'xls': '/assets/img/excel.png',
        'doc': '/assets/img/doc.png',
        'docx': '/assets/img/doc.png',
        'txt': '/assets/img/txt.png'
        // Add more file types and image paths as needed
    };

    // Create a container div for the attachment
    var attachmentContainerSignOff = $('<div class="attachment-container"></div>');
    attachmentContainerSignOff.css({
        textAlign: "center",
        marginBottom: "10px",
        fontSize: "12px",
        marginRight: "20px",
        display: 'flex',
        flexDirection: 'column',  // Stack the elements vertically (image + delete button)
        alignItems: 'center',  // Center items horizontally
        justifyContent: 'center',
        width: '150px',  // Set width for the container
        border: '1px solid #ddd',  // Add a border to create the box effect
        borderRadius: '8px',  // Rounded corners for the box
        padding: '10px',  // Padding inside the box
        backgroundColor: '#f9f9f9'  // Light background color
        }); // Apply CSS styles to the container

    // Create a download link
    var downloadLink = $('<a></a>');

    if (signOfffileType in imagePaths) {
        // Create an image element
        var imageElement = $('<img>');

        // Set the source (URL) of the image based on the file type
        imageElement.attr('src', imagePaths[signOfffileType]); // Set the image source based on file type

        // Set the width and height of the image
        imageElement.css({ width: '55px', height: '55px', transition: "transform 0.2s ease-in-out" }); // Adjust the width and height as needed
        imageElement.hover(
            function () {
                $(this).css("transform", "scale(1.2)"); // Increase size on hover
            },
            function () {
                $(this).css("transform", "scale(1)"); // Reset size when not hovered
            }
        );
        // Append the image element to the download link
        downloadLink.append(imageElement);
    }

    // Set download link attributes
    var filePath = '/uploads/Sign-off-Attachments/' + signoffattachment; // Update this to match your file path
    downloadLink.attr({ href: filePath, download: attachmentSignOffName });
    downloadLink.css({ display: 'block', textAlign: 'center', marginBottom: '10px' }); // Apply CSS styles to the download link

    // Append the download link to the container div
    attachmentContainerSignOff.append(downloadLink);

    // Create a span element for the attachment name
    var attachmentSpan = $('<span></span>').text(attachmentSignOffName);
    attachmentSpan.css('word-break', 'break-all');
    attachmentSpan.css('max-width', '100px'); // Adjust the width as needed
    attachmentSpan.css('font-weight', 'bold');
    attachmentSpan.css('font-size', '10px');
    // Shorten attachment name if necessary
    if (attachmentSignOffName.length > 30) {
        attachmentSpan.text(attachmentSignOffName.substring(0, 30) + "...");
    }

    // Set display property to inline-block to allow for width adjustments
    attachmentSpan.css('display', 'inline-block');
    // Append the attachment span to the container div
    attachmentContainerSignOff.append(attachmentSpan);

    // Append the container div to the attachments wrapper
    attachmentsSignOffWrapper.append(attachmentContainerSignOff);
});

// Append the attachments wrapper to #implementAttachment
$('#signOffSupportingDocument').append(attachmentsSignOffWrapper);

// ////////////////////Cash Advance attachments/////////////////////

$("#cashRequestUploadDocument").empty();

var attachmentCashAdvance = $(this).data('cashadvanceattachments');
var cashAdvanceattachmentArray = attachmentCashAdvance
    .split(',')
    .map(function (item) {
        return item.trim(); // Remove any leading or trailing whitespace from each item
    })
    .filter(function (item) {
        return item !== ''; // Exclude empty strings
    });

// Create a container div for all attachments
var cashAdvanceattachmentsWrapper = $('<div class="attachments-wrapper"></div>');
cashAdvanceattachmentsWrapper.css({ display: 'flex' }); // Display all attachments in a single row

// Iterate over each attachment in the array
cashAdvanceattachmentArray.forEach(function (attachment) {
    var attachmentParts = attachment.split('.');
    var attachmentName = attachmentParts.slice(0, -1).join('.'); // Join all parts except the last one
    var fileType = attachmentParts.slice(-1)[0];

    // Map file types to their corresponding image paths
    var imagePaths = {
        'pdf': '/assets/img/pdf.png',
        'png': '/assets/img/png.png',
        'jpg': '/assets/img/jpg.png',
        'jpeg': '/assets/img/jpeg.png',
        'xlsx': '/assets/img/excel.png',
        'xls': '/assets/img/excel.png',
        'doc': '/assets/img/doc.png',
        'docx': '/assets/img/doc.png',
        'txt': '/assets/img/txt.png'
        // Add more file types and image paths as needed
    };

    // Create a container div for the attachment with box styles
    var cashAdvanceAttachmentContainer = $('<div class="attachment-container"></div>');
    cashAdvanceAttachmentContainer.css({
        textAlign: "center",
        marginBottom: "10px",
        fontSize: "12px",
        marginRight: "20px",
        display: 'flex',
        flexDirection: 'column',  // Stack the elements vertically (image + delete button)
        alignItems: 'center',  // Center items horizontally
        justifyContent: 'center',
        width: '150px',  // Set width for the container
        border: '1px solid #ddd',  // Add a border to create the box effect
        borderRadius: '8px',  // Rounded corners for the box
        padding: '10px',  // Padding inside the box
        backgroundColor: '#f9f9f9'  // Light background color
    });

    // Create a download link
    var downloadLink = $('<a></a>');

    if (fileType in imagePaths) {
        // Create an image element
        var imageElement = $('<img>');

        // Set the source (URL) of the image based on the file type
        imageElement.attr('src', imagePaths[fileType]); // Set the image source based on file type

        // Set the width and height of the image
        imageElement.css({ width: '55px', height: '55px', transition: "transform 0.2s ease-in-out" }); // Adjust the width and height as needed
        imageElement.hover(
            function () {
                $(this).css("transform", "scale(1.2)"); // Increase size on hover
            },
            function () {
                $(this).css("transform", "scale(1)"); // Reset size when not hovered
            }
        );
        // Append the image element to the download link
        downloadLink.append(imageElement);
    }

    // Set download link attributes
    var filePath = '/uploads/Cash-Advance-Request-Attachment/' + attachment; // Update this to match your file path
    downloadLink.attr({ href: filePath, download: attachmentName });
    downloadLink.css({ display: 'block', textAlign: 'center', marginBottom: '10px' }); // Apply CSS styles to the download link

    // Append the download link to the container div
    cashAdvanceAttachmentContainer.append(downloadLink);

    // Create a span element for the attachment name
    var attachmentSpan = $('<span></span>').text(attachmentName);
    attachmentSpan.css('word-break', 'break-all');
    attachmentSpan.css('max-width', '100px'); // Adjust the width as needed
    attachmentSpan.css('font-weight', 'bold');
    attachmentSpan.css('font-size', '10px');
    // Shorten attachment name if necessary
    if (attachmentName.length > 25) {
        attachmentSpan.text(attachmentName.substring(0, 25) + "...");
    }

    // Set display property to inline-block to allow for width adjustments
    attachmentSpan.css('display', 'inline-block');
    // Append the attachment span to the container div
    cashAdvanceAttachmentContainer.append(attachmentSpan);

    var deleteButton = $('<button type="button">Delete</button>'); // Prevent form submission
    deleteButton.css({
        backgroundColor: '#f44336',
        color: '#fff',
        border: 'none',
        padding: '5px',
        cursor: 'pointer',
        fontSize: '10px',
        borderRadius: '4px',
        marginTop: '5px',
        display: 'none' // Initially hide the button
    }).on('click', function (event) {
        event.preventDefault(); // Prevent form submission if inside a form
        Swal.fire({
            text: `Are you sure you want to delete the file: "${attachmentName}"?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/tab-isupport-service/CashRequestDeleteAttachment', // Update URL as necessary
                    type: 'post',
                    data: { file_name: attachment },
                    success: function (response) {
                        Swal.fire("Deleted!", "Your file has been deleted.", "success");
                        cashAdvanceAttachmentContainer.remove(); // Remove the UI element
                    },
                    error: function () {
                        Swal.fire("Error!", "Failed to delete the file.", "error");
                    }
                });
            }
        });
    });
// Append the delete button to the attachment container
cashAdvanceAttachmentContainer.append(deleteButton);

// Trigger to show the delete button
$('#edit_button').click(function () {
    $('.attachment-container button').css('display', 'block'); // Show all delete buttons
});


    // Append the container div to the attachments wrapper
    cashAdvanceattachmentsWrapper.append(cashAdvanceAttachmentContainer);
});

// Append the attachments wrapper to #implementAttachment
$('#cashRequestUploadDocument').append(cashAdvanceattachmentsWrapper);
///////////////////////////////////////////////////////////////////////////////////////////////////
    });
    $('#edit_button').click(function () {
        enableform();
        hidebutton();
        showSaveBackbutton();
        $("#edit_button").hide();
        $("#mandayrefCard").show();
        $("#proj_signOffBtn").hide();
        // $("#report_text").hide();
        $("#project_type").hide();
    });
    $('#backBtn').click(function () {
        $("#edit_button").show();
        $("#mandayrefCard").hide();
        $("#proj_signOffBtn").show();
        $("#report_text").show();
        $("#project_type").show();
    });

    $('#implementation-modal, #exampleModal').on('hidden.bs.modal', function () {
        // Your code to execute when the modal is dismissed
        $("#edit_button").show();
        $("#mandayrefCard").hide();
        $("#proj_signOffBtn").show();
        $("#report_text").show();
        $("#project_type").show();
    });
    
    // Prevent form submission if "N/A" is selected
    $('#implement_maintain').submit(function (event) {
        var serviceCategory = $('#serviceCategory').val();
        var projectCode = $('#projectCode').val();
        if (serviceCategory === "N/A" || projectCode === "N/A") {
            event.preventDefault();
            Swal.fire('Category Error!', 'Please select a valid category.', 'error');
            // Optionally, you can focus on the select dropdown or provide other feedback to the user.
        }
    });


});
$(document).ready(function () {
    $('#implementation-modal').on('shown.bs.modal', function () {

        $('#projectManager').select2({
            width: '100%',
            multiple: false,
            dropdownParent: $('#implementation-modal .modal-content'),
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
                                id: item.engineer, // Use the engineer's name as the id
                                text: item.engineer, // And display text
                            };
                        }).sort(function (a, b) {
                            // Compare the engineer names (text) to sort them alphabetically
                            return a.text.localeCompare(b.text);
                        })
                    };
                }
            },
            templateResult: function (data) {
                if (!data.email) {
                    return data.text;
                }
                return $('<span>' + data.text + ' (' + data.email + ')</span>');
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });

        $('#projectCode').select2({
            width: '100%',
            dropdownParent: $('#implementation-modal .modal-content'),
            ajax: {
                url: '/tab-isupport-service/getProjectCode',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (response) {
                    if (response && response.data) {
                        return {
                            results: response.data.map(function (projectCode) {
                                return {
                                    id: projectCode,
                                    text: projectCode
                                };
                            })
                        };
                    } else {
                        console.error('Invalid response format:', response);
                        return { results: [] };
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching project codes:', error);
                }
            }
        });

        $('#projectType').select2({
            width: '100%',
            dropdownParent: $('#implementation-modal .modal-content'),
        });

        $('#serviceCategory').select2({
            width: '100%',
            dropdownParent: $('#implementation-modal .modal-content')
        });

        $('#businessUnit').select2({
            width: '100%',
            dropdownParent: $('#implementation-modal .modal-content'),
            ajax: {
                url: '/tab-isupport-service/getBusinessUnit',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (response) {
                    if (response && response.data) {
                        return {
                            results: response.data.map(function (businessUnit) {
                                return {
                                    id: businessUnit.description,
                                    text: businessUnit.description
                                };
                            })
                        };
                    } else {
                        console.error('Invalid response format:', response);
                        return { results: [] };
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching project codes:', error);
                }
            }
        });

        $('#productLine').select2({
            width: '100%',
            multiple: false,
            dropdownParent: $('#implementation-modal .modal-content'),
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

        $('#engineers').select2({
            width: '100%',
            multiple: true,
            tags: true,
            dropdownParent: $('#implementation-modal .modal-content'),
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
                                id: item.engineer, // Use the engineer's name as the id
                                text: item.engineer, // And display text
                                created_date: item.created_date // Add the engineer's creation date
                            };
                        }).sort(function (a, b) {
                            // Compare the engineer names (text) to sort them alphabetically
                            return a.text.localeCompare(b.text);
                        })
                    };
                }
            },
            templateResult: function (data) {
                if (!data.email) {
                    return data.text;
                }
                return $('<span>' + data.text + ' (' + data.email + ')</span>');
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    });
    // Event listener for changes in the selected team members
    $('#engineers').on('change', function (e) {
        var selectedEngineers = $(this).select2('data');
        var emails = selectedEngineers.map(function (engineer) {
            return engineer.email; // Extract the email of each selected engineer
        }).join(', ');

        // Extract the creation date of the first selected engineer
        var creationDate = selectedEngineers.length > 0 ? selectedEngineers[0].created_date : '';

        $('#tm_email').val(emails); // Set the value of the hidden input for emails
        $('#created_dateTM').val(creationDate); // Set the value of the hidden input for creation date
    });

    // Event listener for changes in the selected project manager
    $('#projectManager').on('select2:select', function (e) {
        var selectedManager = e.params.data;
        $('#pm_email').val(selectedManager.email); // Set the value of the hidden input to the selected manager's email
    });

    $('#productLine').on('change', function () {
        updateProductLine();
    });

    //for passing data of productline and productCode
    function updateProductLine() {
        var selectedProductLines = $('#productLine').select2('data');
        var productLineDescriptions = selectedProductLines.map(function (productLine) {
            return productLine.text; // Retrieve the description instead of the value
        }).join(', ');
        $('#iSupport_product').val(productLineDescriptions);
    }

    $(function () {
        // Bind the calculate function to the input event of projectMandays and projectAmountGross
        $('#projectMandays, #projectAmountGross').on('input', calculate);
        // Bind the calculate function to the input event of cashAdvance
        $('#cashAdvance').on('input', calculate);

        function calculate() {
            var pMandays = parseFloat($('#projectMandays').val()) || 0;
            var pGross = parseFloat($('#projectAmountGross').val()) || 0;
            var pCash = parseFloat($('#cashAdvance').val()) || 0;

            var pNet = pGross - pCash;

            // Check if pMandays is not zero before performing the division
            var pMcost = (pMandays !== 0) ? pNet / pMandays : 0;

            // Update the corresponding input fields with the calculated values
            $('#projectAmountNet').val(pNet.toFixed(2));
            $('#perMondayCost').val(pMcost.toFixed(2)); 
        }
    });
});

$(document).ready(function () {
    $('#implementation-datatable tbody').on('click', 'tr', function () {
        $('#implementation-modal').on('shown.bs.modal', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var projectId = $('#projectID').val().trim(); // Get projectId from your HTML element
            var projectIdArray = projectId.split(',').filter(function (id) {
                return id.trim() !== "";
            });

            var engineers = $('#engineers').val(); // Get engineers array from your HTML element
            console.log("Engineers before split:", engineers); // Log engineers before splitting
            console.log(projectIdArray);

            $.ajax({
                url: '/tab-isupport/totalMandayUsed', 
                type: 'POST',
                data: {
                    projectId: projectIdArray,
                    engineers: engineers
                },
                success: function (response) {
                    // Handle success response
                    console.log(response);
                    // Round the totalMandaysAll value to the nearest whole number
                    var roundedMandays =parseFloat(response.totalMandaysAll).toFixed(2);
                    // Set the rounded value to the mondayUsed input field
                    $('#mondayUsed').val(roundedMandays);
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });
    });
});
$(document).ready(function () {
    $('#implementation-datatable tbody').on('click', 'tr', function () {
        $('#implementation-modal').on('shown.bs.modal', function () {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var projectId = $('#projectID').val().trim(); 
            var projectIdArray = projectId.split(',').filter(id => id.trim() !== "");

            var engineers = $('#engineers').val();
            console.log("Engineers Before Split:", engineers); 

            // ✅ Show loading spinner inside `#doerContainer`
            $("#doerContainer").html(`
                <div class="text-center p-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p>Loading Engineer Data...</p>
                </div>
            `);

            // 🔥 Make AJAX request
            $.ajax({
                url: '/tab-isupport/totalMandayUsed',
                type: 'POST',
                data: {
                    projectId: projectIdArray,
                    engineers: engineers
                },
                success: function (response) {
                    console.log('Success', response);
                    console.log('Engineer Mandays:', response.engineerMandays);

                    // ✅ Remove spinner before updating content
                    $("#doerContainer").empty();

                    engineers.forEach(function (engineer) {
                        var mandays = response.engineerMandays[engineer] || 0;
                        var roundedMandays = mandays % 1 === 0 ? mandays : parseFloat(mandays).toFixed(2);

                        var inputHTML = `
                            <div class="col-md-12 d-flex align-items-center gap-2 mb-2">
                                <input type="text" class="form-control engr_name" style="width: 80%;" value="${engineer}" readonly>
                                <input type="text" class="form-control man_day" style="width: 20%;" value="${roundedMandays}" readonly>
                            </div>
                        `;
                        $("#doerContainer").append(inputHTML);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    $("#doerContainer").html(`
                        <div class="text-center p-3 text-danger">
                            <p>Failed to load data. Please try again.</p>
                        </div>
                    `);
                }
            });
        });
    });
});

function toggleInputsParticipant(disabled) {
    $('#participantAndPositionContainer input, #participantAndPositionContainer textarea, #participantAndPositionContainer select,  #participantAndPositionContainer button').prop('disabled', disabled);
}

function toggleInputsActionPlan(disabled) {
    $('#ActionPlan_Recommendation input, #ActionPlan_Recommendation textarea, #ActionPlan_Recommendation select, #ActionPlan_Recommendation button').prop('disabled', disabled);
}
$(document).ready(function () {
    // Event delegation for table row clicks
    $('#implementation-datatable tbody').on('click', 'tr', function (e) {
        if ($(e.target).is('input[type="checkbox"]')) {
            return;
        }
        $('#loadingOverlay').show();

        // When the modal is shown, perform AJAX request      
           
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var projectId = $('#projectID').val().trim(); // Get projectId from your HTML element
            var projectIdArray = projectId.split(',').filter(function (id) {
                return id.trim() !== "";
            });

            $.ajax({
                url: '/cash-advance/getCashRefNo',
                type: 'POST',
                data: {
                    projectId: projectIdArray
                },
              success: function (response) {
                console.log('Success', response);

                if (response.length === 0) {
                    console.log("No reference number found or no data returned.");
                    $('#implementation-modal').modal('show');
                    return; // Stop further execution if no valid reference number is found
                } else {
                    console.log("Project reference numbers with hash links:", response);

                    // Empty the container first
                    $("#CashReqContainer").empty();

                    $("#CashReqContainer").css({
                        'max-height': '300px',  // Adjust this value as needed
                        'overflow-y': 'auto',
                        'overflow-x': 'hidden'  // Optional: hides horizontal scrolling
                    });

                    response.forEach(function(item) {
                        const projRefId = item.proj_ref_id;
                        const hashLink = item.hash_link;

                        const linkHTML = `
                            <div class="mb-2">
                                <label class="form-label"><strong>Cash Ref#:</strong>
                                    <a href="${hashLink}" target="_blank">
                                        ${projRefId}
                                    </a>
                                </label>
                            </div>
                        `;

                        $("#CashReqContainer").append(linkHTML);
                    });
                }
            },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('Something went wrong while fetching Manday reference numbers.');
                }
            });


            // Get the HTML content of the column containing engineers
            var engineers = $('#engineers').val();
            console.log("Engineers Before Split:", engineers); // Log engineers
            // Make an AJAX request to fetch the engineer manday values
            $.ajax({
                url: '/tab-isupport/MandayRefNo',
                type: 'POST',
                data: {
                    projectId: projectIdArray,
                    engineers: engineers
                },
                success: function (response) {
                    console.log('Success', response);

                    if (response.length === 0) {
                        console.log("No reference number found or no data returned.");
                        $('#implementation-modal').modal('show');
                      return; // Stop further execution if no valid reference number is found

                    } else{
                        console.log("Manday reference numbers:", response);
                          // Empty the container first
                    $("#mandayRefContainer").empty();
                    
                    $("#mandayRefContainer").css({
                        'max-height': '300px',  // Adjust this value as needed
                        'overflow-y': 'auto',
                        'overflow-x': 'hidden' // Optional: hides horizontal scrolling
                    });
                    }           
                    
                    function sanitizeData(value, defaultValue = '') {
                        return value ? String(value).trim() : defaultValue;
                    }
                    // Utility function to escape HTML special characters
                    function encodeHTML(str) {
                        return str
                            .replace(/&/g, "&amp;")
                            .replace(/</g, "&lt;")
                            .replace(/>/g, "&gt;")
                            .replace(/"/g, "&quot;")
                            .replace(/'/g, "&#39;");
                    }

                    response.forEach(function (item) {
                        // Sanitize and encode all data fields
                        const arRefNo = encodeHTML(sanitizeData(item.ar_refNo, 'N/A'));
                        const arReport = encodeHTML(sanitizeData(item.ar_report));
                        const arStatus = encodeHTML(sanitizeData(item.ar_status));
                        const arRequester = encodeHTML(sanitizeData(item.ar_requester));
                        const arDateFiled = encodeHTML(sanitizeData(item.ar_date_filed));
                        const arDateNeeded = encodeHTML(sanitizeData(item.ar_date_needed));
                        const arActivity = encodeHTML(sanitizeData(item.ar_activity));
                        const arInstruction = encodeHTML(sanitizeData(item.ar_instruction));
                        const arResellers = encodeHTML(sanitizeData(item.ar_resellers));
                        const arResellersContact = encodeHTML(sanitizeData(item.ar_resellers_contact));
                        const arResellersEmail = encodeHTML(sanitizeData(item.ar_resellers_phoneEmail));
                        const arEndUser = encodeHTML(sanitizeData(item.ar_endUser));
                        const arEndUserContact = encodeHTML(sanitizeData(item.ar_endUser_contact));
                        const arEndUserLoc = encodeHTML(sanitizeData(item.ar_endUser_loc));
                        const arEndUserEmail = encodeHTML(sanitizeData(item.ar_endUser_phoneEmail));
                        const arActivityDate = encodeHTML(sanitizeData(item.ar_activityDate));
                        const arTimeReported = encodeHTML(sanitizeData(item.ar_timeReported));
                        const arTimeExited = encodeHTML(sanitizeData(item.ar_timeExited));
                        const arProductLine = encodeHTML(sanitizeData(item.product_line));
                        const arProductCode = encodeHTML(sanitizeData(item.ar_productCode));
                        const arTimeExpected = encodeHTML(sanitizeData(item.ar_timeExpected));
                        const arVenue = encodeHTML(sanitizeData(item.ar_venue));
                        const arActivityType = encodeHTML(sanitizeData(item.ar_activityType));
                        const arProgram = encodeHTML(sanitizeData(item.ar_program));
                        const arCustRequirements = encodeHTML(sanitizeData(item.ar_custRequirements));
                        const arActivityDone = encodeHTML(sanitizeData(item.ar_activityDone));
                        const arAgreements = encodeHTML(sanitizeData(item.ar_agreements));
                        const arSendCopyTo = encodeHTML(sanitizeData(item.ar_sendCopyTo));
                        const arTargetDate = encodeHTML(sanitizeData(item.ar_targetDate));
                        const arDetails = encodeHTML(sanitizeData(item.ar_details));
                        const engrName = encodeHTML(sanitizeData(item.engineers));
                        const engrProdName = encodeHTML(sanitizeData(item.prod_engineers));
                        const projName = encodeHTML(sanitizeData(item.projectName));
                        const projType = encodeHTML(sanitizeData(item.projectType));
                        const projectId = encodeHTML(sanitizeData(item.ar_project));

                        // Generate HTML
                        if (arRefNo !== "N/A") {
                            // Generate HTML
                            const inputHTML = `
                                <div class="col-md-12 d-flex align-items-center gap-2" style="text-align: center;">
                                    <p class="ar_refNo" style="width: 100%;">
                                        <strong>ASA#: </strong>
                                        <a href="#" class="ar_ref_link"
                                            data-ar-ref="${arRefNo}" 
                                            data-ar-report="${arReport}" 
                                            data-status-name="${arStatus}"
                                            data-ar-requester="${arRequester}" 
                                            data-ar-date-filed="${arDateFiled}" 
                                            data-ar-date-needed="${arDateNeeded}" 
                                            data-ar-activity="${arActivity}" 
                                            data-ar-instruction="${arInstruction}" 
                                            data-ar-reseller="${arResellers}"
                                            data-ar-reseller-contact="${arResellersContact}"  
                                            data-ar-reseller-email="${arResellersEmail}" 
                                            data-ar-end-user="${arEndUser}" 
                                            data-ar-end-user-contact="${arEndUserContact}" 
                                            data-ar-end-user-loc="${arEndUserLoc}" 
                                            data-ar-end-user-email="${arEndUserEmail}"
                                            data-ar-act-date="${arActivityDate}" 
                                            data-ar-time-reported="${arTimeReported}" 
                                            data-ar-time-exited="${arTimeExited}" 
                                            data-ar-productline="${arProductLine}"
                                            data-ar-productcode="${arProductCode}"
                                            data-ar-time-expected="${arTimeExpected}"
                                            data-ar-venue="${arVenue}"
                                            data-ar-act-type="${arActivityType}"
                                            data-ar-program="${arProgram}"
                                            data-ar-cust-reqrments="${arCustRequirements}"
                                            data-ar-act-done="${arActivityDone}"
                                            data-ar-agreements="${arAgreements}"
                                            data-ar-sendcopyto="${arSendCopyTo}"                                   
                                            data-ar-target-date="${arTargetDate}"
                                            data-ar-details="${arDetails}"
                                            data-engr-name="${engrName}"
                                            data-engr-prod-name="${engrProdName}"
                                            data-proj-name="${projName}"
                                            data-proj-type="${projType}"
                                            data-project-id="${projectId}"
                                            >
                                            ${arRefNo}
                                        </a>
                                    </p>
                                </div>
                            `;
                            $('#implementation-modal').modal('show');
                            // Prepend input fields to the container
                            $("#mandayRefContainer").prepend(inputHTML);
                        }
                    });
                    // Attach a click event to the dynamically created links
                  // Attach a click event to the dynamically created links
                $('.ar_ref_link').off('click').on('click', function (e) {
                    e.preventDefault();
                    $('#loadingOverlay').show();

                    setTimeout(function() {
                 
                    // Retrieve data attributes from the clicked link
                    var arRefNo = $(this).data('ar-ref');
                    var arRequester = $(this).data('ar-requester');
                    var reportName = $(this).data('ar-report');
                    var statusName = $(this).data('status-name');
                    var instruction = $(this).data('ar-instruction');
                    var dateNeeded = $(this).data('ar-date-needed');
                    var dateFiled = $(this).data('ar-date-filed');
                    var activity = $(this).data('ar-activity');
                    var reseller = $(this).data('ar-reseller');
                    var resellerContact = $(this).data('ar-reseller-contact');
                    var resellerEmail = $(this).data('ar-reseller-email');
                    var endUser = $(this).data('ar-end-user');
                    var endUserContact = $(this).data('ar-end-user-contact');
                    var endUserLoc = $(this).data('ar-end-user-loc');
                    var endUserEmail = $(this).data('ar-end-user-email');
                    var actDate = $(this).data('ar-act-date');
                    var timeReported = $(this).data('ar-time-reported'); 
                    if (timeReported) {
                        var timeReporteddropdown = $('#time_reported1');
                        timeReporteddropdown.empty(); // Clear existing options
                        
                        // Append the single value as an option
                        timeReporteddropdown.append(new Option(timeReported, timeReported, true, true));
                        
                        timeReporteddropdown.trigger('change'); // Update the Select2 dropdown
                    }
                    var timeExited = $(this).data('ar-time-exited');
                    if (timeExited) {
                        var timeExiteddropdown = $('#time_exited1');
                        timeExiteddropdown.empty(); // Clear existing options
                        
                        // Append the single value as an option
                        timeExiteddropdown.append(new Option(timeExited, timeExited, true, true));
                        
                        timeExiteddropdown.trigger('change'); // Update the Select2 dropdown
                    }
                    var Product_line = $(this).data('ar-productline');   
                    if (Product_line) {
                        var Product_line = Product_line.split(',');
                        // Populate the second dropdown with ID #engineers_modal_two
                        var Product_lineDropdown = $('#product_line');
                        Product_lineDropdown.empty(); // Clear existing options
                        Product_line.forEach(function (value) {
                            Product_lineDropdown.append(new Option(value.trim(), value.trim(), true, true));
                        });
                        Product_lineDropdown.trigger('change'); // Update the Select2 dropdown
            
                    }
              
                    var timeExpected = $(this).data('ar-time-expected');
                    if (timeExpected) {
                        var timeExpecteddropdown = $('#time_expected1');
                        timeExpecteddropdown.empty(); // Clear existing options
                        
                        // Append the single value as an option
                        timeExpecteddropdown.append(new Option(timeExpected, timeExpected, true, true));
                        
                        timeExpecteddropdown.trigger('change'); // Update the Select2 dropdown
                    }
                    var venue = $(this).data('ar-venue');
                    var activityType = $(this).data('ar-act-type');
                    if (activityType) {
                        var act_type_dropdown = $('#Activity_Type');
                        act_type_dropdown.empty(); // Clear existing options
                        
                        // Append the single value as an option
                        act_type_dropdown.append(new Option(activityType, activityType, true, true));
                        
                        act_type_dropdown.trigger('change'); // Update the Select2 dropdown
                    }
                    var program_name = $(this).data('ar-program');
                    if (program_name) {
                        var program_name_dropdown = $('#program');
                        program_name_dropdown.empty(); // Clear existing options
                        
                        // Append the single value as an option
                        program_name_dropdown.append(new Option(program_name, program_name, true, true));
                        
                        program_name_dropdown.trigger('change'); // Update the Select2 dropdown
                    }
                    var cust_requirements = $(this).data('ar-cust-reqrments');
                    var act_done = $(this).data('ar-act-done');
                    var agreements = $(this).data('ar-agreements');
                    var sendCopyTo = $(this).data('ar-sendcopyto');
                    var engineerName = $(this).data('engr-name');
                    if (engineerName) {
                        var engineerName = engineerName.split(',');
                        // Populate the second dropdown with ID #engineers_modal_two
                        var engineersDropdownTwo = $('#engineers_modal_two');
                        engineersDropdownTwo.empty(); // Clear existing options
                        engineerName.forEach(function (value) {
                            engineersDropdownTwo.append(new Option(value.trim(), value.trim(), true, true));
                        });
                        engineersDropdownTwo.trigger('change'); // Update the Select2 dropdown
            
                    }
                    var prodengineerName = $(this).data('engr-prod-name');
                    if (prodengineerName) {
                        var prodengineerName = prodengineerName.split(',');
                        // Populate the second dropdown with ID #engineers_modal_two
                        var prodengineersDropdownTwo = $('#engineers_modal');
                        prodengineersDropdownTwo.empty(); // Clear existing options
                        prodengineerName.forEach(function (value) {
                            prodengineersDropdownTwo.append(new Option(value.trim(), value.trim(), true, true));
                        });
                        prodengineersDropdownTwo.trigger('change'); // Update the Select2 dropdown
            
                    }
                
                    console.log('Product_lineDropdown Name:', Product_lineDropdown)
                    
                    var projName = $(this).data('proj-name');
                    var projType = $(this).data('proj-type');
                    var projectId = $(this).data('project-id');
                    console.log('projectId: ',projectId);
                    console.log('projType: ',projType);
                    console.log('projName: ', projName);
                    


                    // Populate modal fields with retrieved data
                    $('#exampleModal').on('shown.bs.modal', function () {
                        var ajaxRequests = [];
                        $('#reference_no .reference_no').text(arRefNo); // Set text
                        $('#Ref_No').val(arRefNo); // Set input value
                        $('#reportDropdown1').val(reportName);  // Assuming 'someReportName' is the value you want to set
                        $(document).trigger('reportNameSet');  // Trigger the event after setting the value
                        var reportValue = $('#reportDropdown1').val(); 
                      
                        console.log($('#myDropdown1').length);   
                        
                        $('#statusDropdown1').val(statusName);
                        $(document).trigger('statusNameSet');  // Trigger the event after setting the value
                        if (reportValue === 'iSupport Services') {
                            // Show the required elements
                            $('#projecttype').show();
                            $('#projectname').show();
                            if (statusName === 'Completed' && 
                                (reportValue !== 'Skills Development' && reportValue !== '7' && 
                                reportValue !== 'Others' && reportValue !== '8')) {
                    
                                $('#completion_acceptance').show();
                    
                            } else {
                                $('#completion_acceptance').hide();
                            }
                            
                            // Reapply disabled states again here if necessary
                            $('#myDropdown1').prop('disabled', true);
                            $('#projtype_button1').prop('disabled', true);
                        }
                        
                        $('#act_details_requester').val(arRequester);
                        $('#special_instr').val(instruction);
                        $('#Date_Needed').val(dateNeeded);
                        $('#Date_Filed').val(dateFiled);
                        $('#act_details_activity').val(activity);
                        $('#Activity_details').val(activity);
                        $('#Reseller').val(reseller);
                        $('#reseller_contact_info').val(resellerContact);
                        $('#reseller_phone_email').val(resellerEmail);
                        $('#end_user_name').val(endUser);
                        $('#end_user_contact').val(endUserContact);
                        $('#end_user_loc').val(endUserLoc);
                        $('#end_user_email').val(endUserEmail);
                        $('#act_date').val(actDate);
                        $('#selectedProjectId').val(projectId); 
                        $('#projtype_button1').val(projType);   
                        $('#myDropdown1').val(projName);       

                        ajaxRequests.push($.ajax({
                            url: '/tab-activity/index/getProjName',  // update this URL as per your route
                            type: 'GET',
                            data: { refNo: arRefNo },
                            success: function (response) {
                                console.log('Response from server: ', response);
                                $('#project .proj_name').text(response.projectName);
                                $('#project_type .proj_type').text(response.projectTypeName);
                            
                                $('#projtype_button1').val(response.projectTypeName);
                            
                                // Display Project Name in Dropdown Button
                                var project_name_dropdown = $('#myDropdown1');
                                project_name_dropdown.empty();
                                project_name_dropdown.append(new Option(response.projectName, response.projectName, true, true));
                                project_name_dropdown.trigger('change');
                            
                                // Use the projectId from the response
                                $('#selectedProjectId').val(response.projectId);  // Make sure to set the actual project ID
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            },
                        }));
                        
                        $('#Activity_Type').val(activityType);
                        const category = reportName;
                        $('#Activity_Type').select2({
                            width: '100%',
                            dropdownParent: $('#exampleModal .modal-content'),
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
                        
                        $('#program').select2({
                            width: '100%',
                            dropdownParent: $('#exampleModal .modal-content'),
                            ajax: {
                                url: `/getProgram/${encodeURIComponent(category)}`,
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
                            },
                            success: function (data) {
                                console.log("Success:", data); // Log successful response
                            },
                            error: function (xhr, status, error) {
                                console.error("Error:", status, error); // Log AJAX error
                            }
                        });
                        $('#venue').val(venue);
                        $('#customerReqfield').val(cust_requirements);
                        $('#activity_donefield').val(act_done);
                        $('#Agreementsfield').val(agreements);
                        $('#sendcopyto').val(sendCopyTo);

                        $('#cancelButton').click(function () {                 
                            // Revert back to the original reference number
                            $('#reference_no .reference_no').text(arRefNo);
                            $('#Ref_No').val(arRefNo);
                        });
                        var selectedValue = $('#reportDropdown1').val();

                        ajaxRequests.push($.ajax({
                            url: '/tab-activity/index/getContractDetails_actionplan',  // 
                            type: 'GET',
                            data: { refNo: arRefNo },
                            success: function (response) {
                                console.log('Response from server: ', response);
                                // Empty the container first
                                $("#ActionPlan_Recommendation").empty();
                        
                                if (Array.isArray(response)) {
                                    // If there is fetched data
                                    response.forEach(function (data, index) {
                                        var plantargetdate = data.PlanTargetDate || ''; // Handle null or undefined values
                                        var details = data.PlanDetails || ''; // Handle null or undefined values
                                        var planowner = data.PlanOwner || ''; // Handle null or undefined values
                                        var inputHTML = '<div class="row actionplan mb-3">\
                                            <div class="col-md-2">\
                                                <div class="participant-container mb-3">\
                                                    <label for="validationServer12" class="form-label">Plan Target</label>\
                                                    <div class="input-group">\
                                                        <input type="date" class="form-control PlanTarget" id="targetPlan" \
                                                            value="' + plantargetdate + '">\
                                                    </div>\
                                                </div>\
                                            </div>\
                                            <div class="col-md-5">\
                                                <div class="position-container mb-3">\
                                                    <label for="validationServer12" class="form-label">Details</label>\
                                                    <div class="input-group">\
                                                        <textarea class="form-control Details" id="details" placeholder="Enter Details" rows="3">' + details + '</textarea>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                            <div class="col-md-3">\
                                                <div class="position-container mb-3">\
                                                    <label for="validationServer12" class="form-label">Plan Owner</label>\
                                                    <div class="input-group">\
                                                        <input type="text" class="form-control PlanOwner" placeholder=" Enter Plan Owner"\
                                                            value="' + planowner + '">\
                                                    </div>\
                                                </div>\
                                            </div>\
                                            <div class="col-md-2 align-self-center">\
                                                <div class="button-container mb-3 d-flex justify-content-center">\
                                                    <button type="button" class="btn btn-primary add-actionplan me-2">Add</button>\
                                                    <button type="button" class="btn btn-danger delete-actionplan"' + (index === 0 ? ' style="display:none;"' : '') + '>Delete</button>\
                                                </div>\
                                            </div>\
                                        </div>';
                        
                                        // Append it to the container
                                        $("#ActionPlan_Recommendation").append(inputHTML);
                                    });
                                } else {
                                    // If there is no fetched data, still display empty fields
                                    var inputHTML = '<div class="row actionplan mb-3">\
                                        <div class="col-md-2">\
                                            <div class="participant-container mb-3">\
                                                <label for="validationServer12" class="form-label">Plan Target</label>\
                                                <div class="input-group">\
                                                    <input type="date" class="form-control PlanTarget" id="targetPlan"\
                                                        value="">\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-5">\
                                            <div class="position-container mb-3">\
                                                <label for="validationServer12" class="form-label">Details</label>\
                                                <div class="input-group">\
                                                    <textarea class="form-control Details" id="details" placeholder="Enter Details" rows="3"></textarea>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-3">\
                                            <div class="position-container mb-3">\
                                                <label for="validationServer12" class="form-label">Plan Owner</label>\
                                                <div class="input-group">\
                                                    <input type="text" class="form-control PlanOwner" placeholder=" Enter Plan Owner"\
                                                        value="">\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-2 align-self-center">\
                                            <div class="button-container mb-3 d-flex justify-content-center">\
                                                <button type="button" class="btn btn-primary add-actionplan me-2">Add</button>\
                                                <button type="button" class="btn btn-danger delete-actionplan" style="display:none;">Delete</button>\
                                            </div>\
                                        </div>\
                                    </div>';
                        
                                    // Append empty fields to the container
                                    $("#ActionPlan_Recommendation").append(inputHTML);
                                }
                                toggleInputsActionPlan(true);
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            },
                            // complete: trackProgress
                        }));
                
                        /////////////////////////////// Participants and Position ////////////////////////  
                        ajaxRequests.push($.ajax({
                            url: '/tab-activity/index/getSummaryReport',
                            type: 'GET',
                            data: { refNo: arRefNo },
                            success: function (response) {
                                console.log('Response from server: ', response);
                        
                                // Empty the container first
                                $("#participantAndPositionContainer").empty();
                        
                                if (Array.isArray(response)) {
                                    // If there is fetched data
                                    response.forEach(function (data, index) {
                                        var participant = data.participant || ''; // Handle null or undefined values
                                        var position = data.position || ''; // Handle null or undefined values
                                        var inputHTML = '<div class="row participantposition mb-3">\
                                    <div class="col-md-5">\
                                        <div class="participant-container mb-3">\
                                            <label for="validationServer12" class="form-label">Participant:</label>\
                                            <div class="input-group">\
                                                <input type="text" class="form-control participant" placeholder="Enter Participant"\
                                                    value="' + participant + '">\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-5">\
                                        <div class="position-container mb-3">\
                                            <label for="validationServer12" class="form-label">Position:</label>\
                                            <div class="input-group">\
                                                <input type="text" class="form-control position" placeholder="Enter Position"\
                                                    value="' + position + '">\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-2 align-self-end text-center"> <!-- Adjust this width based on your needs -->\
                                        <div class="button-container mb-3 d-flex justify-content-center">\
                                            <button type="button" class="btn btn-primary add-position me-2">Add</button>\
                                            <button type="button" class="btn btn-danger delete-position"' + (index === 0 ? ' style="display:none;"' : '') + '>Delete</button>\
                                        </div>\
                                    </div>\
                                </div>';
                        
                                        // Append it to the container
                                        $("#participantAndPositionContainer").append(inputHTML);
                                    });
                                } else {
                                    // If there is no fetched data, still display empty fields
                                    var inputHTML = '<div class="row participantposition mb-3">\
                                    <div class="col-md-5">\
                                        <div class="participant-container mb-3">\
                                            <label for="validationServer12" class="form-label">Participant:</label>\
                                            <div class="input-group">\
                                                <input type="text" class="form-control participant" placeholder="Enter Participant"\
                                                    value="">\
                                            </div>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-5">\
                                        <div class="position-container mb-3">\
                                            <label for="validationServer12" class="form-label">Position:</label>\
                                            <div class="input-group">\
                                                <input type="text" class="form-control position" placeholder="Enter Position"\
                                                    value="">\
                                            </div>\
                                        </div>\
                                    </div>\
                                   <div class="col-md-2 align-self-end text-center"> <!-- Adjust this width based on your needs -->\
                                        <div class="button-container mb-3 d-flex justify-content-center">\
                                            <button type="button" class="btn btn-primary add-position me-2">Add</button>\
                                            <button type="button" class="btn btn-danger delete-position" style="display:none;">Delete</button>\
                                        </div>\
                                    </div>\
                                </div>';
                        
                                    // Append empty fields to the container
                                    $("#participantAndPositionContainer").append(inputHTML);
                                }
                                toggleInputsParticipant(true);
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX error:', status, error);
                            },
                            // complete: trackProgress
                        }));
                        console.log('Selected reportDropdown value:', selectedValue);
                    });

                    $(document).ready(function () {
                        let removedFiles = []; // Array to store removed file names
                        let originalFilesHTML = ''; // Variable to store original file HTML before edit
            
                        // AJAX request to get the files
                        $.ajax({
                            url: '/tab-activity/index/getFile',
                            type: 'GET',
                            data: { refNo: arRefNo },
                            success: function (response) {
                                console.log('Response from server: ', response);
            
                                if (response.retrieve_files && response.retrieve_files.length > 0) {
                                    // Clear the container before appending new files
                                    $('#fileDisplay').empty();
            
                                    response.retrieve_files.forEach(function (file) {
                                        if (file) {
                                            let filePath = 'uploads/' + file; // Adjust the path as needed
                                            let fileName = file.split('/').pop(); // Extract filename from filePath
            
                                            // Determine MIME type based on filename extension
                                            let mimeType = getMimeType(fileName);
            
                                            // Define icon path based on MIME type
                                            let iconPath = getIconPath(mimeType);
            
                                            // Function to set the display for each file
                                            function setFileDisplay(fileName, filePath, iconPath) {
                                                // Shorten the filename for display if needed
                                                let displayName = fileName.length > 20 ?
                                                    fileName.substring(0, 17) + '...' :
                                                    fileName;
            
                                                // Append each file display to the container
                                                $('#fileDisplay').append(`
                                                    <div class="file-container" style="margin-left: 2%;">
                                                        <div style="position: relative; display: inline-block;" >
                                                            <img src="${iconPath}" alt="File Icon" style="width:50px;height:50px;">
                                                            <button class="btn btn-danger btn-sm remove-button general-file-remove-button" data-filename="${fileName}" style="position: absolute; top: -9px; right: 0; width: 20px; height: 20px; border-radius: 50%; padding: 0;"><i class="bi bi-x"></i></button>
                                                        </div>
                                                        <a href="${filePath}" target="_blank">${displayName}</a>
                                                    </div>
                                                `);
                                            }
            
                                            setFileDisplay(fileName, filePath, iconPath); // Set the file display for each file
                                        }
                                    });
            
                                    originalFilesHTML = $('#fileDisplay').html(); // Store the original HTML
                                    $('.remove-button').hide(); // Show remove button on edit
            
            
                                    // Handle edit button click to show respective remove button
                                    $('#editbutton').click(function () {
                                        originalFilesHTML = $('#fileDisplay').html();
                                        $('.remove-button').show(); // Show remove button on edit
                                    });
            
                                    $('#cloneButton').click(function () {
                                        $('#fileDisplay').empty();
                                    });
            
                                    // Handle remove file button click (using event delegation)
                                    $(document).on('click', '.general-file-remove-button', function () {
                                        let button = $(this);
                                        let fileName = button.data('filename');
                                        var ar_id = row.find(ar_idClass).text().trim();
                                        console.log("Ar_id:", ar_id);
            
                                        // Show confirmation alert
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "Clicking this will permanently delete the image.",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Yes, delete it!',
                                            cancelButtonText: 'No, keep it!',
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                console.log('Remove button clicked');
                                                removedFiles.push(fileName); // Store the removed file name
                                                // Remove the file display container from DOM
                                                button.closest('.file-container').remove();
            
                                                // Handle the file deletion immediately
                                                if (ar_id) {
                                                    $.ajax({
                                                        url: '/tab-activity/index/deleteImage',
                                                        type: 'POST',
                                                        data: {
                                                            ar_id: ar_id,
                                                            files: [fileName], // Pass the single file name to delete
                                                            _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                                                        },
                                                        success: function (response) {
                                                            console.log('File deleted successfully:', fileName + ar_id);
                                                            // Show and hide appropriate elements after deletion
                                                            $('.remove-button').show(); // Show remove buttons after deletion
                                                        },
                                                        error: function (xhr, status, error) {
                                                            console.error('Error deleting file:', error);
                                                        }
                                                    });
                                                } else {
                                                    console.error("Error: ar_id is not available.");
                                                }
            
                                                Swal.fire(
                                                    'Deleted!',
                                                    'The file has been deleted.',
                                                    'success'
                                                );
                                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                                $('.remove-button').show(); // Show remove buttons after cancel
                                            }
                                        });
                                    });
            
                                } else {
                                    // No files found case
                                    $('#fileDisplay').html('<p>No files found.</p>');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('AJAX error:', status, error);
                                $('#fileDisplay').html('<p>Error fetching files.</p>');
                            }
                        });
            
                        // Handle cancel button click to restore original HTML
                        $('#cancelButton').click(function () {
                           // Hide remove buttons after cancel
                           $('.remove-button').hide();
                        });
                    });
                    function getMimeType(fileName) {
                        // Implement logic to determine MIME type based on file extension or other criteria
                        // Example implementation:
                        if (fileName.endsWith('.pdf')) {
                            return 'application/pdf';
                        } else if (fileName.endsWith('.png')) {
                            return 'image/png';
                        } else if (fileName.endsWith('.jpg') || fileName.endsWith('.jpeg')) {
                            return 'image/jpeg';
                        } else if (fileName.endsWith('.xlsx') || fileName.endsWith('.xls')) {
                            return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                        } else if (fileName.endsWith('.svg')) {
                            return 'image/svg+xml';
                        } else if (fileName.endsWith('.doc') || fileName.endsWith('.docx')) {
                            return 'application/msword';
                        } else if (fileName.endsWith('.txt')) {
                            return 'text/plain';
                        } else if (fileName.endsWith('.csv')) {
                            return 'text/csv';
                        } else {
                            return 'application/json'; // Default MIME type if none match
                        }
                    }
                    
                    function getIconPath(mimeType) {
                        // Define icon paths based on MIME type
                        const mimeToIcon = {
                            'application/pdf': '/assets/img/pdf.png',
                            'image/png': '/assets/img/png.png',
                            'image/jpeg': '/assets/img/jpg.png',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': '/assets/img/excel.png',
                            'image/svg+xml': '/assets/img/svg.png',
                            'application/msword': '/assets/img/doc.png',
                            'text/plain': '/assets/img/txt.png',
                            'text/csv': '/assets/img/csv.png'
                            // Add more mappings as needed
                        };
                    
                        // Default icon path
                        let iconPath = '/assets/img/download.png';
                        if (mimeToIcon[mimeType]) {
                            iconPath = mimeToIcon[mimeType];
                        }
                    
                        return iconPath;
                    }

                    $('#loadingOverlay').hide();
                    $('#exampleModal').modal('show');
                }.bind(this), 1000); // Optional 
                });

                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
                complete: function () {
                    // Always hide the loading overlay once the request completes (whether success or error)
                    $('#loadingOverlay').hide();
                }
            });
       
    });
});



$(document).ready(function () {
    $('#implementation-datatable tbody').on('click', 'tr', function () {
        $('#implementation-modal').on('shown.bs.modal', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var projectId = $('#projectID').val().trim(); // Get projectId from your HTML element
            var projectIdArray = projectId.split(',').filter(function (id) {
                return id.trim() !== "";
            });

            // Make an AJAX request to fetch the payment status, updated by, and date values
            $.ajax({
                url: '/tab-isupport/PaymentStatus',
                type: 'POST',
                data: {
                    projectId: projectIdArray
                },
                success: function (response) {
                    console.log('Success', response);

                    // Empty the container first
                    $("#paymentStatusContainer").empty();

                    // Iterate over each payment status object in the response array
                    response.forEach(function (payment) {
                        // Extract payment status, updated by, and date values
                        var status = payment.payment_status;
                        var updatedBy = payment.updated_by;
                        var date = payment.date;

                        // Create paragraph elements to display payment status, updated by, and date
                        var inputHTML = '<div class="col-md-12 d-flex align-items-center gap-2 mb-2">\
                        <input class="form-control payment_status" value="' + status + '"  style="width: 50%;" disabled>\
                        <input class="form-control date" value="' + date + '" style="width: 20%;" disabled>\
                        <input class="form-control updated_by" value="' + updatedBy + '" style="width: 30%;" disabled>\
                        </div>';

                        // Append paragraph elements to the container
                        $("#paymentStatusContainer").append(inputHTML);
                    });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
});

/////////////////////////////// Filtering Function /////////////////////////

$(document).ready(function () {
    var table = $('#implementation-datatable').DataTable(); // Initialize DataTable

    $('#status').change(function () {
        var selectedStatus = $(this).val(); // Get the selected status from the dropdown

        // Apply filter based on selectedStatus
        if (selectedStatus === 'All') {
            // Clear any existing search and redraw the table to show all rows
            table.search('').columns().search('').draw();
        } else {
            // Apply filter to the "Completed" column based on selectedStatus
            table.column(15).search(selectedStatus).draw();
        }
    });
});

/////////////////////////////// Cloning /////////////////////////

$(document).ready(function () {
    // Add new participant and position field
    $("#divApprovers").on("click", ".add-field", function () {
        var newFields = $(".cloned-fields:first").clone();

        // Show both "Add" and "Remove" buttons in the new clone
        newFields.find('.add-field, .remove-field').show();

        // Clear the values in the cloned fields
        newFields.find('input').val('');

        // Append the clones to their respective containers
        $(this).closest('.cloned-fields').after(newFields);
    });

    // Remove participant and position field
    // $("#divApprovers").on("click", ".remove-field", function () {
    //     $(this).closest('.cloned-fields').remove();
    // });

        // Delegate event listener for delete buttons
        $('#divApprovers').on('click', '.remove-field', function () {
            const $approverRow = $(this).closest('.cloned-fields');
    
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
    

    // Initially hide the "Remove" button in the template
    $(".cloned-fields:first .remove-field").hide();

});




//////////////////////////// Fetch Isupport Project , Reseller, End User, id, date created ////////////////////////
$(document).ready(function () {
    var table = $('#implementation-datatable').DataTable();
    var selectedData = null;

    // Store the data when a row is clicked
    $('#implementation-datatable tbody').on('click', 'tr', function () {
        selectedData = table.row(this).data();
        if (selectedData) {
            var created_date = selectedData[3];
            $('#created_date').val(created_date);
            console.log('DAte for edit', created_date)
        }
    });

    // Show the modal and populate the fields when the button is clicked
    $('#create_button').on('click', function () {
        if (selectedData) {
            // Assuming data[1] is Project, data[16] is Reseller, and data[17] is End User
            var project = selectedData[2];
            var created_date = selectedData[3];
            var reseller = selectedData[17];
            var endUser = selectedData[18];
            var projectListId = selectedData[25];

            // Set the values to the input fields
            $('#completion_proj').val(project);
            $('#completion_reseller').val(reseller);
            $('#completion_enduser').val(endUser);

            $('#Projectlist_id').val(projectListId);
            $('#CreatedDate').val(created_date);

            // Display the project list id in the console
            // console.log('Project List ID:', projectListId);

            // Show the modal
            $('#signoffForm').modal('show');
        } else {
            Swal.fire('Table error!', 'Please select a row from the table first.', 'warning');
        }
    });

    $('#signoffForm').on('hidden.bs.modal', function () {
        $('body').addClass('modal-open');
    });
});


/////////////////////////////// Send to Database the Project Signoff Document //////////////////
function addIndicator(inputElement) {
    // Add red border, padding, and glow effect to the input field
    inputElement.style.border = '1px solid red';
    inputElement.style.padding = '4px'; // Adjust the padding as needed
    inputElement.style.boxShadow = '0 0 2px red'; // Glow effect, adjust as needed
    // Remove the indicator after 3 seconds
    setTimeout(function() {
    removeIndicator(inputElement);
    }, 3000);
  
  }

  function removeIndicator(inputElement) {
    // Remove the border, padding, and glow effect from the input field
    inputElement.style.border = '';
    inputElement.style.padding = '';
    inputElement.style.boxShadow = '';
  }

$(document).ready(function () {

    // Function to get the current date and time
    function getCurrentDateTime() {
        var now = new Date();
        var year = now.getFullYear();
        var month = ('0' + (now.getMonth() + 1)).slice(-2); // Add leading zero
        var day = ('0' + now.getDate()).slice(-2); // Add leading zero
        var hours = ('0' + now.getHours()).slice(-2); // Add leading zero
        var minutes = ('0' + now.getMinutes()).slice(-2); // Add leading zero
        var seconds = ('0' + now.getSeconds()).slice(-2); // Add leading zero

        return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
    }  

    $("#cancelProjectSignoffDocument").off("click").on("click", function () {
        const deliverablesInput = document.getElementById('txtDeliverables');

        const txtCompany = document.getElementById('txtCompany');
        const txtApprover = document.getElementById('txtApprover');
        const txtPositions = document.getElementById('txtPositions');
        const txtEmail = document.getElementById('txtEmail');

        deliverablesInput.value = ''; // Clear the value of the input/textarea
        txtCompany.value = '';
        txtApprover.value = '';
        txtPositions.value = '';
        txtEmail.value = '';
    });

    $("#ProjectSave").off("click").on("click", function () {
        var txtDeliverablesError = document.getElementById('txtDeliverablesError');
        var txtDeliverablesInput = document.getElementById('txtDeliverables');
        var divApproversError = document.getElementById('divApproversError');
        var txtCompanyInput = document.getElementById('txtCompany');
        var txtApproverInput = document.getElementById('txtApprover');
        var txtPositionsInput = document.getElementById('txtPositions');
        var txtEmailInput = document.getElementById('txtEmail');


        if ($('#attachments')[0].files.length > 0) {
            Swal.fire('Import error!', 'Please Click Import if you want to attach file.', 'warning');
            return false;
        }


        var currentDateTime = getCurrentDateTime();
        $('#time').val(currentDateTime);

        var project_id = ($('#Projectlist_id').val());
        var Created_By = ($('#createdBy').val());
        var Deliverables = $('#txtDeliverables').val();
 
        // var CreatedDate = ($('#CreatedDate').val());
        var CreatedDateTime = ($('#time').val());
        // var CreatedDateTime = CreatedDate + ' ' + CreatedTime;

        var Project = ($('#completion_proj').val());
        var Reseller = ($('#completion_reseller').val());
        var EndUser = ($('#completion_enduser').val());

        // Initialize an array to store the approvers' details
        var approversArray = [];
        var approversValid = true;

        // Get and log details of all Approvers fields
        $('#divApprovers .cloned-fields').each(function (index, element) {
            var company = $(element).find('input[name="txtCompany[]"]').val();
            var approver = $(element).find('input[name="txtApprover[]"]').val();
            var position = $(element).find('input[name="txtPositions[]"]').val();
            var email = $(element).find('input[name="txtEmail[]"]').val();

            // Check if all fields for the current approver are filled
            if (company.trim() === "" || approver.trim() === "" || position.trim() === "" || email.trim() === "") {
                approversValid = false;
                return false; // Break out of the loop if validation fails
            }

            // Create an object for the current approver
            var approverDetails = {
                company: company,
                approver: approver,
                position: position,
                email: email
            };

            // Add the object to the array
            approversArray.push(approverDetails);

        });       

        var ProjectCompletion = {
            project_id, Deliverables, Created_By, CreatedDateTime, Project, Reseller, EndUser, approversArray
        };

        $.ajax({
            type: 'POST',
            url: '/EmailTemplate/Act-Report-Email-Forward/projectsavepending',
            data: {
                CompletionData: JSON.stringify(ProjectCompletion),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                `.`
                if (response.success) {
                    Swal.fire({ text: "Saved successfully!", icon: "success"});
                    $("#loading-overlay").hide();

                    var routeUrl = $('#completionApprovalRoute').val();
                    var projectId = $('#Projectlist_id').val();

                    // Construct the URL with query parameter
                    var redirectUrl = routeUrl + '?Projectlist_id=' + projectId;

                    window.open(redirectUrl, '_blank');

                } else {
                    console.log('Server response error:', response);
                    Swal.fire('Saving Error!', 'Failed to Save', 'error');
                    $("#loading-overlay").hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({ text: "An error Occurred", icon: "error"});
                console.error('AJAX error:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);
                $("#loading-overlay").hide();
            }
        });


    });
});

////////////////////////// File Saving ///////////////////////////

$(document).ready(function () {
    $("#UploadFile").off("click").on("click", function () {
        // Get selected files
        var fileInput = $('#attachments')[0].files;
        var project_id = $('#Projectlist_id').val();

        // Show the spinner
        $("#spinner").show();

        if (fileInput.length > 0) {
            var form_data = new FormData();
            for (var i = 0; i < fileInput.length; i++) {
                form_data.append('files[]', fileInput[i]);
            }
            form_data.append('project_id', project_id);

            // Log FormData entries
            form_data.forEach(function (value, key) {
                console.log(key, value);
            });

            $.ajax({
                url: '/EmailTemplate/Act-Report-Email-Forward/SignoffAttachment',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (output) {
                    console.log('Response from server:', output);
                    Swal.fire({ text: "File Saved successfully!", icon: "success"});
                    $("#spinner").hide();
                    $("#attachments").val('');
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({ text: "Error saving files.", icon: "error"});
                    $("#spinner").hide();
                }
            });
        } else {
            Swal.fire({ text: "Please select at least one file to upload.", icon: "error"});
            $("#spinner").hide();
        }
    });
});



/////////////////////////// Save Edit Button ////////////////////////////////////

$(document).ready(function () {

    $("#saveEditBtn").off("click").on("click", function () {
        var divApproversError = document.getElementById('divApproversError');

        function getCurrentDateTime() {
            var now = new Date();
            var year = now.getFullYear();
            var month = ('0' + (now.getMonth() + 1)).slice(-2); // Add leading zero
            var day = ('0' + now.getDate()).slice(-2); // Add leading zero
            var hours = ('0' + now.getHours()).slice(-2); // Add leading zero
            var minutes = ('0' + now.getMinutes()).slice(-2); // Add leading zero
            var seconds = ('0' + now.getSeconds()).slice(-2); // Add leading zero

            return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
        }



        var currentDateTime = getCurrentDateTime();
        $('#time').val(currentDateTime);

        var project_id = ($('#projectlist_id').val());
        var Created_By = ($('#createdby_approval').val());

        var Deliverables = ($('#txtDeliverables').val());
        // var CreatedDate = ($('#CreatedDate').val());
        var CreatedDateTime = ($('#time').val());
        // var CreatedDateTime = CreatedDate + ' ' + CreatedTime;

        var Project = ($('#projtitle_approval').val());
        var Reseller = ($('#reseller_approval').val());
        var EndUser = ($('#enduser_approval').val());

        // Initialize an array to store the approvers' details
        var approversArray = [];
        var approversValid = true;

      // Get and log details of all Approvers fields
    $('#divApprovers .cloned-fields').each(function (index, element) {
        var company = $(element).find('input[name="txtCompany[]"]').val();
        var approver = $(element).find('input[name="txtApprover[]"]').val();
        var position = $(element).find('input[name="txtPositions[]"]').val();
        var email = $(element).find('input[name="txtEmail[]"]').val();

        var emailPattern = /^[a-zA-Z0-9._%+-]+@msi-ecs\.com\.ph$/;

        // Check for empty fields first
        if (company.trim() === "" || approver.trim() === "" || position.trim() === "" || email.trim() === "") {
            approversValid = false;
            // Show specific indicators for the current field
            addIndicator($(element).find('input[name="txtCompany[]"]')[0]);
            addIndicator($(element).find('input[name="txtApprover[]"]')[0]);
            addIndicator($(element).find('input[name="txtPositions[]"]')[0]);
            addIndicator($(element).find('input[name="txtEmail[]"]')[0]);
        } else {
            // Remove any previous indicators if the field is valid
            removeIndicator($(element).find('input[name="txtCompany[]"]')[0]);
            removeIndicator($(element).find('input[name="txtApprover[]"]')[0]);
            removeIndicator($(element).find('input[name="txtPositions[]"]')[0]);
            removeIndicator($(element).find('input[name="txtEmail[]"]')[0]);
        }

        // Removed validation for @msi-ecs.com.ph email

        // If all validations pass, create an object for the current approver
        if (approversValid) {
            var approverDetails = {
                company: company,
                approver: approver,
                position: position,
                email: email
            };

            // Add the object to the array
            approversArray.push(approverDetails);
        }
    });

    // Check if all approvers are valid
    if (!approversValid) {
        divApproversError.innerText = "Please fill in all required fields correctly.";
        return false;
    } 
    $("#loading-overlay").show();
        var ProjectCompletion = {
            project_id, Deliverables, Created_By, CreatedDateTime, Project, Reseller, EndUser, approversArray
        };

        $.ajax({
            type: 'POST',
            url: '/EmailTemplate/Act-Report-Email-Forward/projectsavepending',
            data: {
                CompletionData: JSON.stringify(ProjectCompletion),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                `.`
                if (response.success) {
                    Swal.fire({ text: "Saved successfully!", icon: "success"});
                    $("#loading-overlay").hide();
                    location.reload();
                } else {
                    console.log('Server response error:', response);
                    Swal.fire({ text: "Failed to Save!", icon: "error"});
                    $("#loading-overlay").hide();
                    location.reload();
                    Swal.fire({ text: "", icon: "error"});
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({ text: "An error Occurred", icon: "error"});
                console.error('AJAX error:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);
                $("#loading-overlay").hide();
            }
        });


    });
});

document.getElementById('cancelBtn').addEventListener('click', function () {
    // Get the error message element
    const divApproversError = document.getElementById('divApproversError'); // Ensure this ID is correct
    
    if (divApproversError) {
        // Clear the error message when the cancel button is clicked
        divApproversError.innerText = "";
        console.log('Cancel Button is clicked, and error message is cleared');
    } else {
        console.log('Error message element not found');
    }
});
///////////////////// End Save Edit Button ////////////////////////////////////


///////////////////////// Send to Client /////////////////////////////////////
$(document).ready(function () {

    $("#confirmBtn").off("click").on("click", function () {


        $("#loading-overlay").show();

        var id = ($('#projectlist_id').val());
        var CreatedBy = ($('#createdby_approval').val());
        var CreatedDate = ($('#createddate_approval').val());
        var ProjectTitle = ($('#projtitle_approval').val());
        var Reseller = ($('#reseller_approval').val());
        var EndUser = ($('#enduser_approval').val());

        var Deliverables = ($('#txtDeliverables').val());

        var approversArray = [];

        // Get and log details of all Approvers fields
        $('#divApprovers .cloned-fields').each(function (index, element) {
            var company = $(element).find('input[name="txtCompany[]"]').val();
            var approver = $(element).find('input[name="txtApprover[]"]').val();
            var position = $(element).find('input[name="txtPositions[]"]').val();
            var email = $(element).find('input[name="txtEmail[]"]').val();

            // Create an object for the current approver
            var approverDetails = {
                company: company,
                approver: approver,
                position: position,
                email: email
            };

            // Add the object to the array
            approversArray.push(approverDetails);

        });

        var attachmentsArray = gatherAttachmentsData();

        var ForApprovalData = {
            id, CreatedBy, CreatedDate, ProjectTitle, Reseller, EndUser, Deliverables, approversArray, attachmentsArray
        };

        console.log(" Data Sent: ", ForApprovalData);

        $.ajax({
            type: 'POST',
            url: '/EmailTemplate/Act-Report-Email-Forward/ProjectSenttoClient',
            data: {
                CompletionData: JSON.stringify(ForApprovalData),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {

                if (response.success) {
                    Swal.fire({ text: "Email sent successfully.", icon: "success"});
                    $("#loading-overlay").hide();
                    location.reload();
                } else {
                    console.log('Server response error:', response);
                    Swal.fire({ text: "Failed to send email", icon: "error"});
                    $("#loading-overlay").hide();
                }
            },

            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({ text: "An error Occurred", icon: "error"});
                console.error('AJAX error:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);
                $("#loading-overlay").hide();
            }
        });
    });

    // Function to gather attachments data from the container
    function gatherAttachmentsData() {
        var attachmentsArray = [];
        $('#attachments-container .attachment-item').each(function (index, element) {
            var attachmentLink = $(element).find('a');
            var filename = attachmentLink.text();
            var path = attachmentLink.attr('href');
            attachmentsArray.push({
                filename: filename,
                path: path
            });
        });
        return attachmentsArray;
    }

});

///////////////////////// End Send to Client /////////////////////////////////////

document.addEventListener('DOMContentLoaded', function () {
    // Get the numerical status from the span element
    const statusElement = document.querySelector('#projstatus');
    const numericalStatus = statusElement.textContent.trim();

    // Convert numerical status to words and corresponding CSS class
    let statusWord;
    let alertClass;

    switch (numericalStatus) {
        case '1':
            statusWord = 'DRAFT';
            alertClass = 'alert-warning';
            break;
        case '2':
            statusWord = 'SENT';
            alertClass = 'alert-info';
            break;
        case '3':
            statusWord = 'APPROVED';
            alertClass = 'alert-success';
            break;
        default:
            statusWord = 'DISAPPROVED';
            alertClass = 'alert-danger';
            break;
    }

    // Update the HTML content
    statusElement.innerHTML = `<div class='${alertClass}'>${statusWord}</div>`;
});


// Check if the Sign off is already Approved or Disapproved

// document.addEventListener('DOMContentLoaded', function () {
//     var status = $('#projstatus .status').text().trim();
//     console.log(status);
//     if ((status == "APPROVED") || (status == "DISAPPROVED")) {
//         $("#confirmBtn").hide();
//         $("#editBtn").hide();
//     }
// });

document.addEventListener('DOMContentLoaded', function() {
    var statusElement = document.getElementById('projstatus');
    var statusValue = statusElement.innerText || statusElement.textContent;
    console.log('Status Try:', statusValue);

    if ((statusValue == "APPROVED") || (statusValue == "DISAPPROVED")) {
                $("#confirmBtn").hide();
                $("#editBtn").hide();
            }
});



// Approvers Status

document.addEventListener('DOMContentLoaded', function () {
    // Get all elements with the class 'approverstatus'
    const approverStatusElements = document.querySelectorAll('.approverstatus');

    // Loop through each element
    approverStatusElements.forEach(function (ApprStatus) {
        const statusText = ApprStatus.textContent.trim();  // Get the status text

        // Initialize variables for background color and text color
        let bgColor;
        let textColor;

        // Determine the colors based on the status
        switch (statusText) {
            case "PENDING":
                bgColor = '#ffc107';
                textColor = '#212529';
                break;
            case "FOR APPROVAL":
                bgColor = '#17a2b8';
                textColor = '#fff';
                break;
            case "APPROVED":
                bgColor = '#28a745';
                textColor = '#fff';
                break;
            case "DISAPPROVED":
                bgColor = '#dc3545';
                textColor = '#fff';
                break;
            default:
                bgColor = '#dc3545';
                textColor = '#fff';
                break;
        }

        // Update the HTML content with inline styles for color
        ApprStatus.style.backgroundColor = bgColor;
        ApprStatus.style.color = textColor;
        ApprStatus.style.padding = '0.2rem 0.5rem';
        ApprStatus.style.borderRadius = '0.25rem';
        ApprStatus.style.display = 'inline-block';
    });
});


$(document).ready(function () {

    $("#cancelBtn").hide();
    $("#saveEditBtn").hide();
    // $("#confirmBtn").show();
    // $("#editBtn").show();

    $("#editBtn").off("click").on("click", function () {

        $("#txtDeliverables").removeAttr("disabled");
        $("#divApprovers input").removeAttr("disabled");
        $("#divApprovers button").removeAttr("disabled");

        $("#cancelBtn").show();
        $("#saveEditBtn").show();
        $("#confirmBtn").hide();
        $("#editBtn").hide();
        $("#backBtn").hide();

    });

    $("#cancelBtn").off("click").on("click", function () {
        $("#txtDeliverables").attr("disabled", "disabled");
        $("#divApprovers input").attr("disabled", "disabled");
        $("#divApprovers button").attr("disabled", "disabled");

        $("#cancelBtn").hide();
        $("#saveEditBtn").hide();
        $("#confirmBtn").show();
        $("#editBtn").show();
        $("#backBtn").show();
    });
});

document.getElementById('backBtn').addEventListener('click', function() {
    window.close();
});

$(document).ready(function () {

    var table = $('#implementation-datatable').DataTable();
    var selectedData = null;

    // Store the data when a row is clicked
    $('#implementation-datatable tbody').on('click', 'tr', function () {
        selectedData = table.row(this).data();

    });

    $("#proj_signOffBtn").off("click").on("click", function () {

        if (selectedData) {
            var projectListId = selectedData[25];

            $('#projectsignoff_id').val(projectListId);

            var projectId = $('#projectsignoff_id').val();
            console.log('Project Id: ' + projectId);

            // Define the URL you want to redirect to
            var routeUrl = '/EmailTemplate/Act-Report-Email-Forward/ProjectSign-Off-View';

            // Construct the URL with query parameter
            var redirectUrl = routeUrl + '?Projectlist_id=' + projectId;

            // Open the URL in a new tab
            window.open(redirectUrl, '_blank');

        } else {
            Swal.fire({ text: "Please select a row from the table first", icon: "warning"});
        }



    });
});

$(document).ready(function () {
    document.getElementById('cancelProjectSignoffDocument').addEventListener('click', function() {
        
        
    });
});