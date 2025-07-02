$(document).ready(function () {
    var table = $('#certificationTable').DataTable({
        responsive: true, // Enable responsive design
        autoWidth: true,
        pageLength: 16,
        dom: 'Bfrtip',
        buttons: [
            // {
            //     extend: 'print',
            //     text: '<i class="bi bi-printer"></i> Print',
            //     className: 'buttons-print btn btn-success',
            //     title: function () {
            //         var currentDate = new Date();
            //         var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
            //         return 'ASA Certification Report - ' + formattedDate;
            //     },
            //     customize: function (win) {
            //         // Add styles to the print view
            //         $(win.document.head).append('<style>head.dt-print-view h1 { text-align: center; padding: 2px; }</style>');
            //         // $(win.document.head).append('<style>table.dataTable th, table.dataTable td { word-wrap: break-word; }</style>');

            //         // Remove DataTables default heading
            //         $(win.document.head).append('<style>.dt-print-view h1 { display: none; }</style>');

            //         for (let i = 1; i <= 13; i++) {
            //             let width = 100 / 13; // Divide the width equally
            //             $(win.document.body).append(`<style>table.dataTable th:nth-child(${i}), table.dataTable td:nth-child(${i}) { width: ${width}%; }</style>`);
            //         }

            //         // Use an absolute path for the logo
            //         var imgSrc = "/assets/img/official-logo.png"; // Ensure the path is absolute
            //         console.log('Image path:', imgSrc);  // Debugging: Log the image path to console

            //          // Image styling for fade effect and centering vertically and horizontally
            //          var imgStyle = 'position:fixed; top:50%; left:50%; transform: translate(-50%, -50%); max-width: 50%; max-height: 50%; opacity:0.2;';

            //          // Prepend the image as a background to the body
            //          $(win.document.body).prepend('<img src="' + imgSrc + '" style="' + imgStyle + '" />');

            //         // Create an image element and set its source
            //         var img = new Image();
            //         img.src = imgSrc;
            //         img.style = imgStyle;

            //         // Add load event listener to ensure the image is fully loaded
            //         img.onload = function() {
            //             console.log('Image loaded successfully');
            //             $(win.document.body).prepend(img.outerHTML);
            //         };

            //         img.onerror = function() {
            //             console.error('Failed to load image:', imgSrc);
            //         };

            //         // Get the total row count
            //         var rowCount = $('#certificationTable').DataTable().rows().count();

            //         // Append total row count to every page
            //         $(win.document.body).prepend('<div id="row-count" style="position: absolute; top: 10px; right: 10px; font-size: 12px;">Total rows: ' + rowCount + '</div>');

            //         var printTitle = '<div style="font-size: 20px; text-align: center;">CERTIFICATIONS REPORT</div>';
            //         $(win.document.body).prepend(printTitle);

            //         // Apply styles to the table
            //         $(win.document.body)
            //             .css('font-size', '9pt')
            //             .find('table')
            //             .addClass('compact')
            //             .css({'font-size': 'inherit', 'z-index': '1'}); // Adjusting z-index of the table

            //         // Apply word-wrap to each column
            //         $(win.document.body)
            //             .find('table')
            //             .find('th, td')
            //             .css({
            //                 'word-wrap': 'break-word',
            //                 'white-space': 'normal'
            //             });
            //     }
            // },
            {
                extend: 'excel',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'buttons-excel btn btn-success',
                filename: function () {
                    var currentDate = new Date();
                    var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                    return 'ASA Activity Completion Report - ' + formattedDate;
                }
            }
        ],
        responsive: true,
        deferRender: true,
        scrollX: true,
        scrollCollapse: true,
        fixedColumns: true,
        colReorder: true // Enable ColReorder extension

        
    });
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

    var originalColumnOrder = table.colReorder.order();

    $('#perCertDropdown').on('change', function () {
        var filterValue = $(this).val();
        console.log("Dropdown value selected:", filterValue);

        // Define column orders for each filter value
        var columnOrder;
        if (filterValue === "inc_Status") {
            // Restore the original column order
            table.colReorder.order(originalColumnOrder);
            columnOrder = originalColumnOrder;
        } else if (filterValue === "per_Engr") {
            columnOrder = [3, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 0, 13]; // Define the order of columns for 'per_Engr'
        } else if (filterValue === "per_Product") {
            columnOrder = [8, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12, 0, 13]; // Define the order of columns for 'per_Product'
        }

        // Reorder table columns based on the selected filter value
        table.colReorder.reset();
        table.colReorder.order(columnOrder);

        var href = "/tab-certifications/print/";
        if (columnOrder) {
            href += columnOrder.join(',');
        }
        $('.btn-print').attr('href', href);
    });

    // Initialize the href attribute on page load with the original column order
    var initialHref = "/tab-certifications/print/";
    if (originalColumnOrder) {
        initialHref += originalColumnOrder.join(',');
    }
    $('.btn-print').attr('href', initialHref);


    //Highlight clicked row
    $('#certificationTable td').on('click', function () {

        // Remove previous highlight class
        $(this).closest('table').find('tr.highlight').removeClass('highlight');

        // add highlight to the parent tr of the clicked td
        $(this).parent('tr').addClass("highlight");
    });

    //clickable row
    // Handle click event on table row
    $(document).on('click', '.clickable-row', function () {
        // showProgressSpinner();
        var row = $(this).closest('tr');
        var releaseStatusClass = ".release-status";
        var incentiveStatusClass = ".incentive-status";
        var dateClass = ".date";
        var engineerClass = ".engr";
        var typeClass = ".type";
        var examTypeClass = ".exam_type";
        var incentiveDetailsClass = ".incentive-details";
        var amountClass = ".amt";
        var productLineClass = ".prod_Line";
        var titleClass = ".inc_title";
        var examCodeClass = ".exam_code";
        var scoreClass = ".score";
        var ar_idClass = ".ar_id";
        var ar_id = row.find(ar_idClass).text().trim();
        console.log("Ar_id:", ar_id);

        var data = $(this).data('refno').split('|');
        console.log('Data extracted:', data); // Verify the data extracted

        var refNo = data[0];
        var productCodes = data[1].split(', '); // Split multiple product codes by comma and space

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
                    $('#reference_no .reference_no').text(refNo);
                    $('#Ref_No').val(refNo);
                }
            });
        });
        
        var programName = data[2].trim();
        var programDropdown = $('#program');
        // Remove existing options (if any)
        programDropdown.empty();
        // Add the new engineer option
        programDropdown.append(new Option(programName, programName, true, true));
        // Trigger change event to update Select2 dropdown
        programDropdown.trigger('change');

        var reportName = data[3].trim();
        var status_report = data[4].trim();
        var ar_activityName = data[5].trim();
        var ar_activityDate = data[6].trim();
        var ar_venue = data[7].trim();
        var ar_sendcopyTo = data[8].trim();

        var ajaxRequests = [];
        var totalRequests = 9; // Total number of AJAX requests
        var completedRequests = 0;

        // // Function to update the progress
        // function trackProgress() {
        //     completedRequests++;
        //     var percentComplete = (completedRequests / totalRequests) * 100;
        //     updateProgressSpinner(percentComplete);
        //     if (completedRequests === totalRequests) {
        //         hideProgressSpinner();
        //         $('#exampleModal').modal('show'); // Show the modal after all requests are complete
        //     }
        // }
        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getProdline',
            type: 'GET',
            data: { refNo: refNo },
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
            // complete: trackProgress
        }));
        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getContractDetails_actionplan',  // 
            type: 'GET',
            data: { refNo: refNo },
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
            // complete: trackProgress
        }));

        /////////////////////////////// Participants and Position ////////////////////////  
        ajaxRequests.push($.ajax({
            url: '/tab-activity/index/getSummaryReport',
            type: 'GET',
            data: { refNo: refNo },
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
            // complete: trackProgress
        }));

        $(document).ready(function () {
            let removedFiles = []; // Array to store removed file names
            let originalFilesHTML = ''; // Variable to store original file HTML before edit

            // AJAX request to get the files
            $.ajax({
                url: '/tab-activity/index/getFile',
                type: 'GET',
                data: { refNo: refNo },
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
                            var ar_id = row.find(ar_idClass).text().trim();
                            console.log("Ar_id:", ar_id);

                            // Show confirmation alert
                            Swal.fire({
                                title: 'Are you sure?',
                                text: `Clicking this will permanently delete the image "${fileName}".`,
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



        $(document).ready(function () {
            let removedFiles = []; // Array to store removed file names
            let originalFilesHTML = ''; // Variable to store original file HTML before edit

            $.ajax({
                url: '/tab-activity/index/getDigiknowFile',
                type: 'GET',
                data: { refNo: refNo },
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
                            var ar_id = row.find(ar_idClass).text().trim();

                            // Show confirmation alert
                            Swal.fire({
                                title: 'Are you sure?',
                                text: `Clicking this will permanently delete the file "${fileName}".`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'No, keep it',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    console.log('Remove button clicked');
                                    removedFiles.push(fileName); // Store the removed file name

                                    // AJAX call to delete the file
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
                                                console.log('File deleted successfully:', fileName + ar_id);
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
                                    $('.remove-button').hide(); // Hide remove buttons after cancel
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

        

////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        // Update modal content with reference number
        $('#reference_no .reference_no').text(refNo);
        console.log(refNo);
        $(document).trigger('referenceNoSet');

        // Update product code textarea if product codes are available
        if (productCodes.length > 0) {
            var productCodesString = productCodes.join('\n'); // Join product codes into a single string separated by newline
            $('#productCodes').val(productCodesString);
        } else {
            // Handle case where no product codes are available
            $('#productCodes').val('N/A');
        }


        $('#reportDropdown1').val(reportName);

        $('#statusDropdown1').val(status_report);
        console.log('Display report name:', reportName);
        console.log('Display status:', status_report);

        // Get data from the clicked row
        var releaseStatus = row.find(releaseStatusClass).text().trim();
        var incentiveStatus = row.find(incentiveStatusClass).text().trim();
        console.log("Incentive Status:", incentiveStatus);
        var optionValue;
        switch (incentiveStatus) {
            case "For HR Request":
                optionValue = "1";
                break;
            case "Collected":
                optionValue = "2";
                break;
            case "No Incentive":
                optionValue = "3";
                break;
            default:
                optionValue = ""; // Handle unknown values
                break;
        }
        var date = row.find(dateClass).text().trim();

        var engineer = row.find(engineerClass).text().trim();
        console.log("Engineer name:", engineer);
        var engineersDropdown = $('#engineers_modal_two');
        // Remove existing options (if any)
        engineersDropdown.empty();
        // Add the new engineer option
        engineersDropdown.append(new Option(engineer, engineer, true, true));
        // Trigger change event to update Select2 dropdown
        engineersDropdown.trigger('change');

        var activityType = row.find(typeClass).text().trim();
        var activityTypeDropdown = $('#Activity_Type');
        // Remove existing options (if any)
        activityTypeDropdown.empty();
        // Add the new engineer option
        activityTypeDropdown.append(new Option(activityType, activityType, true, true));
        // Trigger change event to update Select2 dropdown
        activityTypeDropdown.trigger('change');


        // Use the mapped option value as needed
        console.log("Mapped activity type:", activityType);

        var examType = row.find(examTypeClass).text().trim();
        var examTypeOption;

        switch (examType) {
            case "Prometric Technical Exam":
                examTypeOption = "1";
                break;
            case "Prometric Sales Exam":
                examTypeOption = "2";
                break;
            case "Online Technical Exam":
                examTypeOption = "3";
                break;
            case "Online Sales Exam":
                examTypeOption = "4";
                break;
            default:
                examTypeOption = "";
        }
        var incentiveDetails = row.find(incentiveDetailsClass).text().trim();
        var optionDetails;
        switch (incentiveDetails) {
            case "Preferred - Complex (1 exam track) => P5000":
                optionDetails = "1";
                break;
            case "Preferred - Complex (2 or more exams track) => P10000":
                optionDetails = "2";
                break;
            case "Preferred - Simple (1 exam track) => P3000":
                optionDetails = "3";
                break;
            case "Preferred - Simple (2 or more exams track) => P5000":
                optionDetails = "4";
                break;
            case "Supplemental - Complex (1 exam track) => P2000":
                optionDetails = "5";
                break;
            case "Supplemental - Complex (2 or more exams track) => P3000":
                optionDetails = "6";
                break;
            case "Supplemental - Simple (1 exam track) => P500":
                optionDetails = "7";
                break;
            case "Supplemental - Simple (2 or more exams track) => P1000":
                optionDetails = "8";
                break;
            default:
                optionDetails = "";
        }
        var amount = row.find(amountClass).text().trim();
        if (amount === "0") {
            amount = "NA";
        }

        // var productLine = $(this).find('td').eq(8).text();
        // var prodLineDropdown = $('#product_line');
        // // Remove existing options (if any)
        // prodLineDropdown.empty();
        // // Split the fetched value into an array of individual values
        // var prodLineValues = productLine.split(',').map(value => value.trim()).filter(value => value.length > 0);
        // console.log("prodLineValues:", prodLineValues);
        // // Add options for each value
        // prodLineValues.forEach(function(value) {
        //     prodLineDropdown.append(new Option(value.trim(), value.trim(), true, true));
        // });
        // // Set the value of the dropdown to the array of values
        // $("#product_line").val(prodLineValues);
        // // Trigger change event to update Select2 dropdown
        // prodLineDropdown.trigger('change');


        var title = row.find(titleClass).text().trim();
        var examCode = row.find(examCodeClass).text().trim();
        var score = row.find(scoreClass).text().trim();
        var scoreOption;
        switch (score) {
            case "Passed":
                scoreOption = "Passed";
                break;
            case "Failed":
                scoreOption = "Failed";
                break;
            default:
                scoreOption = "";
        }
        // Fetch the ar_takeStatus value
        var ar_takeStatus = $(this).data("ar-take-status");
        console.log("ar_takeStatus:", ar_takeStatus);

        // Determine the takesOption based on ar_takeStatus
        var takesOption;
        if (ar_takeStatus === 1) {
            takesOption = "1";
        } else if (ar_takeStatus === "nth") {
            takesOption = "nth";
        } else if (parseInt(ar_takeStatus) > 1) {
            takesOption = "2";
        } else {
            takesOption = "";
        }
        console.log("Mapped value:", takesOption);



        // Populate modal with the data
        $("#releaseStatus").val(releaseStatus);
        $("#modal_incentiveStatusDropdown").val(optionValue);
        $("#date").val(date);
        $("#engineers_modal_two").val(engineer);
        $("#Activity_Type").val(activityType);
        $("#modal_examTypeDropdown").val(examTypeOption);
        $("#modal_incentiveDetailsDropdown").val(optionDetails);
        $("#modal_amount").val(amount);
        $("#modal_title").val(title);
        $("#modal_examCode").val(examCode);
        $("#modal_scoreDropdown").val(scoreOption);
        $("#modal_takeStatusDropdown").val(takesOption);
        $("#Activity_details").val(ar_activityName);
        $("#act_date").val(ar_activityDate);
        $("#venue").val(ar_venue);
        $("#sendcopyto").val(ar_sendcopyTo);
        $('#exampleModal').modal('show');

        console.log("Ar activity: " , ar_activityName)
    });
});



///////////////////Select Engineers//////////////////////////////////
$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        $('#engineers').select2({
            width: '80%',
            dropdownParent: $('#exampleModal .modal-content'),
            dropdownCssClass: 'custom-select2-dropdown',
            multiple: true,
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
                                text: item.engineer // And display text
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
});
