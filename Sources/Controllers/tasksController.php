<?php
    class tasksController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            
        }
        
        public function addAction(){
            $this->m->addJS('clockpicker/clockpicker');
            $this->m->addCSS('clockpicker/clockpicker')->addCSS('clockpicker/standalone');
            
            $this->m->date = date("Y-m-d",strtotime($_GET['year'].'-'.$_GET['month'].'-'.$_GET['day']));            
            
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $this->m->data = $tasks->getData($this->m->date);
            $this->m->lessons = $tasks->getLessonsList();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $tasks->addNew();
                $this->m->error = $tasks->error;
            }
        }
    }
?>