<?php
    class lessonsController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            file_put_contents(XPATH.DS.'logs.txt', 'test',FILE_APPEND);
        }
        
        public function listAction(){
            $this->disableTemplate();
            
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $this->m->data = $lessons->getList();
        }
    }
?>