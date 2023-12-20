<?php

namespace App\Http\Controllers\Api;

use App\Models\BooksModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Books extends Controller
{
    public function index()
{
    $books = BooksModel::all();

    if ($books->count() > 0) {
        foreach ($books as $book) {
            // Remove base64 encoding and provide the image URL
        }

        $data = [
            'status' => 200,
            'books' => $books,
        ];

        return response()->json($data, 200);
    } else {
        $data = [
            'status' => 404,
            'message' => 'No records found',
        ];

        return response()->json($data, 404);
    }

}


    public function store(Request $request)
    {

    // Validate the incoming request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:200',
        'publisher' => 'required|max:50',
        'isbn' => 'string|max:50',
        'category' => 'max:100',
        'sub_category' => 'max:100',
        'description' => 'required',
        'image' => '', // Adjust the allowed image types and maximum size as needed
        'added_by' => 'max:11',
        'pages' => 'max:11',
    ]);

    // Check for validation errors
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Process the valid request data
    try {
        // Handle file upload


        // Create a new book record in the database
        $book = new BooksModel([
            'name' => $request->input('name'),
            'publisher' => $request->input('publisher'),
            'isbn' => $request->input('isbn'),
            'category' => $request->input('category'),
            'sub_category' => $request->input('sub_category'),
            'description' => $request->input('description'),
            'image' => $request->input('image'),
            'added_by' => $request->input('added_by'),
            'pages' => $request->input('pages'),
        ]);

        // Save the book record
        $book->save();

        // Return a success response
        return response()->json([
            'status' => 200,
            'message' => 'Book added successfully',
            'book' => $book, // Include the book information in the response
        ], 200);
    } catch (\Exception $e) {
        // Handle any exceptions
        return response()->json([
            'status' => 500,
            'message' => 'Error processing the request',
        ], 500);
    }
}


    public function destroy($id)
    {
        $book = BooksModel::find($id);
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
        $book = BooksModel::find($id);
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

    public function show($id)
    {
        $book = BooksModel::find($id);

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
