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
        
        public function editAction(){
            $this->disableTemplate();
            $this->disableView();
            
            xload('class.students');
            $students = new Students($this->m);
            $students->edit();
        }
        
        
        public function edit_formAction(){
            $this->disableTemplate();
            
            xload('class.students');
            $students = new Students($this->m);
            $this->m->data = $students->getEditData($this->m->_path[2]);
        }
        
        public function removeAction(){
            $this->disableTemplate();
            $this->disableView();
            
            xload('class.students');
            $students = new Students($this->m);
            $students->removeStudent($this->m->_path[2]);
        }
    }
?>