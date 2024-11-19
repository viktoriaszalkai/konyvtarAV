<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new Reservation();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id, $book_id, $start)
    {
        $reservation = Reservation::where('user_id', $user_id)
        ->where('book_id', $book_id)
        ->where('start', $start)
        //listát ad vissza:
        ->get();
        return $reservation[0];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id, $book_id, $start)
    {
        $record = $this->show($user_id, $book_id, $start);
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id, $book_id, $start)
    {
        $this->show($user_id, $book_id, $start)->delete();
    }
    //speciális lekérdezések
    public function reservedBooks(){
        $user = Auth::user();
        return Reservation::with('books')
        ->where('user_id', '=',$user->id)
        ->get();
    }

}
