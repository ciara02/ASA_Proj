$(document).ready(function () {
    // Toggle "Remove" button when checkboxes change
    function toggleRemoveButton() {
        const isAnyChecked = $('.row-checkbox:checked').length > 0;
        $('.softdelete-button').prop('disabled', !isAnyChecked);
    }

    $('#selectAll').on('change', function () {
        $('.row-checkbox').prop('checked', this.checked);
        toggleRemoveButton();
    });

    $(document).on('change', '.row-checkbox', function () {
        toggleRemoveButton();
    });

    $('.row-checkbox').on('change', function () {
        const isDisabled = $('.softdelete-button').prop('disabled');
        console.log('Remove button state:', isDisabled ? 'disabled' : 'enabled');
    });

    $('.softdelete-button').on('click', function () {
        const selectedIds = $('.row-checkbox:checked').map(function () {
            return $(this).data('id');
        }).get();
    
        if (selectedIds.length === 0) return;
    
        Swal.fire({
            title: 'Are you sure?',
            text: "The selected row(s) will be removed from the table.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove them!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/tab-isupport-service/hide',
                    method: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        selectedIds.forEach(id => {
                            $(`tr[data-id="${id}"]`).fadeOut();
                        });
        
                        Swal.fire({
                            title: 'Removed!',
                            text: 'Selected row(s) have been successfully removed.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    },
                    error: function () {
                        Swal.fire('Oops!', 'Something went wrong while removing the row(s).', 'error');
                    }
                });
            }
        });        
    });    
    
});


$(document).ready(function () {
    // Function to disable dateFrom if StartDate is empty
    function disableDateTo() {
        var projectPeriodFrom = $("#projectPeriodFrom").val();
        if (projectPeriodFrom === "") {
            $("#projectPeriodTo").prop("disabled", true);
            $("#projectPeriodTo").val("");
        } else {
            $("#projectPeriodTo").prop("disabled", false);
        }
    }
    // Call the function initially
    disableDateTo();

    // Event listener for changes in StartDate
    $("#projectPeriodFrom").change(function () {
        disableDateTo();
    });

    // Event listener for changes in EndDate
    $("#projectPeriodTo").change(function () {
        // Date Restriction
        var projectPeriodFrom = new Date($("#projectPeriodFrom").val());
        var projectPeriodTo = new Date($("#projectPeriodTo").val());

        // Check if dateFrom is greater than dateTo
        if (projectPeriodFrom > projectPeriodTo) {
            Swal.fire('End date error!', 'End date cannot be earlier than start date.', 'error');
            $("#projectPeriodTo").val("");
        }
    });
});

