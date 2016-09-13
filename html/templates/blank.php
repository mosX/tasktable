<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8" />
        
        <?= $this->header() ?>
        <?= $this->css() ?>
        <?= $this->js() ?>
        <link rel="icon" type='image/jpeg' href="/html/images/0fdfe575d87215d04396f9cc8c6d3ea6.jpg">
        
    </head>
    <body class="area fixed-md">
        <div class="modal-backdrop fade in" style="display:none;"></div>
        <?=$this->module('registration')?>
        <?=$this->module('login')?>
        
        <div class="area font-text-opensans font-header-opensans fixed-md">
            <style>
                .terms ul{
                    list-style: none;
                }
                .terms h2{
                    font-size: 24px;
                    font-weight:bolder;
                    margin:10px 0px;
                }
                .terms h3{
                    font-weight:bolder;
                    margin:10px 0px;
                }
            </style>
            <?=$this->maincontent?>
            
    </body>
</html>