<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Auth;
use Redirect;
class FullCalenderController extends Controller
{
public function index(Request $request)
    {
        if($request->ajax()) {

             $user=Auth::user()->id;
             $datawe = Event::whereDate('id',$user)
                       ->get(['id', 'asesrar_id','title']);

            $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->where('type',1)
                       ->get(['id', 'title', 'start', 'end','availability']);
             //dd("$data");

            //return $data;
            return response()->json($data);
        }

        return view('asesrar.fullcalender');
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

    public function assessor_onsite_assessment(Request $request)
    {

        if($request->ajax()) {

             $user=Auth::user()->id;
             $datawe = Event::whereDate('id',$user)
                       ->get(['id', 'asesrar_id','title']);

            $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->where('type',2)
                       ->get(['id', 'title', 'start', 'end','availability']);
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
        switch ($request->type) {
           case 'add':

              if($request->add_event_availability==1)
              {
                    //dd("available");
                    $data=Event::where('start',$request->start)->first();

                    if($data)
                    {
                        $event = Event::where('start',$request->start)->Update([
                          'asesrar_id' => $request->asesrar_id,
                          'type' => $request->event_type,
                          'availability' => 1,
                          'title' => "Available",
                          'start' => $request->start,
                          'end' => $request->end,

                       ]);
                    }
                    else
                    {
                        $event = Event::create([
                          'asesrar_id' => $request->asesrar_id,
                          'type' => $request->event_type,
                          'availability' => 1,
                          /*'title' => $request->add_event_descp,*/
                          'title' => "Available",
                          'start' => $request->start,
                          'end' => $request->end,

                       ]);
                    }

              }
              else
              {
                    //dd("unavailable");
                    $data=Event::where('start',$request->start)->first();
                    if($data)
                    {
                        $event = Event::where('start',$request->start)->Update([
                          'asesrar_id' => $request->asesrar_id,
                          'type' => $request->event_type,
                          'availability' => 2,
                          /*'title' => $request->add_event_descp,*/
                          'title' => "Unavailable",
                          'start' => $request->start,
                          'end' => $request->end,

                       ]);
                    }
                    else
                    {
                        $event = Event::create([
                          'asesrar_id' => $request->asesrar_id,
                          'type' => $request->event_type,
                          'availability' => 2,
                          /*'title' => $request->add_event_descp,*/
                          'title' => "Unavailable",
                          'start' => $request->start,
                          'end' => $request->end,

                       ]);
                    }
              }

              /*$event = Event::create([
                  'asesrar_id' => $request->asesrar_id,
                  'type' => $request->event_type,
                  'availability' => $request->availability,
                  'title' => $request->add_event_descp,
                  'start' => $request->start,
                  'end' => $request->end,

               ]);*/

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
}
