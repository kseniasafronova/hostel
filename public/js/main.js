function yyyymmdd(date) {         

    var yyyy = date.getFullYear().toString();                                    
    var mm = (date.getMonth()+1).toString(); // getMonth() is zero-based         
    var dd  = date.getDate().toString();             

    return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]);
};



function SetAndShowDate(id, date)
{
    var months = ["янв", "февр", "март", "апр", "мая", "июн", "июл", "авг", "сент", "окт" ,"ноя" ,"дек" ];
    $('#'+id).val(yyyymmdd(date));
    $('#'+id+'-value').html(date.getDate() + " " + months[date.getMonth()] + " " + date.getFullYear());
    $('#'+id + '-value + .day-in-calendar-icon').html(date.getDate());
}

function Calendar(date, from, to, prevButton, nextButton)
{
    var self = this;
    this.date = date;
    this.dateFrom = from;
    this.dateTo = to;
    this.dateToSelect=1;
    
    this.prev = prevButton;
    this.next = nextButton;

    
    
    this.InsertCalendar = function (element, year, month){
        var first_day = new Date(year, month, 1);
        var day_of_week = first_day.getDay();
        var today = new Date();
        
        var d = 1;
        var days_in_month = 32 - new Date(year, month, 32).getDate();
    
        $(element).empty(); //очищаем содержимое
        
        var row = document.createElement("tr");
        if(day_of_week == 0) {
            for (var i=1; i<=7; i++) {
            var cell = document.createElement("td");
            
            $(cell).addClass('dateday');
            if(i<7) {
                cell.innerText = "";
                $(cell).addClass('empty');
            }
            else {
                if(d < today.getDate() && month === today.getMonth() && year === today.getFullYear()) 
                {
                    $(cell).addClass('not-available');
                }
                else 
                {
                    var current = new Date(year, month, d);
                   
                    if(current.getTime() === self.dateFrom.getTime()){ 
                        $(cell).addClass('day-in');
                    }
                    else if (current.getTime() === self.dateTo.getTime()){
                        $(cell).addClass('day-out');
                    }
                    else if(current.getTime() > self.dateFrom.getTime() && current.getTime() < self.dateTo.getTime()) {
                        $(cell).addClass('day-in-range');
                    }
                }
                
                cell.innerText = d++;
                
                
            }
            
            row.appendChild(cell);
            } 
        
        }
        else {
            for (var i=1; i<=7; i++) {
            var cell = document.createElement("td");
            $(cell).addClass("dateday");

            if(i<day_of_week) {
                cell.innerText = "";
                $(cell).addClass('empty');
            }
            else {
                var current = new Date(year, month, d);
               
                if(current.getTime() === self.dateFrom.getTime()){ 
                    $(cell).addClass('day-in');
                }
                else if (current.getTime() === self.dateTo.getTime()){
                    $(cell).addClass('day-out');
                }
                else if(current.getTime() > self.dateFrom.getTime() && current.getTime() < self.dateTo.getTime()) {
                    $(cell).addClass('day-in-range');
                }
                else if(d < today.getDate() && month === today.getMonth() && year === today.getFullYear()) 
                {
                    $(cell).addClass('not-available');
                }
                cell.innerText = d++;
            }
            
           
            row.appendChild(cell);
            }
        }
        
        element.appendChild(row);
    
        for (var i=1; i<6; i++){
            var row = document.createElement("tr");
            for(var j=0; j<7; j++){
                var cell = document.createElement("td");
                $(cell).addClass("dateday");
                if(d<=days_in_month) {
                    var current = new Date(year, month, d);
                    
                    if(current.getTime() === self.dateFrom.getTime()){ 
                        $(cell).addClass('day-in');
                    }
                    else if (current.getTime() === self.dateTo.getTime()){
                        $(cell).addClass('day-out');
                    }
                    else if(current.getTime() > self.dateFrom.getTime() && current.getTime() < self.dateTo.getTime()) {
                        $(cell).addClass('day-in-range');
                    }
                    else if(d < today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        $(cell).addClass('not-available');
                    }
                    cell.innerText = d++;
                }
                else {
                    cell.innerText = "";
                    $(cell).addClass('empty');
                }
               
                
                row.appendChild(cell);
            }
            element.appendChild(row);
            if (d > days_in_month ) break;
        }
    }


    this.ShowCalendar = function(buttonId, header)
    {
        
        var today = new Date();
        var first_day_in_calendar = new Date(self.date.getTime()).setDate(1);
        if(first_day_in_calendar <= today) {
            $(self.prev).attr('disabled', 'true');
        }
        else {
            $(self.prev).removeAttr('disabled');
        }

        var months = ["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"];
        
        if(header !== undefined) {
            $('#calendar .calendar-header').html(header);
        }
        
        var month1 = self.date.getMonth();
        var year1 = self.date.getFullYear();

        var calendar_table = $('#calendar .calendar-month-1 tbody').get(0);
        
        
        self.InsertCalendar( calendar_table, year1, month1);

        var date2 = new Date(self.date.getTime());
        date2.setMonth(date2.getMonth()+1);

        var month2 = date2.getMonth();
        var year2 = date2.getFullYear();

        calendar_table = $('#calendar .calendar-month-2 tbody').get(0);
        
        self.InsertCalendar( calendar_table, year2, month2);

        $('#calendar .calendar-month-1 .month-name').html(months[month1] + " " + year1);
        $('#calendar .calendar-month-2 .month-name').html(months[month2] + " " + year2);

        if(header !== undefined) {
            var rect = $('#'+buttonId).get(0).getBoundingClientRect();
            $('#calendar').offset( {top: rect.bottom , left: rect.left });
            $('#calendar').css('visibility', 'visible');
        }

        self.CountNights(self.dateFrom, self.dateTo);

        $('#calendar td.dateday:not(.not-available):not(.empty)').hover(
            function(){
             var current_date = self.GetCurrentDate(this);
             
             if(self.dateToSelect == 1){
                var element_from = self.FindDateElement(self.dateFrom);
                if(element_from != null) {
                    $(element_from).removeClass('day-in');
                }
                $(this).addClass('day-in');

                $('#calendar .dateday:not(.not-available):not(.empty):not(.day-out)')
                  .each(function() {
                      var d = self.GetCurrentDate(this);
                      
                      if(d > current_date && d < self.dateTo) {
                          $(this).addClass('day-in-range');
                      }
                      else {
                        $(this).removeClass('day-in-range');
                        $(this).removeClass('day-in');
                      }
                  });

                  self.CountNights(current_date, self.dateTo);
             }
             else {
                var element_to = self.FindDateElement(self.dateTo);
                if(element_to != null) {
                    $(element_to).removeClass('day-out');
                }
                $(this).addClass('day-out');

                $('#calendar .dateday:not(.not-available):not(.empty):not(.day-in)')
                  .each(function() {
                      var d = self.GetCurrentDate(this);
                      
                      if(d > self.dateFrom  && d < current_date) {
                          $(this).addClass('day-in-range');
                      }
                      else {
                        $(this).removeClass('day-in-range');
                        $(this).removeClass('day-out');
                      }
                  });

                  self.CountNights(self.dateFrom, current_date);
             }
         }
     );
        
    }

    this.CountNights = function(dateIn, dateOut) {
        var days_of_week = ["Вс","Пн","Вт","Ср","Чт","Пт","Сб"];
        var text = "с " + days_of_week[dateIn.getDay()] + ", " + $('#dateIn-value').html() + 
        " до " + days_of_week[dateOut.getDay()] + ", " + $('#dateOut-value').html() + " (";

        var nights_count =  Math.round((dateOut.getTime() - dateIn.getTime())/1000/60/60/24);
        
        if (nights_count > 0) {
            if(nights_count === 1 || (nights_count%10 === 1 && nights_count>20) ) text += nights_count + " ночь)"; 
            else if( (nights_count>20 || nights_count <10) && (nights_count%10 === 2 || nights_count%10 === 3 || nights_count%10 === 4)) text += nights_count + " ночи)";
            else text += nights_count + " ночей)";
            $('#calendar .calendar-counter').html(text);
        }
        else {
            $('#calendar .calendar-counter').html("");
        }
    }

    this.ChangeMonth = function (value) {
       
        self.date.setMonth(self.date.getMonth() + value)
        self.ShowCalendar();
    }


    this.GetCurrentDate  = function (datedayElement) {
        var y = self.date.getFullYear();
        var day = parseInt($(datedayElement).html());
        var m;
        if($(datedayElement).parents('.calendar-month-1').length >0)
        {
            m = self.date.getMonth();
        }
        else {
            m = self.date.getMonth()+1;
        }
        return new Date(y, m, day);
    }

    this.FindDateElement = function(date) {
        var first_calendar_day = new Date(self.date.getTime());
        first_calendar_day.setDate(1);
       
        var last_calendar_day = new Date(self.date.getTime());
        last_calendar_day.setMonth(last_calendar_day.getMonth() + 1);
        var days_in_month2 = 32 - new Date(last_calendar_day.getFullYear(), last_calendar_day.getMonth(), 32).getDate();
        last_calendar_day.setDate(days_in_month2);
       
        if(date >= first_calendar_day && date <= last_calendar_day) {
            if(date.getMonth() === first_calendar_day.getMonth()) {
                return $('#calendar .calendar-month-1 .dateday[text="' + date.getDate() + '"]').first();
            }
            else {
                return $('#calendar .calendar-month-2 .dateday[text="' + date.getDate() + '"]').first();
            }
        }
        else return null;
    }
}

