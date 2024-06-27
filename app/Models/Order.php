<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'client_name',
        'client_phone',
        'client_address',
        'client_flat_number',
        'status',
        'technician_id'
    ];

    public function invoiceItems()
    {
        return $this->hasMany(OrderInvoice::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class);
    }

    public function notes()
    {
        return $this->hasMany(OrderNote::class);
    }

}
