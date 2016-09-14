<?php
    class registrationController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){
            
            xload('class.registration');
            $registration = new Registration($this->m);
            $registration->registrate();
            $this->m->error = $registration->error;
        }        
        
    }
?>