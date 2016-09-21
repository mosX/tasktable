<script>
    function Calendar(obj){        
        this.parent = obj.parent;
        this.width = obj.width?obj.width:'500px';
        this.height = obj.height?obj.height:'500px';
        this.reservedDates = obj.reservedDates;
        
        
        $('#calendar .c_box').css({'width':this.width,'height':this.height});
                
        this.month_array = new Array('January','February','March','April','May','June',"July",'August','September','October','November','December');
        this.short_tags_array = new Array('Mon','Tue','Wed','Thu','Fri','Sat',"Sun");
        
        if(obj.startDate){
            var d = new Date(obj.startDate);
        }else{
            var d = new Date();
        }
        this.month = d.getMonth();
        this.year = d.getYear()+1900;
        
        this.render();        
        
        this.actions();
    }
    
    Calendar.prototype = {
        prev:{},
        current:{},
        next:{},
        width:0,height:0,
        clear:function(){
            $('.c_box .c_dates',this.parent).empty();
        },
        
        render:function(){
            this.clear();
            //получаем количество дней
            this.current.total_days = new Date(this.year,this.month+1,0).getDate();

            this.current.first_day_of_week = new Date(this.year,this.month,1).getDay();
            this.current.first_day_of_week = this.current.first_day_of_week == 0?7:this.current.first_day_of_week;

            this.prev.total_days = new Date(this.year,this.month,0).getDate();

            this.setCurrentDate();

            this.addDateTags();
            this.addDays();
        },
        getFilledDatas:function(callback){            
            var self = this;
            
            $.ajax({
                url:'/manage/filled/?date='+self.year+'-'+(self.month+1)+'-01',
                type:'GET',
                success:function(msg){
                    self.reservedDates = JSON.parse(msg);
                    
                    callback();
                    
                }
            });
        },
        nextMonth:function(){
            var self = this;
            var d = new Date(this.year,this.month+1);
            this.month = d.getMonth();
            this.year = d.getYear()+1900;
            
            this.getFilledDatas(function(){self.render();});
        },
        
        prevMonth:function(){
            var self = this;
            var d = new Date(this.year,this.month-1);
            this.month = d.getMonth();
            this.year = d.getYear()+1900;
            
            this.getFilledDatas(function(){self.render();});
        },
        
        actions:function(){
            var self = this;
            
            $(this.parent).on('click','.prev_button,.c_day.prev',function(){
                self.prevMonth();
            });
            
            $(this.parent).on('click','.next_button,.c_day.next',function(){
                self.nextMonth();
            });
            
            $(this.parent).on('click','.c_day.current',function(){
                var day = $(this).text();
                
                if($('.c_box.online').length > 0){                
                    location.href = '/tasks/?year='+self.year+'&month='+(self.month+1)+'&day='+day;
                }
            });
        },
        
        setCurrentDate:function(){
            $('.c_box .current_date').text(this.month_array[this.month]+' '+this.year);
        },
        addDateTags:function(){
            var html = "<div class='c_row date_tags'>";
            
            for(var key in this.short_tags_array){
                html += "<div class='c_day_name'>"+this.short_tags_array[key]+"</div>";
            }
            html += '</div>';
            $('.c_box .c_dates',this.parent).append(html);
        },
        checkHoliday:function(year,month,day){
            var d = new Date(year,month,day);
            var dayOfWeek = d.getDay();
            
            if(dayOfWeek == 6 || dayOfWeek == 0){
                return 'holiday';
            }
            
            return '';
        },
        checkReservatedDays:function(year, month, day){
            var d;
            
            for(var key in this.reservedDates){
                d = new Date(this.reservedDates[key]*1000);
                
                if(day == d.getDate() && month == d.getMonth() && year == d.getYear()+1900){
                    return 'reserved';    
                }
            }
            /*if(day == 23){
                return 'reserved';
            }*/
            return '';
        },
        checkToday:function(year,month,day){
            var date = new Date();

            var m = date.getMonth();
            var y = date.getYear()+1900;
            var d = date.getDate();
            
            if(year == y && month == m && day == d){
                return 'today';
            }
            return '';
        },
        addDays:function(){
            var k=0;
            var grey = false;
            
            for(var i=0;i<6; i++ ){
                if(i==0){   //первая неделя с частью предыдущего месяца
                    
                    var html = "<div class='c_row'>";
                    if(this.current.first_day_of_week == 1){    //если первый день это понедельник то первоя строка это все прошлый месяц
                        for(var j=this.prev.total_days-6;j<=this.prev.total_days;j++){
                            html += "<div class='c_day prev'>"+j+"</div>";
                        }
                    }else{
                        //console.log(this.current.first_day_of_week);
                        var dayOfWeek = this.current.first_day_of_week;
                        
                        for(var j=this.prev.total_days-dayOfWeek+2;j<=this.prev.total_days;j++){                            
                            html += "<div class='c_day prev'>"+j+"</div>";
                        }
                        //console.log(dayOfWeek);
                        for(var j=dayOfWeek ; j <= 7;j++){
                            
                            html += "<div class='c_day current "+this.checkToday(this.year,this.month,k+1)+" "+this.checkHoliday(this.year,this.month,k+1)+"'>"+(++k)+"</div>";
                        }
                    }
                    
                    html +="</div>";
                    $('.c_box .c_dates',this.parent).append(html);
                    continue;
                }else{
                    var html = "<div class='c_row'>"                    
                    
                    for(var j=0;j<7;j++){                   
                        html += "<div class='c_day "+(grey?'next':"current "+this.checkToday(this.year,this.month,k+1)+" "+this.checkHoliday(this.year,this.month,k+1) +' '+this.checkReservatedDays(this.year,this.month,k+1))+"'>"+(++k)+"</div>";

                        if(k == this.current.total_days){   //определяем следующий месяц
                            grey = true;
                            k = 0;
                        }
                    }

                    html +="</div>";
                    $('.c_box .c_dates',this.parent).append(html);
                }
            }
        }
    }
