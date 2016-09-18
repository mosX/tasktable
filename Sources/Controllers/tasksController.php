<?php
    class tasksController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            
        }
        
        public function editAction(){
            $this->m->addJS('jquery-ui-1.9.2.custom.min')->addJS('jscolor.min');
            $this->m->addCSS('ui-lightness/jquery-ui-1.9.2.custom.min');
            
            $this->m->addJS('clockpicker/clockpicker');
            $this->m->addCSS('clockpicker/clockpicker')->addCSS('clockpicker/standalone');
            
            xload('class.tasks');
            xload('class.students');
            $students = new Students($this->m);
            $tasks = new Tasks($this->m);
            $this->m->data = $tasks->getEditData($this->m->_path[2]);
            
            $this->m->lessons = $tasks->getLessonsList();
            
            $this->m->students_list = $students->getStudentsList();
            $this->m->students = $students->getTaskStudents($this->m->_path[2]);
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $tasks->edit($this->m->_path[2]);
                $this->m->error = $tasks->error;
            }
        }
        
        public function addAction(){
            $this->m->addJS('clockpicker/clockpicker')->addJS('jscolor.min');
            $this->m->addCSS('clockpicker/clockpicker')->addCSS('clockpicker/standalone');
            
            $this->m->date = date("Y-m-d",strtotime($_GET['year'].'-'.$_GET['month'].'-'.$_GET['day']));            
            
            xload('class.tasks');
            xload('class.students');
            $tasks = new Tasks($this->m);
            $students = new Students($this->m);
            
            $this->m->data = $tasks->getData($this->m->date);
            $this->m->lessons = $tasks->getLessonsList();
            
            $this->m->students = $students->getStudentsList();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $tasks->addNew();
                $this->m->error = $tasks->error;
            }
        }
    }
?>