var reference_num = null;
var isReferenceNoSet = false;
$(document).ready(function () {
    // Handle the custom event referenceNoSet
    $(document).on('referenceNoSet', function () {
        reference_num = $('#reference_no .reference_no').text();
        console.log("referenceNoSet event triggered, reference_num:", reference_num);
        isReferenceNoSet = true;
    });

    // Example of triggering the event (you should trigger this event where you set the reference number)
    // $(document).trigger('referenceNoSet');
});

// $(document).ready(function () {
//     $("#sendactivity").off("click").on("click", function () {
//         $("#loading-overlay").show();


//         function validateEmail(email) {
//             var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//             return re.test(email);
//         }

//         function getValidEmails(input) {
//             return input.split(',')
//                         .map(email => email.trim())
//                         .filter(email => email !== '' && validateEmail(email));
//         }



//         var sendTo = getValidEmails($('#txtTo').val());
//         var sendCC = getValidEmails($('#txtCC').val());
//         var sendBCC = getValidEmails($('#txtBCC').val());
//         var sendSubject = $('#txtSubject').val();
//         var sendMessage = $('#txtMessage').val();

//         if (sendTo.length === 0 || sendSubject.trim() === '' || sendMessage.trim() === '') {
//             var missingField = sendTo.length === 0 ? 'Send to Email Address' : sendSubject.trim() === '' ? 'Subject' : 'Message';
//             Swal.fire({
//                 text: "Please provide " + missingField,
//                 icon: "warning"
//             });
//             $("#loading-overlay").hide();
//             return; // Abort the process
//         }


//         var report = $('#reportDropdown1').val();
//         var status = $('#statusDropdown1').val();
//         var projtype = $('#projtype_button1').val();
//         var projname = $('#myDropdown1  option:selected').text().trim();
//         // var reference_num = $('#reference_no .reference_no').text();
//         // Check if the reference number has been set by the custom event
//         if (!isReferenceNoSet) {
//             // Fetch the reference number directly as a fallback
//             reference_num = $('#reference_no .reference_no').text();
//             console.log("Fallback fetching reference_num:", reference_num);

//             // You can add an additional check here if the reference number is still null or empty
//             if (!reference_num) {
//                 Swal.fire({ text: "Reference number is not set yet", icon: "warning"});
//                 $("#loading-overlay").hide();
//                 return;
//             }
//         }

//         var act_details = $('#Activity_details').val();
//         var act_details_req = $('#act_details_requester').val();
//         var product_engr = $('#engineers_modal option:selected')
//         .map(function () {
//             return $(this).text().trim();
//         })
//         .get()
//         .join(', ');

//         var date_filed = $('#Date_Filed').val();
//         var act_details_activity = $('#act_details_activity').val();
//         var copy_to = $('#Copy_to option:selected')
//         .map(function () {
//             return $(this).text().trim();
//         })
//         .get()
//         .join(', ');
//         var date_needed = $('#Date_Needed').val();
//         var special_instr = $('#special_instruction').val();

//         var reseller = $('#Reseller').val();
//         var reseller_contact = $('#reseller_contact_info').val();
//         var reseller_phone_email = $('#reseller_phone_email').val();
//         var enduser_name = $('#end_user_name').val();
//         var enduser_contact = $('#end_user_contact').val();
//         var enduser_email = $('#end_user_email').val();
//         var enduser_location = $('#end_user_loc').val();


//         var Act_date = $('#act_date').val();
//         var Activity_type = $('#Activity_Type').val();
//         var Program = $('#program').val();
//         var Product_line = $('#product_line option:selected')
//         .map(function () {
//             return $(this).text().trim();
//         })
//         .get()
//         .join(', ');



//         var engineer_name = $('#engineers_modal_two option:selected')
//         .map(function () {
//             return $(this).text().trim();
//         })
//         .get()
//         .join(', ');

//         var Venue = $('#venue').val();
//         var Send_copy_to = $('#sendcopyto').val();


//         var Time_expected1 = $('#time_expected1').val();
//         var Time_reported1 = $('#time_reported1').val();
//         var Time_exited1 = $('#time_exited1').val();

//         var customer_req = $('#customerReqfield').val();
//         var Activity_Done = $('#activity_donefield').val();
//         var Agreements = $('#Agreementsfield').val();

//         var formData = [];
//         $(".participantposition").each(function () {
//             var participant = $(this).find(".participant").val();
//             var position = $(this).find(".position").val();
//             if (participant !== undefined && position !== undefined && participant !== "" && position !== "") {
//                 formData.push({ participant: participant, position: position });
//             }
//         });

