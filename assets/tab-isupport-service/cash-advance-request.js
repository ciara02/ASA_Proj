document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('fileddate_approval');
  const originalDate = input.value; // format: YYYY-MM-DD

  if (originalDate) {
      const [year, month, day] = originalDate.split('-');
      const date = new Date(year, month - 1, day);
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      const formatted = date.toLocaleDateString('en-US', options);

      input.value = formatted; // e.g., "Apr 25, 2025"
  }
});

const startInput = document.getElementById("Datestart_approval");
const endInput = document.getElementById("Dateend_approval");

let startPicker, endPicker;
let lastValidStartDate = null;
let lastValidEndDate = null;

startPicker = flatpickr(startInput, {
  dateFormat: "F d, Y",
  onChange: function(selectedDates) {
    const startDate = selectedDates[0];
    const endDate = endPicker.selectedDates[0];
    if (endDate && startDate > endDate) {
      Swal.fire({
        icon: "warning",
        title: "Invalid Start Date",
        text: "Start date cannot be later than the end date.",
      });
      startPicker.setDate(lastValidStartDate || null, false);
    } else {
      lastValidStartDate = startDate;
    }
  }
});

endPicker = flatpickr(endInput, {
  dateFormat: "F d, Y",
  onChange: function(selectedDates) {
    const endDate = selectedDates[0];
    const startDate = startPicker.selectedDates[0];
    if (startDate && endDate < startDate) {
      Swal.fire({
        icon: "warning",
        title: "Invalid End Date",
        text: "End date cannot be earlier than the start date.",
      });
      endPicker.setDate(lastValidEndDate || null, false);
    } else {
      lastValidEndDate = endDate;
    }
  }
});

document.getElementById('Mandays_approval').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

document.addEventListener('DOMContentLoaded', function () {
  const projectCostInput = document.getElementById('ProjectCost_approval');
  const expensesInput = document.getElementById('Expenses_approval');
  const marginInput = document.getElementById('Margin_approval');

  function calculateMargin() {
      let projectCost = parseFloat(projectCostInput.value.replace(/,/g, '')) || 0;
      let expenses = parseFloat(expensesInput.value.replace(/,/g, '')) || 0;
      let margin = projectCost - expenses;

      marginInput.value = margin.toFixed(2); 
  }

  // Run calculation on input
  projectCostInput.addEventListener('input', calculateMargin);
  expensesInput.addEventListener('input', calculateMargin);
});

document.addEventListener('DOMContentLoaded', function () {
  const expenseInput = document.getElementById('Expenses_approval');

  // Restrict input to numbers and one decimal point
  expenseInput.addEventListener('input', function () {
    // Allow only digits and a single decimal point
    let cleaned = expenseInput.value.replace(/[^0-9.]/g, '');
    const parts = cleaned.split('.');
    if (parts.length > 2) {
      cleaned = parts[0] + '.' + parts.slice(1).join('');
    }
    expenseInput.value = cleaned;
  });

  // Format on blur
  expenseInput.addEventListener('blur', function () {
    let raw = expenseInput.value.replace(/,/g, '');
    let value = parseFloat(raw);
    if (!isNaN(value)) {
      expenseInput.value = value.toFixed(2);
    }
  });
});


const perDiemItems = [
  { currency: 'Domestic - PESO', rate: '', days: '', pax: '', total: '' }
];

const perdiemtbody = document.querySelector("#perDiemBody");
let perDiemTotalInput;
let perDiemTotalCell;

function calculatePerDiemTotal() {
  let total = 0;
  document.querySelectorAll('input[name="perdiemTotal[]"]').forEach(input => {
    const value = parseFloat(input.value.replace(/,/g, "")) || 0;
    total += value;
  });

  if (perDiemTotalInput) {
    perDiemTotalInput.value = total.toFixed(2);
  }

  if (typeof updateGrandTotal === "function") {
    updateGrandTotal();
  }
}

