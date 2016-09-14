<?php
    class manageController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            
        }
        
        public function filledAction(){
            $this->disableTemplate();
            $this->disableView();
            
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $this->m->data = $tasks->getFilledDates($year,$month);
            echo json_encode($this->m->data);            
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