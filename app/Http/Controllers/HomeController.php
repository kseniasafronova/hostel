<?php

namespace App\Http\Controllers;
use DB;
use DateTime;
use Illuminate\Http\Request;
use Date;

class HomeController extends Controller
{
    public function showPrices($month) {
        $prices = DB::table('rooms')
        ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
        ->join('prices', function ($join) use ($month) {
            $join->on( 'rooms.room_type_id', '=', 'prices.room_type_id')
            ->where('prices.month', $month);
        })
        ->select('rooms.number', 'room_types.place_count','prices.price')
        ->get();
        return view('pages.rooms_and_prices', ['prices'=>$prices]);
    }

    public function showBookingTable() {
        return view('pages.booking_table');
    }

    public function searchFreePlaces(Request $request) {

        // select rooms.number, count(places.room_id) 
        // from rooms left outer join places 
        // on places.room_id = rooms.id 
        // where places.id not in 
        // (select place_id from bookings 
        // where date_in between '2018-07-06' and '2018-07-13' 
        // or date_out between '2018-07-06' and '2018-07-13') 
        // group by places.room_id 

        // select count(*) from  places  
        // where id not in 
        // (select place_id from bookings 
        // where date_in between '2018-07-06' and '2018-07-13' 
        // or date_out between '2018-07-06' and '2018-07-13') 

        $free_places_count = DB::table('places')
        ->whereNotIn('id', function($q) use ($request)  {
            $q->select('place_id')->from('bookings')
            ->whereBetween('date_in', [$request->dateIn, $request->dateOut])
            ->orWhereBetween('date_out', [$request->dateIn, $request->dateOut]);
        })
        ->count();

        $places_by_rooms = DB::table('rooms')
        ->select('number', 'places_query.place_count')
        ->join(DB::raw('(select room_id, count(*) as place_count from places 
                        where places.id not in 
                          (select place_id from bookings 
                           where date_in between"'.$request->dateIn.'" and "'.$request->dateOut. 
                           '" or date_out between "'.$request->dateIn.'" and "'.$request->dateOut.'")   
                        group by room_id) places_query'), 
                function($join) {
                    $join->on('rooms.id', '=', 'places_query.room_id');
                })
        ->get();
        

        return view('pages.available', ['dateIn'=> $request->dateIn, 'dateOut'=> $request->dateOut, 'count_of_free'=> $free_places_count, 'places_by_rooms'=>$places_by_rooms]);
    }
}
