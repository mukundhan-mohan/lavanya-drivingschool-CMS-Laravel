<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class Debit extends Model
{
    use HasFactory;
    
    public static function boot()
    {

        parent::boot();

        static::created(function ($item) {
           $ledger = new Ledger();
           $ledger->particulars = $item->details;
           $ledger->credit = "";
           $ledger->debit =  $item->debit;
           $ledger->save();

        });
    }

    public function getCreatedAtFormatedAttribute(){
        return  Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('M d Y \a\t h:i  A');
    }

    public function getUpdatedAtFormatedAttribute(){
        return  Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format('M d Y \a\t h:i  A');
    }
}
