
   <form id="room-search"  method="get" action="{{url('searchfreeplaces')}}">
        {{ csrf_field() }}
    
        <div class=" form-group">
            <span>Дата заезда:</span>
            <input name="dateIn" id="dateIn" type="hidden" required/>
            <div id="dateIn-button" class=" date-button btn btn-info d-flex">
                <svg class="calendar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 64h-48V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H160V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V160h352v298c0 3.3-2.7 6-6 6z"/>
                </svg>
                <span id="dateIn-value"></span>
                <i class="day-in-calendar-icon">+</i>
            </div>
        </div>

        <div class="form-group">
                <span>Дата выезда:</span>
                <input name="dateOut" id="dateOut" type="hidden" value="hello" required/>
                <div id="dateOut-button" class=" date-button btn btn-info d-flex">
                    <svg class="calendar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M400 64h-48V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H160V12c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v52H48C21.5 64 0 85.5 0 112v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48zm-6 400H54c-3.3 0-6-2.7-6-6V160h352v298c0 3.3-2.7 6-6 6z"/>
                    </svg>
                    <span id="dateOut-value"></span>
                    <i class="day-in-calendar-icon">+</i>
                </div>
        </div>

        

        <div class="form-group">
                <span>Количество гостей</span>
                <select name="guests-count" id="guests-count" class="form-control">
                    <option value="1">1</option>
                    <option value="2" selected>2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
        </div> 
    
    <button class="form-control btn btn-outline-dark" type="submit">Проверить варианты</button>
   </form>

  

