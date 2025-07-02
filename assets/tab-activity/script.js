//datepicker 1st option for date
// document.addEventListener("DOMContentLoaded", function() {
//   flatpickr(".startDate, .endDate, #Date_Filed, #act_date, #stra_dateStart, #stra_dateEnd, #Date_Needed, #modal_poc_dateStart, #modal_poc_dateEnd, #modal_memoIssued, #modal_dateStart, #modal_dateEnd, #date, #activity_date", {
//       dateFormat: "m/d/Y",
//       altInput: true,
//       altFormat: "m/d/Y",
//       allowInput: true,
//       minDate: "05/02/2018",
//       maxDate: "today",
//       yearSelectorType: 'dropdown',
//       onOpen: function(selectedDates, dateStr, instance) {
//         // Custom logic when the calendar opens if needed
//         var inputs = document.querySelectorAll('input[type="number"]');
//         inputs.forEach(function(input) {
//           // Example to hide spinners
//           input.setAttribute('type', 'text'); // Temporarily change type to text
//           // Add your custom spinner or control logic here
//         });
//       }
//   });
// });

//datepicker second option for date
// $(document).ready(function () {
//   var today = new Date();
//   $('.startDate, .endDate, #Date_Filed, #act_date, #stra_dateStart, #stra_dateEnd, #Date_Needed, #modal_poc_dateStart, #modal_poc_dateEnd, #modal_memoIssued, #modal_dateStart, #modal_dateEnd, #date, #activity_date').datepicker({
//     format: 'mm/dd/yyyy',
//     autoclose: true,
//     todayHighlight: true,
//     startView: 1,     // Start with year view
//     // minViewMode: 2,   // Allow navigating to day view
//     startDate: new Date('12/31/2020'),   // Allow navigating to day view
//     endDate: today   // Allow navigating to day view
//   }).on('changeDate', function (e) {
//       // You can add additional validation or formatting here if needed
//   });
// });

$(document).ready(function () {
  // Function to disable dateFrom if StartDate is empty
  function disableDateTo() {
      var startDate = $("#dateFiled").val();
      if (startDate === "") {
          $("#dateNeeded").prop("disabled", true);
          $("#dateNeeded").val("");
      } else {
          $("#dateNeeded").prop("disabled", false);
      }
  }
  // Call the function initially
  disableDateTo();

  // Event listener for changes in StartDate
  $("#dateFiled").change(function () {
      disableDateTo();
  });

  // Event listener for changes in EndDate
  $("#dateNeeded").change(function () {
      // Date Restriction
      var dateFrom = new Date($("#dateFiled").val());
      var dateTo = new Date($("#dateNeeded").val());

      // Check if dateFrom is greater than dateTo
      if (dateFrom > dateTo) {
          Swal.fire({title:"Date error!", text: "Date needed cannot be less than date filed", icon: "error"});
          $("#dateNeeded").val("");
      }
  });
});


$(document).ready(function () {
  // Function to disable dateFrom if StartDate is empty
  function disableDateTo() {
      var modal_dateStart = $("#modal_dateStart").val();
      if (modal_dateStart === "") {
          $("#modal_dateEnd").prop("disabled", true);
          $("#modal_dateEnd").val("");
      } else {
          $("#modal_dateEnd").prop("disabled", false);
      }
  }
  // Call the function initially
  disableDateTo();

  // Event listener for changes in StartDate
  $("#modal_dateStart").change(function () {
      disableDateTo();
  });

  // Event listener for changes in EndDate
  $("#modal_dateEnd").change(function () {
      // Date Restriction
      var modal_dateStart = new Date($("#modal_dateStart").val());
      var modal_dateEnd = new Date($("#modal_dateEnd").val());

      // Check if dateFrom is greater than dateTo
      if (modal_dateStart > modal_dateEnd) {
          Swal.fire({title:"End Date error!", text: "End date cannot be less than start date", icon: "error"});
          $("#modal_dateEnd").val("");
      }
  });
});

$(document).ready(function () {
  // Function to disable dateFrom if StartDate is empty
  function disableDateTo() {
      var modal_poc_dateStart = $("#modal_poc_dateStart").val();
      if (modal_poc_dateStart === "") {
          $("#modal_poc_dateEnd").prop("disabled", true);
          $("#modal_poc_dateEnd").val("");
      } else {
          $("#modal_poc_dateEnd").prop("disabled", false);
      }
  }
  // Call the function initially
  disableDateTo();

  // Event listener for changes in StartDate
  $("#modal_poc_dateStart").change(function () {
      disableDateTo();
  });

  // Event listener for changes in EndDate
  $("#modal_poc_dateEnd").change(function () {
      // Date Restriction
      var modal_poc_dateStart = new Date($("#modal_poc_dateStart").val());
      var modal_poc_dateEnd = new Date($("#modal_poc_dateEnd").val());

      // Check if dateFrom is greater than dateTo
      if (modal_poc_dateStart > modal_poc_dateEnd) {
          Swal.fire({title:"End Date error!", text: "End date cannot be less than start date", icon: "error"});
          $("#modal_poc_dateEnd").val("");
      }
  });
});

  // Trigger the modal when the button is clicked
$('#quick_add_activitybtn').on('click', openModal);
   
   // Function to open the modal and generate ASA number
   function openModal() {
    var referenceNumberField = $('#ref_no');

    // Call the function to generate the ASA number
    var asaNumber = generateASAnumber();

    // Populate the reference number field
    referenceNumberField.val(asaNumber);

    // // Display the modal
    // $('#add_quick_activity').modal('show');
}

function generateASAnumber() {
    var currentDate = new Date();
    var formattedDate = currentDate.toISOString().slice(0, 10).replace(/-/g, '');

    // Generate random 6-digit number
    var randomNumber = String(Math.floor(Math.random() * 99999)).padStart(6, '0');

    // Combine date and random number to create the ASA number
    var asaNumber = formattedDate + '-' + randomNumber;

    return asaNumber;
}

$(document).ready(function () {
  // Fetch the logged-in user and preselect in the dropdown
  $.ajax({
    url: '/getLoggedInUser', // Adjust the route based on your Laravel setup
    method: 'GET',
    success: function (response) {
      if (response && response.engineer && response.email) {
        var loggedInUser = {
          id: response.engineer,
          text: response.engineer,
          email: response.email
        };

        // Preselect the logged-in user in the Select2 dropdown
        $('#engineer').select2({
          width: '100%',
          multiple: true,
          tags: true,
          data: [loggedInUser], // Add the preselected option with email
          ajax: {
            url: '/ldap',
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return { search: params.term };
            },
            processResults: function (data) {
              return {
                results: $.map(data, function (item) {
                  return {
                    id: item.engineer,
                    text: item.engineer,
                    email: item.email || 'No email found'
                  };
                })
              };
            }
          },
          templateResult: function (data) {
            if (data.loading) return data.text;
            return `${data.text} `;
          },
          templateSelection: function (data) {
            return `${data.text}`;
          }
        });

        // Manually trigger change to reflect preselection
        $('#engineer').val([loggedInUser.id]).trigger('change');
      }
    },
    error: function () {
      console.error('Failed to fetch logged-in user details.');
    }
  });

  // Handle selection event
  $('#engineer').on('select2:select', function (e) {
    const selectedOption = e.params.data;

    // Retrieve email
    const email = selectedOption.email || 'No email found';
    console.log(`Adding email: ${email} for engineer: ${selectedOption.text}`);

    if (email !== 'No email found') {
      addEmailToContainer(selectedOption.text, email);
    } else {
      console.warn(`No email found for engineer: ${selectedOption.text}`);
    }
  });

  // Function to add email to container
  function addEmailToContainer(engineerName, email) {
    // Prevent duplicates
    if ($(`#engineer_email_container input[data-engineer="${engineerName}"]`).length === 0) {
      $('#engineer_email_container').append(
        `<input type="hidden" name="engineer_email[]" value="${email}" data-engineer="${engineerName}">`
      );
    } else {
      console.warn(`Email already added for engineer: ${engineerName}`);
    }
  }

  // Debug all selected options
  $('#engineer').on('change', function () {
    const selectedOptions = $('#engineer').select2('data');
    $('#engineer_email_container').empty(); // Clear previous entries
  
    selectedOptions.forEach(option => {
      if (option.email) {
        addEmailToContainer(option.text, option.email);
      } else {
        console.warn(`No email found for engineer: ${option.text}`);
      }
    });
  });
  
});


$(document).ready(function () {
  $('#prod_engineers').select2({
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

    // Activity Details send copy to managers/supervisors
    $(document).ready(function() {
      // Initialize Select2 with static data
      $('#send_copy_to').select2({
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
                            text: item.engineer, // And display text
                            email: item.email, // Add the engineer's email
                        };
                    }).sort(function(a, b) {
                        // Compare the engineer names (text) to sort them alphabetically
                        return a.text.localeCompare(b.text);
                    })
                };
            }
        },
        templateResult: function(data) {
  
                return data.text;
    
        },
        escapeMarkup: function(markup) {
            return markup;
        }
    });

    // Event listener for changes in the selected team members
    $('#send_copy_to').on('change', function (e) {
        var selectedEngineers = $(this).select2('data');
        var emails = selectedEngineers.map(function (engineer) {
            return engineer.email; // Extract the email of each selected engineer
        }).join(', ');

        // Extract the creation date of the first selected engineer
        var creationDate = selectedEngineers.length > 0 ? selectedEngineers[0].created_date : '';

        $('#copyToManagerEmail').val(emails); // Set the value of the hidden input for emails
    });
  });

// Activity Summary Report containing Time 

