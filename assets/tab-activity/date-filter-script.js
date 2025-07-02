$(document).ready(function () {
    $('#datatable1').DataTable({
        scrollX: true,
        pageLength: 16,
        dom: 'frtip',
        order: [
            [0, 'ASC']
        ],
        createdRow: function(row, data, dataIndex) {
            // Add the highlight-hover class to each row
            $(row).addClass('highlight-hover');
        },
    });
});

$(document).ready(function () {
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
    $("#startDate").change(function () {
        disableDateTo();
    });

    // Event listener for changes in EndDate
    $("#endDate").change(function () {
        // Date Restriction
        var dateFrom = new Date($("#startDate").val());
        var dateTo = new Date($("#endDate").val());

        // Check if dateFrom is greater than dateTo
        if (dateFrom > dateTo) {
            Swal.fire('End date error!', 'End date cannot be earlier than start date.', 'error');
            $("#endDate").val("");
        }
    });
});



document.addEventListener('DOMContentLoaded', function () {
    // Attach an event listener to the Filter button
    document.querySelector('.find-btn').addEventListener('click', function (e) {
        e.preventDefault()
        // Retrieve the values of startDate, endDate, and engineername
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;
        var engineerName = Array.from(document.getElementById('engineername').selectedOptions).map(option => option.value);


        if (startDate === '' && endDate === '' && engineerName.length === 0) {
            Swal.fire({ text: "Please provide Start Date, End Date, or Engineer Name", icon: "warning"});
            return; // Stop further execution
        } else if (startDate !== '' && endDate === '') {
            Swal.fire({ text: "Please provide End Date", icon: "warning"});
            return; // Stop further execution
        } else if (startDate === '' && endDate !== '') {
            Swal.fire({ text: "Please provide Start Date", icon: "warning"});
            return; // Stop further execution
        }

        // Function to restore input values
        function restoreInputValues() {
            document.getElementById('startDate').value = startDate;
            document.getElementById('endDate').value = endDate;
            var engineerSelect = document.getElementById('engineername');
            Array.from(engineerSelect.options).forEach(option => {
                option.selected = engineerName.includes(option.value);
            });
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
            // Proceed with AJAX request if the difference is within 1 year
            // Show loading animation
            $('#loading').show();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Send AJAX request to the controller
            $.ajax({
                url: '/tab-activity/index/searchActivityReport',  // update this URL as per your route
                type: 'GET',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    engineerName: engineerName
                },
                success: function (response) {
                    console.log('Response from server:', response);
                    restoreInputValues();
            
                    $('#loading').hide();
            
                    $('#datatable1').DataTable().clear().destroy();
                    $('#datatable1 thead').empty();
            
                    // Merge the data with the same ar_refNo
                    var mergedData = [];
                    var groupedData = {};
            
                    response.forEach(function (item) {
                        if (!groupedData[item.ar_refNo]) {
                            groupedData[item.ar_refNo] = item;
                        }
                    });
            
                    // Convert groupedData object to an array
                    mergedData = Object.values(groupedData);
            
                    // Define the columns for DataTable
                    var columns = [
                        { title: "Date", data: "ar_activityDate" },
                        { title: "Reference #", data: "ar_refNo" },
                        { title: "Engineer Name", data: "EngrNames" },
                        { title: "From", data: "time_reported" },
                        { title: "To", data: "time_exited" },
                        { title: "Category", data: "report_name" },
                        { title: "Activity Type", data: "type_name" },
                        { title: "Product Line", data: "ProductLine" },
                        { title: "Activity Details", data: "ar_activity" },
                        { title: "Reseller", data: "ar_resellers" },
                        { title: "Venue", data: "ar_venue" },
                        { title: "Status", data: "status_name" }
                    ];
            
                    $('#datatable1').DataTable({
                        scrollX: true,
                        data: mergedData,
                        columns: columns,
                        order: [[0, 'ASC']],
                        dom: 'Bfrtip',
                        autoWidth: true,
                        pageLength: 16,
                        createdRow: function (row, data, dataIndex) {
                            // Add the highlight-hover class to each row
                            $(row).addClass('highlight-hover');
                    
                            // Apply truncation to Engineer Name
                            $('td:eq(2)', row).addClass('truncate').text(data.EngrNames);
                    
                            // Apply truncation to Product Line
                            $('td:eq(7)', row).addClass('truncate').text(data.ProductLine);
                        },
                        buttons: [
                            {
                                extend: 'print',
                                text: '<i class="bi bi-printer"></i> Print',
                                className: 'buttons-print btn btn-success',
                                title: function () {
                                    var currentDate = new Date();
                                    var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                                    return 'ASA Activity Report - ' + formattedDate;
                                },
                                customize: function (win) {
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
                                    var rowCount = $('#datatable1').DataTable().rows().count();
                                    
                                    // Append total row count to every page
                                    $(win.document.body).prepend('<div id="row-count" style="position: absolute; top: 10px; right: 10px; font-size: 12px;">Total rows: ' + rowCount + '</div>');

                                    var printTitle = '<div style="font-size: 20px; text-align: center;">ACTIVITY REPORTS</div>';
                                    $(win.document.body).prepend(printTitle);
                                    
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
                                    return 'ASA Activity Report- ' + formattedDate;
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
                        }
                    });
                },
                
                error: function (xhr, status, error) {
                    $('#loading').hide(); // Hide loading animation on error as well
                    console.error('AJAX error:', status, error);
                }
            });
        }
    });
});
