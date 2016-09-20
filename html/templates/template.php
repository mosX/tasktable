<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8" />
        
        <title>Расписание</title>
        <link rel="icon" type='image/jpeg' href="/html/images/0fdfe575d87215d04396f9cc8c6d3ea6.jpg">
        <?=$this->css();?>
        <?=$this->js();?>
    </head>
    <body>
        <style>
            #content{
                min-height: 820px;
                margin-bottom:30px;
            }
            #footer{
                height: 40px;
                background: rgb(248,248,248);
            }
        </style>
        <?=$this->module('modals')?>
        
        <?=$this->module('header')?>
        <div id="content">
            <?=$this->maincontent?>
        </div>
        
        <div id="footer">
            <div class="container">
                
            </div>
        </div>
    </body>
</html>