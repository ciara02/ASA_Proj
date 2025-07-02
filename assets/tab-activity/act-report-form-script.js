$(document).ready(function () {
    // Function to disable dateFrom if StartDate is empty
    function disableDateTo() {
        var startDate = $("#Date_Filed").val();
        if (startDate === "") {
            $("#Date_Needed").prop("disabled", true);
            $("#Date_Needed").val("");
        } else {
            $("#Date_Needed").prop("disabled", false);
        }
    }
    // Call the function initially
    disableDateTo();

    // Event listener for changes in StartDate
    $("#Date_Filed").change(function () {
        disableDateTo();
    });

    // Event listener for changes in EndDate
    $("#Date_Needed").change(function () {
        // Date Restriction
        var dateFrom = new Date($("#Date_Filed").val());
        var dateTo = new Date($("#Date_Needed").val());

        // Check if dateFrom is greater than dateTo
        if (dateFrom > dateTo) {
            Swal.fire({ title: "Date error!", text: "Date needed cannot be less than date filed", icon: "error" });
            $("#Date_Needed").val("");
        }
    });
});

$(document).ready(function () {
    // Function to disable dateFrom if StartDate is empty
    function disableDateTo() {
        var stra_dateStart = $("#stra_dateStart").val();
        if (stra_dateStart === "") {
            $("#stra_dateEnd").prop("disabled", true);
            $("#stra_dateEnd").val("");
        } else {
            $("#stra_dateEnd").prop("disabled", false);
        }
    }
    // Call the function initially
    disableDateTo();

    // Event listener for changes in StartDate
    $("#stra_dateStart").change(function () {
        disableDateTo();
    });

    // Event listener for changes in EndDate
    $("#stra_dateEnd").change(function () {
        // Date Restriction
        var stra_dateStart = new Date($("#stra_dateStart").val());
        var stra_dateEnd = new Date($("#stra_dateEnd").val());

        // Check if dateFrom is greater than dateTo
        if (stra_dateStart > stra_dateEnd) {
            Swal.fire({ title: "End Date error!", text: "End date cannot be less than start date", icon: "error" });
            $("#stra_dateEnd").val("");
        }
    });
});

$(document).ready(function () {
    // Function to disable dateFrom if StartDate is empty
    function disableDateTo() {
        var modal_poc_dateStart = $("#modal_poc_dateStart").val();
        if (modal_poc_dateStart === "") {
            $("#modal_poc_dateEnd").prop("disabled", true);
            $("#modal_poc_dateEnd").val("");
        } else {
            $("#modal_poc_dateEnd").prop("disabled", false);
        }
    }
    // Call the function initially
    disableDateTo();

    // Event listener for changes in StartDate
    $("#modal_poc_dateStart").change(function () {
        disableDateTo();
    });

    // Event listener for changes in EndDate
    $("#modal_poc_dateEnd").change(function () {
        // Date Restriction
        var modal_poc_dateStart = new Date($("#modal_poc_dateStart").val());
        var modal_poc_dateEnd = new Date($("#modal_poc_dateEnd").val());

        // Check if dateFrom is greater than dateTo
        if (modal_poc_dateStart > modal_poc_dateEnd) {
            Swal.fire({ title: "End Date error!", text: "End date cannot be less than start date", icon: "error" });
            $("#modal_poc_dateEnd").val("");
        }
    });
});

$(document).ready(function () {
    // Function to disable dateFrom if StartDate is empty
    function disableDateTo() {
        var modal_dateStart = $("#modal_dateStart").val();
        if (modal_dateStart === "") {
            $("#modal_dateEnd").prop("disabled", true);
            $("#modal_dateEnd").val("");
        } else {
            $("#modal_dateEnd").prop("disabled", false);
        }
    }
    // Call the function initially
    disableDateTo();

    // Event listener for changes in StartDate
    $("#modal_dateStart").change(function () {
        disableDateTo();
    });

    // Event listener for changes in EndDate
    $("#modal_dateEnd").change(function () {
        // Date Restriction
        var modal_dateStart = new Date($("#modal_dateStart").val());
        var modal_dateEnd = new Date($("#modal_dateEnd").val());

        // Check if dateFrom is greater than dateTo
        if (modal_dateStart > modal_dateEnd) {
            Swal.fire({ title: "End Date error!", text: "End date cannot be less than start date", icon: "error" });
            $("#modal_dateEnd").val("");
        }
    });
});

