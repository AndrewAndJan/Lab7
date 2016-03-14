<div class="container">
    <div class="row">
        <div class="col-lg-12 col-md-12" style="text-align: center;">
            <form action="/result" method="post">
                {daysSearch}
                {periodSearch}
                <button type="submit">search</button>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4 col-md-4">
            <h2>Days</h2>
            {daysofweek}
                Day: {day} <br/>
                Time: {time} <br/>
                Time End: {timeEnd} <br/>
                Course: {course} <br/>
                Type: {type} <br/>
                Instructor: {instructor} <br/>
                Building: {building} {room}<br/>
                <br />
            {/daysofweek}
        </div>
        
        <div class="col-lg-4 col-md-4">
            <h2>Courses</h2>
            {courses}
                Day: {day} <br/>
                Time: {time} <br/>
                Time End: {timeEnd} <br/>
                Course: {course} <br/>
                Type: {type} <br/>
                Instructor: {instructor} <br/>
                Building: {building} {room}<br/>
                <br />
            {/courses}
        </div>
        
        <div class="col-lg-4 col-md-4">
            <h2>Periods</h2>
            {periods}
                Day: {day} <br/>
                Time: {time} <br/>
                Time End: {timeEnd} <br/>
                Course: {course} <br/>
                Type: {type} <br/>
                Instructor: {instructor} <br/>
                Building: {building} {room}<br/>
                <br />
            {/periods}
        </div>
        
    </div>
</div>
