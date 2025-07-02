<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandBookResource extends JsonResource
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
            'brand'=>$this->brand,
            'tag'=>$this->tag,
            'type'=>$this->type,
            'state'=>$this->state,
            'industry_level_1'=>$this->industry_level_1,
            'industry_level_2'=>$this->industry_level_2,
            'logo'=>$this->logo,
            'logo_b64'=>$this->logo_b64,
            'icon'=>$this->icon,
            'icon_b64'=>$this->icon_b64,
            'approved'=>$this->approved,
            'rejected'=>$this->rejected,
            'approved_icon'=>$this->approved_icon,
            'rejected_icon'=>$this->rejected_icon,
            'proportions'=>$this->proportions,
            'space'=>$this->space,
            'size'=>$this->size,
            'colors_list'=>$this->colors_list,
            'fonts_main'=>$this->fonts_main,
            'fonts_secondary'=>$this->fonts_secondary,
            'vision'=>$this->vision,
            'mission'=>$this->mission,
            'core_values'=>$this->core_values,
            'user_id'=>$this->user_id,
            'status'=>$this->status,
            'color_list'=>$this->color_list,
            'main_color'=>$this->main_color,
            'main_color_hex'=>$this->main_color_hex,
            'secondary_color_hex'=>$this->secondary_color_hex,
            'theme'=>$this->theme,
            'completed'=>$this->completed,
            'shared_link'=>$this->shared_link,
            'old_logo'=>$this->old_logo,
            'logo_w'=>$this->logo_w,
            'logo_h'=>$this->logo_h,
            'new_color_scheme'=>$this->new_color_scheme,
            'mockups'=>$this->mockups,
            'icon_family'=>$this->icon_family,
            'misuses'=>$this->misuses,
            'logo_versions'=>$this->logo_versions,
            'expires_at'=>$this->expires_at,
            'all_logo_variations'=>$this->all_logo_variations,
            'graphic_element'=>$this->graphic_element,
        ];
    }
}
