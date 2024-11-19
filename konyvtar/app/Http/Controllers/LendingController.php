<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LendingController extends Controller
{
    //alapfüggvények

    public function index()
    {
        return Lending::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = new Lending();
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user_id, $copy_id, $start)
    {
        $lending = Lending::where('user_id', $user_id)
        ->where('copy_id', $copy_id)
        ->where('start', $start)
        //listát ad vissza:
        ->get();
        return $lending[0];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user_id, $copy_id, $start)
    {
        $record = $this->show($user_id, $copy_id, $start);
        $record->fill($request->all());
        $record->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user_id, $copy_id, $start)
    {
        $this->show($user_id, $copy_id, $start)->delete();
    }

    //lekérdezések
    public function lendingsFilterByUser(){
        $user = Auth::user();	//bejelentkezett felhasználó
        //copies: fg neve!!!
        return Lending::with('copies')
        ->where('user_id','=',$user->id)
        ->get();
    }

    //Milyen könyvek vannak nálam

    public function activeLendingsData(){
        $user = Auth::user();
        $lendings = DB::table("lendinds as l")
        ->join('copies as c','l.copy_id', '=', 'c.copy_id')
        ->join('books as b','b.book_id', '=', 'c.book_id')
        ->select('b.book_id', 'author','title')
        ->where('user_id',$user->id)
        ->whereNull("end")
        ->groupBy('b.book_id')
       // ->having(count('*')>2)
        ->get();
        return $lendings;
    }

}
