<?php

namespace App\Http\Controllers;

use App\Brandbook;
use App\Http\Requests\Tab\StoreTabRequest;
use App\Http\Requests\Tab\UpdateTabRequest;
use App\Http\Requests\updateTabsOrderRequest;
use App\Tab;
use App\TabContent;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class TabController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the tabs by brandbook id.
     */
    public function tabs(Brandbook $brandbook)
    {
        $tabs = Tab::where('book_id', $brandbook->id)->get();

        return response()->json($tabs);
    }

    /**
     * Store a newly created tab.
     */
    public function store(StoreTabRequest $request)
    {
        $icon   =   $request->icon;
        $path = 'user_files/images/' . 'tabs' . '/' . $request->book_id . '/';
        if($iamge_path    =   $this->uploadBase64Image($icon,$path)){
            $payload            =   $request->except(["icon"]);
            $payload["icon"]    =   $iamge_path;
            $tab                =   Tab::create($payload);
            $tab->tabContents()->create([
                'title' => $tab->title,
            ]);
            return response()->json([]);
        }else{
            return response()->json([
                'error' => 'Invalid icon',
            ], 422);
        }

    }

    /**
     * Update the specified tab.
     */
    public function update(UpdateTabRequest $request, $id)
    {
        Tab::where('id', $id)
            ->update([
                'title' => $request->title,
                'icon' => $request->icon,
                'order' => $request->order,
                'slug' => Str::slug($request->title)
            ]);

        return response()->json([]);
    }

    /**
     * Remove the specified tab.
     */
    public static function deleteTab($tabId)
    {
        $tab = Tab::find($tabId);
        if($tab){
            if($tab->is_default){
                foreach ($tab->tabContents as $tabContent) {
                    $tabContent->delete();
                }
                $brandbook  =   $tab->brandBook;
                if($tab->slug   ==  Tab::INTRODUCTION){
                    $brandbook->introduction_title  =   null;
                    $brandbook->introduction_text   =   null;
                }elseif($tab->slug   ==  Tab::VISION){
                    $brandbook->vision_title    =   null;
                    $brandbook->vision_text =   null;
                    $brandbook->vision      =   null;
                }elseif($tab->slug   ==  Tab::MISSION){
                    $brandbook->mission_title   =   null;
                    $brandbook->mission_text    =   null;
                }elseif($tab->slug   ==  Tab::CORE_VALUES){
                    $brandbook->core_title  =   null;
                    $brandbook->core_text   =   null;
                }elseif($tab->slug   ==  Tab::BRAND_ARCHETYPE){
                    $brandbook->voices=   null;
                }elseif($tab->slug   ==  Tab::LOGO){
                    $brandbook->logo_title=   null;
                    $brandbook->logo_text=   null;
                }elseif($tab->slug   ==  Tab::CLEAR_SPACE){
                    $brandbook->space_title=   null;
                    $brandbook->space_text=   null;
                }elseif($tab->slug   ==  Tab::MINIMUM_SIZE){
                    $brandbook->size_title=   null;
                    $brandbook->size_text=   null;
                }elseif($tab->slug   ==  Tab::LOGO_MISUSE){
                    $brandbook->misuse_title    =   null;
                    $brandbook->misuse_text =   null;
                }elseif($tab->slug   ==  Tab::FEATURE_ICONS){
                    $brandbook->icon_family =   null;
                }elseif($tab->slug   ==  Tab::COLOR_PALETTE){
                    $brandbook->pallette_title  =   null;
                    $brandbook->pallette_text   =   null;
                    $brandbook->colors_list     =   null;
                }elseif($tab->slug   ==  Tab::OUR_FONTS){
                    $brandbook->fonts_main      =   null;
                    $brandbook->fonts_secondary =   null;
                }elseif($tab->slug   ==  Tab::BRAND_DESIGNER){
                }
                $tab->is_deleted    =   true;
                $tab->save();
            }else{
                $tab->delete();
            }
            return response()->json([]);
        }else{
            return response()->json([],405);
        }
    }
    public function updateTabsOrder(updateTabsOrderRequest $request){
        $tabSlugs = $request->tabSlugs;
        foreach ($tabSlugs as $index => $slug) {
            Tab::where('slug', $slug)->update(['order' => $index]);
        }
        return response()->json([]);
    }
}
