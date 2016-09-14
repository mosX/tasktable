<div class="container">
    <div class="well">
        <form action="" method="POST">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">Имя</div>

                    <div class="col-sm-8">
                         <input type="text" name="firstname">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">Фамилия</div>

                    <div class="col-sm-8">
                         <input type="text" name="lastname">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-12">
                         <input type="submit" value="Добавить" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <table class="table table-striped table-hover">
        <?php foreach($this->m->data as $item){ ?>
        <tr>
            <td><?=$item->firstname?></td>
            <td><?=$item->lastname?></td>
            <td><?=date("Y-m-d",strtotime($item->date))?></td>
        </tr>
        <?php } ?>
    </table>
</div>

