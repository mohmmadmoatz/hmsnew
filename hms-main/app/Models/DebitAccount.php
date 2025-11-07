<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitAccount extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $appends = ['balance'];

    // get balance attribute
    public function getBalanceAttribute()
    {

        $this->total_debit_iqd = DebitTransaction::where("account_id",$this->id)->where('payment_type', 2)->sum('amount_iqd');
        $this->total_debit_usd =DebitTransaction::where("account_id",$this->id)->where('payment_type', 2)->sum('amount_usd');

        $this->total_credit_iqd = DebitTransaction::where("account_id",$this->id)->where('payment_type', 1)->sum('amount_iqd');
        $this->total_credit_usd =DebitTransaction::where("account_id",$this->id)->where('payment_type', 1)->sum('amount_usd');

        $this->remaining_balance_iqd = $this->total_debit_iqd - $this->total_credit_iqd;
        $this->remaining_balance_usd = $this->total_debit_usd - $this->total_credit_usd;

        return number_format($this->remaining_balance_iqd,0) . " د.ع" . " | " . number_format($this->remaining_balance_usd,0) . " $";
        
    }
}
