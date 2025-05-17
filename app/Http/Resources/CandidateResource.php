<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'name'             => $this->user?->name,
            'email'            => $this->user?->email,
            'address'          => $this->address,
            'designation'      => $this->designation,
            'phone'            => $this->phone,
            'image'            => $this->image ? asset('storage/' . $this->image) : null,
            'cv'               => $this->cv ? asset('storage/' . $this->cv) : null,
            'cover_letter'     => $this->cover_letter ? asset('storage/' . $this->cover_letter) : null,
            'status'           => $this->status,
            'facebook'         => $this->facebook,
            'github'           => $this->github,
            'twitter'          => $this->twitter,
            'linkedin'         => $this->linkedin,
            'personal_website' => $this->personal_website,
            'about'            => $this->about,
        ];
    }
}