$(document).ready(function () {
  // Initialize Select2 for the engineers dropdown
  $('.get_time').select2({
      width: '100%',
      multiple: false,
      // minimumInputLength: 1, // Minimum characters to start searching
      tags: false, // Allow custom values not available in the dropdown
      ajax: {
          url: '/tab-activity/create-activity/getTime',
          dataType: 'json',
          // delay: 250, // Delay in milliseconds before making the request
          data: function (params) {
              return {
                  term: params.term, // Pass the search term to the server
              };
          },
          processResults: function (response) {
            return {
                results: response.data
            };
        }
      },

  });
});
$(document).ready(function () {
  function convertToMinutes(time) {
      const [timeStr, period] = time.split(' ');
      let [hours, minutes] = timeStr.split(':').map(Number);
      if (period === 'PM' && hours !== 12) hours += 12;
      if (period === 'AM' && hours === 12) hours = 0;
      return hours * 60 + minutes;
  }

  function isBeforeOrEqualTo(time, compareTime) {
      return convertToMinutes(time) <= convertToMinutes(compareTime);
  }

  function isAfterOrEqualTo(time, compareTime) {
      return convertToMinutes(time) >= convertToMinutes(compareTime);
  }

  function isBefore630AM(time) {
      return convertToMinutes(time) <= convertToMinutes('5:30 AM');
  }

  function sortTimes(a, b) {
      const aMinutes = convertToMinutes(a.text);
      const bMinutes = convertToMinutes(b.text);

      if (isBefore630AM(a.text) && !isBefore630AM(b.text)) return 1;
      if (!isBefore630AM(a.text) && isBefore630AM(b.text)) return -1;
      return aMinutes - bMinutes;
  }

  function initializeSelect2(selector, filterFunc, sortFunc) {
      $(selector).select2({
          width: '100%',
          ajax: {
              url: '/tab-activity/create-activity/getTime',
              dataType: 'json',
              data: function (params) {
                  return { term: params.term };
              },
              processResults: function (response) {
                  if (Array.isArray(response.data)) {
                      let filteredData = filterFunc(response.data);
                      filteredData.sort(sortFunc);
                      return {
                          results: filteredData.map(function (time) {
                              return { id: time.id, text: time.text };
                          })
                      };
                  } else {
                      console.error('Invalid response data:', response);
                      return { results: [] };
                  }
              }
          }
      });
  }

  function updateTimeReportedDropdown() {
      const selectedTimeExitedText = $('#time_exited').val() ? $('#time_exited option:selected').text() : '11:59 PM';
      initializeSelect2('#time_reported', (data) => {
          return data.filter(time => isBeforeOrEqualTo(time.text, selectedTimeExitedText));
      }, sortTimes);
  }

  function updateTimeExitedDropdown() {
      const selectedTimeReportedText = $('#time_reported').val() ? $('#time_reported option:selected').text() : '12:00 AM';
      initializeSelect2('#time_exited', (data) => {
          return data.filter(time => {
              return isAfterOrEqualTo(time.text, selectedTimeReportedText) || isBefore630AM(time.text);
          });
      }, sortTimes);
  }

  // Initialize dropdowns
  updateTimeReportedDropdown();
  updateTimeExitedDropdown();

  // Listen for changes
  $('#time_reported').on('change', function () {
      updateTimeExitedDropdown();
  });

  $('#time_exited').on('change', function () {
      updateTimeReportedDropdown();
  });
});




///////////////////////--Show/Hides Forms--//////////////////////////////////////////////
$(document).ready(function () {
  // Default hide
  hideAllElements();

  // Initialize Select2 for Program_Create
  // $('#Program_Create').select2({
  //   placeholder: 'Select a program'
  // });

  // Event listener for reportDropdown change
  $('#reportDropdown').change(function () {
    var category = $(this).val();
    console.log(category);

    // Make an AJAX request to fetch activity types
    $.ajax({
      url: `/getActivityTypes/${encodeURIComponent(category)}`,
      dataType: 'json',
      success: function (data) {
        // Initialize Select2 with the fetched data and no default selection
        $('#Activity_Type_Create').empty().select2({
          width: '100%',
          data: $.map(data, function (activityType) {
            return {
              id: activityType,
              text: activityType
            };
          }),
          placeholder: "Select Activity Type"
        }).val(null).trigger('change'); // Set no option selected

        // Attach event listener to Activity_Type_Create after it is populated
        $('#Activity_Type_Create').change(function () {
          handleDropdownChanges();
        });
      },
      error: function () {
        console.error('Failed to fetch data');
      }
    });

    // Make an AJAX request to fetch program data
    $.ajax({
      url: `/getProgram/${encodeURIComponent(category)}`,
      dataType: 'json',
      success: function (data) {
        // Clear existing options and add new options with placeholder
        $('#Program_Create').empty().select2({
          width: '100%',
          data: $.map(data, function (program) {
            return {
              id: program,
              text: program
            };
          }),
          placeholder: 'Select a program'
        }).val(null).trigger('change'); // Set no option selected

        // Attach event listener to Program_Create after it is populated
        $('#Program_Create').change(function () {
          handleDropdownChanges();
        });
      },
      error: function () {
        console.error('Failed to fetch data');
      }
    });
  });

  // Attach event listener to act_dropdrown to handle initial change event
  $('.act_dropdrown').change(function () {
    handleDropdownChanges();
  });

  function handleDropdownChanges() {
    var report = $("#reportDropdown").val();
    var status = $("#statusDropdown").val();
    var selectedActivity = $("#Activity_Type_Create").val();
    var selectedProgram = $("#Program_Create").val();

    // Update your switch cases as necessary to handle changes based on selectedActivity and selectedProgram
    switch (report) {
      case "1":
        handleSupportServices(status);
        break;
      case "2":
        handleISupportServices(status);
        break;
      case "3":
        handleClientCalls(status, selectedActivity);
        break;
      case "4":
        handleInternalEnablement(status, selectedProgram);
        break;
      case "5":
      case "6":
        handlePartnerEnablement(status, selectedProgram);
        break;
      case "7":
        handleSkillsDevelopment(status, selectedActivity);
        break;
      case "8":
        handleOthers(status, selectedActivity);
        break;
      default:
        hideAllElements();
    }
  }

  function handleSupportServices(status) {
    if (status === "1") {
      showForms(["act_details", "contract_details", "newAct_Btn"]);
    } else if (status === "2" || status === "3" || status === "4" || status === "5") {
      showForms([
        "act_details", "contract_details", "act_summary_report", "MultiParticipant",
        "customer_req", "time_form", "venue_form", "act_done", "agreements",
        "act_plan_recommendation", "attachment", "newAct_Btn"
      ]);
    }
  }

  function handleISupportServices(status) {
    if (status === "1") {
      showForms(["act_form", "contract_details", "act_summary_report", "new_Activity_ProjNameDropdown", "new_Activity_ProjTypeDropdown", "newAct_Btn", "time_form", "venue_form"]);
    } else if (status === "2" || status === "3" || status === "4" || status === "5") {
      showForms([
        "act_form", "contract_details", "act_summary_report", "MultiParticipant",
        "customer_req", "act_done", "agreements", "act_plan_recommendation", "attachment",
        "newAct_Btn", "time_form", "venue_form", "new_Activity_ProjNameDropdown", "new_Activity_ProjTypeDropdown" 
      ]);
    } else if (status === "na") {
      // If status is "na", handle it differently
      hideForms(["new_Activity_ProjNameDropdown", "new_Activity_ProjTypeDropdown"]);
    }
  }
  

  function handleClientCalls(status, selectedValue) {
    if (selectedValue === "POC (Proof of Concept)" && status === "1") {
      showForms(["act_form", "contract_details", "act_summary_report", "newAct_Btn", "OthersTopicCard", "pocCardBody", "time_form", "venue_form", "dateStartEnd"]);
    } else if (selectedValue === "POC (Proof of Concept)" && (status === "2" || status === "3" || status === "4" || status === "5")) {
      showForms([
        "act_form", "contract_details", "act_summary_report", "MultiParticipant",
        "customer_req", "act_done", "agreements", "act_plan_recommendation", "attachment",
        "newAct_Btn", "time_form", "venue_form", "OthersTopicCard", "pocCardBody", "dateStartEnd"
      ]);
    } else {
      // Check if status is one of the specified values
      if (["2", "3", "4", "5"].includes(status)) {
        showForms(["act_form", "contract_details", "act_summary_report", "newAct_Btn", "MultiParticipant",
        "customer_req", "act_done", "agreements", "act_plan_recommendation", "attachment", "time_form", "venue_form"]);
      } else {
        showForms(["act_form", "contract_details", "act_summary_report", "newAct_Btn" , "time_form", "venue_form" ]);
      }
    }
  }

  function handleInternalEnablement(status, selectedProgram) {
    // If selectedProgram is "PKOC / MSLC" and status is 1
    if (selectedProgram === "PKOC / MSLC" && status === "1") {
      showForms(["act_form", "act_summary_report", "newAct_Btn", "time_form", "OthersTopicCard", "topic_input", "venue_form", "dateStartEnd"]);
    } 
    // If selectedProgram is "PKOC / MSLC" and status is 2, 4, or 5
    else if (selectedProgram === "PKOC / MSLC" && (status === "2" || status === "3" || status === "4" || status === "5")) {
      showForms([
        "act_form", "act_summary_report", "MultiParticipant", "customer_req", "act_done",
        "agreements", "act_plan_recommendation", "attachment", "newAct_Btn", "time_form", "venue_form",
        "OthersTopicCard", "topic_input", "dateStartEnd" // Include OthersTopicCard and topic_input here
      ]);
    } else {
      if (status === "1") {
        showForms(["act_form", "act_summary_report", "newAct_Btn", "time_form", "venue_form"]);
      } else if (status === "2" || status === "3" || status === "4" || status === "5") {
        showForms([
          "act_form", "act_summary_report", "MultiParticipant", "customer_req", "act_done",
          "agreements", "act_plan_recommendation", "attachment", "newAct_Btn", "time_form", "venue_form"
        ]);
      }
    }
  }
  
  function handlePartnerEnablement(status, selectedProgram) {
    if (selectedProgram === "sTraCert" && status === "1") {
      showForms(["act_form", "contract_details", "act_summary_report", "time_form", "newAct_Btn", "venue_form", "OthersTopicCard", "topic_input", "dateStartEnd"]);
    } else if (selectedProgram === "sTraCert" && (status === "2" || status === "3" || status === "4" || status === "5")) {
      showForms([
        "act_form", "contract_details", "act_summary_report", "MultiParticipant",
        "customer_req", "act_done", "agreements", "act_plan_recommendation", "attachment",
        "newAct_Btn", "time_form", "venue_form", "OthersTopicCard", "topic_input", "dateStartEnd",
      ]);
    } else {
      if (status === "1") {
        showForms(["act_form", "contract_details", "act_summary_report", "time_form", "newAct_Btn", "venue_form"]);
      } else if (status === "2" || status === "3" || status === "4" || status === "5") {
        showForms([
          "act_form", "contract_details", "act_summary_report", "MultiParticipant",
          "customer_req", "act_done", "agreements", "act_plan_recommendation", "attachment",
          "newAct_Btn", "time_form", "venue_form"
        ]);
      }
    } 
  }
  

  function handleSkillsDevelopment(status, selectedValue) {
    if (["1", "2", "3", "4", "5"].includes(status)) {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn"]);
    }
    if (selectedValue === "Sales Certification" || selectedValue === "Technical Certification") {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn", "examStatus"]);
    } else if (selectedValue === "Technology or Product Skills Devt") {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn", "techProdCardbody"]);
    } else if (["Vendor Training", "Bootcamp Attended", "TCT (Technology Cross Training) - Attended", "TPS Led Softskills Training", "HR-Led Training"].includes(selectedValue)) {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn", "trainingCardBody"]);
    }
  }

  function handleOthers(status, selectedValue) {
    if (["1", "2", "3", "4", "5"].includes(status)) {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn",  "venue_form"]);
    }
    if (selectedValue === "DIGIKnow") {
      showForms(["act_form", "act_summary_report", "newAct_Btn", "OthersTopicCard", "othersDigiKnow", "venue_form"]);
    } else if (selectedValue === "Internal Project") {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn", "OthersTopicCard", "otherInternalProject", "venue_form"]);
    } else if (selectedValue === "Perfect Attendance under Merit") {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn", "OthersTopicCard", "attendancePerfect", "venue_form"]);
    } else if (selectedValue === "Memo from HR under Demerit") {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn", "OthersTopicCard", "othersMemo", "venue_form"]);
    } else if (selectedValue === "Feedback On Engineer") {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn", "OthersTopicCard", "engrFeedback", "venue_form"]);
    } else if (selectedValue === "Train To Retain (T2R)") {
      showForms(["act_form", "act_summary_report", "attachment", "newAct_Btn", "OthersTopicCard", "topic_input", "dateStartEnd", "venue_form"]);
    }
  }
});