function addPerDiemRow(item = { currency: 'Domestic - PESO', rate: '', days: '', pax: '', total: '' }, isFirstRow = false) {
  const row = document.createElement("tr");

  row.innerHTML = `
    <td><input type="text" class="form-control no-border" name="Currency[]" value="${item.currency}"></td>
    <td><input type="number" class="form-control no-border rate" name="Rate[]" value="${item.rate}" placeholder="0"></td>
    <td><input type="number" class="form-control no-border days" name="days[]" value="${item.days}" placeholder="0"></td>
    <td><input type="number" class="form-control no-border pax" name="pax[]" value="${item.pax}" placeholder="0"></td>
  `;

  // Only add total cell in the first row
  if (isFirstRow) {
    perDiemTotalCell = document.createElement("td");
    perDiemTotalCell.setAttribute("rowspan", "1");
    perDiemTotalCell.innerHTML = `
      <input type="text" class="form-control no-border total" name="grandPerdiemTotal" readonly value="0.00">
    `;
    perDiemTotalInput = perDiemTotalCell.querySelector("input");
    row.appendChild(perDiemTotalCell);
  }

  perdiemtbody.appendChild(row);

  const rateInput = row.querySelector('.rate');
  const daysInput = row.querySelector('.days');
  const paxInput = row.querySelector('.pax');

  const hiddenTotal = document.createElement("input");
  hiddenTotal.type = "hidden";
  hiddenTotal.name = "perdiemTotal[]";
  hiddenTotal.value = "0.00";
  row.appendChild(hiddenTotal);

  function calculateRowTotal() {
    const rate = parseFloat(rateInput.value) || 0;
    const days = parseFloat(daysInput.value) || 0;
    const pax = parseFloat(paxInput.value) || 0;
    const total = rate * days * pax;
    hiddenTotal.value = total.toFixed(2);
    calculatePerDiemTotal();
  }

  [rateInput, daysInput, paxInput].forEach(input => {
    input.addEventListener('input', calculateRowTotal);
  });
}

// Initial row
addPerDiemRow(perDiemItems[0], true);

// Add row
document.getElementById("addPerDiemRow").addEventListener("click", () => {
  addPerDiemRow();
  const rowCount = perdiemtbody.querySelectorAll("tr").length;
  perDiemTotalCell.setAttribute("rowspan", rowCount.toString());
  updateRemoveButtonVisibility();
});

// Remove row
const removeBtn = document.getElementById("removePerDiemRow");

function updateRemoveButtonVisibility() {
  const rows = perdiemtbody.querySelectorAll("tr");
  removeBtn.style.display = rows.length <= 1 ? "none" : "inline-block";
}

updateRemoveButtonVisibility();

removeBtn.addEventListener("click", () => {
  const rows = perdiemtbody.querySelectorAll("tr");
  if (rows.length <= 1) return;

  Swal.fire({
    title: "Are you sure?",
    text: "This will remove the last row.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, remove it",
    cancelButtonText: "Cancel"
  }).then((result) => {
    if (result.isConfirmed) {
      const lastRow = rows[rows.length - 1];
      lastRow.remove();

      const rowCount = perdiemtbody.querySelectorAll("tr").length;
      perDiemTotalCell.setAttribute("rowspan", rowCount.toString());
      calculatePerDiemTotal();

      updateRemoveButtonVisibility(); 

      Swal.fire({
        title: "Removed!",
        text: "The last row has been deleted.",
        icon: "success",
        timer: 1500,
        showConfirmButton: false
      });
    }
  });
});



const transpoItems = [
  { date: "", itemDesc: "", from: "", to: "", amount: "" }
];

const transpoBody = document.getElementById("transpoBody");
let transpoTotalInput;
let transpoTotalCell;

function formatNumber(num) {
  return num.toLocaleString(undefined, {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  });
}

function calculateTranspoTotal() {
  let total = 0;
  document.querySelectorAll('input[name="transAmount[]"]').forEach((input) => {
    const value = parseFloat(input.value.replace(/,/g, "")) || 0;
    total += value;
  });

  if (transpoTotalInput) {
    transpoTotalInput.value =  total.toFixed(2);
  }

  if (typeof updateGrandTotal === "function") {
    updateGrandTotal();
  }
}

function createTranspoRow(item = {}, includeTotalCell = false) {
  const row = document.createElement("tr");

  row.innerHTML = `
    <td><input type="date" class="form-control no-border" name="Date[]" value="${item.date || ""}"></td>
    <td><input type="text" class="form-control no-border" name="itemDesc[]" value="${item.itemDesc || ""}"></td>
    <td><input type="text" class="form-control no-border" name="From[]" value="${item.from || ""}"></td>
    <td><input type="text" class="form-control no-border" name="To[]" value="${item.to || ""}"></td>
    <td><input type="number" class="form-control no-border transAmount" name="transAmount[]" placeholder="0.00" value="${item.amount || ""}"></td>
  `;

  if (includeTotalCell) {
    transpoTotalCell = document.createElement("td");
    transpoTotalCell.setAttribute("rowspan", "1");
    transpoTotalCell.innerHTML = `
      <input type="text" class="form-control no-border" name="transpoTotal[]" readonly value="0.00">
    `;
    transpoTotalInput = transpoTotalCell.querySelector("input");
    row.appendChild(transpoTotalCell);
  }

  transpoBody.appendChild(row);

  const amountInput = row.querySelector('input[name="transAmount[]"]');
  amountInput.addEventListener("input", calculateTranspoTotal);

  return row;
}