$(document).ready(function () {
    // Define the custom sorting function for date
    $.fn.dataTable.ext.type.order['custom-date-pre'] = function(data) {
        console.log("Raw data for sorting:", data);  // Log the raw data
    
        // If the date is null or empty, we want it to go last
        if (!data) return 9999;
    
        // Parse the date into a full Date object
        const dateObj = new Date(data);
    
        // If the date is invalid or unrealistic (e.g., year is far in the future), push it to the bottom
        const currentYear = new Date().getFullYear();
        const invalidYearThreshold = 2100; // You can adjust this threshold as needed
        if (isNaN(dateObj) || dateObj.getFullYear() > invalidYearThreshold) {
            return 9999; // Push far future dates to the bottom
        }
    
        // Get the timestamp for sorting (useful for sorting full date values)
        return dateObj.getTime();
    };
    

    // IMPLEMENTATION's DATATABLE
    let mandayCache = {};
    let isFetchingData = false;
    let isModalOpen = false;
    const BATCH_SIZE = 10;
    const FETCH_INTERVAL = 60000;
    
    function loadMandayDataContinuously() {
        if (isFetchingData || isModalOpen) return;
        isFetchingData = true;
        console.log("Starting batch AJAX request...");
        
        let projectBatches = [];
        let currentBatch = [];
        let projectElements = $(".doer_eng").toArray();
        
        projectElements.forEach(el => {
            let $el = $(el);
            let projectId = $el.data("project-id");
            let engineerList = $el.find(".engineer-list");
            let engineerNames = $el.data("engineers") || "";
            let totalMandayCell = $el.closest("tr").find(".totalMandayUsed");
            
            if (!projectId || !engineerNames.trim()) {
                engineerList.hide();
                return;
            }
            
            let engineerNamesArray = engineerNames.split(',').map(name => name.trim()).filter(Boolean);
            if (mandayCache[projectId]) {
                renderMandayData(engineerList, totalMandayCell, mandayCache[projectId], engineerNamesArray);
                return;
            }
            
            currentBatch.push({ projectId, engineerList, totalMandayCell, engineerNamesArray });
            if (currentBatch.length >= BATCH_SIZE) {
                projectBatches.push(currentBatch);
                currentBatch = [];
            }
        });
        if (currentBatch.length > 0) projectBatches.push(currentBatch);
        
        async function processBatch(batchIndex) {
            if (batchIndex >= projectBatches.length || isModalOpen) {
                isFetchingData = false;
                return;
            }
            
            let batch = projectBatches[batchIndex];
            console.log("Processing batch:", batch);
            
            let batchRequests = batch.map(item => {
                let startTime = performance.now();
                return $.ajax({
                    url: '/tab-isupport/totalMandayUsed',
                    type: "POST",
                    data: { engineers: item.engineerNamesArray, projectId: item.projectId },
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                }).then(response => {
                    let endTime = performance.now();
                    let timeTaken = ((endTime - startTime) / 1000).toFixed(2);
                    console.log(`AJAX request for project ${item.projectId} took ${timeTaken} seconds.`);
                    
                    if (response && response.engineerMandays) {
                        mandayCache[item.projectId] = response;
                        renderMandayData(item.engineerList, item.totalMandayCell, response, item.engineerNamesArray);
                    }
                }).catch(error => {
                    console.error(`Failed to fetch data for project ${item.projectId}:`, error);
                });
            });
            
            await Promise.allSettled(batchRequests);
            setTimeout(() => processBatch(batchIndex + 1), 500);
        }
        
        processBatch(0);
    }
    
    $(document).ready(() => {
        loadMandayDataContinuously();
        setInterval(() => {
            if (!isModalOpen) loadMandayDataContinuously();
        }, FETCH_INTERVAL);
    });
    
    function renderMandayData(engineerList, totalMandayCell, data, engineerNamesArray) {
        console.log("Updating UI with manday data:", data);
        
        let totalMandays = data.totalMandaysAll || 0;
        totalMandayCell.text(totalMandays.toFixed(2));
        
        let updatedDisplay = engineerNamesArray.map(name => {
            let mandayCount = data.engineerMandays?.[name] || 0;
            return `<div class="eng-item">${name} - <span class="manday-count">${mandayCount}</span></div>`;
        }).join('');
        
        engineerList.html(updatedDisplay).show();
    }
    
    $(document).on('click', '.open-modal', function () {
        isModalOpen = true;
        $('#implementation-modal').modal('show');
    });
    
    $('#implementation-modal').on('hidden.bs.modal', function () {
        isModalOpen = false;
        console.log("Modal closed. Resuming data fetch...");
        setTimeout(loadMandayDataContinuously, 5000);
    });
    //manday spinner beside engineer
    $(document).ready(function () {
        // Show loading spinner inside the manday count and total manday cells before data is fetched
        $(".manday-count, .totalMandayUsed").html(`
            <div class="spinner-border text-secondary" role="status" style="width: 1rem; height: 1rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
        `);
    });
    function allDataLoaded() {
        let allLoaded = true;
    
        $(".doer_eng").each(function () {
            let $this = $(this);
            let totalMandayCell = $this.closest("tr").find(".totalMandayUsed");
            let mandaySpinner = totalMandayCell.find(".spinner-border");
    
            // Debugging output
            console.log("Checking row...");
            console.log("Spinner Exists?", mandaySpinner.length > 0);
    
            // If the spinner still exists, data is not fully loaded
            if (mandaySpinner.length > 0) {
                allLoaded = false;
                return false; // Break loop
            }
        });
    
        return allLoaded;
    }    
    
    var table = $('#implementation-datatable').DataTable({
        dom: 'Bfrtip',
        responsive: false,
        deferRender: true,
        scrollX: true,         // Enable horizontal scrolling
        scrollY: '60vh',       // Enable vertical scrolling
        scrollCollapse: true,
        scroller: true,
        paging: false,         // Disable paging
        order: [],
        fixedColumns: {
            leftColumns: 1      // Keep the first column fixed
        },
        columnDefs: [
            {
                targets: [0],     // Adjust for the first column (checkbox)
                orderable: false  // Make the checkbox column unorderable
            }
        ],
        createdRow: function(row, data, dataIndex) {
            // Add the highlight-hover class to each row
            $(row).addClass('highlight-hover');
        },

        buttons: [
            {
                extend: 'excel',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'buttons-excel btn btn-success',
                action: function (e, dt, button, config) {
                    if (allDataLoaded()) {
                        // Directly proceed with the Excel download
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                    } else {
                        // Show warning only if data is still loading
                        Swal.fire({
                            icon: 'warning',
                            title: 'Confirm Download',
                            text: "The 'Doer & Engineer' column is still loading. Some data may be incomplete. Do you want to proceed?",
                            showCancelButton: true,
                            confirmButtonText: 'Yes, Download',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Proceed with default Excel export
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, config);
                            }
                        });
        
                        e.preventDefault(); // Stop immediate execution of download
                    }
                },
                filename: function () {
                    var currentDate = new Date();
                    var formattedDate = currentDate.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                    return 'Isupport Services Report - ' + formattedDate;
                },
                exportOptions: {
                    modifier: {
                        search: 'none',
                        order: 'current',
                    },
                    rows: function (data, row, column, node) {
                        return true; // Include all rows
                    },
                    columns: ':visible', // Export visible columns
                    format: {
                        body: function (data, row, column, node) {
                            if (column === 21) {  // Adjust column index as needed
                                var engineerData = $(node).find('.engineer-list .eng-item')
                                    .map(function() {
                                        var name = $(this).text().split('-')[0].trim();
                                        var manday = $(this).find('.manday-count').text().trim();
                                        return name ? name + ' - ' + manday : 'No Engineers';
                                    })
                                    .get()
                                    .join('\r\n');
                                return engineerData.length ? engineerData : 'No Doers/Engineers';
                            }
                    
                            if (column === 20) {  // Adjust column index as needed
                                var mandayUsed = $(node).find('.totalMandayUsed').text().trim();
                                console.log("Manday Used Found:", mandayUsed); // Debugging
                                return mandayUsed && mandayUsed !== 'Loading..' ? mandayUsed : 'N/A';
                            }
                    
                            return data; // For other columns, just return the normal data
                        }
                    }                    
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
                           'border-radius': '2px'
                       });
            });
        }
        
        
    });
    $('#implementation-datatable').on('order.dt', function(e, settings) {
        const sortedColumnIndex = settings.aaSorting[0][0]; // Get the column index that was sorted
        const sortDirection = settings.aaSorting[0][1]; // Get the sort direction (asc/desc)
        console.log("Column sorted:", sortedColumnIndex);
        console.log("Sort direction:", sortDirection);
    });


    //Highlight clicked row
    $('#implementation-datatable td').on('click', function () {

        // Remove previous highlight class
        $(this).closest('table').find('tr.highlight').removeClass('highlight');

        // add highlight to the parent tr of the clicked td
        $(this).parent('tr').addClass("highlight");
    });

    $(document).ready(function () {
        $('#engineer').select2({
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
                        }).sort(function (a, b) {
                            // Compare the engineer names (text) to sort them alphabetically
                            return a.text.localeCompare(b.text);
                        })
                    };
                }
            }
        });
    });

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
                                text: item.engineer, // And display text
                                email: item.email, // Add the engineer's email
                                created_date: item.created_date // Add the engineer's creation date
                            };
                        }).sort(function (a, b) {
                            // Compare the engineer names (text) to sort them alphabetically
                            return a.text.localeCompare(b.text);
                        })
                    };
                }
            },
            templateResult: function (data) {
                if (!data.email) {
                    return data.text;
                }
                return $('<span>' + data.text + ' (' + data.email + ')</span>');
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });

        // Event listener for changes in the selected team members
        $('#engineers').on('change', function (e) {
            var selectedEngineers = $(this).select2('data');
            var emails = selectedEngineers.map(function (engineer) {
                return engineer.email; // Extract the email of each selected engineer
            }).join(', ');

            // Extract the creation date of the first selected engineer
            var creationDate = selectedEngineers.length > 0 ? selectedEngineers[0].created_date : '';

            $('#tm_email').val(emails); // Set the value of the hidden input for emails
            $('#created_dateTM').val(creationDate); // Set the value of the hidden input for creation date
        });

    });




    $(document).ready(function () {
        $('#projectManager').select2({
            width: '100%',
            multiple: false,
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
                                email: item.email // Add the engineer's email
                            };
                        }).sort(function (a, b) {
                            // Compare the engineer names (text) to sort them alphabetically
                            return a.text.localeCompare(b.text);
                        })
                    };
                }
            },
            templateResult: function (data) {
                if (!data.email) {
                    return data.text;
                }
                return $('<span>' + data.text + ' (' + data.email + ')</span>');
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });

        // Event listener for changes in the selected project manager
        $('#projectManager').on('select2:select', function (e) {
            var selectedManager = e.params.data;
            $('#pm_email').val(selectedManager.email); // Set the value of the hidden input to the selected manager's email
        });

        //    Append Excel button to the button container
        var excelButton = table.buttons().container().appendTo($('#excelButton'))
    });



    $(document).ready(function () {
        $('#projectCode').select2({
            width: '100%',
            ajax: {
                url: '/tab-isupport-service/getProjectCode',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (response) {
                    if (response && response.data) {
                        return {
                            results: response.data.map(function (projectCode) {
                                return {
                                    id: projectCode,
                                    text: projectCode
                                };
                            })
                        };
                    } else {
                        console.error('Invalid response format:', response);
                        return { results: [] };
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching project codes:', error);
                }
            }
        });
    });

    $(document).ready(function () {
        $('#businessUnit').select2({
            width: '100%',
            ajax: {
                url: '/tab-isupport-service/getBusinessUnit',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (response) {
                    if (response && response.data) {
                        return {
                            results: response.data.map(function (businessUnit) {
                                return {
                                    id: businessUnit.description,
                                    text: businessUnit.description
                                };
                            })
                        };
                    } else {
                        console.error('Invalid response format:', response);
                        return { results: [] };
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching project codes:', error);
                }
            }
        });
    });




    $(document).ready(function () {
        $('#productLine').select2({
            width: '100%',
            multiple: false,
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
                                    id: getProductline.description,
                                    text: getProductline.description,
                                    code: getProductline.flex_value // Store the product code in a 'code' attribute

                                    // id: getProductline.description, // Assuming 'flex_value_id' is the id
                                    // text: getProductline.description,

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

        $('#productLine').on('change', function () {
            updateProductLine();
        });

        //for passing data of productline and productCode
        function updateProductLine() {
            var selectedProductLines = $('#productLine').select2('data');
            var productLineDescriptions = selectedProductLines.map(function (productLine) {
                return productLine.text; // Retrieve the description instead of the value
            }).join(', ');
            $('#iSupport_product').val(productLineDescriptions);
        }
    });




    $(document).ready(function () {
        $('#projectType').select2({
            width: '100%',
        });
        $('#serviceCategory').select2({
            width: '100%',
        });
    });
    $(function () {
        // Bind the calculate function to the input event of projectMandays and projectAmountGross
        $('#projectMandays, #projectAmountGross').on('input', calculate);
        // Bind the calculate function to the input event of cashAdvance
        $('#cashAdvance').on('input', calculate);
        // $('#cashAdvance').on('input', function() {
        //     var value = $(this).val();
        //     if (value.match(/\D/)) {
        //         // Show the tooltip if non-integer values are entered
        //         $(this).tooltip('show');
        //     } else {
        //         // Hide the tooltip if the value is valid
        //         $(this).tooltip('hide');
        //     }
        //     $(this).val(value.replace(/[^0-9]/g, ''));
        //     calculate();
        // });
    
        function calculate() {
            var projectCode = $('#projectCode').val(); // Assuming you have an input field with the project code
            var pMandays = parseFloat($('#projectMandays').val()) || 0;
            var pGross = parseFloat($('#projectAmountGross').val()) || 0;
            var pCash = parseFloat($('#cashAdvance').val()) || 0; // Treat as an integer
        
            var pNet = pGross - pCash;
        
            // Check if pMandays is not zero before performing the division
            var pMcost = (pMandays !== 0) ? pNet / pMandays : 0;
        
            // Update the corresponding input fields with the calculated values
            $('#projectAmountNet').val(pNet.toFixed(2)); // Ensure that the value has two decimal places
            $('#perMondayCost').val(pMcost.toFixed(2));  // Ensure that the value has two decimal places
        
            console.log({
                projectCode: projectCode,
                projectAmountNet: pNet.toFixed(2),
                perMondayCost: pMcost.toFixed(2)
            });
            
            // Send the calculated values to the controller
            $.ajax({
                url: '/tab-isupport-service/implementation/saveEditProject',  // Replace with your actual route
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),  // Include CSRF token
                    projectCode: projectCode,
                    projectAmountNet: pNet.toFixed(2),
                    perMondayCost: pMcost.toFixed(2)
                },
                success: function(response) {
                    console.log('Data sent successfully:', response);
                },
                error: function(xhr) {
                    console.log('An error occurred:', xhr.responseText);
                }
            });
        }
        
    }); 
});