function hideAllElements() {
  $("#act_form, #act_details, #contract_details, #act_summary_report, #MultiParticipant, #customer_req, #act_done, #agreements, #act_plan_recommendation, #attachment," +
  " #new_Activity_ProjNameDropdown, #new_Activity_ProjTypeDropdown, #newAct_Btn, #techProdCardbody, #trainingCardBody, #examStatus , #venue_form, #OthersTopicCard, #topic_input, #othersDigiKnow, #otherInternalProject, #attendancePerfect, #othersMemo, #engrFeedback, #time_form," +
"#pocCardBody, #dateStartEnd" ).hide();
}

function showForms(formIds) {
  hideAllElements();  // First, hide all elements
  formIds.forEach(function (formId) {
    $("#" + formId).show();  // Show the specified forms
  });
}


///////////////////////--Enable/Disabled Project Type/Name--//////////////////////////////////////////////

// document.getElementById('reportDropdown').addEventListener('change', function () {
//   var reportValue = this.value;
//   var projTypeDropdown = document.getElementById('projtype_button');
//   var projectNameDropdown = document.getElementById('myDropdown');

//   // Check if the selected report is 'iSupport Services'
//   if (reportValue === '2') {
//     // Enable the other two buttons
//     projTypeDropdown.disabled = false;
//     projectNameDropdown.disabled = false;

//   }
// });

///////////////////////--Connect Project Type Button to Project Name--//////////////////////////////////////////////


$(document).ready(function () {
  $('#projtype_button').change(function () {
    $('#myDropdown').select2({
      width: '100%',
    });

    var projectType = $(this).val();
    var projecttypenumber = 0;

    if (projectType === "1") {
      projecttypenumber = 1;
    } else if (projectType === "2") {
      projecttypenumber = 2;
    }

    if (projecttypenumber !== 0) {
      $('#myDropdown').prop('disabled', true).html('<option>Loading...</option>');

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: '/tab-activity/create-activity/getProjectName',
        type: 'GET',
        data: {
          projecttypenumber: projecttypenumber
        },
        success: function (response) {
          // Clear existing options
          $('#myDropdown').empty();
          
          // Append a default option
          $('#myDropdown').append('<option value="" disabled selected>--Select Project Name--</option>');
          
          // Append new options with both id and proj_name
          $.each(response, function (index, value) {
            $('#myDropdown').append('<option value="' + value.id + '">' + value.proj_name + '</option>');
          });
          
          // Enable the dropdown
          $('#myDropdown').prop('disabled', false);
        },
        error: function (xhr) {
          console.log(xhr.responseText);
        }
      });
    } else {
      // If no project type selected, disable and empty the second dropdown
      $('#myDropdown').prop('disabled', true).empty();
      // $('#myDropdown').append('<option value="" disabled selected>--Select Project Name--</option>');
    }
  });

  // Update hidden input when a project is selected
  $('#myDropdown').change(function () {
    var selectedProjectId = $(this).val(); // Get the selected project's ID
    console.log('Selected Project ID:', selectedProjectId); // Log the selected ID to the console
    $('#selectedProjectId').val(selectedProjectId); // Set the hidden input value to the selected ID
  });
});



////////////////////////// Participants and Positions Cloning //////////////////////////////////

$(document).ready(function () {
// Add new participant and position field
$(".card-body").on("click", ".add-field", function () {
  // Clone the first set of fields
  var newFields = $(".cloned-fields:first").clone();

  // Show both "Add" and "Remove" buttons in the new clone
  newFields.find('.add-field, .remove-field').show();

  // Clear the values in the cloned input fields
  newFields.find('input').val('');

  // Append the cloned fields after the current set of fields
  $(this).closest('.cloned-fields').after(newFields);
});

  // Remove participant and position field with confirmation
  $(".card-body").on("click", ".remove-field", function (e) {
    e.preventDefault(); // Prevent the default action

    var $this = $(this); // Store the reference to the clicked element

    Swal.fire({
      title: 'Delete',
      text: "Are you sure you want to remove this participant?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, remove it!',
      cancelButtonText: 'No, keep it'
    }).then((result) => {
      if (result.isConfirmed) {
        $this.closest('.cloned-fields').remove();
        Swal.fire(
          'Deleted!',
          'The field has been removed.',
          'success'
        );
      }
    });
  });

  // Initially hide the "Remove" button in the template
  $(".cloned-fields:first .remove-field").hide();
});


////////////////////////// Action Plan / Recommendation Cloning//////////////////////////////////

$(document).ready(function () {
// Add new participant and position field
$(".card-body").on("click", ".add-field1", function () {
  // Clone the first set of fields
  var clonefields = $(".cloned-action-plan-recommendation:first").clone();

  // Show both "Add" and "Remove" buttons in the new clone
  clonefields.find('.add-field1, .remove-field1').show();

  // Clear the values in the cloned input fields
  clonefields.find('input, textarea').val('');

  // Append the cloned fields after the current set of fields
  $(this).closest('.cloned-action-plan-recommendation').after(clonefields);
});

  // Remove participant and position field with confirmation
  $(".card-body").on("click", ".remove-field1", function (e) {
    e.preventDefault(); // Prevent the default action

    var $this = $(this); // Store the reference to the clicked element

    Swal.fire({
      title: 'Delete',
      text: "Are you sure you want to delete this field?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, keep it'
    }).then((result) => {
      if (result.isConfirmed) {
        $this.closest('.cloned-action-plan-recommendation').remove();
        Swal.fire(
          'Deleted!',
          'The field has been removed.',
          'success'
        );
      }
    });
  });

  // Initially hide the "Remove" button in the template
  $(".cloned-action-plan-recommendation:first .remove-field1").hide();
});



$(document).ready(function () {
  $('#product_line_select').select2({
      width: '100%',
      multiple: true,
      ajax: {
          url: '/tab-experience-center/productLine/getProductline',
          dataType: 'json',
          delay: 250,
          data: function (params) {
              return {
                  term: params.term
              };
          },
          processResults: function (response) {
              if (Array.isArray(response.data)) {
                  return {
                      results: response.data.map(function (getProductline) {
                          return {
                              id: getProductline.flex_value_id,
                              text: getProductline.description,
                              code: getProductline.flex_value // Store the product code in a 'code' attribute
                          };
                      })
                  };
              } else {
                  console.error('Response data is not an array:', response.data);
                  return { results: [] };
              }
          },
          error: function (xhr, status, error) {
              console.error('Error fetching product lines:', error);
          }
      }
  });

  // Event listener for changes in the selected product lines
  $('#product_line_select').on('select2:select', function (e) {
      updateProductCode();
      updateProductCodeAuto();
  });

  $('#product_line_select').on('change', function() {
    updateProductLine();
    updateProductCodeAuto();
});

//automatic productCode application
function updateProductCodeAuto() {
  var selectedProductLines = $('#product_line_select').select2('data');
  var productCodes = selectedProductLines.map(function(productLine) {
      return productLine.code; // Extract the product code from the 'code' attribute
  }).join('; ');
  
  // Update the value of the 'prod_code' input field with the product codes of the selected product lines
  $('#prod_code').val(productCodes);
}

//for passing data of productline and productCode
function updateProductLine() {
  var selectedProductLines = $('#product_line_select').select2('data');
  var productLineDescriptions = selectedProductLines.map(function(productLine) {
      return productLine.text; // Retrieve the description instead of the value
  }).join(', ');
  $('#product_line_input').val(productLineDescriptions);
}

  function updateProductCode() {
      var selectedProductLines = $('#product_line_select').select2('data');
      var productCodes = selectedProductLines.map(function(productLine) {
          return productLine.code; // Extract the product code from the 'code' attribute
      }).join(', ');
      
      // Update the value of the 'prod_code' input field with the product codes of the selected product lines
      $('#prod_code_input').val(productCodes);

  }
});

