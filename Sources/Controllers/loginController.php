<?php
    class loginController extends Model {
        public function init(){
            $this->m->_template = 'main';
            
        }

        public function indexAction(){
            $this->m->setTitle('OnePbx');   
                                 
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $this->disableTemplate();
                $this->disableView();

                $this->m->_auth->ajaxLogin($_POST['email'],$_POST['password'],'/');
            }
        }
    }
?>