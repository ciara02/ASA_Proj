$(document).ready(function () {
    $('#activity-accept-table').DataTable({
        responsive: true,
        deferRender: true,
        scrollX: true,
        order: [[0, 'ASC']],
        scrollCollapse: true,
        fixedColumns: true,
        pageLength: 16,
        createdRow: function(row, data, dataIndex) {
            // Add the highlight-hover class to each row
            $(row).addClass('highlight-hover');
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'buttons-print btn btn-success no-line-height',
                title: function () {
                    var currentDate = new Date();
                    var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                    return 'ASA Activity Completion Report - ' + formattedDate;
                },
                customize: function (win) {
                    // Add styles to the print view
                    $(win.document.head).append('<style>head.dt-print-view h1 { text-align: center; margin: 1em; }</style>');
                    $(win.document.head).append('<style>table.dataTable th, table.dataTable td { word-wrap: break-word; white-space: normal; }</style>');
                    
                    // Remove DataTables default heading
                    $(win.document.head).append('<style>.dt-print-view h1 { display: none; }</style>');

                     // Use an absolute path for the logo
                     var imgSrc = "/assets/img/official-logo.png"; // Ensure the path is absolute
                     console.log('Image path:', imgSrc);  // Debugging: Log the image path to console
 
                     // Image styling for fade effect and centering vertically and horizontally
                     var imgStyle = 'position:fixed; top:50%; left:50%; transform: translate(-50%, -50%); max-width: 50%; max-height: 50%; opacity:0.2;';
                     
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
                    var rowCount = $('#activity-accept-table').DataTable().rows().count();
                    
                    // Append total row count to every page
                    $(win.document.body).prepend('<div id="row-count" style="position: absolute; top: 10px; right: 10px; font-size: 12px;">Total rows: ' + rowCount + '</div>');

                    var printTitle = '<div style="font-size: 20px; text-align: center;">ACTIVITY COMPLETION ACCEPTANCE REPORT</div>';
                    $(win.document.body).prepend(printTitle);
                    
                    // Apply styles to the table
                    $(win.document.body)
                        .css('font-size', '8pt')
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
                className: 'buttons-excel btn btn-primary no-line-height',
                filename: function () {
                    var currentDate = new Date();
                    var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                    return 'ASA Activity Completion Report- ' + formattedDate;
                }
            }
        ],
    });
});

