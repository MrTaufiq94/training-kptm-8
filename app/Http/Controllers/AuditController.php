<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;

class AuditController extends Controller
{
    public function audit(){
        //query all audit
        $audits = Audit::orderBy('created_at','desc')->get();
        //return to view
        return view('audit', compact('audits'));
    }
}
