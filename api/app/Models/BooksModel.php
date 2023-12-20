<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksModel extends Model
{
    use HasFactory;
    protected $table='test';
    protected $fillable =[
'name',
'publisher',
'isbn',
'category',
'sub_category',
'description',
'pages',
'image',
'added_by',
'book_id',
'extended',
'extension_date',
'penalty_amount',
'penalty_status',
'status',
'user_id',
'loan_date',
'return_date',
    ];
}
