<table class="table">
    <?php 
        $i = 0;
        foreach($this->m->data as $item){ 
            
    ?>
        <tr>
            <td><?=++$i?></td>
            <td><?=$item->name?></td>
            <td>
                <a style="color: red;" href="/lessons/remove/<?=$item->id?>/" class="glyphicon glyphicon-remove remove" ></a>
                <a style="color: blue;" href="/lessons/edit_form/<?=$item->id?>/" class="glyphicon glyphicon-pencil edit" ></a>
            </td>
        </tr>
    <?php } ?>
</table>