</script>

<script>
    var reservedDates = new Array();
    <?php foreach($this->m->data as $item){ ?>
        reservedDates.push(<?=$item?>);
    <?php } ?>
    $('document').ready(function(){
        var cal = new Calendar({
            parent:'#calendar',
            //startDate:<?=strtotime(date("2016-05-01"))*1000?>,
            startDate:<?=strtotime(date())*1000?>,
            height:'500px',
            width:'500px',
            reservedDates:reservedDates
        });
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
        /*width:500px;
        height:500px;*/
        
    }
     .header{
         padding:0px 15px;
        position:relative;
        text-align: center;
        height:6%;
    }
    .c_box .prev_button{
        cursor:pointer;
        margin-top:5px;
        display:inline-block;
        vertical-align: middle;
        width:20px;
        height:20px;
        float:left;
        background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAALCAYAAACzkJeoAAAASUlEQVR42p2QMQoAQQgD79EZ0Mqn5xCu2cPdYgUbJ0rMMxXgLeiuKq8gsJAz8weQ0QiwJEfECnr4wdlEnwJ68+yyhReC+c85oRecj0Um+pmo9wAAAABJRU5ErkJggg==");
        background-repeat: no-repeat;
    }
    .c_box .next_button{
        cursor:pointer;
        margin-top:5px;
        display:inline-block;
        vertical-align: middle;
        width:20px;
        height:20px;
        float:right;
        background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAcAAAALCAYAAACzkJeoAAAARElEQVR42qXPsQoAIAhF0T76PdDJT7cUmtQhcmk4N8QVQ9JXN2bmgWOgqp+BiCRG2AYAMoi3/LxYdyagAnhA6G93TrABZaJFJjrFY8IAAAAASUVORK5CYII=");
        background-repeat: no-repeat;
    }
    .c_box .header .current_date{
        display:inline-block;
        vertical-align: middle;
        width:50%;
        margin:auto;
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
    .c_row .c_day.today{
        border-radius: 10px;
        background: rgba(103,183,255,0.5);
    }
    .c_row .c_day.holiday.reserved,.c_row .c_day.reserved{
        font-weight:bolder;
        color: red;
    }
    .c_row .c_day.holiday{
        font-weight:bolder;
        color: #3498db;
    }
    .c_row .c_day.prev,.c_row .c_day.next{
        
        color: #a6a6a6;
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
        <div class="c_box <?=$this->m->_user->id ? 'online':''?>">
            <div class='header'>
                <div class="prev_button"></div><div class="current_date">April 2016</div><div class="next_button"></div>
            </div>
            <div class='c_dates'>
               
            </div>
        </div>
    </div>
    
<?php if($this->m->currentTasks ){ ?>
     <?php 
        foreach($this->m->currentTasks as $item){ 
            
            $start = strtotime($item->start);
            $end = strtotime($item->end);
            
            $date = time();
            
            $data[] = array(strtotime(date("Y-m-d ".date("H",$start).":".date("i",$start).":00",$date)),strtotime(date("Y-m-d ".date("H",$end).":".date("i",$end).":00",$date)));    
        }
    ?>
    <script>
        $('document').ready(function(){
            var object = new Workload({
                parent:$('#canvas'),
                start_day:<?=strtotime(date("Y-m-d 00:00:00"))?>,
                end_day:<?=strtotime(date("Y-m-d 23:59:59"))?>,
                workloads:'<?=json_encode($data)?>',
            });
            
        });
    </script>
    <div id="daystat" style="margin-top:20px;">
        <canvas style="width:100%; height:40px" id="canvas"></canvas>
    </div>
    
    <table class="table" style="margin-top:20px;">
        <?php foreach($this->m->currentTasks as $item){ ?>
            <tr style="background:#<?=$item->color?>">
                <td><?=$item->message?></td>
                <td><?=$item->lessons_name?></td>
                <td><?=date("H:i",strtotime($item->start))?></td>
                <td><?=date("H:i",strtotime($item->end))?></td>
                <td>
                    <?php if($item->permanent == 1){ ?>
                        <span style="color:pink" class="glyphicon glyphicon-dashboard"></span>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php } ?>
</div>

