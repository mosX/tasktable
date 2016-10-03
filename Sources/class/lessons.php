<?php
class Lessons{
    protected $_table = 'lessons';

    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
    
    public function addLesson(){
        $name = strip_tags(trim($_POST['name']));
        
        if(!$name){
            $this->error = 'Вы должны ввести название';
            //echo '{"status":"error","message":"Вы должны ввести название"}';
            return false;
        }
        
        //проверяем или такого не было
        $this->m->_db->setQuery(
                    "SELECT `lessons`.`id` "
                    . " FROM `lessons` "
                    . " WHERE `lessons`.`name` = '".$name."'"
                    . " AND `lessons`.`user_id` = ".$this->m->_user->id
                    . " LIMIT 1"
                );
        $check = $this->m->_db->loadResult();
        if($check){
            $this->error = 'Вы уже добавляли такое название';
            //echo '{"status":"error","message":"Вы уже добавляли такое название"}';
            return false;
        }
        
        $row->user_id = $this->m->_user->id;
        $row->name = $name;
        $row->date = date("Y-m-d H:i:s");
        
        if($this->m->_db->insertObject('lessons',$row)){
            //echo '{"status":"success"}';
            return true;
        }
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
                    . " ORDER BY `id` DESC"
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
                    . " ORDER BY `id` DESC"
                    . " LIMIT 10"
                );
        $data = $this->m->_db->loadObjectList();
        
        return $data;
    }
}
?>
