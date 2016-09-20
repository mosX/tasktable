<?php
class Lessons{
    protected $_table = 'lessons';

    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
    
    public function getLessonsList(){
        $this->m->_db->setQuery(
                    "SELECT `lessons`.* "
                    . " FROM `lessons`"
                    . " WHERE `lessons`.`user_id` = ".$this->m->_user->id
                );
        $data  = $this->m->_db->loadObjectList();
        
        return $data;
    }
    
    public function getList(){
        $this->m->_db->setQuery(
                    "SELECT `lessons`.* "
                    . " FROM `lessons`"
                    . " WHERE `lessons`.`user_id` = ".$this->m->_user->id  
                    . " LIMIT 10"
                );
        $data = $this->m->_db->loadObjectList();
        
        return $data;
    }
}
?>
