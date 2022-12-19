<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Attendances extends Model
{
    use HasFactory;

    public static function boot() {
        parent::boot();
        static::created(function($item) {
            $activity = new Activity();
            $activity->updated_by = auth()->user()->id;
            $activity->eloquent = "attendance";
            $activity->eloquent_id = "";
            $activity->change = "";
            $activity->create_or_update = 'update';
            $activity->save();
        });
    }

    public function getCreatedAtFormatedAttribute(){
        return  Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('M d Y \a\t h:i  A');
    }

    public function getUpdatedAtFormatedAttribute(){
        return  Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('M d Y \a\t h:i  A');
    }
}
