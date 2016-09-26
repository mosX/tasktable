<?php
class Lessons{
    protected $_table = 'lessons';

    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
    
    public function remove($id){
        $id = (int)$id;
        if(!$id) return;
        
        $this->m->_db->setQuery(
                    "UPDATE `lessons` SET `lessons`.`status` = 0 "
                    . " WHERE `lessons`.`id` = ".$id
                    . " AND `lessons`.`user_id` = ".$this->m->_user->id 
                    . " LIMIT 1"
                );
        if($this->m->_db->query()){
            echo '{"status":"success"}';
        }else{
            echo '{"status":"error"}';
        }        
    }
    
    public function edit($id){
        $id = (int)$id;
        if(!$id) return;
        
        $name = strip_tags(trim($_POST['name']));
        $this->m->_db->setQuery(
                    "UPDATE `lessons` SET `lessons`.`name` = '".$name."'"
                    . "WHERE `lessons`.`id` = ".$id
                    . " AND `lessons`.`user_id` = ".$this->m->_user->id
                    . " LIMIT 1"
                );
        if($this->m->_db->query()){
            echo '{"status":"success"}';
        }else{
            echo '{"status":"error"}';
        }
    }
    
    public function getLessonsList(){
        $this->m->_db->setQuery(
                    "SELECT `lessons`.* "
                    . " FROM `lessons`"
                    . " WHERE `lessons`.`user_id` = ".$this->m->_user->id
                    . " AND `lessons`.`status` = 1"
                );
        $data  = $this->m->_db->loadObjectList();
        
        return $data;
    }
    
    public function getList(){
        $this->m->_db->setQuery(
                    "SELECT `lessons`.* "
                    . " FROM `lessons`"
                    . " WHERE `lessons`.`user_id` = ".$this->m->_user->id  
                    . " AND `lessons`.`status` = 1"
                    . " LIMIT 10"
                );
        $data = $this->m->_db->loadObjectList();
        
        return $data;
    }
}
?>
