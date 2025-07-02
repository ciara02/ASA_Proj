
document.addEventListener('DOMContentLoaded', function () {
    var project_id = $('#projectlist_id').val();

    $.ajax({
        type: 'GET',
        url: '/EmailTemplate/Act-Report-Email-Forward/RetrieveAttachment',
        data: {
            project_id: project_id
        },
        success: function (response) {
            if (response.success) {
                console.log('Server get File:', response);
                displayAttachments(response.attachments);
            } else {
                console.log('Server response error:', response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({ text: "An error Occurred", icon: "error"});
            console.error('AJAX error:', textStatus, errorThrown);
            console.log('Response text:', jqXHR.responseText);
            $("#loading-overlay").hide();
        }
    });

    function displayAttachments(attachments) {
        var container = $('#attachments-container');
        container.empty(); // Clear any existing content

        attachments.forEach(function (attachment) {
            var filename = attachment.attachment.split('/').pop(); // Extract the filename
            var path = '/uploads/Sign-off-Attachments/' + filename; // Construct the new path
            var attachmentElement = $('<div>').addClass('attachment-item mb-2');
            var attachmentLink = $('<a>')
            .attr('href', path)
            .attr('target', '_blank')
            .text(filename);
        attachmentElement.append(attachmentLink);
        container.append(attachmentElement);
    });
    }
});
