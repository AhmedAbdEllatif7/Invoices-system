<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Interfaces\Notifications\NotificationsRepositoryInterface;
use Illuminate\Http\Request;


class NotificationController extends Controller
{

    private $notificationsRepository;

    public function __construct(NotificationsRepositoryInterface $notificationsRepository){
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:الاشعارات');

        $this->notificationsRepository = $notificationsRepository;
    }






    
    public function viewNotificationInvoice()
    {
        return $this->notificationsRepository->viewNotificationInvoice();
    }
    
    



    public function readAllNotification()
    {
        return $this->notificationsRepository->readAllNotification();
    }



    public function viewReadNotificationInvoice()
    {
        return $this->notificationsRepository->viewReadNotificationInvoice();
    }
    


    public function deleteSelectedNotifications(Request $request)
    {
        return $this->notificationsRepository->deleteSelectedNotifications($request);
    }
    
}
