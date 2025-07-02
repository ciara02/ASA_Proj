
// $(document).ready(function () {
//     $('#expCenterTable').DataTable({
//         dom: 'Bfrtip',
//         buttons: [
//             {
//                 extend: 'print',
//                 text: '<i class="bi bi-printer"></i> Print',
//                 className: 'buttons-print btn btn-success',
//                 title: function () {
//                     var currentDate = new Date();
//                     var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
//                     return 'ASA Experience Center - ' + formattedDate;
//                 },
//                 customize: function (win) {
//                     $(win.document.body).css('font-size', '10pt')
//                         .css('margin', '0')
//                         .css('padding', '0')
//                         .css('width', '100%');

//                     $(win.document.body).find('table')
//                         .addClass('compact')
//                         .css('font-size', 'inherit')
//                         .css('width', '100%')
//                         .css('table-layout', 'fixed');

//                     $(win.document.body).find('table').find('th, td')
//                         .css('word-wrap', 'break-word');

//                     // Set the page size and orientation
//                     var css = '@page { size: A4 landscape; margin: 1cm; }';
//                     var head = win.document.head || win.document.getElementsByTagName('head')[0];
//                     var style = win.document.createElement('style');
//                     style.type = 'text/css';
//                     style.media = 'print';
//                     if (style.styleSheet) {
//                         style.styleSheet.cssText = css;
//                     } else {
//                         style.appendChild(win.document.createTextNode(css));
//                     }
//                     head.appendChild(style);
//                 }
//             },
//             {
//                 text: '<i class="bi bi-file-earmark-excel"></i> Excel',
//                 className: 'buttons-excel btn btn-primary',
//                 action: function (e, dt, button, config) {
//                     var currentDate = new Date();
//                     var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
//                     var workbook = new ExcelJS.Workbook();
//                     var worksheet = workbook.addWorksheet('ASA Experience Center - ' + formattedDate);

//                     worksheet.columns = dt.columns().header().toArray().map((header, i) => ({
//                         header: $(header).text(),
//                         key: i.toString(),
//                         width: 25, // Adjust the width as needed
//                     }));

//                     dt.rows({ search: 'applied' }).every(function (rowIdx) {
//                         var row = dt.row(rowIdx).data();
//                         worksheet.addRow(row);
//                     });

//                     worksheet.pageSetup.paperSize = 9; // A4
//                     worksheet.pageSetup.orientation = 'landscape';
//                     worksheet.pageSetup.fitToPage = true;
//                     worksheet.pageSetup.fitToWidth = 1;
//                     worksheet.pageSetup.fitToHeight = 0;

//                     workbook.xlsx.writeBuffer().then(function (buffer) {
//                         saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'ASA Experience Center - ' + formattedDate + '.xlsx');
//                     });
//                 }
//             }
//         ],
//         initComplete: function() {
//             // Move buttons to the container
//             $('#printButtonContainer').html($('.dt-buttons'));

//             // Adjust buttons style and size to match Bootstrap's success and primary buttons
//             $('.buttons-print, .buttons-excel').each(function() {
//                 $(this).removeClass('dt-button')
//                        .addClass('btn')
//                        .css({
//                            'padding': '0.375rem 0.75rem',
//                            'font-size': '1rem',
//                            'border-radius': '.25rem'
//                        });
//             });
//         },
//         responsive: true,
//         deferRender: true,
//         scrollX: true,
//         scrollCollapse: true,
//         fixedColumns: true,
//     });
// });

