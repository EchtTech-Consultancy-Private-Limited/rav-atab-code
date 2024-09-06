<?php 
namespace App\Http\Helpers;

use DB,Log;
use Carbon\Carbon;


class ApplicationDurationCaculate {

    /****** Start Secretariat ****/
    function calculateTimeDateAccount($role_id, $userAction, $app) {
        if(isset($app)){
        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => $role_id,
            'user_action'=>$userAction
        ])->first();

        $application_payment = DB::table('tbl_application_payment')->whereNull('deleted_at')->where([
            'application_id' => $app->id,
            'pay_status'=>'Y'
        ])->latest()->first();
    //    dd($application_payment->approve_remark);
       $obj = new \stdclass;
       if($application_payment?->approve_remark == null){
        if($application_time){
            $now = time();
            /**Start-- Extra Day Assign By Admin */
            $assignDayTime = $now - strtotime($app->assign_day_for_verify_date);
            $assigndayscount = round($assignDayTime/ (60 * 60 * 24));
            if($app->assign_day_for_verify >= $assigndayscount){
                $assignDayVerifys = (int)($app->assign_day_for_verify);
            }else{
                $assignDayVerifys =0;
            }
            /**End-- Extra Day Assign By Admin */
            $dayTime = $now - strtotime($app->created_at);
            $dayscount = round($dayTime/ (60 * 60 * 24));
            if($application_time->number_of_days >= $dayscount){
                $applicationTime = (int)($application_time->number_of_days-$dayscount);
            }elseif($app->assign_day_for_verify !=0 && $assignDayVerifys !=0){
                $applicationTime = (int)($app->assign_day_for_verify);
                
            }else{
                $applicationTime =0;
            }
           
            if($applicationTime == 0){
                if($assignDayVerifys>0){
                    $obj->applicationAction = 'Y';
                    $obj->applicationDayTime =$assignDayVerifys;
                }else{
                    $obj->applicationAction = 'N';
                    $obj->applicationDayTime =0;
                }
            }else{
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$applicationTime;
            }
        }
        //return $obj;
       }else{
            $obj->applicationAction = 'V';
            $obj->applicationDayTime =0;
           
       }
       return $obj;
    }else{
        return null;
    }
    }
    /****** End Account *********/

    /****** Start Secretariat ***/
    function calculateTimeDateSecretariat($role_id, $userAction, $app) {
        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => $role_id,
            'user_action'=>$userAction
        ])->first();

        $application_payment = DB::table('tbl_application_payment')->whereNull('deleted_at')->where([
            'application_id' => $app->id,
            'pay_status'=>'Y'
        ])->latest()->first();
        //dd($application_time);
       $obj = new \stdclass;
       //if($application_payment->approve_remark == null){
        if($application_time){
            $now = time();
            /**Start-- Extra Day Assign By Admin */
            $assignDayTime = $now - strtotime($app->assign_day_for_verify_date);
            $assigndayscount = round($assignDayTime/ (60 * 60 * 24));
            if($app->assign_day_for_verify >= $assigndayscount){
                $assignDayVerifys = (int)($app->assign_day_for_verify);
            }else{
                $assignDayVerifys =0;
            }
            /**End-- Extra Day Assign By Admin */
            $secretariat_details = DB::table('tbl_secretariat_assign')->where('application_id',$app->id)->first();
            $dayTime = $now - strtotime($secretariat_details->created_at);
            $dayscount = round($dayTime/ (60 * 60 * 24));
            if($application_time->number_of_days >= $dayscount){
                $applicationTime = (int)($application_time->number_of_days-$dayscount);
            }elseif($app->assign_day_for_verify !=0 && $assignDayVerifys !=0){
                $applicationTime = (int)($app->assign_day_for_verify);
            }else{
                $applicationTime =0;
            }
           
            if($applicationTime == 0){
                if($assignDayVerifys>0){
                    $obj->applicationAction = 'Y';
                    $obj->applicationDayTime =$assignDayVerifys;
                }else{
                    $obj->applicationAction = 'N';
                    $obj->applicationDayTime =0;
                }
            }else{
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$applicationTime;
            }
        }
        //return $obj;
        //}else{
        //  $obj->applicationAction = 'V';
        //  $obj->applicationDayTime =0;
        //}
       return $obj;
    }
    /****** End Secretariat *****/

    /****** Start Training Provider *****/
    function calculateTimeDateTrainingProvider($role_id, $userAction, $app) {
       
        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => $role_id,
            'user_action'=>$userAction
        ])->first();

        $application_payment = DB::table('tbl_application_payment')->whereNull('deleted_at')->where([
            'application_id' => $app->id,
            'pay_status'=>'Y'
        ])->latest()->first();
       //dd($role_id);
       $obj = new \stdclass;
       //if($application_payment->approve_remark == null){
        if($application_time){
            $now = time();
            /**Start-- Extra Day Assign By Admin */
            $assignDayTime = $now - strtotime($app->assign_day_for_verify_date);
            $assigndayscount = round($assignDayTime/ (60 * 60 * 24));
            if($app->assign_day_for_verify >= $assigndayscount){
                $assignDayVerifys = (int)($app->assign_day_for_verify);
            }else{
                $assignDayVerifys =0;
            }
            /**End-- Extra Day Assign By Admin */
            $dayTime = $now - strtotime($app->created_at);
            $dayscount = round($dayTime/ (60 * 60 * 24));
            if($application_time->number_of_days >= $dayscount){
                $applicationTime = (int)($application_time->number_of_days-$dayscount);
            }elseif($app->assign_day_for_verify !=0 && $assignDayVerifys !=0){
                $applicationTime = (int)($app->assign_day_for_verify);
                
            }else{
                $applicationTime =0;
            }
           
            if($applicationTime == 0){
                if($assignDayVerifys>0){
                    $obj->applicationAction = 'Y';
                    $obj->applicationDayTime =$assignDayVerifys;
                }else{
                    $obj->applicationAction = 'N';
                    $obj->applicationDayTime =0;
                }
            }else{
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$applicationTime;
            }
        }
        //return $obj;
        //    }else{
        //         $obj->applicationAction = 'V';
        //         $obj->applicationDayTime =0;
            
        //    }
            return $obj;
    }
    /****** End Training Provider ******/
    
    /****** Start Desktop Assessor Verify Document ******/
    function calculateTimeDateDesktopAssessorAcceptDoc($assID, $role_id, $userAction, $app) {
       
        $now = time();
        /**Start-- Extra Day Assign By Admin */
        $assignDayTime = $now - strtotime($app->assign_day_for_verify_date);
        $assigndayscount = round($assignDayTime/ (60 * 60 * 24));
        if($app->assign_day_for_verify >= $assigndayscount){
            $assignDayVerifys = (int)($app->assign_day_for_verify);
        }else{
            $assignDayVerifys =0;
        }
        /**End-- Extra Day Assign By Admin */


        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => $role_id,
            'user_action'=>$userAction,
            'user_type' =>'desktop'
        ])->first();

        $assessor_assign = DB::table('tbl_assessor_assign')->where([
            'application_id' => $app->id,
            'assessor_id' => $assID,
            'assessor_type' => 'desktop'
        ])->latest()->first();


       if(!empty($assessor_assign)){
       $obj = new \stdclass;
       $now = strtotime(date('Y-m-d'));
       $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       $daysCount = strtotime(date('Y-m-d'))-strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       if(isset($application_time->number_of_days) && $application_time->number_of_days ==1){
            $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       }else{
            $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at. ' + '.$application_time->number_of_days.' days')));
       }
      //dd($assignDate);
        if($application_time){
            if($assignDate >= $now){
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$application_time->number_of_days;
           }else{
            if($assignDayVerifys>0){
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$assignDayVerifys;
            }else{
                $obj->applicationAction = 'N';
                $obj->applicationDayTime =0;
            }
           }
        }
        return $obj;
      }else{
        return null;
      }

    }
    function calculateTimeDateDesktopAssessorVerifyDoc($assID, $role_id, $userAction, $app) {
       
        $now = time();
        /**Start-- Extra Day Assign By Admin */
        $assignDayTime = $now - strtotime($app->assign_day_for_verify_date);
        $assigndayscount = round($assignDayTime/ (60 * 60 * 24));
        if($app->assign_day_for_verify >= $assigndayscount){
            $assignDayVerifys = (int)($app->assign_day_for_verify);
        }else{
            $assignDayVerifys =0;
        }
        /**End-- Extra Day Assign By Admin */


        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => $role_id,
            'user_action'=>$userAction,
            'user_type' =>'desktop'
        ])->first();

        $assessor_assign = DB::table('tbl_assessor_assign')->where([
            'application_id' => $app->id,
            'assessor_id' => $assID,
            'assessor_type' => 'desktop'
        ])->latest()->first();
    if(!empty($assessor_assign)){
       $obj = new \stdclass;
       $now = strtotime(date('Y-m-d'));
       $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       $daysCount = strtotime(date('Y-m-d'))-strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       $assigndayscount = round($daysCount/ (60 * 60 * 24));

       if($application_time->number_of_days ==1){
            $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       }else{
            $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at. ' + '.$application_time->number_of_days.' days')));
       }
        if($application_time){
            if($assignDate >= $now){
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$assigndayscount;
           }else{
            if($assignDayVerifys>0){
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$assignDayVerifys;
            }else{
                $obj->applicationAction = 'N';
                $obj->applicationDayTime =0;
            }
           }
        }
        return $obj;
      }else{
        
        return null;
      }
    }
    /****** End Desktop Assessor Verify Document *******/

    /****** Start Onsite Assessor Verify Document ******/
    function calculateTimeDateOnsiteAssessorAcceptDoc($assID, $role_id, $userAction, $app) {
       
        $now = time();
        /**Start-- Extra Day Assign By Admin */
        $assignDayTime = $now - strtotime($app->assign_day_for_verify_date);
        $assigndayscount = round($assignDayTime/ (60 * 60 * 24));
        if($app->assign_day_for_verify >= $assigndayscount){
            $assignDayVerifys = (int)($app->assign_day_for_verify);
        }else{
            $assignDayVerifys =0;
        }
        /**End-- Extra Day Assign By Admin */

        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => $role_id,
            'user_action'=>$userAction,
            'user_type' =>'onsite'
        ])->first();

        $assessor_assign = DB::table('tbl_assessor_assign')->where([
            'application_id' => $app->id,
            'assessor_id' => $assID,
            'assessor_type' => 'onsite'
        ])->latest()->first();
       if(!empty($assessor_assign)){
       $obj = new \stdclass;
       $now = strtotime(date('Y-m-d'));
       $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       $daysCount = strtotime(date('Y-m-d'))-strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       if($application_time->number_of_days ==1){
            $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       }else{
            $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at. ' + '.$application_time->number_of_days.' days')));
       }
      //dd($assignDate);
        if($application_time){
            if($assignDate >= $now){
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$application_time->number_of_days;
           }else{
            if($assignDayVerifys>0){
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$assignDayVerifys;
            }else{
                $obj->applicationAction = 'N';
                $obj->applicationDayTime =0;
            }
           }
        }
        return $obj;
     }else{
        return null;
     }
    }
    function calculateTimeDateOnsiteAssessorVerifyDoc($assID, $role_id, $userAction, $app) {
       
        $now = time();
        /**Start-- Extra Day Assign By Admin */
        $assignDayTime = $now - strtotime($app->assign_day_for_verify_date);
        $assigndayscount = round($assignDayTime/ (60 * 60 * 24));
        if($app->assign_day_for_verify >= $assigndayscount){
            $assignDayVerifys = (int)($app->assign_day_for_verify);
        }else{
            $assignDayVerifys =0;
        }
        /**End-- Extra Day Assign By Admin */

        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => $role_id,
            'user_action'=>$userAction,
            'user_type' =>'onsite'
        ])->first();

        $assessor_assign = DB::table('tbl_assessor_assign')->where([
            'application_id' => $app->id,
            'assessor_id' => $assID,
            'assessor_type' => 'onsite'
        ])->latest()->first();
        if(!empty($assessor_assign)){
       $obj = new \stdclass;
       $now = strtotime(date('Y-m-d'));
       $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       $daysCount = strtotime(date('Y-m-d'))-strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       if($application_time->number_of_days ==1){
            $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at)));
       }else{
            $assignDate = strtotime(date('Y-m-d', strtotime($assessor_assign->created_at. ' + '.$application_time->number_of_days.' days')));
       }
      //dd($assignDate);
        if($application_time){
            if($assignDate >= $now){
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$application_time->number_of_days;
           }else{
            if($assignDayVerifys>0){
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$assignDayVerifys;
            }else{
                $obj->applicationAction = 'N';
                $obj->applicationDayTime =0;
            }
           }
        }
        return $obj;
     }else{
        return null;
     }
    }
    /****** End Onsite Assessor Verify Document ********/

    /****** Start Admin *********/
    function calculateTimeDateAdmin($role_id, $userAction, $app) {
       
        $application_time = DB::table('tbl_application_time')->where([
            'role_id' => $role_id,
            'user_action'=>$userAction
        ])->first();

        $application_payment = DB::table('tbl_application_payment')->whereNull('deleted_at')->where([
            'application_id' => $app->id,
            'pay_status'=>'Y'
        ])->latest()->first();
       $obj = new \stdclass;
       //if($application_payment->approve_remark == null){
        if($application_time){
            $now = time();
            /**Start-- Extra Day Assign By Admin */
            $assignDayTime = $now - strtotime($app->assign_day_for_verify_date);
            $assigndayscount = round($assignDayTime/ (60 * 60 * 24));
            if($app->assign_day_for_verify >= $assigndayscount){
                $assignDayVerifys = (int)($app->assign_day_for_verify);
            }else{
                $assignDayVerifys =0;
            }
            /**End-- Extra Day Assign By Admin */
            $dayTime = $now - strtotime($app->created_at);
            $dayscount = round($dayTime/ (60 * 60 * 24));
            if($application_time->number_of_days >= $dayscount){
                $applicationTime = (int)($application_time->number_of_days-$dayscount);
            }elseif($app->assign_day_for_verify !=0 && $assignDayVerifys !=0){
                $applicationTime = (int)($app->assign_day_for_verify);
                
            }else{
                $applicationTime =0;
            }
           
            if($applicationTime == 0){
                 if($assignDayVerifys>0){
                    $obj->applicationAction = 'Y';
                    $obj->applicationDayTime =$assignDayVerifys;
                }else{
                    $obj->applicationAction = 'N';
                    $obj->applicationDayTime =0;
                }
            }else{
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$applicationTime;
            }
        }
    
            return $obj;
    }
    /****** End Admin ******/

    /****** Start Surveillance Renewal ****/
    function surveillanceRenewal($roleid, $app){
        //dd($app->level_id);
        $renewal = DB::table('tbl_surveillance_renewal')->where([
            'application_level' => $app->level_id,
            'popup_type' =>'renewal',
        ])->first();
        $surveillance = DB::table('tbl_surveillance_renewal')->where([
            'application_level' => $app->level_id,
            'popup_type' => 'surveillance',
        ])->first();
        $obj = new \stdclass;
        $now = time();
        if($app->valid_till !=''){

            $totalday = strtotime($app->valid_till)-strtotime($app->valid_from);
            $totoaldayscount = round($totalday/ (60 * 60 * 24));
            
            $fromDate = strtotime($app->valid_till)-$now;
            $dayscount = round($fromDate/ (60 * 60 * 24));
        //dd($totoaldayscount);
            if($dayscount <= $surveillance->popup_show_days){
                $obj->surveillance_popup = $surveillance->popup_show_days;
                $obj->surveillance_totalDay = $surveillance->number_of_days;
                $obj->surveillance_status = 'Y';
            }
            if($dayscount <= $renewal->popup_show_days){
                $obj->renewal_popup = $renewal->popup_show_days;
                $obj->renewal_totalDay = $renewal->number_of_days;
                $obj->renewal_status = 'Y';
            }
        }

        return $obj;
    }
    /****** End Surveillance Renewal ****/

        /****** Start SuperAdmin ***/
    function calculateTimeDateSuperAdminPendingApplication($app) {
        $application_time = DB::table('tbl_application_time')
        // ->whereNotIn('user_type',['admin'])
        ->get();

        // dd($application_time);
        $application_payment = DB::table('tbl_application_payment')->whereNull('deleted_at')->where([
            'application_id' => $app->id,
            'pay_status'=>'Y'
        ])->latest()->first();
        $arr = [];

        foreach($application_time as $app_time){
        $obj = new \stdclass;
        if($application_time){
            $now = time();
            /**Start-- Extra Day Assign By Admin */
            $assignDayTime =  strtotime($app->assign_day_for_verify_date) - $now;
            $assigndayscount = round($assignDayTime/ (60 * 60 * 24));
            
            if($app->assign_day_for_verify >= $assigndayscount){
                $assignDayVerifys = (int)($app->assign_day_for_verify);
            }else{
                $assignDayVerifys =0;
            }
            /**End-- Extra Day Assign By Admin */

            if($app_time->user_action =="recieved_document_same_assign_date"){
                $created_at = DB::table('tbl_assessor_assign')->where('application_id',$app->id)->first()?->created_at;
            }
            else if($app_time->user_action=="assign_secretariat"){
                $created_at = DB::table('tbl_secretariat_assign')->where(['application_id'=>$app->id])->first()?->created_at;
            }
            else{
                $created_at = $app->created_at;
            }

            $dayTime = $now - strtotime($created_at);
            $dayscount = round($dayTime/ (60 * 60 * 24));
            if($app_time->number_of_days >= $dayscount && $application_payment->status==2){
                $applicationTime = (int)($app_time->number_of_days-$dayscount);
            }else{
                $applicationTime =0;
            }
            if($applicationTime == 0){
                if($assignDayVerifys>0){
                    $obj->applicationAction = 'Y';
                    $obj->applicationDayTime =$assignDayVerifys;
                }else{
                    $obj->applicationAction = 'N';
                    $obj->applicationDayTime =0;
                }
            }else{
                $obj->applicationAction = 'Y';
                $obj->applicationDayTime =$applicationTime;
            }
        }
        $arr[] = $obj;
        // return $obj;
    }
    
    return $arr;

    }
}