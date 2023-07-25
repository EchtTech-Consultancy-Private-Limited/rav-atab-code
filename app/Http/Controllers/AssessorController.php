<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use Redirect;
use App\Models\Manuals;
use Illuminate\Http\Request;

class AssessorController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function manual_list()
    {
        $data = Manuals::where('status','1')->orderBy('id','DESC')->get();
        //dd($data);
        return view('asesrar.list-manual',['data'=> $data]);
    }

}
