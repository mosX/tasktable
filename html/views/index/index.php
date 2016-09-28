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

