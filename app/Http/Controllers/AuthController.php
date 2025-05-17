<?php
namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            $candidateRole = Role::where('name', 'Candidate')->first();
            $user          = User::create([
                'name'     => $request->full_name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role_id'  => $candidateRole->id,
            ]);

            // Step 2: Create candidate
            Candidate::create([
                'user_id' => $user->id,
            ]);

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
            'password' => 'required|string',
        ]);

      
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid credentials',
            ], 401);
        }

       
        $candidate = Candidate::where('user_id', $user->id)->first();

        if (! $candidate) {
            return response()->json([
                'status'  => false,
                'message' => 'Candidate record not found for this user',
            ], 404);
        }

        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => [
                'id'           => $user->id,
                'name'         => $user->name,
                'email'        => $user->email,
                'role_id'      => $user->role_id,
                'candidate_id' => $candidate->id,
                'image'        => $candidate->image ? asset('storage/' . $candidate->image) : null,
            ],
        ], 200);
    }
}
