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
