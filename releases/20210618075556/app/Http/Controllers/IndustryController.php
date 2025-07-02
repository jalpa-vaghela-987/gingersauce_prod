<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Industry;
use App\IndustryRelation;
use DB;

class IndustryController extends Controller
{
    public function get(Request $request){
    	if($request->has('q') && $request->has('level')){
    		return response()->json(Industry::where('level', 'Level '.$request->level)->where('title', 'like', '%'.$request->q.'%')->get());
    	}
    	return response()->json([]);
    }

    public function get_related(Request $request){
    	if($request->has('industry')){
    		$relations = DB::table('industry_relations')->where('term_id', $request->industry)->join('industries', 'industries.id', '=', 'industry_relations.relation_id')->get();
    		return response()->json($relations, 200);
    		//IndustryRelation::where('term_id', $request->industry)->get();

    	}
    	return response()->json([]);
    }
}
