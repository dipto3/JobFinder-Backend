<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterCompanyRequest;
use App\Jobs\EmailConfirmationJob;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Package;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function verify(User $user)
    {
        if (! $user->email_verified_at) {
            $user->update([
                'email_verified_at' => Carbon::now(),
            ]);
            $user->company()->update([
                'status' => 1,
            ]);

            return redirect()->route('verification.success');
        }

        return redirect()->route('verification.already.done');
    }
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            // $candidateRole = Role::where('name', 'Candidate')->first();
            $user = Candidate::create([
                'name'     => $request->full_name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                // 'role_id'  => $candidateRole->id,
            ]);

            // Candidate::create([
            //     'user_id' => $user->id,
            // ]);
            // event(new WelcomeMailEvent($user));
            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Candidate registered successfully',
                'data'    => $user,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Registration failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $candidate = Candidate::where('email', $request->email)->first();

        if (! $candidate || ! Hash::check($request->password, $candidate->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Create token using correct guard
        $token = $candidate->createToken('candidate-api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => $candidate,
        ]);
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => [
                'id'      => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'role_id' => $user->role_id,
            ],
        ], 200);
    }

    public function companyRegister(RegisterCompanyRequest $request)
    {
        $request->validated();
        DB::beginTransaction();

        try {
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('company-logo', 'public');
            }
            $companyRole = Role::where('name', 'Company')->first();
            $package     = Package::where('name', 'Basic')->first();
            $user        = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role_id'  => $companyRole->id,
            ]);

            $company = Company::create([
                'user_id'    => $user->id,
                'package_id' => $package->id,
                'name'       => $request->name,
                'email'      => $request->email,
                'website'    => $request->website,
                'logo'       => $logoPath,
                'address'    => $request->address,
                'phone'      => $request->phone,
                'status'     => 0,
            ]);
            EmailConfirmationJob::dispatch($user);
            DB::commit();
            return response()->json([
                'message' => 'Company registered request successfully!',
                'user'    => $user,
                'company' => $company,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Registration failed',
                'error'   => $e->getMessage(),
            ], 500);
        }

    }

    public function companyLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

        $company = Company::where('user_id', $user->id)->first();

        if (! $company) {
            return response()->json([
                'status'  => false,
                'message' => 'Company record not found for this user',
            ], 404);
        }

        if ($company->status != 1) {
            return response()->json([
                'status'  => false,
                'message' => 'Your company account is not approved yet.',
            ], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'role_id'    => $user->role_id,
                'company_id' => $company->id,
                'logo'       => $company->logo ? asset('storage/' . $company->logo) : null,
            ],
        ], 200);
    }

    public function verificationAlreadyDone()
    {
        return view('mail.company-verification-done');
    }

    public function verificationSuccess()
    {
        return view('mail.verification-success');
    }

    public function adminDetails()
    {
        $admin = User::where('id', auth()->id())->first();
        dd($admin);
        return $admin;
    }
}
