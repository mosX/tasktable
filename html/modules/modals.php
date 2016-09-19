<script>
    function loadLessonsList(callback){
        $.ajax({
            url:'/lessons/list/',
            type:'GET',
            success:function(msg){
                $('#addLessonModal .lessons_list').html(msg);
                
                callback();
            }
        });
    }
    $('document').ready(function () {
        $('#add_lesson_btn').click(function(){
            loadLessonsList(function(){
                $('#addLessonModal').modal('show');
            });
            return false;
        });
        
        $('#addLessonModal form').submit(function () {
            var name = $('input[name=type]', this).val();

            $.ajax({
                url: '/manage/addtype/',
                type: 'POST',
                data: {name: name},
                success: function (msg) {
                    var json = JSON.parse(msg);
                    if (json.status == 'error') {
                        $('#addLessonModal form .error').text(json.message);
                    } else {
                        loadLessonsList(function(){
                            //$('#addLessonModal').modal('show');
                        });
                        $('#addLessonModal form input[name=type]').val('');
                        $('#addLessonModal form .error').empty();
                        //$('#addLessonModal').modal('hide');
                    }
                }
            });
            return false;
        });
    });
</script>
<div id="addLessonModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Добавить Предмет</h4>
            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">Название</div>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="type">
                                <div class="error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-sm-8">
                                <input type="submit" class="btn btn-primary" value="Добавить">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="lessons_list">
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $('document').ready(function () {
        $('#loginModal form').submit(function(){
            var email = $('input[name=email]',this).val();
            var password = $('input[name=password]',this).val();
            
            $.ajax({
                url:'/login/',
                type:'POST',
                data:{email:email,password:password},
                success:function(msg){
                    var json = JSON.parse(msg);
                    
                    if(json.status == 'error'){
                        $('#loginModal .email_error').text(json.message);
                    }else{
                        $('#loginModal .email_error').empty();
                        location.href = location.href;
                    }
                }
            });
            
            return false;
        });
    });
</script>

<div id="loginModal" class="modal fade" role="dialog">
    <div class="modal-dialog"  style="width:400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Авторизация</h4>
            </div>
            <div class="modal-body">
                <form class="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">Email</div>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="email">
                                <div class="error email_error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">Password</div>

                            <div class="col-sm-8">
                                <input type="password" class="form-control" name="password">
                                <div class="error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="submit" class="btn btn-primary" value="Добавить">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>