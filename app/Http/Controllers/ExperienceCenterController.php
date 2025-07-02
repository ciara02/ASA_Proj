<?php

namespace App\Http\Controllers;

use App\Models\LDAPEngineer;
use Illuminate\Http\Request;
use App\Models\tbl_activityReport;
use App\Services\ProductLineQuery;
use App\Models\tbl_engineers;
use App\Models\tbl_time_list;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExperienceCenterController extends Controller
{
    public function dashboard()
    {
        $experience = tbl_activityReport::getDashboardData();
        $ldapUsername = Auth::user()->email;
    
        // Transform the email to match LDAP format (adjust this transformation based on your requirement)
        $ldapUsername = strtolower(substr($ldapUsername, 0, strpos($ldapUsername, '@')));
    
        // Log the transformed email to ensure it's correct
        Log::info('Transformed email for LDAP search: ' . $ldapUsername);
    
        // Fetch the LDAP user data for the currently logged-in user
        $ldapEngineer = LDAPEngineer::fetchUserFromLDAP($ldapUsername);

        return view('tab-experience-center.experience-center', compact('experience', 'ldapEngineer'));
    }

    public function participantsName(Request $request)
    {
        $refNo = $request->refNo;


        $getPositionName = tbl_activityReport::with('manyparticipants_ExpCenter')
            ->where('ar_refNo', 'like', '%' . ($refNo) . '%')
            ->get();

        $resultArray = [];

        foreach ($getPositionName as $participantData) {
            $participantsData = [
                'participant' => $participantData->manyparticipants_ExpCenter->pluck('participant'),
                'position' => $participantData->manyparticipants_ExpCenter->pluck('position')
            ];
            $resultArray[] = $participantsData;
        }
        return response()->json($resultArray);
    }

    public function actionPlanRecommendation(Request $request)
    {
        $refNo = $request->refNo;
    
        $getactionPlan = tbl_activityReport::with('manyactionPlan_ExpCenter')
            ->where('ar_refNo', 'like', '%' . ($refNo) . '%')
            ->get();
    
        $actionPlanArray = [];
    
        foreach ($getactionPlan as $activityReport) {
            $actionPlans =  [
                    'targetDate' => $activityReport->manyactionPlan_ExpCenter->pluck('PlanTargetDate'),
                    'planDetails' => $activityReport->manyactionPlan_ExpCenter->pluck('PlanDetails'),
                    'planOwner' => $activityReport->manyactionPlan_ExpCenter->pluck('PlanOwner')
                ];
    
            $actionPlanArray[] = $actionPlans;
        }
    
        return response()->json($actionPlanArray);
    }

    public function getProductline(Request $request)
    {
        $term = $request->input('term');

        // Assuming `ProductLineQuery` class has a method to retrieve product lines
        $productLineQuery = new ProductLineQuery();
        $productLines = $productLineQuery->searchProductLines($term); // Assuming you have a method like this
    
        return response()->json(['data' => $productLines]);
    }
   
}
