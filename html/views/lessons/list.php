<script>
    $('document').ready(function(){
        $('#lessons_wraper .edit').click(function(){
            var parent = $(this).closest('tr');
            var id = $(this).closest('tr').attr('data-id');
            
            $('#lessons_wraper .value').css({'display':'block'});
            $('#lessons_wraper .edit_value').css({'display':'none'});
            
            $('.value',parent).css({'display':'none'});
            $('.edit_value',parent).css({'display':'block'});
            
            return false;
        });
        
        $('.save_edit_changes').click(function(){
            var parent = $(this).closest('tr');
            var id = $(parent).attr('data-id');
            var name = $('input[name=name]',parent).val();
            
            $.ajax({
                url:'/lessons/edit/'+id+'/',
                type:'POST',
                data:{name:name},
                success:function(msg){
                    var json = JSON.parse(msg);
                    
                    if(json.status == 'success'){
                        $('.value',parent).text(name).css({'display':'block'});
                        $('.edit_value',parent).css({'display':'none'});
                    }else if(json.status == 'error'){
                        
                    }
                }
            });
        });
        
        $('#lessons_wraper .remove').click(function(){
            var el = $(this);
            var id = $(this).closest('tr').attr('data-id');
            $.ajax({
                url:'/lessons/remove/'+id+'/',
                success:function(msg){
                    var json = JSON.parse(msg);
                    
                    if(json.status == 'success'){
                        
                    }else if(json.status == 'error'){
                        
                    }
                }
            });
            return false;
        });
    });
</script>
<style>
    #lessons_wraper .edit_value{
        display:none;
    }
</style>

<table class="table" id="lessons_wraper">
    <?php 
        $i = 0;
        foreach($this->m->data as $item){
    ?>
        <tr data-id="<?=$item->id?>">
            <td><?=++$i?></td>
            <td>
                <div class="value"><?=$item->name?></div>
                <div class="edit_value">
                    <div class="input-group">
                        <input type="text" name="name" value="<?=$item->name?>" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-primary save_edit_changes" type="button">Сохранить</button>
                        </span>                        
                    </div>
                </div>
            </td>
            <td>
                <a style="color: red;" href="/lessons/remove/<?=$item->id?>/" class="glyphicon glyphicon-remove remove" ></a>
                <a style="color: blue;" href="/lessons/edit_form/<?=$item->id?>/" class="glyphicon glyphicon-pencil edit" ></a>
            </td>
        </tr>
    <?php } ?>
</table>