var originalReferenceNumber;

// var table = $('#exampleModal').DataTable({});

// Store the original reference number when the modal is opened
$('#exampleModal').on('show.bs.modal', function () {
    originalReferenceNumber = $('#reference_no .reference_no').text();
    originalReferenceNumber = $('#Ref_No').val();
});

$('#exampleModal').on('hidden.bs.modal', function () {
    $('#reference_no .reference_no').text(originalReferenceNumber);
    $('#Ref_No').val(originalReferenceNumber);
});

$('#exampleModal').on('hidden.bs.modal', function () {
    $('#exampleModal').on('hidden.bs.modal', function () {
        $('#projecttype').hide();
        $('#projectname').hide();
        $('#completion_acceptance').hide();
        $('#SentToClient').prop('disabled', true);

    });

});

//////////////////// Check if Report Name is Isupport Upon Opening Modal /////////////////////////
$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        const reportValue = document.querySelector('#reportDropdown1').value.replace(/\//g, '_');


        if ((reportValue === 'iSupport Services' || reportValue === '2')) {

            $('#projecttype').show();
            $('#projectname').show();
            // $('#completion_acceptance').show();

            
            $('#reportDropdown1').prop('disabled', true);
            $('#statusDropdown1').prop('disabled', true);
            $('#projtype_button1').prop('disabled', true);
            $('#myDropdown1').prop('disabled', true);
        }

       

    });
});

$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        const statusValue = $('#statusDropdown1').val();
        const reportValue = document.querySelector('#reportDropdown1').value.replace(/\//g, '_');
        console.log(statusValue);
        console.log(reportValue);

        if (statusValue === 'Completed' && 
            (reportValue !== 'Skills Development' && reportValue !== '7' && 
            reportValue !== 'Others' && reportValue !== '8')) {

            $('#completion_acceptance').show();

        } else {
            $('#completion_acceptance').hide();
        }
});
});


//////////////////////////////////////// Disable Project Name and Project Type ///////////////////////////
document.getElementById('reportDropdown1').addEventListener('change', function () {
    var reportValue = this.value;

    // Check if the selected report is 'iSupport Services'
    if (reportValue === 'iSupport Services' || reportValue === '2') {
        console.log("Report Status:", reportValue);
        $('#projecttype').show();
        $('#projectname').show();
    } else {
        // Disable the other two buttons
        $('#projecttype').hide();
        $('#projectname').hide();

        $("#projtype_button1").val("");
        $('#myDropdown1').empty();
    }
});
$(document).ready(function () {
    // Initialize Select2 inside the modal
    $('#exampleModal').on('shown.bs.modal', function () {
        $('#myDropdown1').select2({
            width: '100%',
            dropdownParent: $('#exampleModal .modal-content'),
        });

        // Fetch project names when modal opens
        var projectType = $('#projtype_button1').val(); // Get project type
        console.log("Selected Project Type on Modal Open: ", projectType);

        var projecttypenumber = 0;
        if (projectType === "Implementation") {
            projecttypenumber = 1;
        } else if (projectType === "Maintenance Agreement") {
            projecttypenumber = 2;
        }

        console.log("Project Type Number on Modal Open: ", projecttypenumber);

        if (projecttypenumber > 0) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            console.log("Making AJAX Request to fetch project names...");

            // Make AJAX request
            $.ajax({
                url: '/tab-activity/create-activity/getProjectName',
                type: 'GET',
                data: { projecttypenumber: projecttypenumber },
                success: function (response) {
                    console.log("AJAX Response:", response);

                    // Clear and populate dropdown
                    $('#myDropdown1').empty().append('<option value="">-- Select a Project --</option>');

                    if (Array.isArray(response) && response.length > 0) {
                        let matchedId = null; // To store the ID that matches the saved project name
                        const savedProjectName = $('#selectedProjectId').val(); // Get saved project name
                        console.log("Saved Project Name: ", savedProjectName);

                        $.each(response, function (index, value) {
                            // Append options to dropdown
                            $('#myDropdown1').append('<option value="' + value.id + '">' + value.proj_name + '</option>');

                            // Check if the current project's name matches the saved name
                            if (value.proj_name === savedProjectName) {
                                matchedId = value.id; // Store the matching ID
                            }
                        });

                        // Set the matching ID as selected if found
                        if (matchedId) {
                            $('#myDropdown1').val(matchedId).trigger('change');
                            console.log("Matched ID set as selected: ", matchedId);
                        } else {
                            console.warn("No match found for the saved project name.");
                        }
                    } else {
                        console.error("No valid projects returned or empty array.");
                        $('#myDropdown1').html('<option>No projects available</option>');
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.error("Response Text:", xhr.responseText);
                    $('#myDropdown1').html('<option>Error loading projects</option>');
                    $('#myDropdown1').prop('disabled', true);
                }
            });
        } else {
            console.log("No valid project type selected.");
            $('#myDropdown1').empty().append('<option value="">-- Select a Project --</option>');
            $('#myDropdown1').prop('disabled', true);
        }
    });

    // Handle change event for project type
    $('#projtype_button1').change(function () {
        let projectType = $(this).val();
        console.log("Selected Project Type:", projectType);
    
        let projecttypenumber = (projectType === "Implementation") ? 1 : 
                                (projectType === "Maintenance Agreement") ? 2 : 0;
    
        if (projecttypenumber > 0) {
            console.log("Fetching projects for type:", projecttypenumber);
            
            $.ajax({
                url: '/tab-activity/create-activity/getProjectName',
                type: 'GET',
                data: { projecttypenumber: projecttypenumber },
                success: function (response) {
                    console.log("AJAX Response:", response);
    
                    $('#myDropdown1').empty().append('<option value="">-- Select a Project --</option>');
    
                    if (Array.isArray(response) && response.length > 0) {
                        let matchedId = null;
                        const savedProjectName = $('#selectedProjectId').val().trim().toLowerCase();
    
                        $.each(response, function (index, value) {
                            let projName = value.proj_name.trim().toLowerCase();
                            $('#myDropdown1').append('<option value="' + value.id + '">' + value.proj_name + '</option>');
    
                            if (projName === savedProjectName) {
                                matchedId = value.id;
                            }
                        });
    
                        if (matchedId) {
                            $('#myDropdown1').val(matchedId).trigger('change');
                            console.log("Matched Project Selected:", matchedId);
                        } else {
                            console.warn("No exact match for saved project.");
                        }
                    } else {
                        console.error("No valid projects returned.");
                        $('#myDropdown1').html('<option>No projects available</option>');
                    }
    
                    $('#myDropdown1').prop('disabled', response.length === 0);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error);
                    console.error("Response Text:", xhr.responseText);
                    $('#myDropdown1').html('<option>Error loading projects</option>').prop('disabled', true);
                }
            });
        } else {
            console.log("No valid project type selected.");
            $('#myDropdown1').empty().append('<option value="">-- Select a Project --</option>').prop('disabled', true);
        }
    });

    // Handle change event for the project dropdown
    $('#myDropdown1').change(function () {
        const selectedProjectId = $(this).val(); // Get the selected project ID
        $('#selectedProjectId').val(selectedProjectId); // Update hidden input value
        console.log('Selected Project ID:', selectedProjectId); // Debugging
    });
});

////////////////////////// Select2 Engineer //////////////////////////////////

