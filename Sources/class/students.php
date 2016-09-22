<?php
class Students{
    
    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
    
    public function removeStudents($id){
        $this->m->_db->setQuery(
                    "DELETE FROM `task_students` "
                    . " WHERE `task_students`.`task_id` = ".$id
                    . " AND `task_students`.`user_id` = ".$this->m->_user->id
                );
        $this->m->_db->query();
        /*$this->m->_db->setQuery(
                    "UPDATE `task_students` SET `task_students`.`status` = 0"
                    . " WHERE `task_students`.`task_id` = ".$id
                    . " AND `task_students`.`user_id` = ".$this->m->_user->id
                );
        $this->m->_db->query();*/
    }
    
    public function removeStudent($id){
        $id = (int)$id;
        if(!$id) return;
        
        $this->m->_db->setQuery(
                    "UPDATE `students` SET `students`.`status` = 0"
                    . " WHERE `students`.`user_id` = ".$this->m->_user->id
                    . " AND `students`.`id` = ".$id
                    . " LIMIT 1"
                );
        if($this->m->_db->query()){
            echo '{"status":"success"}';
        }else{
            p($this->m->_db->_sql);
            echo '{"status":"error"}';
        }
    }
    
    public function getTaskStudents($id){
        $this->m->_db->setQuery(
                    "SELECT `task_students`.* "
                    . " , `students`.`firstname`"
                    . " , `students`.`lastname`"
                    . " FROM `task_students` "
                    . " LEFT JOIN `students` ON `students`.`id` = `task_students`.`student_id`"
                    . " WHERE `task_students`.`task_id` = ".$id 
                    . " AND `task_students`.`user_id` = ".$this->m->_user->id
                );
        $data = $this->m->_db->loadObjectList();
        
        return $data;
    }
    
    public function getStudentsList(){
        $this->m->_db->setQuery(
                    "SELECT `students`.* "
                    . " FROM `students`"
                    . " WHERE `students`.`user_id` = ".$this->m->_user->id
                    . " AND `students`.`status` = 1"
                    . " ORDER BY `id` DESC"
                );
        $data = $this->m->_db->loadObjectList();
        
        return $data;
    }
    
    public function addStudent($student_id,$task_id){
        $row->user_id = $this->m->_user->id;
        $row->task_id = $task_id;
        $row->student_id = $student_id;
        $row->date = date("Y-m-d H:i:s");
        $this->m->_db->insertObject('task_students',$row);
    }
    
    public function getAll(){
        $this->m->_db->setQuery(
                    "SELECT `students`.* "
                    . " FROM `students`"
                    . " WHERE `students`.`user_id` = ".$this->m->_user->id
                    . " AND `students`.`status` = 1"
                    . " ORDER BY `id` DESC"
                );
        $data = $this->m->_db->loadObjectList();
        
        return $data;
    }
    
    public function getEditData($id){
        $this->m->_db->setQuery(
                    "SELECT `students`.* FROM `students` WHERE `students`.`id` = ".$id 
                    . " AND `students`.`user_id` = ".$this->m->_user->id
                    . " LIMIT 1"
                );
        $this->m->_db->loadObject($data);
        return $data;
    }
    
    public function edit(){
        $id = (int)$_POST['id'];
        $firstname = strip_tags(trim($_POST['firstname']));
        $lastname = strip_tags(trim($_POST['lastname']));
        $phone = strip_tags(trim($_POST['phone']));
        
        $this->m->_db->setQuery(
                    "UPDATE `students` SET `students`.`firstname` = '".$firstname."'"
                    . " , `students`.`lastname` = '".$lastname."'"
                    . " , `students`.`phone` = '".$phone."'"
                    . " WHERE `students`.`user_id` = ". $this->m->_user->id
                    . " AND `students`.`id` = ".$id
                    . " LIMIT 1"
                );
        if($this->m->_db->query()){
            echo '{"status":"success"}';
        }else{
            echo '{"status":"error"}';
        }
    }
    
    public function addNew(){
        $this->validation = true;
        
        $firstname = strip_tags(trim($_POST['firstname']));
        $lastname = strip_tags(trim($_POST['lastname']));
        $phone = strip_tags(trim($_POST['phone']));
        
        if(!$firstname){
            $this->validation = false;
            $this->error->firstname = 'Вы должны ввести имя';
        }
        
        if(!$this->validation){
            return false;
        }
        
        $row->user_id = $this->m->_user->id;
        $row->firstname = $firstname;
        $row->lastname = $lastname;
        $row->phone = $phone;
        $row->date = date("Y-m-d H:i:s");
        
        if($this->m->_db->insertObject('students',$row)){
            return true;
        }
        
        return false;
    }
}
?>
