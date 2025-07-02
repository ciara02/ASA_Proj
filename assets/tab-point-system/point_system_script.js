// Function to show the loading screen
function showLoadingScreen() {
    $('#loadingScreen').show(); // Replace with your loading screen element selector
}

// Function to hide the loading screen
function hideLoadingScreen() {
    $('#loadingScreen').hide(); // Replace with your loading screen element selector
}

$(document).ready(function() {
    // Get the CSRF token from the meta tag
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // Set up AJAX to include the CSRF token in the request header
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    $('#create-form').submit(function(event) {
        event.preventDefault(); // Prevent default form submission

        var formData = new FormData(this);  // Collect form data, including text fields

        // Show the loading screen before making the AJAX request
        showLoadingScreen();

        // Perform the first AJAX request to store the data
        $.ajax({
            url: '/tab-point-system/store', // Replace with the correct URL to the store method
            type: 'POST',
            data: formData,
            processData: false, // Don't process the data
            contentType: false, // Set content type to false
            success: function(response) {
                if (response.status === 'success') {
                    var pointSystemId = response.id;

                    var fileData = new FormData();
                    var files = $('#pointsystem_att')[0].files;

                    // Check if there are files selected
                    if (files.length > 0) {
                        // If files are selected, append them to fileData
                        for (var i = 0; i < files.length; i++) {
                            fileData.append('files[]', files[i]);
                        }

                        // Perform the second AJAX request to upload the files
                        $.ajax({
                            url:'/tab-point-system/uploadPSFiles',
                            type: 'POST',
                            data: fileData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                console.log(response); 
                                if (response.status === 'success') {
                                    var alertHtml = `
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        ${response.status_message}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                `;
                                $('#alerts-container').html(alertHtml);  // Append to alerts container
                                
                                    
                                    
                                    // Hide the loading screen before redirect
                                    showLoadingScreen();
                                    
                                    // Redirect to the desired page after showing the message
                                    setTimeout(function() {
                                        window.location.href = response.redirect_url;  // Redirect URL after creation
                                    }, 2000);  // Delay redirect to allow the message to be visible
                                } else {
                                    // Handle errors if any
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.error,
                                        confirmButtonText: 'Ok'
                                    });
                                    hideLoadingScreen(); // Hide loading screen in case of error
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong during the file upload.',
                                    confirmButtonText: 'Ok'
                                });
                                hideLoadingScreen(); // Hide loading screen in case of error
                            }
                        });
                    } else {
                        // If no files are selected, show success message and redirect
                        var alertHtml = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${response.status_message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                        $('#alerts-container').html(alertHtml);  // Append to alerts container
                        
                        // Hide the loading screen before redirect
                        showLoadingScreen();
                        
                        // Redirect after creation (without files)
                        setTimeout(function() {
                            window.location.href = response.redirect_url;  // Redirect URL after creation
                        }, 2000);  // Delay redirect to allow the message to be visible
                    }
                } else {
                    // Handle failure scenario and redirect
                    window.location.href = response.redirect_url;
                    hideLoadingScreen(); // Hide loading screen in case of failure
                }
            },
            error: function(xhr, status, error) {
                // If form submission fails, redirect to a fallback page
                window.location.href = '/error'; // Replace with an error page or fallback route
                hideLoadingScreen(); // Hide loading screen in case of error
            }
        });
    });
});

$('#editform').submit(function(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(this);  // Create FormData object from form

    $.ajax({
        url: $(this).attr('action'),  // Use the form action
        type: 'POST',
        data: formData,
        contentType: false,  // Don't set content type
        processData: false,  // Don't process the data
        success: function(response) {
            console.log(response);  // Handle the success response
            showLoadingScreen();
        },
        error: function(xhr, status, error) {
            console.log(error);  // Handle errors
            hideLoadingScreen(); 
        }
    });
});