$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        $('#engineers_modal, #engineers_modal_two, #Copy_to').select2({
            width: '100%',
            dropdownParent: $('#exampleModal .modal-content'),
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


////////////////////////// Select2 Time Reported //////////////////////////////////
$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        // Initialize Select2 for the time_reported dropdown
        $('#time_reported1').select2({
            width: '100%',
            dropdownParent: $('#exampleModal .modal-content'),
            ajax: {
                url: '/tab-activity/create-activity/getTime_update',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term, // Pass the search term to the server
                    };
                },
                processResults: function (response) {
                    if (Array.isArray(response.data)) {
                        // Filter and sort times
                        const filteredData = response.data.filter(time => isAfterOrEqualTo('6:00 AM', time) || isBeforeOrEqualTo('5:30 AM', time));
                        filteredData.sort((a, b) => sortTimes(a, b)); // Custom sorting

                        // Map the array data to Select2 format
                        return {
                            results: filteredData.map(function (getTime) {
                                return {
                                    id: getTime,
                                    text: getTime
                                };
                            })
                        };
                    }
                }
            }
        });

        // Initialize Select2 for the time_exited dropdown
        $('#time_exited1').select2({
            width: '100%',
            dropdownParent: $('#exampleModal .modal-content'),
            ajax: {
                url: '/tab-activity/create-activity/getTime_update',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term, // Pass the search term to the server
                    };
                },
                processResults: function (response) {
                    if (Array.isArray(response.data)) {
                        // Filter and sort times
                        const filteredData = response.data.filter(time => isAfterOrEqualTo('6:00 AM', time) || isBeforeOrEqualTo('5:30 AM', time));
                        filteredData.sort((a, b) => sortTimes(a, b)); // Custom sorting

                        // Filter out times before or equal to the selected time
                        const selectedTime = $('#time_reported1').val();
                        const filteredDataForExited = filteredData.filter(time => !isBeforeOrEqualToSelectedTime(time, selectedTime));

                        // Map the filtered array data to Select2 format
                        return {
                            results: filteredDataForExited.map(function (getTime) {
                                return {
                                    id: getTime,
                                    text: getTime
                                };
                            })
                        };
                    }
                }
            }
        });

        // Listen for changes on the time_reported1 dropdown
        $('#time_reported1').on('change', function () {
            const selectedTime = $('#time_reported1').val();
            updateTimeExitedDropdown(selectedTime);
        });

        // Listen for changes on the time_exited1 dropdown
        $('#time_exited1').on('change', function () {
            const selectedTime = $('#time_exited1').val();
            updateTimeReportedDropdown(selectedTime);
        });

        function updateTimeExitedDropdown(selectedTime) {
            $('#time_exited1').select2({
                width: '100%',
                dropdownParent: $('#exampleModal .modal-content'),
                ajax: {
                    url: '/tab-activity/create-activity/getTime_update',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            term: params.term, // Pass the search term to the server
                        };
                    },
                    processResults: function (response) {
                        if (Array.isArray(response.data)) {
                            // Filter and sort times
                            const filteredData = response.data.filter(time => isAfterOrEqualTo('6:00 AM', time) || isBeforeOrEqualTo('5:30 AM', time));
                            filteredData.sort((a, b) => sortTimes(a, b)); // Custom sorting

                            // Filter out times before or equal to the selected time
                            const filteredDataForExited = filteredData.filter(time => !isBeforeOrEqualToSelectedTime(time, selectedTime));

                            // Map the filtered array data to Select2 format
                            return {
                                results: filteredDataForExited.map(function (getTime) {
                                    return {
                                        id: getTime,
                                        text: getTime
                                    };
                                })
                            };
                        }
                    }
                }
            });
        }

        function updateTimeReportedDropdown(selectedTime) {
            $('#time_reported1').select2({
                width: '100%',
                dropdownParent: $('#exampleModal .modal-content'),
                ajax: {
                    url: '/tab-activity/create-activity/getTime_update',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            term: params.term, // Pass the search term to the server
                        };
                    },
                    processResults: function (response) {
                        if (Array.isArray(response.data)) {
                            // Filter and sort times
                            const filteredData = response.data.filter(time => isAfterOrEqualTo('6:00 AM', time) || isBeforeOrEqualTo('5:30 AM', time));
                            filteredData.sort((a, b) => sortTimes(a, b)); // Custom sorting

                            // Filter out times after or equal to the selected time
                            const filteredDataForReported = filteredData.filter(time => !isAfterOrEqualToSelectedTime(time, selectedTime));

                            // Map the filtered array data to Select2 format
                            return {
                                results: filteredDataForReported.map(function (getTime) {
                                    return {
                                        id: getTime,
                                        text: getTime
                                    };
                                })
                            };
                        }
                    }
                }
            });
        }

        function isAfterOrEqualTo(startTime, time) {
            return convertToMinutes(time) >= convertToMinutes(startTime);
        }

        function isBeforeOrEqualTo(endTime, time) {
            return convertToMinutes(time) <= convertToMinutes(endTime);
        }

        function isBeforeOrEqualToSelectedTime(time, selectedTime) {
            return convertToMinutes(time) <= convertToMinutes(selectedTime);
        }

        function isAfterOrEqualToSelectedTime(time, selectedTime) {
            return convertToMinutes(time) >= convertToMinutes(selectedTime);
        }

        function sortTimes(a, b) {
            const aMinutes = convertToMinutes(a);
            const bMinutes = convertToMinutes(b);

            // Determine if time is in AM range to be sorted at the end
            const isAMTime = time => convertToMinutes(time) < convertToMinutes('6:00 AM');

            // Place times before 6:00 AM at the end
            if (isAMTime(a) && !isAMTime(b)) return 1;
            if (!isAMTime(a) && isAMTime(b)) return -1;

            // Standard chronological sorting
            if (aMinutes < bMinutes) return -1;
            if (aMinutes > bMinutes) return 1;

            return 0;
        }

        function convertToMinutes(time) {
            const [timeStr, period] = time.split(' ');
            let [hours, minutes] = timeStr.split(':').map(Number);
            if (period === 'PM' && hours !== 12) {
                hours += 12;
            }
            if (period === 'AM' && hours === 12) {
                hours = 0;
            }
            return hours * 60 + minutes;
        }
    });
});



////////////////////////// Select2 Time Expected //////////////////////////////////


$(document).ready(function () {
    $('#exampleModal').on('shown.bs.modal', function () {
        // Initialize Select2 for the time_reported dropdown
        $('#time_expected1').select2({
            width: '100%',
            dropdownParent: $('#exampleModal .modal-content'),
            ajax: {
                url: '/tab-activity/create-activity/getTime_update',
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term, // Pass the search term to the server
                    };
                },
                processResults: function (response) {
                    // Check if response is an array
                    if (Array.isArray(response.data)) {
                        // Map the array data to Select2 format
                        return {
                            results: response.data.map(function (getTime) {
                                return {
                                    id: getTime,
                                    text: getTime
                                };
                            })
                        };
                    }
                }
            }
        })
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
///////////////////////////// Disable Formfields in Display ///////////////////////////
$(document).ready(function () {
    // Function to toggle the disabled attribute of input fields
    function toggleInputs(disabled) {
        // Toggle inputs except #act_details_requester and keep #product_code always disabled
        $('.modal-body input:not(#act_details_requester):not(#product_code), .modal-body textarea, .modal-body select, #ActionPlan_Recommendation button, #participantAndPositionContainer button')
            .prop('disabled', disabled);
    
        // Ensure #product_code stays disabled
        $('#product_code').prop('disabled', true);
    }

    // Function to toggle visibility of buttons
    function toggleButtons(editMode) {
        if (editMode) {
            // Show save and cancel buttons
            $('#saveButton, #cancelButton').show();
            // Hide forward and clone buttons
            $('#forwardButton2, #cloneButton, #editbutton, #saveCloneButton').hide();
        } else {
            // Show forward and clone buttons
            $('#forwardButton2, #cloneButton, #editbutton').show();
            // Hide save and cancel buttons
            $('#saveButton, #cancelButton, #saveCloneButton').hide();
        }
    }

    function cloneButton(cloneMode) {
        if (cloneMode) {
            $('#forwardButton2, #cloneButton, #editbutton, #saveButton ').hide();
            // Show save Clone Button
            $('#saveCloneButton, #cancelButton').show();
        }
    }


    // Show modal event
    $('#exampleModal').on('shown.bs.modal', function () {
        // Disable input fields initially

        toggleInputs(true);
        // Show forward and clone buttons
        toggleButtons(false);
    });

    // Edit button click event
    $('#editbutton').click(function () {

        toggleInputs(false); // Enable inputs
        toggleButtons(true); // Show save and cancel buttons

        $('#completion_acceptance').hide();


        //Enable the report name and report status dropdown
        $('#reportDropdown1').prop('disabled', false);
        $('#statusDropdown1').prop('disabled', false);

        $('#projtype_button1').prop('disabled', false);
        $('#myDropdown1').prop('disabled', false);
    
       

    });

    // Edit button click event
    $('#forwardButton2').click(function () {

        // Toggle the disabled attribute of input fields
        toggleInputs(false); // Enable inputs
        // toggleButtons(true); // Show save and cancel buttons

    });

    $('#completion_acceptance').click(function () {


        toggleInputs(false); // Enable inputs


    });




    // Edit button click event
    $('#cloneButton').click(function () {
        // Toggle the disabled attribute of input fields
        toggleInputs(false); // Enable inputs
        cloneButton(true); // Show clone, save and cancel buttons


        //Enable the report name and report status dropdown
        $('#reportDropdown1').prop('disabled', false);
        $('#statusDropdown1').prop('disabled', false);

        $('#projtype_button1').prop('disabled', false);
        $('#myDropdown1').prop('disabled', false);



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Send AJAX request to the controller
        $.ajax({
            url: '/tab-activity/index/getcloneReference',  // update this URL as per your route
            type: 'GET',
            success: function (response) {
                console.log('Response from server:', response);
                $('#reference_no .reference_no').text(response);
                $('#Ref_No').val(response);

            },
            error: function (xhr, status, error) {

                console.error('AJAX error:', status, error);
            }
        });

    });



    // Cancel button click event
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
    
                toggleInputs(true); // Disable inputs
                toggleButtons(false); // Show forward and clone buttons
    
                // Enable the report name and report status dropdown
                $('#reportDropdown1').prop('disabled', true);
                $('#statusDropdown1').prop('disabled', true);
    
                $('#projtype_button1').prop('disabled', true);
                $('#myDropdown1').prop('disabled', true);
    
                // Revert back to the original reference number
                $('#reference_no .reference_no').text(originalReferenceNumber);
                $('#Ref_No').val(originalReferenceNumber);
            }
        });
    });
});

