<?php
    class lessonsController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            file_put_contents(XPATH.DS.'logs.txt', 'test',FILE_APPEND);
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
            $lessons->edit($this->m->_path[2]);
            
        }
        
        public function listAction(){
            $this->disableTemplate();
            
            xload('class.lessons');
            $lessons = new Lessons($this->m);
            $this->m->data = $lessons->getList();
        }
    }
?>