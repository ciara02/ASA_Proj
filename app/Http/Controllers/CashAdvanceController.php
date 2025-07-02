<?php

namespace App\Http\Controllers;

use App\Mail\CashAdvanceRequestApproved;
use App\Mail\CashAdvanceRequestDisapproved;
use App\Mail\CashAdvanceRequestEmail;
use App\Models\LDAPEngineer;
use App\Models\tbl_accomodation;
use App\Models\tbl_cash_advance_request;
use App\Models\tbl_misc_fee;
use App\Models\tbl_per_diem;
use App\Models\tbl_project_list;
use App\Models\tbl_transportation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CashAdvanceController extends Controller
{
    public function showRequestForm(Request $request)
    {
        $encoded = $request->query('projectID'); // or 'id'
        $projectID = base64_decode($encoded);

        $projectInfo = tbl_project_list::with('cashAdvance', 'financial_status', 'cashRequest_status')
            ->where('id', $projectID)
            ->first(); // since you're expecting only one project
        
         if (!$projectInfo) {
                abort(404, 'Project not found');
            }

        $latestCashStatus = $projectInfo->cashRequest_status
        ? $projectInfo->cashRequest_status->sortByDesc('group')->first()
        : null;

    if (optional($latestCashStatus)->status === 'For Approval') {
        return view('tab-isupport-service.cash-advance-request.already_requested', compact('projectInfo'));
    }

           
    $ldapUsername = Auth::user()->email;

    // Transform the email to match LDAP format (if needed)
    $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));

    $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);
  if (!$ldapEngineer) {
        Log::info('Setting default values for LDAP user.');
        $ldapEngineer = (object) ['email' => ''];
    }

    return view('tab-isupport-service.cash-advance-request.index' , compact('projectInfo','ldapEngineer')); // assumes you have resources/views/cashadvance/request.blade.php
}

public function approvalRequestView($hash)
{
    $record = tbl_cash_advance_request::where('hash', $hash)->firstOrFail();

    $record->load([
        'per_diem' => function ($query) use ($hash) {
            $query->where('hash', $hash);
        },
        'transportation' => function ($query) use ($hash) {
            $query->where('hash', $hash);
        },
        'accommodation' => function ($query) use ($hash) {
            $query->where('hash', $hash);
        },
        'miscFee' => function ($query) use ($hash) {
            $query->where('hash', $hash);
        },
    ]);

    $approvalRequestViewUrl = route('cash-advance.request.view', ['hash' => $record->hash]);
    $approveUrl = route('cash-advance.request.approve', ['hash' => $record->hash]);
    $disapproveUrl = route('cash-advance.request.disapprove', ['hash' => $record->hash]);

    return view('tab-isupport-service.cash-advance-request.approvalRequest', compact(
        'record', 'approvalRequestViewUrl', 'approveUrl', 'disapproveUrl'
    ));
}

public function approve(Request $request, $hash)
{
    // Update record in DB
    tbl_cash_advance_request::where('hash', $hash)->update([
        'status' => 'Approved',
        'approver_email' => Auth::user()->email ?? 'Unknown User',
        'approver_name' => Auth::user()->name ?? 'Unknown User',
    ]);

    // Reload updated record
    $record = tbl_cash_advance_request::where('hash', $hash)->firstOrFail();

    // Load relations
    $record->load([
        'per_diem' => fn ($query) => $query->where('hash', $hash),
        'transportation' => fn ($query) => $query->where('hash', $hash),
        'accommodation' => fn ($query) => $query->where('hash', $hash),
        'miscFee' => fn ($query) => $query->where('hash', $hash),
    ]);

    $requestUrl = [
        'approvalRequestView'=> route('cash-advance.request.view', ['hash' => $record->hash]),
        'approve' => route('cash-advance.request.approve', ['hash' => $record->hash]),
        'disapprove' => route('cash-advance.request.disapprove', ['hash' => $record->hash]),
    ];

    $recipients = [
        'requester' => $record->requester_email,
        'approver' => $record->approver_email,
    ];

    foreach ($recipients as $role => $email) {
        if ($email) {
            $cacheKey = "last_email_sent_{$role}_" . $record->id;
            $lastEmailSent = Cache::get($cacheKey);

            if (!$lastEmailSent || now()->diffInSeconds($lastEmailSent) >= 3) {
                Mail::to($email)->send(new CashAdvanceRequestApproved($record, $requestUrl, $role));
                Cache::put($cacheKey, now(), now()->addSeconds(3));
            } else {
                Log::info("Email throttled — recently sent to {$role}.");
            }
        }
    }

    return view('tab-isupport-service.cash-advance-request.approvalRequest', [
        'record' => $record,
        'approvalRequestViewUrl' => $requestUrl['approvalRequestView'],
        'approveUrl' => $requestUrl['approve'],
        'disapproveUrl' => $requestUrl['disapprove'],
    ]);
}

