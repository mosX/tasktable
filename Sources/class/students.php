<?php
class Students{
    
    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
    
    public function getAll(){
        $this->m->_db->setQuery(
                    "SELECT * FROM `students`"
                    . " WHERE `students`.`user_id` = ".$this->m->_user->id
                    . " AND `students`.`status` = 1"
                    . " ORDER BY `id` DESC"
                );
        $data = $this->m->_db->loadObjectList();
        
        return $data;
    }
    
    public function addNew(){
        $this->validation = true;
        
        $firstname = strip_tags(trim($_POST['firstname']));
        $lastname = strip_tags(trim($_POST['lastname']));
        
        if(!$firstname){
            $this->validation = false;
            $this->error->firstname = 'Вы должны ввести имя';
        }
        
        if(!$firstname){
            $this->validation = false;
            $this->error->lastname = 'Вы должны ввести фамилию';
        }
        
        if(!$this->validation){
            return false;
        }
        
        $row->user_id = $this->m->_user->id;
        $row->firstname = $firstname;
        $row->lastname = $lastname;
        $row->date = date("Y-m-d H:i:s");
        
        
        if($this->m->_db->insertObject('students',$row)){
            return true;
        }
        
        return false;
    }
}
?>
