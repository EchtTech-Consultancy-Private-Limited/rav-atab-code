<?php

return [
    'tp' =>['status'=>'Payment Pending','uploadDocs'=>"Please upload  all the documents of the application",'secondPay'=>"Please pay second payment for onsite assessor"],
    
    'accountant' =>['appCreated'=>'New Application Created',"doneSecPay"=>"Second Payment Done successfully."],
    
    'secretariat' =>['assigned'=>'A new application assigned to you.','sendApproval'=>'Application sent for approval','sec_pay'=>'Second payment done for onsite assessor'],
    
    'admin' =>['paymentApprove'=>'Payment Approved by Accountant.','acceptCourseDoc'=>'All docs accepted of courses.','acceptApplication'=>'Application Accepted','rejectApplication'=>'Application Rejected','approvedApplication'=>'Application Approved','desktopAssigned'=>'Secretariat assigned new application to desktop assessor','onsiteAssigned'=>'Secretariat assigned new application to onsite assessor'],

    'assessor_desktop' =>['assigned'=>'A new application assigned to you.','summary'=>'Desktop Assessor created final summary'],

    'assessor_onsite' =>['assigned'=>'A new application assigned to you.','summary'=>'Onsite Assessor created final summary'],
    
    'common'=>['nc'=>'There are nc on application documents','upload'=>'Documents uploaded against nc','appApproved'=>'Application Completed successfully.','appRejected'=>'Application rejected.','additionalPay'=>'Additional Payment Query Raised'],
    
    'tpUrl'=>[
        'level1'=>"/tp/application-view/",
        'level2'=>'/upgrade/tp/application-view/',
        'level3'=>'/upgrade/level-3/tp/application-view/',
        'level'=>'/tp/application-payment-fee-list'
    ],

    
    'tpPaymentUrl'=>[
        'level1'=>"/show-course-payment/",
        'level2'=>'/upgrade-show-course-payment/',
        'level3'=>'/makepayment/'
    ],
    'secretariatUrl'=>[
        'level1'=>"/admin/application-view/",
        'level2'=>'/admin/application-view-level-2/',
        'level3'=>'/admin/application-view-level-3/'
    ],
    'adminUrl'=>[
        'level1'=>"/super-admin/application-view/",
        'level'=>"/super-admin/payment-fee-list"
    ],
    'accountantUrl'=>[
        'level1'=>"/account/application-view/",
    ],
    'desktopUrl'=>[
        'level1'=>"/desktop/application-view/",
    ],
    'onsiteUrl'=>[
        'level1'=>"/onsite/application-view/",
    ],
    
];
