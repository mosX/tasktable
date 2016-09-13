<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta charset="utf-8" />
        
        <title>Программа заработка</title>
        <link rel="icon" type='image/jpeg' href="/html/images/0fdfe575d87215d04396f9cc8c6d3ea6.jpg">
        <?=$this->css();?>
        <?=$this->js();?>
        
        <!--<script type="text/javascript" src="/html/js/jquery.js"></script>
        <script type="text/javascript" src="/html/js/bootstrap.min.js"></script>
        
        <link type="text/css" rel="stylesheet" href="/html/css/bootstrap.min.css">        
        -->
        
        <link rel="stylesheet" href="http://cdn.webix.com/edge/webix.css" type="text/css"> 
        <script src="http://cdn.webix.com/edge/webix.js" type="text/javascript"></script> 
    </head>
    <body>
        <script>
            $('document').ready(function(){
                $('#addLessonModal form').submit(function(){
                    var name = $('input[name=type]',this).val();
                    
                    $.ajax({
                        url:'/manage/addtype/',
                        type:'POST',
                        data:{name:name},
                        success:function(msg){
                            var json = JSON.parse(msg);
                            if(json.status == 'error'){
                                $('#addLessonModal form .error').text(json.message);
                            }else{
                                $('#addLessonModal form .error').empty();
                            }
                        }
                    });
                    return false;
                });
            });
        </script>
        <div id="addLessonModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Добавить Предмет</h4>
                </div>
                <div class="modal-body">
                  <form class="form">
                      <div class="form-group">
                          <div class="row">
                              <div class="col-sm-4">
                                  Название
                              </div>
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
                </div>
              </div>

            </div>
          </div>
        
        <?=$this->module('header')?>
       <?=$this->maincontent?>
    </body>
</html>