<?php
    class lessonsController extends Model {
        public function init(){
            if(!$this->m->_user->id) redirect('/');
        }
        
        public function indexAction(){
            file_put_contents(XPATH.DS.'logs.txt', 'test',FILE_APPEND);
        }
        
        public function remove_mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $lessons->remove($_GET['id']);
        }
        
        public function edit_mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            
            $_POST = json_decode(file_get_contents('php://input'), true);   //для Content-Type: application/json
            
            if($lessons->edit($_POST['id'])==true){
                echo '{"status":"success"}';
            }else{
                echo '{"status":"error"}';
            }
        }
        
        public function add_mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            
            $_POST = json_decode(file_get_contents('php://input'), true);   //для Content-Type: application/json
            
            if($lessons->addLesson() == false){
                echo '{"status":"error","message":"'.$lessons->error.'"}';
            }else{
                $package = new stdClass();
                $package->status = 'success';
                $package->id = $lessons->id;
                //$package->data = $lessons->getList();
                echo json_encode($package);
            }
        }
        
        public function get_mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $data = $lessons->getList();
            
            echo json_encode($data);
        }
        
        public function removeAction(){
            $this->disableTemplate();
            $this->disableView();
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $lessons->remove($this->m->_path[2]);            
        }
        
        public function editAction(){
            $this->disableTemplate();
            $this->disableView();
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            if($lessons->edit($this->m->_path[2])){
                echo '{"status":"success"}';
            }else{
                echo '{"status":"error"}';
            }
            
        }
        
        public function listAction(){
            $this->disableTemplate();
            
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $this->m->data = $lessons->getList();
        }
    }
?>