// Initialize table
transpoItems.forEach((item, index) => {
  createTranspoRow(item, index === 0);
});
transpoTotalCell.setAttribute("rowspan", transpoItems.length.toString());

// Add row button handler
document.getElementById("addTranspoRow").addEventListener("click", () => {
  createTranspoRow();
  const rowCount = transpoBody.querySelectorAll("tr").length;
  transpoTotalCell.setAttribute("rowspan", rowCount.toString());
  updateRemoveTranspoButtonVisibility();
});

// Optional: Remove row button
const removeTranspoBtn = document.getElementById("removeTranspoRow");

function updateRemoveTranspoButtonVisibility() {
  const rows = transpoBody.querySelectorAll("tr");
  removeTranspoBtn.style.display = rows.length <= 1 ? "none" : "inline-block";
}

updateRemoveTranspoButtonVisibility();

removeTranspoBtn.addEventListener("click", () => {
  const rows = transpoBody.querySelectorAll("tr");
  if (rows.length <= 1) return;

  Swal.fire({
    title: "Are you sure?",
    text: "This will remove the last row.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, remove it",
    cancelButtonText: "Cancel"
  }).then((result) => {
    if (result.isConfirmed) {
      const lastRow = rows[rows.length - 1];
      lastRow.remove();

      const updatedRowCount = transpoBody.querySelectorAll("tr").length;
      transpoTotalCell.setAttribute("rowspan", updatedRowCount.toString());

      calculateTranspoTotal();

      updateRemoveTranspoButtonVisibility(); 

      Swal.fire({
        title: "Removed!",
        text: "The last row has been deleted.",
        icon: "success",
        timer: 1500,
        showConfirmButton: false
      });
    }
  });
});

  
const accItems = [
  { hotel: "", rate: "", rooms: "", nights: "", amount: "" }
];

const accBody = document.getElementById("accBody");
let accTotalInput;
let accTotalCell;

function calculateAccTotal() {
  let total = 0;
  document.querySelectorAll('input[name="accAmount[]"]').forEach(input => {
    const val = parseFloat(input.value.replace(/,/g, '')) || 0;
    total += val;
  });
  if (accTotalInput) {
    accTotalInput.value = total.toFixed(2); // No commas
  }

  if (typeof updateGrandTotal === "function") {
    updateGrandTotal();
  }
}

function createAccRow(item = {}, includeTotalCell = false) {
  const row = document.createElement("tr");

  row.innerHTML = `
    <td><input type="text" class="form-control no-border hotel" name="Hotel[]" value="${item.hotel || ''}"></td>
    <td><input type="number" class="form-control no-border dailyRate" name="DailyRate[]" value="${item.rate || ''}" placeholder="0"></td>
    <td><input type="number" class="form-control no-border rooms" name="rooms[]" value="${item.rooms || ''}" placeholder="0"></td>
    <td><input type="number" class="form-control no-border nights" name="nights[]" value="${item.nights || ''}" placeholder="0"></td>
    <td><input type="number" class="form-control no-border accAmount" name="accAmount[]" readonly placeholder="0.00"></td>
  `;

  // Only add the total cell to the first row
  if (includeTotalCell) {
    accTotalCell = document.createElement("td");
    accTotalCell.setAttribute("rowspan", "1");
    accTotalCell.innerHTML = `<input type="text" class="form-control no-border" name="accTotal[]" readonly value="0.00">`;
    accTotalInput = accTotalCell.querySelector("input");
    row.appendChild(accTotalCell);
  }

  accBody.appendChild(row);

  const dailyRateInput = row.querySelector('.dailyRate');
  const roomsInput = row.querySelector('.rooms');
  const nightsInput = row.querySelector('.nights');
  const amountInput = row.querySelector('.accAmount');

  function updateAmount() {
    const dailyRate = parseFloat(dailyRateInput.value.replace(/,/g, '')) || 0;
    const rooms = parseFloat(roomsInput.value.replace(/,/g, '')) || 0;
    const nights = parseFloat(nightsInput.value.replace(/,/g, '')) || 0;
    const amount = dailyRate * rooms * nights;
    amountInput.value = amount > 0 ? amount.toFixed(2) : "";
    calculateAccTotal();
  }

  dailyRateInput.addEventListener('input', updateAmount);
  roomsInput.addEventListener('input', updateAmount);
  nightsInput.addEventListener('input', updateAmount);

  updateAmount();
}

