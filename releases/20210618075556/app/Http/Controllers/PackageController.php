<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;

class PackageController extends Controller {

    public function packages() {
        return Package::orderBy( 'position' )->get()->toJson();
    }

}
