<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class LicenceEntries extends Model
{
    use HasFactory;

    public function getEnquiryFormatedAttribute(){
        return  Carbon::createFromFormat('Y-m-d H:i:s', $this->enquiry_date)->format('M d Y \a\t h:i  A');
    }

    public function getCreatedAtFormatedAttribute(){
        return  Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('M d Y \a\t h:i  A');
    }

    public function getUpdatedAtFormatedAttribute(){
        return  Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('M d Y \a\t h:i  A');
    }
}
