<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class StaffAttendances extends Model
{
    use HasFactory;

    public function tooltip($date , $id){
        $status = StaffAttendances::select('staff_attendances.attendance_status')->where("staff_attendances.attendance_date", $date)->where("staff_attendances.staff_id", $id)->first();
            return $status;
    }

    public function getCreatedAtFormatedAttribute(){
        return  Carbon::createFromFormat('Y-m-d', $this->attendance_date)->format('M d Y');
    }

    public function getUpdatedAtFormatedAttribute(){
        return  Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('M d Y \a\t h:i  A');
    }
}
