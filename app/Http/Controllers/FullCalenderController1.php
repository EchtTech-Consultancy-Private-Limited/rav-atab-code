<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Auth;
use Redirect;
class FullCalenderController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {

        if($request->ajax()) {

             $user=Auth::user()->id;
             $datawe = Event::whereDate('id',$user)
                       ->get(['id', 'asesrar_id','title']);

            $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->where('type',1)
                       ->get(['id', 'title', 'start', 'end']);
             //dd("$data");
            return response()->json($data);
        }

        return view('asesrar.fullcalender');
    }

    public function ssessor_onsite_assessment(Request $request)
    {

        if($request->ajax()) {

             $user=Auth::user()->id;
             $datawe = Event::whereDate('id',$user)
                       ->get(['id', 'asesrar_id','title']);

            $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->where('type',2)
                       ->get(['id', 'title', 'start', 'end']);
             //dd("$data");
            return response()->json($data);
        }

        return view('asesrar.fullcalenderonsite');
    }



    public function onsiteassessment(Request $request)
    {

        if($request->ajax()) {

             $user=Auth::user()->id;
             $datawe = Event::whereDate('id',$user)
                       ->get(['id', 'asesrar_id','title']);

              $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->where('type',2)
                       ->get(['id', 'title', 'start', 'end']);
             //dd("$data");
            return response()->json($data);
        }

        return view('asesrar.fullcalenderonsite');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request)
    {
        //dd($request->event_type);
        /*if( $request->availability==1)
          {

            $request->event_class=="available";
            dd("$request->event_class");
          }
          elseif($request->availability==2)
          {
             $request->event_class=="unavailable";
          }*/

        switch ($request->type) {
           case 'add':

              $event = Event::create([
                  'asesrar_id' => $request->asesrar_id,
                  'type' => $request->event_type,
                  'availability' => $request->availability,
                  'title' => $request->add_event_descp,
                  'start' => $request->start,
                  'end' => $request->end,

               ]);

             //return Redirect::to('assessor-desktop-assessment');
             return response()->json($event);
             break;

             case 'update':
             //dd($request->edit_event_descp);
              $event = Event::find($request->event_id)->update([

                  'title' => $request->edit_event_descp,
              ]);

              return response()->json($event);
             break;

           case 'delete':
              $event = Event::find($request->id)->delete();

              return response()->json($event);
             break;

           default:
             # code...
             break;
        }
    }

     public function fullcalenderAjax_onsite(Request $request)
    {
        //dd($request->event_type);
        /*if( $request->availability==1)
          {

            $request->event_class=="available";
            dd("$request->event_class");
          }
          elseif($request->availability==2)
          {
             $request->event_class=="unavailable";
          }*/

        switch ($request->type) {
           case 'add':

              $event = Event::create([
                  'asesrar_id' => $request->asesrar_id,
                  'type' => $request->event_type,
                  'availability' => $request->availability,
                  'title' => $request->add_event_descp,
                  'start' => $request->start,
                  'end' => $request->end,

               ]);

             //return Redirect::to('assessor-desktop-assessment');
             return response()->json($event);
             break;

             case 'update':
              $event = Event::find($request->event_id)->update([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
              ]);

              return response()->json($event);
             break;

           case 'delete':
              $event = Event::find($request->id)->delete();

              return response()->json($event);
             break;

           default:
             # code...
             break;
        }
    }
}
