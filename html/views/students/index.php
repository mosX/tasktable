<div class="container">
    <div class="well">
        <form action="" method="POST">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">Имя</div>

                    <div class="col-sm-8">
                         <input type="text" name="firstname" value="<?=$_POST['firstname']?>">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">Фамилия</div>

                    <div class="col-sm-8">
                         <input type="text" name="lastname" value="<?=$_POST['lastname']?>">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">Телефон</div>

                    <div class="col-sm-8">
                         <input type="text" name="phone" value="<?=$_POST['phone']?>">
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
    <script>
        $('document').ready(function(){
            $('.remove').click(function(){
                var el = $(this);
                var url = $(this).attr('href');
                
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(msg){
                        var json = JSON.parse(msg);
                        
                        if(json.status == 'success'){
                            $(el).closest('tr').remove();
                        }
                    }
                });
                return false;
            });
            
            $('.edit').click(function(){
                var el = $(this);
                var url = $(this).attr('href');
                
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function(msg){
                        $('#editStudentModal .modal-body').html(msg);
                        $('#editStudentModal').modal('show');
                        
                        /*$('#editStudentModal form').click(function(){
                            console.log('222');
                        });*/
                    }
                });
                
                
                return false;
            });
            
            $('#editStudentModal').on('submit','form',function(){
                
                var id = $('input[name=id]',this).val();
                var firstname = $('input[name=firstname]',this).val();
                var lastname = $('input[name=lastname]',this).val();
                var phone = $('input[name=phone]',this).val();
                
                $.ajax({
                    url:'/students/edit/'+id+'/',
                    type:'POST',
                    data:{firstname:firstname,lastname:lastname,phone:phone,id:id},
                    success:function(msg){
                        var json = JSON.parse(msg);
                        if(json.status == 'success'){
                            location.href = location.href;
                        }else if(json.status == 'erorr'){
                            
                        }
                    }
                });
                return false;
            });
        });
    </script>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Телефон</th>
                <th>Дата</th>
                <th></th>
            </tr>
        </thead>
        <?php foreach($this->m->data as $item){ ?>
        <tr>
            <td><?=$item->firstname?></td>
            <td><?=$item->lastname?></td>
            <td><?=$item->phone?></td>
            <td><?=date("Y-m-d",strtotime($item->date))?></td>
            <td>
                <a style="color: red;" href="/students/remove/<?=$item->id?>/" class="glyphicon glyphicon-remove remove" ></a>
                <a style="color: blue;" href="/students/edit_form/<?=$item->id?>/" class="glyphicon glyphicon-pencil edit" ></a>
            </td>            
        </tr>
        <?php } ?>
    </table>
</div>

<div id="editStudentModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Редактировать Студента</h4>
            </div>
            <div class="modal-body"></div>            
        </div>
    </div>
</div>


