<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    protected $table='test';
    protected $fillable =[
'name',
'book_id',
'extended',
'extension_date',
'penalty_amount',
'penalty_status',
'status',
'added_by',
'user_id',
'loan_date',
'return_date',
    ];
}