// /////////////////////////////////// Activity Type ////////////////////////////////////

// $(document).ready(function() {
//   $('#reportDropdown').change(function() {
//     var category = $(this).val();
//     console.log(category);

//     // Make an AJAX request to fetch data
//     $.ajax({
//       url: `/getActivityTypes/${encodeURIComponent(category)}`,
//       dataType: 'json',
//       success: function(data) {
//         // Initialize Select2 with the fetched data and no default selection
//         $('#Activity_Type_Create').empty().select2({
//           width: '60%',
//           data: $.map(data, function (activityType) {
//             return {
//               id: activityType,
//               text: activityType
//             };
//           }),
//           placeholder: "Select Activity Type"
//         }).val(null).trigger('change'); // Set no option selected
//       },
//       error: function() {
//         console.error('Failed to fetch data');
//       }
//     });
//   });
// });


/////////////////////////////////// Program ////////////////////////////////////

// $(document).ready(function() {
//   // Initialize Select2 with placeholder and allowClear
//   $('#Program_Create').select2({
//     width: '100%',
//     placeholder: 'Select a program'
//   });

//   // When dropdown is clicked
//   $('#reportDropdown').on('click', function() {
//     var category = $(this).val();
//     console.log(category);

//     // Fetch data and update Select2 options
//     $.ajax({
//       url: `/getProgram/${encodeURIComponent(category)}`,
//       dataType: 'json',
//       success: function(data) {
//         // Clear existing options and add new options with placeholder
//         $('#Program_Create').empty().select2({
//           width: '100%',
//           data: $.map(data, function(activityType) {
//             return {
//               id: activityType,
//               text: activityType
//             };
//           }),
//           placeholder: 'Select a program', // Ensure the placeholder is included
//         }).val(null).trigger('change'); // Set no option selected
//       },
//       error: function() {
//         console.error('Failed to fetch data');
//       }
//     });
//   });
// });
 // Function to trigger the date/month picker when the input gains focus
 document.querySelectorAll('input[type="month"], input[type="date"]').forEach(function(input) {
  input.addEventListener('click', function(event) {
      // If the input already has focus, call showPicker again
      if (document.activeElement === this && this.showPicker) {
          this.showPicker();
      }
  });
});

 // Add event listener to scoreDropdown
 document.getElementById('scoreDropdown').addEventListener('change', function() {
  var scoreDropdownValue = this.value; // Fetch the selected value
  console.log('Selected Score:', scoreDropdownValue); // Log the value to console
});

// You can also log the initial value if needed
var scoreDropdownInput = document.getElementById('scoreDropdown');
var initialScoreDropdownValue = scoreDropdownInput ? scoreDropdownInput.value : '';
console.log('Initial Selected Score:', initialScoreDropdownValue);


// Initialize tooltips
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

// Validation function (Now allowing text and numbers)
function validateInput(inputElement) {
  inputElement.addEventListener('input', function (e) {
      // Remove tooltip visibility check based on input type
      if (e.target.value !== '') {
          // You can implement any other checks here, such as length validation
          $(inputElement).tooltip('hide'); // Hide tooltip if input is valid (allowing text and numbers)
      }
  });
}

// Get the input elements
var resellersContactInput = document.getElementById('resellersContact');
var endUserContactInput = document.getElementById('endUserContact');

// Apply validation to both input elements
validateInput(resellersContactInput);
validateInput(endUserContactInput);