////////////////// Point System /////////////////////////////////////////////////////
document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.getElementById('pointSystemDropdown');
    var severityLabel = document.getElementById('severityLabel');

    console.log(dropdown.value);

    dropdown.addEventListener('change', function() {
        var selectedValue = this.value;

        console.log("Selected value: " + selectedValue);

        if (selectedValue === '1') {
            severityLabel.textContent = 'Merit Type:';
        } else if (selectedValue === '0') {
            severityLabel.textContent = 'Demerit Type:';
        } else {
            severityLabel.textContent = 'Severity:';
        }

        console.log("Updated label text: " + severityLabel.textContent);
    });
});

document.addEventListener("DOMContentLoaded", function() {
    // Get the element by its ID
    var statusElement = document.getElementById("statusValue");
    
    // Get the text content of the element
    var statusValue = statusElement.textContent;

    // Log the status value
    console.log("Status Value:", statusValue);

    // Check the status value and show/hide elements accordingly
    if (statusValue.trim() === 'Approved' || statusValue.trim() === 'Disapproved') {
        $('#edit-merit, #save-merit, #approve-merit, #disapprove-merit').hide();
    } else {
        $('#edit-merit, #save-merit').show();
    }
});
/////////////////////////////////// Data Table ////////////////////
$(document).ready(function () {
    var table = $('#meritdemeritTable').DataTable({
        dom: 'Bfrtip',
        pageLength: 16,
        buttons: [{
            extend: 'print',
            text: '<i class="bi bi-printer"></i> Print',
            className: 'buttons-print btn btn-success',
            title: function () {
                var currentDate = new Date();
                var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                return 'Merit/ Demerit  Report  - ' + formattedDate;
            },
            customize: function (win) {
                // Set A4 paper size
                $(win.document.head).append('<style>@page { size: A4 landscape; margin: 20mm; }</style>');
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
                var rowCount = $('#meritdemeritTable').DataTable().rows().count();
                
                // Append total row count to every page
                $(win.document.body).prepend('<div id="row-count" style="position: absolute; top: 10px; right: 10px; font-size: 12px;">Total rows: ' + rowCount + '</div>');

                var printTitle = '<div style="font-size: 20px; text-align: center;">MERIT/DEMERIT REPORT</div>';
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
            text: '<i class="bi bi-download"></i> Excel',
            extend: 'excel',
            className: 'btn btn-secondary custom-excel',
            filename: function () {
                var currentDate = new Date();
                var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                return 'ASA_Merit-Demerit_Report_' + formattedDate;
            }
        }],
        initComplete: function() {
            // Move buttons to the container
            $('#printButtonContainer').html($('.dt-buttons'));
            // Adjust buttons style and size to match Bootstrap's success and primary buttons
            $(' .buttons-excel').each(function() {
                $(this).removeClass('dt-button')
                       .addClass('btn')
                       .css({
                           'padding': '0.375rem 0.75rem',
                           'font-size': '1rem',
                           'border-radius': '.25rem',
                           'margin-left': '.25rem'
                       });
            });
        },
        responsive: true,
        deferRender: true,
        scrollX: true,
        scrollCollapse: true,
        fixedColumns: true,
        columnDefs: [{ width: '20%', targets: 0 }],
        "order": [[1, "desc"]],
        "processing": true,
        "serverSide": false, // We're handling pagination, searching, and sorting on client side
    });

    function applyFilters() {
        var selectedType = $('#meritdemeritDropdown').val();
        var selectedApproval = $('#approvalDropdown').val();

        console.log("Selected Type:", selectedType);
        console.log("Selected Approval:", selectedApproval);

        // Construct filter expression for the "Type" dropdown
        var typeFilterExpression = '';
        if (selectedType === "1" || selectedType === "0" || selectedType !== null) {
            typeFilterExpression += '^' + (selectedType === "1" ? 'Merit' : 'Demerit') + '$';
        }

        // Construct filter expression for the "Approval" dropdown
        var approvalFilterExpression = '';
        if (selectedApproval === "For Approval" || selectedApproval === "Approved" || selectedApproval === "Disapproved") {
            approvalFilterExpression += '^' + (selectedApproval === "For Approval" ? 'FOR APPROVAL' : (selectedApproval === "Disapproved" ? 'DISAPPROVED' : selectedApproval.toUpperCase())) + '$';
        }

        // Apply filter expression to the "Type" column
        table.column(3).search(typeFilterExpression, true, false).draw();

        // Apply filter expression to the "Approval" column
        table.column(2).search(approvalFilterExpression, true, false).draw();

        // Update the href attribute of the <a> tag with the current values
        var printLink = "/tab-point-system/print-merit-demerit?type=" + selectedType + "&approval=" + selectedApproval;
        $('#printButton').attr('href', printLink);
    }

    var printLink = "/tab-point-system/print-merit-demerit?type=" + null + "&approval=" + null;
        $('#printButton').attr('href', printLink);

    $('#meritdemeritDropdown, #approvalDropdown').on('change', applyFilters);

    ////////////////////////////////////////////-clickable row-//////////////////////////////
    $(document).on('click', '.clickable-row', function () {
        window.location = $(this).data("href");
    });

    //Highlight clicked row
    $('#meritdemeritTable td').on('click', function () {

        // Remove previous highlight class
        $(this).closest('table').find('tr.highlight').removeClass('highlight');

        // add highlight to the parent tr of the clicked td
        $(this).parent('tr').addClass("highlight");
    });
});

//////////////////----update radio button value in merit demerit --//////////////////
function updatePoints(level, points) {
    document.getElementById('hiddenSeverity').value = level;
    document.getElementById('hiddenPoints').value = points;

    document.getElementById('pointsDisplay1').innerText = `(${level}.00) points`;
    document.getElementById('pointsDisplay2').innerText = `(${points}.00) amount`;
}

////////////////////////////////////////-disable form-//////////////////////////////////////////////////
document.addEventListener("DOMContentLoaded", function () {
    const formElements = document.querySelectorAll('#editform input, #editform select, #editform textarea, #editform a');
    const editMeritButton = document.getElementById('edit-merit');
    const uploadFileEdit = document.getElementById('uploadFileEdit');
    const backButton = document.getElementById('cancel');

    if (uploadFileEdit) {
        $(uploadFileEdit).hide();
    }

    // Disable form elements by default
    formElements.forEach(function (element) {
        if (!element.classList.contains('always-readonly') && element !== backButton) {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                if (element.type === 'radio') {
                    element.setAttribute('disabled', true);
                } else {
                    element.setAttribute('readonly', true);
                }
            } else if (element.tagName === 'SELECT') {
                element.setAttribute('disabled', true);
            } else if (element.tagName === 'A' && element !== backButton) {
                element.style.pointerEvents = 'none'; // Disable clickability
                element.style.cursor = 'default'; // Change cursor appearance
            }
        }
    });

    // Enable form and delete buttons on "Edit" click
    if (editMeritButton) {
        editMeritButton.addEventListener('click', function () {
            formElements.forEach(function (element) {
                if (!element.classList.contains('always-readonly') && element !== backButton) {
                    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        if (element.type === 'radio') {
                            element.removeAttribute('disabled');
                        } else {
                            element.removeAttribute('readonly');
                        }
                    } else if (element.tagName === 'SELECT') {
                        element.removeAttribute('disabled');
                    } else if (element.tagName === 'A' && element !== backButton) {
                        element.style.pointerEvents = 'auto'; // Enable clickability
                        element.style.cursor = 'pointer'; // Restore cursor appearance
                    }
                }
            });

            document.getElementById('save-merit').removeAttribute('disabled');
            this.setAttribute('disabled', true); // Disable the "Edit" button

            document.querySelectorAll('.delete-file-btn').forEach(function (button) {
                button.style.display = 'inline-block';
            });

            if (uploadFileEdit) {
                $(uploadFileEdit).show();
            }
        });
    }

    // Delegate the delete button click event to a parent element for dynamic handling
    document.getElementById('pointsystem_att_edit_Display').addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('delete-file-btn')) {
            const button = event.target;
            const fileName = button.getAttribute('data-file');

            Swal.fire({
                text: `Are you sure you want to delete the file: "${fileName}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/tab-point-system/delete-attachment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ attachment: fileName })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Deleted!', data.message, 'success');
                                // Remove the attachment from the DOM
                                button.parentElement.remove();
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'An error occurred while deleting the attachment.', 'error');
                            console.error(error);
                        });
                }
            });
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Get all form elements
    var updateformElements = document.querySelectorAll('#updateLevelForm input, #updateLevelForm select, #updateLevelForm textarea');

    // Set input and textarea elements to readonly and disable select and radio
    updateformElements.forEach(function (element) {
        if (!element.classList.contains('always-readonly')) {
            if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                if (element.type === 'radio') {
                    element.setAttribute('disabled', true);
                } else {
                    element.setAttribute('readonly', true);
                }
            } else if (element.tagName === 'SELECT') {
                element.setAttribute('disabled', true);
            }
        }
    });

    // Enable the form on "Update Severity" button click
    var updateeditMeritButton = document.getElementById('severity-merit');
    $('#save-points').hide();
    
    if (updateeditMeritButton) {
        updateeditMeritButton.addEventListener('click', function () {
            updateformElements.forEach(function (element) {
                if (!element.classList.contains('always-readonly')) {
                    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        if (element.type === 'radio') {
                            // Enable radio buttons
                            element.removeAttribute('disabled');
                        } else {
                            // Disable inputs and make textareas readonly
                            element.setAttribute('readonly', true);
                        }
                    } else if (element.tagName === 'SELECT') {
                        // Optionally handle SELECT elements if needed
                        element.setAttribute('disabled', true);
                    }
                }
            });
            $('#severity-merit').hide();
            $('#save-points').show();
        });
    }
    

});
//////////////////////////////////////show engineers////////////////////////////////
$(document).ready(function () {
    $('#engineers').select2({
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
//////////////////////////////////////edit engineers////////////////////////////////
$(document).ready(function () {
    $('#engineerEdit').select2({
        width: '100%',
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

//////////////////////////(/////-ajax success message-/////////////////////////////
$(document).ready(function () {
    $('#editform').submit(function (e) {
        e.preventDefault();

        // Ensure CSRF token is included in the request headers
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Get the URL with the ID parameter
        var url = $(this).attr('action');

        // Serialize form data
        var formData = $(this).serialize();

        // Show the loading screen
        $('#loadingScreen').css('display', 'flex');

        // Make an Ajax request
        $.ajax({
            type: 'PUT',
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            success: function (response) {
                // Hide the loading screen
                $('#loadingScreen').css('display', 'none');

                // Handle the response based on the status and show an alert
                if (response.status === 'success') {
                    if (response.redirect) {
                        // Redirect to the specified route with the message as a query parameter
                        window.location.href = response.redirect + '?message=' + encodeURIComponent(response.message);
                    } else {
                        // Handle other success scenarios (if needed)
                    }
                } else if (response.status === 'info') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Information',
                        text: response.message
                    });
                } else if (response.status === 'error') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error: ' + response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                // Hide the loading screen
                $('#loadingScreen').css('display', 'none');

                // Handle the Ajax error if needed
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Ajax Error',
                    text: 'An error occurred: ' + xhr.responseText
                });
            }
        });
    });
});


// On the redirected page
$(document).ready(function () {
    // Parse the query parameters from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');

    if (message) {
        // Create a success alert dynamically
        var alertHtml = '<div class="alert alert-success alert-dismissible">';
        alertHtml += decodeURIComponent(message);
        alertHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';

        // Replace the existing alert in the HTML with the new one
        $('#alerts-container').html(alertHtml);

        // Remove the message parameter from the URL
        urlParams.delete('message');
        const newUrl = window.location.pathname + '?' + urlParams.toString();
        window.history.replaceState({}, document.title, newUrl);
    }
});



// document.getElementById('create-form').addEventListener('submit', function(event) {
//     document.getElementById('loadingScreen').style.display = 'flex';
// });


//////////////////////////////////refresh button////////////////////////////////////
document.getElementById('removeButton').addEventListener('click', function () {
    document.getElementById('meritdemeritDropdown').selectedIndex = 0;
    document.getElementById('approvalDropdown').selectedIndex = 0;
});
