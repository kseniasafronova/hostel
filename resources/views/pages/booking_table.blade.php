@extends ('layouts.app')
@php 
    $months = ["январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "декабрь"];
@endphp

@section('meta')
    @parent
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')

    <label for="month-select">Месяц:</label>
    <select class="form-control" id="month-select">
        @php 
            $month = date("n");
            $year = date("Y"); 


            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        @endphp
        @for ($i=0; $i<3; $i++)
    <option data-y = {{$year}} data-m = {{$month}} @php if ($i===0 ) echo "selected"; @endphp>{{$months[$month-1]}}</option>
            @php 
                if($month < 12) $month++;
                else 
                {
                    $month = 1;
                    $year++;
                }
            @endphp
        @endfor
    </select>

    <div id="booking-table"></div>
@stop

@section('scripts')
    @parent
    <script>
        function findObjectsInArrayByProperty(arr, propertyName, value) {
            var objects = [];
            arr.forEach(function(item) {
                if(item[propertyName] === value) {
                    objects.push(item) ;
                }
            });
            return objects;
        }

        function addBookingStatusClass (status, element) {
            if(status === 0) {
                $(element).addClass('pre-booking');
            }
            else {
                $(element).addClass('confirmed-booking');
            }
        }



        function showBookingTable(data) {
            $('#booking-table').empty();

            var table = document.createElement('table');
            $('#booking-table').append(table);

            $(table).html("<thead><th>Место</th><th>Комната</th><th>Кол-во мест</th></thead><tbody></tbody>");


            var days_in_month = 32 - new Date(data.year, data.month-1, 32).getDate();
            
            for(var i=0; i<days_in_month; i++) {
                $('#booking-table thead tr:first-child').append('<th style="width: 20px;">'+(i+1)+'</th>');
            }
           
            for(var i=0; i<data.places.length; i++) {
                var row = document.createElement('tr');

                var query = findObjectsInArrayByProperty(data.bookings, 'place_id', data.places[i].id);
                
                $(row).append('<td>'+ data.places[i].place_no +'</td>');
                $(row).append('<td>'+ data.places[i].room_no +'</td>');
                $(row).append('<td>'+ data.places[i].place_count +'</td>');
                for(var j=0; j<days_in_month; j++) {
                    var td = document.createElement('td');
                    $(td).addClass('date-td');
                    query.forEach(function(item){
                        var date_in = parseInt(item.date_in.substring(8));
                        var date_out = parseInt(item.date_out.substring(8));
                        var status = item.status;

                        if(j+1>=date_in && j+1<=date_out) {
                            if(j+1===date_in) {
                                var right_triangle = document.createElement('div');
                                $(right_triangle).addClass('booking-date-in');
                                addBookingStatusClass(status, right_triangle);
                                $(td).append(right_triangle);
                            }
                            else if(j+1===date_out) {
                                var left_triangle = document.createElement('div');
                                $(left_triangle).addClass('booking-date-out');
                                addBookingStatusClass(status, left_triangle);
                                $(td).append(left_triangle);
                            }
                            else {
                                $(td).addClass('booking-date-in-range')
                                addBookingStatusClass(status, td);
                            }

                            
                        }
                    });
                    $(row).append(td);
                }
                $('#booking-table tbody').append(row);
            }
        }



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function selectMonth(year, month) {
            $.ajax(
                {
                    method: 'POST',
                    url: '/admin/bookingtable' ,
                    data: {y: year, m: month},
                    dataType: 'json',
                    success: function(response) {
                        showBookingTable(response);
                    }
                }   
            );
        }



        $(function() {
            $('#month-select').on('change' , function() {
                selectMonth($('#month-select :selected').attr('data-y'), $('#month-select :selected').attr('data-m'));
            });

            selectMonth(new Date().getFullYear(), new Date().getMonth()+1); // в js месяцы отсчитываются с нуля
        });
    </script>
@stop