document.getElementById('updateForm').addEventListener('submit', function(event) {
  // Prevent the form from submitting
  event.preventDefault();
  // Reset previous indicators
  resetIndicators();

  var reportVal = document.getElementById('reportDropdown').value;
  var activityTypeDropdownValue = document.getElementById('Activity_Type_Create').value;
  var statusDropdownValue = document.getElementById('statusDropdown').value;
  var venueInput = document.getElementById('venue');

  var projtype_buttonError = document.getElementById('projtype_buttonError');
  var myDropdownError = document.getElementById('myDropdownError');
  var activityError = document.getElementById('activityError');
  var activityError1 = document.getElementById('activityError1');
  var copyToError = document.getElementById('copyToError');
  var prodengrError = document.getElementById('prodengrError');
  var resellersError = document.getElementById('resellersError');
  var resellersContactError = document.getElementById('resellersContactError');
  var resellersEmailError = document.getElementById('resellersEmailError');
  var actTypeError = document.getElementById('actTypeError');
  var programError = document.getElementById('programError');
  var productLineError = document.getElementById('productLineError');
  var engrError = document.getElementById('engrError');
  var venueError = document.getElementById('venueError');
  var trainingNameError = document.getElementById('trainingNameError');
  var locationError = document.getElementById('locationError');
  var speakerNameError = document.getElementById('speakerNameError');
  var technologyError = document.getElementById('technologyError');
  var examCodeError = document.getElementById('examCodeError');
  var TakeStatusError = document.getElementById('TakeStatusError');
  var scoreError = document.getElementById('scoreError');
  var topicError = document.getElementById('topicError');
  var dateStartError = document.getElementById('dateStartError');
  var dateEndError = document.getElementById('dateEndError');
  var prodModError = document.getElementById('prodModError');
  var assetError = document.getElementById('assetError');
  var pocDateStartError = document.getElementById('pocDateStartError');
  var pocDateEndError = document.getElementById('pocDateEndError');
  var digiKnowFileError = document.getElementById('digiKnowFileError');
  var msiProjError = document.getElementById('msiProjError');
  var comPercentError = document.getElementById('comPercentError');
  var perfectAttError = document.getElementById('perfectAttError');
  var memoIssuedError = document.getElementById('memoIssuedError');
  var memoDetailsError = document.getElementById('memoDetailsError');
  var engrFeedbackError = document.getElementById('engrFeedbackError');
  var engrRatingError = document.getElementById('engrRatingError');
  var recipientsError = document.getElementById('recipientsError');
  var attendeesError = document.getElementById('attendeesError');
  var time_expectedError = document.getElementById('time_expectedError');
  var time_reportedError = document.getElementById('time_reportedError');
  var time_exitedError = document.getElementById('time_exitedError');

  var projTypeSelect = document.getElementById('projtype_button');
  if (projTypeSelect  && projTypeSelect.offsetParent !== null && projTypeSelect.value.length === 0) {
    Swal.fire({ text: "Project Type is required", icon: "warning"});
    addIndicator(projTypeSelect);
    // Scroll to the location of the indicator error
    projtype_buttonError.innerText = "Please select Project Type";
    // scrollToElement(prodEngineersSelect);
    return;
  }else {
    // Clear error message if input is valid
    projtype_buttonError.innerText = '';
  }

  var myDropdownSelect = document.getElementById('myDropdown');
  if (myDropdownSelect  && myDropdownSelect.offsetParent !== null && myDropdownSelect.value.length === 0) {
    Swal.fire({ text: "Project Name is required", icon: "warning"});
    addIndicator(myDropdownSelect);
    // Scroll to the location of the indicator error
    myDropdownError.innerText = "Please select Project Name";
    // scrollToElement(prodEngineersSelect);
    return;
  }else {
    // Clear error message if input is valid
    myDropdownError.innerText = '';
  }

  // Check if the activity input field is visible and required
  var activityInput = document.getElementById('activityinput');
  if (activityInput && activityInput.offsetParent !== null && activityInput.value.trim() === '') {
      // If the field is visible and empty, show an error message
      Swal.fire({ text: "Please specify the activity details", icon: "warning"});
      
      // Add indicator
      addIndicator(activityInput);
      activityError1.innerText = "Please specify the activity details";
      // Scroll to the location of the indicator error
      // scrollToElement(activityInput);
      return; // Prevent form submission
  }

    // Check if the activity input field is visible and required
    var activitybodyInput = document.getElementById('activitybodyInput');
    if (activitybodyInput && activitybodyInput.offsetParent !== null && activitybodyInput.value.trim() === '') {
        // If the field is visible and empty, show an error message
        Swal.fire({ text: "Please specify the activity details.", icon: "warning"});
        // Add indicator
        addIndicator(activitybodyInput);
       // Show an error message
        activityError.innerText = "Please specify the activity details";
        // Scroll to the location of the indicator error
        // scrollToElement(activitybodyInput);
        return; // Prevent form submission
    } else {
      // Clear error message if input is valid
      activityError.innerText = '';
    }
  
  // Check if Product Engineers Only field is filled out
  var prodEngineersSelect = document.getElementById('prod_engineers');
  if (prodEngineersSelect  && prodEngineersSelect.offsetParent !== null && prodEngineersSelect.value.length === 0) {
    Swal.fire({ text: "Please select at least one product engineer", icon: "warning"});
    addIndicator(prodEngineersSelect);
    // Scroll to the location of the indicator error
    prodengrError.innerText = "Please select at least one Product Engineers";
    // scrollToElement(prodEngineersSelect);
    return;
  }else {
    // Clear error message if input is valid
    prodengrError.innerText = '';
  }

    // Check if Copy to field is filled out
    var sendCopyToSelect = document.getElementById('send_copy_to');
    if (sendCopyToSelect && sendCopyToSelect.offsetParent !== null && sendCopyToSelect.value.length === 0) {
        Swal.fire({ text: "Please notify the Manager, Supervisor, and / or Secondary Engineer for the PL. Kindly fill up Copy To field.", icon: "warning"});
        // Add indicator
        addIndicator(sendCopyToSelect);
        copyToError.innerText = "Please specify the Manager to be notified";
        // Scroll to the location of the indicator error
        // scrollToElement(sendCopyToSelect);
        return;
    }

   // Check if Engineers Only field is filled out
   var EngineersSelect = document.getElementById('engineer');
   if (EngineersSelect  && EngineersSelect.offsetParent !== null && EngineersSelect.value.length === 0) {
     Swal.fire({ text: "Please Specify Engineer Involved", icon: "warning"});
     addIndicator(EngineersSelect);
     engrError.innerText = "Please specify the Engineer who accomplished the activity";
     // Scroll to the location of the indicator error
    //  scrollToElement(EngineersSelect);
     return;
   }
  
  
  // Check if Resellers field is filled out
  var resellersInput = document.getElementById('resellers');
  if (resellersInput && resellersInput.offsetParent !== null && resellersInput.value.trim() === '') {
      Swal.fire({ text: "Please Specify the reseller.", icon: "warning"});
      // Add indicator
      addIndicator(resellersInput);
          resellersError.innerText = "Please specify the Reseller";
      // Scroll to the location of the indicator error
      // scrollToElement(resellersInput);
      return;
  }
  
  // Check if Resellers Contact # field is filled out
  var resellersContactInput = document.getElementById('resellersContact');
  if (resellersContactInput && resellersContactInput.offsetParent !== null && resellersContactInput.value.trim() === '') {
      // alert('Please Specify the person to talk in ' + $('#resellers').val());

      Swal.fire({
        text: 'Please specify the contact number of  ' + $('#resellers').val(),
        icon: 'warning'
      });

      // Add indicator
      addIndicator(resellersContactInput);
      resellersContactError.innerText = "Please specify the Reseller's contact number";
      // Scroll to the location of the indicator error
      // scrollToElement(resellersContactInput);
      return;
  }
  
  var resellersEmailInput = document.getElementById('resellersEmail');
  var sendCopyToInput = document.getElementById('send_copy_To');
  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
  if (resellersEmailInput && resellersEmailInput.offsetParent !== null) {
      if (resellersEmailInput.value.trim() === '') {
          Swal.fire({
              text: 'Please specify the email address of ' + $('#resellers').val(),
              icon: 'warning'
          });
  
          // Add indicator
          addIndicator(resellersEmailInput);
          resellersEmailError.innerText = "Please specify the Reseller's email address";
          // Scroll to the location of the indicator error
          // scrollToElement(resellersEmailInput);
          return;
      }
  }

  if (sendCopyToInput && sendCopyToInput.offsetParent !== null) {
    var emails = sendCopyToInput.value.split(',');
    var invalidEmails = emails.filter(function(email) {
        return email.trim() !== '' && !emailPattern.test(email.trim());
    });

    if (invalidEmails.length > 0) {
        Swal.fire({
            text: 'Please enter valid email addresses separated by commas.',
            icon: 'warning'
        });

        // Add indicator
        addIndicator(sendCopyToInput);
        document.getElementById('emailError').style.display = 'block';
        // Scroll to the location of the indicator error
        // scrollToElement(sendCopyToInput);
        return;
    } else {
      document.getElementById('emailError').style.display = 'none';
  }
  }

  if (reportVal !== '1'){
  var programdropdown = document.getElementById('Program_Create');
  if (programdropdown  && programdropdown.offsetParent !== null && programdropdown.value.length === 0) {
    Swal.fire({ text: "Please specify a program the activity is related to. Click NONE if it is not related to anything.", icon: "warning"});
    addIndicator(programdropdown);
     programError.innerText = "Please specify a program";
    // Scroll to the location of the indicator error
    // scrollToElement(programdropdown);
    return;
  }
  }

 if (reportVal === '2' || reportVal === '3' || reportVal === '4' || reportVal === '5' || reportVal === '6' || reportVal === '8'){
  var activityTypeDropdown = document.getElementById('Activity_Type_Create');
  if (activityTypeDropdown  && activityTypeDropdown.offsetParent !== null && activityTypeDropdown.value.length === 0) {
    Swal.fire({ text: "Please specify the activity type.", icon: "warning"});
    addIndicator(activityTypeDropdown);
    actTypeError.innerText = "Please specify the activity Type";
    // Scroll to the location of the indicator error
    // scrollToElement(activityTypeDropdown);
    return;
  }
 }

 if (reportVal === '3'){
    var prodModelInput = document.getElementById('modal_prodModel');
    var assetCodeInput = document.getElementById('modal_assetCode');
    var dateStart = document.getElementById('modal_poc_dateStart');
    var dateEnd = document.getElementById('modal_poc_dateEnd');

   if (activityTypeDropdownValue === 'POC (Proof of Concept)') {
    if (prodModelInput  && prodModelInput.offsetParent !== null && prodModelInput.value.trim() === '') {
      Swal.fire({ text: "Please specify the product model.", icon: "warning"});
      addIndicator(prodModelInput);    
      prodModError.innerText = "Please specify the Product Model.";
      // Scroll to the location of the indicator error
      // scrollToElement(prodModelInput);
      return;
    }
    if (assetCodeInput  && assetCodeInput.offsetParent !== null && assetCodeInput.value.trim() === '') {
      Swal.fire({ text: "Please specify the asset code.", icon: "warning"});
      addIndicator(assetCodeInput);
      assetError.innerText = "Please specify the Asset Code.";
      // Scroll to the location of the indicator error
      // scrollToElement(assetCodeInput);
      return;
    }
    if (dateStart  && dateStart.offsetParent !== null && dateStart.value.trim() === '') {
      Swal.fire({ text: "Please specify the start date.", icon: "warning"});
      addIndicator(dateStart);
       pocDateStartError.innerText = "Please specify the start date.";
      // Scroll to the location of the indicator error
      // scrollToElement(dateStart);
      return;
    }
    if (dateEnd  && dateEnd.offsetParent !== null && dateEnd.value.trim() === '') {
      Swal.fire({ text: "Please specify the end date.", icon: "warning"});
      addIndicator(dateEnd);
      pocDateEndError.innerText = "Please specify the end date.";
      // Scroll to the location of the indicator error
      // scrollToElement(dateEnd);
      return;
    }
   }
 }

 if (reportVal !== '7' && reportVal !== '8') {
  // Get the elements by their IDs
  var time_expected = document.getElementById('time_expected');
  var time_reported = document.getElementById('time_reported');
  var time_exited = document.getElementById('time_exited');

  // Check if the time_expected field is empty
  if (time_expected && time_expected.offsetParent !== null && time_expected.value.length === 0) {
    Swal.fire({
        text: "Please specify the activity time expected by the client.",
        icon: "warning"
    });
    addIndicator(time_expected);
    time_expectedError.innerText = "Expected time by the client is required.";
    // Scroll to the location of the indicator error
    // scrollToElement(programdropdown2);
    return;
}

  // Check if the time_reported field is empty
  if (time_reported && time_reported.offsetParent !== null && time_reported.value.length === 0) {
      Swal.fire({
          text: "Please specify the time when the activity started.",
          icon: "warning"
      });
      addIndicator(time_reported);
      time_reportedError.innerText = "Activity start time is required.";
      // Scroll to the location of the indicator error
      // scrollToElement(programdropdown2);
      return;
  }

  // Check if the time_exited field is empty
  if (time_exited && time_exited.offsetParent !== null && time_exited.value.length === 0) {
      Swal.fire({
          text: "Please specify the time when the activity ended.",
          icon: "warning"
      });
      addIndicator(time_exited);
      time_exitedError.innerText = "Activity end time is required.";
      // Scroll to the location of the indicator error
      // scrollToElement(programdropdown2);
      return;
  }
}

 if (reportVal === '7'){
    var prodLineValue = document.getElementById('product_line_select');
    var skillActType = document.getElementById('Activity_Type_Create');

    if (skillActType  && skillActType.offsetParent !== null && skillActType.value.length === 0) {
      Swal.fire({ text: "Please Activity type cannot be blank.", icon: "warning"});
      addIndicator(skillActType);
      actTypeError.innerText = "Please specify the activity Type.";
      // Scroll to the location of the indicator error
      // scrollToElement(skillActType);
      return;
    }
    if (prodLineValue  && prodLineValue.offsetParent !== null && prodLineValue.value.length === 0) {
      Swal.fire({ text: "Please specify the product line involve.", icon: "warning"});
      addIndicator(prodLineValue);
      productLineError.innerText = "Please specify the product line involved.";
      // Scroll to the location of the indicator error
      // scrollToElement(prodLineValue);
      return;
    } 

    // txtTitle selTakeStatus selScore selIncentiveDetails txtIncentiveAmount
    if (activityTypeDropdownValue === "Sales Certification" || activityTypeDropdownValue === "Technical Certification") {

      var examCodeInput = document.getElementById('examCode');
      var takeStatusDropdownInput = document.getElementById('takeStatusDropdown');
      var scoreDropdownInput = document.getElementById('scoreDropdown');
      var incentiveDetailsDropdown = document.getElementById('"incentiveDetailsDropdown');
      var titleInput = document.getElementById('title');
      var amountInput = document.getElementById('amount');
      var takeStatusValue = document.getElementById('takeStatusDropdown').value;
      var scoreDropdownValue = document.getElementById('scoreDropdown').value;
      var incentiveValue = incentiveDetailsDropdown ? incentiveDetailsDropdown.value : '';
      var amountValue = amountInput ? amountInput.value.trim() : '';

           // Check for required fields
           if (examCodeInput && examCodeInput.offsetParent !== null && examCodeInput.value.trim() === '') {
            Swal.fire({ text: "Please Specify the Exam Code and Name", icon: "warning"});
            addIndicator(examCodeInput);
            examCodeError.innerText = "Please specify the Exam Code and Name.";
            // scrollToElement(examCodeInput);
            return;
        }

        if (takeStatusDropdownInput && takeStatusDropdownInput.offsetParent !== null && takeStatusDropdownInput.value.length === 0) {
            Swal.fire({ text: "How many times did you take the exam? Be honest", icon: "warning"});
            addIndicator(takeStatusDropdownInput);
           TakeStatusError.innerText = "Please specify how many times you take the exam.";
            // scrollToElement(takeStatusDropdownInput);
            return;
        }

        if (scoreDropdownInput && scoreDropdownInput.offsetParent !== null && scoreDropdownInput.value.length === 0) {
            Swal.fire({ text: "Is it Failed or Passed. Please specify.", icon: "warning"});
            addIndicator(scoreDropdownInput);
            scoreError.innerText = "Please specify the score.";
            // scrollToElement(scoreDropdownInput);
            return;
        }


        // Check incentive conditions
        if ((incentiveValue.length !== 0) || (amountValue !== '')) {
            if (
                (titleInput && titleInput.offsetParent !== null && titleInput.value.trim() === '') ||
                (takeStatusValue && takeStatusValue.offsetParent !== null && takeStatusValue !== '1') ||
                (scoreDropdownValue && scoreDropdownValue.offsetParent !== null && scoreDropdownValue === "Failed")
            ) {
   
                Swal.fire({ text: "No Incentive for a Failed Exam or Exam with NO title or Exam that is taken more than once", icon: "warning"});
                
                addIndicator(incentiveDetailsDropdown);
                // scrollToElement(incentiveDetailsDropdown);

                if (titleInput && titleInput.offsetParent !== null && titleInput.value.trim() === '') {
                    addIndicator(titleInput);
                    // scrollToElement(titleInput);
                }

                if (takeStatusValue && takeStatusValue.offsetParent !== null && takeStatusValue !== '1') {
                    addIndicator(takeStatusDropdownInput);
                    // scrollToElement(takeStatusDropdownInput);
                }

                if (scoreDropdownValue && scoreDropdownValue.offsetParent !== null && scoreDropdownValue === "Failed") {
                    addIndicator(scoreDropdownInput);
                    // scrollToElement(scoreDropdownInput);
                }

                return; // Prevent form submission
            }
        }

        // Submit form if passed
        if (scoreDropdownValue === 'Passed') {
            console.log('Form submitted because the score is Passed.');
            // Submit form logic here, e.g. document.getElementById('yourForm').submit();
        } else {
            console.log('Form not submitted because the score is not Passed.');
        }
    }

    
    else if (activityTypeDropdownValue === 'Technology or Product Skills Devt') {//for Technology or Product Skills Devt
      var techprodLearnedInput = document.getElementById('techprodLearned');
      if (techprodLearnedInput  && techprodLearnedInput.offsetParent !== null && techprodLearnedInput.value.trim() === '') {
        Swal.fire({ text: "Please specify the Technology or Product learned", icon: "warning"});
        addIndicator(techprodLearnedInput);
        technologyError.innerText = "Please specify the Technology or Product learned";
        // Scroll to the location of the indicator error
        // scrollToElement(techprodLearnedInput);
        return;
      }
    }else{
      var trainingNameInput = document.getElementById('trainingName');
      var locationInput = document.getElementById('location');
      var speakerInput = document.getElementById('speaker');

      var chkAttendess = document.querySelectorAll('input.chkAttendess:checked');
      if (chkAttendess.length === 0) {
        var firstCheckbox = document.querySelector('input.chkAttendess');
        Swal.fire({ text: "Please indicate the attendees", icon: "warning"});
        addIndicator(firstCheckbox);
        attendeesError.innerText = "Please select at least one attendee";
        // scrollToElement(firstCheckbox);
        return; // Prevent form submission
      }

      if (trainingNameInput  && trainingNameInput.offsetParent !== null && trainingNameInput.value.trim() === '') {
        Swal.fire({ text: "Please specify Training Name", icon: "warning"});
        addIndicator(trainingNameInput);
        trainingNameError.innerText = "Please specify Training Name";
        // Scroll to the location of the indicator error
        // scrollToElement(trainingNameInput);
        return;
      }
      else if (locationInput  && locationInput.offsetParent !== null && locationInput.value.trim() === '') {
        Swal.fire({ text: "Please Specify the Training Venue", icon: "warning"});
        addIndicator(locationInput);
        locationError.innerText = "Please specify the Training Venue";
        // Scroll to the location of the indicator error
        // scrollToElement(locationInput);
        return;
      }
      else if (speakerInput  && speakerInput.offsetParent !== null && speakerInput.value.trim() === '') {
        Swal.fire({ text: "Please specify the speakers", icon: "warning"});
        addIndicator(speakerInput);
        speakerNameError.innerText = "Please specify the speakers";
        // Scroll to the location of the indicator error
        // scrollToElement(speakerInput);
        return;
      }
    }
 }
// Others
 if (reportVal ==='8') { 
  if (venueInput  && venueInput.offsetParent !== null && venueInput.value.trim() === '') {
    Swal.fire({ text: "Please specify the venue of this activity", icon: "warning"});
    addIndicator(venueInput);
    venueError.innerText = "Please specify venue of this activity";
    // Scroll to the location of the indicator error
    // scrollToElement(venueInput);
    return;
  }
  if (activityTypeDropdownValue != '') {
    // digiknow
    var digiknowFlyersattValid = document.getElementById('digiknowFlyersattValid');
    if (activityTypeDropdownValue === "DIGIKnow") {
      var  recChekcbox = document.querySelectorAll('input.recipientsChk:checked');
      if (recChekcbox.length === 0) {
        var firstrecCheckbox = document.querySelector('input.recipientsChk');
        Swal.fire({ text: "Please indicate the recipients.", icon: "warning"});
        addIndicator(firstrecCheckbox);
        recipientsError.innerText = "Please specify at least one recipient";
        // scrollToElement(firstrecCheckbox);
        return; // Prevent form submission
      }
    } 
    if (digiknowFlyersattValid && digiknowFlyersattValid.offsetParent !== null && digiknowFlyersattValid.value.trim() === '') {
      Swal.fire({ text: "Please attach the DIGIKnow Flyer", icon: "warning"});
      addIndicator(digiknowFlyersattValid);
      digiKnowFileError.innerText = "Please attach the DIGIKnow Flyer";
      // Scroll to the location of the indicator error
      // scrollToElement(digiknowFlyersattValid);
      return;
    }
  } 
  if (activityTypeDropdownValue === "Internal Project") {
    var MSIProjNameInput = document.getElementById('modal_MSIProjName'); 
    var CompliancePercentageInput = document.getElementById('modal_CompliancePercentage');

    if (MSIProjNameInput  && MSIProjNameInput.offsetParent !== null && MSIProjNameInput.value.trim() === '') {
      Swal.fire({ text: "Please specify MSI Project Name", icon: "warning"});
      addIndicator(MSIProjNameInput);
      msiProjError.innerText = "Please specify MSI Project Name";
      // Scroll to the location of the indicator error
      // scrollToElement(MSIProjNameInput);
      return;
    }
    if (CompliancePercentageInput  && CompliancePercentageInput.offsetParent !== null && CompliancePercentageInput.value.trim() === '') {
      Swal.fire({ text: "Please specify Compliance Percentage.", icon: "warning"});
      addIndicator(CompliancePercentageInput);
      comPercentError.innerText = "Please specify Compliance Percentage";
      // Scroll to the location of the indicator error
      // scrollToElement(CompliancePercentageInput);
      return;
    }
  }

  var perfectAtt = document.getElementById('modalperfectAttendance'); 
  var engrFeedbackInput = document.getElementById('modal_engrFeedbackInput');
  var memoDetailsInput = document.getElementById('memoDetails');
  var memoIssuedInput = document.getElementById('modal_memoIssued');
  var other_ratingInput = document.getElementById('modal_other_rating');
  var topicNameInput = document.getElementById('modal_topicName');
  var dateStartInput = document.getElementById('modal_dateStart');
  var dateEndInput = document.getElementById('modal_dateEnd');
 

  if (activityTypeDropdownValue === "Perfect Attendance under Merit") {
    if (perfectAtt  && perfectAtt.offsetParent !== null && perfectAtt.value.trim() === '') {
      Swal.fire({ text: "Please specify the PA month and year.", icon: "warning"});
      addIndicator(perfectAtt);
      perfectAttError.innerText = "Please specify the PA month and year";
      // Scroll to the location of the indicator error
      // scrollToElement(perfectAtt);
      return;
    }  
  }else if (activityTypeDropdownValue === "Memo from HR under Demerit") {
    if (memoIssuedInput  && memoIssuedInput.offsetParent !== null && memoIssuedInput.value.trim() === '') {
      Swal.fire({ text: "Please specify the MEMO effectivity month and year.", icon: "warning"});
      addIndicator(memoIssuedInput);
      memoIssuedError.innerText = "Please specify the MEMO effectivity month and year";
      // Scroll to the location of the indicator error
      // scrollToElement(memoIssuedInput);
      return;
    }

    if (memoDetailsInput  && memoDetailsInput.offsetParent !== null && memoDetailsInput.value.trim() === '') {
      Swal.fire({ text: "Please specify the MEMO effectivity month and year.", icon: "warning"});
      addIndicator(memoDetailsInput);
      memoDetailsError.innerText = "Please specify the MEMO details";
      // Scroll to the location of the indicator error
      // scrollToElement(memoDetailsInput);
      return;
    }

  }else if (activityTypeDropdownValue === "Feedback On Engineer") {
    if (engrFeedbackInput  && engrFeedbackInput.offsetParent !== null && engrFeedbackInput.value.trim() === '') {
      Swal.fire({ text: "Please specify the feedback on Engineer.", icon: "warning"});
      addIndicator(engrFeedbackInput);
      engrFeedbackError.innerText = "Please specify the feedback on Engineer";
      // Scroll to the location of the indicator error
      // scrollToElement(engrFeedbackInput);
      return;
    } 
    else if (other_ratingInput  && other_ratingInput.offsetParent !== null && other_ratingInput.value.trim() === '') {
      Swal.fire({ text: "Please specify the rating on engineer.", icon: "warning"});
      addIndicator(other_ratingInput);
      engrRatingError.innerText = "Please specify the rating on engineer";
      // Scroll to the location of the indicator error
      // scrollToElement(other_ratingInput);
      return;
    }
  }else if (activityTypeDropdownValue === "Train To Retain (T2R)") {
    if (topicNameInput  && topicNameInput.offsetParent !== null && topicNameInput.value.trim() === '') {
      Swal.fire({ text: "Please specify the topic.", icon: "warning"});
      addIndicator(topicNameInput);
      topicError.innerText = "Please specify the topic";
      // Scroll to the location of the indicator error
      // scrollToElement(topicNameInput);
      return;
    }else if (dateStartInput  && dateStartInput.offsetParent !== null && dateStartInput.value.trim() === '') {
      Swal.fire({ text: "Please specify the start date.", icon: "warning"});
      addIndicator(dateStartInput);
      dateStartError.innerText = "Please specify the start date";
      // Scroll to the location of the indicator error
      // scrollToElement(dateStartInput);
      return;
    }else if (dateEndInput  && dateEndInput.offsetParent !== null && dateEndInput.value.trim() === '') {
      Swal.fire({ text: "Please specify the end date.", icon: "warning"});
      addIndicator(dateEndInput);
      dateEndError.innerText = "Please specify the end date";
      // Scroll to the location of the indicator error
      // scrollToElement(dateEndInput);
      return;
    }
  } 
  var othersActType = document.getElementById('Activity_Type_Create');
  if (othersActType  && othersActType.offsetParent !== null && othersActType.value.length === 0) {   
    Swal.fire({ text: "Please Activity type cannot be blank.", icon: "warning"});
    addIndicator(othersActType);
    actTypeError.innerText = "Please specify the Activity type";
    // Scroll to the location of the indicator error
    // scrollToElement(othersActType);
    return;
  }
  else  if (statusDropdownValue === '1' || reportVal === '7' && statusDropdownValue === '4') {
    var programdropdown2 = document.getElementById('Program_Create');
    if (programdropdown2  && programdropdown2.offsetParent !== null && programdropdown2.value.length === 0) {
      Swal.fire({ text: "Please specify a program the activity is related to. Click NONE if it is not related to anything.", icon: "warning"});
      addIndicator(programdropdown2);
      programError.innerText = "Please specify a program the activity is related to";
      // Scroll to the location of the indicator error
      // scrollToElement(programdropdown2);
      return;
    } 
  }
 }

   // If all fields pass validation, show the loading screen and submit the form
 document.getElementById('loadingScreen').style.display = 'flex';
   this.submit();
});

