<table class="table">
    <?php 
        $i = 0;
        foreach($this->m->data as $item){ 
            
    ?>
        <tr>
            <td><?=++$i?></td>
            <td><?=$item->name?></td>
        </tr>
    <?php } ?>
</table>