$(document).ready(function () {
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
    $("#dateFrom").change(function () {
        disableDateTo();
    });

    // Event listener for changes in EndDate
    $("#dateTo").change(function () {
        // Date Restriction
        var dateFrom = new Date($("#dateFrom").val());
        var dateTo = new Date($("#dateTo").val());

        // Check if dateFrom is greater than dateTo
        if (dateFrom > dateTo) {
            Swal.fire({title:"End date error!", text: "End date cannot be less than start date", icon: "error"});
            $("#dateTo").val("");
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var filterButton = document.getElementById('filter_button');

    if (filterButton) {
        filterButton.addEventListener('click', function (event) {
            var startDate = document.getElementById('dateFrom')?.value || '';
            var endDate = document.getElementById('dateTo')?.value || '';
            var engineerName = document.getElementById('engineers')?.value || '';

            if (startDate === '' && endDate === '' && engineerName === '') {
                Swal.fire({ text: "Please provide Start Date, End Date", icon: "warning"});
                event.preventDefault();
            } else if (startDate !== '' && endDate === '') {
                Swal.fire({ text: "Please provide End Date", icon: "warning"});
                event.preventDefault();
            } else if (startDate === '' && endDate !== '') {
                Swal.fire({ text: "Please provide Start Date", icon: "warning"});
                event.preventDefault();
            }
        });
    } else {
        console.warn('Element with ID "filter_button" not found.');
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var submitBtn = document.getElementById('saveBtn');

    submitBtn.addEventListener('click', function (event) {
        event.preventDefault();

        // Reset all indicators before validation
        resetIndicators();

        function addErrorMessage(elementId, message) {
            var errorElement = document.getElementById(elementId + 'Error');
            if (errorElement) {
                errorElement.textContent = message;
            }
        }
        
        function clearErrorMessage(elementId) {
            var errorElement = document.getElementById(elementId + 'Error');
            if (errorElement) {
                errorElement.textContent = '';
            }
        }

        var projCodeSelect = document.getElementById('projectCode');
        if (!projCodeSelect.value) {
            Swal.fire({ text: "Please select a Project Code.", icon: "warning"});
            // scrollToElement(projCodeSelect);
            addIndicator(projCodeSelect);
            addErrorMessage('projectCode', "Project Code is required.");
            return;
        }else {
            clearErrorMessage('projectCode');
        }

        var projectNameSelect = document.getElementById('projectName');
        if (!projectNameSelect.value) {
            Swal.fire({ text: "Please fill out the Project Name field.", icon: "warning"});
            // scrollToElement(projectNameSelect);
            addIndicator(projectNameSelect);
            addErrorMessage('projectName', "Project Name is required.");
            return;
        }else {
            clearErrorMessage('projectName');
        }

        var serviceCategory = document.getElementById('serviceCategory');
        if (!serviceCategory.value) {
            Swal.fire({ text: "Please select a Service Category.", icon: "warning"});
            // scrollToElement(serviceCategory);
            addIndicator(serviceCategory);
            addErrorMessage('serviceCategory', "Service Category is required.");
            return;
        } else {
            clearErrorMessage('serviceCategory');
        }

        var projType = document.getElementById('projectType');
        if (!projType.value) {
            Swal.fire({ text: "Please select a Project Type.", icon: "warning"});
            // scrollToElement(projType);
            addIndicator(projType);
            addErrorMessage('projectType', "Project Type is required.");
            return;
        } else {
            clearErrorMessage('projectType');
        }

        var projectManager = document.getElementById('projectManager');
        if (!projectManager.value) {
            Swal.fire({ text: "Please select a Project Manager.", icon: "warning"});
            // scrollToElement(projectManager);
            addIndicator(projectManager);
            addErrorMessage('projectManager', "Project Manager is required.");
            return;
        } else {
            clearErrorMessage('projectManager');
        }

        var projectMandays = document.getElementById('projectMandays');
        if (!projectMandays.value) {
            Swal.fire({ text: "Please fill out the Project Manday/s field.", icon: "warning"});
            // scrollToElement(projectMandays);
            addIndicator(projectMandays);
            addErrorMessage('projectMandays', "Project Mandays is required.");
            return;
        }else {
            clearErrorMessage('projectMandays');
        }

        var projectAmountGross = document.getElementById('projectAmountGross');
        if (!projectAmountGross.value) {
            Swal.fire({ text: "Please provide Project Amount.", icon: "warning"});
            // scrollToElement(projectAmountGross);
            addIndicator(projectAmountGross);
            addErrorMessage('projectAmountGross', "Project Amount Gross is required.");
            return;
        }else {
            clearErrorMessage('projectAmountGross');
        }

        var poNumber = document.getElementById('poNumber');
        if (!poNumber.value) {
            Swal.fire({ text: "Please fill out the PO # field.", icon: "warning"});
            // scrollToElement(poNumber);
            addIndicator(poNumber);
            addErrorMessage('poNumber', "PO Number is required.");
            return;
        }else {
            clearErrorMessage('poNumber');
        }

        var soNumber = document.getElementById('soNumber');
        if (!soNumber.value) {
            Swal.fire({ text: "Please fill out the SO # field.", icon: "warning"});
            // scrollToElement(soNumber);
            addIndicator(soNumber);
            addErrorMessage('soNumber', "SO Number is required.");
            return;
        }else {
            clearErrorMessage('soNumber');
        }
        // If all fields are valid, allow form submission
        document.getElementById('projectCreate').submit();
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
        inputElement.style.border = '1px solid #e54141';
        inputElement.style.padding = '4px'; // Adjust the padding as needed
        inputElement.style.boxShadow = '0 0 3px red'; // Glow effect, adjust as needed
        // Check if the input element is a select element
        if (inputElement.tagName.toLowerCase() === 'select') {
            // Add red border, padding, and glow effect to the select element
            inputElement.style.border = '1px solid #e54141'; // Example border color for select
            inputElement.style.padding = '5px'; // Example padding for select
            inputElement.style.boxShadow = '0 0 2px red'; // Example glow effect for select

            // Add styles to the Select2 dropdown
            var select2Container = $(inputElement).siblings('.select2-container');
            select2Container.find('.select2-selection').css({
                'border': '1px solid #e54141', // Example border color for Select2 dropdown
                'padding': '5px', // Example padding for Select2 dropdown
                'box-shadow': '0 0 2px red' // Example glow effect for Select2 dropdown
            });
        }
    }

    // Function to remove the indicator from the input element
    function removeIndicator(inputElement) {
        // Remove the border, padding, and glow effect from the input field
        inputElement.style.border = '';
        inputElement.style.padding = '';
        inputElement.style.boxShadow = '';

        // Check if the input element is a select element
        if (inputElement.tagName.toLowerCase() === 'select') {
            // Remove styles from the Select2 dropdown
            var select2Container = $(inputElement).siblings('.select2-container');
            select2Container.find('.select2-selection').css({
                'border': '', // Reset border
                'padding': '', // Reset padding
                'box-shadow': '' // Reset glow effect
            });
        }
    }

    $('#projectCode, #projectManager, #projType').on('select2:select select2:unselect', function () {
        var selectedOptions = $(this).val();
        if (selectedOptions !== null && selectedOptions.length > 0) {
            // If options are selected, remove the indicator
            removeIndicator(this);
        } else {
            // If no options are selected or the input is null, add the indicator
            addIndicator(this);
        }
    });

    // Get all form inputs (including Select2 elements)
    var formInputs = document.querySelectorAll('input, select');

    // Iterate over each input element
    formInputs.forEach(function (input) {
        // For regular input elements, listen for the input event
        input.addEventListener('input', function () {
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
        inputs.forEach(function (input) {
            input.style.border = '';
            input.style.padding = '';
            input.style.boxShadow = '';

            // Check if the input element is a select element
            if (input.tagName.toLowerCase() === 'select') {
                // Remove styles from the Select2 dropdown
                var select2Container = $(input).siblings('.select2-container');
                select2Container.find('.select2-selection').css({
                    'border': '', // Reset border
                    'padding': '', // Reset padding
                    'box-shadow': '' // Reset glow effect
                });
            }
        });
    }
});



$(document).ready(function () {

    var table = $('#implementation-datatable').DataTable();
    var selectedData = null;

    // Store the data when a row is clicked
    $('#implementation-datatable tbody').on('click', 'tr', function () {
        selectedData = table.row(this).data();

    });

    $('#backBtn').on('click', function() {
        // Clear the file input value
        $('#implementationSupportingDocument').val('');
    });

    $('#implementation-modal').on('hidden.bs.modal', function () {
        $('#implementationSupportingDocument').val('');
    });


    // Save Data to Database
$("#saveBtn").off("click").on("click", function () {

    
    if ($('#implementationSupportingDocument')[0].files.length > 0) {
        Swal.fire({ text: "Please Click Import if you want to attach file.", icon: "warning"});
        return false;
    }

    $("#loading-overlay").show();

    var projectListId = selectedData[25];
    var projectListStatus = selectedData[16];

    

    $('#projectsignoff_id').val(projectListId);

    var projectCode = $('#projectCode').val();
    var projectId = $('#projectsignoff_id').val();
    var projectPeriodFrom = $('#projectPeriodFrom').val();
    var projectPeriodTo = $('#projectPeriodTo').val();
    var createdBy = $('#createdBy').val();
    var createdDate = $('#created_date').val();
    var projectName = $('#projectName').val();
    var serviceCategory = $('#serviceCategory').val();
    var projectManager = $('#projectManager').val();
    var engineers = $('#engineers').val();

    var projectType = $('#projectType').val();

    if (projectType === "Implementation") {
        projectType = "1";
    }
    if (projectType === "Maintenance Agreement") {
        projectType = "2";
    }

    var businessUnit = $('#businessUnit').val();
    var or = $('#or').val();
    var inv = $('#inv').val();
    var productLine = $('#iSupport_product').val();
    var mbs = $('#mbs').val();
    var projectMandays = $('#projectMandays').val();
    var projectAmountGross = $('#projectAmountGross').val();
    var poNumber = $('#poNumber').val();
    var perMondayCost = $('#perMondayCost').val();
    var projectAmountNet = $('#projectAmountNet').val();
    var soNumber = $('#soNumber').val();
    var mondayUsed = $('#mondayUsed').val();
    var cashAdvance = $('#cashAdvance').val();
    var ftNumber = $('#ftNumber').val();
    var payment_stat = $('#payment_stat').val();
    var ref_date = $('#ref_date').val();
    var specialInstruction = $('#specialInstruction').val();
    var resellers = $('#resellers').val();
    var resellers_Contact = $('#resellers_Contact').val();
    var resellerPhoneEmail = $('#resellerPhoneEmail').val();
    var endUser = $('#endUser').val();
    var endUserContactNumber = $('#endUserContactNumber').val();
    var endUserLocation = $('#endUserLocation').val();
    var endUserPhoneEmail = $('#endUserPhoneEmail').val();

    // Log values to the console
    console.log("projectCode: " + projectCode);
    console.log("projectId: " + projectId);
    console.log("projectPeriodFrom: " + projectPeriodFrom);
    console.log("projectPeriodTo: " + projectPeriodTo);
    console.log("createdBy: " + createdBy);
    console.log("projectName: " + projectName);
    console.log("serviceCategory: " + serviceCategory);
    console.log("projectManager: " + projectManager);
    console.log("engineers: " + engineers);
    console.log("projectType: " + projectType);
    console.log("businessUnit: " + businessUnit);
    console.log("or: " + or);
    console.log("inv: " + inv);
    console.log("productLine: " + productLine);
    console.log("mbs: " + mbs);
    console.log("projectMandays: " + projectMandays);
    console.log("projectAmountGross: " + projectAmountGross);
    console.log("poNumber: " + poNumber);
    console.log("perMondayCost: " + perMondayCost);
    console.log("projectAmountNet: " + projectAmountNet);
    console.log("soNumber: " + soNumber);
    console.log("mondayUsed: " + mondayUsed);
    console.log("cashAdvance: " + cashAdvance);
    console.log("ftNumber: " + ftNumber);
    console.log("payment_stat: " + payment_stat);
    console.log("ref_date: " + ref_date);
    console.log("specialInstruction: " + specialInstruction);
    console.log("resellers: " + resellers);
    console.log("resellers_Contact: " + resellers_Contact);
    console.log("resellerPhoneEmail: " + resellerPhoneEmail);
    console.log("endUser: " + endUser);
    console.log("endUserContactNumber: " + endUserContactNumber);
    console.log("endUserLocation: " + endUserLocation);
    console.log("endUserPhoneEmail: " + endUserPhoneEmail);


    var Data = {
        projectCode: projectCode,
        projectId: projectId,
        projectPeriodFrom: projectPeriodFrom,
        projectPeriodTo: projectPeriodTo,
        created_date:createdDate,
        createdBy: createdBy,
        projectName: projectName,
        serviceCategory: serviceCategory,
        projectManager: projectManager,
        engineers: engineers,
        projectType: projectType,
        businessUnit: businessUnit,
        or: or,
        inv: inv,
        productLine: productLine,
        mbs: mbs,
        projectMandays: projectMandays,
        projectAmountGross: projectAmountGross,
        poNumber: poNumber,
        perMondayCost: perMondayCost,
        projectAmountNet: projectAmountNet,
        soNumber: soNumber,
        mondayUsed: mondayUsed,
        cashAdvance: cashAdvance,
        ftNumber: ftNumber,
        payment_stat: payment_stat,
        ref_date: ref_date,
        specialInstruction: specialInstruction,
        resellers: resellers,
        resellers_Contact: resellers_Contact,
        resellerPhoneEmail: resellerPhoneEmail,
        endUser: endUser,
        endUserContactNumber: endUserContactNumber,
        endUserLocation: endUserLocation,
        endUserPhoneEmail: endUserPhoneEmail,
        projectListStatus: projectListStatus
    };
    

    
    $.ajax({
        type: 'POST',
        url: '/tab-isupport-service/implementation/saveEditProject',
        data: {
            projectdata: JSON.stringify(Data),
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({ text: "Saved successfully!", icon: "success"});
                $("#loading-overlay").hide();
                location.reload();

            } else {
                console.log('Server response error:', response);
                Swal.fire({ text: "Failed to Save", icon: "error"});
                $("#loading-overlay").hide();
                // location.reload();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            Swal.fire({ text: "An error Occurred", icon: "error"});
            console.error('AJAX error:', textStatus, errorThrown);
            console.log('Response text:', jqXHR.responseText);
            $("#loading-overlay").hide();
        }
    });

});

});


////////////////////////// File Saving for Isupport Services ///////////////////////////
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
$(document).ready(function () {

    var table = $('#implementation-datatable').DataTable();
    var selectedData = null;

    // Store the data when a row is clicked
    $('#implementation-datatable tbody').on('click', 'tr', function () {
        selectedData = table.row(this).data();
    });
    


    $("#UploadFileIsupport").off("click").on("click", function () {
        var projectListId = selectedData[25];
        $('#projectsignoff_id').val(projectListId);
    
        // Get selected files
        var fileInput = $('#implementationSupportingDocument')[0].files;
        var project_id = $('#projectsignoff_id').val();
    
        console.log("Attachment: ", project_id);
    
        // Show the spinner
        $("#spinner").show();
    
        if (fileInput.length > 0) {
            var form_data = new FormData();
            for (var i = 0; i < fileInput.length; i++) {
                form_data.append('files[]', fileInput[i]);
            }
            form_data.append('project_id', project_id);
    
            // Log FormData entries
            form_data.forEach(function (value, key) {
                console.log(key, value);
            });
    
            $.ajax({
                url: '/EmailTemplate/Act-Report-Email-Forward/IsupportAttachment',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (output) {
                    console.log('Response from server:', output);
                    Swal.fire({ text: "File Saved successfully!", icon: "success" }).then(() => {
                        // Hide the spinner
                        $("#spinner").hide();
            
                        // Clear the file input
                        $("#implementationSupportingDocument").val('');
            
                        // Enhanced file display with delete option
                        $("#implementAttachment").empty();
            
                        if (output.files && output.files.length > 0) {
                            var attachmentsWrapper = $('<div class="attachments-wrapper"></div>').css({
                                display: 'flex',
                                gap: '10px',
                            });
            
                            var imagePaths = {
                                pdf: '/assets/img/pdf.png',
                                png: '/assets/img/png.png',
                                jpg: '/assets/img/jpg.png',
                                jpeg: '/assets/img/jpeg.png',
                                xlsx: '/assets/img/excel.png',
                                xls: '/assets/img/excel.png',
                                doc: '/assets/img/doc.png',
                                docx: '/assets/img/doc.png',
                                txt: '/assets/img/txt.png',
                                // Extend as needed
                            };
            
                            output.files.forEach(function (file) {
                                var filePath = '/uploads/Isupport-Attachments/' + file;
                                var parts = file.split('.');
                                var attachmentName = parts.slice(0, -1).join('.');
                                var fileType = parts.slice(-1)[0].toLowerCase();
                                var imageSrc = imagePaths[fileType] || '/assets/img/default.png';
            
                                // Create container for each file
                                var attachmentContainer = $('<div class="attachment-container"></div>').css({
                                    textAlign: 'center',
                                    fontSize: '12px',
                                    marginBottom: '10px',
                                    display: 'flex',
                                    flexDirection: 'column',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    width: '150px',
                                    border: '1px solid #ddd',
                                    borderRadius: '8px',
                                    padding: '10px',
                                    backgroundColor: '#f9f9f9',
                                });
            
                                // Image for the attachment
                                var imageElement = $('<img>').attr('src', imageSrc).css({
                                    width: '55px',
                                    height: '55px',
                                    marginBottom: '5px',
                                    cursor: 'pointer',
                                    transition: 'transform 0.2s',
                                }).hover(
                                    function () { $(this).css('transform', 'scale(1.2)'); },
                                    function () { $(this).css('transform', 'scale(1)'); }
                                );
            
                                // Download link
                                var downloadLink = $('<a></a>')
                                    .attr({ href: filePath, download: attachmentName, target: '_blank' })
                                    .append(imageElement);
            
                                // Delete button
                                var removeButton = $('<button type="button">Delete</button>').css({
                                    backgroundColor: '#f44336',
                                    color: '#fff',
                                    border: 'none',
                                    padding: '5px',
                                    cursor: 'pointer',
                                    fontSize: '10px',
                                    borderRadius: '4px',
                                    marginTop: '5px',
                                }).on('click', function () {
                                    Swal.fire({
                                        text: `Are you sure you want to delete the file: "${attachmentName}"?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#3085d6',
                                        confirmButtonText: 'Yes, delete it!',
                                        heightAuto: false,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: '/EmailTemplate/Act-Report-Email-Forward/deleteAttachment',
                                                type: 'post',
                                                data: { file_name: file },
                                                success: function (response) {
                                                    Swal.fire("Deleted!", "Your file has been deleted.", "success");
                                                    attachmentContainer.remove(); // Remove the UI element
                                                },
                                                error: function () {
                                                    Swal.fire("Error!", "Failed to delete the file.", "error");
                                                }
                                            });
                                        }
                                    });
                                });
            
                                // Append elements to the container
                                attachmentContainer.append(downloadLink);
                                attachmentContainer.append(
                                    $('<span></span>')
                                        .text(attachmentName.length > 25 ? attachmentName.slice(0, 25) + '...' : attachmentName)
                                        .css({ fontWeight: 'bold', wordBreak: 'break-word', textAlign: 'center', fontSize: '10px' })
                                );
                                attachmentContainer.append(removeButton);
            
                                // Append the attachment container to the wrapper
                                attachmentsWrapper.append(attachmentContainer);
                            });
            
                            $("#implementAttachment").append(attachmentsWrapper);
                        } else {
                            $("#implementAttachment").html('<p>No files uploaded yet.</p>');
                        }
            
                        // Optional: Reset the form if needed
                         $("#implementationSupportingDocument").val('');

                    });
                },
                error: function (err) {
                    console.error("Error savingfile:", err);
                    Swal.fire({ text: "File saving failed!", icon: "error" });
                }
            });            
        } else {
            Swal.fire({ text: "Please select at least one file to upload", icon: "warning" });
            $("#spinner").hide();
        }
    });
      
    $("#uploadSignOffDocButton").off("click").on("click", function () {
        var projectListId = selectedData[25];
        var proj_completed = selectedData[16];
        $('#projectsignoff_id').val(projectListId);
    
        // Get selected files
        var fileInput = $('#signoffFile')[0].files;
        var project_id = $('#projectsignoff_id').val();
    
        console.log("Attachment: ", project_id);
    
        // Show the spinner
        console.log("Showing the spinner");
        $("#spinner2").css({"display": "inline-block", "opacity": 1});
    
        if (fileInput.length > 0) {
            var form_data = new FormData();
            for (var i = 0; i < fileInput.length; i++) {
                form_data.append('files[]', fileInput[i]);
            }
            form_data.append('project_id', project_id);
    
            // Log FormData entries
            form_data.forEach(function (value, key) {
                console.log(key, value);
            });
    
            $.ajax({
                url: '/tab-isupport-service/signOfftAttachment',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (output) {
                    console.log('Response from server:', output);
                    Swal.fire({
                        text: "Project is completed successfully!",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Reload the page
                            location.reload();
                        }
                    });
    
                    // Hide the spinner after showing the alert
                    $("#spinner2").hide();
                    $("#signoffFile").val('');
    
                    // Update the project status if it is "On Going"
                    if (proj_completed === "On Going") {
                        $.ajax({
                            url: '/tab-isupport-service/updateProjectStatus',
                            type: 'post',
                            data: {
                                project_id: project_id,
                                status: 'Completed'
                            },
                            success: function (response) {
                                console.log('Project status updated:', response);
                            },
                            error: function (xhr, status, error) {
                                console.error('Failed to update project status:', error);
                            }
                        });
                    }
    
                    // Hide the modal using Bootstrap's modal API
                    $('#uploadSignOffFile').modal('hide').on('hidden.bs.modal', function () {
                        $('.modal-backdrop').remove(); // Remove the backdrop
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire({ text: "Error saving files.", icon: "error" });
    
                    // Hide the spinner if an error occurs
                    $("#spinner2").hide();
                }
            });
        } else {
            Swal.fire({ text: "Please select at least one file to upload", icon: "warning" });
    
            // Hide the spinner if no files are selected
            $("#spinner").hide();
        }
    });    
    
    $("#CashAdvanceAttachment").off("click").on("click", function () {
        var projectListId = selectedData[25];
        $('#projectsignoff_id').val(projectListId);
    
        // Get selected files
        var fileInput = $('#implementationSupportingDocument')[0].files;
        var project_id = $('#projectsignoff_id').val();
    
        console.log("Attachment: ", project_id);
    
        // Show the spinner
        $("#spinner").show();
    
        if (fileInput.length > 0) {
            var form_data = new FormData();
            for (var i = 0; i < fileInput.length; i++) {
                form_data.append('files[]', fileInput[i]);
            }
            form_data.append('project_id', project_id);
    
            // Log FormData entries
            form_data.forEach(function (value, key) {
                console.log(key, value);
            });
    
            $.ajax({
                url: '/tab-isupport-service/CashRequestAttachment',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function (output) {
                    console.log('Response from server:', output);
                    Swal.fire({ text: "File Saved successfully!", icon: "success" }).then(() => {
                        // Hide the spinner
                        $("#spinner").hide();
            
                        // Clear the file input
                        $("#implementationSupportingDocument").val('');
            
                        // Enhanced file display with delete option
                        $("#cashRequestUploadDocument").empty();
            
                        if (output.files && output.files.length > 0) {
                            var attachmentsWrapper = $('<div class="attachments-wrapper"></div>').css({
                                display: 'flex',
                                gap: '10px',
                            });
            
                            var imagePaths = {
                                pdf: '/assets/img/pdf.png',
                                png: '/assets/img/png.png',
                                jpg: '/assets/img/jpg.png',
                                jpeg: '/assets/img/jpeg.png',
                                xlsx: '/assets/img/excel.png',
                                xls: '/assets/img/excel.png',
                                doc: '/assets/img/doc.png',
                                docx: '/assets/img/doc.png',
                                txt: '/assets/img/txt.png',
                                // Extend as needed
                            };
            
                            output.files.forEach(function (file) {
                                var filePath = '/uploads/Cash-Advance-Request-Attachment/' + file;
                                var parts = file.split('.');
                                var attachmentName = parts.slice(0, -1).join('.');
                                var fileType = parts.slice(-1)[0].toLowerCase();
                                var imageSrc = imagePaths[fileType] || '/assets/img/default.png';
            
                                // Create container for each file
                                var attachmentContainer = $('<div class="attachment-container"></div>').css({
                                    textAlign: 'center',
                                    fontSize: '12px',
                                    marginBottom: '10px',
                                    display: 'flex',
                                    flexDirection: 'column',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    width: '150px',
                                    border: '1px solid #ddd',
                                    borderRadius: '8px',
                                    padding: '10px',
                                    backgroundColor: '#f9f9f9',
                                });
            
                                // Image for the attachment
                                var imageElement = $('<img>').attr('src', imageSrc).css({
                                    width: '55px',
                                    height: '55px',
                                    marginBottom: '5px',
                                    cursor: 'pointer',
                                    transition: 'transform 0.2s',
                                }).hover(
                                    function () { $(this).css('transform', 'scale(1.2)'); },
                                    function () { $(this).css('transform', 'scale(1)'); }
                                );
            
                                // Download link
                                var downloadLink = $('<a></a>')
                                    .attr({ href: filePath, download: attachmentName, target: '_blank' })
                                    .append(imageElement);
            
                                // Delete button
                                var removeButton = $('<button type="button">Delete</button>').css({
                                    backgroundColor: '#f44336',
                                    color: '#fff',
                                    border: 'none',
                                    padding: '5px',
                                    cursor: 'pointer',
                                    fontSize: '10px',
                                    borderRadius: '4px',
                                    marginTop: '5px',
                                }).on('click', function () {
                                    Swal.fire({
                                        text: `Are you sure you want to delete the file: "${attachmentName}"?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: '#d33',
                                        cancelButtonColor: '#3085d6',
                                        confirmButtonText: 'Yes, delete it!',
                                        heightAuto: false,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            console.log('User confirmed deletion of file:', attachmentName);

                                            $.ajax({
                                                url: '/tab-isupport-service/CashRequestDeleteAttachment',
                                                type: 'post',
                                                data: { file_name: file,
                                                    _token: $('meta[name="csrf-token"]').attr('content')
                                                 },
                                                success: function (response) {
                                                    console.log('Delete success response:', response);
                                                    Swal.fire("Deleted!", "Your file has been deleted.", "success");
                                                    attachmentContainer.remove(); // Remove the UI element
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error('Delete failed:', status, error, xhr.responseText);
                                                    Swal.fire("Error!", "Failed to delete the file.", "error");
                                                }
                                            });
                                        } else {
                                            console.log('User canceled deletion');
                                        }
                                    });
                                });
            
                                // Append elements to the container
                                attachmentContainer.append(downloadLink);
                                attachmentContainer.append(
                                    $('<span></span>')
                                        .text(attachmentName.length > 25 ? attachmentName.slice(0, 25) + '...' : attachmentName)
                                        .css({ fontWeight: 'bold', wordBreak: 'break-word', textAlign: 'center', fontSize: '10px' })
                                );
                                attachmentContainer.append(removeButton);
            
                                // Append the attachment container to the wrapper
                                attachmentsWrapper.append(attachmentContainer);
                            });
            
                            $("#cashRequestUploadDocument").append(attachmentsWrapper);
                        } else {
                            $("#cashRequestUploadDocument").html('<p>No files uploaded yet.</p>');
                        }
            
                        // Optional: Reset the form if needed
                       $("#implementationSupportingDocument").val('');
                    });
                },
                error: function (err) {
                    console.error("Error savingfile:", err);
                    Swal.fire({ text: "File saving failed!", icon: "error" });
                }
            });            
        } else {
            Swal.fire({ text: "Please select at least one file to upload", icon: "warning" });
            $("#spinner").hide();
        }
    });
       
});