//         var ActionPlanRecommendation = [];
//         $(".actionplan").each(function () {
//             var plantarget = $(this).find(".PlanTarget").val();
//             var details = $(this).find(".Details").val();
//             var planowner = $(this).find(".PlanOwner").val();
//             if (plantarget !== undefined && details !== undefined && planowner !== undefined
//                 && plantarget !== "" && details !== "" && planowner !== "") {
//                 ActionPlanRecommendation.push({ plantarget: plantarget, details: details, planowner: planowner });
//             }
//         });

//              // Capture attachment information
//              var attachments = [];
//              $("#fileDisplay a").each(function () {
//                  var attachment = $(this).attr("href");
//                  if (attachment) {
//                      attachments.push(attachment);
//                  }
//              });

//         // Storing data in sessionStorage
//         var dataToStore = {
//           report,status, projtype,projname, reference_num, act_details, act_details_req,product_engr,date_filed,
//           act_details_activity, copy_to, date_needed, special_instr,reseller,reseller_contact,reseller_phone_email,
//           enduser_name,enduser_contact,enduser_email,enduser_location, Act_date, Activity_type, Program,Product_line,
//           Time_expected1, Time_reported1, Time_exited1, engineer_name,Venue,Send_copy_to, customer_req,Activity_Done,Agreements,formData,
//           ActionPlanRecommendation,attachments,sendTo,sendCC,sendBCC,sendSubject,sendMessage

//         };

//         $.ajax({
//             type: 'POST',
//             url: '/EmailTemplate/Act-Report-Email-Forward/send',
//             data: {
//                 reportData: JSON.stringify(dataToStore),
//                 _token: $('meta[name="csrf-token"]').attr('content')
//             },
//             success: function (response) {
//                 if (response.success) {
//                     Swal.fire({ text: "Email Send Successfully", icon: "success"});
//                     $("#loading-overlay").hide();
//                     $('#forwardmodal').modal('hide');
//                 } else {
//                     console.log('Server response error:', response);
//                     Swal.fire({ text: "Failed to Send Email", icon: "error"});
//                     $("#loading-overlay").hide();
//                 }
//             },
//             error: function (jqXHR, textStatus, errorThrown) {
//                 Swal.fire({ text: "Error Occurred", icon: "error"});
//                 console.error('AJAX error:', textStatus, errorThrown);
//                 console.log('Response text:', jqXHR.responseText);

//                 $("#loading-overlay").hide();
//             }
//         });

//     });
// });

