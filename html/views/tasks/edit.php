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
    <form class="form" action="" method="POST">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Заметка</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="message" value="<?=$_POST['message'] ? $_POST['message'] : $this->m->data->message?>">
                    <div class="error"><?=$this->m->error->message?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Постояное расписание</div>
                
                <div class="col-sm-8">
                    <input type="checkbox" name="permanent" <?=$_POST['permanent'] ? 'checked=checked' :($this->m->data->permanent ? 'checked=checked':'')?>>
                </div>
            </div>
        </div>
         <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Дата заявки</div>
                
                <div class="col-sm-8">
                    <input type="text" class="datepicker form-control" name="date" value="<?=$_POST['date'] ? $_POST['date'] :date("Y-m-d",strtotime($this->m->data->start))?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Предмет</div>

                <div class="col-sm-8">
                    <?php  $type = $_POST['type']?  $_POST['type']:$this->m->data->lesson; ?>
                                        
                    <select name="type" class="form-control">
                        <option>Без типа</option>
                        
                        <?php foreach($this->m->lessons as $item){ ?>
                            <option <?=$type == $item->id ? 'selected=selected':''?> value="<?=$item->id?>"><?=$item->name?></option>
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
                        <?php if(!$this->m->students){ ?>
                            <div class="form-group element">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <select name="students[]" class="form-control">
                                            <option>Пусто</option>
                                            <?php foreach($this->m->students_list as $item){ ?>
                                                <option value="<?=$item->id?>"><?=$item->firstname?> <?=$item->lastname?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2 text-center">
                                        <span class="glyphicon glyphicon-remove remove_student"></span>
                                    </div>
                                </div>
                            </div>
                        <?php }else{ ?>
                            <?php foreach($this->m->students as $item){ ?>
                                <div class="form-group element">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <select name="students[]" class="form-control">
                                                <option>Пусто</option>
                                                <?php foreach($this->m->students_list as $item2){ ?>
                                                    <option <?=$item->student_id == $item2->id ? 'selected=selected':''?> value="<?=$item2->id?>"><?=$item2->firstname?> <?=$item2->lastname?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2 text-center">
                                            <span class="glyphicon glyphicon-remove remove_student"></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php }?>
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
                    <input type="text" class="form-control clockpicker" name="start" value="<?=$_POST['start'] ? $_POST['start'] : date("H:i",strtotime($this->m->data->start))?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Окончание</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control clockpicker" name="end" value="<?=$_POST['end'] ? $_POST['end'] : date("H:i",strtotime($this->m->data->end))?>">
                    <div class="error"><?=$this->m->error->date?></div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-primary" value="Редактировать">
                </div>
            </div>
        </div>     
    </form>
</div>

<script>
    $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd'
    });
</script>