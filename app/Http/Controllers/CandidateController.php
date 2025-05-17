<?php
namespace App\Http\Controllers;

use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function profile()
    {
        $candidate = Candidate::where('user_id', auth()->id())->first();
        return CandidateResource::make($candidate);
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        $data = $request->validate([
            'name'             => 'nullable|string|max:255',
            'email'            => 'nullable|email|max:255',
            'address'          => 'nullable|string',
            'designation'      => 'nullable|string',
            'phone'            => 'nullable|numeric',
            'image'            => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'cv'               => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter'     => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'status'           => 'nullable|in:0,1',
            'facebook'         => 'nullable|url',
            'github'           => 'nullable|url',
            'twitter'          => 'nullable|url',
            'linkedin'         => 'nullable|url',
            'personal_website' => 'nullable|url',
            'about'            => 'nullable|string',
        ]);

        // ✅ Step 1: build user data with fallback to existing
        $userData = [
            'name'  => $request->input('name', $candidate->user->name),
            'email' => $request->input('email', $candidate->user->email),
        ];
        $candidate->user->update($userData);

        // ✅ Step 2: handle file uploads with delete + update
        if ($request->hasFile('image')) {
            if ($candidate->image && Storage::disk('public')->exists($candidate->image)) {
                Storage::disk('public')->delete($candidate->image);
            }
            $data['image'] = $request->file('image')->store('candidate-image', 'public');
        } else {
            $data['image'] = $candidate->image;
        }

        if ($request->hasFile('cv')) {
            if ($candidate->cv && Storage::disk('public')->exists($candidate->cv)) {
                Storage::disk('public')->delete($candidate->cv);
            }
            $data['cv'] = $request->file('cv')->store('candidate-cv', 'public');
        } else {
            $data['cv'] = $candidate->cv;
        }

        if ($request->hasFile('cover_letter')) {
            if ($candidate->cover_letter && Storage::disk('public')->exists($candidate->cover_letter)) {
                Storage::disk('public')->delete($candidate->cover_letter);
            }
            $data['cover_letter'] = $request->file('cover_letter')->store('candidate-cover-letter', 'public');
        } else {
            $data['cover_letter'] = $candidate->cover_letter;
        }

        // ✅ Step 3: build full candidate data with fallback to existing values
        $candidateData = [
            'address'          => $request->input('address', $candidate->address),
            'designation'      => $request->input('designation', $candidate->designation),
            'phone'            => $request->input('phone', $candidate->phone),
            'image'            => $data['image'],
            'cv'               => $data['cv'],
            'cover_letter'     => $data['cover_letter'],
            'status'           => $request->input('status', $candidate->status),
            'facebook'         => $request->input('facebook', $candidate->facebook),
            'github'           => $request->input('github', $candidate->github),
            'twitter'          => $request->input('twitter', $candidate->twitter),
            'linkedin'         => $request->input('linkedin', $candidate->linkedin),
            'personal_website' => $request->input('personal_website', $candidate->personal_website),
            'about'            => $request->input('about', $candidate->about),
        ];

        // ✅ Final update
        $candidate->update($candidateData);

        return new CandidateResource($candidate);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
