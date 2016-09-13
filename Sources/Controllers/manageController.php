<?php
    class manageController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            
        }
        
        public function addtypeAction(){
            $this->disableTemplate();
            $this->disableView();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                xload('class.manage');
                $manage = new Manage($this->m);
                $manage->addType();
            }
        }
    }
?>