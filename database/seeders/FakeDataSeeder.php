<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Hash;
use App\Models\Level;
use App\Models\LevelRule;
use App\Models\Application;
use App\Models\ApplicationCourse;
use App\Models\ApplicationPayment;
use App\Models\ApplicationAcknowledgement;
use App\Models\ApplicationDocument;
use App\Models\DocumentType;
use App\Models\ApplicationReport;


class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        /*$user = User::create(['title' => 'Mr.','firstname' => 'Satish','email' => 'satish@gmail.com','mobile_no' => '9999999991','password' => Hash::make('admin@123'),'role' => 1,'status' => 1]);
        $user = User::create(['title' => 'Mr.','firstname' => 'demo1','email' => 'demo1@gmail.com','mobile_no' => '9999999992','password' => Hash::make('admin@123'),'role' => 2,'status' => 1]);
        $user = User::create(['title' => 'Mr.','firstname' => 'demo2','email' => 'demo2@gmail.com','mobile_no' => '9999999993','password' => Hash::make('admin@123'),'role' => 2,'status' => 1]);
        $user = User::create(['title' => 'Mr.','firstname' => 'demo3','email' => 'demo3@gmail.com','mobile_no' => '9999999994','password' => Hash::make('admin@123'),'role' => 2,'status' => 1]);
        $user = User::create(['title' => 'Mr.','firstname' => 'demo4','email' => 'demo4@gmail.com','mobile_no' => '9999999995','password' => Hash::make('admin@123'),'role' => 2,'status' => 1]);
        $user = User::create(['title' => 'Mr.','firstname' => 'demo5','email' => 'demo5@gmail.com','mobile_no' => '9999999996','password' => Hash::make('admin@123'),'role' => 2,'status' => 1]);
        $user = User::create(['title' => 'Mr.','firstname' => 'demo6','email' => 'demo6@gmail.com','mobile_no' => '9999999997','password' => Hash::make('admin@123'),'role' => 2,'status' => 1]);
        $user = User::create(['title' => 'Mr.','firstname' => 'demo7','email' => 'demo7@gmail.com','mobile_no' => '9999999998','password' => Hash::make('admin@123'),'role' => 2,'status' => 1]);
        $user = User::create(['title' => 'Mr.','firstname' => 'demo8','email' => 'demo8@gmail.com','mobile_no' => '9999999999','password' => Hash::make('admin@123'),'role' => 2,'status' => 1]);
        $user = User::create(['title' => 'Mr.','firstname' => 'demo9','email' => 'demo9@gmail.com','mobile_no' => '9999999990','password' => Hash::make('admin@123'),'role' => 2,'status' => 1]);
*/

        $Level=Level::create(['name' => 'Level 1','status' => 1]);
        $LevelRule=LevelRule::create(['level_id'=>$Level->id, 'name'=>$Level->name, 'rule_type'=>'1', 'fee_duration'=>'12', 'course_criteria_more_than'=>'0', 'course_criteria_less_than_equal'=>'5', 'fee_india'=>'1000', 'fee_saarc'=>'15', 'fee_rest_world'=>'50', 'status'=>'1']);
        $LevelRule=LevelRule::create(['level_id'=>$Level->id, 'name'=>$Level->name, 'rule_type'=>'1', 'fee_duration'=>'12', 'course_criteria_more_than'=>'5', 'course_criteria_less_than_equal'=>'10', 'fee_india'=>'2000', 'fee_saarc'=>'30', 'fee_rest_world'=>'100', 'status'=>'1']);
        $LevelRule=LevelRule::create(['level_id'=>$Level->id, 'name'=>$Level->name, 'rule_type'=>'1', 'fee_duration'=>'12', 'course_criteria_more_than'=>'10', 'course_criteria_less_than_equal'=>'0', 'fee_india'=>'3000', 'fee_saarc'=>'45', 'fee_rest_world'=>'150', 'status'=>'1']);

        /*$Level=Level::create(['name' => 'Level 2','status' => 1]);
        $LevelRule=LevelRule::create(['level_id'=>$Level->id, 'name'=>$Level->name, 'rule_type'=>'1', 'fee_duration'=>'12', 'course_criteria_more_than'=>'0', 'course_criteria_less_than_equal'=>'5', 'fee_india'=>'2500', 'fee_saarc'=>'4022', 'fee_rest_world'=>'100', 'status'=>'1']);
        $LevelRule=LevelRule::create(['level_id'=>$Level->id, 'name'=>$Level->name, 'rule_type'=>'1', 'fee_duration'=>'12', 'course_criteria_more_than'=>'5', 'course_criteria_less_than_equal'=>'10', 'fee_india'=>'5000', 'fee_saarc'=>'75', 'fee_rest_world'=>'200', 'status'=>'1']);
        $LevelRule=LevelRule::create(['level_id'=>$Level->id, 'name'=>$Level->name, 'rule_type'=>'1', 'fee_duration'=>'12', 'course_criteria_more_than'=>'10', 'course_criteria_less_than_equal'=>'0', 'fee_india'=>'10000', 'fee_saarc'=>'150', 'fee_rest_world'=>'400', 'status'=>'1']);

        $Level=Level::create(['name' => 'Level 3','status' => 1]);
        $LevelRule=LevelRule::create(['level_id'=>$Level->id, 'name'=>$Level->name, 'rule_type'=>'1', 'fee_duration'=>'36', 'course_criteria_more_than'=>'0', 'course_criteria_less_than_equal'=>'5', 'fee_india'=>'25000', 'fee_saarc'=>'350', 'fee_rest_world'=>'1000', 'status'=>'1']);
        $LevelRule=LevelRule::create(['level_id'=>$Level->id, 'name'=>$Level->name, 'rule_type'=>'1', 'fee_duration'=>'36', 'course_criteria_more_than'=>'5', 'course_criteria_less_than_equal'=>'10', 'fee_india'=>'35000', 'fee_saarc'=>'475', 'fee_rest_world'=>'1500', 'status'=>'1']);
        $LevelRule=LevelRule::create(['level_id'=>$Level->id, 'name'=>$Level->name, 'rule_type'=>'1', 'fee_duration'=>'36', 'course_criteria_more_than'=>'10', 'course_criteria_less_than_equal'=>'0', 'fee_india'=>'50000', 'fee_saarc'=>'675', 'fee_rest_world'=>'2000', 'status'=>'1']);
        */
    $user_id=2;
        $Application=Application::create(['application_no'=>'400001', 'level_id'=>$Level->id, 'user_id'=>$user_id, 'name'=>'Satish', 'organization'=>'Echttech', 'designation'=>'Cordinator', 'email'=>'satish@gmail.com', 'website'=>'http://www.echttech.com', 'phone_no'=>'0120797979', 'address'=>'Noida', 'city'=>'133230', 'state'=>'4022', 'country'=>'101', 'postal'=>'201306', 'ip'=>'', 'status'=>1]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'2000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665443', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);

    $user_id=3;
        $Application=Application::create(['application_no'=>'400002', 'level_id'=>$Level->id, 'user_id'=>'3', 'name'=>'David', 'organization'=>'Demo', 'designation'=>'Cordinator', 'email'=>'aaa@gmail.com', 'website'=>'http://www.demo.com', 'phone_no'=>'0120797979', 'address'=>'Dambulla', 'city'=>'66463', 'state'=>'2798', 'country'=>'208', 'postal'=>'201306', 'ip'=>'', 'status'=>1]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'1000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665444', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);


    $user_id=4;
        $Application=Application::create(['application_no'=>'400003', 'level_id'=>$Level->id, 'user_id'=>'4', 'name'=>'Daksh', 'organization'=>'Demo', 'designation'=>'Cordinator', 'email'=>'bbb@gmail.com', 'website'=>'http://www.demo.com', 'phone_no'=>'0120797979', 'address'=>'Dambulla', 'city'=>'133230', 'state'=>'4022', 'country'=>'101', 'postal'=>'201306', 'ip'=>'', 'status'=>2]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'1000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665445', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);


    $user_id=5;
        $Application=Application::create(['application_no'=>'400004', 'level_id'=>$Level->id, 'user_id'=>'5', 'name'=>'Rohit', 'organization'=>'Demo', 'designation'=>'Cordinator', 'email'=>'ccc@gmail.com', 'website'=>'http://www.demo.com', 'phone_no'=>'0120797979', 'address'=>'California', 'city'=>'113217', 'state'=>'1422', 'country'=>'233', 'postal'=>'201306', 'ip'=>'', 'status'=>1]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'1000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665446', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);

    $user_id=6;
        $Application=Application::create(['application_no'=>'400005', 'level_id'=>$Level->id, 'user_id'=>'6', 'name'=>'Mike', 'organization'=>'Demo', 'designation'=>'Cordinator', 'email'=>'ddd@gmail.com', 'website'=>'http://www.demo.com', 'phone_no'=>'0120797979', 'address'=>'California', 'city'=>'113217', 'state'=>'1422', 'country'=>'233', 'postal'=>'201306', 'ip'=>'', 'status'=>0]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'1000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665447', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);

    $user_id=7;
        $Application=Application::create(['application_no'=>'400006', 'level_id'=>$Level->id, 'user_id'=>'7', 'name'=>'Sandy', 'organization'=>'Demo', 'designation'=>'Cordinator', 'email'=>'eee@gmail.com', 'website'=>'http://www.demo.com', 'phone_no'=>'0120797979', 'address'=>'California', 'city'=>'113217', 'state'=>'1422', 'country'=>'233', 'postal'=>'201306', 'ip'=>'', 'status'=>0]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'1000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665448', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);

    $user_id=8;
        $Application=Application::create(['application_no'=>'400007', 'level_id'=>$Level->id, 'user_id'=>'8', 'name'=>'Loin', 'organization'=>'Demo', 'designation'=>'Cordinator', 'email'=>'fff@gmail.com', 'website'=>'http://www.demo.com', 'phone_no'=>'0120797979', 'address'=>'Noida', 'city'=>'133230', 'state'=>'4022', 'country'=>'101', 'postal'=>'201306', 'ip'=>'', 'status'=>1]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'1000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665449', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);

    $user_id=9;
        $Application=Application::create(['application_no'=>'400008', 'level_id'=>$Level->id, 'user_id'=>'9', 'name'=>'Rowart', 'organization'=>'Demo', 'designation'=>'Cordinator', 'email'=>'ggg@gmail.com', 'website'=>'http://www.demo.com', 'phone_no'=>'0120797979', 'address'=>'Noida', 'city'=>'133230', 'state'=>'4022', 'country'=>'101', 'postal'=>'201306', 'ip'=>'', 'status'=>0]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'1000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665450', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);

    $user_id=10;
        $Application=Application::create(['application_no'=>'400009', 'level_id'=>$Level->id, 'user_id'=>'10', 'name'=>'Pankaj', 'organization'=>'Demo', 'designation'=>'Cordinator', 'email'=>'hhh@gmail.com', 'website'=>'http://www.demo.com', 'phone_no'=>'0120797979', 'address'=>'Noida', 'city'=>'133230', 'state'=>'4022', 'country'=>'101', 'postal'=>'201306', 'ip'=>'', 'status'=>1]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'1000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665451', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);

        $user_id=11;
        $Application=Application::create(['application_no'=>'400010', 'level_id'=>$Level->id, 'user_id'=>'2', 'name'=>'Satish', 'organization'=>'Demo', 'designation'=>'Cordinator', 'email'=>'satish@gmail.com', 'website'=>'http://www.echttech.com', 'phone_no'=>'0120797979', 'address'=>'Noida', 'city'=>'133230', 'state'=>'4022', 'country'=>'101', 'postal'=>'201306', 'ip'=>'', 'status'=>0]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 1', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 2', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 3', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 4', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);
        $ApplicationCourse=ApplicationCourse::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'course_id'=>'0', 'user_id'=>$user_id, 'course_name'=>'Course 5', 'course_duration'=>'12', 'eligibility'=>'yes', 'mode_of_course'=>'n/a', 'course_brief'=>'n/a', 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360))]);

        $ApplicationPayment=ApplicationPayment::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'amount'=>'1000', 'payment_date'=>date("Y-m-d"), 'payment_details'=>'Payment ID: TM788665452', 'payment_details_file'=>'' , 'valid_from'=>date("Y-m-d"), 'valid_to'=>date("Y-m-d",time()+(86400*360)), 'status'=>1]);
        $ApplicationAcknowledgement=ApplicationAcknowledgement::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'subject'=>'Acknowledgement Letter', 'description'=>'Mr. your application has approved to upload documents, Please upload required documents', 'send_email_status'=>1]);
        $DocumentType=DocumentType::create(['name'=>'Ownership File']);
        $DocumentType=DocumentType::create(['name'=>'PAN']);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>1, 'document_file'=>'demo-doc.pdf', 'status'=>1]);
        $ApplicationDocument=ApplicationDocument::create(['application_id'=>$Application->id, 'level_id'=>$Level->id, 'user_id'=>$user_id, 'document_type_id'=>2, 'document_file'=>'demo2-doc.pdf', 'status'=>1]);



    }
}
