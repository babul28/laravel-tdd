<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckinBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Book $book)
    {
        try {
            $book->checkin(Auth::user());
        } catch (\Exception $e) {
            return abort(404);
        }
    }
}