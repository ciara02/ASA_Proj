<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Controllers\crud_controller;

class AzureController extends Controller
{
    public function handleRedirect()
    {
        // Prevent caching
        $response = new Response();
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');

        return Socialite::driver('azure')->redirect();
    }

    public function handleCallBack()
    {
        // Check if the user is already authenticated
        if (Auth::check()) {
            // Redirect to the intended URL after successful login
            return redirect()->intended(route('tab-activity.index')); // Default route if no intended URL
        Log::debug('Redirecting to: ' . url()->previous());

        }
    
        try {
            $azure_user = Socialite::with('azure')->stateless()->user();
            $user = User::where('email', '=', $azure_user->email)->first();
    
            if (!$user) {
                $new_user = User::create([
                    'name' => $azure_user->getName(),
                    'email' => $azure_user->getEmail(),
                    'azure_id' => $azure_user->getId()
                ]);
    
                Auth::login($new_user);
                return redirect()->intended(route('tab-activity.index')); // Default route if no intended URL
            } else {
                Auth::login($user);
                return redirect()->intended(route('tab-activity.index')); // Default route if no intended URL
            }
        } catch (\Throwable $th) {
            Log::error('Azure Callback Error: ' . $th->getMessage());
            dd('Something went wrong!' . $th->getMessage());
        }
    }
    

    public function logout(Request $request)
    {
        try {
            Auth::guard()->logout();
            $request->session()->flush();
            $azureLogoutUrl = Socialite::driver('azure')->getLogoutUrl(route('login.page'));

            // Log the logout URL
            Log::info('Azure logout URL: ' . $azureLogoutUrl);

            return redirect($azureLogoutUrl);
        } catch (\Exception $e) {
            // Log any errors that occur during the redirect process
            Log::error('Error during logout redirect: ' . $e->getMessage());
            // You might want to handle the error gracefully, for example, by redirecting to a generic error page
            return redirect()->route('error.page');
        }
    }

    public function login()
    {

        return view('tab-login.login');
    }
}
