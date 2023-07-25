<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Faq;

class FaqController extends Controller
{
    //

    public function get_faqs(Request $request)
    {

        if(!empty($request->category)) $faqs=Faq::where('faqs.category',$request->category)->orderby('id','Desc')->paginate(10);
        else $faqs=Faq::orderby('id','Desc')->paginate(10);

        $faqs->appends(['category' => $request->category]);

        return view("pages.faq-index",compact('faqs'));
       
    }
    public function view_faqs(Request $request)
    {
        $faqs=Faq::where('category',5)->orderby('sort_order','Asc')->get();
        return view("pages.faq-view",compact('faqs'));
       
    }
    
    public function add_faq(Request $request)
    {
        return view("pages.faq-add");
       
    }
    public function add_faq_post(Request $request)
    {
        $request->validate(
            [
            'question' =>'required',
            'answer' =>'required',
            ]
        );

        Faq::create(['question'=>$request->question,'answer'=>$request->answer,'category'=>$request->category,'sort_order'=>$request->sort_order]);
        return redirect('/get-faqs')->with('success', 'Faq added successfull!! ');
    }

    public function update_faq(Request $request,$id=0)
    {

        $id=dDecrypt($id);

        $faq=Faq::where('id',$id)->get();
        //dd($faq);
        return view("pages.faq-edit",['data'=>$faq->first()]);
    }

    public function update_faq_post(Request $request,$id=0)
    {

        $id=dDecrypt($id);

        $request->validate(
            [
            'question' =>'required',
            'answer' =>'required',
            ]
        );
         //  dd($request->all());
            $data=Faq::find($id);
            $data->question = $request->question;
            $data->answer = $request->answer;
            $data->category = $request->category;
            $data->sort_order = $request->sort_order;
            $data->save();
            return redirect('/get-faqs')->with('success', 'Faq Updated successfull!! ');
    }

    public function delete_faq(Request $request,$id=0)
    {
        $id=dDecrypt($id);
        $data=Faq::where('id',$id)->delete();
        return redirect('/get-faqs')->with('success', 'Faq Deleted successfull!! ');
    }

    public function activate_faq(Request $request,$id=0)
    {
        $id=dDecrypt($id);
        $data=Faq::find($id);
        $data->status = ($data->status==1?0:1);
        $data->save();
        return redirect('/get-faqs')->with('success', 'Faq Activated successfull!! ');
    }

}