function scrollToElement(element) {
  // Calculate the offset of the element relative to the viewport
  var elementRect = element.getBoundingClientRect();
  var absoluteElementTop = elementRect.top + window.pageYOffset;
  
  // Calculate the amount of scrolling needed to bring the element into view
  var middle = absoluteElementTop - (window.innerHeight / 2);
  
  // Scroll to the calculated position with smooth animation
  window.scrollTo({
    top: middle,
    behavior: 'smooth'
  });
}


// Function to add the indicator to the input element
function addIndicator(inputElement) {
  // Add red border, padding, and glow effect to the input field
  inputElement.style.border = '1px solid red';
  inputElement.style.padding = '4px'; // Adjust the padding as needed
  inputElement.style.boxShadow = '0 0 2px red'; // Glow effect, adjust as needed
  
  // Check if the input element is a select element
  if (inputElement.tagName.toLowerCase() === 'select') {
    // Add red border, padding, and glow effect to the select element
    inputElement.style.border = '1px solid red'; // Example border color for select
    inputElement.style.padding = '6px'; // Example padding for select
    inputElement.style.boxShadow = '0 0 2px red'; // Example glow effect for select
    
    // Add styles to the Select2 dropdown
    var select2Container = $(inputElement).siblings('.select2-container');
    select2Container.find('.select2-selection').css({
      'border': '1px solid red', // Example border color for Select2 dropdown
      'padding': '6px', // Example padding for Select2 dropdown
      'box-shadow': '0 0 2px red' // Example glow effect for Select2 dropdown
    });
  }
  // Remove the indicator after 3 seconds
  setTimeout(function() {
  removeIndicator(inputElement);
  }, 3000);

}

