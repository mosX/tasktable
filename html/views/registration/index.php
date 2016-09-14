<style>
    #registration{
        width:500px;
        margin:auto;
    }
</style>
<div class="container">
    <form action="" method="POST" class="form" id="registration">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Имя</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="firstname" value="<?=$_POST['firstname']?>">
                    <div class="error"><?=$this->m->error->firstname?></div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Фамилия</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="lastname" value="<?=$_POST['lastname']?>">
                    <div class="error"><?=$this->m->error->lastname?></div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Email</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="email" value="<?=$_POST['email']?>">
                    <div class="error"><?=$this->m->error->email?></div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Пароль</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="password">
                    <div class="error"><?=$this->m->error->password?></div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-4">Повторить Пароль</div>

                <div class="col-sm-8">
                    <input type="text" class="form-control" name="conf_password">
                    <div class="error"><?=$this->m->error->password2?></div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
                <div class="col-sm-12">
                    <input type="submit" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>
</div>