$(document).ready(function () {

    function toggleInputsParticipant(disabled) {
        $('#participantAndPositionContainer input, #participantAndPositionContainer textarea, #participantAndPositionContainer select,  #participantAndPositionContainer button').prop('disabled', disabled);
    }

    function toggleInputsActionPlan(disabled) {
        $('#ActionPlan_Recommendation input, #ActionPlan_Recommendation textarea, #ActionPlan_Recommendation select , #ActionPlan_Recommendation button').prop('disabled', disabled);
    }
    ///////////////////////// Auto-Populate Engineeer Dropdown //////////////////////////////
    function setEngineerName(clickedRow = null) {
        var EngrNameValue;
        if (clickedRow) {
            // If a row is clicked in the DataTable
            EngrNameValue = $(clickedRow).find('td').eq(2).text();
        } else {
            // Default to modal's context if no row is clicked
            EngrNameValue = $('#exampleModal').find('td').eq(2).text();
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
    ///////////////////////// Auto-Populate Time Reported Dropdown //////////////////////////////
    function setTimeReported(clickedRow = null) {

        var time_reportedvalue;
        if (clickedRow) {
            // If a row is clicked in the DataTable
            time_reportedvalue = $(clickedRow).find('td').eq(3).text();
        } else {
            // Default to modal's context if no row is clicked
            time_reportedvalue = $('#exampleModal').find('td').eq(3).text();
        }

        if (time_reportedvalue) {
            var reportedtime = time_reportedvalue.split(',');
            var time_reported_dropdown = $('#time_reported1');
            time_reported_dropdown.empty(); // Clear existing options
            reportedtime.forEach(function (value) {
                time_reported_dropdown.append(new Option(value.trim(), value.trim(), true, true));
            });
            time_reported_dropdown.trigger('change'); // Update the Select2 dropdown
        }

    }
    ///////////////////////// Auto-Populate Time Exited Dropdown //////////////////////////////
    function setTimeExited(clickedRow = null) {

        var time_exited;
        if (clickedRow) {
            // If a row is clicked in the DataTable
            time_exited = $(clickedRow).find('td').eq(4).text();
        } else {
            // Default to modal's context if no row is clicked
            time_exited = $('#exampleModal').find('td').eq(4).text();
        }

        if (time_exited) {
            var exitedtime = time_exited.split(',');
            var time_exited_dropdown = $('#time_exited1');
            time_exited_dropdown.empty(); // Clear existing options
            exitedtime.forEach(function (value) {
                time_exited_dropdown.append(new Option(value.trim(), value.trim(), true, true));
            });
            time_exited_dropdown.trigger('change'); // Update the Select2 dropdown
        }

    }

    ///////////////////////// Activity Type //////////////////////////////
    function setActivityType(clickedRow = null) {

        var act_type;
        if (clickedRow) {
            // If a row is clicked in the DataTable
            act_type = $(clickedRow).find('td').eq(6).text();
        } else {
            // Default to modal's context if no row is clicked
            act_type = $('#exampleModal').find('td').eq(6).text();
        }

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

    // Initialize the DataTable
    $('#datatable1').DataTable();

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


    // Row click event
    $('#datatable1 tbody').on('click', 'tr', function () {
        showProgressSpinner();
        var category = $(this).find('td').eq(5).text();
        var status = $(this).find('td').eq(11).text();
        var referenceNumber = $(this).find('td').eq(1).text();

        var date = $(this).find('td').eq(0).text();
        var act_details = $(this).find('td').eq(8).text();
        var reseller = $(this).find('td').eq(9).text();
        var Venue = $(this).find('td').eq(10).text();
        var productCode = $(this).find('td').eq(13).text();


        $('#report_category .report').text(category);
        $('#reportDropdown1').val(category);

        $('#report_status .status').text(status);
        $('#statusDropdown1').val(status);

        $('#act_date').val(date);
        $('#reference_no .reference_no').text(referenceNumber);
        $('#Activity_details').val(act_details)
        $('#act_details_activity').val(act_details)
        $('#Reseller').val(reseller)
        $('#venue').val(Venue)
        $('#prod_code').val(productCode);
        $('#Ref_No').val(referenceNumber);
        ///////////////////////// Auto-Populate Callout Dropdown Functions //////////////////////////////

        setEngineerName(this);
        setTimeReported(this);
        setTimeExited(this);
        setActivityType(this);

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
        //////////////////////////////////// Get Project Name and Type ////////////////////////
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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
                $('#ar_id').val(response.ar_id);


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

        //////////////////////// Get Program /////////////////////////////////////////
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
                toggleInputsActionPlan(true);
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
                toggleInputsParticipant(true);
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



        // // $('#exampleModal').modal('show');
        //    $.when.apply($, ajaxRequests).done(function() {
        //     $("#loading-overlay").hide();
        //     $('#exampleModal').modal('show');


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
                } else {
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
                } else {
                    $('#euCheckbox').prop('checked', false);
                }
                if (response.msi_attendees === '1') {
                    $('#MSICheckbox').prop('checked', true);
                } else {
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



////////////////////////// Clone Participants and Position //////////////////////////////////

$(document).ready(function () {
    // Function to add a new set of fields
    $(document).on("click", ".add-position", function () {
        var clonedHTML = $(this).closest(".row").clone(); // Clone the HTML structure
        clonedHTML.find(".participant").val(""); // Clear participant input value
        clonedHTML.find(".position").val(""); // Clear position input value
        // clonedHTML.find(".add-position").remove(); // Remove the "Add" button from the cloned row
        clonedHTML.find(".delete-position").show(); // Show the "Delete" button in the cloned row
        $("#participantAndPositionContainer").append(clonedHTML); // Append the cloned HTML to the container
    });

    // Function to delete a set of fields with confirmation
    $(document).on("click", ".delete-position", function (e) {
        e.preventDefault(); // Prevent the default action

        var $this = $(this); // Store the reference to the clicked element
        var row = $this.closest(".row");

        Swal.fire({
            title: 'Delete',
            text: "Are you sure you want to remove this participant?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                if ($("#participantAndPositionContainer .row").length > 1) {
                    row.remove();
                    Swal.fire(
                        'Deleted!',
                        'The field has been removed.',
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        'You cannot delete the only remaining participant.',
                        'error'
                    );
                }
            }
        });
    });
});


////////////////////////// Clone Action Plan / Recommendation //////////////////////////////////

$(document).ready(function () {
    // Function to add a new set of fields
    $(document).on("click", ".add-actionplan", function () {
        var clonedHTML = $(this).closest(".row").clone(); // Clone the HTML structure

        // Clear input values in the cloned row
        clonedHTML.find(".PlanTarget").val("");
        clonedHTML.find(".Details").val("");
        clonedHTML.find(".PlanOwner").val("");

        // Append the cloned HTML to the container
        $("#ActionPlan_Recommendation").append(clonedHTML);

        // Update the delete button visibility
        updateDeleteButtonVisibility();
    });

    // Function to delete a set of fields with confirmation
    $(document).on("click", ".delete-actionplan", function (e) {
        e.preventDefault(); // Prevent the default action

        var $this = $(this); // Store the reference to the clicked element
        var row = $this.closest(".row");

        Swal.fire({
            title: 'Delete',
            text: "Are you sure you want to delete this field?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                if (row.index() === 0) {
                    // Clear input values instead of deleting the row if it's the first row
                    row.find(".PlanTarget").val(""); // Clear Plan Target input value
                    row.find(".Details").val(""); // Clear Details input value
                    row.find(".PlanOwner").val(""); // Clear Plan Owner input value
                } else {
                    // Delete the row if it's not the first row
                    row.remove();
                }

                // Update the delete button visibility after deletion
                updateDeleteButtonVisibility();

                Swal.fire(
                    'Deleted!',
                    'The field has been removed.',
                    'success'
                );
            }
        });
    });

    // Function to update delete button visibility
    function updateDeleteButtonVisibility() {
        $(".delete-actionplan").each(function (index) {
            if (index === 0) {
                // Hide the delete button for the first row
                $(this).hide();
            } else {
                // Show the delete button for other rows
                $(this).show();
            }
        });
    }

    // Initialize delete button visibility
    updateDeleteButtonVisibility();
});




////////////////////////// Show/Hide Forms //////////////////////////////////

document.addEventListener('DOMContentLoaded', function () {
    // Define a function to check conditions and toggle visibility of cards
    function checkConditionsAndToggleVisibility() {

        const category = document.querySelector('#reportDropdown1').value;
        const status = document.querySelector('#statusDropdown1').value;
        const attachmentSection = document.getElementById('Attachment');
        // Hide all cards first
        document.querySelectorAll('.modal-body .card').forEach(card => card.style.display = 'none');
        attachmentSection.style.display = 'none';

        $('#time_expected1').prop('disabled', false);
        $('#time_reported1').prop('disabled', false);
        $('#time_exited1').prop('disabled', false);

        // Show the required cards if conditions are met
        ///////////////////////////// Support Request //////////////////////////
        if (category === 'Support Request' && status === 'Pending') {
            document.getElementById('activity_details').style.display = '';
            document.getElementById('Contract_Details').style.display = '';
        }
        if (category === 'Support Request' && (status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
            document.getElementById('activity_details').style.display = '';
            document.getElementById('Contract_Details').style.display = '';
            document.getElementById('Act_summary_report').style.display = '';
            document.getElementById('Participant_Position').style.display = '';
            document.getElementById('customer_requirements').style.display = '';
            document.getElementById('Activity_Done').style.display = '';
            document.getElementById('Agreements').style.display = '';
            document.getElementById('action_plan_recommendation').style.display = '';
            attachmentSection.style.display = '';
        }

        ///////////////////////////// iSupport Services || Client Calls || Partner Enablement/Recruitment || Supporting Activity //////////////////////////

        if ((category === 'iSupport Services' || category === 'Client Calls' || category === 'Partner Enablement/Recruitment' || category === 'Supporting Activity') && status === 'Pending') {
            document.getElementById('quick_addActivity1').style.display = '';
            document.getElementById('Contract_Details').style.display = '';
            document.getElementById('Act_summary_report').style.display = '';

        }
        if ((category === 'iSupport Services' || category === 'Client Calls' || category === 'Partner Enablement/Recruitment' || category === 'Supporting Activity') && (status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
            document.getElementById('quick_addActivity1').style.display = '';
            document.getElementById('Contract_Details').style.display = '';
            document.getElementById('Act_summary_report').style.display = '';
            document.getElementById('Participant_Position').style.display = '';
            document.getElementById('customer_requirements').style.display = '';
            document.getElementById('Activity_Done').style.display = '';
            document.getElementById('Agreements').style.display = '';
            document.getElementById('action_plan_recommendation').style.display = '';
            attachmentSection.style.display = '';
        }

        ///////////////////////////// Internal Enablement //////////////////////////

        if (category === 'Internal Enablement' && status === 'Pending') {
            document.getElementById('quick_addActivity1').style.display = '';
            document.getElementById('Act_summary_report').style.display = '';
        }

        if (category === 'Internal Enablement' && (status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
            document.getElementById('quick_addActivity1').style.display = '';
            document.getElementById('Act_summary_report').style.display = '';
            document.getElementById('Participant_Position').style.display = '';
            document.getElementById('customer_requirements').style.display = '';
            document.getElementById('Activity_Done').style.display = '';
            document.getElementById('Agreements').style.display = '';
            document.getElementById('action_plan_recommendation').style.display = '';
            attachmentSection.style.display = '';

        }

        ///////////////////////////// Skills Development //////////////////////////
        if ((category === 'Skills Development' || category === 'Others') && (status === 'Pending' || status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
            document.getElementById('quick_addActivity1').style.display = '';
            document.getElementById('Act_summary_report').style.display = '';
            attachmentSection.style.display = '';
            $('#editbutton, #cloneButton').click(function () {
                //Enable the report name and report status dropdown
                //   $('#time_expected1').prop('disabled', true);
                //   $('#time_reported1').prop('disabled', true);
                //   $('#time_exited1').prop('disabled', true);
                $('#time_Expected_modal').hide();
                $('#time_Reported_modal').hide();
                $('#time_Exited_modal').hide();
            });
            $('#time_Expected_modal').hide();
            $('#time_Reported_modal').hide();
            $('#time_Exited_modal').hide();
        }
        else {
            $('#editbutton, #cloneButton').click(function () {
                //Enable the report name and report status dropdown
                //   $('#time_expected1').prop('disabled', false);
                //   $('#time_reported1').prop('disabled', false);
                //   $('#time_exited1').prop('disabled', false);
                $('#time_Expected_modal').show();
                $('#time_Reported_modal').show();
                $('#time_Exited_modal').show();
            });
            $('#time_Expected_modal').show();
            $('#time_Reported_modal').show();
            $('#time_Exited_modal').show();
        }
        if ((category === 'Skills Development') && (status === 'Pending' || status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
            document.getElementById('quick_addActivity1').style.display = '';
            document.getElementById('Act_summary_report').style.display = '';
            attachmentSection.style.display = '';
            $('#editbutton, #cloneButton').click(function () {
                $('#modal_venueHidden').hide();
            });
            $('#modal_venueHidden').hide();
        } else {
            $('#editbutton, #cloneButton').click(function () {
                $('#modal_venueHidden').show();
            });
            $('#modal_venueHidden').show();
        }
    }
    // Function to handle change event on dropdowns
    function handleDropdownChange() {
        checkConditionsAndToggleVisibility();
    }

    // Attach a handler to the modal's show event to check the conditions
    $('#exampleModal').on('show.bs.modal', function () {
        checkConditionsAndToggleVisibility();
    });
    // Add event listeners for dropdown change events
    document.querySelector('#reportDropdown1').addEventListener('change', handleDropdownChange);
    document.querySelector('#statusDropdown1').addEventListener('change', handleDropdownChange);
});

// ////////////////// Dynamic Activity Type Dropdown /////////////////////////

$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        const category = $('#report_category .report').text().replace(/\//g, '_');
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
        // Add the onchange event listener
        // $('#Activity_Type').on('change', function () {
        //     var selectedValue = $(this).val();
        //     console.log('Report:', category);
        //     console.log('Activity Type:', selectedValue);
        // });
    });
});


////////// Dynamic Productline Dropdown /////////////////////////

$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {


        $('#product_line').select2({
            width: '100%',
            dropdownParent: $('#exampleModal .modal-content'),
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
        // Event listener for changes in the selected product lines
        $('#product_line').on('select2:select', function (e) {
            updateProductCode();
            updateProductLine();
        });

        $('#product_line').on('select2:unselect', function (e) {
            updateProductCode(); // Update product code when a product line is removed
        });

        $('#product_line').on('change', function () {
            updateProductLine();
        });
    });

    // Automatic productCode application
    function updateProductCode() {
        var selectedProductLines = $('#product_line').select2('data');
        var productCodes = selectedProductLines.map(function (productLine) {
            return productLine.text;
        }).join(', ');

        $('#prod_code').val(productCodes);
    }

    // For passing data of productline and productCode
    function updateProductLine() {
        var selectedProductLines = $('#product_line').select2('data');
        var productLineDescriptions = selectedProductLines.map(function (productLine) {
            return productLine.text;
        }).join(', ');
        $('#product_line_input').val(productLineDescriptions);
    }
});

///////////////////////////////////////////////////////// Dynamic Activity Type / Program  Dropdown and Show Hide Form ///////////////////////////

$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        // Function to handle form display based on selected values
        function handleFormDisplay(category, selectedValue, source) {
            // Hide all form elements initially
            const attachmentSection = document.getElementById('Attachment');


            if (source === 'activity_type') {
                $('#othersDigiKnow, #otherInternalProject, #otherAttendance, #otherMemo, #otherFeedback, #otherTrainToRetain, #skillsTech, #TechAndSkillsDevt, #POC').hide();
                if (category === 'Client Calls' && selectedValue === 'POC (Proof of Concept)') {
                    document.getElementById('POC').style.display = '';
                    attachmentSection.style.display = '';
                }

                if (category === 'Skills Development' && (selectedValue === 'Technical Certification' || selectedValue === 'Sales Certification')) {
                    document.getElementById('skillsTech').style.display = '';
                    attachmentSection.style.display = '';
                }

                if (category === 'Skills Development' && selectedValue === 'Technology or Product Skills Devt') {
                    document.getElementById('TechAndSkillsDevt').style.display = '';
                    attachmentSection.style.display = '';
                }

                if (category === 'Skills Development' && (selectedValue === 'Vendor Training' || selectedValue === 'Bootcamp Attended' || selectedValue === 'TCT (Technology Cross Training)-Attended')) {
                    document.getElementById('SkillsDevOthers').style.display = '';
                    attachmentSection.style.display = '';
                }

                if (category === 'Others' && selectedValue === 'DIGIKnow') {
                    document.getElementById('othersDigiKnow').style.display = '';
                    attachmentSection.style.display = 'none';

                }
                if (category === 'Others' && selectedValue === 'Internal Project') {
                    document.getElementById('otherInternalProject').style.display = '';
                    attachmentSection.style.display = '';
                }
                if (category === 'Others' && selectedValue === 'Perfect Attendance under Merit') {
                    document.getElementById('otherAttendance').style.display = '';
                    attachmentSection.style.display = '';
                }
                if (category === 'Others' && selectedValue === 'Memo from HR under Demerit') {
                    document.getElementById('otherMemo').style.display = '';
                    attachmentSection.style.display = '';
                }
                if (category === 'Others' && selectedValue === 'Feedback On Engineer') {
                    document.getElementById('otherFeedback').style.display = '';
                    attachmentSection.style.display = '';
                }
                if (category === 'Others' && selectedValue === 'Train To Retain (T2R)') {
                    document.getElementById('otherTrainToRetain').style.display = '';
                    attachmentSection.style.display = '';
                }
            }

            if (source === 'program') {
                if (category === 'Partner Enablement_Recruitment' && selectedValue === 'sTraCert') {
                    document.getElementById('sTracert').style.display = '';
                } else if (category === 'Internal Enablement' && selectedValue === 'PKOC / MSLC') {
                    document.getElementById('sTracert').style.display = '';
                } else {
                    $('#sTracert').hide();
                }
            }
        }

        // Add the onchange event listener for #Activity_Type
        $('#Activity_Type').on('change', function () {
            var category = document.querySelector('#reportDropdown1').value.replace(/\//g, '_');
            var selectedValue = $(this).val();
            handleFormDisplay(category, selectedValue, 'activity_type');
        });

        // Add the onchange event listener for #program
        $('#program').on('change', function () {
            var category = document.querySelector('#reportDropdown1').value.replace(/\//g, '_');
            var selectedValue = $(this).val();
            handleFormDisplay(category, selectedValue, 'program');
        });

        // Set up event listener for reportDropdown1 change
        $('#reportDropdown1').on('change', function () {
            const category = document.querySelector('#reportDropdown1').value.replace(/\//g, '_');

            // Clear the #Activity_Type and #program dropdowns
            $('#Activity_Type').val(null).empty();
            $('#program').val(null).empty();

            // Initialize select2 for #Activity_Type
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

            // Initialize select2 for #program
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
        });

        var existingCategory = $('#reportDropdown1').val().replace(/\//g, '_');
        var existingActivityType = $('#Activity_Type').val();
        var existingProgram = $('#program').val();

        if (existingCategory) {
            var hasHandled = false;

            if (existingActivityType) {
                var matchActivityTypeCondition = false;
                // Check if Activity_Type matches the condition
                if (existingCategory === 'Client Calls' && existingActivityType === 'POC (Proof of Concept)') {
                    matchActivityTypeCondition = true;
                }
                if (existingCategory === 'Skills Development' &&
                    (existingActivityType === 'Technical Certification' ||
                        existingActivityType === 'Sales Certification' ||
                        existingActivityType === 'Technology or Product Skills Devt' ||
                        existingActivityType === 'Vendor Training' ||
                        existingActivityType === 'Bootcamp Attended' ||
                        existingActivityType === 'TCT (Technology Cross Training)-Attended')) {
                    matchActivityTypeCondition = true;
                }
                if (existingCategory === 'Others' &&
                    (existingActivityType === 'DIGIKnow' ||
                        existingActivityType === 'Internal Project' ||
                        existingActivityType === 'Perfect Attendance under Merit' ||
                        existingActivityType === 'Memo from HR under Demerit' ||
                        existingActivityType === 'Feedback On Engineer' ||
                        existingActivityType === 'Train To Retain (T2R)')) {
                    matchActivityTypeCondition = true;
                }

                if (matchActivityTypeCondition) {
                    handleFormDisplay(existingCategory, existingActivityType, 'activity_type');
                    hasHandled = true;
                }
            }

            if (!hasHandled && existingProgram) {
                var matchProgramCondition = false;
                // Check if Program matches the condition
                if (existingCategory === 'Partner Enablement_Recruitment' && existingProgram === 'sTraCert') {
                    matchProgramCondition = true;
                }
                if (existingCategory === 'Internal Enablement' && existingProgram === 'PKOC / MSLC') {
                    matchProgramCondition = true;
                }

                if (matchProgramCondition) {
                    handleFormDisplay(existingCategory, existingProgram, 'program');
                    hasHandled = true;
                }
            }
        }
    });
});

//////////////////// Dynamic Program Dropdown /////////////////////////
$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        const category = document.querySelector('#reportDropdown1').value.replace(/\//g, '_');

        // console.log(category);
        // Ensure category is not empty
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

    });
});

