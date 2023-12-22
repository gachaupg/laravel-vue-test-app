<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BorrowController extends Controller
{
    public function index(){
        $books = Borrow::all();
        if ($books->count() > 0) {
            $data = [
                'status' => 200,
                'books' => $books,
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No record found',
            ];

            return response()->json($data, 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:200',
            'book_id' => 'required|max:50',
            'extended' => 'string|max:50',
            'extension_date' => 'max:100',
            'penalty_amount' => 'max:100',
            'penalty_status' => 'required',
            'status' => '', // Adjust image validation as needed
            'user_id' => 'max:11',
            'loan_date' => 'max:11',
            'return_date'=>'',
            'added_by'=>''
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors(),
            ], 400);
        } else {
            $book = Borrow::create($request->all());
            return response()->json([
                'status' => 200,
                'message'=>'data saved successfully',
                'book' => $book,
            ], 200);
        }
    }

    public function destroy($id)
    {
        $book = Borrow::find($id);
        if ($book->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'deleted succesfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'error when deleting',
            ], 400);
        }
    }

    public function update($id, Request $request)
    {
        $book = Borrow::find($id);
        if ($book->update($request->all())) {
            return response()->json([
                'status' => 200,
                'message' => 'updated succesfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'eroor when updating',
            ], 400);
        }
    }

    public function updatereturn($id, Request $request)
    {
        $book = Borrow::find($id);

        if ($book->update(['status' => true])) {
            return response()->json([
                'status' => 200,
                'message' => 'Updated successfully',
                'book'=> $book,
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Error when updating',
            ], 400);
        }
    }
    public function borrowstate($id, Request $request)
    {
        $book = Borrow::find($id);

        if ($book->update(['penalty_status' => true])) {
            return response()->json([
                'status' => 200,
                'message' => 'Updated successfully',
                'book'=> $book,
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Error when updating',
            ], 400);
        }
    }
    public function exstate($id, Request $request)
{
    $book = Borrow::find($id);

    if (!$book) {
        return response()->json([
            'status' => 404,
            'message' => 'Book not found',
        ], 404);
    }

    if ($book->update(['return_dates' => ''])) {
        return response()->json([
            'status' => 200,
            'message' => 'Updated successfully',
            'book' => $book,
        ], 200);
    } else {
        return response()->json([
            'status' => 400,
            'message' => 'Error when updating',
        ], 400);
    }
}
    public function show($id)
    {
        $book = Borrow::find($id);

        if ($book == null) {
            return response()->json([
                'status' => 404,
                'message' => 'No book found with the id',
            ], 404);
        } else {
            return response()->json([
                'status' => 200,
                'book' => $book,
            ], 200);
        }
    }


}



