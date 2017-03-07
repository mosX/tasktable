<?php
    class weekController extends Model {
        public function init(){
            if(!$this->m->_user->id) redirect('/');
        }
        
        public function indexAction(){                       
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $this->m->data = $tasks->getWeek($_GET['date']);
        }
        
        public function get_mobileAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $this->m->data = $tasks->getWeek($_GET['date']);
            
            foreach($this->m->data as $day=>$item){
                foreach($item as $key=>$item2){
                    $this->m->data[$day][$key]->start = date("H:i",strtotime($item2->start));
                    $this->m->data[$day][$key]->end = date("H:i",strtotime($item2->end));
                }
            }
            echo json_encode($this->m->data);
        }
    }
?>