$(document).ready(function () {
    $("#sendactivity").off("click").on("click", function () {
        $("#loading-overlay").show();

        // function validateEmail(email) {
        //     var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        //     return re.test(email);
        // }
        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+$/; // Basic email pattern
            var domain = "@msi-ecs.com.ph";
            return re.test(email) && email.endsWith(domain);
        }

        function getEmails(input) {
            return input.split(',').map(email => email.trim()).filter(email => email !== '');
        }

        function showError(inputId, message) {
            $("#" + inputId).next(".error-message").text(message).show();
        }

        function clearErrors() {
            $(".error-message").text("").hide();
        }

        clearErrors();


        var sendTo = getEmails($('#txtTo').val());
        var sendCC = getEmails($('#txtCC').val());
        var sendBCC = getEmails($('#txtBCC').val());
        var sendSubject = $('#txtSubject').val();
        var sendMessage = $('#txtMessage').val();

        // var invalidEmails = sendTo.filter(email => !validateEmail(email));

        // if (invalidEmails.length > 0) {
        //     showError("txtTo", "*Invalid email/s: " + invalidEmails.join(', '));
        //     Swal.fire({
        //         text: "Please provide valid email addresses ending with @msi-ecs.com.ph. Invalid email/s: " + invalidEmails.join(', '),
        //         icon: "warning"
        //     });
        //     $("#loading-overlay").hide();
        //     return; // Abort the process
        // }

        if (sendTo.length === 0) {
            showError("txtTo", "*Please provide an Email Address.");
            Swal.fire({
                text: "Please provide an Email Address.",
                icon: "warning"
            });
            $("#loading-overlay").hide();
            return; // Abort the process
        }

        if (sendSubject.trim() === '') {
            showError("txtSubject", "*Please provide a Subject.");
            Swal.fire({
                text: "Please provide a Subject.",
                icon: "warning"
            });
            $("#loading-overlay").hide();
            return; // Abort the process
        }

        if (sendMessage.trim() === '') {
            showError("txtMessage", "*Please provide a Message.");
            Swal.fire({
                text: "Please provide a Message.",
                icon: "warning"
            });
            $("#loading-overlay").hide();
            return; // Abort the process
        }


        // if (sendTo.length === 0 || sendSubject.trim() === '' || sendMessage.trim() === '') {
        //     var missingField = sendTo.length === 0 ? 'Email Address' : sendSubject.trim() === '' ? 'Subject' : 'Message';
        //     Swal.fire({
        //         text: "Please provide " + missingField,
        //         icon: "warning"
        //     });
        //     $("#loading-overlay").hide();
        //     return; // Abort the process
        // }

        var report = $('#reportDropdown1').val();
        var status = $('#statusDropdown1').val();
        var projtype = $('#projtype_button1').val();
        var projname = $('#myDropdown1 option:selected').text().trim();

        // Check if the reference number has been set by the custom event
        if (!isReferenceNoSet) {
            reference_num = $('#reference_no .reference_no').text();
            console.log("Fallback fetching reference_num:", reference_num);

            if (!reference_num) {
                Swal.fire({ text: "Reference number is not set yet", icon: "warning" });
                $("#loading-overlay").hide();
                return;
            }
        }

        var act_details = $('#Activity_details').val();
        var act_details_req = $('#act_details_requester').val();
        var product_engr = $('#engineers_modal option:selected').map(function () {
            return $(this).text().trim();
        }).get().join(', ');

        var date_filed = $('#Date_Filed').val();
        var act_details_activity = $('#act_details_activity').val();
        var copy_to = $('#Copy_to option:selected').map(function () {
            return $(this).text().trim();
        }).get().join(', ');
        var date_needed = $('#Date_Needed').val();
        var special_instr = $('#special_instruction').val();

        var reseller = $('#Reseller').val();
        var reseller_contact = $('#reseller_contact_info').val();
        var reseller_phone_email = $('#reseller_phone_email').val();
        var enduser_name = $('#end_user_name').val();
        var enduser_contact = $('#end_user_contact').val();
        var enduser_email = $('#end_user_email').val();
        var enduser_location = $('#end_user_loc').val();

        var Act_date = $('#act_date').val();
        var Activity_type = $('#Activity_Type').val();
        var Program = $('#program').val();
        var Product_line = $('#product_line option:selected').map(function () {
            return $(this).text().trim();
        }).get().join(', ');

        var Product_Code = $('#product_code').val();

        var engineer_name = $('#engineers_modal_two option:selected').map(function () {
            return $(this).text().trim();
        }).get().join(', ');

        var Venue = $('#venue').val();
        var Send_copy_to = $('#sendcopyto').val();

        var Time_expected1 = $('#time_expected1').val();
        var Time_reported1 = $('#time_reported1').val();
        var Time_exited1 = $('#time_exited1').val();

        var customer_req = $('#customerReqfield').val();
        var Activity_Done = $('#activity_donefield').val();
        var Agreements = $('#Agreementsfield').val();

        var straCert_TopicName = $('#stra_topicName').val();
        var straCert_DateStart = $('#stra_dateStart').val();
        var straCert_DateEnd = $('#stra_dateEnd').val();

        var productModel = $('#modal_prodModel').val();
        var assetCode = $('#modal_assetCode').val();
        var poc_dateStart = $('#modal_poc_dateStart').val();
        var poc_dateEnd = $('#modal_poc_dateEnd').val();

        // Technical Cert
        var tech_Title = $('#modal_title').val();
        var tech_examCode = $('#modal_examCode').val();
        var tech_status = $('#modal_takeStatusDropdown').val();
        var tech_ScoreDropdown = $('#modal_scoreDropdown').val();
        var tech_examType = $('#modal_examTypeDropdown').val();
        var tech_incStatus = $('#modal_incentiveStatusDropdown').val();
        var tect_incDetails = $('#modal_incentiveDetailsDropdown').val();
        var tech_examAmount = $('#modal_amount').val();

         // Technology
         var Tech_ProdLearned = $('#modal_techprodLearned').val();

         // Skills Dev
         var skills_trainingName = $('#modal_trainingName').val();
         var skills_speaker = $('#modal_speaker').val();
         var skills_location = $('#modal_location').val();
         var skill_bpcheckBox = $('#bpCheckbox').is(':checked') ? 1 : 0;
         var skills_eucheckbox = $('#euCheckbox').is(':checked') ? 1 : 0;
         var skill_msicheckbox = $('#MSICheckbox').is(':checked') ? 1 : 0;


        var Digi_flyers = [];
        $("#digiknowfileDisplay a").each(function () {
            var Digi_flyersattachment = $(this).attr("href");
            if (Digi_flyersattachment) {
                Digi_flyers.push(Digi_flyersattachment);
            }
        });
        var bp_digiCheckbox = $('#modal_bpDigiCheckbox').is(':checked') ? 1 : 0;
        var eu_digiCheckbox = $('#modal_euDigiCheckbox').is(':checked') ? 1 : 0;

        var internal_Msi = $('#modal_MSIProjName').val();
        var internal_Percent = $('#modal_CompliancePercentage').val();
        var internal_Attendance = $('#modalperfectAttendance').val();

        var memo_Issued = $('#modal_memoIssued').val();
        var memo_Details = $('#modal_memoDetails').val();

        var engr_feedback = $('#modal_engrFeedbackInput').val();
        var engr_rating = $('#modal_other_rating').val();

        var T2R_topic = $('#modal_topicName').val();
        var T2R_datestart = $('#modal_dateStart').val();
        var T2R_dateEnd = $('#modal_dateEnd').val();

        var formData = [];
        $(".participantposition").each(function () {
            var participant = $(this).find(".participant").val();
            var position = $(this).find(".position").val();
            if (participant !== undefined && position !== undefined && participant !== "" && position !== "") {
                formData.push({ participant: participant, position: position });
            }
        });

        var ActionPlanRecommendation = [];
        $(".actionplan").each(function () {
            var plantarget = $(this).find(".PlanTarget").val();
            var details = $(this).find(".Details").val();
            var planowner = $(this).find(".PlanOwner").val();
            if (plantarget !== undefined && details !== undefined && planowner !== undefined
                && plantarget !== "" && details !== "" && planowner !== "") {
                ActionPlanRecommendation.push({ plantarget: plantarget, details: details, planowner: planowner });
            }
        });

        // Capture attachment information
        var attachments = [];
        $("#fileDisplay a").each(function () {
            var attachment = $(this).attr("href");
            if (attachment) {
                attachments.push(attachment);
            }
        });

        // Storing data in sessionStorage
        var dataToStore = {
            report, status, projtype, projname, reference_num, act_details, act_details_req, product_engr, date_filed,
            act_details_activity, copy_to, date_needed, special_instr, reseller, reseller_contact, reseller_phone_email,
            enduser_name, enduser_contact, enduser_email, enduser_location, Act_date, Activity_type, Program, Product_line, Product_Code,
            Time_expected1, Time_reported1, Time_exited1, engineer_name, Venue, Send_copy_to, customer_req, Activity_Done, Agreements, formData,
            straCert_TopicName, straCert_DateStart, straCert_DateEnd, productModel, assetCode, poc_dateStart, poc_dateEnd,
            Digi_flyers, bp_digiCheckbox, eu_digiCheckbox, internal_Msi, internal_Percent, internal_Attendance, memo_Issued,
            memo_Details, engr_feedback, engr_rating, T2R_topic, T2R_datestart, T2R_dateEnd, tech_Title, tech_examCode, tech_status,
            tech_ScoreDropdown, tech_examType, tech_incStatus, tect_incDetails, tech_examAmount, Tech_ProdLearned, skills_trainingName,
            skills_speaker, skills_location, skill_bpcheckBox, skills_eucheckbox, skill_msicheckbox,
            ActionPlanRecommendation, attachments, sendTo, sendCC, sendBCC, sendSubject, sendMessage
        };

        $.ajax({
            type: 'POST',
            url: '/EmailTemplate/Act-Report-Email-Forward/send',
            data: {
                reportData: JSON.stringify(dataToStore),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({ text: "Email Sent Successfully", icon: "success" });
                    $("#loading-overlay").hide();
                    $('#forwardmodal').modal('hide');
                } else {
                    console.log('Server response error:', response);
                    Swal.fire({ text: "Failed to Send Email", icon: "error" });
                    $("#loading-overlay").hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({ text: "Error Occurred", icon: "error" });
                console.error('AJAX error:', textStatus, errorThrown);
                console.log('Response text:', jqXHR.responseText);

                $("#loading-overlay").hide();
            }
        });
    });
});




// Clear Forward fields
function clearModalFields() {
    $('#txtTo').val('');
    $('#txtCC').val('');
    $('#txtBCC').val('');
    $('#txtSubject').val('');
    $('#txtMessage').val('');
}

// Clear the modal fields when the modal is hidden
$('#forwardmodal').on('hidden.bs.modal', function () {
    clearModalFields();
    $('#exampleModal').focus();
});

