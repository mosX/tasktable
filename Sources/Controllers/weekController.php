<?php
    class weekController extends Model {
        public function init(){
            if(!$this->m->_user->id) redirect('/');
        }
        
        public function indexAction(){           
            
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $this->m->data = $tasks->getWeek();
            
        }
    }
?>