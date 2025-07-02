<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Tab extends Model
{
    protected $fillable = ['book_id', 'slug', 'title', 'icon', 'is_default', 'order', 'status'];
        const INTRODUCTION    =   'introduction';
        const VISION    =  'vision';
        const MISSION    =  'mission';
        const CORE_VALUES    =  'core-values';
        const BRAND_ARCHETYPE    =  'brand-archetype';
        const LOGO    =  'logo';
        const CLEAR_SPACE    =  'clear-space';
        const MINIMUM_SIZE    =  'minimum-size';
        const LOGO_MISUSE    =  'logo-misuse';
        const FEATURE_ICONS    =  'feature-icons';
        const COLOR_PALETTE    =  'color-palette';
        const OUR_FONTS    =  'our-fonts';
        const BRAND_DESIGNER    =  'brand-designer';

    public function setTitleAttribute($title) {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }

    public function brandBooks() {
        return $this->belongsTo( 'App\Brandbook');
    }
    public function brandBook(): BelongsTo {
        return $this->belongsTo(Brandbook::class,'book_id','id');
    }

    public function tabContents() {
        return $this->hasMany( 'App\TabContent', 'tab_id', 'id');
    }
    public function getIconAttribute(){
        $icon       =   $this->attributes['icon'];
        $is_default =   $this->attributes['is_default'];
        if(!$is_default && !$this->isSVG($icon) && Storage::exists($icon)){
            return Storage::url($icon);
        }else{
            return $icon;
        }
    }
    private function isSVG($svgString) {
        try{
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($svgString);
            if ($xml !== false && $xml->getName() === 'svg' && $xml['xmlns'] == 'http://www.w3.org/2000/svg') {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
