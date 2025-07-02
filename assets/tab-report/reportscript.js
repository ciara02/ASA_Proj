// /////////////////////// -- Calling DataTable -- //////////////////////
$(document).ready(function () {
    $('#project-table').DataTable({
        scrollX: true,
    });
});
// /////////////////////// -- Clickable Datatable -- //////////////////////
$(document).ready(function () {
    $('#project-table').DataTable();
    $("#newproj_opportunity").hide();

    const editDatatableRowHtml = $('#edit_datatable_row').html();
    
    $('#project-table tbody').on('click', 'tr', function () {

        var table = $('#project-table').DataTable();
        var rowData = table.row(this).data();
        var projectCategory = $('.projcategory').val();       
       
        if (rowData) {
            if (projectCategory === 'DigiKnow' || projectCategory === 'DigiKnow Per Engineer' || projectCategory === 'DigiKnow Per Product Line' || projectCategory === 'Project Progress Report' || projectCategory === 'Solution Center' || projectCategory === 'Solution Center per Product Line' || projectCategory === 'sTraCert' || projectCategory === 'Compiled Reports') {
                var arId = rowData.ar_id;
                var referenceNo = rowData.ar_refNo;
                var reportName = rowData.report_name;
                var statusName = rowData.status_name;
                var activityName = rowData.ar_activity;
                var activityDate = rowData.ar_activityDate;
                var activityType = rowData.type_name;
                var programName = rowData.program_name;
                var Productlines = rowData.ProductLine;
                var venue = rowData.ar_venue;
                var sendCopyTo = rowData.ar_sendCopyTo;
                var reseller = rowData.ar_resellers;
                var resellerContact = rowData.ar_resellers_contact;
                var resellerEmail= rowData.ar_resellers_phoneEmail;
                var endUser= rowData.ar_endUser;
                var endUserContact= rowData.ar_endUser_contact;
                var endUserEmail= rowData.ar_endUser_phoneEmail;
                var endUserLocation= rowData.ar_endUser_loc;
                var requester = rowData.ar_requester;
                var specialInstruction = rowData.ar_instruction;
                var copy_name = rowData.copy_name;
                var prodEngrName = rowData.prodEngr_name;
                var dateNeeded = rowData.ar_date_needed;
                var DateFiled = rowData.ar_date_filed;
                var engrName = rowData.engr_name;
                var receipentBP = rowData.ar_recipientBPs;
                var recipientEU = rowData.ar_recipientEUs;
                var timeExpected = rowData.expected_key_time;
                var timeExited = rowData.exited_key_time;
                var timeReported = rowData.expected_key_time;
                var projectName = rowData.proj_name;
                var projType = rowData.name;
                var title = rowData.ar_title;
                var examName = rowData.ar_examName;
                var takeStatus = rowData.ar_takeStatus;
                var score = rowData.ar_score;
                var examType = rowData.ar_examType;
                var incDetails = rowData.ar_incDetails;
                var incAmount = rowData.ar_incAmount;
                var incStatus = rowData.ar_incStatus;
                var topicName = rowData.ar_topic;
                var stra_dateStart = rowData.ar_dateStart;
                var stra_dateEnd = rowData.ar_dateEnd;
                var techProdLearned = rowData.ar_prodLearned;
                var engrFeedback = rowData.ar_feedbackEngr;
                var engrRating = rowData.ar_rating;
                var techProdLearned = rowData.ar_prodLearned;
                var memoIssued = rowData.ar_memoIssued;
                var memoDetails = rowData.ar_memoDetails;
                var prodModel = rowData.ar_POCproductModel;
                var assetCode = rowData.ar_POCassetOrCode;
                var poc_dateStart = rowData.ar_POCdateStart;
                var poc_dateEnd = rowData.ar_POCdateEnd;
                var trainingName = rowData.ar_trainingName;
                var location = rowData.ar_location;
                var speaker = rowData.ar_speakers;
                var perfectAttendance = rowData.ar_perfectAtt;
                var MSIProjName = rowData.ar_projName;
                var compliancePercentage = rowData.ar_compPercent;
                var attendeesBP = rowData.ar_attendeesBPs;
                var attendeesEUs = rowData.ar_attendeesEUs;
                var attendeesMSI = rowData.ar_attendeesMSI;
                var custRequirements = rowData.ar_custRequirements;
                var activityDone = rowData.ar_activityDone;
                var agreements = rowData.ar_agreements;

                $('#project .proj_name').text(projectName);
                $('#project_type .proj_type').text(projType);
                $('#report_status .status').text(statusName);
                $('#report_category .report').text(reportName);
                $('#reference_no .reference_no').text(referenceNo);
                $('#reportDropdown1').val(reportName);
                $('#statusDropdown1').val(statusName);
                $('#projtype_button1').val(projType);
                $('#Activity_details').val(activityName);
                $('#act_date').val(activityDate);
                $('#act_details_requester').val(requester);
                $('#Date_Filed').val(DateFiled);
                $('#Date_Needed').val(dateNeeded);
                $('#act_details_activity').val(activityName);
                $('#Ref_No').val(referenceNo);
                $('#special_instruction').val(specialInstruction);
                $('#venue').val(venue);
                $('#sendcopyto').val(sendCopyTo);
                $('#Reseller').val(reseller);
                $('#reseller_contact_info').val(resellerContact);
                $('#reseller_phone_email').val(resellerEmail);
                $('#end_user_name').val(endUser);
                $('#end_user_contact').val(endUserContact);
                $('#end_user_email').val(endUserEmail);
                $('#end_user_loc').val(endUserLocation);
                $('#modal_title').val(title);
                $('#modal_examCode').val(examName);
                $('#modal_takeStatusDropdown').val(takeStatus);
                $('#modal_scoreDropdown').val(score);
                $('#modal_examTypeDropdown').val(examType);
                $('#modal_incentiveStatusDropdown').val(incDetails);
                $('#modal_incentiveDetailsDropdown').val(incAmount);
                $('#modal_amount').val(incStatus);
                $('#modal_techprodLearned').val(techProdLearned);
                $('#stra_topicName').val(topicName);
                $('#stra_dateStart').val(stra_dateStart);
                $('#stra_dateEnd').val(stra_dateEnd);
                $('#modal_engrFeedbackInput').val(engrFeedback);
                $('#modal_other_rating').val(engrRating);
                $('#modal_topicName').val(topicName);
                $('#modal_dateStart').val(stra_dateStart);
                $('#modal_dateEnd').val(stra_dateEnd);
                $('#modal_memoIssued').val(memoIssued);
                $('#modal_memoDetails').val(memoDetails);
                $('#modal_prodModel').val(prodModel);
                $('#modal_assetCode').val(assetCode);
                $('#modal_poc_dateStart').val(poc_dateStart);
                $('#modal_poc_dateEnd').val(poc_dateEnd);
                $('#modal_trainingName').val(trainingName);
                $('#modal_location').val(location);
                $('#modal_speaker').val(speaker);
                $('#modalperfectAttendance').val(perfectAttendance);
                $('#modal_MSIProjName').val(MSIProjName);
                $('#modal_CompliancePercentage').val(compliancePercentage);
                $('#customerReqfield').val(custRequirements);
                $('#activity_donefield').val(activityDone);
                $('#Agreementsfield').val(agreements);

//////////////////////////////////////////////////---PROJECT TYPE DROPDOWN--///////////////////////////////////////////////////////////////////////
                var projectNameDropdown = $('#myDropdown1');
                // Remove existing options (if any)
                projectNameDropdown.empty();
                // Add the new engineer option
                projectNameDropdown.append(new Option(projectName, projectName, true, true));
                // Trigger change event to update Select2 dropdown
                projectNameDropdown.trigger('change');
                $('#myDropdown1').val(projectName);
//////////////////////////////////////////////////---ACTIVITY TYPE DROPDOWN SELECT--//////////////////////////////////////////////////////
                var activityTypeDropdown = $('#Activity_Type');
                // Remove existing options (if any)
                activityTypeDropdown.empty();
                // Add the new engineer option
                activityTypeDropdown.append(new Option(activityType, activityType, true, true));
                // Trigger change event to update Select2 dropdown
                activityTypeDropdown.trigger('change');
                $('#Activity_Type').val(activityType);

//////////////////////////////////////////////////---PROGRAM DROPDOWN SELECT--//////////////////////////////////////////////////////
                var programDropdown = $('#program');
                // Remove existing options (if any)
                programDropdown.empty();
                // Add the new engineer option
                programDropdown.append(new Option(programName, programName, true, true));
                // Trigger change event to update Select2 dropdown
                programDropdown.trigger('change');
                $('#program').val(programName);
                
//////////////////////////////////////////////////---PRODUCTLINE DROPDOWN SELECT--//////////////////////////////////////////////////////
                var prodLineDropdown = $('#product_line');
                // Remove existing options (if any)
                prodLineDropdown.empty();
                if (Productlines) {
                     // Split the fetched value into an array of individual values
                var prodLineValues = Productlines.split(',').map(value => value.trim()).filter(value => value.length > 0);
                console.log("prodLineValues:", prodLineValues);
                // Add options for each value
                prodLineValues.forEach(function(value) {
                    prodLineDropdown.append(new Option(value.trim(), value.trim(), true, true));
                });
                $('#product_line').val(prodLineValues);
                }

//////////////////////////////////////////////////---TIME DROPDOWN SELECT--//////////////////////////////////////////////////////
                var timeExpectedDropdown = $('#time_expected1');
                // Remove existing options (if any)
                timeExpectedDropdown.empty();
                if (timeExpected == null || timeExpected === '') {
                    // Append "N/A" option
                    timeExpectedDropdown.append(new Option("N/A", "", true, true));
                } else {
                    // Append the actual timeExited value
                    timeExpectedDropdown.append(new Option(timeExpected, timeExpected, true, true));
                }
                // Trigger change event to update Select2 dropdown
                timeExpectedDropdown.trigger('change');
                $('#time_expected1').val(timeExpected);


                var timeReportedDropdown = $('#time_reported1');
                // Remove existing options (if any)
                timeReportedDropdown.empty();               
                // Check if timeExited is null or empty
                if (timeReported == null || timeReported === '') {
                    // Append "N/A" option
                    timeReportedDropdown.append(new Option("N/A", "", true, true));
                } else {
                    // Append the actual timeExited value
                    timeReportedDropdown.append(new Option(timeReported, timeReported, true, true));
                }
                timeReportedDropdown.trigger('change');
                $('#time_reported1').val(timeReported);


                var timeExitedDropdown = $('#time_exited1');
                // Remove existing options (if any)
                timeExitedDropdown.empty();            
                // Check if timeExited is null or empty
                if (timeExited == null || timeExited === '') {
                    // Append "N/A" option
                    timeExitedDropdown.append(new Option("N/A", "", true, true));
                } else {
                    // Append the actual timeExited value
                    timeExitedDropdown.append(new Option(timeExited, timeExited, true, true));
                }
                // Trigger change event to update Select2 dropdown
                timeExitedDropdown.trigger('change');
                $('#time_exited1').val(timeExited);
                

               
//////////////////////////////////////////////////---ENGR DROPDOWN SELECT--//////////////////////////////////////////////////////
                var engrNameDropdown = $('#engineers_modal_two');
                // Remove existing options (if any)
                engrNameDropdown.empty();

                // Check if prodEngrName is not null or undefined
                if (engrName) {
                    // Split the fetched value into an array of individual values
                    var engrNameValues = engrName.split(',').map(value => value.trim()).filter(value => value.length > 0);
                    console.log("engrNameValues:", engrNameValues);
                    
                    // Add options for each value
                    engrNameValues.forEach(function(value) {
                        engrNameDropdown.append(new Option(value.trim(), value.trim(), true, true));
                    });
                    
                    // Set the value of the dropdown
                    $('#engineers_modal_two').val(engrNameValues);
                }
               
//////////////////////////////////////////////////---PROD ENGR DROPDOWN SELECT--//////////////////////////////////////////////////////
                var prodEngrDropdown = $('#engineers_modal');
                // Remove existing options (if any)
                prodEngrDropdown.empty();

                // Check if prodEngrName is not null or undefined
                if (prodEngrName) {
                    // Split the fetched value into an array of individual values
                    var prodEngrNameValues = prodEngrName.split(',').map(value => value.trim()).filter(value => value.length > 0);
                    console.log("prodEngrNameValues:", prodEngrNameValues);
                    
                    // Add options for each value
                    prodEngrNameValues.forEach(function(value) {
                        prodEngrDropdown.append(new Option(value.trim(), value.trim(), true, true));
                    });
                    
                    // Set the value of the dropdown
                    $('#engineers_modal').val(prodEngrNameValues);
                }

//////////////////////////////////////////////////---COPY TO DROPDOWN SELECT--//////////////////////////////////////////////////////
                var copyToDropdown = $('#Copy_to');
                // Remove existing options (if any)
                copyToDropdown.empty();
                if (copy_name) {
                     // Split the fetched value into an array of individual values
                var copyToValues = copy_name.split(',').map(value => value.trim()).filter(value => value.length > 0);
                console.log("copyToValues:", copyToValues);
                // Add options for each value
                copyToValues.forEach(function(value) {
                    copyToDropdown.append(new Option(value.trim(), value.trim(), true, true));
                });
                $('#Copy_to').val(copyToValues);
                }       

//////////////////////////////////////////////////---RECEIPENT / ATTENDEES CHECKBOX--//////////////////////////////////////////////////////
                if (receipentBP === '1') {
                    $('#modal_bpDigiCheckbox').prop('checked', true);
                } else {
                    $('#modal_bpDigiCheckbox').prop('checked', false);
                }
                if (recipientEU === '1') {
                    $('#modal_euDigiCheckbox').prop('checked', true);
                } else{
                    $('#modal_euDigiCheckbox').prop('checked', false);
                }

                if (attendeesBP === '1') {
                    $('#bpCheckbox').prop('checked', true);
                } else {
                    $('#bpCheckbox').prop('checked', false);
                }
                if (attendeesEUs === '1') {
                    $('#euCheckbox').prop('checked', true);
                } else{
                    $('#euCheckbox').prop('checked', false);
                }
                if (attendeesMSI === '1') {
                    $('#MSICheckbox').prop('checked', true);
                } else{
                    $('#MSICheckbox').prop('checked', false);
                }

/////////////////////////////////////////////////////////////--ATTACHMENT FETCH--////////////////////////////////////////////////////////////////////////
                
        $(document).ready(function () {
            let removedFilesHTML = []; // Array to store removed file HTML
            let removeButtonClicked = false; // Variable to track if remove button was clicked
            let originalFilesHTML = []; // Array to store original file HTML before edit
        
            // AJAX request to get the files
            $.ajax({
                url: '/tab-activity/index/getFile',
                type: 'GET',
                data: { refNo: referenceNo },
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
                                                <button class="btn btn-danger btn-sm remove-button" style="position: absolute; top: -9px; right: 0; width: 20px; height: 20px; border-radius: 50%; padding: 0;"><i class="bi bi-x"></i></button>
                                            </div>
                                            <a href="${filePath}" target="_blank">${displayName}</a>
                                        </div>
                                    `);
                                }
                                originalFilesHTML = $('#fileDisplay').html();
                                setFileDisplay(fileName, filePath, iconPath); // Set the file display for each file
                                $('.remove-button').hide(); // Initially hide remove button
            
                                // Handle edit button click to show respective remove button
                                $('#editbutton').click(function () {
                                      originalFilesHTML = $('#fileDisplay').html();
                                    $('.remove-button').show(); // Show remove button on edit
                                });
            
                                $('#cloneButton').click(function () {
                                   $('#fileDisplay').empty();
                                });
            
                                // Handle remove file button click (using event delegation)
                                $(document).on('click', '.remove-button', function () {
                                    console.log('Remove button clicked');
                                    // Store the removed file container HTML
                                    removedFilesHTML.push($(this).closest('.file-container').prop('outerHTML'));
                                    // Remove the file display container from DOM
                                    $(this).closest('.file-container').remove();
                                    removeButtonClicked = true; // Set removeButtonClicked to true
                                });
            
                                // Handle save button click
                                $('#saveButton').click(function () {
                                    // Assuming ar_id is retrieved from a hidden input or relevant field
                                    var ar_id = $("#ar_id").val();
                                    // Assuming this retrieves the file data
                                    var digiknow_file_data = $('#modal_digiknowFlyersattachment').prop('files')[0];
            
                                    console.log('ar_id:', ar_id);
                                    console.log('digiknow_file:', digiknow_file_data ? digiknow_file_data.name : null);
            
                                    // Conditionally delete the file if remove button was clicked
                                    if (removeButtonClicked) {
                                        // AJAX call to delete the file
                                        if (ar_id) {
                                            $.ajax({
                                                url: '/tab-activity/index/deleteImage',
                                                type: 'POST',
                                                data: {
                                                    ar_id: ar_id,
                                                    digiknow_file: digiknow_file_data ? digiknow_file_data.name : null,
                                                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                                                },
                                                success: function (response) {
                                                    console.log('File deleted successfully:', response);
                                                    // Assuming there is an image element to remove
                                                    $('#imageElement').fadeOut('slow', function () {
                                                        $(this).remove();
                                                    });
                                                    // Hide and show appropriate elements after deletion
                                                    $('#fileDisplay').hide();
                                                    $('#modal_digiknowFlyersattachment').show();
                                                    // Hide the delete button after successful deletion
                                                    $('.remove-button').hide(); // Hide remove buttons after deletion
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error('Error deleting file:', error);
                                                }
                                            });
                                        } else {
                                            console.error("Error: ar_id is not available.");
                                        }
                                    }
            
                                    // Reset flag after handling deletion
                                    removeButtonClicked = false;
                                });
                            }
                        });
        
                    } else {
                        // No files found case
                        $('#fileDisplay').html('<p>No files found.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    $('#fileDisplay').html('<p>Error fetching files.</p>');
                },
            });
        
            // Handle cancel button click to restore removed files
            $('#cancelButton').click(function () {            
                $('#fileDisplay').empty();

                // Append the original files HTML
               $('#fileDisplay').append(originalFilesHTML);

               // Hide remove buttons after cancel
               $('.remove-button').hide();
            });
        });

        $(document).ready(function () {
            let removeButtonClicked = false; // Variable to track if remove button was clicked
            let removedFilesHTML = []; // Array to store removed file HTML
            let originalFilesHTML = []; // Array to store original file HTML before edit
        
            $.ajax({
                url: '/tab-activity/index/getDigiknowFile',
                type: 'GET',
                data: { refNo: referenceNo },
                success: function (response, status, xhr) {
                    console.log('Response from server: ', response);

                    if (response.retrieve_digiknowfiles && response.retrieve_digiknowfiles.length > 0) {
                        // Clear the container before appending new files
                        $('#digiknowfileDisplay').empty();

                        response.retrieve_digiknowfiles.forEach(function (file) {
                            if (file) {
                                let filePath = 'uploads/' + file; // Assuming file is the file name or path
                                let fileName = file.split('/').pop(); // Extract filename from filePath
            
                                // Determine MIME type based on filename extension (you may need to adjust how you retrieve this)
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
                                    $('#digiknowfileDisplay').append(`
                                        <div class="file-container" style="margin-left: 2%;"> 
                                            <div style="position: relative; display: inline-block;" >
                                                <img src="${iconPath}" alt="File Icon" style="width:50px;height:50px;">
                                                <button class="btn btn-danger btn-sm remove-button" style="position: absolute; top: -9px; right: 0; width: 20px; height: 20px; border-radius: 50%; padding: 0;"><i class="bi bi-x"></i></button>
                                            </div>
                                            <a href="${filePath}" target="_blank">${displayName}</a>
                                        </div>
                                    `);
                                }
                                originalFilesHTML = $('#digiknowfileDisplay').html();
                                setFileDisplay(fileName, filePath, iconPath); // Set the file display for each file
            
                                // Hide remove buttons initially
                                $('.remove-button').hide();
    
                                // Handle edit button click to show remove buttons
                                $('#editbutton').click(function () {
                                    originalFilesHTML = $('#digiknowfileDisplay').html();
                                    $('.remove-button').show();
                                });
                                 // Handle edit button click to show remove buttons
                                 $('#cloneButton').click(function () {
                                    $('#digiknowfileDisplay').empty();
                                });
    
                                // Handle remove file button click (using event delegation)
                                $(document).on('click', '.remove-button', function () {
                                    console.log('Remove button clicked');
                                    // Store the removed file container HTML
                                    removedFilesHTML.push($(this).closest('.file-container').prop('outerHTML'));
                                    // Remove the file display container from DOM
                                    $(this).closest('.file-container').remove();
                                    removeButtonClicked = true; // Set removeButtonClicked to true
                                });
            
                                // Handle save button click
                                $('#saveButton').click(function () {
                                    // Assuming ar_id is retrieved from a hidden input or relevant field
                                    var ar_id = $("#ar_id").val();
                                    // Assuming this retrieves the file data
                                    var digiknow_file_data = $('#modal_digiknowFlyersattachment').prop('files')[0];
            
                                    console.log('ar_id:', ar_id);
                                    console.log('digiknow_file:', digiknow_file_data ? digiknow_file_data.name : null);
            
                                    // Conditionally delete the file if remove button was clicked
                                    if (removeButtonClicked) {
                                        // AJAX call to delete the file
                                        if (ar_id) {
                                            $.ajax({
                                                url: '/tab-activity/index/deleteImage',
                                                type: 'POST',
                                                data: {
                                                    ar_id: ar_id,
                                                    digiknow_file: digiknow_file_data ? digiknow_file_data.name : null,
                                                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                                                },
                                                success: function (response) {
                                                    console.log('File deleted successfully:', response);
                                                    // Assuming there is an image element to remove
                                                    $('#imageElement').fadeOut('slow', function () {
                                                        $(this).remove();
                                                    });
                                                    // Hide and show appropriate elements after deletion
                                                    $('#digiknowfileDisplay').hide();
                                                    $('#modal_digiknowFlyersattachment').show();
                                                    // Hide the delete button after successful deletion
                                                    $('.remove-button').hide(); // Hide remove buttons after deletion
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error('Error deleting file:', error);
                                                }
                                            });
                                        } else {
                                            console.error("Error: ar_id is not available.");
                                        }
                                    }
            
                                    // Reset flag after handling deletion
                                    removeButtonClicked = false;
                                });
                            }
                        });
        
                    } else {
                        // No files found case
                        $('#digiknowfileDisplay').html('<p>No files found.</p>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    $('#digiknowfileDisplay').html('<p>Error fetching files.</p>');
                },
            });
        
             // Handle cancel button click to restore removed files
            $('#cancelButton').click(function () {
                $('#digiknowfileDisplay').empty();

                 // Append the original files HTML
                $('#digiknowfileDisplay').append(originalFilesHTML);

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
/////////////////////////////////////////////////////////////--END OF ATTACHMENT FETCH--////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////  Action Plan / Recommendation Modal  //////////////////////////////////////////////////////
  $(document).ready(function () {
    function toggleInputsActionPlan(disabled) {
        $('#ActionPlan_Recommendation input, #ActionPlan_Recommendation textarea, #ActionPlan_Recommendation select, #ActionPlan_Recommendation button').prop('disabled', disabled);
    }
    $.ajax({
        url: '/tab-activity/index/getContractDetails_actionplan',  // 
        type: 'GET',
        data: { refNo: referenceNo },
        success: function (response) {
            console.log('Response from server: ', response);
            // empty the container first
            $("#ActionPlan_Recommendation").empty();
    
            if (Array.isArray(response)) {
                // If there is fetched data
                response.forEach(function (data) {
                    var plantargetdate = data.PlanTargetDate || ''; // Handle null or undefined values
                    var details = data.PlanDetails || ''; // Handle null or undefined values
                    var planowner = data.PlanOwner || ''; // Handle null or undefined values
                    var inputHTML = '<div class="row actionplan">\
       <div class="col-md-2">\
           <div class="participant-container mb-3">\
               <label for="validationServer12" class="form-label">Plan Target</label>\
               <div class="input-group">\
                   <input type="date" class="form-control PlanTarget" placeholder="Plan Target"\
                       value="' + plantargetdate + '">\
               </div>\
           </div>\
       </div>\
       <div class="col-md-5">\
           <div class="position-container mb-3">\
               <label for="validationServer12" class="form-label">Details</label>\
               <div class="input-group">\
                       <textarea type="text" class="form-control Details" id="details" placeholder="Enter Details" rows="3">' + details + '</textarea>\
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
           <div class="button-container mb-3">\
               <button type="button" class="btn btn-primary add-actionplan">Add</button>\
               <button type="button" class="btn btn-danger delete-actionplan">Delete</button>\
           </div>\
       </div>\
    </div>';
    
                    // Append it to the container
                    $("#ActionPlan_Recommendation").append(inputHTML);
                });
            } else {
                // If there is no fetched data, still display empty fields
                var inputHTML = '<div class="row actionplan">\
    <div class="col-md-2">\
       <div class="participant-container mb-3">\
           <label for="validationServer12" class="form-label">Plan Target</label>\
           <div class="input-group">\
               <input type="date" class="form-control PlanTarget"\
                   value="">\
           </div>\
       </div>\
    </div>\
    <div class="col-md-5">\
       <div class="position-container mb-3">\
           <label for="validationServer12" class="form-label">Details</label>\
           <div class="input-group">\
           <textarea type="text" class="form-control Details" id="details" placeholder="Enter Details" rows="3"  value=""></textarea>\
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
    <div class="col-md-2 align-self-end"> <!-- Adjust this width based on your needs -->\
       <div class="button-container mb-3">\
           <button type="button" class="btn btn-primary add-actionplan">Add</button>\
           <button type="button" class="btn btn-danger delete-actionplan">Delete</button>\
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
    });
});

///////////////////////////////////  Participant/Position Modal  //////////////////////////////////////////////////////
$(document).ready(function () {
    function toggleInputsParticipant(disabled) {
        $('#participantAndPositionContainer input, #participantAndPositionContainer textarea, #participantAndPositionContainer select,  #participantAndPositionContainer button' ).prop('disabled', disabled);
    }
    $.ajax({
        url: '/tab-activity/index/getSummaryReport',
        type: 'GET',
        data: { refNo: referenceNo },
        success: function (response) {
            console.log('Response from server: ', response);
    
            // empty the container first
            $("#participantAndPositionContainer").empty();
    
            if (Array.isArray(response)) {
                // If there is fetched data
                response.forEach(function (data) {
                    var participant = data.participant || ''; // Handle null or undefined values
                    var position = data.position || ''; // Handle null or undefined values
                    var inputHTML = '<div class="row participantposition">\
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
            <div class="col-md-2 align-self-end"> <!-- Adjust this width based on your needs -->\
                <div class="button-container mb-3">\
                    <button type="button" class="btn btn-primary add-position">Add</button>\
                    <button type="button" class="btn btn-danger delete-position">Delete</button>\
                </div>\
            </div>\
        </div>';
    
                    // Append it to the container
                    $("#participantAndPositionContainer").append(inputHTML);
                });
            } else {
                // If there is no fetched data, still display empty fields
                var inputHTML = '<div class="row participantposition">\
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
            <div class="col-md-2 align-self-end"> <!-- Adjust this width based on your needs -->\
                <div class="button-container mb-3">\
                    <button type="button" class="btn btn-primary add-position">Add</button>\
                    <button type="button" class="btn btn-danger delete-position">Delete</button>\
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
    });
});


                $('#exampleModal').modal('show');

            } else if (projectCategory === 'Maintain Projects' || projectCategory === 'Ongoing Projects'){
                reinitializeModal('#edit_datatable_row', editDatatableRowHtml);
                
                // Populate the modal with the captured project code and name
                $('#project_code').val();
                $('#project_name').val();
                $('#date_filed').val();
                $('#business_unit').val();
                $('#product_line').val();
                $('#serv_category').val();
                $('#orig_receipt').val();
                $('#inv').val();
                $('#mbs').val();
                $('#po').val();
                $('#so').val();
                $('#ft').val();
                $('#start_date').val();
                $('#end_date').val();
                $('#proj_amount').val();
                $('#completed').val();
                $('#reseller').val();
                $('#end_user').val();
                $('#proj_manday').val();
                $('#financial_status').val();
                $('#sign-off_status').val();
                $('#special_instruction').val();


             $('#edit_datatable_row').modal('show');
            } 
   }
});

function reinitializeModal(modalSelector, modalHtml) {
    var modalElement = $(modalSelector);
    modalElement.modal('dispose');
    modalElement.html(modalHtml);
}

    $('#project-table td').on('click', function () {

        // Remove previous highlight class
        $(this).closest('table').find('tr.highlight').removeClass('highlight');

        // add highlight to the parent tr of the clicked td
        $(this).parent('tr').addClass("highlight");
    });
});
//////////////////////////////Engineer name////////////////////////////////////////////////////
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

//////////////////////////Enable/Disable New Project/Opportunity Button/////////////////////////////

$(document).ready(function () {
    // Create a temporary storage for the element
    var tempStorage = $('<div></div>');

    $(".projcategory").change(function () {
        var projcatdropdown = $("#projectcategorydropdown").val();
        console.log(projcatdropdown);  // Check if the value is correctly logged

        var newproj_opportunitybtn = $("#newproj_opportunity");
        var projectcatDropdownContainer = $("#projectcatDropdownContainer");
        var engineerDropdownContainer = $("#engineerDropdownContainer");

        if (projcatdropdown === "Maintain Projects") {
            newproj_opportunitybtn.show();
            tempStorage.append(engineerDropdownContainer);  // Move to temp storage
        } else {
            newproj_opportunitybtn.hide();
        }

        if (projcatdropdown === "Maintain Projects" || projcatdropdown === "Ongoing Projects") {
            if ($("#engineerDropdownContainer").length > 0) {
                tempStorage.append(engineerDropdownContainer);  // Move to temp storage
            }
        } else {
            if ($("#engineerDropdownContainer").length === 0) {
                projectcatDropdownContainer.after(tempStorage.children());  // Move back from temp storage
            }
        }
    });
});




////////////////////////// Get Project Name use as parameters /////////////////////////////

$(document).ready(function () {
    $('#project-table tbody').on('click', 'tr', function () {
        var projectName = $(this).find('td:eq(1)').text();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/tab-activity/getProjName',
            method: 'POST',
            data: {
                projName: projectName
            },
            success: function (response) {
                console.log('Success', response);

                // empty the container first
                $("#engineerInputsContainer").empty();

                response.forEach(function (project) {
                    project.eng_names.forEach(function (eng_name, index) {
                        var projectId = project.project_ids[index]; // get corresponding project_id

                        var inputHTML = '<div class="col-md-12 d-flex align-items-center gap-2 mt-2">\
                  <label for="engr_name" class="form-label">Engineer Name:</label>\
                  <input type="text" class="form-control engr_name" placeholder=""\
                      value="' + eng_name + '" required>\
                  <label for="man_day" class="form-label">Project Id:</label>\
                  <input type="text" class="form-control man_day" placeholder=""\
                      value="' + projectId + '" required>\
                      <a href="/tab-manday/index?engName=' + encodeURIComponent(eng_name) + '&projectId=' + encodeURIComponent(projectId) + '" class="btn btn-info">Manday</a></div>';

                        // Append it to the container
                        $("#engineerInputsContainer").append(inputHTML);
                    });
                });
            },
            error: function (xhr, status, error) {
                console.error('Error:', xhr.responseText);
            }
        });
    });
});

$(document).ready(function() {
    // Function to disable dateFrom if StartDate is empty
    function disableDateTo() {
        var startDate = $("#startDate").val();
        if (startDate === "") {
            $("#endDate").prop("disabled", true);
            $("#endDate").val("");
        } else {
            $("#endDate").prop("disabled", false);
        }
    }
    // Call the function initially
    disableDateTo();

    // Event listener for changes in StartDate
    $("#startDate").change(function() {
        disableDateTo();
    });

    // Event listener for changes in EndDate
    $("#endDate").change(function() {
        // Date Restriction
        var dateFrom = new Date($("#startDate").val());
        var dateTo = new Date($("#endDate").val());

        // Check if dateFrom is greater than dateTo
        if (dateFrom > dateTo) {
           
            Swal.fire({title:"End date error!", text: "End date cannot be less than start date", icon: "error"});
           
            $("#endDate").val("");
        } 
    });
});

//////////////////////////// Report Filter /////////////////////////////
$(document).ready(function () {
    $('#filterButton').click(function () {

        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var projectCategory = $('.projcategory').val();
        var engineername = Array.from(document.getElementById('engineername').selectedOptions).map(option => option.value);

        if (startDate === '' || endDate === '' || projectCategory === '') {
            Swal.fire({ text: "Please provide Start Date, End Date, and Project Category", icon: "warning"});
            return; // Stop further execution
        } 

        // Function to restore input values
        function restoreInputValues() {
            document.getElementById('startDate').value = startDate;
            document.getElementById('endDate').value = endDate;
            document.getElementById('projectcategorydropdown').value = projectCategory;
            if (projectCategory !== 'Maintain Projects' && projectCategory !== 'Ongoing Projects') {
                var engineerSelect = document.getElementById('engineername');
                 Array.from(engineerSelect.options).forEach(option => {
                option.selected = engineername.includes(option.value);
            });
            }
        }

        // Parse the startDate and endDate to JavaScript Date objects
        var parsedStartDate = new Date(startDate);
        var parsedEndDate = new Date(endDate);

        // Calculate the difference in days between endDate and startDate
        var timeDifference = parsedEndDate.getTime() - parsedStartDate.getTime();
        var daysDifference = timeDifference / (1000 * 3600 * 24);

        // Check if the difference is greater than 365 days (1 year)
        if (daysDifference > 730) {
            // Show alert if the difference is greater than 2 years
            Swal.fire('Date Range Error!', 'Please select a date range within two years.', 'error');
        } else {
            // Show loading animation
            $('#loading').show();

            $.ajax({
                url: '/tab-report/DigiKnowEngr',
                type: "GET",
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    projectCategory: projectCategory,
                    engineers: engineername,
                },
                success: function (response) {
                    console.log('Success', response);

                    restoreInputValues();
                    // Hide loading animation when request is complete
                    $('#loading').hide();

                    $('#project-table').DataTable().clear().destroy();
                    $('#project-table thead').empty();

                    var columns;
                    if (projectCategory === "DigiKnow") {
                        columns = [

                            { title: "Activity Date", data: "ar_activityDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Product Line", data: "ProductLine" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Engineer Name", data: "engr_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Details", data: "ar_activity" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Category", data: "report_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Type", data: "type_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Reseller", data: "ar_resellers" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User", data: "ar_endUser" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Status", data: "status_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Venue", data: "ar_venue" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }}
                        
                        ];
                        
                    }

                    if (projectCategory === "DigiKnow Per Product Line") {
                        columns = [
                            { title: "Product Line", data: "ProductLine" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Date", data: "ar_activityDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Engineer Name", data: "engr_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Details", data: "ar_activity" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Category", data: "report_name", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Activity Type", data: "type_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Reseller", data: "ar_resellers" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User", data: "ar_endUser", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Status", data: "status_name", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Venue", data: "ar_venue", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } }
                        ];
                    }

                    if (projectCategory === "DigiKnow Per Engineer") {
                        columns = [
                            { title: "Engineer Name", data: "engr_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Activity Date", data: "ar_activityDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Product Line", data: "ProductLine" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Details", data: "ar_activity" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Category", data: "report_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Type", data: "type_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Reseller", data: "ar_resellers", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "End User", data: "ar_endUser" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Status", data: "status_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Venue", data: "ar_venue" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }}
                        ];
                    }

                    if (projectCategory === "Maintain Projects") {
                        columns = [

                            { title: "Project Code", data: "proj_code", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Project Name", data: "proj_name", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Date Filed", data: "created_date", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Business Unit", data: "BusinessUnit" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Product Line", data: "product_line" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Service Category", data: "service_category" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "OR", data: "original_receipt" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "INV", data: "inv" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "MBS", data: "mbs" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "PO", data: "po_number" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "SO", data: "so_number" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "FT", data: "ft_number" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Start Date", data: "proj_startDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End Date", data: "proj_endDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            {
                                title: "Project Amount",
                                data: "proj_amount",
                                render: function (data, type, row) {
                                    return parseFloat(data).toFixed(2);
                                }
                            },
                            { title: "Project Status", data: "ProjListStatus" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Reseller", data: "reseller", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "endUser", data: "endUser" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Project manday", data: "manday" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Financial Status", data: "Payment" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            {
                                title: "Signoff Status",
                                data: "SignoffStatus",
                                render: function (data, type, row) {
                                    // Check if data is a string and convert it to a number
                                    var statusNumber = parseInt(data, 10);

                                    switch (statusNumber) {
                                        case 1:
                                            return 'Draft';
                                        case 2:
                                            return 'For Approval';
                                        case 3:
                                            return 'Approved';
                                        case 4:
                                            return 'Disapproved';
                                        default:
                                            return 'Unknown Status';
                                    }
                                }
                            },
                            { title: "Doer & Engineers", data: "Engineers" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Special Instruction", data: "special_instruction" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                        ];
                    }

                    if (projectCategory === "Ongoing Projects") {
                        columns = [
                            { title: "Project Name", data: "proj_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Start Date", data: "proj_startDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "End Date", data: "proj_endDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Project Amount", data: "proj_amount" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Status", data: "status" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Completed", data: "approved_date" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Reseller", data: "reseller" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User", data: "endUser" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                        ];
                    }


                    if (projectCategory === "Project Progress Report") {
                        columns = [
                            { title: "Project Name", data: "proj_name", render: function(data, type, row) {
                                return data ? data : 'NO PROJECT ASSIGNED'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Activity Date", data: "ar_activityDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Status", data: "status_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Details", data: "ar_activity" ,render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Date From", data: "reported_key_time", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Date To", data: "exited_key_time" ,render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                            { title: "Category", data: "report_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Type", data: "type_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Product Line", data: "ProductLine" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Resellers", data: "ar_resellers" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User", data: "ar_endUser" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Venue", data: "ar_venue" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            } },
                        ];
                    }

                    if (projectCategory === "Solution Center") {
                        columns = [

                            { title: "Activity Date", data: "ar_activityDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Product Line", data: "ProductLine" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Engineer Name", data: "engr_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Details", data: "ar_activity" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Category",  data: "report_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Type", data: "type_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Reseller", data: "ar_resellers" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User", data: "ar_endUser" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Status",data: "status_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Venue",  data: "ar_venue" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                        ];
                    }


                    if (projectCategory === "Solution Center per Product Line") {
                        columns = [

                            { title: "Activity Date", data: "ar_activityDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Engineer Name", data: "engr_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Details", data: "ar_activity" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Category", data: "report_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Type", data: "type_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Product Line", data: "ProductLine" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Reseller", data: "ar_resellers" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User", data: "ar_endUser" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Status", data: "status_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Venue", data: "ar_venue" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                        ];
                    }

                    if (projectCategory === "sTraCert") {
                        columns = [

                            { title: "Activity Date", data: "ar_activityDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Product Line", data: "ProductLine" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Engineer Name", data: "engr_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Details", data: "ar_activity" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Category", data: "report_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Type", data: "type_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Reseller", data: "ar_resellers" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User", data: "ar_endUser" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Status", data: "status_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Venue", data: "ar_venue" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                        ];
                    }

                    if (projectCategory === "Compiled Reports") {
                        columns = [

                            { title: "Activity Date", data: "ar_activityDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Project Name", data: "proj_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Reference #", data: "ar_refNo" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Engineer Name", data: "engr_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},

                            { title: "Time Expected", data: "expected_key_time" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Time Reported", data: "reported_key_time" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Time Exited", data: "exited_key_time" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Category", data: "report_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Details", data: "ar_activity" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Program", data: "program_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Product Line", data: "ProductLine" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Product Code", data: "ProductCode" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Resellers", data: "ar_resellers" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Resellers Contact", data: "ar_resellers_contact" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Resellers Phone/Email", data: "ar_resellers_phoneEmail" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User", data: "ar_endUser" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User Contact", data: "ar_endUser_contact" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User Location", data: "ar_endUser_loc" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End User Phone/Email", data: "ar_endUser_phoneEmail" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Customer Requirements", data: "ar_custRequirements" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Participants", data: "participant" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Position", data: "position" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},

                            { 
                                title: "Activity Done", 
                                data: "ar_activityDone", 
                                render: function(data, type, row) {
                                  const displayData = data ? data : 'N/A'; // 'N/A' is the default value if data is null
                                  return `<span class="truncate-text" title="${displayData}">${displayData}</span>`;
                                }
                              },
                            { title: "Agreements", data: "ar_agreements" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Target Date", data: "ar_targetDate" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},

                            { title: "Plan Details", data: "ar_details" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Owner", data: "ar_owner" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Activity Type", data: "type_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Exam Title", data: "ar_title" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Exam Name", data: "ar_examName" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Exam Take Status", data: "take_display" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Exam Score", data: "ar_score" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Exam Type", data: "exam_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Incentive Details", data: "incDetails_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Incentive Amount", data: "ar_incAmount" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Incentive Status", data: "incStatus_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Technology/Product Learned", data: "ar_prodLearned" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Training Name", data: "ar_trainingName" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Location", data: "ar_location" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Speaker", data: "ar_speakers" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Project Name", data: "ar_projName" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Compliance Percentage", data: "ar_compPercent" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},

                            { title: "Perfect Attendance", data: "ar_perfectAtt" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Memo Details", data: "ar_memoDetails" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Memo Issued Date", data: "ar_memoIssued" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},

                            { title: "Feedback On Engineer", data: "ar_feedbackEngr" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Feedback Rating", data: "ar_rating", render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},

                            { title: "Product Model (POC)", data: "ar_POCproductModel" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Asset/Code (POC)", data: "ar_POCassetOrCode" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Start Date (POC)", data: "ar_POCdateStart" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End Date (POC)", data: "ar_POCdateEnd" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},

                            { title: "Topic (sTraCert)", data: "ar_topic" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Start Date (sTraCert)", data: "ar_dateStart" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "End Date (sTraCert)", data: "ar_dateEnd" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},

                            { title: "Venue", data: "ar_venue" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Creator", data: "ar_requester" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Project Code", data: "proj_code" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                            { title: "Status", data: "status_name" , render: function(data, type, row) {
                                return data ? data : 'N/A'; // 'N/A' is the default value if data is null
                            }},
                        ];
                    }

                    if (projectCategory === "Compiled Reports") {
                        $('#project-table').DataTable(
                            {
                                scrollX: true,
                                data: response,
                                columns: columns,
                                dom: 'Bfrtip',
                                autoWidth: true,
                                createdRow: function(row, data, dataIndex) {
                                    // Add the highlight-hover class to each row
                                    $(row).addClass('highlight-hover');
                                },
                                buttons: [
                                    {
                                        extend: 'excel',
                                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                                        className: 'buttons-excel btn btn-success',
                                        filename: function () {
                                            var currentDate = new Date();
                                            var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                                            return 'ASA Compiled Reports - ' + formattedDate;
                                        }
                                    }
                                ],
                                });
                    }else{
                        $('#project-table').DataTable(
                            {
                                scrollX: true,
                                data: response,
                                columns: columns,
                                dom: 'Bfrtip',
                                autoWidth: true,
                                createdRow: function(row, data, dataIndex) {
                                    // Add the highlight-hover class to each row
                                    $(row).addClass('highlight-hover');
                                },
                                buttons: [
                                    {
                                        extend: 'print',
                                        text: '<i class="bi bi-printer"></i> Print',
                                        className: 'buttons-print btn btn-success',
                                        title: function () {
                                            var currentDate = new Date();
                                            var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                                            return 'ASA Report Analysis - ' + formattedDate;
                                        },
                                        customize: function (win) {
                                            // Add styles to the print view
                                            $(win.document.head).append('<style>head.dt-print-view h1 { text-align: center; padding: 2px; }</style>');
                                            // $(win.document.head).append('<style>table.dataTable th, table.dataTable td { word-wrap: break-word; }</style>');
                        
                                            // Remove DataTables default heading
                                            $(win.document.head).append('<style>.dt-print-view h1 { display: none; }</style>');
                        
                                            // Use an absolute path for the logo
                                            var imgSrc = "/assets/img/official-logo.png"; // Ensure the path is absolute
                                            console.log('Image path:', imgSrc);  // Debugging: Log the image path to console
                        
                                             // Image styling for fade effect and centering vertically and horizontally
                                             var imgStyle = 'position:fixed; top:50%; left:50%; transform: translate(-50%, -50%); max-width: 50%; max-height: 50%; opacity:0.2;';
                                                            
                                             // Prepend the image as a background to the body
                                             $(win.document.body).prepend('<img src="' + imgSrc + '" style="' + imgStyle + '" />');
                                            
                                            // Create an image element and set its source
                                            var img = new Image();
                                            img.src = imgSrc;
                                            img.style = imgStyle;
                        
                                            // Add load event listener to ensure the image is fully loaded
                                            img.onload = function() {
                                                console.log('Image loaded successfully');
                                                $(win.document.body).prepend(img.outerHTML);
                                            };
                        
                                            img.onerror = function() {
                                                console.error('Failed to load image:', imgSrc);
                                            };
                                            
                                            // Get the total row count
                                            var rowCount = $('#project-table').DataTable().rows().count();
                                            
                                            // Append total row count to every page
                                            $(win.document.body).prepend('<div id="row-count" style="position: absolute; top: 10px; right: 10px; font-size: 12px;">Total rows: ' + rowCount + '</div>');
                                            if (projectCategory === "DigiKnow") {
                                                var printTitle = '<div style="font-size: 20px; text-align: center;">DigiKnow Report</div>';
                                                $(win.document.body).prepend(printTitle);
                                            }else if (projectCategory === "DigiKnow Per Engineer") {
                                                var printTitle = '<div style="font-size: 20px; text-align: center;">DigiKnow Per Engineer Report</div>';
                                                $(win.document.body).prepend(printTitle);
                                            }
                                            else if (projectCategory === "DigiKnow Per Product Line") {
                                                 var printTitle = '<div style="font-size: 20px; text-align: center;">DigiKnow Per Product Line Report</div>';
                                                $(win.document.body).prepend(printTitle);
                                            }
                                            else if (projectCategory === "Project Progress Report") {
                                                 var printTitle = '<div style="font-size: 20px; text-align: center;">Project Progress Report</div>';
                                                $(win.document.body).prepend(printTitle);
                                            }
                                            else if (projectCategory === "Solution Center") {
                                                 var printTitle = '<div style="font-size: 20px; text-align: center;">Solution Center Report</div>';
                                                $(win.document.body).prepend(printTitle);
                                            }
                                            else if (projectCategory === "Solution Center per Product Line") {
                                                 var printTitle = '<div style="font-size: 20px; text-align: center;">Solution Center per Product Line Report</div>';
                                                $(win.document.body).prepend(printTitle);
                                            }
                                            else if (projectCategory === "sTraCert") {
                                                var printTitle = '<div style="font-size: 20px; text-align: center;">sTraCert Report</div>';
                                                $(win.document.body).prepend(printTitle);
                                            }
                                           
                        
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
                                                .css({
                                                    'word-wrap': 'break-word',
                                                    'white-space': 'normal'
                                                });
                                        }
                                    },
                                    {
                                        extend: 'excel',
                                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                                        className: 'buttons-excel btn btn-success',
                                        filename: function () {
                                            var currentDate = new Date();
                                            var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                                            return 'ASA Report Analysis - ' + formattedDate;
                                        }
                                    }
                                ],
                                initComplete: function() {                     
                                    // Adjust buttons style and size to match Bootstrap's success and primary buttons
                                    $('.buttons-excel').each(function() {
                                        $(this).removeClass('dt-button')
                                               .addClass('btn')
                                               .css({
                                                   'padding': '0.375rem 0.75rem',
                                                   'font-size': '1rem',
                                                   'border-radius': '2px',
                                                   'margin-left' : '5px'
                                               });
                                    });
                                },
                                });
                    }
                  

                },
                error: function (xhr, status, error) {
                    console.error('Error:', xhr.responseText);

                    // Hide loading animation on error
                    $('#loading').hide();
                }
            });
        }
    });
});

