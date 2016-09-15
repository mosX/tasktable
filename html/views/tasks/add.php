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
    <script>
        $('document').ready(function(){
            var ws = $('#canvas')[0];
            var ctx = ws.getContext('2d');

            ws.width = $('#canvas').width();
            ws.height = $('#canvas').height();
            
            var start_day = <?=strtotime(date("Y-m-d 00:00:00",strtotime($this->m->date)))?>;
            var end_day = <?=strtotime(date("Y-m-d 23:59:59",strtotime($this->m->date)))?>;
            
            var interval = end_day - start_day+1;
            
            ctx.save();                
                ctx.fillStyle = 'rgba(255,0,0,0.5)';
                ctx.rect(20,20,10,300);
                ctx.fill();
            ctx.restore();  
            
            var start = 0;
            while(start <= interval){
                var y = (300/interval)*start;
                
                ctx.save();
                    ctx.lineWidth = 1;

                    ctx.strokeStyle = '#5ca905';

                    //ctx.translate(x+40, 0.5);

                    ctx.beginPath();
                        ctx.moveTo(20, 20+y);
                        ctx.lineTo(100, 20+y);
                    ctx.closePath();

                    ctx.stroke();
                ctx.restore();
                
                start += 3600;
            }
        });
    </script>
    <div id="daystat">
        <canvas style="outline: 1px solid red;" id="canvas" width="400" height="400"></canvas>
    </div>
</div>
