<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('guest.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function showRegistrationForm()
    {
        return view('guest.register');
    }

    public function register(Request $request)
    {
        $registrationData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|regex:/[0-9]/|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*?&#]/',
            'gender' => 'required|in:Male,Female',
            'field_of_work' => 'required|string|regex:/^(?:[^,]+,){2}[^,]+$/',
            'linkedin_username' => 'required|regex:/^https:\/\/www\.linkedin\.com\/in\/[a-zA-Z0-9\-_]+$/',
            'mobile_number' => 'required|digits_between:10,15',
        ], [
            'name.required' => 'Your name is required.',
            'name.string' => 'Your name must be a valid string.',
            'name.max' => 'Your name must not exceed 255 characters.',
            'email.required' => 'Your email is required.',
            'email.email' => 'Your email must be a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'A password is required.',
            'password.regex' => 'Your password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'gender.required' => 'Please select your gender.',
            'gender.in' => 'Gender must be either Male or Female.',
            'field_of_work.required' => 'Your field of work is required.',
            'field_of_work.regex' => 'Your field of work must contain at least three values separated by commas.',
            'linkedin_username.required' => 'Your LinkedIn username is required.',
            'linkedin_username.regex' => 'Please provide a valid LinkedIn profile link (e.g., https://www.linkedin.com/in/username).',
            'mobile_number.required' => 'Your mobile number is required.',
            'mobile_number.digits_between' => 'Your mobile number must be between 10 and 15 digits.',
        ]);

        $registrationFee = random_int(100000, 125000);

        session(['registrationData' => $registrationData, 'registrationFee' => $registrationFee]);

        return redirect()->route('guest.processPayment');
    }

    public function showProcessPaymentPage()
    {
        $registrationData = session('registrationData');
        $registrationFee = session('registrationFee');

        if (!$registrationData || !$registrationFee) {
            return redirect()->route('register')->with('error', 'Registration data not found!');
        }

        return view('guest.processPayment', compact('registrationData', 'registrationFee'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $registrationData = session('registrationData');
        $expectedFee = session('registrationFee');

        if (!$registrationData || !$expectedFee) {
            return redirect()->route('guest.register')->with('error', 'Registration data not found!');
        }

        $amount = $request->amount;

        if ($amount < $expectedFee) {
            return redirect()->route('processPayment')->withInput()->withErrors(['amount' => 'You are still underpaid by Rp ' . ($expectedFee - $amount)]);
        } else if ($amount > $expectedFee) {
            $overpaid = $amount - $expectedFee;

            session(['overpaidAmount' => $overpaid, 'previousAmount' => $amount]);

            return redirect()->route('processPayment')->with([
                'success' => "You overpaid by Rp $overpaid. Would you like to add the overpaid amount to your balance?",
                'confirmationNeeded' => true,
            ]);
        } else {
            return $this->finalizeRegistration($registrationData);
        }
    }

    private function finalizeRegistration($registrationData, $overpaidAmount = 0)
    {
        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'password' => bcrypt($registrationData['password']),
            'gender' => $registrationData['gender'],
            'field_of_work' => $registrationData['field_of_work'],
            'linkedin_username' => $registrationData['linkedin_username'],
            'mobile_number' => $registrationData['mobile_number'],
            'coin_balance' => $overpaidAmount,
        ]);

        session()->forget(['registrationData', 'registrationFee', 'overpaidAmount', 'previousAmount']);
        Auth::login($user);

        return redirect()->route('user.home')->with('success', 'Registration successful! Welcome!');
    }


    public function confirmOverpayment(Request $request)
    {
        $request->validate([
            'confirmOverpayment' => 'required|in:yes',
            'overpaidAmount' => 'required|numeric',
        ]);

        $registrationData = session('registrationData');
        if (!$registrationData) {
            return redirect()->route('guest.register')->with('error', 'Registration data not found!');
        }

        $overpaidAmount = session('overpaidAmount', 0);
        return $this->finalizeRegistration($registrationData, $overpaidAmount);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
