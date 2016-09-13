<script>
    function Calendar(){
        this.clear();
        
        this.addDateTags();
        this.addDays();
    }
    
    Calendar.prototype = {
        clear:function(){
            $('.c_box .c_dates','#calendar').empty();
        },
        addDateTags:function(){
            $('.c_box .c_dates','#calendar').append("<div class='c_row date_tags'>"
                                                +"<div class='c_day_name'>Mon</div>"
                                                +"<div class='c_day_name'>Tue</div>"
                                                +"<div class='c_day_name'>Wed</div>"
                                                +"<div class='c_day_name'>Thu</div>"
                                                +"<div class='c_day_name'>Fri</div>"
                                                +"<div class='c_day_name'>Sat</div>"
                                                +"<div class='c_day_name'>Sun</div>"
                                            +"</div>");
        },
        addDays:function(){
            for(var i=0;i<6; i++ ){
                $('.c_box .c_dates','#calendar').append("<div class='c_row'>"
                                                        +"<div class='c_day'>1</div>"
                                                        +"<div class='c_day'>2</div>"
                                                        +"<div class='c_day'>3</div>"
                                                        +"<div class='c_day'>4</div>"
                                                        +"<div class='c_day'>5</div>"
                                                        +"<div class='c_day'>6</div>"
                                                        +"<div class='c_day'>7</div>"
                                                    +   "</div>");
            }
        }
    }
</script>

<script>
    $('document').ready(function(){
        var cal = new Calendar();
    });
</script>

<style>
    #calendar{
        
        text-align: center;
    }
    
    .c_box{
        padding:10px;
        margin:auto;
        border: 1px solid #c6c6c6;
        width:500px;
        height:500px;
    }
    .c_dates{
            width: 100%;        
            height:94%;
            display:table;
    }
    .c_row{
        width:100%;        
        display:table-row;
        clear:both;
    }
    .c_row .c_day_name{
        vertical-align: middle;        
        display:table-cell;
        text-align: center;
    }
    .c_row .c_day{
        cursor:pointer;
        vertical-align: middle;        
        display:table-cell;
        text-align: center;
    }
    .header{
        text-align: center;
        height:6%;
    }
    .header .current_date{
        outline : 1px solid red;
        width:100%;
        display:block;
        margin:auto;
        text-align: center;
    }
    .date_tags{
        height:30px;
    }
    .date_tags .c_day_name{
        font-size:10px;
        border-bottom: 1px solid #c6c6c6;
    }
</style>
<div class="container">
    <div id="calendar">        
        <div class="c_box">
            <div class='header'>April 2016</div>
            <div class='c_dates'>
               
            </div>
        </div>
    </div>
</div>