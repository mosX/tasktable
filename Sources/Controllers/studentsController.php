<?php
    class studentsController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            xload('class.students');
            $students = new Students($this->m);
            $this->m->data = $students->getAll();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($students->addNew()){
                    redirect('/students/');
                }
            }
        }
        
        public function addAction(){
            
        }
    }
?>