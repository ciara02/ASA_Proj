document.addEventListener('DOMContentLoaded', function () {
    const statusEl = document.getElementById('statusText');
    const status = statusEl.textContent.trim();

    console.log("Status Text:", status);

    if (status === 'For Approval') {
        statusEl.classList.add('alert-warning');
    } else if (status === 'Disapproved') {
        statusEl.classList.add('alert-danger');
    } else if (status === 'Approved') {
        statusEl.classList.add('alert-success');
    } else {
        statusEl.classList.add('alert-secondary');
    }
});