<?php
    class logoutController extends Model {
        public function init(){
            $this->disableTemplate();
            $this->disableView();
        }
        
        public function mobileAction(){
            header("Access-Control-Allow-Origin: *");
            
            if($this->m->_auth->logout() == true){
                echo '{"status":"success"}';
            }else{
                echo '{"status":"error"}';
            }
        }
        
        public function indexAction(){
            if($this->m->_auth->logout()){
                redirect('/');
            }
        }        
    }
?>