public function disapprove(Request $request, $hash)
{
    tbl_cash_advance_request::where('hash', $hash)->update([
        'status' => 'Disapproved',
        'approver_email' => Auth::user()->email ?? 'Unknown User',
        'approver_name' => Auth::user()->name ?? 'Unknown User',
    ]);

    $record = tbl_cash_advance_request::where('hash', $hash)->firstOrFail();

    $record->load([
        'per_diem' => function ($query) use ($hash) {
            $query->where('hash', $hash);
        },
        'transportation' => function ($query) use ($hash) {
            $query->where('hash', $hash);
        },
        'accommodation' => function ($query) use ($hash) {
            $query->where('hash', $hash);
        },
        'miscFee' => function ($query) use ($hash) {
            $query->where('hash', $hash);
        },
    ]);


    if (!$record) {
        abort(404, 'Cash advance request not found');
    }


    $requestUrl = [
        'approvalRequestView' => route('cash-advance.request.view', ['hash' => $record->hash]),
        'approve' => route('cash-advance.request.approve', ['hash' => $record->hash]),
        'disapprove' => route('cash-advance.request.disapprove', ['hash' => $record->hash]),
    ];

    $lastEmailSent = Cache::get('last_email_sent_' . $record->id);
        
    $recipients = [
        'requester' => $record->requester_email,
        'approver' => $record->approver_email,
    ];

    foreach ($recipients as $role => $email) {
        if ($email) {
            $cacheKey = "last_email_sent_disapproved_{$role}_" . $record->id;
            $lastEmailSent = Cache::get($cacheKey);

            if (!$lastEmailSent || now()->diffInSeconds($lastEmailSent) >= 3) {
                Mail::to($email)->send(new CashAdvanceRequestDisapproved($record, $role));

                Cache::put($cacheKey, now(), now()->addSeconds(3));
            } else {
                Log::info("Disapproval email throttled — recently sent to {$role}.");
            }
        }
    }

    return view('tab-isupport-service.cash-advance-request.approvalRequest', [
            'record' => $record,
            'approvalRequestViewUrl' => $requestUrl['approvalRequestView'],
            'approveUrl' => $requestUrl['approve'],
            'disapproveUrl' => $requestUrl['disapprove'],
        ]);
    }