$(document).ready(function () {
    $('#expCenterTable').DataTable({
        dom: 'Bfrtip',
        pageLength: 18,
        buttons: [
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'buttons-print btn btn-success',
                title: function () {
                    var currentDate = new Date();
                    var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                    return 'Experience Center Report  - ' + formattedDate;
                },
                customize: function (win) {
                    // Set A4 paper size
                    $(win.document.head).append('<style>@page { size: A4 landscape; margin: 20mm; }</style>');
                    // Add styles to the print view
                    $(win.document.head).append('<style>head.dt-print-view h1 { text-align: center; margin: 1em; }</style>');
                    $(win.document.head).append('<style>table.dataTable th, table.dataTable td { word-wrap: break-word; white-space: normal; }</style>');
                    
                    // Remove DataTables default heading
                    $(win.document.head).append('<style>.dt-print-view h1 { display: none; }</style>');
                    
                    // Add logo to the top of the document
                    var imgSrc = "assets/img/official-logo.png";
                    console.log('Image path:', imgSrc);  // Debugging: Log the image path to console
                    
                    // Image styling for fade effect and centering vertically and horizontally
                    var imgStyle = 'position:fixed; top:50%; left:50%; transform: translate(-50%, -50%); max-width: 50%; max-height: 50%; opacity:0.2;';
                    
                    // Prepend the image as a background to the body
                    $(win.document.body).prepend('<img src="' + imgSrc + '" style="' + imgStyle + '" />');
                    
                    // Get the total row count
                    var rowCount = $('#expCenterTable').DataTable().rows().count();
                    
                    // Append total row count to every page
                    $(win.document.body).prepend('<div id="row-count" style="position: fixed; top: 0px; right: 10px; font-size: 12px;">Total rows: ' + rowCount + '</div>');
                    
                    // Apply styles to the table
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .find('table')
                        .addClass('compact')
                        .css({'font-size': 'inherit', 'z-index': '1'}); // Adjusting z-index of the table
                    
                    // Apply word-wrap to each column
                    $(win.document.body)
                        .find('table')
                        .find('th, td')
                        .css('word-wrap', 'break-word');
                }
            },
            {
                extend: 'excel',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'buttons-excel btn btn-primary',
                filename: function () {
                    var currentDate = new Date();
                    var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                    return 'Experience Center Report - ' + formattedDate;
                }
            }
        ],
        initComplete: function() {
            // Move buttons to the container
            $('#printButtonContainer').html($('.dt-buttons'));

            // Adjust buttons style and size to match Bootstrap's success and primary buttons
            $('.buttons-print, .buttons-excel').each(function() {
                $(this).removeClass('dt-button')
                       .addClass('btn')
                       .css({
                           'padding': '0.375rem 0.75rem',
                           'font-size': '1rem',
                           'border-radius': '.25rem'
                       });
            });
        },
        responsive: true,
        deferRender: true,
        scrollX: true,
        scrollCollapse: true,
        fixedColumns: true,
        createdRow: function(row, data, dataIndex) {
            // Add the highlight-hover class to each row
            $(row).addClass('highlight-hover');
        },
    });
});


$('#exampleModal').on('show.bs.modal', function () {
    $(this).find('input, select, textarea').each(function () {
        var $element = $(this);
        $element.data('original-value', $element.val());
        if ($element.is(':checkbox, :radio')) {
            $element.data('original-checked', $element.prop('checked'));
        }
    });
});
$('#cancelButton').click(function () {
    Swal.fire({
        title: "Are you sure you want to cancel?",
        text: "Unsaved data will be removed.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) { // Check if the confirm button was clicked
            $('#exampleModal').find('input, select, textarea').each(function () {
                var $element = $(this);
                if ($element.is(':checkbox, :radio')) {
                    $element.prop('checked', $element.data('original-checked'));
                } else {
                    $element.val($element.data('original-value'));
                }
            });
        }
    });
});

