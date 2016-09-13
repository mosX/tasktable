<?php
    class indexController extends Model {
        public function init() {
            $this->m->addCSS("default");
            //$this->m->addJS('default')->addJS('countdown');
            //$this->m->addJS('base')->addJS('tracker');
            
            //$this->m->_template = 'template_bak';
            if($this->m->_user->id) redirect('/settings/');
        }

        public function indexAction(){
            //$this->m->addJS('countdown');
            $this->m->setTitle('OnePbx');
            
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $this->m->data = $tasks->getFilledDates();
        }
        
        public function testAction(){
            
        }
    }
?>