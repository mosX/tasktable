<?php
    class indexController extends Model {
        public function init() {
            
        }

        public function indexAction(){
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $this->m->data = $tasks->getFilledDates();            
            
            $this->m->currentTasks = $tasks->getData(date("Y-m-d H:i:s"));
            //p($this->m->currentTasks);
        }
    }
?>