$(document).ready(function () {

    function setEngineerName(clickedRow = null) {
        var EngrNameValue;
        if (clickedRow) {
            // If a row is clicked in the DataTable
            EngrNameValue = $(clickedRow).find('td').eq(3).text();
        } else {
            // Default to modal's context if no row is clicked
            EngrNameValue = $('#exampleModal').find('td').eq(3).text();
        }

        if (EngrNameValue) {
            var engineerName = EngrNameValue.split(',');
            // Populate the second dropdown with ID #engineers_modal_two
            var engineersDropdownTwo = $('#engineers_modal_two');
            engineersDropdownTwo.empty(); // Clear existing options
            engineerName.forEach(function (value) {
                engineersDropdownTwo.append(new Option(value.trim(), value.trim(), true, true));
            });
            engineersDropdownTwo.trigger('change'); // Update the Select2 dropdown

        }
    }

    function setActivityType(data) {

        var act_type = data[6];
        console.log("Activity Type: ", act_type);


        if (act_type) {
            var activity_type = act_type.split(',');
            var act_type_dropdown = $('#Activity_Type');
            act_type_dropdown.empty(); // Clear existing options
            activity_type.forEach(function (value) {
                act_type_dropdown.append(new Option(value.trim(), value.trim(), true, true));
            });
            act_type_dropdown.trigger('change'); // Update the Select2 dropdown
        }

    }
 ///////////////////////// Auto-Populate Time Reported Dropdown //////////////////////////////
    function setTimeReported(data) {

        var setTimeReported = data[7];
        console.log("Activity Type: ", setTimeReported);


        if (setTimeReported) {
            var timereported = setTimeReported.split(',');
            var setTimeReported_dropdown = $('#time_reported1');
            setTimeReported_dropdown.empty(); // Clear existing options
            timereported.forEach(function (value) {
                setTimeReported_dropdown.append(new Option(value.trim(), value.trim(), true, true));
            });
            setTimeReported_dropdown.trigger('change'); // Update the Select2 dropdown
        }

    }

     ///////////////////////// Auto-Populate Time Exited Dropdown //////////////////////////////
     function setTimeExited(data) {

        var time_exited = data[8];
        console.log("Activity Type: ", time_exited);

        if (time_exited) {
            var timeexited = time_exited.split(',');
            var time_exited_dropdown = $('#time_exited1');
            time_exited_dropdown.empty(); // Clear existing options
            timeexited.forEach(function (value) {
                time_exited_dropdown.append(new Option(value.trim(), value.trim(), true, true));
            });
            time_exited_dropdown.trigger('change'); // Update the Select2 dropdown
        }
    }

      // Initialize the DataTable
      $('#expCenterTable').DataTable();

      function showProgressSpinner() {
          $('#loading-progress').show();
          $('#spinner-text').text('0%');
      }
  
      // Update the progress spinner
      function updateProgressSpinner(percent) {
          var wholePercent = Math.floor(percent); // Convert to whole number
          $('#spinner-text').text(wholePercent + '%');
      }
  
      // Hide the progress spinner
      function hideProgressSpinner() {
          $('#loading-progress').hide();
      }
  



    $('#expCenterTable tbody').on('click', '.clickable-row', function () {
        showProgressSpinner();

        //Assigning Value to Modal Textfields
        var data = $(this).data('refno').split('|');

        setEngineerName(this);
        setActivityType(data);
        setTimeReported(data);
        setTimeExited(data);

        var reportValue = data[16];
        var statusValue = data[17];
        var referenceNumber = $(this).find('td').eq(2).text();
        var date = $(this).find('td').eq(1).text();
        var act_details = $(this).find('td').eq(6).text();
        var reseller = $(this).find('td').eq(5).text();
        var Venue = data[10];

        var category;
        switch (reportValue) {
            case "1":
                category = "Support Request";
                break;
            case "2":
                category = "iSupport Services";
                break;
            case "3":
                category = "Client Calls";
                break;
            case "4":
                category = "Internal Enablement";
                break;
            case "5":
                category = "Partner Enablement/Recruitment";
                break;
            case "6":
                category = "Supporting Activity";
                break;
            case "7":
                category = "Skills Development";
                break;
            case "8":
                category = "Others";
                break;
            default:
                category = "";
        }

        var status;
        switch (statusValue) {
            case "1":
                status = "Pending";
                break;
            case "2":
                status = "Pending";
                break;
            case "3":
                status = "For Follow up";
                break;
            case "4":
                status = "Activity Report being created";
                break;
            case "5":
                status = "Completed";
                break;
        }

        $('#report_category .report').text(category);
        $('#reportDropdown1').val(category);
        console.log('report type: ',reportValue)

        $('#report_status .status').text(status);
        $('#statusDropdown1').val(status);

        $('#reference_no .reference_no').text(referenceNumber);
        $('#Ref_No').val(referenceNumber);

        $('#act_date').val(date);
        $('#reference_no .reference_no').text(referenceNumber);
        $('#Activity_details').val(act_details.trim());
        $('#act_details_activity').val(act_details.trim());
        $('#Reseller').val(reseller)
        $('#venue').val(Venue)

        $('#Ref_No').val(referenceNumber);
        console.log('Reference No: ', referenceNumber)

        ////////////////// Percentage Loading /////////////////

        var ajaxRequests = [];
        var totalRequests = 9; // Total number of AJAX requests
        var completedRequests = 0;

        // Function to update the progress
        function trackProgress() {
            completedRequests++;
            var percentComplete = (completedRequests / totalRequests) * 100;
            updateProgressSpinner(percentComplete);
            if (completedRequests === totalRequests) {
                hideProgressSpinner();
                $('#exampleModal').modal('show'); // Show the modal after all requests are complete
            }
        }

           // Get Project Name and Project Type
           ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getProjName',  // update this URL as per your route
            type: 'GET',
            data: { refNo: referenceNumber },
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
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));


        // Send Get Contract Details
        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getContractDetails',  // update this URL as per your route
            type: 'GET',
            data: { refNo: referenceNumber },
            success: function (response) {
                console.log('Response from server: ', response);
                // Set the Contract Details in the modal
                $('#reseller_contact_info').val(response.reseller_contact);
                $('#reseller_phone_email').val(response.reseller_phoneEmail);
                $('#end_user_name').val(response.endUser_name);
                $('#end_user_contact').val(response.endUser_contact);
                $('#end_user_email').val(response.endUser_phoneEmail);
                $('#end_user_loc').val(response.endUser_loc);

                //Activity Details
                $('#act_details_requester').val(response.requester);
                $('#Date_Needed').val(response.date_needed);
                $('#Date_Filed').val(response.date_filed);
                $('#sendcopyto').val(response.send_copy);
                $('#special_instruction').val(response.special_instruction);

                $('#customerReqfield').val(response.cust_requirements);
                $('#activity_donefield').val(response.activity_done.replace(/<br\s*\/?>/g, '\n'));
                $('#Agreementsfield').val(response.agreements);


            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));

        /////////////////////////////// Get Product Engineer ////////////////////////  
        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getProdEngr',
            type: 'GET',
            data: { refNo: referenceNumber },
            success: function (response) {
                console.log('Response from server Product Engineer Only: ', response);


                var engineersDropdown = $('#engineers_modal');
                engineersDropdown.empty(); // Clear existing options

                if (response) {
                    // Parse JSON response
                    var engineerNames = response.split(','); // Assuming engineers are comma-separated

                    engineerNames.forEach(function (engineer) {
                        // Append each engineer as an option to the dropdown
                        engineersDropdown.append(new Option(engineer, engineer, true, true));
                    });
                }
                engineersDropdown.trigger('change'); // Update the Select2 dropdown
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));

               /////////////////////////////// Get Program ////////////////////////  

        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/GetProgramActReport',
            type: 'GET',
            data: { refNo: referenceNumber },
            success: function (response) {
                console.log('Response from server Program: ', response);

                var programdropdown = $('#program');
                programdropdown.empty(); // Clear existing options

                if (response) {
                    // Parse JSON response
                    var Program = response.split(','); // Assuming product lines are comma-separated

                    Program.forEach(function (program) {
                        // Append each product line as an option to the dropdown
                        programdropdown.append(new Option(program, program, true, true));
                    });
                }
                programdropdown.trigger('change'); // Update the Select2 dropdown
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));

         /////////////////////////////// Get Copy To Engineer ////////////////////////  
         ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getCopyToEngr',
            type: 'GET',
            data: { refNo: referenceNumber },
            success: function (response) {
                console.log('Response from server Copy To Engineer: ', response);

                var copytoengineer = $('#Copy_to');
                copytoengineer.empty(); // Clear existing options

                // Check if the response is not empty
                if (response) {
                    // Parse JSON response
                    var copy_to_engineers = response.split(','); // Assuming engineers are comma-separated

                    copy_to_engineers.forEach(function (copyToengineer) {
                        // Append each engineer as an option to the dropdown
                        copytoengineer.append(new Option(copyToengineer, copyToengineer, true, true));
                    });
                }
                copytoengineer.trigger('change'); // Update the Select2 dropdown

            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));

        /////////////////////////////// Get Product Line ////////////////////////  
        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getProdline',
            type: 'GET',
            data: { refNo: referenceNumber },
            success: function (response) {
                console.log('Response from server Product Data: ', response);
        
                var productlineDropdown = $('#product_line');
                var productcodeInput = $('#product_code');  // Input field for product codes
        
                // Clear existing options in the product line dropdown
                productlineDropdown.empty();
        
                // Clear existing value for product codes
                productcodeInput.val('');
        
                // Check if productlines are returned and are not empty
                if (response.productlines && response.productlines.trim() !== '') {
                    var productlines = response.productlines.split(','); // Split by commas
                    console.log('Product Lines: ', productlines);  // Debug
        
                    // Append each product line to the product line dropdown
                    productlines.forEach(function (productline) {
                        productlineDropdown.append(new Option(productline, productline, false, false));
                    });
        
                    // Re-initialize Select2 with proper width after appending options
                    productlineDropdown.select2({
                        width: '100%', // Ensure it takes up the available space
                        placeholder: 'Select Product Lines' // Optional: Placeholder text
                    });
        
                    // Set all product lines as selected values
                    productlineDropdown.val(productlines).trigger('change');  // Select all product lines
                }
        
                // Check if productcodes are returned and are not empty
                if (response.productcodes && response.productcodes.trim() !== '') {
                    var productcodes = response.productcodes.split(','); // Split by commas
                    console.log('Product Codes: ', productcodes);  // Debug
        
                    // Join product codes as a comma-separated string and set it as the value of the input
                    productcodeInput.val(productcodes.join(', '));
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
            },
            complete: trackProgress
        }));

        ///////////////////////////////////  Action Plan / Recommendation Modal  //////////////////////////////////////////////////////
        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getContractDetails_actionplan',  // 
            type: 'GET',
            data: { refNo: referenceNumber },
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
                // toggleInputsActionPlan(true);
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));
        
        ///////////////////////////////////  Participant/Position Modal  //////////////////////////////////////////////////////
        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getSummaryReport',
            type: 'GET',
            data: { refNo: referenceNumber },
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
                // toggleInputsParticipant(true);
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));

           //////////////////////////////////////////////////  Activity Report Get Time Expected //////////////////////////////////////////////////////
           ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getSummaryReport_time',
            type: 'GET',
            data: { refNo: referenceNumber },
            success: function (response) {
                console.log('Response from server: ', response);

                var timeExpectedDropdown = $('#time_expected1');
                timeExpectedDropdown.empty(); // Clear existing options

                // Check if response.time_expected is an array
                if (Array.isArray(response.time_expected)) {
                    response.time_expected.forEach(function (time) {
                        timeExpectedDropdown.append(new Option(time, time, true, true));
                    });
                } else {
                    timeExpectedDropdown.append(new Option(response.time_expected, response.time_expected, true, true));
                }

                timeExpectedDropdown.trigger('change'); // Update the Select2 dropdown
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));

        $(document).ready(function () {
            let removedFiles = []; // Array to store removed file names
            let originalFilesHTML = ''; // Variable to store original file HTML before edit
        
            // AJAX request to get the files
            $.ajax({
                url: '/tab-activity/index/getFile',
                type: 'GET',
                data: { refNo: referenceNumber },
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
                            $('#cancelButton').hide();
                        });
        
                        // Handle remove file button click (using event delegation)
                        $(document).on('click', '.general-file-remove-button', function () {
                            let button = $(this);
                            let fileName = button.data('filename');
        
                            // Show confirmation alert
                            Swal.fire({
                                title: 'Delete',
                                text: "Clicking this will permanently delete the image.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'No, cancel!',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    console.log('Remove button clicked');
                                    removedFiles.push(fileName); // Store the removed file name
                                    // Remove the file display container from DOM
                                    button.closest('.file-container').remove();
        
                                    // Handle the file deletion immediately
                                    var ar_id = $("#ar_id").val();
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
                                                console.log('File deleted successfully:', fileName);
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
                                    // Restore the original file display HTML
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
        
                     

        $(document).ready(function () {
            let removedFiles = []; // Array to store removed file names
            let originalFilesHTML = ''; // Variable to store original file HTML before edit
        
            $.ajax({
                url: '/tab-activity/index/getDigiknowFile',
                type: 'GET',
                data: { refNo: referenceNumber },
                success: function (response, status, xhr) {
                    console.log('Response from server: ', response);
        
                    if (response.retrieve_digiknowfiles && response.retrieve_digiknowfiles.length > 0) {
                        // Clear the container before appending new files
                        $('#digiknowfileDisplay').empty();
        
                        response.retrieve_digiknowfiles.forEach(function (file) {
                            if (file) {
                                let filePath = 'uploads/' + file; // Assuming file is the file name or path
                                let fileName = file.split('/').pop(); // Extract filename from filePath
        
                                // Determine MIME type based on filename extension
                                let mimeType = getMimeType(fileName);
        
                                // Define icon path based on MIME type
                                let iconPath = getIconPath(mimeType);
        
                                // Function to set the display for each file
                                function setFileDisplay(fileName, filePath, iconPath) {
                                    // Shorten the filename for display if needed
                                    let displayName = fileName.length > 20 ? fileName.substring(0, 17) + '...' : fileName;
        
                                    // Append each file display to the container
                                    $('#digiknowfileDisplay').append(`
                                        <div class="file-container" style="margin-left: 2%;"> 
                                            <div style="position: relative; display: inline-block;" >
                                                <img src="${iconPath}" alt="File Icon" style="width:50px;height:50px;">
                                                <button class="btn btn-danger btn-sm remove-button digiknow-file-remove-button" data-filename="${fileName}" style="position: absolute; top: -9px; right: 0; width: 20px; height: 20px; border-radius: 50%; padding: 0;"><i class="bi bi-x"></i></button>
                                            </div>
                                            <a href="${filePath}" target="_blank">${displayName}</a>
                                        </div>
                                    `);
                                }
        
                                setFileDisplay(fileName, filePath, iconPath); // Set the file display for each file
                            }
                        });
        
                        originalFilesHTML = $('#digiknowfileDisplay').html(); // Store the original HTML
                        $('.remove-button').hide(); // Initially hide remove button
        
                        // Handle edit button click to show remove buttons
                        $('#editbutton').click(function () {
                            $('.remove-button').show();
                        });
        
                        // Handle clone button click to empty the display
                        $('#cloneButton').click(function () {
                            $('#digiknowfileDisplay').empty();
                            $('#cancelButton').hide();
                        });
        
                        // Handle remove file button click (using event delegation)
                        $(document).on('click', '.digiknow-file-remove-button', function () {
                            let button = $(this);
                            let fileName = button.data('filename');
        
                            // Show confirmation alert
                            Swal.fire({
                                title: 'Delete',
                                text: "Clicking this will permanently delete the file.",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'No, cancel',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    console.log('Remove button clicked');
                                    removedFiles.push(fileName); // Store the removed file name
        
                                    // AJAX call to delete the file
                                    var ar_id = $("#ar_id").val();
                                    if (ar_id) {
                                        $.ajax({
                                            url: '/tab-activity/index/deleteImage',
                                            type: 'POST',
                                            data: {
                                                ar_id: ar_id,
                                                digiknow_files: [fileName], // Pass the single file name to delete
                                                _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                                            },
                                            success: function (response) {
                                                console.log('File deleted successfully:', fileName);
                                                // Remove the file display container from DOM
                                                button.closest('.file-container').remove();
                                                Swal.fire(
                                                    'Deleted!',
                                                    'The file has been deleted.',
                                                    'success'
                                                );
                                            },
                                            error: function (xhr, status, error) {
                                                console.error('Error deleting file:', error);
                                                Swal.fire(
                                                    'Error!',
                                                    'Failed to delete the file.',
                                                    'error'
                                                );
                                            }
                                        });
                                    } else {
                                        console.error("Error: ar_id is not available.");
                                        Swal.fire(
                                            'Error!',
                                            'Failed to delete the file.',
                                            'error'
                                        );
                                    }
                                } else if (result.dismiss === Swal.DismissReason.cancel) {
                                    $('.remove-button').show(); // Show remove buttons after cancel
                                }
                            });
                        });
        
                    } else {
                        // No files found case
                        $('#digiknowfileDisplay').html('<p>No files found.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    $('#digiknowfileDisplay').html('<p>Error fetching files.</p>');
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

         /////////////////////////Get Others/////////////////////////////////////////////////
         ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getOthers',
            type: 'GET',
            data: { refNo: referenceNumber },
               success: function (response) {
                console.log('Response from server: ', response);
                // Set the Others in the modal
                // Digiknow
                if (response.digiknow_flyers) {
                    let digiknow_file_path = 'uploads/' + response.digiknow_flyers; // Adjust the path as needed
                    console.log(digiknow_file_path);
                    $('#modal_digiknowFlyersattachment').html(`
                                <a href="${digiknow_file_path}" target="_blank">${response.digiknow_flyers}</a>
                            `);
                } else {
                    $('#modal_digiknowFlyersattachment').html('<p>No file found.</p>');
                }
                if (response.receipentBP === '1') {
                    $('#modal_bpDigiCheckbox').prop('checked', true);
                } else {
                    $('#modal_bpDigiCheckbox').prop('checked', false);
                }
                if (response.recipientEU === '1') {
                    $('#modal_euDigiCheckbox').prop('checked', true);
                } else{
                    $('#modal_euDigiCheckbox').prop('checked', false);
                }

                // Internal
                $('#modal_MSIProjName').val(response.msi_proj);
                $('#modal_CompliancePercentage').val(response.percentage);

                // Attendance
                $('#modalperfectAttendance').val(response.perfect_att);

                // Memo
                $('#modal_memoIssued').val(response.memo_issued);
                $('#modal_memoDetails').val(response.memo_details);

                // Feedback
                $('#modal_engrFeedbackInput').val(response.engr_feedback);
                $('#modal_other_rating').val(response.engr_rating);

                //Train To Retain including PKOC /MSCLC , sTracert
                $('#modal_topicName').val(response.topic);
                $('#modal_dateStart').val(response.dateStart);
                $('#modal_dateEnd').val(response.dateEnd);

                // Stracert
                $('#stra_topicName').val(response.topic);
                $('#stra_dateStart').val(response.dateStart);
                $('#stra_dateEnd').val(response.dateEnd);

                ///POC
                $('#modal_prodModel').val(response.product_model);
                $('#modal_assetCode').val(response.asset_code);
                $('#modal_poc_dateStart').val(response.poc_dateStart);
                $('#modal_poc_dateEnd').val(response.poc_dateEnd);
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));


        
        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/get_skills_dev',
            type: 'GET',
            data: { refNo: referenceNumber },
               success: function (response) {
                console.log('Response from server1: ', response); 

                // Tech or Prod Skills
                $('#modal_techprodLearned').val(response.prod_learned);

                // Training Name
                $('#modal_trainingName').val(response.training_name);
                $('#modal_location').val(response.training_location);
                $('#modal_speaker').val(response.training_speaker);
                if (response.bp_attendees === '1') {
                    $('#bpCheckbox').prop('checked', true);
                } else {
                    $('#bpCheckbox').prop('checked', false);
                }
                if (response.eu_attendees === '1') {
                    $('#euCheckbox').prop('checked', true);
                } else{
                    $('#euCheckbox').prop('checked', false);
                }
                if (response.msi_attendees === '1') {
                    $('#MSICheckbox').prop('checked', true);
                } else{
                    $('#MSICheckbox').prop('checked', false);
                }

                // Exam Status
                $('#modal_title').val(response.exam_title);
                $('#modal_examCode').val(response.exam_name);
                $('#modal_takeStatusDropdown').val(response.take_status);
                $('#modal_scoreDropdown').val(response.exam_score);
                $('#modal_examTypeDropdown').val(response.exam_type);
                $('#modal_incentiveStatusDropdown').val(response.exam_incStatus);
                $('#modal_incentiveDetailsDropdown').val(response.exam_incdetails);
                $('#modal_amount').val(response.exam_incAmount);

            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            },
            complete: trackProgress
        }));
    });
});