// Function to remove the indicator from the input element
// Function to remove the indicator from the input element
function removeIndicator(inputElement) {
  // Remove the border, padding, and glow effect from the input field
  inputElement.style.border = '';
  inputElement.style.padding = '';
  inputElement.style.boxShadow = '';
  
  // Check if the input element is a select element
  if (inputElement.tagName.toLowerCase() === 'select') {
    // Remove the border, padding, and glow effect from the select element
    inputElement.style.border = ''; // Reset border
    inputElement.style.padding = ''; // Reset padding
    inputElement.style.boxShadow = ''; // Reset glow effect
    
    // Remove styles from the Select2 dropdown
    var select2Container = $(inputElement).siblings('.select2-container');
    select2Container.find('.select2-selection').css({
      'border': '', // Reset border
      'padding': '', // Reset padding
      'box-shadow': '' // Reset glow effect
    });
  }
}
$('#prod_engineers, #send_copy_to, #Activity_Type_Create, #product_line_select, #Program_Create, #engineer').on('select2:select select2:unselect', function() {
  var selectedOptions = $(this).val();
  if (selectedOptions !== null && selectedOptions.length > 0) {
    // If options are selected, remove the indicator
    removeIndicator(this);
  } else {
    // If no options are selected, add the indicator
    addIndicator(this);
  }
});

document.getElementById('projtype_button').addEventListener('input', function() {
  var projtype_buttonError = document.getElementById('projtype_buttonError');
  if (this.value.trim() !== '') {
    projtype_buttonError.innerText = '';
  }
});

document.getElementById('activitybodyInput').addEventListener('input', function() {
  var activityError = document.getElementById('activityError');
  if (this.value.trim() !== '') {
    activityError.innerText = '';
  }
});

document.getElementById('activityinput').addEventListener('input', function() {
  var activityError1 = document.getElementById('activityError1');
  if (this.value.trim() !== '') {
    activityError1.innerText = '';
  }
});
$('#prod_engineers').on('select2:select select2:unselect', function (e) {
  var prodengrError = document.getElementById('prodengrError');
  if (e.params.data && e.params.data.text.trim() !== '') {
    prodengrError.innerText = '';
  }
});
$('#engineer').on('select2:select select2:unselect', function (e) {
  var engrError = document.getElementById('engrError');
  if (e.params.data && e.params.data.text.trim() !== '') {
    engrError.innerText = '';
  }
});
$('#send_copy_to').on('select2:select select2:unselect', function (e) {
  var copyToError = document.getElementById('copyToError');
  if (e.params.data && e.params.data.text.trim() !== '') {
    copyToError.innerText = '';
  }
});
document.getElementById('resellers').addEventListener('input', function() {
  var resellersError = document.getElementById('resellersError');
  if (this.value.trim() !== '') {
    resellersError.innerText = '';
  }
});
document.getElementById('resellersContact').addEventListener('input', function() {
  var resellersContactError = document.getElementById('resellersContactError');
  if (this.value.trim() !== '') {
    resellersContactError.innerText = '';
  }
});

