<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class textType extends Model
{
    public function text_type(){
        $sel = DB::table('text_type')->get()->toArray();
        return $sel;
    }
}