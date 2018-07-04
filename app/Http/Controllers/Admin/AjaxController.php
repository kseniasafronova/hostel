<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DateTime;

class AjaxController extends Controller
{
    public function showBookingTable(Request $request) {
       
        $places = DB::table('places')
        ->join('rooms', 'rooms.id', '=', 'places.room_id')
        ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
        ->select(DB::raw ('places.id, places.number as place_no ,rooms.number as room_no, room_types.place_count'))
        ->get();

        $month = $request->m;
        $year = $request->y;

        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $first_day_in_month = new DateTime($year.'/'.$month.'/1');
        $last_day_in_month = new DateTime($year.'/'.$month.'/'.$days_in_month);

        $bookings = DB::table('bookings')
        ->join('orders', 'orders.id', '=', 'bookings.order_id')
        ->where([['date_in', '>=', $first_day_in_month->format('Y/m/d')], ['date_out', '<=', $last_day_in_month->format('Y/m/d')]])
        ->select(DB::raw ('bookings.place_id, bookings.date_in, bookings.date_out, orders.booking_status as status'))
        ->get();

        $response = array('month'=> $month, 'year'=> $year, 'places'=> $places, 'bookings'=> $bookings);
        return response()->json($response);
    }
}
