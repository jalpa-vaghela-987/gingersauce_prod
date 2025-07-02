<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Theme;
use Auth;
use App\Http\Controllers\BrandbookController;

class ThemeController extends Controller
{
	public function load()
	{
		if (Auth::check()) {
			return response()->json(['themes' => Theme::where('is_active', true)->get()]);
		}
	}

	public function load_preview(Request $request)
	{
		$bbc = new BrandbookController;
		$theme = Theme::findOrFail($request->theme);
		$file = json_decode($theme->file, true);
		$id = $request->id;

		return $bbc->get_html($id, $file[0]['download_link'], false);
	}
}
