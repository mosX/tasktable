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
                <div class="col-sm-4">Цвет заметки</div>
                
                <div class="col-sm-8">
                    <input type="text"  class="form-control jscolor {valueElement:'color_picker',value:'ffffff'}" value="<?=$_POST['color']?>">
                    <input type="hidden" name="color" value="<?=$_POST['color']?>" id="color_picker">
                    <div class="error"><?=$this->m->error->color?></div>
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
                    <div class="error"><?=$this->m->error->type?></div>
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
                    
                    <div class="error"><?=$this->m->error->students?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Начало</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control clockpicker" name="start" value="<?=$_POST['start']?>">
                    <div class="error"><?=$this->m->error->start?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Окончание</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control clockpicker" name="end" value="<?=$_POST['end']?>">
                    <div class="error"><?=$this->m->error->end?></div>
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
            this.width = this.ws.width - this.x_margin*2;
            this.height = 7;
            
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
                                
                var start_x = this.timeToX(start);
                var end_x = this.timeToX(end);
                
                
                this.ctx.save();
                    this.ctx.lineWidth = 5;
                    this.ctx.strokeStyle = 'red';

                    this.ctx.beginPath();
                        this.ctx.moveTo(this.x_margin+start_x, this.y_margin+4);
                        this.ctx.lineTo(this.x_margin+end_x, this.y_margin+4);
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
                    var x = this.timeToX(start);
                    
                    this.ctx.save();
                        this.ctx.lineWidth = 1;
                        this.ctx.strokeStyle = '#5ca905';

                        this.ctx.beginPath();
                            this.ctx.moveTo(this.x_margin+x , this.y_margin);
                            this.ctx.lineTo(20.5+x, this.y_margin - 10);
                        this.ctx.closePath();

                        this.ctx.stroke();
                    this.ctx.restore();
                    
                    
                    var d = new Date( (this.start_day+start +1) *1000);
                    var hours = d.getHours();
                    hours = hours < 10 ? '0'+hours:hours;
                    var minutes = d.getMinutes();
                    minutes = minutes < 10 ? '0'+minutes:minutes;
                    //Текст
                    var text = hours+':'+minutes;
                    var textWidth = this.ctx.measureText(text).width / 2;
                    
                    this.ctx.save();
                        this.ctx.fillStyle = "#999";
                        this.ctx.font = "normal 9pt Arial";
                        this.ctx.fillText(text, this.x_margin+x - textWidth, 10);
                    this.ctx.restore();

                    start += 3600;
                }
            },
            timeToX:function(time){
                var x = (this.width/this.interval)*time;
                return x;
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
        <canvas style="width:100%; height:40px" id="canvas"></canvas>
    </div>
    <script>
        $('document').ready(function(){
            $('.clear_permanent').click(function(){
                var id = parseInt($(this).attr('data-id'));
                $.ajax({
                    url:'/manage/clear_permanent/'+id+'/?date='+<?=strtotime($this->m->date)?>,
                    type:'POST',
                    success:function(msg){
                        //console.log(msg);
                        var json = JSON.parse(msg);
                        if(json.status == 'success'){
                            location.href = location.href;
                        }
                    }
                });
                
                return false;
            });
            
            $('.remove').click(function(){
                var el = $(this);
                
                $.ajax({
                    url:$(el).attr('href'),
                    type:'POST',
                    success:function(msg){
                        var json = JSON.parse(msg);
                        if(json.status == 'success'){
                            location.href = location.href;
                    }
                });
                
                return false;
            });
        });
    </script>
    <table class="table">
        <?php foreach($this->m->data as $item){ ?>
            <tr style="background: #<?=$item->color?>;">
                <td><?=$item->message?></td>
                <td><?=$item->lessons_name?></td>
                <td><?=date("H:i",strtotime($item->start))?></td>
                <td><?=date("H:i",strtotime($item->end))?></td>
                <td>
                    
                    <a href="/tasks/edit/<?=$item->id?>/" class="glyphicon glyphicon-pencil edit" ></a>
                    <a style="color: red;" href="/tasks/remove/<?=$item->id?>/?date=<?=strtotime($this->m->date)?>" class="glyphicon glyphicon-remove remove" ></a>
                    <?php if($item->permanent){ ?>
                        <!--<a class="clear_permanent" data-id="<?=$item->id?>" href="">Отключить</a>-->
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
   
    
</div>
