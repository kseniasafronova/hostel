@extends('layouts.app')

@section('content')
    <table>
        <tr>
            <th>Room Number</th>
            <th>Places Count</th>
            <th>Price</th>
        </tr>
        @foreach ($prices as $price)
            <tr>
                <td>{{$price->number}}</td>
                <td>{{$price->place_count}}</td>
                <td>{{$price->price}}</td>
            </tr>
         @endforeach
    </table>
@stop