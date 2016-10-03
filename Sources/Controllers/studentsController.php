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
        
        public function remove_mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            
            xload('class.students');
            $students = new Students($this->m);
            $students->removeStudent($_GET['id']);
        }
        
        public function add_mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            xload('class.students');
            $students = new Students($this->m);
            if($students->addNew() == false){
                echo '{"status":"error","message":"'.$students->error.'"}';
            }else{
                $package = new stdClass();
                $package->status = 'success';
                $package->data = $students->getAll();
                echo json_encode($package);
            }
        }
        
        public function get_mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            xload('class.students');
            $students = new Students($this->m);
            $data = $students->getAll();
            
            foreach($data as $item){
                $item->date = date("Y-m-d",strtotime($item->date));
            }
            
            echo json_encode($data);
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