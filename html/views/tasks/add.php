<style>
    .date_title{
        font-size:24px;
        text-align: center;
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
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    Начало
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control clockpicker" name="start" value="<?=$_POST['start']?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    Окончание
                </div>
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
                <td><?=$item->start?></td>
                <td><?=$item->end?></td>
            </tr>
        <?php } ?>
    </table>
</div>
