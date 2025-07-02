//Get Datatable
$(document).ready(function () {
    $('#manday-table').DataTable({
        scrollX: true,
    });
});

    //Highlight clicked row
    $('#manday-table td').on('click', function() {
            
        // Remove previous highlight class
        $(this).closest('table').find('tr.highlight').removeClass('highlight');
        
        // add highlight to the parent tr of the clicked td
        $(this).parent('tr').addClass("highlight");
    });

// Engineer Name
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

//Get Project Name
$(document).ready(function () {
    $('#projectname').select2({
        width: '100%',
        multiple: true,
        tags: true,
        ajax: {
            url: '/tab-manday/getProjname',
            dataType: 'json',
            delay: 250, // Delay in milliseconds before making the request
            data: function (params) {
                return {
                    term: params.term, // Pass the search term to the server
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            id: item,
                            text: item
                        };
                    })
                };
            }
        }
    });
});

