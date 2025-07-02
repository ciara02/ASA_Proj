<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\LDAPEngineer;
use Illuminate\Support\Facades\Cache;

class LDAPController extends Controller
{
    public function LDAP_Engr(Request $request)
    {
        // Retrieve the search term from the request
        $searchTerm = $request->input('search', '');
    
        // Define a unique cache key based on the search term
        $cacheKey = 'ldap_engineer_search_' . md5($searchTerm);
    
        // Check if the search results are cached
        if (Cache::has($cacheKey)) {
            // Return cached results
            return response()->json(Cache::get($cacheKey));
        }
    
        // Define the filter for LDAP search
        $filter = $searchTerm ? '(fullName=*' . $searchTerm . '*)' : '(mail=*)'; // Adjust the filter based on your needs
    
        // Fetch users from LDAP
        $adUsers = LDAPEngineer::fetchFromLDAP($filter);
    
        // Filter the users based on the search term if it is provided
        if (!empty($searchTerm)) {
            $adUsers = array_filter($adUsers, function ($user) use ($searchTerm) {
                // Modify the condition based on how you want to search (e.g., starts with, contains)
                return stripos($user->fullName, $searchTerm) !== false; // Case-insensitive search
            });
        }
    
        // Convert LDAPUser instances to the associative array format expected by your frontend
        $response = array_map(function ($user) {
            return [
                'engineer' => $user->fullName,
                'email' => $user->email,
            ];
        }, $adUsers);
    
        // Cache the search results for a specific duration (20 minutes)
        Cache::put($cacheKey, $response, 20 * 60);
    
        // Return the response
        return response()->json($response);
    }
    



    public function LDAP_Supervisor(Request $request)
    {
        // Retrieve the search term from the request
        $searchTerm = $request->input('search', '');

        // Define a unique cache key based on the search term
        $cacheKey = 'ldap_supervisor_search_' . md5($searchTerm);

        // Check if the search results are cached
        if (Cache::has($cacheKey)) {
            // Return cached results
            return response()->json(Cache::get($cacheKey));
        }

        // Fetch users from LDAP
        $adUsers = LDAPEngineer::SupervisorLDAP();

        // Filter the users based on the search term if it is provided
        if (!empty($searchTerm)) {
            $adUsers = array_filter($adUsers, function ($user) use ($searchTerm) {
                // Modify the condition based on how you want to search (e.g., starts with, contains)
                return stripos($user->fullName, $searchTerm) !== false; // Case-insensitive search
            });
        }

        // Convert LDAPUser instances to the associative array format expected by your frontend
        $response = array_map(function ($user) {
            return [
                'engineer' => $user->fullName,
                'email' => $user->email,
            ];
        }, $adUsers);

        // Cache the search results for a specific duration
        Cache::put($cacheKey, $response, 20 * 60);


        return response()->json($response);
    }

    public function getLoggedInUser(Request $request)
    {
        // Simulate retrieving Azure AD claims (e.g., email from token or session)
        $azureUser = $request->user(); // Assuming the user is authenticated via Azure AD
    
        if (!$azureUser) {
            Log::warning('Authentication failed: Azure user not available.');
            return response()->json(['error' => 'User not authenticated'], 401);
        }
    
        $userEmail = $azureUser->email ?? null;
    
        if (!$userEmail) {
            Log::warning('No email found for the authenticated Azure user.');
            return response()->json(['error' => 'Email not available'], 400);
        }
    
        // Log the original Azure email
        Log::info("Azure email retrieved: {$userEmail}");
    
        // Transform the Azure email to match LDAP formatting
        $transformedEmail = $this->transformEmailToLDAP($userEmail);
    
        // Log the transformed email
        Log::info("Transformed email for LDAP search: {$transformedEmail}");
    
        // Search LDAP for the transformed email
        $ldapUsers = LDAPEngineer::searchByEmail($transformedEmail);
    
        // Log all LDAP results to see if there are multiple matches
        if ($ldapUsers && count($ldapUsers) > 1) {
            Log::info('Multiple LDAP users found:');
            foreach ($ldapUsers as $user) {
                Log::info("LDAP User: {$user->fullName}, Email: {$user->email}");
            }
        }
    
        if (!$ldapUsers) {
            Log::warning("LDAP search failed: No user found for email {$transformedEmail}");
            return response()->json(['error' => 'User not found in LDAP'], 404);
        }
    
        // Assuming only one match, log the found user
        Log::info("LDAP user found: Full Name - {$ldapUsers[0]->fullName}, Email - {$ldapUsers[0]->email}");
    
        return response()->json([
            'engineer' => $ldapUsers[0]->fullName,
            'email' => $ldapUsers[0]->email,
        ]);
    }
    
    private function transformEmailToLDAP($email)
    {
        // Validate email format before transformation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email; // Return as-is if not valid
        }
    
        $parts = explode('@', $email);
        $username = $parts[0];
        $domain = $parts[1];
    
        // Specific username transformations
        $transformations = [
            'divine_delacruz' => 'dpdelacruz',
            'lj_cruz' => 'ltcruz',
            'mj_reyes'=> 'mjreyes',
            'vee_hernandez'=> 'vmhernandez',
            'liane_delacruz'=> 'ladelacruz',
            'tin_david'=> 'ttdavid',
            'royce_gonzales'=> 'ragonzales',
            'justine_garcia'=> 'jlgarcia',
            'jb_bautista'=> 'jbbautista'
        ];
    
        if (isset($transformations[$username])) {
            return $transformations[$username] . '@' . $domain;
        }
    
        // Check if the username follows the pattern: "first_last"
        if (preg_match('/^([a-zA-Z]+)_([a-zA-Z]+)$/', $username, $matches)) {
            $firstName = $matches[1];
            $lastName = $matches[2];
    
            // If the first part has only 2 characters (initials like "mj"), remove the underscore
            if (strlen($firstName) == 1) {
                return $firstName . $lastName . '@' . $domain;
            }
    
            // Otherwise, transform normally: Keep first letter + full last name
            return substr($firstName, 0, 1) . $lastName . '@' . $domain;
        }
    
        // If no underscore is found or other formats, return as-is
        return $email;
    }    
    
    
}
