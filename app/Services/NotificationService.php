<?php

namespace App\Services;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * manipulateInput
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return void
     */
    function SendNotification($senderId, $receiverId, $applicationId, $userType = null, $data = null)
    {
        try {
            DB::beginTransaction();
            $candidate = DB::table('notifications')->insert(
                [
                    'user_type' => $userType,
                    'sender_id' => $senderId,
                    'receiver_id' => $receiverId,
                    'application_id'   => $applicationId,
                    'is_read' => '0',
                    'data' => $data,
                ]
            );
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
}
