<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'location'=>$this->location,
            'avatar'=> $this->avatar,
            'avatar_url'=> $this->avatar_url,
            'name'=> $this->name,
            'position'=> $this->position,
            'description'=> $this->description,
            'company_web'=> $this->company_web,
            'company_dribble'=> $this->company_dribble,
            'company_behance'=> $this->company_behance,
            'company_phone'=> $this->company_phone,
            'email'=> $this->email,
            'company_logo_full'=> $this->company_logo_full,
        ];
    }
}
