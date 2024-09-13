<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Transaction extends BaseModel
{
    use HasFactory;

    public function getByOrderId($orderId, $status = TransactionStatus::UN_PAID)
    {
        return$this->where('user_id', Auth::user()->id)->where('order_id', $orderId)->where('status', $status)->latest()->first();
    }
}
