<form class="form" action="" method="POST">
    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">Имя</div>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="firstname" value="<?=$this->m->data->firstname?>">
                <div class="firstname_error error"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">Фамилия</div>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="lastname" value="<?=$this->m->data->lastname?>">
                <div class="lastname_error error"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-sm-4">Телефон</div>

            <div class="col-sm-8">
                <input type="text" class="form-control" name="phone" value="<?=$this->m->data->phone?>">
                <div class="phone_error error"></div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="row">

            <div class="col-sm-8">
                <input type="hidden" name="id" value="<?=$this->m->data->id?>">
                <input type="submit" class="btn btn-primary" value="Редактировать">
            </div>
        </div>
    </div>
</form>