$(document).ready(function () {

    $("#saveButton").off("click").on("click", function () {


        if (validateFormData()) {

            $("#loading-overlay").show();

            /// Report Details 
            ///////////////////// 1st phase  Header //////////////////////////
            var report = $('#reportDropdown1').val();
            var status = $('#statusDropdown1').val();
            var projtype = $('#projtype_button1').val();
            var projname = $('#myDropdown1  option:selected').text().trim();
            var projnameID = $('#selectedProjectId').val();
            var reference_num = $('#reference_no .reference_no').text();

            ///////////////////// 2nd phase Activity Details //////////////////////////
            var act_details = $('#Activity_details').val();
            console.log("aCTIVITY: ", act_details);
            var act_details_req = $('#act_details_requester').val();
            var product_engr = $('#engineers_modal option:selected')
                .map(function () {
                    return $(this).text().trim();
                })
                .get()
                .join(', ');
            console.log("Product Engineer:", product_engr)
            var date_filed = $('#Date_Filed').val();
            var act_details_activity = $('#act_details_activity').val();
            // var copy_to = $('#Copy_to').val();

            var copy_to = $('#Copy_to option:selected')
                .map(function () {
                    return $(this).text().trim();
                })
                .get()
                .join(', ');
            console.log("Copy To:", copy_to)

            var date_needed = $('#Date_Needed').val();
            var special_instr = $('#special_instruction').val();

            ///////////////////// 3rd phase Contract Details//////////////////////////

            var reseller = $('#Reseller').val();
            var reseller_contact = $('#reseller_contact_info').val();
            var reseller_phone_email = $('#reseller_phone_email').val();
            var enduser_name = $('#end_user_name').val();
            var enduser_contact = $('#end_user_contact').val();
            var enduser_email = $('#end_user_email').val();
            var enduser_location = $('#end_user_loc').val();

            ///////////////////// 4th phase Activity Summary Report //////////////////////////

            var Act_date = $('#act_date').val();
            var Activity_type = $('#Activity_Type').val();
            var Program = $('#program').val();

            // Assuming Product_line is an array
            var Product_line = $('#product_line').val();

            // Trim each element in the array
            for (var i = 0; i < Product_line.length; i++) {
                Product_line[i] = Product_line[i].trim();
            }

            var Time_expected1 = $('#time_expected1').val();
            var Time_reported1 = $('#time_reported1').val();
            var Time_exited1 = $('#time_exited1').val();

            var engineer_name = $('#engineers_modal_two').val();

            var Venue = $('#venue').val();
            var Send_copy_to = $('#sendcopyto').val();

            var formData = [];
            $(".participantposition").each(function () {
                var participant = $(this).find(".participant").val();
                var position = $(this).find(".position").val();
                if (participant !== undefined && position !== undefined && participant !== "" && position !== "") {
                    formData.push({ participant: participant, position: position });
                }
            });

            ///////////////////// 5th phase Activity Summary Report //////////////////////////

            var customer_req = $('#customerReqfield').val();
            var Activity_Done = $('#activity_donefield').val();
            var Agreements = $('#Agreementsfield').val();

            ///////////////////// 6th phase Activity Summary Report //////////////////////////

            var ActionPlanRecommendation = [];
            $(".actionplan").each(function () {
                var plantarget = $(this).find(".PlanTarget").val();
                var details = $(this).find(".Details").val();
                var planowner = $(this).find(".PlanOwner").val();
                if (plantarget !== undefined && details !== undefined && planowner !== undefined
                    && plantarget !== "" && details !== "" && planowner !== "") {
                    ActionPlanRecommendation.push({ plantarget: plantarget, details: details, planowner: planowner });
                }
            });

            // Stracert
            var straCert_TopicName = $('#stra_topicName').val();
            var straCert_DateStart = $('#stra_dateStart').val();
            var straCert_DateEnd = $('#stra_dateEnd').val();
            console.log("Topic Name:", straCert_TopicName);
            console.log("Date Start:", straCert_DateStart);
            console.log("Date End:", straCert_DateEnd);

            // POC
            var productModel = $('#modal_prodModel').val();
            var assetCode = $('#modal_assetCode').val();
            var poc_dateStart = $('#modal_poc_dateStart').val();
            var poc_dateEnd = $('#modal_poc_dateEnd').val();

            // Technical Cert
            var tech_Title = $('#modal_title').val();
            var tech_examCode = $('#modal_examCode').val();
            var tech_status = $('#modal_takeStatusDropdown').val();
            var tech_ScoreDropdown = $('#modal_scoreDropdown').val();
            var tech_examType = $('#modal_examTypeDropdown').val();
            var tech_incStatus = $('#modal_incentiveStatusDropdown').val();
            var tect_incDetails = $('#modal_incentiveDetailsDropdown').val();
            var tech_examAmount = $('#modal_amount').val();

            // Technology
            var Tech_ProdLearned = $('#modal_techprodLearned').val();

            // Skills Dev
            var skills_trainingName = $('#modal_trainingName').val();
            var skills_speaker = $('#modal_speaker').val();
            var skills_location = $('#modal_location').val();
            var skill_bpcheckBox = $('#bpCheckbox').is(':checked') ? 1 : 0;
            var skills_eucheckbox = $('#euCheckbox').is(':checked') ? 1 : 0;
            var skill_msicheckbox = $('#MSICheckbox').is(':checked') ? 1 : 0;

            // DigiKnow
            var Digi_flyers = $('#modal_digiknowFlyersattachment').val();
            var bp_digiCheckbox = $('#modal_bpDigiCheckbox').is(':checked') ? 1 : 0;
            var eu_digiCheckbox = $('#modal_euDigiCheckbox').is(':checked') ? 1 : 0;

            // Internal Proj
            var internal_Msi = $('#modal_MSIProjName').val();
            var internal_Percent = $('#modal_CompliancePercentage').val();
            var internal_Attendance = $('#modalperfectAttendance').val();

            // Memo
            var memo_Issued = $('#modal_memoIssued').val();
            var memo_Details = $('#modal_memoDetails').val();

            // Feedback
            var engr_feedback = $('#modal_engrFeedbackInput').val();
            var engr_rating = $('#modal_other_rating').val();

            // T2R
            var T2R_topic = $('#modal_topicName').val();
            var T2R_datestart = $('#modal_dateStart').val();
            var T2R_dateEnd = $('#modal_dateEnd').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // console.log('Report Status: ', status );
            // Make the first AJAX request
            $.ajax({
                type: 'POST',
                url: '/tab-activity/index/editModal',
                data: {
                    report: report,
                    status: status,
                    projname: projname,
                    projnameID: projnameID,
                    projtype: projtype,
                    reference_num: reference_num,

                    act_details: act_details,
                    act_details_req: act_details_req,
                    product_engr: product_engr,
                    copy_to: copy_to,
                    date_filed: date_filed,
                    act_details_activity: act_details_activity,
                    date_needed: date_needed,
                    special_instr: special_instr,

                    reseller: reseller,
                    reseller_contact: reseller_contact,
                    reseller_phone_email: reseller_phone_email,
                    enduser_name: enduser_name,
                    enduser_contact: enduser_contact,
                    enduser_email: enduser_email,
                    enduser_location: enduser_location,

                    Act_date: Act_date,
                    Activity_type: Activity_type,
                    Program: Program,
                    Product_line: Product_line,
                    Time_expected1: Time_expected1,
                    Time_reported1: Time_reported1,
                    Time_exited1: Time_exited1,
                    engineer_name: engineer_name,
                    Venue: Venue,
                    Send_copy_to: Send_copy_to,

                    formData: formData,

                    customer_req: customer_req,
                    Activity_Done: Activity_Done,
                    Agreements: Agreements,

                    ActionPlanRecommendation: ActionPlanRecommendation,

                    ////////////////Stracert/////////////////////////
                    Stra_TopicName: straCert_TopicName,
                    Stra_DateStart: straCert_DateStart,
                    Stra_DateEnd: straCert_DateEnd,

                    /////////////POC///////////////////////////////
                    POC_ProdModel: productModel,
                    POC_AssetCode: assetCode,
                    POC_DateStart: poc_dateStart,
                    POC_DateEnd: poc_dateEnd,

                    /////////////Technology Certificate///////////////////////////////
                    Tech_Title: tech_Title,
                    Tech_examCode: tech_examCode,
                    Tech_status: tech_status,
                    Tech_ScoreDropdown: tech_ScoreDropdown,
                    Tech_examType: tech_examType,
                    Tech_incStatus: tech_incStatus,
                    Tect_incDetails: tect_incDetails,
                    Tech_examAmount: tech_examAmount,

                    /////////////////Tech Learned/////////////////////////////
                    Tech_ProdLearned: Tech_ProdLearned,

                    ////////////////////Skills Development///////////////////////
                    Skills_trainingName: skills_trainingName,
                    Skills_speaker: skills_speaker,
                    Skills_location: skills_location,
                    Skill_bpcheckBox: skill_bpcheckBox,
                    Skills_eucheckbox: skills_eucheckbox,
                    Skill_msicheckbox: skill_msicheckbox,

                    // Digiknow
                    Digi_flyers: Digi_flyers,
                    Bp_digiCheckbox: bp_digiCheckbox,
                    Eu_digiCheckbox: eu_digiCheckbox,

                    ////Internal
                    Internal_Msi: internal_Msi,
                    Internal_Percent: internal_Percent,
                    Internal_Attendance: internal_Attendance,

                    // Memo
                    Memo_Issued: memo_Issued,
                    Memo_Details: memo_Details,

                    // Feedback
                    Engr_feedback: engr_feedback,
                    Engr_rating: engr_rating,

                    // T2R
                    T2R_topic: T2R_topic,
                    T2R_datestart: T2R_datestart,
                    T2R_dateEnd: T2R_dateEnd,
                },
                success: function (response) {
                    console.log('Response from server:', response);
                    if (response.ar_id) {
                        console.log('Generated ar_id:', response.ar_id);

                        // Define a function to handle file uploads
                        function handleFileUpload(fileInputId, url, callback) {
                            var file_data = $(fileInputId).prop('files');
                            console.log('File data:', file_data);

                            if (file_data && file_data.length > 0) {
                                var form_data = new FormData();
                                form_data.append('ar_id', response.ar_id);

                                for (var i = 0; i < file_data.length; i++) {
                                    form_data.append('file_data[]', file_data[i]);
                                }

                                // Log FormData entries
                                form_data.forEach(function (value, key) {
                                    console.log(key, value);
                                });

                                // Make the AJAX request
                                $.ajax({
                                    url: url,
                                    dataType: 'text',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: form_data,
                                    type: 'post',
                                    success: function (output) {
                                        console.log('Response from server:', output);
                                        if (callback) callback();
                                    },
                                    error: function (xhr, status, error) {
                                        console.error('Error:', error);
                                        $("#loading-overlay").hide();
                                        Swal.fire({ text: "Error saving files.", icon: "error" });
                                    }
                                });
                            } else {
                                console.log('No files uploaded.');
                                if (callback) callback();
                            }
                        }

                        // Define a function to handle the final success message
                        function finalSuccessMessage() {
                            $("#loading-overlay").hide();
                            Swal.fire({ text: "Saved successfully!", icon: "success" });
                            $('#exampleModal').modal('hide');
                            location.reload();
                        }

                        // Counter to keep track of completed uploads
                        var uploadCounter = 0;
                        var totalUploads = 2; // Number of file upload inputs

                        // Callback function to check if all uploads are done
                        function uploadCallback() {
                            uploadCounter++;
                            if (uploadCounter === totalUploads) {
                                finalSuccessMessage();
                            }
                        }

                        // Handle the first file upload scenario
                        handleFileUpload('#upload_file', '/tab-activity/index/editImage', uploadCallback);

                        // Handle the second file upload scenario
                        handleFileUpload('#modal_digiknowFlyersattachment', '/tab-activity/index/editDigiknowImage', uploadCallback);
                    } else {
                        $("#loading-overlay").hide();
                        Swal.fire({ text: "Saved successfully!", icon: "success" });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    $("#loading-overlay").hide();
                    Swal.fire({ text: "Error Saving data", icon: "error" });
                }
            });
        }
    });
});

$('#exampleModal').on('shown.bs.modal', function () {
    // Reset the file inputs
    $('#upload_file').val('');
    $('#modal_digiknowFlyersattachment').val('');
});

$(document).ready(function () {

    $("#saveCloneButton").off("click").on("click", function () {
        if (validateFormData()) {
            $("#loading-overlay").show();

            /// Report Details 
            ///////////////////// 1st phase  Header //////////////////////////
            var report = $('#reportDropdown1').val();
            var status = $('#statusDropdown1').val();
            var projtype = $('#projtype_button1').val();
            var projname = $('#myDropdown1  option:selected').text().trim();
            var projnameID = $('#selectedProjectId').val();
            var reference_num = $('#reference_no .reference_no').text();

            ///////////////////// 2nd phase Activity Details //////////////////////////
            var act_details = $('#Activity_details').val();
            console.log("aCTIVITY: ", act_details);
            var act_details_req = $('#act_details_requester').val();
            var product_engr = $('#engineers_modal option:selected')
                .map(function () {
                    return $(this).text().trim();
                })
                .get()
                .join(', ');
            console.log("Product Engineer:", product_engr)
            var date_filed = $('#Date_Filed').val();
            var act_details_activity = $('#act_details_activity').val();
            // var copy_to = $('#Copy_to').val();

            var copy_to = $('#Copy_to option:selected')
                .map(function () {
                    return $(this).text().trim();
                })
                .get()
                .join(', ');
            console.log("Copy To:", copy_to)

            var date_needed = $('#Date_Needed').val();
            var special_instr = $('#special_instruction').val();

            ///////////////////// 3rd phase Contract Details//////////////////////////

            var reseller = $('#Reseller').val();
            var reseller_contact = $('#reseller_contact_info').val();
            var reseller_phone_email = $('#reseller_phone_email').val();
            var enduser_name = $('#end_user_name').val();
            var enduser_contact = $('#end_user_contact').val();
            var enduser_email = $('#end_user_email').val();
            var enduser_location = $('#end_user_loc').val();

            ///////////////////// 4th phase Activity Summary Report //////////////////////////

            var Act_date = $('#act_date').val();
            var Activity_type = $('#Activity_Type').val();
            var Program = $('#program').val();

            // Assuming Product_line is an array
            var Product_line = $('#product_line').val();

            // Trim each element in the array
            for (var i = 0; i < Product_line.length; i++) {
                Product_line[i] = Product_line[i].trim();
            }

            var Time_expected1 = $('#time_expected1').val();
            var Time_reported1 = $('#time_reported1').val();
            var Time_exited1 = $('#time_exited1').val();

            var engineer_name = $('#engineers_modal_two').val();

            var Venue = $('#venue').val();
            var Send_copy_to = $('#sendcopyto').val();

            var formData = [];
            $(".participantposition").each(function () {
                var participant = $(this).find(".participant").val();
                var position = $(this).find(".position").val();
                if (participant !== undefined && position !== undefined && participant !== "" && position !== "") {
                    formData.push({ participant: participant, position: position });
                }
            });

            console.log("Data:", formData);

            ///////////////////// 5th phase Activity Summary Report //////////////////////////

            var customer_req = $('#customerReqfield').val();
            var Activity_Done = $('#activity_donefield').val();
            var Agreements = $('#Agreementsfield').val();

            console.log("Customer:", customer_req);
            console.log("Activity Done:", Activity_Done);
            console.log("Agreements:", Agreements);

            ///////////////////// 6th phase Activity Summary Report //////////////////////////

            var ActionPlanRecommendation = [];
            $(".actionplan").each(function () {
                var plantarget = $(this).find(".PlanTarget").val();
                var details = $(this).find(".Details").val();
                var planowner = $(this).find(".PlanOwner").val();
                if (plantarget !== undefined && details !== undefined && planowner !== undefined
                    && plantarget !== "" && details !== "" && planowner !== "") {
                    ActionPlanRecommendation.push({ plantarget: plantarget, details: details, planowner: planowner });
                }
            });

            // Stracert
            var straCert_TopicName = $('#stra_topicName').val();
            var straCert_DateStart = $('#stra_dateStart').val();
            var straCert_DateEnd = $('#stra_dateEnd').val();
            console.log("Topic Name:", straCert_TopicName);
            console.log("Date Start:", straCert_DateStart);
            console.log("Date End:", straCert_DateEnd);

            // POC
            var productModel = $('#modal_prodModel').val();
            var assetCode = $('#modal_assetCode').val();
            var poc_dateStart = $('#modal_poc_dateStart').val();
            var poc_dateEnd = $('#modal_poc_dateEnd').val();

            // Technical Cert
            var tech_Title = $('#modal_title').val();
            var tech_examCode = $('#modal_examCode').val();
            var tech_status = $('#modal_takeStatusDropdown').val();
            var tech_ScoreDropdown = $('#modal_scoreDropdown').val();
            var tech_examType = $('#modal_examTypeDropdown').val();
            var tech_incStatus = $('#modal_incentiveStatusDropdown').val();
            var tect_incDetails = $('#modal_incentiveDetailsDropdown').val();
            var tech_examAmount = $('#modal_amount').val();

            // Technology
            var Tech_ProdLearned = $('#modal_techprodLearned').val();

            // Skills Dev
            var skills_trainingName = $('#modal_trainingName').val();
            var skills_speaker = $('#modal_speaker').val();
            var skills_location = $('#modal_location').val();
            var skill_bpcheckBox = $('#bpCheckbox').is(':checked') ? 1 : 0;
            var skills_eucheckbox = $('#euCheckbox').is(':checked') ? 1 : 0;
            var skill_msicheckbox = $('#MSICheckbox').is(':checked') ? 1 : 0;

            // DigiKnow
            var Digi_flyers = $('#modal_digiknowFlyersattachment').val();
            var bp_digiCheckbox = $('#modal_bpDigiCheckbox').is(':checked') ? 1 : 0;
            var eu_digiCheckbox = $('#modal_euDigiCheckbox').is(':checked') ? 1 : 0;

            // Internal Proj
            var internal_Msi = $('#modal_MSIProjName').val();
            var internal_Percent = $('#modal_CompliancePercentage').val();
            var internal_Attendance = $('#modalperfectAttendance').val();

            // Memo
            var memo_Issued = $('#modal_memoIssued').val();
            var memo_Details = $('#modal_memoDetails').val();

            // Feedback
            var engr_feedback = $('#modal_engrFeedbackInput').val();
            var engr_rating = $('#modal_other_rating').val();

            // T2R
            var T2R_topic = $('#modal_topicName').val();
            var T2R_datestart = $('#modal_dateStart').val();
            var T2R_dateEnd = $('#modal_dateEnd').val();



            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Make the first AJAX request
            $.ajax({
                type: 'POST',
                url: '/tab-activity/index/saveclonedata',
                data: {
                    report: report,
                    status: status,
                    projname: projname,
                    projnameID: projnameID,
                    projtype: projtype,
                    reference_num: reference_num,

                    act_details: act_details,
                    act_details_req: act_details_req,
                    product_engr: product_engr,
                    copy_to: copy_to,
                    date_filed: date_filed,
                    act_details_activity: act_details_activity,
                    date_needed: date_needed,
                    special_instr: special_instr,

                    reseller: reseller,
                    reseller_contact: reseller_contact,
                    reseller_phone_email: reseller_phone_email,
                    enduser_name: enduser_name,
                    enduser_contact: enduser_contact,
                    enduser_email: enduser_email,
                    enduser_location: enduser_location,

                    Act_date: Act_date,
                    Activity_type: Activity_type,
                    Program: Program,
                    Product_line: Product_line,
                    Time_expected1: Time_expected1,
                    Time_reported1: Time_reported1,
                    Time_exited1: Time_exited1,
                    engineer_name: engineer_name,
                    Venue: Venue,
                    Send_copy_to: Send_copy_to,

                    formData: formData,

                    customer_req: customer_req,
                    Activity_Done: Activity_Done,
                    Agreements: Agreements,

                    ActionPlanRecommendation: ActionPlanRecommendation,

                    ////////////////Stracert/////////////////////////
                    Stra_TopicName: straCert_TopicName,
                    Stra_DateStart: straCert_DateStart,
                    Stra_DateEnd: straCert_DateEnd,

                    /////////////POC///////////////////////////////
                    POC_ProdModel: productModel,
                    POC_AssetCode: assetCode,
                    POC_DateStart: poc_dateStart,
                    POC_DateEnd: poc_dateEnd,

                    /////////////Technology Certificate///////////////////////////////
                    Tech_Title: tech_Title,
                    Tech_examCode: tech_examCode,
                    Tech_status: tech_status,
                    Tech_ScoreDropdown: tech_ScoreDropdown,
                    Tech_examType: tech_examType,
                    Tech_incStatus: tech_incStatus,
                    Tect_incDetails: tect_incDetails,
                    Tech_examAmount: tech_examAmount,

                    /////////////////Tech Learned/////////////////////////////
                    Tech_ProdLearned: Tech_ProdLearned,

                    ////////////////////Skills Development///////////////////////
                    Skills_trainingName: skills_trainingName,
                    Skills_speaker: skills_speaker,
                    Skills_location: skills_location,
                    Skill_bpcheckBox: skill_bpcheckBox,
                    Skills_eucheckbox: skills_eucheckbox,
                    Skill_msicheckbox: skill_msicheckbox,

                    // Digiknow
                    Digi_flyers: Digi_flyers,
                    Bp_digiCheckbox: bp_digiCheckbox,
                    Eu_digiCheckbox: eu_digiCheckbox,

                    ////Internal
                    Internal_Msi: internal_Msi,
                    Internal_Percent: internal_Percent,
                    Internal_Attendance: internal_Attendance,

                    // Memo
                    Memo_Issued: memo_Issued,
                    Memo_Details: memo_Details,

                    // Feedback
                    Engr_feedback: engr_feedback,
                    Engr_rating: engr_rating,

                    // T2R
                    T2R_topic: T2R_topic,
                    T2R_datestart: T2R_datestart,
                    T2R_dateEnd: T2R_dateEnd,
                },
                success: function (response) {
                    console.log('Response from server:', response);
                    if (response.ar_id) {
                        console.log('Generated ar_id:', response.ar_id);

                        // Define a function to handle file uploads
                        function handleFileUpload(fileInputId, url, callback) {
                            var file_data = $(fileInputId).prop('files');
                            console.log('File data:', file_data);

                            if (file_data && file_data.length > 0) {
                                var form_data = new FormData();
                                form_data.append('ar_id', response.ar_id);

                                for (var i = 0; i < file_data.length; i++) {
                                    form_data.append('file_data[]', file_data[i]);
                                }

                                // Log FormData entries
                                form_data.forEach(function (value, key) {
                                    console.log(key, value);
                                });

                                // Make the AJAX request
                                $.ajax({
                                    url: url,
                                    dataType: 'text',
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    data: form_data,
                                    type: 'post',
                                    success: function (output) {
                                        console.log('Response from server:', output);
                                        if (callback) callback();
                                    },
                                    error: function (xhr, status, error) {
                                        console.error('Error:', error);
                                        $("#loading-overlay").hide();
                                        Swal.fire({ text: "Error saving files.", icon: "error" });
                                    }
                                });
                            } else {
                                console.log('No files uploaded.');
                                if (callback) callback();
                            }
                        }

                        // Define a function to handle the final success message
                        function finalSuccessMessage() {
                            $("#loading-overlay").hide();
                            Swal.fire({ text: "Saved successfully!", icon: "success" });
                            $('#exampleModal').modal('hide');
                            location.reload();
                        }

                        // Counter to keep track of completed uploads
                        var uploadCounter = 0;
                        var totalUploads = 2; // Number of file upload inputs

                        // Callback function to check if all uploads are done
                        function uploadCallback() {
                            uploadCounter++;
                            if (uploadCounter === totalUploads) {
                                finalSuccessMessage();
                            }
                        }

                        // Handle the first file upload scenario
                        handleFileUpload('#upload_file', '/tab-activity/index/editImage', uploadCallback);

                        // Handle the second file upload scenario
                        handleFileUpload('#modal_digiknowFlyersattachment', '/tab-activity/index/editDigiknowImage', uploadCallback);
                    } else {
                        $("#loading-overlay").hide();
                        Swal.fire({ text: "Saved successfully!", icon: "success" });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    // Hide loading overlay and enable screen
                    $("#loading-overlay").hide();
                    Swal.fire({ text: "Error Saving data", icon: "error" });

                }
            });
        }
    });
});

function validateFormData() {
    var report = $('#reportDropdown1').val();
    var status = $('#statusDropdown1').val();
    var activityType = $('#Activity_Type').val();

    var Product_line = $('#product_line').val();
    for (var i = 0; i < Product_line.length; i++) {
        Product_line[i] = Product_line[i].trim();
    }

    var requiredFields = [];


    // Reset all fields to remove previous error class
    setTimeout(function () {
        $('input, select, textarea').removeClass('error');
        $('.select2-selection').removeClass('error');
    }, 3000); // Delay execution by 1000 milliseconds (1 second)

    // Add conditional validation based on report and status values
    if (report === "Support Request" && status === "Pending") {
        requiredFields.push(
            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#act_details_requester'), name: 'Activity Details Requester' },
            { element: $('#engineers_modal'), name: 'Product Engineers Only' },
            { element: $('#Date_Filed'), name: 'Date Filed' },
            { element: $('#act_details_activity'), name: 'Activity Details' },
            { element: $('#Copy_to'), name: 'Copy To' },
            { element: $('#Date_Needed'), name: 'Date Needed' },
            { element: $('#special_instruction'), name: 'Special Instruction' },
            { element: $('#Ref_No'), name: 'Reference Number' },
            ////////////////////// Contract Details ///////////////////////////////
            { element: $('#Reseller'), name: 'Reseller\'s Name' },
            { element: $('#reseller_contact_info'), name: 'Reseller\'s Contact Number' },
            { element: $('#reseller_phone_email'), name: 'Reseller\'s Email Address' },
            // { element: $('#end_user_name'), name: 'End User\'s Name' },
            { element: $('#end_user_contact'), name: 'End User\'s Contact Number' },
            { element: $('#end_user_email'), name: 'End User\'s Email Address' },
            // { element: $('#end_user_loc'), name: 'End User\'s Location' }
        );
    }

    if (report === "Support Request" && (status === "" || status === "For Follow up" || status === "Activity Report being created" || status === "Completed")) {
        requiredFields.push(
            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#act_details_requester'), name: 'Activity Details Requester' },
            { element: $('#engineers_modal'), name: 'Product Engineers Only' },
            { element: $('#Date_Filed'), name: 'Date Filed' },
            { element: $('#act_details_activity'), name: 'Activity Details' },
            { element: $('#Copy_to'), name: 'Copy To' },
            { element: $('#Date_Needed'), name: 'Date Needed' },
            { element: $('#Ref_No'), name: 'Reference Number' },
            ////////////////////// Contract Details ///////////////////////////////
            { element: $('#Reseller'), name: 'Reseller\'s Name' },
            { element: $('#reseller_contact_info'), name: 'Reseller\'s Contact Number' },
            { element: $('#reseller_phone_email'), name: 'Reseller\'s Email Address' },
            // { element: $('#end_user_name'), name: 'End User\'s Name' },
            { element: $('#end_user_contact'), name: 'End User\'s Contact Number' },
            { element: $('#end_user_email'), name: 'End User\'s Email Address' },
            // { element: $('#end_user_loc'), name: 'End User\'s Location' },
            ////////////////////// Activity Summary Report ///////////////////////////////
            { element: $('#act_date'), name: 'Activity Date' },
            { element: $('#program'), name: 'Program' },
            { element: $('#product_line'), name: 'Product Line' },
            { element: $('#engineers_modal_two'), name: 'Engineers' },
        );
    }

    if ((report === 'iSupport Services') && status === 'Pending') {
        requiredFields.push(

            ////////////////////// Project Details ////////////////////////////////

            { element: $('#projtype_button1'), name: 'Project Type' },
            { element: $('#myDropdown1  option:selected'), name: 'Project Name' },

            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#Activity_details'), name: 'Activity Details' },
            ////////////////////// Contract Details ///////////////////////////////
            { element: $('#Reseller'), name: 'Reseller\'s Name' },
            { element: $('#reseller_contact_info'), name: 'Reseller\'s Contact Number' },
            { element: $('#reseller_phone_email'), name: 'Reseller\'s Email Address' },
            // { element: $('#end_user_name'), name: 'End User\'s Name' },
            { element: $('#end_user_contact'), name: 'End User\'s Contact Number' },
            { element: $('#end_user_email'), name: 'End User\'s Email Address' },
            // { element: $('#end_user_loc'), name: 'End User\'s Location' },
            ////////////////////// Activity Summary Report ///////////////////////////////
            { element: $('#act_date'), name: 'Activity Date' },
            { element: $('#Activity_Type'), name: 'Activity Type' },
            { element: $('#program'), name: 'Program' },
            { element: $('#product_line'), name: 'Product Line' },
            // { element: $('#time_expected1'), name: 'Time Expected From Client' },
            // { element: $('#time_reported1'), name: 'Time Reported From Client' },
            // { element: $('#time_exited1'), name: 'Time Exited From Client' },
            { element: $('#engineers_modal_two'), name: 'Engineers' },
            { element: $('#venue'), name: 'Venue' }
            // { element: $('#sendcopyto'), name: 'Send Copy To' }
        );
    }

    if ((report === 'Client Calls' || report === 'Partner Enablement/Recruitment' || report === 'Supporting Activity') && status === 'Pending') {
        requiredFields.push(

            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#Activity_details'), name: 'Activity Details' },
            ////////////////////// Contract Details ///////////////////////////////
            { element: $('#Reseller'), name: 'Reseller\'s Name' },
            { element: $('#reseller_contact_info'), name: 'Reseller\'s Contact Number' },
            { element: $('#reseller_phone_email'), name: 'Reseller\'s Email Address' },
            // { element: $('#end_user_name'), name: 'End User\'s Name' },
            { element: $('#end_user_contact'), name: 'End User\'s Contact Number' },
            { element: $('#end_user_email'), name: 'End User\'s Email Address' },
            // { element: $('#end_user_loc'), name: 'End User\'s Location' },
            ////////////////////// Activity Summary Report ///////////////////////////////
            { element: $('#act_date'), name: 'Activity Date' },
            { element: $('#Activity_Type'), name: 'Activity Type' },
            { element: $('#program'), name: 'Program' },
            { element: $('#product_line'), name: 'Product Line' },
            { element: $('#time_expected1'), name: 'Time Expected From Client' },
            { element: $('#time_reported1'), name: 'Time Reported From Client' },
            { element: $('#time_exited1'), name: 'Time Exited From Client' },
            { element: $('#engineers_modal_two'), name: 'Engineers' },
            { element: $('#venue'), name: 'Venue' }
            // { element: $('#sendcopyto'), name: 'Send Copy To' }
        );
        if (activityType === "POC (Proof of Concept)") {
            requiredFields.push(
                { element: $('#modal_prodModel'), name: 'Product Model' },
                { element: $('#modal_assetCode'), name: 'Asset Code' },
                { element: $('#modal_poc_dateStart'), name: 'POC Date Start' },
                { element: $('#modal_poc_dateEnd'), name: 'POC Date End' }
            );

        }
    }

    if (report === 'iSupport Services' && (status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
        requiredFields.push(
            ////////////////////// Project Details ////////////////////////////////

            { element: $('#projtype_button1'), name: 'Project Type' },
            { element: $('#myDropdown1  option:selected'), name: 'Project Name' },

            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#Activity_details'), name: 'Activity Details' },
            ////////////////////// Contract Details ///////////////////////////////
            { element: $('#Reseller'), name: 'Reseller\'s Name' },
            { element: $('#reseller_contact_info'), name: 'Reseller\'s Contact Number' },
            { element: $('#reseller_phone_email'), name: 'Reseller\'s Email Address' },
            // { element: $('#end_user_name'), name: 'End User\'s Name' },
            { element: $('#end_user_contact'), name: 'End User\'s Contact Number' },
            { element: $('#end_user_email'), name: 'End User\'s Email Address' },
            // { element: $('#end_user_loc'), name: 'End User\'s Location' },
            ////////////////////// Activity Summary Report ///////////////////////////////
            { element: $('#act_date'), name: 'Activity Date' },
            { element: $('#Activity_Type'), name: 'Activity Type' },
            { element: $('#program'), name: 'Program' },
            { element: $('#product_line'), name: 'Product Line' },
            { element: $('#time_expected1'), name: 'Time Expected From Client' },
            { element: $('#time_reported1'), name: 'Time Reported From Client' },
            { element: $('#time_exited1'), name: 'Time Exited From Client' },
            { element: $('#engineers_modal_two'), name: 'Engineers' },
            { element: $('#venue'), name: 'Venue' }
            // { element: $('#sendcopyto'), name: 'Send Copy To' },
            ////////////////// Customer, Activity Done, Agreements //////////////////////
            // { element: $('#customerReqfield'), name: 'Customer Request' },
            // { element: $('#activity_donefield'), name: 'Activity Done' },
            // { element: $('#Agreementsfield'), name: 'Agreements' }
        );
    }

    if ((report === 'Client Calls' || report === 'Partner Enablement/Recruitment' || report === 'Supporting Activity') && (status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
        requiredFields.push(

            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#Activity_details'), name: 'Activity Details' },
            ////////////////////// Contract Details ///////////////////////////////
            { element: $('#Reseller'), name: 'Reseller\'s Name' },
            { element: $('#reseller_contact_info'), name: 'Reseller Contact Number' },
            { element: $('#reseller_phone_email'), name: 'Reseller Email Address' },
            // { element: $('#end_user_name'), name: 'End User\'s Name' },
            { element: $('#end_user_contact'), name: 'End User\'s Contact Number' },
            { element: $('#end_user_email'), name: 'End User\'s Email Address' },
            // { element: $('#end_user_loc'), name: 'End User\'s Location' },
            ////////////////////// Activity Summary Report ///////////////////////////////
            { element: $('#act_date'), name: 'Activity Date' },
            { element: $('#program'), name: 'Program' },
            { element: $('#product_line'), name: 'Product Line' },
            { element: $('#time_expected1'), name: 'Time Expected From Client' },
            { element: $('#time_reported1'), name: 'Time Reported From Client' },
            { element: $('#time_exited1'), name: 'Time Exited From Client' },
            { element: $('#engineers_modal_two'), name: 'Engineers' },
            { element: $('#venue'), name: 'Venue' }
            // { element: $('#sendcopyto'), name: 'Send Copy To' },
            ////////////////// Customer, Activity Done, Agreements //////////////////////
            // { element: $('#customerReqfield'), name: 'Customer Request' },
            // { element: $('#activity_donefield'), name: 'Activity Done' },
            // { element: $('#Agreementsfield'), name: 'Agreements' }
        );
        if (activityType === "POC (Proof of Concept)") {
            requiredFields.push(
                { element: $('#modal_prodModel'), name: 'Product Model' },
                { element: $('#modal_assetCode'), name: 'Asset Code' },
                { element: $('#modal_poc_dateStart'), name: 'POC Date Start' },
                { element: $('#modal_poc_dateEnd'), name: 'POC Date End' }
            );

        }
    }

    if (report === 'Internal Enablement' && status === 'Pending') {
        requiredFields.push(
            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#Activity_details'), name: 'Activity Details' },
            ////////////////////// Activity Summary Report ///////////////////////////////
            { element: $('#act_date'), name: 'Activity Date' },
            { element: $('#Activity_Type'), name: 'Activity Type' },
            { element: $('#program'), name: 'Program' },
            { element: $('#product_line'), name: 'Product Line' },
            { element: $('#time_expected1'), name: 'Time Expected From Client' },
            { element: $('#time_reported1'), name: 'Time Reported From Client' },
            { element: $('#time_exited1'), name: 'Time Exited From Client' },
            { element: $('#engineers_modal_two'), name: 'Engineers' },
            { element: $('#venue'), name: 'Venue' }
            // { element: $('#sendcopyto'), name: 'Send Copy To' }
        );
        if (activityType === "POC (Proof of Concept)") {
            requiredFields.push(
                { element: $('#stra_topicName'), name: 'Topic Name' },
                { element: $('#stra_dateStart'), name: 'Date Start' },
                { element: $('#stra_dateEnd'), name: 'Date End' },
            );

        }
    }

    if (report === 'Internal Enablement' && (status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
        requiredFields.push(
            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#Activity_details'), name: 'Activity Details' },
            ////////////////////// Activity Summary Report ///////////////////////////////
            { element: $('#act_date'), name: 'Activity Date' },
            { element: $('#Activity_Type'), name: 'Activity Type' },
            { element: $('#program'), name: 'Program' },
            { element: $('#product_line'), name: 'Product Line' },
            { element: $('#time_expected1'), name: 'Time Expected From Client' },
            { element: $('#time_reported1'), name: 'Time Reported From Client' },
            { element: $('#time_exited1'), name: 'Time Exited From Client' },
            { element: $('#engineers_modal_two'), name: 'Engineers' },
            { element: $('#venue'), name: 'Venue' }
            // { element: $('#sendcopyto'), name: 'Send Copy To' },
            ////////////////// Customer, Activity Done, Agreements //////////////////////
            // { element: $('#customerReqfield'), name: 'Customer Request' },
            // { element: $('#activity_donefield'), name: 'Activity Done' },
            // { element: $('#Agreementsfield'), name: 'Agreements' }
        );
        if (activityType === "POC (Proof of Concept)") {
            requiredFields.push(
                { element: $('#stra_topicName'), name: 'Topic Name' },
                { element: $('#stra_dateStart'), name: 'Date Start' },
                { element: $('#stra_dateEnd'), name: 'Date End' },
            );

        }
    }
    if (report === 'Skills Development' && (status === 'Pending' || status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
        requiredFields.push(
            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#Activity_details'), name: 'Activity Details' },

            ////////////////////// Activity Summary Report ///////////////////////////////
            { element: $('#act_date'), name: 'Activity Date' },
            { element: $('#Activity_Type'), name: 'Activity Type' },
            { element: $('#program'), name: 'Program' },
            { element: $('#product_line'), name: 'Product Line' },
            { element: $('#engineers_modal_two'), name: 'Engineers' }
            // { element: $('#venue'), name: 'Venue' },
            // { element: $('#sendcopyto'), name: 'Send Copy To' }
        );
        if (activityType === "Technical Certification " || activityType === "Sales Certification") {
            requiredFields.push(
                { element: $('#modal_examCode'), name: 'Exam Code' },
                { element: $('#modal_takeStatusDropdown'), name: 'Take Status' },
                { element: $('#modal_scoreDropdown'), name: 'Score' },
            );

        }
        if (activityType === "Technology or Product Skills Development") {
            requiredFields.push(
                { element: $('#modal_techprodLearned'), name: 'Technology/ Product Learned' },
            );

        }
        if (activityType === "Vendor Training" || activityType === "Bootcamp Attended" || activityType === "TCT (Technology Cross Training)" || activityType === "TPS Led Softskills Training" || activityType === "HR-Led Training") {
            requiredFields.push(
                { element: $('#modal_trainingName'), name: 'Training Name' },
                { element: $('#modal_location'), name: 'Location' },
                { element: $('#modal_speaker'), name: 'Speaker' },
            );
        }
    }
    if (report === 'Others' && (status === 'Pending' || status === 'Cancelled' || status === "For Follow up" || status === 'Activity Report being created' || status === 'Completed')) {
        requiredFields.push(
            ////////////////////// Activity Details ///////////////////////////////
            { element: $('#Activity_details'), name: 'Activity Details' },

            ////////////////////// Activity Summary Report ///////////////////////////////
            { element: $('#act_date'), name: 'Activity Date' },
            { element: $('#Activity_Type'), name: 'Activity Type' },
            { element: $('#program'), name: 'Program' },
            { element: $('#product_line'), name: 'Product Line' },
            { element: $('#engineers_modal_two'), name: 'Engineers' },
            { element: $('#venue'), name: 'Venue' }
            // { element: $('#sendcopyto'), name: 'Send Copy To' }
        );
        if (activityType === "DIGIKnow") {
            requiredFields.push(
                { element: $('#modal_digiknowFlyersattachment'), name: 'DIGIKnow Attachment' },

            );

        }
        if (activityType === "Internal Project") {
            requiredFields.push(
                { element: $('#modal_MSIProjName'), name: 'MSI Project Name' },
                { element: $('#modal_CompliancePercentage'), name: 'Compliance Percentage' },
            );

        }
        if (activityType === "Perfect Attendance under Merit") {
            requiredFields.push(
                { element: $('#modalperfectAttendance'), name: 'Perfect Attendance' },
            );

        }
        if (activityType === "Memo from HR under Demerit") {
            requiredFields.push(
                { element: $('#modal_memoIssued'), name: 'Memo Issued' },
                { element: $('#modal_memoDetails'), name: 'Memo Details' },
            );

        }
        if (activityType === "Feedback On Engineer") {
            requiredFields.push(
                { element: $('#modal_engrFeedbackInput'), name: 'Engineer Feedback' },
                { element: $('#modal_other_rating'), name: 'Engineer Rating' },
            );

        }
        if (activityType === "Train To Retain (T2R)") {
            requiredFields.push(
                { element: $('#modal_topicName'), name: 'Topic' },
                { element: $('#modal_dateStart'), name: 'Date Start' },
                { element: $('#modal_dateEnd'), name: 'Date End' },
            );

        }
    }

    // Add other fields that are always required
    requiredFields.push(
        { element: $('#reportDropdown1'), name: 'Report' },
        { element: $('#statusDropdown1'), name: 'Status' }
    );

    // Variable to track if the form is valid
    var isFormValid = true;

    for (var i = 0; i < requiredFields.length; i++) {
        var field = requiredFields[i];
        var value = field.element.val();
    
        // Clear previous error messages
        field.element.removeClass('error');
        field.element.closest('.col-md-4, .col-md-12, .form-group').find('.error-message').remove();
    
        if (value === undefined || value === "" || (field.element.is("select") && !field.element.find("option:selected").val())) {
            if (field.name !== 'End User\'s Email Address' && field.name !== 'End User\'s Contact Number' && field.name !== 'Send Copy To') {
                Swal.fire({ text: field.name + " is required.", icon: "warning" });
    
                if (field.element.hasClass('select2-hidden-accessible')) {
                    field.element.next('.select2-container').find('.select2-selection').addClass('error'); // Add error class to Select2
                } else {
                    field.element.addClass('error'); // Add error class to regular elements
                }
    
                field.element.closest('.col-md-4, .col-md-12, .form-group').append('<div class="error-message" style="color: red; display: block;">' + field.name + ' is required.</div>');
    
                // Set the form validity flag to false
                isFormValid = false;
    
                // Skip the remaining checks for this field
                continue;
            }
        }
    
        if (value !== "") {
            if ((field.name === 'Reseller\'s Contact Number' || field.name === 'End User\'s Contact Number')) {
                if (value.trim() === '') {
                    Swal.fire({ 
                        text: field.name + " cannot be empty.", 
                        icon: "warning" 
                    });
                
                    field.element.addClass('error');
                    field.element.closest('.col-md-4, .col-md-12, .form-group')
                        .append('<div class="error-message" style="color: red; display: block;">' + field.name + ' cannot be empty.</div>');
                    
                    // Set the form validity flag to false
                    isFormValid = false;
                
                    // Skip the remaining checks for this field
                    continue;
                }
    
                // No validation restricting the number of digits
            }
            
            // Remove validation for valid email address to allow "N/A" input
        }
    }

    // Attach event listeners to remove error message on input
    for (var i = 0; i < requiredFields.length; i++) {
        var field = requiredFields[i];
        field.element.on('input change', function () {
            $(this).removeClass('error');
            $(this).closest('.col-md-4, .col-md-12, .form-group').find('.error-message').remove();
        });
    }

    // Prevent form submission if the form is not valid
    if (!isFormValid) {
        event.preventDefault();
    } else {
        return true;
    }
}



//////////////////////////////////////////////// Completion Acceptance Modal and Display //////////////////////////////////////////

$(document).ready(function () {

    function generateApproverRow(index, data = {}) {
        var approverStatusHtml = getStatusHtmlApprover(data.aaa_status || '');

        return `
    <div class="row approver-row mt-2">
        <div class="col-md-2">
            <div class="form-group">
                <label for="company_name_${index}" class="form-label mb-1 small-label">Company Name:</label>
                <input type="text" class="form-control form-control-sm" id="act_company_name_${index}" value="${data.aaa_company || ''}" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="approver_name_${index}" class="form-label mb-1 small-label">Approver Name:</label>
                <input type="text" class="form-control form-control-sm" id="act_approver_name_${index}" value="${data.aaa_name || ''}" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="position_${index}" class="form-label mb-1 small-label">Position:</label>
                <input type="text" class="form-control form-control-sm" id="act_position_${index}" value="${data.aaa_position || ''}" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="email_add_${index}" class="form-label mb-1 small-label">Email:</label>
                <input type="text" class="form-control form-control-sm" id="act_email_add_${index}" value="${data.aaa_email || ''}" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group text-center">
                <label for="approver_status_${index}" class="form-label mb-1 small-label">Status:</label>
                ${approverStatusHtml}
            </div>
        </div>
        <div class="col-md-2 mt-2 d-flex align-items-start justify-content-start pt-3">
            <button type="button" class="btn btn-danger btn-sm act_delete-approver">Delete</button>
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

    $("#completion_acceptance").off("click").on("click", function () {

        // var report = $('#reference_no').val();
        var reportnumber = $('#reference_no .reference_no').text();

        $.ajax({
            url: '/tab-activity/index/getCompletionAcceptance',
            type: 'GET',
            data: {
                reportnumber: reportnumber
            },
            success: function (response) {
                console.log('Response for server:', response);


                // Populate modal fields
                $('#ArId').val(response.ar_id).prop('disabled', true);
                $('#refno').val(response.ar_refNo).prop('disabled', true);
                $('#date').val(response.ar_date_filed).prop('disabled', true);
                $('#created_by').val(response.ar_requester).prop('disabled', true);
                $('#reseller_contact').val(response.ar_resellers_contact).prop('disabled', true);
                $('#activity_date').val(response.ar_activityDate).prop('disabled', true);
                $('#EU_Contact').val(response.ar_endUser_contact).prop('disabled', true);
                $('#actcompletion_activity').val(response.ar_activity).prop('disabled', true);
                $('#activity_done').val(response.ar_activityDone).prop('disabled', true);
                $('#Proj_Name_input').val(response.proj_name).prop('disabled', true);
                $('#reseller_input').val(response.ar_resellers).prop('disabled', true);
                $('#end_user_input').val(response.ar_endUser).prop('disabled', true);


                // Show the modal
                $('#CompletionAcceptanceModal').modal('show');
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });


        // Fetch product engineers
        $.ajax({
            url: '/tab-activity/index/getEngr',
            type: 'GET',
            data: { refNo: reportnumber },
            success: function (response) {
                console.log('Response from server Engineer Only: ', response);

                var engineersDropdown = $('#Act_Completion_Engineer').prop('disabled', true);
                engineersDropdown.empty(); // Clear existing options

                if (response) {
                    var engineerNames = response.split(','); // Split response by comma

                    engineerNames.forEach(function (engineer) {
                        engineersDropdown.append(new Option(engineer, engineer, true, true));
                    });
                }
                // Update the Select2 dropdown
                engineersDropdown.trigger('change');
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });

        $.ajax({
            url: '/tab-activity/getRefNumber',
            method: 'POST',
            data: {
                refNumber: reportnumber,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var container = $('#approvers-container1');
                container.empty();

                if (response && response.length > 0) {
                    var ar_id = response[0].ar_id;

                    //-----------------------------------------------------------------
                    var status = response[0].aa_status;

                    var displayText = getStatusHtml(status);
                    $('#completionstatus .status').html(displayText);
                    //-----------------------------------------------------------------

                    response.forEach(function (data, index) {
                        container.append(generateApproverRow(index, data));
                    });
                } else {
                    container.append(generateApproverRow(0, {}));
                }

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
                    return "<div class='alert-warning'>DRAFT</div>";
            }
        }

    });

    // Attach click event only once for the "Add Approver" button
    $('#add-approver1').on('click', function () {
        var container = $('#approvers-container1');
        var index = container.children('.approver-row').length;
        container.append(generateApproverRow(index, {}));
    });

    // Delegate event listener for delete buttons
    $('#approvers-container1').on('click', '.act_delete-approver', function () {
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


$(document).ready(function () {
    $('#CompletionAcceptanceModal').on('shown.bs.modal', function () {
        $('#Act_Completion_Engineer').select2({
            width: '60%',
            dropdownParent: $('#CompletionAcceptanceModal .modal-content'),
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


//////////////////////////////////////////////// End of  Completion Acceptance Modal and Display //////////////////////////////////////////



//////////////////////////////////////////////// Saving of Completion Acceptance  //////////////////////////////////////////

$(document).ready(function () {

        $("#SaveChanges").off("click").on("click", function () {

            $("#loading-overlay").show();
    
            var completionStatus = $('#completionstatus .status').text().trim();
    
            if (completionStatus === "APPROVED") {
                Swal.fire({ text: "This Activity Completion is already approved and cannot be modified anymore.", icon: "error" });
                $("#loading-overlay").hide();
                return false;
            }
    
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
    
            // Capture the current time
            var currentTime = new Date().toLocaleTimeString('en-GB', { hour12: false });
            // Set the value of the hidden time input
            $('#time').val(currentTime);
    
            var Ar_id = ($('#ArId').val());
    
            var CreatedBy = ($('#created_by').val());
            var CreatedDate = ($('#date').val());
            var CreatedTime = ($('#time').val());
            var CreatedDateTime = CreatedDate + ' ' + CreatedTime;
    
            // Collecting data from dynamic approver fields
            var Email = [];
            var Name = [];
            var ApproverCompanyName = [];
            var ApproverPosition = [];
    
            function showError(elementId, message) {
                // Remove any existing error message
                $('#' + elementId).next('.error-message').remove();
    
                // Append the error message after the element
                $('<div class="error-message" style="color: red; font-size: 0.875em;">' + message + '</div>').insertAfter('#' + elementId);
            }
    
            var hasEmptyFields = false;
            var invalidDomain = false;
            var invalidEmails = [];
    
            $('.approver-row').each(function () {
                var company = $(this).find('input[id^="act_company_name"]').val();
                var name = $(this).find('input[id^="act_approver_name"]').val();
                var position = $(this).find('input[id^="act_position"]').val();
                var email = $(this).find('input[id^="act_email_add"]').val();
                var validEmails = getValidEmails(email);
    
                // Remove existing error messages
                $(this).find('.error-message').remove();
    
                if (!company) {
                    showError($(this).find('input[id^="act_company_name"]').attr('id'), "*Please provide a company name.");
                    hasEmptyFields = true;
                }
                if (!name) {
                    showError($(this).find('input[id^="act_approver_name"]').attr('id'), "*Please provide Approver name.");
                    hasEmptyFields = true;
                }
                if (!position) {
                    showError($(this).find('input[id^="act_position"]').attr('id'), "*Please provide a position.");
                    hasEmptyFields = true;
                }
                if (!email) {
                    showError($(this).find('input[id^="act_email_add"]').attr('id'), "*Please provide an email address.");
                    hasEmptyFields = true;
                } else if (!validateEmail(email)) {
                    invalidDomain = true;
                    invalidEmails.push(email);
                }
    
                if (!hasEmptyFields && !invalidDomain) {
                    ApproverCompanyName.push(company);
                    Name.push(name);
                    ApproverPosition.push(position);
                    Email.push(email);
                }
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
                    $('#SentToClient').prop('disabled', false);
                    $("#loading-overlay").hide();
                } else {
                    console.log('Server response error:', response);
                    Swal.fire({ text: "Error when Created for Completion Acceptance", icon: "error" });
                    // $('#SentToClient').hide();
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
    $("#SentToClient").off("click").on("click", function () {

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
        var Ar_id = $('#ArId').val();
        console.log("Activity Report:", Ar_id);
        var Project_Name = $('#Proj_Name_input').val();
        var Reseller = $('#reseller_input').val();
        var Reseller_Contact = $('#reseller_contact').val();
        var ActivityDate = $('#activity_date').val();
        var EndUser = $('#end_user_input').val();
        var EndUser_Contact = $('#EU_Contact').val();
        var Activity_Details = $('#actcompletion_activity').val();

        var EngineerName = $('#Act_Completion_Engineer option:selected')
            .map(function () {
                return $(this).text().trim();
            })
            .get()
            .join(', ');


        var ActivityDone = $('#activity_done').val();

        // Collecting data from dynamic approver fields
        var ApproverEmail = [];
        var ApproverName = [];
        var CompanyName = [];
        var Position = [];

        var hasEmptyFields = false;

        $('.approver-row').each(function () {
            var company = $(this).find('input[id^="act_company_name"]').val();
            var name = $(this).find('input[id^="act_approver_name"]').val();
            var position = $(this).find('input[id^="act_position"]').val();
            var email = $(this).find('input[id^="act_email_add"]').val();
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










