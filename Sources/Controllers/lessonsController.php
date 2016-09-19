<?php
    class lessonsController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            
        }
        
        public function listAction(){
            $this->disableTemplate();
            
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $this->m->data = $lessons->getList();
        }
    }
?>