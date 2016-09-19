
<nav class="navbar navbar-default" id="header">
    <div class='container'>

        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#headerMenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
            <a class="navbar-brand logo" href="/"></a>
        </div>

        <ul class="nav navbar-nav navbar-collapse collapse" id="headerMenu">
            <li class="active"><a href="/">Календарь</a></li>
            <?php if($this->_user->id){ ?>
                <li><a style="cursor:pointer;" data-toggle="modal" data-target="#addLessonModal">Добавить Предмет</a></li>
                <li><a href="/students/">Студенты</a></li>
            <?php } ?>
        </ul>
        
        <ul class="pull-right nav navbar-nav">
            <?php if($this->_user->id){ ?>
                <li><a href="/logout/">Выход</a></li>
            <?php }else{ ?>
                <li><a data-toggle="modal" data-target="#loginModal" href="">Вход</a></li>
                <li><a href="/registration/">Регистрация</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>
