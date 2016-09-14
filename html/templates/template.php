<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8" />
        
        <title>Расписание</title>
        <link rel="icon" type='image/jpeg' href="/html/images/0fdfe575d87215d04396f9cc8c6d3ea6.jpg">
        <?=$this->css();?>
        <?=$this->js();?>
        
        <!--<script type="text/javascript" src="/html/js/jquery.js"></script>
        <script type="text/javascript" src="/html/js/bootstrap.min.js"></script>
        
        <link type="text/css" rel="stylesheet" href="/html/css/bootstrap.min.css">        
        -->
        
        <!--<link rel="stylesheet" href="http://cdn.webix.com/edge/webix.css" type="text/css"> 
        <script src="http://cdn.webix.com/edge/webix.js" type="text/javascript"></script> -->
    </head>
    <body>
       <?=$this->module('modals')?>
        
        <?=$this->module('header')?>
       <?=$this->maincontent?>
    </body>
</html>