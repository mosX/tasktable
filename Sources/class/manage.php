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
        
        $row->name = $name;
        $row->date = date("Y-m-d H:i:s");
        if($this->m->_db->insertObject('lessons',$row)){
            echo '{"status":"success"}';
        }
    }    
}
?>