public function saveData(Request $request)
{
    $projectID = $request->input('projectID');
    $sharedHash = Str::uuid(); 

    $validated = $request->validate([
        'projectName' => 'nullable|string',
        'status' => 'nullable|string|max:255',
        'requestedby_approval' => 'nullable|string|max:255',   
        'requestedby_email' => 'nullable|string|max:255',
        'fileddate_approval' => 'nullable|date|max:255',
        'PersonImplement_approval' => 'nullable|string|max:255',
        'Reseller_approval' => 'nullable|string|max:255',
        'Project_approval' => 'nullable|string|max:255',
        'Contact_approval' => 'nullable|string|max:255',
        'Location_approval' => 'nullable|string|max:255',
        'Emailaddress_approval' => 'nullable|string|max:255',
        'Datestart_approval' => 'nullable|date|max:255',
        'Enduser_approval' => 'nullable|string|max:255',
        'Dateend_approval' => 'nullable|date|max:255',
        'ContactPerson_approval' => 'nullable|string|max:255',
        'Mandays_approval' => 'nullable|string|max:255',
        'Emailaddress2_approval' => 'nullable|string|max:255',
        'Costmanday_approval' => 'nullable|string|max:255',
        'Address_approval' => 'nullable|string|max:255',
        'ProjectCost_approval' => 'nullable|string|max:255',
        'PONumber_approval' => 'nullable|string|max:255',
        'SONumber_approval' => 'nullable|string|max:255',
        'Expenses_approval' => 'nullable|numeric',
        'PaymentStatus_approval' => 'nullable|string|max:255',
        'Margin_approval' => 'nullable|numeric',
        'margin' => 'nullable|boolean',
        'parkedFunds' => 'nullable|boolean',
        'others' => 'nullable|boolean',
        'charged_others' => 'nullable|string|max:255',
        'division1' => 'nullable|string|max:255',
        'division2' => 'nullable|string|max:255',
        'prodLine_approval' => 'nullable|string|max:255',
        'DigiOne' => 'nullable|boolean',
        'MarketingEvent' => 'nullable|boolean',
        'Travel' => 'nullable|boolean',
        'Training' => 'nullable|boolean',
        'Promos' => 'nullable|boolean',
        'Advertising' => 'nullable|boolean',
        'Freight' => 'nullable|boolean',
        'Representation' => 'nullable|boolean',
        'expenses_Others' => 'nullable|boolean',
        'expenses_others_input' => 'nullable|string|max:255',
        'grandTotal' => 'nullable|numeric',
        'projRefID' => 'nullable|numeric',

        'perdiem' => 'nullable',
        'transpo' => 'nullable',
        'accommodation' => 'nullable',
        'miscFee' => 'nullable',
        
    ]);
    $projectRefID = $validated['projRefID'] ?? null;

    try {
        $maxCashAdvanceNumber = tbl_cash_advance_request::where('proj_id', $projectID)->max('group');
        $newCashAdvanceNumber = $maxCashAdvanceNumber ? $maxCashAdvanceNumber + 1 : 1;
        $data = new tbl_cash_advance_request();
        $data->proj_id = $projectID;
        $data->status = 'For Approval';
        $data->project_type = $validated['projectName'] ?? null;
        $data->requested_by = $validated['requestedby_approval'] ?? null;
        $data->requester_email = $validated['requestedby_email'] ?? null;
        $data->date_filed = $validated['fileddate_approval'] ?? null;
        $data->person_implementing = $validated['PersonImplement_approval'] ?? null;
        $data->reseller_name = $validated['Reseller_approval'] ?? null;
        $data->proj_name = $validated['Project_approval'] ?? null;
        $data->reseller_contact = $validated['Contact_approval'] ?? null;
        $data->reseller_location = $validated['Location_approval'] ?? null;
        $data->reseller_email = $validated['Emailaddress_approval'] ?? null;
        $data->date_start = $validated['Datestart_approval'] ?? null;
        $data->enduser_name = $validated['Enduser_approval'] ?? null;
        $data->date_end = $validated['Dateend_approval'] ?? null;
        $data->enduser_contact = $validated['ContactPerson_approval'] ?? null;
        $data->enduser_location = $validated['Address_approval'] ?? null;
        $data->mandays = $validated['Mandays_approval'] ?? null;
        $data->enduser_email = $validated['Emailaddress2_approval'] ?? null;
        $data->cost_manday = $validated['Costmanday_approval'] ?? null;
        $data->proj_cost = $validated['ProjectCost_approval'] ?? null;
        $data->po_number = $validated['PONumber_approval'] ?? null;
        $data->so_number = $validated['SONumber_approval'] ?? null;
        $data->expenses = $validated['Expenses_approval'] ?? null;
        $data->payment_status = $validated['PaymentStatus_approval'] ?? null;
        $data->margin = $validated['Margin_approval'] ?? null;
        $data->charged_to_margin = $validated['margin'] ?? null;
        $data->charged_to_parked_funds = $validated['parkedFunds'] ?? null;
        $data->charged_to_others = $validated['others'] ?? null;
        $data->charged_others_input = $validated['charged_others'] ?? null;
        $data->division = $validated['division1'] ?? null;
        $data->division2 = $validated['division2'] ?? null;
        $data->prod_line = $validated['prodLine_approval'] ?? null;
        $data->expense_DigiOne = $validated['DigiOne'] ?? null;
        $data->expense_marketingEvent = $validated['MarketingEvent'] ?? null;
        $data->expense_travel = $validated['Travel'] ?? null;
        $data->expense_training = $validated['Training'] ?? null;
        $data->expense_promos = $validated['Promos'] ?? null;
        $data->expense_advertising = $validated['Advertising'] ?? null;
        $data->expense_freight = $validated['Freight'] ?? null;
        $data->expense_representation = $validated['Representation'] ?? null;
        $data->expense_others = $validated['expenses_Others'] ?? null;
        $data->expense_others_input = $validated['expenses_others_input'] ?? null;
        $data->grand_total = $validated['grandTotal'] ?? null;
        $data->proj_ref_id = $validated['projRefID'] ?? null;
        $data->group = $newCashAdvanceNumber;
        
        $data->hash = $sharedHash;
        $data->save();


        if ($request->has('perdiem')) {
        
            foreach ($request->input('perdiem') as $item) {
                Log::info('Saving perdiem item', [
                    'item' => $item,
                    'projectID' => $projectID
                ]);
        
                $perdiem = new tbl_per_diem(); 
                $perdiem->perDiem_id = $projectID; 
                $perdiem->perDiem_currency = $item['currency'] ?? null;
                $perdiem->perDiem_rate = $item['rate'] ?? null;
                $perdiem->perDiem_days = $item['days'] ?? null;
                $perdiem->perDiem_pax = $item['pax'] ?? null;
                $perdiem->perDiem_total = $item['total'] ?? null;
                $perdiem->group = $newCashAdvanceNumber;
                $perdiem->proj_ref_id = $projectID;
                $perdiem->hash = $sharedHash;
                $perdiem->save();
            }
        }

            // For Transportation
            if ($request->has('transpo')) {
                // Get the latest number ONCE for the whole batch
            
                foreach ($request->input('transpo') as $item) {
                    $transpo = new tbl_transportation(); 
                    $transpo->transpo_id = $projectID; 
                    $transpo->transpo_date = $item['date'] ?? null;
                    $transpo->transpo_description = $item['itemDesc'] ?? null;
                    $transpo->transpo_from = $item['from'] ?? null;
                    $transpo->transpo_to = $item['to'] ?? null;
                    $transpo->transpo_amount = $item['amount'] ?? null;
                    $transpo->transpo_total = $item['total'] ?? null;
                    $transpo->proj_ref_id = $projectID;
                    $transpo->group = $newCashAdvanceNumber; // Same number for all in this batch
                    $transpo->hash = $sharedHash;
                    $transpo->save();
                }
            }
            

            // For Accommodation
            if ($request->has('accommodation')) {
            
                foreach ($request->input('accommodation') as $item) {
                    $acc = new tbl_accomodation();
                    $acc->accomodation_id = $projectID; 
                    $acc->accom_hotel = $item['hotel'] ?? null;
                    $acc->accom_rate = $item['rate'] ?? null;
                    $acc->accom_rooms = $item['rooms'] ?? null;
                    $acc->accom_nights = $item['nights'] ?? null;
                    $acc->accom_amount = $item['amount'] ?? null;
                    $acc->accom_total = $item['total'] ?? null;
                    $acc->proj_ref_id = $projectID;
                    $acc->group = $newCashAdvanceNumber;
                    $acc->hash = $sharedHash;
                    $acc->save();
                }
            }

            // For Misc Fee
            if ($request->has('miscFee')) {
            
                foreach ($request->input('miscFee') as $item) {
                    $misc = new tbl_misc_fee();
                    $misc->misc_id = $projectID; 
                    $misc->misc_particulars = $item['particular'] ?? null;
                    $misc->misc_pax = $item['pax'] ?? null;
                    $misc->misc_amount = $item['amount'] ?? null;
                    $misc->misc_total = $item['total'] ?? null;
                    $misc->proj_ref_id = $projectID;
                    $misc->group = $newCashAdvanceNumber;
                    $misc->hash = $sharedHash;
                    $misc->save();
                }
            }
            
          $record = tbl_cash_advance_request::where('hash', $sharedHash)
            ->with([
                'per_diem' => fn ($query) => $query->where('hash', $sharedHash)->orderBy('created_at'),
                'transportation' => fn ($query) => $query->where('hash', $sharedHash)->orderBy('created_at'),
                'accommodation' => fn ($query) => $query->where('hash', $sharedHash)->orderBy('created_at'),
                'miscFee' => fn ($query) => $query->where('hash', $sharedHash)->orderBy('created_at'),
            ])
            ->firstOrFail();

        $requestUrl = [
            'approvalRequestView'=> route('cash-advance.request.view', ['hash' => $record->hash]),
            'approve' => route('cash-advance.request.approve', ['hash' => $record->hash]),
            'disapprove' => route('cash-advance.request.disapprove', ['hash' => $record->hash]),
        ];

        $lastEmailSent = Cache::get('last_email_sent_' . $record->id);
        
        if (!$lastEmailSent || now()->diffInSeconds($lastEmailSent) >= 3) {
            // Mail::to('ciara_dymosco@msi-ecs.com.ph')
              Mail::to([
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
                'jay_ballesteros@msi-ecs.com.ph'])
                ->send(new CashAdvanceRequestEmail($record, $requestUrl));
        
            Cache::put('last_email_sent_' . $record->id, now(), 3);
        } else {
            Log::info("Email throttled — recently sent.");
        }        
        
        // Respond with success message
        return response()->json(['message' => 'Saved successfully!'], 200);
    } catch (\Exception $e) {
        // Log the detailed error for debugging purposes
        Log::error('Error saving cash advance: ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString()
        ]);
        
        // Send a failure response with the error message (you can include the message in development, but keep it generic in production)
        return response()->json([
            'message' => 'Failed to save data',
            'error' => env('APP_DEBUG') ? $e->getMessage() : 'Something went wrong, please try again later.'
        ], 500);
    }
    }

        public function getApprovedCashReq($projectId)
    {
        $approvedAmount = tbl_cash_advance_request::where('proj_id', $projectId)
            ->where('status', 'Approved')
            ->sum('expenses');

        return response()->json(['approved_total' => $approvedAmount]);
    }


        public function print($hash)
    {
        $record = tbl_cash_advance_request::where('hash', $hash)->firstOrFail();

        $record->load([
            'per_diem' => fn($query) => $query->where('hash', $hash),
            'transportation' => fn($query) => $query->where('hash', $hash),
            'accommodation' => fn($query) => $query->where('hash', $hash),
            'miscFee' => fn($query) => $query->where('hash', $hash),
        ]);

        return view('tab-isupport-service.cash-advance-request.print', compact('record'));
    }  
      public function getCashRefNo(Request $request)
    {
        $projectId = $request->input('projectId');
        $projectIds = is_array($projectId) ? $projectId : [$projectId];

        $userEmail = Auth::user()->email;

        $allowedEmails = $this->getAllowedEmails();

        if (in_array($userEmail, $allowedEmails)) {
            $getCashRefNo = tbl_cash_advance_request::whereIn('proj_id', $projectIds)
                ->orderBy('group', 'desc')
                ->get(['proj_ref_id', 'hash']);
        } else {
            $getCashRefNo = tbl_cash_advance_request::whereIn('proj_id', $projectIds)
                ->where('requester_email', $userEmail)
                ->orderBy('group', 'desc')
                ->get(['proj_ref_id', 'hash']);
        }

        $data = $getCashRefNo->map(function ($record) {
            return [
                'proj_ref_id' => $record->proj_ref_id,
                'hash_link' => route('cash-advance.request.view', ['hash' => $record->hash]),
            ];
        });

        return response()->json($data);
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
}

