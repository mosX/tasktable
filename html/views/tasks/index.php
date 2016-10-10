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
    function setEnd(){
        parent = $('form');        
        var arr = $('input[name=start]',parent).val().split(':');
        
        var hours = arr[0];
        var minutes = arr[1];
        
        var d = new Date();
        
        d.setHours(hours);
        d.setMinutes(minutes);

        var new_d = new Date(d.getTime() + 60*90*1000);
        
        var new_hours = new_d.getHours();
        var new_minutes = new_d.getMinutes();
        
        $('input[name=end]',parent).val(new_hours+ ':'+new_minutes );
    }
    
    $('document').ready(function () {
        $('.clockpicker_start').clockpicker({
                placement: 'bottom',
                align: 'left',
                donetext: 'OK',
                autoclose:true,
                afterDone: function(){
                    console.log("after done");
                    setEnd(false);
                    //{{setEnd()}}
                }
            });
        
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
                    <input type="text"  class="form-control jscolor {valueElement:'color_picker',value:'ffffff'}" value="">
                    <input type="hidden" name="color" value="<?=$_POST['color']?>" id="color_picker">
                    <div class="error"><?=$this->m->error->color?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Постояное расписание</div>
                
                <div class="col-sm-8">
                    <ul class="list-inline">
                        <li>
                            ПН
                            <input type="checkbox" name="permanent[1]" <?=$_POST['permanent'][1]? 'checked=checked' :''?>>
                        </li>
                        <li>
                            ВТ
                            <input type="checkbox" name="permanent[2]" <?=$_POST['permanent'][2]? 'checked=checked' :''?>>
                        </li>
                        <li>
                            СР
                            <input type="checkbox" name="permanent[3]" <?=$_POST['permanent'][3]? 'checked=checked' :''?>>
                        </li>
                        <li>
                            ЧТ
                            <input type="checkbox" name="permanent[4]" <?=$_POST['permanent'][4]? 'checked=checked' :''?>>
                        </li>
                        <li>
                            ПТ
                            <input type="checkbox" name="permanent[5]" <?=$_POST['permanent'][5]? 'checked=checked' :''?>>                            
                        </li>
                        <li>
                            СБ
                            <input type="checkbox" name="permanent[6]" <?=$_POST['permanent'][6]? 'checked=checked' :''?>>
                        </li>
                        <li>
                            НД
                            <input type="checkbox" name="permanent[7]" <?=$_POST['permanent'][7]? 'checked=checked' :''?>>
                        </li>
                    </ul>
                    
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
                    <input type="text" class="form-control clockpicker_start" name="start" value="<?=$_POST['start']?>">
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
                var url = $(this).attr('href');
                
                $.ajax({
                    url:url,
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
                    }
                });
                return false;
            });
        });
    </script>
    <table class="table">
        <?php foreach($this->m->data as $item){ ?>
            <tr style="background: #<?=$item->color?>;">
                
                <td><?=$item->end?></td>
                <td><?=$item->message?></td>
                <td><?=$item->lessons_name?></td>
                <td><?=date("H:i",strtotime($item->start))?></td>
                <td><?=date("H:i",strtotime($item->end))?></td>
                <td>                    
                    <a href="/tasks/edit/<?=$item->id?>/" class="glyphicon glyphicon-pencil edit"  style="margin-right:10px;"></a>
                    <a style="margin-right:10px;color: red; font-size:18px;" href="/tasks/remove/<?=$item->id?>/?date=<?=$this->m->date?>" class="glyphicon glyphicon-remove remove" ></a>
                    
                    <?php if($item->permanent){ ?>
                        <a style="color: darkorange; font-size:18px;" href="/tasks/clear_permanent/<?=$item->id?>/?date=<?=$this->m->date?>" class="glyphicon glyphicon-remove-circle clear_permanent" ></a>
                    <?php } ?>                    
                </td>
                <td>
                    <?php if($item->permanent == 1){ ?>
                        <span style="color:pink" class="glyphicon glyphicon-dashboard"></span>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
   
    
</div>
