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
            donetext: 'OK'
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
                <div class="col-sm-4">
                    Заметка
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="message">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    Начало
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control clockpicker" name="start">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">
                    Окончание
                </div>
                <div class="col-sm-8">
                    <input type="text" class="form-control clockpicker" name="end">
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