function HideCalendar()
{
    $('#calendar').css('visibility', 'hidden');
}





$(function() {
    
    var prevButton = $('#calendar .calendar-prev').first();
    var nextButton = $('#calendar .calendar-next').first();

    var d = new Date();
    d = new Date(d.getFullYear(), d.getMonth(), d.getDate());
    SetAndShowDate('dateIn', d);

    d.setDate(d.getDate()+1);
    SetAndShowDate('dateOut', d);

    var calendar = new Calendar(d, new Date($('#dateIn').val()), new Date($('#dateOut').val()), prevButton, nextButton);

    $('body').click(function() {
        if($('#calendar').css('visibility') === "visible") {
            HideCalendar();
        }
    });

    $('#dateIn-button').click(function(event) {
        if($('#calendar').css('visibility') === "hidden") {
            var date = new Date($('#dateIn').val());
            calendar.date = date;
            calendar.dateToSelect = 1;
            calendar.ShowCalendar('dateIn-button', 'Дата приезда');
            event.stopPropagation();
        }
    });

    $('#dateOut-button').click(function(event) {
        if($('#calendar').css('visibility') === "hidden") {
        var date = new Date($('#dateOut').val());
        calendar.date = date;
        calendar.dateToSelect = 2;
        calendar.ShowCalendar('dateOut-button',  'Дата отъезда');
        event.stopPropagation();
        }
    });

    $('#calendar .calendar-prev').click(function (event) {
        calendar.ChangeMonth(-1);
        event.stopPropagation();
    });
    $('#calendar .calendar-next').click(function (event) {
        calendar.ChangeMonth(1);
        event.stopPropagation();
    });

    $('#calendar').click(function(event) {
        event.stopPropagation();
    });

    $('#calendar' ).on('click','.dateday:not(.not-available):not(.empty)', function(){

        var d = calendar.GetCurrentDate(this);
        

        if(calendar.dateToSelect === 1) {
            SetAndShowDate('dateIn', d);
            calendar.dateFrom = new Date(d.getTime());
            if(d >= new Date($('#dateOut').val())) {
                d.setDate(d.getDate()+1);
                SetAndShowDate('dateOut', d);
                calendar.dateTo = new Date(d.getTime());
            }    
        }
        else {
            SetAndShowDate('dateOut', d);
            calendar.dateTo = new Date(d.getTime());
            if(d <= new Date($('#dateIn').val())) {
                d.setDate(d.getDate()-1);
                SetAndShowDate('dateIn', d);
                calendar.dateFrom = new Date(d.getTime());
            }
        }
        
        HideCalendar();
        
    });

    // $('#room-search').on('submit', function() {
    //     $.ajax ({
    //         type: "GET",
    //         url: '/searchfreeplaces',
    //         data: $('#room-search').serialize()
    //     });
    // });
});