// Initialize rows
accItems.forEach((item, index) => {
  createAccRow(item, index === 0); // only first row gets total cell
});
accTotalCell.setAttribute("rowspan", accItems.length.toString());

// Add row
document.getElementById("addAccRow").addEventListener("click", () => {
  createAccRow();

  // Update rowspan of total cell
  const rowCount = accBody.querySelectorAll("tr").length;
  accTotalCell.setAttribute("rowspan", rowCount.toString());
  updateRemoveAccButtonVisibility();
});

// Remove last row
const removeAccBtn = document.getElementById("removeAccRow");

function updateRemoveAccButtonVisibility() {
  const rows = accBody.querySelectorAll("tr");
  removeAccBtn.style.display = rows.length <= 1 ? "none" : "inline-block";
}

updateRemoveAccButtonVisibility();

removeAccBtn.addEventListener("click", () => {
  const rows = accBody.querySelectorAll("tr");
  if (rows.length <= 1) return; 

  Swal.fire({
    title: "Are you sure?",
    text: "This will remove the last row.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, remove it",
    cancelButtonText: "Cancel"
  }).then((result) => {
    if (result.isConfirmed) {
      const lastRow = rows[rows.length - 1];
      lastRow.remove();

      // Update rowspan
      const updatedRowCount = accBody.querySelectorAll("tr").length;
      accTotalCell.setAttribute("rowspan", updatedRowCount.toString());

      calculateAccTotal();

      updateRemoveAccButtonVisibility();

      Swal.fire({
        title: "Removed!",
        text: "The last row has been deleted.",
        icon: "success",
        timer: 1500,
        showConfirmButton: false
      });
    }
  });
});

// Function to calculate total
function calculateAccTotal() {
  const amountInputs = document.querySelectorAll('.accAmount');
  let total = 0;
  amountInputs.forEach(input => {
    total += parseFloat(input.value) || 0;
  });
  if (accTotalInput) {
    accTotalInput.value = total.toFixed(2);
  }
  updateGrandTotal();

}

  
  
const particulars = [
  "Excess Baggage",
  "Airport Tax",
  "Terminal Fee",
  "Contingency Fund",
  "Others, Pls. Specify:"
];

const tbody = document.getElementById("miscBody");
let miscTotalInput; // reference for total field

