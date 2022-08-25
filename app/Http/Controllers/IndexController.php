<?php

namespace App\Http\Controllers;

use App\Mail\SubmissionMail;
use App\Models\Optout;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Exports\OptoutExport;
use App\Exports\HistoryExport;
use App\Models\History;
use Maatwebsite\Excel\Facades\Excel;
class IndexController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function submit(Request $request)
    {
        $data['ufax'] = ($request->has('ufax')) ? $request->ufax : '';
        $data['uphone'] = ($request->has('uphone')) ? $request->uphone : '';
        $data['ip_address'] = $request->ip();
        $data['datetime'] = now();

        Optout::create($data);
        try {
            Mail::send(new SubmissionMail($data));
        } catch (\Exception $e) {
            return $e;
        }
        return true;
    }
    public function export(Request $request){
        History::insert([
            'name' => Auth::user()->name,
            'download_date' => date('Y-m-d H:i:s'),
            'ip_adress' => $request->ip()
        ]);
        return Excel::download(new OptoutExport, 'optout.xlsx');
    }
    public function historExport (){
        return Excel::download(new HistoryExport, 'history.xlsx');
    }
}
