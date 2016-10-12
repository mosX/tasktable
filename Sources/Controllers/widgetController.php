<?php
    class widgetController extends Model {
        public function init(){
            
        }
        
        public function indexAction(){                       
                        
        }
        
        public function get_filledAction(){
            header("Access-Control-Allow-Origin: *");
            $this->disableTemplate();
            $this->disableView();
            
            $uuid = $_GET['device_id'];
            
            $this->m->_db->setQuery(
                        "SELECT * FROM `users`"
                        . " WHERE `users`.`device_id` = '".$uuid."'"
                        . " LIMIT 1"
                    );
            $this->m->_db->loadObject($this->m->_user);

            if(!$this->m->_user) return false;
            
            xload('class.tasks');
            $tasks = new Tasks($this->m);
            $json->data = $tasks->getData(date("Y-m-d H:i:s"));
            echo json_encode($json);
        }
    }
?>