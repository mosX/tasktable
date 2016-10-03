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

