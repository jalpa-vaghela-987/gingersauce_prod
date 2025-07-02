<?php

namespace App\Http\Controllers;

use App\Http\Requests\TabContent\StoreTabContentRequest;
use App\Http\Requests\TabContent\UpdateTabContentRequest;
use App\Tab;
use App\TabContent;
use App\Traits\ImageTrait;

class TabContentController extends Controller
{
    use ImageTrait;

    /**
     * Display a listing of the tab contents by tab id.
     */
    public function tabContents(Tab $tab)
    {
        $tabContents = TabContent::where('tab_id', $tab->id)->get();

        return response()->json(['tab_contents' => $tabContents]);
    }

    /**
     * Store a newly created tab content.
     */
    public function store(StoreTabContentRequest $request)
    {
        if($request->hasFile('image')) {
            $path = public_path( config('app.images_path') . 'tab_contents' . '/' . $request->tab_id . '/' );
            $image = $this->saveImage( $request->image, $path);
        }

        TabContent::create([
            'tab_id' => $request->tab_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => ($image) ?? null,
            'width' => $request->width,
            'height' => $request->height
        ]);

        return response()->json([]);
    }

    /**
     * Update the specified tab content.
     */
    public function update(UpdateTabContentRequest $request, $id)
    {
        $tabContent = TabContent::find($id);

        if($request->hasFile('image')) {
            if ($tabContent->image && file_exists( config('app.images_path') . 'tab_contents' . '/' . $tabContent->tab_id . '/' . $tabContent->image) ) {
                unlink( config('app.images_path') . 'tab_contents' . '/' . $tabContent->tab_id . '/' . $tabContent->image );
            }
            $path = public_path( config('app.images_path') . 'tab_contents' . '/' . $tabContent->tab_id . '/' );
            $image = $this->saveImage( $request->image, $path);
        }

        TabContent::where('id', $id)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => ($image) ?? $tabContent->image,
                'width' => $request->width,
                'height' => $request->height
            ]);

        return response()->json([]);
    }

    /**
     * Remove the specified tab content.
     */
    public function destroy($id)
    {
        $tabContent = TabContent::find($id);
        $tabContent->delete();
        return response()->json([]);
    }
}