$(document).ready(function() {
    // Function to disable dateFrom if StartDate is empty
    function disableDateTo() {
        var startDate = $("#dateFrom").val();
        if (startDate === "") {
            $("#dateTo").prop("disabled", true);
            $("#dateTo").val("");
        } else {
            $("#dateTo").prop("disabled", false);
        }
    }
    // Call the function initially
    disableDateTo();

    // Event listener for changes in StartDate
    $("#dateFrom").change(function() {
        disableDateTo();
    });

    // Event listener for changes in EndDate
    $("#dateTo").change(function() {
        // Date Restriction
        var dateFrom = new Date($("#dateFrom").val());
        var dateTo = new Date($("#dateTo").val());

        // Check if dateFrom is greater than dateTo
        if (dateFrom > dateTo) {
            Swal.fire('End date error!', 'End date cannot be earlier than start date.', 'error');
            $("#dateTo").val("");
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Attach an event listener to the Filter button
    document.getElementById('filter_button').addEventListener('click', function() {
        // Retrieve the values of startDate, endDate, and engineername
        var startDate = document.getElementById('dateFrom').value;
        var endDate = document.getElementById('dateTo').value;
        var engineerName = Array.from(document.getElementById('engineername').selectedOptions).map(option => option.value);


        if (startDate === '' && endDate === '' && engineerName === '') {
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
        document.getElementById('dateFrom').value = startDate;
        document.getElementById('dateTo').value = endDate;
        var engineerSelect = document.getElementById('engineername');
        Array.from(engineerSelect.options).forEach(option => {
            option.selected = engineerName.includes(option.value);
        });
        }
            // Proceed with AJAX request if the difference is within 1 year
            // Show loading animation
            $('#loading2').show();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Send AJAX request to the controller
            $.ajax({
                url: '/tab-activity/searchActCompletionAcceptanceReport',  // update this URL as per your route
                type: 'GET',
                data:  {
                    startDate: startDate,
                    endDate: endDate,
                    engineerName: engineerName
                },
                success: function (response) {
                    console.log('Response from server:', response);
                    restoreInputValues();

                    $('#loading2').hide();

                    $('#activity-accept-table').DataTable().clear().destroy();
                    $('#activity-accept-table thead').empty();

                    columns = [
                        { title: "Date", data: "ar_activityDate" },
                        { title: "Engineer Name", data: "engr_name"},
                        { title: "Activity Reference #",  data: "ar_refNo" },
                        { title: "Activity Details",  data: "ar_activity" },
                        { title: "Reseller",  data: "ar_resellers" },
                        { title: "End User",  data: "ar_endUser" },
                        { title: "Category",  data: "report_name" },
                        { title: "Activity Type",  data: "type_name" },
                        { title: "Product Line",  data: "ProductLine" },
                        { title: "Status",  data: "aa_status" },
                        { title: "Created By",  data: "aa_created_by" },
                        { title: "Project Name",  data: "proj_name" },
                        { title: "Reseller Contact",  data: "ar_resellers_contact" },
                        { title: "End User Contact",  data: "ar_endUser_contact" },
                        { 
                            title: "Date Created",
                            data: "aa_date_created",
                            render: function(data, type, row) {
                                // Check if the data exists and is not null
                                if (data) {
                                    // Format the date using JavaScript Date object
                                    var date = new Date(data);
                                    var formattedDate = date.getFullYear() + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getDate().toString().padStart(2, '0');
                                    return formattedDate;
                                } else {
                                    return ''; // Return an empty string if data is null
                                }
                            }
                        },
                        { title: "Activity Done",  data: "ar_activityDone", className: "truncate" ,  render: function(data, type, row) {
                            // Remove <br /> tags from the data
                            return data ? data.replace(/<br\s*\/?>/gi, '') : '';
                        }},
                    
                    ];

                    $('#activity-accept-table').DataTable(
                        {
                            scrollX: true,
                            data: response,
                            columns: columns,
                            createdRow: function(row, data, dataIndex) {
                                // Add the highlight-hover class to each row
                                $(row).addClass('highlight-hover');
                            },
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'print',
                                    text: '<i class="bi bi-printer"></i> Print',
                                    className: 'buttons-print btn btn-success',
                                    title: function () {
                                        var currentDate = new Date();
                                        var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                                        return 'ASA Activity Completion Report - ' + formattedDate;
                                    },
                                    customize: function (win) {
                                        // Add styles to the print view
                                        $(win.document.head).append('<style>head.dt-print-view h1 { text-align: center; margin: 1em; }</style>');
                                        $(win.document.head).append('<style>table.dataTable th, table.dataTable td { word-wrap: break-word; white-space: normal; }</style>');
                                        
                                        // Remove DataTables default heading
                                        $(win.document.head).append('<style>.dt-print-view h1 { display: none; }</style>');
                    
                                         // Use an absolute path for the logo
                                         var imgSrc = "/assets/img/official-logo.png"; // Ensure the path is absolute
                                         console.log('Image path:', imgSrc);  // Debugging: Log the image path to console
                     
                                         // Image styling for fade effect and centering vertically and horizontally
                                         var imgStyle = 'position:fixed; top:50%; left:50%; transform: translate(-50%, -50%); max-width: 50%; max-height: 50%; opacity:0.2;';
                                         
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
                                        var rowCount = $('#activity-accept-table').DataTable().rows().count();
                                        
                                        // Append total row count to every page
                                        $(win.document.body).prepend('<div id="row-count" style="position: absolute; top: 10px; right: 10px; font-size: 12px;">Total rows: ' + rowCount + '</div>');
                    
                                        var printTitle = '<div style="font-size: 20px; text-align: center;">ACTIVITY COMPLETION ACCEPTANCE REPORT</div>';
                                        $(win.document.body).prepend(printTitle);
                                        
                                        // Apply styles to the table
                                        $(win.document.body)
                                            .css('font-size', '8pt')
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
                                        return 'ASA Activity Completion Report- ' + formattedDate;
                                    }
                                }
                            ],
                        });
                },
                error: function (xhr, status, error) {
                    $('#loading').hide(); // Hide loading animation on error as well
                    console.error('AJAX error:', status, error);
                }
            });
        
    });
});


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
                    results: $.map(data, function (item) { // Adjust based on the actual response format
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









