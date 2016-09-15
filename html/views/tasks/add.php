<style>
    .date_title{
        font-size:24px;
        text-align: center;
    }
    .edit{
        font-size:16px;
        cursor:pointer;
    }
</style>
<script>
    $('document').ready(function () {
        $('.clockpicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            donetext: 'OK',
            autoclose:true
        });
    });
</script>
<div class="container">    
    <div class="date_title">
        <?=date("Y m d",strtotime($this->m->date))?>
    </div>
    <form class="form" action="" method="POST">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Заметка</div>
                
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="message" value="<?=$_POST['message']?>">
                    <div class="error"><?=$this->m->error->message?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Постояное расписание</div>
                
                <div class="col-sm-8">
                    <input type="checkbox" name="permanent" <?=$_POST['permanent']? 'checked=checked' :''?>>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Предмет</div>

                <div class="col-sm-8">
                    <select name="type" class="form-control">
                        <option>Без типа</option>
                        <?php foreach($this->m->lessons as $item){ ?>
                            <option value="<?=$item->id?>"><?=$item->name?></option>
                        <?php } ?>
                    </select>
                    <div class="error"><?=$this->m->error->message?></div>
                </div>
            </div>
        </div>
        <script>
            $('document').ready(function(){
                $('.add_student').click(function(){
                    $('.student_block .element').eq(0).clone().appendTo('.student_block');
                });
                
                $('.student_block').on('click','.remove_student',function(){
                    $(this).closest('.element').remove();
                });
            });
        </script>
        <style>
            
            .student_block .element:first-child .remove_student{
                display:none;
            }
            .student_block .form-group .remove_student{
                cursor:pointer;
                font-size:18px;
                margin-top:5px;
                color: red;
            }
        </style>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Студент</div>

                <div class="col-sm-8">
                    <div class="student_block">
                        <div class="form-group element">
                            <div class="row">
                                <div class="col-sm-10">
                                    <select name="students[]" class="form-control">
                                        <option>Пусто</option>
                                        <?php foreach($this->m->students as $item){ ?>
                                            <option value="<?=$item->id?>"><?=$item->firstname?> <?=$item->lastname?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-sm-2 text-center">
                                    <span class="glyphicon glyphicon-remove remove_student"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="btn btn-primary add_student">Добавить</div>
                    
                    <div class="error"><?=$this->m->error->message?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Начало</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control clockpicker" name="start" value="<?=$_POST['start']?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Окончание</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control clockpicker" name="end" value="<?=$_POST['end']?>">
                    <div class="error"><?=$this->m->error->date?></div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">                
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-primary" value="Сохранить">
                </div>
            </div>
        </div>
      
    </form>

    <table class="table">
        <?php foreach($this->m->data as $item){ ?>
            <tr>
                <td><?=$item->message?></td>
                <td><?=$item->lessons_name?></td>
                <td><?=date("H:i",strtotime($item->start))?></td>
                <td><?=date("H:i",strtotime($item->end))?></td>
                <td><a href="/tasks/edit/<?=$item->id?>/" class="glyphicon glyphicon-pencil edit" ></a></td>
            </tr>
        <?php } ?>
    </table>
    <?php 
            foreach($this->m->data as $item){ 
                $start = strtotime($item->start);
                
                $end = strtotime($item->end);
                $date = strtotime($this->m->date);
                
                $data[] = array(strtotime(date("Y-m-d ".date("H",$start).":".date("i",$start).":00",$date)),strtotime(date("Y-m-d ".date("H",$end).":".date("i",$end).":00",$date)));
                
                
            } 
            
        ?>
    
    <script>
        
        
        function Workload(obj){
            this.parent = obj.parent;
            try{
                this.workloads = JSON.parse(obj.workloads);
            }catch(e){
                return false;
            }
            
            
            this.ws = $(this.parent)[0];
            this.ctx = this.ws.getContext('2d');
            
            this.ws.width = $('#canvas').width();
            this.ws.height = $('#canvas').height();
            
            this.start_day = obj.start_day-1;
            
            this.end_day = obj.end_day;
            
            this.x_margin = 20;
            this.y_margin = 20;
            this.width = 10;
            this.height = 300;
            
            this.interval = this.end_day - this.start_day;
            
            this.hourPositions();
            
            for(var key in this.workloads){                
                this.setWorloads(this.workloads[key]);               
            }
        }
        Workload.prototype = {
            parent:null,
            ws:null,ctx:null,
            start_day:0,end_day:0,
            interval:0,
            setWorloads:function(data){
                var start = data[0]-this.start_day;
                var end = data[1]-this.start_day;
                                
                var start_y = this.timeToY(start);
                var end_y = this.timeToY(end);
                                
                this.ctx.save();
                    this.ctx.lineWidth = 2;
                    this.ctx.strokeStyle = 'red';

                    this.ctx.beginPath();
                        this.ctx.moveTo(40.5, 20+start_y);
                        this.ctx.lineTo(40.5, 20+end_y);
                    this.ctx.closePath();

                    this.ctx.stroke();
                this.ctx.restore();
                
                this.ctx.save();
                    this.ctx.lineWidth = 1;
                    this.ctx.strokeStyle = 'red';

                    this.ctx.beginPath();
                        this.ctx.moveTo(40.5, 20+start_y);
                        this.ctx.lineTo(40.5, 20+end_y);
                    this.ctx.closePath();

                    this.ctx.stroke();
                this.ctx.restore();

            },
            hourPositions:function(){
                this.ctx.save();
                    this.ctx.fillStyle = 'rgba(0,155,100,0.5)';
                    this.ctx.rect(this.x_margin,this.y_margin,this.width,this.height);
                    this.ctx.fill();
                this.ctx.restore();

                var start = 0;
                
                while(start <= this.interval){
                    var y = this.timeToY(start);

                    this.ctx.save();
                        this.ctx.lineWidth = 1;
                        this.ctx.strokeStyle = '#5ca905';

                        this.ctx.beginPath();
                            this.ctx.moveTo(this.x_margin + this.width, this.y_margin+y);
                            this.ctx.lineTo(40.5, 20+y);
                        this.ctx.closePath();

                        this.ctx.stroke();
                    this.ctx.restore();

                    start += 3600;
                }
            },
            timeToY:function(time){
                var y = (300/this.interval)*time;
                return y;
            }
        }
        
        $('document').ready(function(){
            var object = new Workload({
                parent:$('#canvas'),
                start_day:<?=strtotime(date("Y-m-d 00:00:00",strtotime($this->m->date)))?>,
                end_day:<?=strtotime(date("Y-m-d 23:59:59",strtotime($this->m->date)))?>,
                workloads:'<?=json_encode($data)?>',
            });
            
        });
    </script>
    <div id="daystat">
        <canvas style="outline: 1px solid red;" id="canvas" width="400" height="400"></canvas>
    </div>
</div>
