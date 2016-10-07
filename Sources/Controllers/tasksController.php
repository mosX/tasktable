<?php
    class tasksController extends Model {
        public function init(){
            if(!$this->m->_user->id) redirect('/');
        }
        
        public function mobile_addAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            
            $_POST = json_decode(file_get_contents('php://input'), true);   //для Content-Type: application/json
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($tasks->addNew() == true){
                    echo '{"status":"success"}';
                    return;
                }else{
                    echo '{"status":"error"}';
                    
                }
                $this->m->error = $tasks->error;
                //p($this->m->error);
            }
        }
        
        public function remove_mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $tasks->remove($_GET['id']);
        }
        
        public function mobile_get_editAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            xload('class.tasks');
            xload('class.students');
            
            $students = new Students($this->m);
            $tasks = new Tasks($this->m);
            $data = $tasks->getEditData($_GET['id']);
            
            $data->start = date("H:i",strtotime($data->start));
            $data->end = date("H:i",strtotime($data->end));
                
            
            $data->students = $students->getTaskStudents($_GET['id']);
            
            echo json_encode($data);
        }
        
        public function mobile_getAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            xload('class.tasks');
            xload('class.students');
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $tasks = new Tasks($this->m);
            $students = new Students($this->m);
            
            $this->m->date = date("Y-m-d",strtotime($_GET['year'].'-'.$_GET['month'].'-'.$_GET['day']));
            $this->m->data = $tasks->getData($this->m->date);
            $this->m->lessons = $lessons->getLessonsList();
            $this->m->students = $students->getStudentsList();
            
            foreach($this->m->data as $item){
                $item->start = date("H:i",strtotime($item->start));
                $item->end = date("H:i",strtotime($item->end));
            }
            
            $package = new stdClass();
            $package->tasks = $this->m->data;
            $package->lessons = $this->m->lessons;
            $package->students = $this->m->students;
            
            echo json_encode($package);
        }
        
        public function indexAction(){
            $this->m->addJS('workload');
            $this->m->addJS('clockpicker/clockpicker')->addJS('jscolor.min');
            $this->m->addCSS('clockpicker/clockpicker')->addCSS('clockpicker/standalone');
            
            $this->m->date = date("Y-m-d",strtotime($_GET['year'].'-'.$_GET['month'].'-'.$_GET['day']));            
            
            xload('class.tasks');
            xload('class.students');
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $tasks = new Tasks($this->m);
            $students = new Students($this->m);
            
            $this->m->data = $tasks->getData($this->m->date);
            
            $this->m->lessons = $lessons->getLessonsList();
            
            $this->m->students = $students->getStudentsList();
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($tasks->addNew() === true){
                    //redirect('/?date='.date("Y-m-d",strtotime($_GET['year'].'-'.$_GET['month'].'-'.$_GET['day'].' '.$_GET['start'])));
                    redirect('/');
                }
                $this->m->error = $tasks->error;
            }
        }
        
        public function clear_permanentAction(){
            $this->disableTemplate();
            $this->disableView();
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $tasks->clearPermanent($this->m->_path[2]);
        }
        
        public function removeAction(){
            $this->disableTemplate();
            $this->disableView();
            
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $tasks->remove($this->m->_path[2]);
        }
        
        public function editAction(){
            $this->m->addJS('jquery-ui-1.9.2.custom.min')->addJS('jscolor.min');
            $this->m->addCSS('ui-lightness/jquery-ui-1.9.2.custom.min');
            
            $this->m->addJS('clockpicker/clockpicker');
            $this->m->addCSS('clockpicker/clockpicker')->addCSS('clockpicker/standalone');
            
            xload('class.tasks');
            xload('class.students');
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $students = new Students($this->m);
            $tasks = new Tasks($this->m);
            
            $this->m->data = $tasks->getEditData($this->m->_path[2]);
            
            $this->m->lessons = $lessons->getLessonsList();
            
            $this->m->students_list = $students->getStudentsList();
            $this->m->students = $students->getTaskStudents($this->m->_path[2]);
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $tasks->edit($this->m->_path[2]);
                $this->m->error = $tasks->error;
            }
        }
        
        /*public function addAction(){
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
        }*/
    }
?>