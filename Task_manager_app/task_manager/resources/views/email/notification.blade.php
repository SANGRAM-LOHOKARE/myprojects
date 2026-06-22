{{$data ->task_owner }},<br><br>
The task {{ $data ->task_description }} ,<br><br>{{$data->task_status == 0?"has been assigned to you.":"marked as completed"}}<br><br>
@if($data->task_status != 0)
    kindly complete within {{ $data ->task_eta }}.<br><br>
@endif
Thankyou