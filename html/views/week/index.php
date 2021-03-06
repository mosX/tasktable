<div class="container">
    <div class="btn-group" style="margin-bottom:20px;   ">
        <a href="/week/?date=<?=date("Y-m-d",strtotime('-1 week',strtotime($this->m->date)))?>" class="btn btn-primary">Предыдущая</a>
        <a href="/week/?date=<?=date("Y-m-d",strtotime('+1 week',strtotime($this->m->date)))?>" class="btn btn-primary">Следующая</a>
    </div>
    
    <h3><?=date("Y/m/d",strtotime($this->m->monday))?> - <?=date("Y/m/d",strtotime($this->m->saturday))?></h3>
    <table class="table">
        <?php 
            $weeks = array(1=>'ПН',2=>'ВТ',3=>'СР',4=>'ЧТ',5=>'ПТ',6=>'СБ',7=>'ВС');
        ?>
        <?php for($i=1;$i<=7;$i++){ ?>        
            <tr>
                <td><?=$weeks[$i]?></td>
                <td>
                    <ul style="list-style: none;">
                        <?php foreach($this->m->data[$i] as $item){ ?>
                            <li style="background: #<?=$item->color?>">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?=$item->lesson_name?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?=date("H:i",strtotime($item->start))?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?=date("H:i",strtotime($item->end))?>
                                        </div>
                                    </div>
                                </div>
                                
                            </li>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
