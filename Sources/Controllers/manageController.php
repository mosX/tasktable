<?php
    class manageController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            
        }
        
        public function clear_permanentAction(){
            $this->disableTemplate();
            $this->disableView();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                xload('class.manage');
                $manage = new Manage($this->m);
                $manage->clearPermanent($this->m->_path[2]);
            }
        }
        
        public function filledAction(){
            header("Access-Control-Allow-Origin: *");
                        
            $this->disableTemplate();
            $this->disableView();
            
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $this->m->data = $tasks->getFilledDates();
            echo json_encode($this->m->data);            
        }
        
        public function addtypeAction(){
            $this->disableTemplate();
            $this->disableView();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                xload('class.lessons');
                $lessons = new Lessons($this->m);
                if($lessons->addLesson() == false){
                    echo '{"status":"error","message":"'.$lessons->error.'"}';
                }else{
                    echo '{"status":"success"}';
                }
                
                /*xload('class.manage');
                $manage = new Manage($this->m);
                $manage->addType();*/
            }
        }
    }
?>