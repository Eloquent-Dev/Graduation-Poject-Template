<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class DispatcherController extends Controller
{
    public function index(){
        $complaints = Complaint::with(['category','user'])
        ->orderByRaw("FIELD(status,'pending,'in_progress','resolved','under_review','reopened','closed'")
        ->latest()
        ->paginate(15);

        return view('dispatcher.index', compact('complaints'));
    }

    public function show(Complaint $complaint){
        return view('dispatcher.show', compact('complaint'));
    }
}
