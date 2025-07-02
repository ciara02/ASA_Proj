<?php

namespace App\Http\Controllers;

use App\Models\tbl_activityReport;
use App\Models\tbl_attachments;
use App\Models\tbl_business_unit;
use App\Models\tbl_cashAdvance;
use App\Models\tbl_productLine;
use App\Models\tbl_project_signoff_attachment;
use App\Models\tbl_project_type_list;
use App\Models\tbl_time_list;
use App\Models\tbl_report_list;
use App\Models\tbl_status_list;
use App\Services\ProjectQuery;
use Illuminate\Http\Request;
use App\Models\tbl_engineers;
use App\Models\tbl_payment;
use App\Models\tbl_proj_attachment;
use App\Models\tbl_project_list;
use App\Models\tbl_projectMember;
use App\Models\tbl_projectSignOff;
use App\Models\tbl_projectSignoffApproval;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\LDAPEngineer;
use App\Models\tbl_activityType_list;
use App\Models\tbl_cash_advance_attachments;
use App\Models\tbl_prodEngineers;
use App\Models\tbl_program_list;
use App\Services\ProductLineQuery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class ISupportController extends Controller
{

    public function fetchImplementationProjects($projTypeId)
    {
        $projectList = new tbl_project_list();

        return $projectList->fetchImplementationProjects($projTypeId);
    }
    private function getAllowedEmails()
    {
        return [
            'ciara_dymosco@msi-ecs.com.ph',
            'keem_eslera@msi-ecs.com.ph',
            'gary_delcastillo@msi-ecs.com.ph',
            'sonnie_calimutan@msi-ecs.com.ph',
            'jennie_dionisio@msi-ecs.com.ph',
            'justin_rivera@msi-ecs.com.ph',
            'louie_ladio@msi-ecs.com.ph',
            'maybel_estipular@msi-ecs.com.ph',
            'melvin_manzanares@msi-ecs.com.ph',
            'chux_lunar@msi-ecs.com.ph',
            'rey_fuyonan@msi-ecs.com.ph',
            'ed_recinto@msi-ecs.com.ph',
            'reeree_delosreyes@msi-ecs.com.ph',
            'el_linugo@msi-ecs.com.ph',
            'jay_ballesteros@msi-ecs.com.ph'
        ];
    }
    

    public function implementationIndex()
{
    // Fetch implementation projects
    $implementationProjects = $this->fetchImplementationProjects(1);

    // Get the authenticated user's email
    $ldapUsername = Auth::user()->email;

    $user = Auth::user();
    $allowedEmails = $this->getAllowedEmails();

    $isAllowedToEdit = in_array(strtolower($user->email), $allowedEmails);

    // Transform the email to match LDAP format (if needed)
    $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));

    // Log the transformed email for debugging
    Log::info('Transformed email for LDAP search: ' . $ldapUsername);

    // Fetch the LDAP user data
    $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);

    // Ensure $ldapEngineer is an object with a default structure
    if (!$ldapEngineer) {
        Log::info('Setting default values for LDAP user.');
        $ldapEngineer = (object) ['email' => ''];
    }

    // Return the view with required data
    return view('tab-isupport-service.implementation.index', compact('implementationProjects', 'ldapEngineer', 'isAllowedToEdit'));
}



    public function implementationCreate()
    {
        $ldapUsername = Auth::user()->email;

        // Transform the email to match LDAP format (if needed)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email for debugging
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
    
        // Ensure $ldapEngineer is an object with a default structure
        if (!$ldapEngineer) {
            Log::info('Setting default values for LDAP user.');
            $ldapEngineer = (object) ['email' => ''];
        }

        return view('tab-isupport-service.implementation.create', compact('ldapEngineer'));
    }

    public function getEngineers(Request $request)
    {
        $term = $request->input('term'); 

        $engineers = tbl_engineers::where('engr_name', 'like', "%$term%")
            ->distinct()
            ->orderBy('engr_name')
            ->pluck('engr_name');

        return response()->json(['data' => $engineers]);
    }


    public function maintenanceAgreementIndex()
    {
        $implementationProjects = $this->fetchImplementationProjects(2);

        $ldapUsername = Auth::user()->email;

        // Transform the email to match LDAP format (if needed)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));

         $user = Auth::user();
        $allowedEmails = $this->getAllowedEmails();

        $isAllowedToEdit = in_array(strtolower($user->email), $allowedEmails);
    
        // Log the transformed email for debugging
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
    
        // Ensure $ldapEngineer is an object with a default structure
        if (!$ldapEngineer) {
            Log::info('Setting default values for LDAP user.');
            $ldapEngineer = (object) ['email' => ''];
        }

        return view('tab-isupport-service.maintenance-agreement.index', compact('implementationProjects', 'ldapEngineer', 'isAllowedToEdit'));
    }

    public function maintenanceAgreementCreate()
    {
        $ldapUsername = Auth::user()->email;

        // Transform the email to match LDAP format (if needed)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email for debugging
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
    
        // Ensure $ldapEngineer is an object with a default structure
        if (!$ldapEngineer) {
            Log::info('Setting default values for LDAP user.');
            $ldapEngineer = (object) ['email' => ''];
        }

        return view('tab-isupport-service.maintenance-agreement.create', compact('ldapEngineer'));
    }

    
    public function hide(Request $request)
{
    $ids = $request->input('ids');

    tbl_project_list::whereIn('id', $ids)->update(['is_hidden' => 1]);

    return response()->json(['message' => 'Projects hidden successfully.']);
}


    // PROJECT SIGN-OFF MENU
    public function projectSignOffIndex()
    {
        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);

        return view('tab-isupport-service.project-sign-off.index', compact('ldapEngineer'));
    }

    public function projectSignOffSearch(Request $request)
    {
        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);

        $dateFrom = $request->input('dateFrom');
        $dateTo = $request->input('dateTo');
        $engineers = $request->input('engineer');

        $projectSignOff = new tbl_projectSignOff();

        $projects = $projectSignOff->projectSignOffSearch($dateFrom, $dateTo, $engineers);

        return view('tab-isupport-service.project-sign-off.index', compact('projects', 'ldapEngineer'));
    }


    public function getERPprojectCode(Request $request)
    {
        $term = $request->input('term');
        try {
            $projectCodeQuery = new ProjectQuery();
            $projectCodes = $projectCodeQuery->get_ERPprojects($term);

            $projectCodes = array_map(function ($project) {
                return $project->code;
            }, $projectCodes);

            return response()->json(['data' => $projectCodes]);
        } catch (\Exception $e) {
            Log::error('Error fetching ERP Project Codes: ' . $e->getMessage());
            return response()->json(['data' => []], 500);
        }
    }

    public function getERPBusinessUnit(Request $request)
    {
        $term = $request->input('term');

        $businessUnitQuery = new ProjectQuery();
        $businessUnit = $businessUnitQuery->get_ERP_BusinessUnit($term); // Assuming you have a method like this


        return response()->json(['data' => $businessUnit]);
    }

    public function getapproversName(Request $request)
    {
        $proj_IDValue = $request->proj_id;


        $getprojectSignoff = tbl_projectSignOff::with('getProjSignoffApprovers')
            ->where('project_id', 'like', '%' . ($proj_IDValue) . '%')
            ->get();

        $actionPlanArray = [];

        foreach ($getprojectSignoff as $projectSignoff) {
            $actionPlans =  [
                'company' => $projectSignoff->getProjSignoffApprovers->pluck('company'),
                'name' => $projectSignoff->getProjSignoffApprovers->pluck('name'),
                'position' => $projectSignoff->getProjSignoffApprovers->pluck('position'),
                'email_address' => $projectSignoff->getProjSignoffApprovers->pluck('email_address'),
                'statusforApproval' => $projectSignoff->getProjSignoffApprovers->pluck('status')
            ];

            $actionPlanArray[] = $actionPlans;
        }

        return response()->json($actionPlanArray);
    }



    public function storeProjectOpp(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'projectCode' => 'required',
                'projectPeriodFrom' => 'nullable',
                'projectPeriodTo' => 'nullable',
                'projectName' => 'required',
                'serviceCategory' => 'required',
                'createdBy_Input' => 'nullable',
                'projectManager' => 'nullable',
                'engineers' => 'required|array',
                'businessUnit' => 'nullable',
                'iSupport_product_input' => 'nullable',
                'projectType' => 'required',
                'or' => 'nullable',
                'inv' => 'nullable',
                'mbs' => 'nullable',
                'projectMandays' => 'required',
                'projectAmountGross' => 'required',
                'perMondayCost' => 'nullable',
                'projectAmountNet' => 'nullable',
                'poNumber' => 'required',
                'soNumber' => 'required',
                'ftNumber' => 'nullable',
                'specialInstruction' => 'nullable',
                'resellers' => 'nullable',
                'resellers_Contact' => 'nullable',
                'resellerPhoneEmail' => 'nullable',
                'endUser' => 'nullable',
                'endUserContactNumber' => 'nullable',
                'endUserPhoneEmail' => 'nullable',
                'endUserLocation' => 'nullable',
                'status' => 'nullable',
                'email' => 'nullable',
                'pm_email' => 'nullable',
                'created_date' => 'nullable',

                'implementationSupportingDocument' => 'nullable|array',
                'implementationSupportingDocument.*' => 'file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip,rar|max:10240',

               
                'tm_email' => 'required|array',
                'created_dateTM' => 'required|array',
            ]);
     
            $cashAdvance = $request->input('cashAdvance');
            $teamMembers = $request->input('engineers'); // Corrected fetching of team members
            $teamMembersEmailArray = $request->input('tm_email');
            $teamMembersDateAssigned = $request->input('created_dateTM');


            $tbl_project = new tbl_project_list();           

            $tbl_project->project_net = $validatedData['projectAmountNet'];
            $tbl_project->manday_cost = $validatedData['perMondayCost'];
            $tbl_project->proj_code =  $validatedData['projectCode'];
            $tbl_project->proj_startDate = $validatedData['projectPeriodFrom'] ?? null;
            $tbl_project->proj_endDate = $validatedData['projectPeriodTo'] ?? null;
            $tbl_project->proj_name =  $validatedData['projectName'];
            $tbl_project->service_category =  $validatedData['serviceCategory'];
            $tbl_project->created_by = $validatedData['createdBy_Input'];
            $tbl_project->PM = $validatedData['projectManager']?? null;
            $tbl_project->business_unit = $validatedData['businessUnit'] ?? null;
            $tbl_project->product_line = $validatedData['iSupport_product_input'] ?? null;
            $tbl_project->proj_type_id = $validatedData['projectType'] ?? null;
            $tbl_project->original_receipt = $validatedData['or'] ?? null;
            $tbl_project->inv = $validatedData['inv'] ?? null;
            $tbl_project->mbs = $validatedData['mbs'] ?? null;
            $tbl_project->manday = $validatedData['projectMandays'];
            $tbl_project->proj_amount = $validatedData['projectAmountGross'];
            $tbl_project->po_number = $validatedData['poNumber'] ?? null;
            $tbl_project->so_number = $validatedData['soNumber'] ?? null;
            $tbl_project->ft_number = $validatedData['ftNumber'] ?? null;
            $tbl_project->special_instruction = $validatedData['specialInstruction'] ?? null;
            $tbl_project->reseller = $validatedData['resellers'] ?? null;
            $tbl_project->rs_contact = $validatedData['resellers_Contact'] ?? null;
            $tbl_project->rs_email = $validatedData['resellerPhoneEmail'] ?? null;
            $tbl_project->endUser = $validatedData['endUser'] ?? null;
            $tbl_project->eu_contact = $validatedData['endUserContactNumber'] ?? null;
            $tbl_project->eu_email = $validatedData['endUserPhoneEmail'] ?? null;
            $tbl_project->eu_location = $validatedData['endUserLocation'] ?? null;
            $tbl_project->status = $validatedData['status'] ?? null;
            $tbl_project->creator_email = $validatedData['email'] ?? null;
            $tbl_project->pm_email = $projectManagerEmail ?? null;
            $tbl_project->created_date = $validatedData['created_date'] ?? null;


            // dd($request->all());
            $tbl_project->save();

            if ($cashAdvance !== null || $cashAdvance === 0) {
                $cashValue = new tbl_cashAdvance();
                $cashValue->project_id = $tbl_project->id;
                $cashValue->cash_advance = $cashAdvance;

                if ($cashValue->save()) {
                    echo "Record saved successfully!";
                } else {
                    echo "Error: " . $cashValue->getError();
                }
            }

            if (is_array($teamMembers) && is_array($teamMembersEmailArray) && is_array($teamMembersDateAssigned)) {
                for ($i = 0; $i < count($teamMembers); $i++) {
                    $pm_engineer = new tbl_projectMember();
                    $pm_engineer->project_id = $tbl_project->id;
                    $pm_engineer->eng_email = $teamMembersEmailArray[$i] ?? null;
                    $pm_engineer->eng_name = $teamMembers[$i] ?? null;
                    $pm_engineer->date_assigned = $teamMembersDateAssigned[$i] ?? null;
                    $pm_engineer->save();
                }
            }

            $files = $request->file('implementationSupportingDocument');

            if ($files) {
                $destinationPath = public_path('uploads/Isupport-Attachments');
            
                // Ensure the directory exists
                if (!is_dir($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
            
                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $filename = uniqid() . '_' . $file->getClientOriginalName();
            
                        // Move the file to the destination folder
                        $file->move($destinationPath, $filename);
            
                        // Save file information in the database
                        $imageModel = new tbl_proj_attachment;
                        $imageModel->proj_id = $tbl_project->id;
                        $imageModel->attachment = $filename;
                        $imageModel->save();
                    }
                }
            } else {
                $filename = null;
            }
            

            return redirect()->route('tab-isupport-service.implementation.index')->with('success', 'New Project created successfully');
        } catch (ValidationException $e) {
            dd($e->errors());
        }
    }

    public function projectSignOffModal()
    {
        return view('tab-isupport-service.project-sign-off.project-signoff-modal');
    }

    public function editProjectSignoffModal(Request $request)
    {
        $request->validate([
            'reseller_input' => 'required',
            'endUser_input' => 'required',
            'Deliverables_Input' => 'required',
        ]);

        $id = $request->input('project_id');
        try {
            $project_list = tbl_project_list::findOrFail($id);

            $project_signoff = tbl_projectSignOff::where('project_id', $id)->firstOrFail();

            if (
                $project_list->reseller != $request->input('reseller_input') ||
                $project_list->endUser != $request->input('endUser_input') ||
                $project_signoff->deliverables != $request->input('Deliverables_Input')
            ) {

                $project_list->update([
                    'reseller' => $request->input('reseller_input'),
                    'endUser' => $request->input('endUser_input'),
                ]);

                $project_signoff->update([
                    'deliverables' => $request->input('Deliverables_Input'),
                ]);

                return response()->json(['message' => 'Project sign-off updated successfully']);
            } else {

                return response()->json(['message' => 'No changes were made']);
            }
        } catch (ValidationException $e) {

            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {

            return response()->json(['error' => 'An error occurred while updating the project sign-off'], 500);
        }
    }

    public function getTotalMandaysUsed(Request $request)
    {
        $engineers = $request->input('engineers'); // Engineers sent from the frontend
        $projectId = $request->input('projectId'); // Project IDs sent from the frontend
        
        // Initialize total mandays and engineer mandays
        $totalMandaysAll = 0;
        $engineerMandays = [];
        
        // Ensure engineers and projectIds are arrays
        $engineerNames = is_array($engineers) ? $engineers : [$engineers];
        $projectIds = is_array($projectId) ? $projectId : [$projectId];
        
        // Log for debugging
        Log::info('Received Engineers:', $engineerNames);
        Log::info('Received Project IDs:', $projectIds);
        
        // Fetch activity reports for the given project IDs
        $getTotalManday = tbl_activityReport::with('MandayEngr', 'MandaytimeFrom', 'MandaytimeTo')
            ->select('ar_id', 'ar_project', 'ar_timeExited', 'ar_timeReported')
            ->whereIn('ar_project', $projectIds) // Filter by project IDs
            ->get();
        
        // Track unique `ar_id` to avoid re-calculating for the same project
        $processedArIds = [];
        
        foreach ($getTotalManday as $manday) {
            // Skip if this ar_id has already been processed
            if (in_array($manday->ar_id, $processedArIds)) {
                continue;
            }
            
            if (isset($manday->MandaytimeFrom) && isset($manday->MandaytimeTo)) {
                // Calculate the duration in hours and convert to days
                $MandaytimeFrom = strval($manday->MandaytimeFrom->key_timestamp);
                $MandaytimeTo = strval($manday->MandaytimeTo->key_timestamp);
                $durationInHours = (strtotime($MandaytimeTo) - strtotime($MandaytimeFrom)) / (60 * 60);
                $durationInDays = $durationInHours / 8;
                
                // Round duration in days to 2 decimal places before adding it to the total
                $roundedDurationInDays = round($durationInDays, 2);
                
                // Add the project total mandays (multiplied by the number of engineers involved)
                $totalMandaysAll += $roundedDurationInDays * count($engineerNames); // Multiply by the number of engineers involved
                
                // Log the calculated duration for the project
                Log::info("Duration in Days for ar_id {$manday->ar_id}: {$roundedDurationInDays}");
                
                // Loop through all engineers involved with the project
                if (!empty($manday->MandayEngr) && is_iterable($manday->MandayEngr)) {
                    foreach ($manday->MandayEngr as $engineer) {
                        if (isset($engineer->engr_name)) { // Ensure engineer name exists
                            $engineerName = trim($engineer->engr_name);
            
                            // Only process engineers that were requested
                            if (in_array($engineerName, $engineerNames)) {
                                if (!isset($engineerMandays[$engineerName])) {
                                    $engineerMandays[$engineerName] = 0;
                                }
            
                                // Log each engineer's mandays
                                Log::info("Adding {$roundedDurationInDays} days to {$engineerName}");
            
                                // Add mandays for this engineer (same for all engineers with this `ar_id`)
                                $engineerMandays[$engineerName] += $roundedDurationInDays;
                            }
                        }
                    }
                } else {
                    Log::warning("No engineers found for ar_id: " . $manday->ar_id);
                }
            
                // Mark this `ar_id` as processed
                $processedArIds[] = $manday->ar_id;
            }
        }
        
        // Handle engineers without saved time (assign 0 mandays to those without time)
        foreach ($engineerNames as $engineerName) {
            // If an engineer doesn't have any time, set their mandays to 0
            if (!isset($engineerMandays[$engineerName])) {
                $engineerMandays[$engineerName] = 0;
            }
        }
    
        // Exclude engineers with 0 mandays from the total mandays calculation
        $validEngineerMandays = array_filter($engineerMandays, function ($mandays) {
            return $mandays > 0;
        });
        
        // Recalculate total mandays only for engineers with saved time
        $totalMandaysAll = array_sum($validEngineerMandays);
    
        // Log the final result for debugging
        Log::info('Final Total Mandays All (after calculation): ', ['totalMandaysAll' => $totalMandaysAll]);
        
        // Round engineer mandays to 2 decimal places before returning
        foreach ($engineerMandays as $engineer => $mandays) {
            $engineerMandays[$engineer] = round($mandays, 2); // Round each engineer's mandays
        }
        
        // Return the total mandays and individual engineer mandays
        return response()->json([
            'totalMandaysAll' => round($totalMandaysAll, 2), // Return rounded total mandays
            'engineerMandays' => $engineerMandays,           // Individual engineer mandays
        ]);
    }
    
       
    public function getMandayRefNo(Request $request)
    {
        $projectId = $request->input('projectId');
    
        $projectIds = is_array($projectId) ? $projectId : [$projectId];
    
        $getMandayRef = tbl_activityReport::whereIn('ar_project', $projectIds)
            ->get([
                'ar_refNo', 
                'ar_report', 
                'ar_status', 
                'ar_requester', 
                'ar_date_filed', 
                'ar_date_needed', 
                'ar_activity', 
                'ar_instruction', 
                'ar_resellers', 
                'ar_resellers_contact', 
                'ar_resellers_phoneEmail', 
                'ar_endUser', 
                'ar_endUser_contact',
                'ar_endUser_loc', 
                'ar_endUser_phoneEmail', 
                'ar_activityDate', 
                'ar_timeReported', 
                'ar_timeExited', 
                'ar_productLine', 
                'ar_productCode', 
                'ar_timeExpected', 
                'ar_venue', 
                'ar_activityType', 
                'ar_program', 
                'ar_custRequirements', 
                'ar_activityDone',
                'ar_agreements', 
                'ar_targetDate', 
                'ar_details',
                'ar_sendCopyTo',
                'tbl_activityReport.ar_id',
                'ar_project'
            ]); 

            foreach ($getMandayRef as $activityReport) {

                $activityTypeName = tbl_activityType_list::where('type_id', $activityReport->ar_activityType)->value('type_name');
                $activityReport->ar_activityType = $activityTypeName; 
                
                $activityReportName = tbl_report_list::where('report_id', $activityReport->ar_report)->value('report_name');
                $activityReport->ar_report = $activityReportName; 
                
                $activityStatustName = tbl_status_list::where('status_id', $activityReport->ar_status)->value('status_name');
                $activityReport->ar_status = $activityStatustName; 
                
                $programsName = tbl_program_list::where('program_id', $activityReport->ar_program)->value('program_name');
                $activityReport->ar_program = $programsName; 
            

                $times = tbl_time_list::whereIn('key_id', [
                    $activityReport->ar_timeReported, 
                    $activityReport->ar_timeExpected, 
                    $activityReport->ar_timeExited
                ])->pluck('key_time', 'key_id');
            
                $activityReport->ar_timeReported = $times[$activityReport->ar_timeReported] ?? null;
                $activityReport->ar_timeExpected = $times[$activityReport->ar_timeExpected] ?? null;
                $activityReport->ar_timeExited = $times[$activityReport->ar_timeExited] ?? null;
            
                $activityReport->engineers = tbl_engineers::where('engr_ar_id', $activityReport->ar_id)->pluck('engr_name');
                $activityReport->prod_engineers = tbl_prodEngineers::where('prodEngr_ar_id', $activityReport->ar_id)->pluck('prodEngr_name');
                $activityReport->product_line = tbl_productLine::where('ar_id', $activityReport->ar_id)->pluck('ProductLine');
            

                $project = tbl_project_list::where('id', $activityReport->ar_project)
                    ->select('proj_name', 'proj_type_id')
                    ->first();
                
                if ($project) {
                    $activityReport->projectName = $project->proj_name;
            
                    $projectType = tbl_project_type_list::where('id', $project->proj_type_id)->value('name');
                    $activityReport->projectType = $projectType;
                }
            }
            
            
    
        return response()->json($getMandayRef);
    }
    
    


    public function paymentStatus(Request $request)
    {
        $projectId = $request->input('projectId');

        $projectIds = is_array($projectId) ? $projectId : [$projectId];

        $paymentStatus = tbl_payment::whereIn('project_id', $projectIds)
            ->select('payment_status', 'updated_by', 'date') 
            ->get()
            ->map(function ($payment) {
                if (is_numeric($payment->date)) {
                    $payment->date = date('Y-m-d', $payment->date);
                } else {
                    $payment->date = null;
                }
                return $payment;
            });

        return response()->json($paymentStatus);
    }


    /////////////////////////////////////////////////// Save Edit Project ////////////////////////////////////////////////

    public function saveEditProject(Request $request)
    {
        try {
            $StoreData = json_decode($request->input('projectdata'), true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON data');
            }

            $Project_id = $StoreData['projectId'];

            if (!$Project_id) {
                throw new \Exception('Project ID is missing');
            }

            $ProjectSave = tbl_project_list::find($Project_id);

            if (!$ProjectSave) {
                throw new \Exception('Project not found');
            }

            $ProjectSave->proj_code = $StoreData['projectCode'];
            $ProjectSave->proj_startDate = $StoreData['projectPeriodFrom'];
            $ProjectSave->proj_endDate = $StoreData['projectPeriodTo'];
            $ProjectSave->proj_name = $StoreData['projectName'];
            $ProjectSave->service_category = $StoreData['serviceCategory'];
            $ProjectSave->created_by = $StoreData['createdBy'];
            $ProjectSave->PM = $StoreData['projectManager'];
            $ProjectSave->business_unit = $StoreData['businessUnit'];
            $ProjectSave->business_unit_id = $StoreData['projectId'];
            $ProjectSave->product_line = $StoreData['productLine'];
            $ProjectSave->proj_type_id = $StoreData['projectType'];
            $ProjectSave->original_receipt = $StoreData['or'];
            $ProjectSave->inv = $StoreData['inv'];
            $ProjectSave->mbs = $StoreData['mbs'];
            $ProjectSave->manday = $StoreData['projectMandays'];
            $ProjectSave->proj_amount = $StoreData['projectAmountGross'];
            $ProjectSave->manday_cost = $StoreData['perMondayCost'];
            $ProjectSave->project_net = $StoreData['projectAmountNet'];
            $ProjectSave->po_number = $StoreData['poNumber'];
            $ProjectSave->so_number = $StoreData['soNumber'];
            $ProjectSave->ft_number = $StoreData['ftNumber'];
            $ProjectSave->special_instruction = $StoreData['specialInstruction'];
            $ProjectSave->reseller = $StoreData['resellers'];
            $ProjectSave->rs_contact = $StoreData['resellers_Contact'];
            $ProjectSave->rs_email = $StoreData['resellerPhoneEmail'];
            $ProjectSave->endUser = $StoreData['endUser'];
            $ProjectSave->eu_contact = $StoreData['endUserContactNumber'];
            $ProjectSave->eu_email = $StoreData['endUserPhoneEmail'];
            $ProjectSave->eu_location = $StoreData['endUserLocation'];
            $ProjectSave->status = $StoreData['status'] ?? null;
            $ProjectSave->creator_email = $StoreData['email'] ?? null;
            $ProjectSave->pm_email = $StoreData['pm_email'] ?? null;
            $ProjectSave->created_date = $StoreData['created_date'] ?? null;
            $ProjectSave->status = $StoreData['projectListStatus'];

            $ProjectSave->save();

            $projectDate = $ProjectSave->created_Date;

            $cashAdvanceValue = is_numeric($StoreData['cashAdvance']) 
            ? (float)$StoreData['cashAdvance'] 
            : 0.0; 
            
            $cashadvance = tbl_cashAdvance::firstOrNew(['project_id' => $Project_id]);
            $cashadvance->project_id = $Project_id;
            $cashadvance->cash_advance = $cashAdvanceValue;
            $cashadvance->save();
        
            
            Log::info('Cash Advance Value:', ['cashAdvance' => $StoreData['cashAdvance']]);


            $businessUnit = tbl_business_unit::firstOrNew(['id' => $Project_id]);
            $businessUnit->id = $Project_id;
            $businessUnit->business_unit = $StoreData['businessUnit'];
            $businessUnit->save();

            $refDate = isset($StoreData['ref_date']) && strtotime($StoreData['ref_date']) !== false ? strtotime($StoreData['ref_date']) : null;

            // Check if both payment_status and date are null before saving
            if (($StoreData['payment_stat'] !== null && $StoreData['payment_stat'] !== '') || $refDate !== null) {
                $paymentStatus = new tbl_payment();
                $paymentStatus->payment_status = $StoreData['payment_stat'] ?? null;
                $paymentStatus->date = $refDate ?? time();
                $paymentStatus->project_id = $Project_id;
                $paymentStatus->updated_by = Auth::user()->name;
                $paymentStatus->save();
            }
                 

            $Engineers = $StoreData['engineers'] ?? []; // Default to an empty array if not provided

            if (empty($Engineers)) {
                // Remove all engineers if none are selected
                tbl_projectMember::where('project_id', $Project_id)->delete();
            } else {
                // Fetch existing project members
                $existingEngineers = tbl_projectMember::where('project_id', $Project_id)->pluck('eng_name')->toArray();
            
                // Determine engineers to remove and add
                $engineersToRemove = array_diff($existingEngineers, $Engineers);
                $engineersToAdd = array_diff($Engineers, $existingEngineers);
            
                // Remove engineers no longer in the list
                if (!empty($engineersToRemove)) {
                    tbl_projectMember::where('project_id', $Project_id)
                        ->whereIn('eng_name', $engineersToRemove)
                        ->delete();
                }
            
                // Fetch engineers from LDAP (assuming this returns full details)
                $ldapEngineers = LDAPEngineer::fetchFromLDAP();
            
                // Add new engineers
                foreach ($engineersToAdd as $engineerName) {
                    foreach ($ldapEngineers as $ldapEngineer) {
                        if ($ldapEngineer->fullName === trim($engineerName)) {
                            tbl_projectMember::create([
                                'eng_name' => $ldapEngineer->fullName,
                                'eng_email' => $ldapEngineer->email,
                                'project_id' => $Project_id,
                                'date_assigned' => $projectDate,
                            ]);
                        }
                    }
                }
            }
            
            


            return response()->json(['success' => true]);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function IsupportAttachment(Request $request)
    {
        $files = $request->file('files');
        $project_id = $request->input('project_id');
    
        if ($files && count($files) > 0) {
            foreach ($files as $file) {
                // Generate a unique filename
                $filename = uniqid() . '_' . $file->getClientOriginalName();
    
                // Specify the destination path
                $destinationPath = public_path('uploads/Isupport-Attachments');
    
                // Move the uploaded file to the destination path
                $file->move($destinationPath, $filename);
    
                // Save the file path to the database
                $imageModel = new tbl_proj_attachment();
                $imageModel->proj_id = $project_id;
                $imageModel->attachment = $filename;
                $imageModel->save();
            }
    
            // Retrieve all files associated with the project from the database
            $allFiles = tbl_proj_attachment::where('proj_id', $project_id)
                ->pluck('attachment')
                ->toArray();
    
            // Return success message with all files
            return response()->json([
                'message' => 'Files saved successfully',
                'files' => $allFiles
            ], 200);
        } else {
            Log::error("Error in Saving Files");
            return response()->json(['error' => 'Error while uploading files'], 400);
        }
    }
    public function deleteAttachment(Request $request)
    {
        $fileName = $request->input('file_name');
        $filePath = public_path('uploads/Isupport-Attachments/' . $fileName);
    
        try {
            // Delete the record from the database
            $deleted = DB::table('tbl_proj_attachment')
                ->where('attachment', $fileName)
                ->delete();
    
            // Attempt to delete the file, but don't fail if it doesn't exist
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file from the filesystem
            }
    
            // Respond with success regardless of file existence
            if ($deleted) {
                return response()->json(['message' => 'File deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Database record not found, but file check completed'], 200);
            }
        } catch (\Exception $e) {
            // Catch any unexpected errors
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }       

    public function signOfftAttachment(Request $request)
    {
        $files = $request->file('files');
        $project_id = $request->input('project_id');
    
        if ($files && count($files) > 0) {
            foreach ($files as $file) {
                // Generate a unique filename
                $filename = uniqid() . '_' . $file->getClientOriginalName();
    
                // Specify the destination path
                $destinationPath = public_path('uploads/Sign-off-Attachments');
    
                // Move the uploaded file to the destination path
                $file->move($destinationPath, $filename);
    
                // Save the file path to the database
                $imageModel = new tbl_project_signoff_attachment();
                $imageModel->project_id = $project_id;
                $imageModel->attachment = $filename;
                $imageModel->save();
            }
    
            // Return success message
            return response()->json(['message' => 'Files saved successfully'], 200);
        } else {
            Log::error("Error in Saving Files");
            return response()->json(['error' => 'Error while uploading files'], 400);
        }
    }

    public function updateProjectStatus(Request $request)
    {
        // Validate the request
        $request->validate([
            'project_id' => 'required|exists:tbl_project_list,id', // Make sure the table name matches your database
            'status' => 'required|string'
        ]);
    
        // Find the project by ID
        $project = tbl_project_list::find($request->input('project_id'));
    
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
    
        // Update the project status
        $project->status = $request->input('status');
        $project->save();
    
        return response()->json(['message' => 'Project status updated successfully']);
    }

     public function CashRequestAttachment(Request $request)
    {
        $files = $request->file('files');
        $project_id = $request->input('project_id');
    
        if ($files && count($files) > 0) {
            foreach ($files as $file) {
                // Generate a unique filename
                $filename = uniqid() . '_' . $file->getClientOriginalName();
    
                // Specify the destination path
                $destinationPath = public_path('uploads/Cash-Advance-Request-Attachment');
    
                // Move the uploaded file to the destination path
                $file->move($destinationPath, $filename);
    
                // Save the file path to the database
                $imageModel = new tbl_cash_advance_attachments();
                $imageModel->proj_id = $project_id;
                $imageModel->attachment_file = $filename;
                $imageModel->save();
            }
    
            // Retrieve all files associated with the project from the database
            $allFiles = tbl_cash_advance_attachments::where('proj_id', $project_id)
                ->pluck('attachment_file')
                ->toArray();
    
            // Return success message with all files
            return response()->json([
                'message' => 'Files saved successfully',
                'files' => $allFiles
            ], 200);
        } else {
            Log::error("Error in Saving Files");
            return response()->json(['error' => 'Error while uploading files'], 400);
        }
    }

    public function deleteCashAdvanceAttachment(Request $request)
    {
        $fileName = $request->input('file_name');
        $filePath = public_path('uploads/Cash-Advance-Request-Attachment/' . $fileName);
    
        try {
            // Delete the record from the database
            $deleted = DB::table('tbl_cash_advance_attachments')
                ->where('attachment_file', $fileName)
                ->delete();
    
            // Attempt to delete the file, but don't fail if it doesn't exist
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file from the filesystem
            }
    
            // Respond with success regardless of file existence
            if ($deleted) {
                return response()->json(['message' => 'File deleted successfully'], 200);
            } else {
                return response()->json(['message' => 'Database record not found, but file check completed'], 200);
            }
        } catch (\Exception $e) {
            // Catch any unexpected errors
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }       
    
    
}