function formatNumber(num) {
  return num.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function calculateMiscTotal() {
  let total = 0;
  const rows = tbody.querySelectorAll("tr");

  rows.forEach(row => {
    const paxInput = row.querySelector('input[name="miscPax[]"]');
    const amountInput = row.querySelector('input[name="miscAmount[]"]');

    if (paxInput && amountInput) {
      const pax = parseFloat(paxInput.value.replace(/,/g, '')) || 0;
      const amount = parseFloat(amountInput.value.replace(/,/g, '')) || 0;
      const subtotal = pax * amount;
      total += subtotal;
    }
  });

  if (miscTotalInput) {
    miscTotalInput.value = formatNumber(total).replace(/,/g, '');
  }

  updateGrandTotal(); // assuming you have this function
}

// Create rows dynamically
particulars.forEach((item, index) => {
  const row = document.createElement("tr");
  row.innerHTML = `
    <td><input type="text" class="form-control no-border" name="particulars[]" value="${item}"></td>
    <td><input type="number" class="form-control no-border" name="miscPax[]" placeholder="0"></td>
    <td><input type="number" class="form-control no-border" name="miscAmount[]" placeholder="0.00"></td>
    ${index === 0 ? `<td rowspan="${particulars.length}">
      <input type="text" class="form-control no-border miscTotal" name="miscTotal[]" readonly placeholder="0.00">
    </td>` : ''}
  `;
  tbody.appendChild(row);

  // Store reference to total field
  if (index === 0) {
    miscTotalInput = row.querySelector('input[name="miscTotal[]"]');
  }

  // Add listeners to both pax and amount input for real-time calculation
  const paxInput = row.querySelector('input[name="miscPax[]"]');
  const amountInput = row.querySelector('input[name="miscAmount[]"]');

  if (paxInput) paxInput.addEventListener("input", calculateMiscTotal);
  if (amountInput) amountInput.addEventListener("input", calculateMiscTotal);
});

  
  document.addEventListener('DOMContentLoaded', function () {
    const division1 = document.getElementById('division1');
    const division2 = document.getElementById('division2');

    division1.addEventListener('change', function () {
        if (this.value === 'TPSA') {
            division2.value = 'TPS A';
        } else if (this.value === 'TPSB') {
            division2.value = 'TPS B';
        }
    });
});

function updateGrandTotal() {
  let grandTotal = 0;

  // Per Diem Totals
  document.querySelectorAll('input[name="perdiemTotal[]"]').forEach(input => {
    grandTotal += parseFloat(input.value.replace(/,/g, '')) || 0;
  });

  // Transpo Total
  const transpoInput = document.querySelector('input[name="transpoTotal[]"]');
  if (transpoInput) {
    grandTotal += parseFloat(transpoInput.value.replace(/,/g, '')) || 0;
  }

  // Accommodation Total
  const accInput = document.querySelector('input[name="accTotal[]"]');
  if (accInput) {
    grandTotal += parseFloat(accInput.value.replace(/,/g, '')) || 0;
  }

  // Miscellaneous Total
  const miscInput = document.querySelector('input[name="miscTotal[]"]');
  if (miscInput) {
    grandTotal += parseFloat(miscInput.value.replace(/,/g, '')) || 0;
  }

  // Update grand total field
  const grandTotalField = document.getElementById('grandTotal');
  if (grandTotalField) {
    grandTotalField.value = formatNumber(grandTotal).replace(/,/g, '');
  }
}


$(document).ready(function() {
  $('#saveRequest').on('click', function() {
    let projectID = $('#projectID').val();
    let projectName = $('#projectTypeName').val();

    let perdiemItems = [];
    let transpoItems = [];
    let accData = [];
    let miscData = [];

    $('#perDiemBody tr').each(function () {
      let currency = $(this).find('input[name="Currency[]"]').val();
      let rate = $(this).find('input[name="Rate[]"]').val();
      let days = $(this).find('input[name="days[]"]').val();
      let pax = $(this).find('input[name="pax[]"]').val();
      let total = $(this).find('input[name="perdiemTotal[]"]').val();

      if (currency || rate || days || pax || total) {
        perdiemItems.push({ currency, rate, days, pax, total });
      }
    });

    $('#transpoBody tr').each(function () {
      let date = $(this).find('input[name="Date[]"]').val();
      let itemDesc = $(this).find('input[name="itemDesc[]"]').val();
      let from = $(this).find('input[name="From[]"]').val();
      let to = $(this).find('input[name="To[]"]').val();
      let amount = $(this).find('input[name="transAmount[]"]').val();
      let total = $(this).find('input[name="transpoTotal[]"]').val();

      if (date || itemDesc || from || to || amount || total) {
        transpoItems.push({ date, itemDesc, from, to, amount, total });
      }
    });

    $('#accBody tr').each(function () {
      let hotel = $(this).find('input[name="Hotel[]"]').val();
      let dailyRate = $(this).find('input[name="DailyRate[]"]').val();
      let rooms = $(this).find('input[name="rooms[]"]').val();
      let nights = $(this).find('input[name="nights[]"]').val();
      let amount = $(this).find('input[name="accAmount[]"]').val();
      let total = $(this).find('input[name="accTotal[]"]').val();

      if (hotel || dailyRate || rooms || nights || amount || total) {
        accData.push({ hotel, rate: dailyRate, rooms, nights, amount, total });
      }
    });

    $('#miscBody tr').each(function () {
      let particular = $(this).find('input[name="particulars[]"]').val();
      let pax = $(this).find('input[name="miscPax[]"]').val();
      let amount = $(this).find('input[name="miscAmount[]"]').val();
      let total = $(this).find('input[name="miscTotal[]"]').val();

      if (particular || pax || amount || total) {
        miscData.push({ particular, pax, amount, total });
      }
    });

    let formData = {
      projectID,
      projectName,
      status: $('#projstatus').val(),
      requestedby_approval: $('#requestedby_approval').val(),
      requestedby_email: $('#requestedByEmail').val(),
      fileddate_approval: $('#fileddate_approval').val(),
      PersonImplement_approval: $('#PersonImplement_approval').val(),
      Reseller_approval: $('#Reseller_approval').val(),
      Project_approval: $('#Project_approval').val(),
      Contact_approval: $('#Contact_approval').val(),
      Location_approval: $('#Location_approval').val(),
      Emailaddress_approval: $('#Emailaddress_approval').val(),
      Datestart_approval: $('#Datestart_approval').val(),
      Enduser_approval: $('#Enduser_approval').val(),
      Dateend_approval: $('#Dateend_approval').val(),
      ContactPerson_approval: $('#ContactPerson_approval').val(),
      Mandays_approval: $('#Mandays_approval').val(),
      Emailaddress2_approval: $('#Emailaddress2_approval').val(),
      Costmanday_approval: $('#Costmanday_approval').val(),
      Address_approval: $('#Address_approval').val(),
      ProjectCost_approval: $('#ProjectCost_approval').val(),
      PONumber_approval: $('#PONumber_approval').val(),
      SONumber_approval: $('#SONumber_approval').val(),
      Expenses_approval: $('#Expenses_approval').val(),
      PaymentStatus_approval: $('#PaymentStatus_approval').val(),
      Margin_approval: $('#Margin_approval').val(),
      margin: $('#margin1').is(':checked') ? 1 : 0,
      parkedFunds: $('#parkedFunds').is(':checked') ? 1 : 0,
      others: $('#others').is(':checked') ? 1 : 0,
      charged_others: $('#charged_others').val(),
      division1: $('#division1').val(),
      division2: $('#division2').val(),
      prodLine_approval: $('#prodLine_approval').val(),
      DigiOne: $('#DigiOne').is(':checked') ? 1 : 0,
      MarketingEvent: $('#MarketingEvent').is(':checked') ? 1 : 0,
      Travel: $('#Travel').is(':checked') ? 1 : 0,
      Training: $('#Training').is(':checked') ? 1 : 0,
      Promos: $('#Promos').is(':checked') ? 1 : 0,
      Advertising: $('#Advertising').is(':checked') ? 1 : 0,
      Freight: $('#Freight').is(':checked') ? 1 : 0,
      Representation: $('#Representation').is(':checked') ? 1 : 0,
      expenses_Others: $('#expenses_Others').is(':checked') ? 1 : 0,
      expenses_others_input: $('#expenses_others_input').val(),
      grandTotal: $('#grandTotal').val(),
      projRefID: $('#cashRequestIDValue').val(),

      perdiem: perdiemItems,
      transpo: transpoItems,
      accommodation: accData,
      miscFee: miscData
    };

    Swal.fire({
      title: 'Submit for Approval?',
      text: 'Once submitted, the request will be sent for approval and will no longer be editable.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Submit',
      cancelButtonText: 'No, Cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        $('#saveRequest').hide();
        $('#projstatus').html("<div class='alert alert-warning'>For Approval</div>");
        $('#loading-spinner').show();

        $.ajax({
          url: '/save-cash-advance',
          type: 'POST',
          data: formData,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            $('#loading-spinner').hide();
            Swal.fire({
              icon: 'success',
              title: 'Request Submitted!',
              text: 'Please wait for the manager/supervisor to approve your request',
            });
            console.log(response);
          },
          error: function (xhr, status, error) {
            $('#loading-spinner').hide();
            Swal.fire({
              icon: 'error',
              title: 'Submission Failed!',
              text: 'There was an error submitting your request. Please try again.',
            });
            if (xhr.responseJSON) {
              console.error('Response JSON:', xhr.responseJSON);
            }
          }
        });
      } else {
        Swal.fire('Cancelled', 'Your approval request was not submitted.', 'info');
      }
    });
  });
});
document.getElementById('back').addEventListener('click', function () {
  window.close(); // Try to close the tab

  // Fallback: If tab doesn't close, go back or redirect
  setTimeout(() => {
      if (!window.closed) {
          if (document.referrer && document.referrer !== window.location.href) {
              history.back();
          } else {
              window.location.href = '/tab-isupport-service/implementation'; // fallback URL
          }
      }
  }, 200);
});

document.addEventListener('DOMContentLoaded', function () {
    const cashRequestInput = document.getElementById('cashRequestIDValue');

    if (cashRequestInput && !cashRequestInput.value) {
        const reference = Math.floor(100000 + Math.random() * 900000); // 6-digit number
        cashRequestInput.value = reference;
    }
    console.log('Cash Request ID:', cashRequestInput.value);
});