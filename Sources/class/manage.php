<?php
class Manage{
    //protected $_table = '';

    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
        
    public function addType(){
        $name = strip_tags(trim($_POST['name']));
        
        if(!$name){
            echo '{"status":"error","message":"Вы должны ввести название"}';
            return false;
        }
        
        $row->user_id = $this->m->_user->id;
        $row->name = $name;
        $row->date = date("Y-m-d H:i:s");
        
        if($this->m->_db->insertObject('lessons',$row)){
            echo '{"status":"success"}';
        }
    }
    
    public function clearPermanent($id,$date){
        $id = (int)$id;
        //получаем таск
        $this->m->_db->setQuery(
                    "SELECT `tasks`.* "
                    . " FROM `tasks` "
                    . " WHERE `tasks`.`id` = ".$id
                    . " AND `tasks`.`permanent` = 1"
                    . " AND `tasks`.`user_id` = " .$this->m->_user->id
                    . " LIMIT 1"
            );
        $this->m->_db->loadObject($data);
        
        if(!$data) {
            echo '{"status":"error"}';
            return false;            
        }
        
        $row->user_id = $this->m->_user->id;
        $row->task_id = $data->id;
        $row->date = date("Y-m-d",$_GET['date']);
        $row->created = date('Y-m-d H:i:s');
        
        if($this->m->_db->insertObject('permanent_exceptions',$row)){
            echo '{"status":"success"}';
        }
        
    }
}
?>
