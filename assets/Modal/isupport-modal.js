function disableInputs() {
    
    // Disable text fields and dropdowns in modal body
    $('#projectSignOffModal .modal-body input[type="text"], #projectSignOffModal .modal-body input[type="button"], #projectSignOffModal .modal-body textarea, #projectSignOffModal .modal-body input[type="file"], #projectSignOffModal .modal-body input[type="date"], #projectSignOffModal .modal-body select').prop('disabled', true);
    }

function enableInputs() {
    // Enable text fields and dropdowns in modal body
    $('#projectSignOffModal .modal-body input[type="text"], #projectSignOffModal .modal-body input[type="button"], #projectSignOffModal .modal-body textarea, #projectSignOffModal .modal-body input[type="file"], #projectSignOffModal .modal-body input[type="date"], #projectSignOffModal .modal-body select').not('#project_title, #projectSignOffModal .modal-body #approverContainer input, #projectSignOffModal .modal-body input[type="file"] ').prop('disabled', false);
}

function hideButtons(){
 $('#editBtn, #approvalBtn, #submitBtn').hide();
}

function showButtons() {
    $('#editBtn, #approvalBtn').show();
}



$(document).ready(function() {
    $('#implementation-datatable tbody').on('click', 'tr', function() {
        var projectId = $(this).data('project-id');
        console.log('Project Id: ' + projectId);

        // Define the URL you want to redirect to
        var routeUrl = '/EmailTemplate/Act-Report-Email-Forward/ProjectSign-Off-View';

        // Construct the URL with query parameter
        var redirectUrl = routeUrl + '?Projectlist_id=' + projectId;

        // Open the URL in a new tab
        window.open(redirectUrl, '_blank');
    });
});




$(document).ready(function() {
    // Function to reload the page with preserved search value
    function reloadPage(searchValue) {
        // Reload the page with the search value preserved as a query parameter
        window.location.href = window.location.pathname + '?search=' + encodeURIComponent(searchValue);
    }

    $('#projectSignoffUpdate').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();
        
        // Get current form data
        var currentFormData = $(this).serialize();
    
        // Get the initial form data
        var initialFormData = $(this).data('initialFormData');
    
        console.log("Initial form data:", initialFormData);
        console.log("Current form data:", currentFormData);
    
        // Check if there are changes in form data
        if (initialFormData === currentFormData) {
            // If there are no changes, show a message and return without submitting the form
            Swal.fire({ text: "There are no changes", icon: "warning"});
            return; // Exit function
        }
    
        // Send AJAX request
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: currentFormData,
            success: function(response) {
                // If the update is successful, show a success message
                if (response.message === 'Project sign-off updated successfully') {
                    alert(response.message);
                    // Close the modal
                    $('#projectSignOffModal').modal('hide');
                    // Get the current search value
                    var searchValue = $('#implementation-datatable_filter input').val();
                    // Reload the page with preserved search value
                    reloadPage(searchValue);
                } else if (response.message === 'No changes were made') {
                    // If no changes were made, show a message but don't reload the page
                    alert(response.message);
                    // Close the modal
                    $('#projectSignOffModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                // If there is an error, show an error message
                var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : 'An error occurred.';
                alert(errorMessage);
            }
        });
    });
    
    // Store initial form data as data attribute
    $('#projectSignoffUpdate').data('initialFormData', $('#projectSignoffUpdate').serialize());
});