document.getElementById('resellersEmail').addEventListener('input', function() {
  var resellersEmailError = document.getElementById('resellersEmailError');
  if (this.value.trim() !== '') {
    resellersEmailError.innerText = '';
  }
});
$('#Activity_Type_Create').on('select2:select select2:unselect', function (e) {
  var actTypeError = document.getElementById('actTypeError');
  if (e.params.data && e.params.data.text.trim() !== '') {
    actTypeError.innerText = '';
  }
});
$('#Program_Create').on('select2:select select2:unselect', function (e) {
  var programError = document.getElementById('programError');
  if (e.params.data && e.params.data.text.trim() !== '') {
    programError.innerText = '';
  }
});
document.getElementById('modal_prodModel').addEventListener('input', function() {
  var prodModError = document.getElementById('prodModError');
  if (this.value.trim() !== '') {
    prodModError.innerText = '';
  }
});
document.getElementById('modal_assetCode').addEventListener('input', function() {
  var assetError = document.getElementById('assetError');
  if (this.value.trim() !== '') {
    assetError.innerText = '';
  }
});
document.getElementById('modal_poc_dateStart').addEventListener('input', function() {
  var pocDateStartError = document.getElementById('pocDateStartError');
  if (this.value.trim() !== '') {
    pocDateStartError.innerText = '';
  }
});
document.getElementById('modal_poc_dateEnd').addEventListener('input', function() {
  var pocDateEndError = document.getElementById('pocDateEndError');
  if (this.value.trim() !== '') {
    pocDateEndError.innerText = '';
  }
});
$('#product_line_select').on('select2:select select2:unselect', function (e) {
  var productLineError = document.getElementById('productLineError');
  if (e.params.data && e.params.data.text.trim() !== '') {
    productLineError.innerText = '';
  }
});
document.addEventListener('DOMContentLoaded', function() {
  var modalExamCode = document.getElementById('examCode');
  if (modalExamCode) {
    modalExamCode.addEventListener('input', function() {
      var examCodeError = document.getElementById('examCodeError');
      if (this.value.trim() !== '') {
        examCodeError.innerText = '';
      }
    });
  } else {
    console.error('Element with ID examCode not found.');
  }
});
document.getElementById('takeStatusDropdown').addEventListener('input', function() {
  var TakeStatusError = document.getElementById('TakeStatusError');
  if (this.value.trim() !== '') {
    TakeStatusError.innerText = '';
  }
});
document.getElementById('scoreDropdown').addEventListener('input', function() {
  var scoreError = document.getElementById('scoreError');
  if (this.value.trim() !== '') {
    scoreError.innerText = '';
  }
});
document.getElementById('techprodLearned').addEventListener('input', function() {
  var technologyError = document.getElementById('technologyError');
  if (this.value.trim() !== '') {
    technologyError.innerText = '';
  }
});
document.getElementById('trainingName').addEventListener('input', function() {
  var trainingNameError = document.getElementById('trainingNameError');
  if (this.value.trim() !== '') {
    trainingNameError.innerText = '';
  }
});
document.getElementById('location').addEventListener('input', function() {
  var locationError = document.getElementById('locationError');
  if (this.value.trim() !== '') {
    locationError.innerText = '';
  }
});
document.getElementById('speaker').addEventListener('input', function() {
  var speakerNameError = document.getElementById('speakerNameError');
  if (this.value.trim() !== '') {
    speakerNameError.innerText = '';
  }
});
document.getElementById('venue').addEventListener('input', function() {
  var venueError = document.getElementById('venueError');
  if (this.value.trim() !== '') {
    venueError.innerText = '';
  }
});
document.addEventListener('DOMContentLoaded', function() {
  // Retrieve elements for recipients
  var bpDigiCheckbox = document.getElementById('bpDigiCheckbox');
  var euDigiCheckbox = document.getElementById('euDigiCheckbox');
  var recipientsError = document.getElementById('recipientsError');
  
  // Retrieve elements for attendees
  var bpCheckbox = document.getElementById('bpCheckbox');
  var euCheckbox = document.getElementById('euCheckbox');
  var MSICheckbox = document.getElementById('MSICheckbox');
  var attendeesError = document.getElementById('attendeesError');

  // Function to check the state of recipient checkboxes
  function handlerecipientCheckboxChange() {
      if (bpDigiCheckbox.checked || euDigiCheckbox.checked) {
          recipientsError.innerText = ''; // Clear error message if at least one checkbox is selected
      }
  }

  // Function to check the state of attendee checkboxes
  function handleattendeesCheckboxChange() {
      if (bpCheckbox.checked || euCheckbox.checked || MSICheckbox.checked) {
          attendeesError.innerText = ''; // Clear error message if at least one checkbox is selected
      }
  }

  // Attach event listeners to recipient checkboxes
  if (bpDigiCheckbox) {
      bpDigiCheckbox.addEventListener('change', handlerecipientCheckboxChange);
  } else {
      console.error('Element with ID bpDigiCheckbox not found.');
  }

  if (euDigiCheckbox) {
      euDigiCheckbox.addEventListener('change', handlerecipientCheckboxChange);
  } else {
      console.error('Element with ID euDigiCheckbox not found.');
  }

  // Attach event listeners to attendee checkboxes
  if (bpCheckbox) {
      bpCheckbox.addEventListener('change', handleattendeesCheckboxChange);
  } else {
      console.error('Element with ID bpCheckbox not found.');
  }

  if (euCheckbox) {
      euCheckbox.addEventListener('change', handleattendeesCheckboxChange);
  } else {
      console.error('Element with ID euCheckbox not found.');
  }

  if (MSICheckbox) {
      MSICheckbox.addEventListener('change', handleattendeesCheckboxChange);
  } else {
      console.error('Element with ID MSICheckbox not found.');
  }

  // Initial check to set error messages based on default checkbox states
  handlerecipientCheckboxChange();
  handleattendeesCheckboxChange();
});

document.getElementById('bpDigiCheckbox').addEventListener('input', function() {
  var recipientsError = document.getElementById('recipientsError');
  if (this.value.trim() !== '') {
    recipientsError.innerText = '';
  }
});
document.getElementById('modal_MSIProjName').addEventListener('input', function() {
  var msiProjError = document.getElementById('msiProjError');
  if (this.value.trim() !== '') {
    msiProjError.innerText = '';
  }
});
document.getElementById('modal_CompliancePercentage').addEventListener('input', function() {
  var comPercentError = document.getElementById('comPercentError');
  if (this.value.trim() !== '') {
    comPercentError.innerText = '';
  }
});
document.getElementById('modalperfectAttendance').addEventListener('input', function() {
  var perfectAttError = document.getElementById('perfectAttError');
  if (this.value.trim() !== '') {
    perfectAttError.innerText = '';
  }
});
document.getElementById('modal_engrFeedbackInput').addEventListener('input', function() {
  var engrFeedbackError = document.getElementById('engrFeedbackError');
  if (this.value.trim() !== '') {
    engrFeedbackError.innerText = '';
  }
});
document.getElementById('modal_memoIssued').addEventListener('input', function() {
  var memoIssuedError = document.getElementById('memoIssuedError');
  console.log('Input value:', this.value);  // Debugging line

  // Check if the value is empty
  if (this.value.trim() !== '') {
      memoIssuedError.innerText = '';
  }
});
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('memoDetails').addEventListener('input', function() {
      var memoDetailsError = document.getElementById('memoDetailsError');
      if (this.value.trim() !== '') {
          memoDetailsError.innerText = '';
      }
  });
});
document.getElementById('modal_other_rating').addEventListener('input', function() {
  var engrRatingError = document.getElementById('engrRatingError');
  if (this.value.trim() !== '') {
    engrRatingError.innerText = '';
  }
});
document.getElementById('modal_topicName').addEventListener('input', function() {
  var perfectAttError = document.getElementById('perfectAttError');
  if (this.value.trim() !== '') {
    perfectAttError.innerText = '';
  }
});
document.getElementById('modal_dateStart').addEventListener('input', function() {
  var dateStartError = document.getElementById('dateStartError');
  if (this.value.trim() !== '') {
    dateStartError.innerText = '';
  }
});
document.getElementById('modal_dateEnd').addEventListener('input', function() {
  var dateEndError = document.getElementById('dateEndError');
  if (this.value.trim() !== '') {
    dateEndError.innerText = '';
  }
});
document.getElementById('modal_topicName').addEventListener('input', function() {
  var topicError = document.getElementById('topicError');
  if (this.value.trim() !== '') {
    topicError.innerText = '';
  }
});
document.getElementById('modal_dateStart').addEventListener('input', function() {
  var dateStartError = document.getElementById('dateStartError');
  if (this.value.trim() !== '') {
    dateStartError.innerText = '';
  }
});
document.getElementById('modal_dateEnd').addEventListener('input', function() {
  var dateEndError = document.getElementById('dateEndError');
  if (this.value.trim() !== '') {
    dateEndError.innerText = '';
  }
});

$('#time_expected').on('select2:select select2:unselect', function (e) {
  var time_expectedError = document.getElementById('time_expectedError');
  if (e.params.data && e.params.data.text.trim() !== '') {
    time_expectedError.innerText = '';
  }
});
$('#time_reported').on('select2:select select2:unselect', function (e) {
  var time_reportedError = document.getElementById('time_reportedError');
  if (e.params.data && e.params.data.text.trim() !== '') {
    time_reportedError.innerText = '';
  }
});
$('#time_exited').on('select2:select select2:unselect', function (e) {
  var time_exitedError = document.getElementById('time_exitedError');
  if (e.params.data && e.params.data.text.trim() !== '') {
    time_exitedError.innerText = '';
  }
});


// Get all form inputs (including Select2 elements)
var formInputs = document.querySelectorAll('input, select');

// Iterate over each input element
formInputs.forEach(function(input) {

    // For regular input elements, listen for the input event
    input.addEventListener('input', function() {
      // Check if the value is not empty
      if (input.value.trim() !== '') {
        // If the field is not empty, remove the indicator
        removeIndicator(input);
      }
    });
  
});

// Function to reset all indicators
function resetIndicators() {
  var inputs = document.querySelectorAll('input, select');
  inputs.forEach(function(input) {
      input.style.border = '';
  });
}

const Filevalidation = () => {
  const fi = document.getElementById('act_reportFile');
  // Check if any file is selected.
  if (fi.files.length > 0) {
      for (let i = 0; i < fi.files.length; i++) {
          const fsize = fi.files.item(i).size;
          const file = Math.round(fsize / 1024);
          // The size of the file.
          if (file >= 10000) {
            Swal.fire({ text: "DIGIKnow Flyer file too big, please select a file less than 10MB", icon: "warning"});
              fi.value = ""; // Clear the file input
              document.getElementById('size').innerHTML = ""; // Clear the size display
          } else if (file === 0) {
              Swal.fire({ text: "The File you selected is empty or doesn't exist. Please select another file.", icon: "warning"});
              fi.value = ""; // Clear the file input
              document.getElementById('size').innerHTML = ""; // Clear the size display
          } else {
              document.getElementById('size').innerHTML = '<b>Size: ' + file + '</b> KB';
          }
      }
  } else {
      Swal.fire({ text: "No file selected. Please select a file.", icon: "warning"});
  }
}

const DigiknowFlyerValidation = () => {
  const fi = document.getElementById('digiknowFlyersattValid');
  // Check if any file is selected.
  if (fi.files.length > 0) {
      for (let i = 0; i < fi.files.length; i++) {
          const fsize = fi.files.item(i).size;
          const file = Math.round(fsize / 1024);
          // The size of the file.
          if (file >= 10000) {
              Swal.fire({ text: "DIGIKnow Flyer file too big, please select a file less than 10MB", icon: "warning"});
              fi.value = ""; // Clear the file input
          } else if (file === 0) {
              Swal.fire({ text: "The DIGIKnow Flyer file you selected is empty. Please select another file.", icon: "warning"});
              fi.value = ""; // Clear the file input
          }
      }
  } else {
      Swal.fire({ text: "No DIGIKnow Flyer file selected. Please select a file.", icon: "warning"});
      
  }
}

