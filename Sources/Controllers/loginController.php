<?php
    class loginController extends Model {
        public function init(){
            $this->m->_template = 'main';            
        }

        public function checkmobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            
            $session = $this->m->_auth->checkOnline($_POST['uuid']);
            
            if($session){//просто получить данные пользователя и вернуть сессию
                echo '{"status":"success","session":"'.$session->session_id.'"}';
                return true;            
            }else{
                echo '{"status":"error"}';
            }
        }
        
        public function mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $this->m->_auth->mobileLogin($_POST['email'],$_POST['password'],$_POST['uuid']);
            }
            
            //echo '{"status":"blabla"}';
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