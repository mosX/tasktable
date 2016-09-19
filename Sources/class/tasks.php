<?php
class Tasks{
    protected $_table = 'tasks';

    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
    
    public function remove($id,$date){
        $id = (int)$id;
        
        //проверяем или есть
        $this->m->_db->setQuery(
                    "SELECT `tasks`.`id` "
                    . " , `tasks`.`permanent`"
                    . " FROM `tasks` "
                    . " WHERE `tasks`.`id` = ".$id
                    . " LIMIT 1"
                );
        $this->m->_db->loadObject($check);
        
        if(!$check->id){
            echo '{"status":"error"}';
            return false;
        }
        
        if($check->permanent){
            $row->user_id = $this->m->_user->id;
            $row->task_id = $id;
            $row->date = date("Y-m-d",$_GET['date']);
            $row->created = date('Y-m-d H:i:s');

            if($this->m->_db->insertObject('permanent_exceptions',$row)){
                echo '{"status":"success"}';
            }
        }else{
            $this->m->_db->setQuery(
                        "UPDATE `tasks` SET `tasks`.`status` = 0"
                        . " WHERE `tasks`.`id` = ".$id
                        . " LIMIT 1"
                    );
            if($this->m->_db->query()){
                echo '{"status":"success"}';        
            }
        }
        
    }
    
    public function getFilledDates(){
        $date = strtotime(date('Y-m-d'));        
        if($_GET['date']){            
            $date = strtotime($_GET['date']);
        }
        
        $start = date('Y-m-01 00:00:00',$date);
        
        $end = date('Y-m-t 23:59:59',$date);
        $permanents_dates = array();
        
        //получаем перманентные записи
        $this->m->_db->setQuery(
                    "SELECT DATE_FORMAT(`tasks`.`start`,'%Y-%m-%d') as start "
                    . " , DATE_FORMAT(`tasks`.`permanent_update`,'%Y-%m-%d') as permanent_update "
                    . " , UNIX_TIMESTAMP(start) as timestamp"
                    //. " , `permanent_exceptions`.`id` as 'ignore'"
                    . " FROM `tasks` "
                    //. " LEFT JOIN `permanent_exceptions` ON `permanent_exceptions`.`task_id` = `tasks`.`id` AND DATE_FORMAT(`permanent_exceptions`.`date`,'%Y-%m-%d') = DATE_FORMAT(`tasks`.`start`,'%Y-%m-%d')"   //проверка на исключение
                    . " WHERE `tasks`.`status` = 1"
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " AND `tasks`.`permanent` = 1"
                    . " AND `tasks`.`status` = 1"
                    //. " AND `permanent_exceptions`.`id` IS NULL"
                    . " GROUP BY start"
                );
        $permanents = $this->m->_db->loadObjectList();
        
        $this->m->_db->setQuery(
                    "SELECT `permanent_exceptions`.* "
                    . " , UNIX_TIMESTAMP(date) as timestamp"
                    . " FROM `permanent_exceptions` "
                    . " WHERE `permanent_exceptions`.`date` > '".$start."'"
                    . " AND `permanent_exceptions`.`date` < '".$end."'"
                    . " AND `permanent_exceptions`.`user_id` = ".$this->m->_user->id 
                );
        $permanent_exceptions = $this->m->_db->loadObjectList('timestamp');
        
        $start_month = (int)date("m",strtotime($start));
        
        foreach($permanents as $item){
            $dayOfWeek = date('N',strtotime($item->start));
            //$startDayOfWeek = strtotime($item->start);
            $startDayOfWeek = strtotime($item->permanent_update);
            
            $temp_date = strtotime($start);
            
            while(date('m',$temp_date) == $start_month){    //пока тот же месяц
                if($temp_date < $startDayOfWeek){   //если дата создание больше чем дата счетчика
                    $temp_date += 60*60*24;
                    continue;
                }
                
                if(date("N",$temp_date) == $dayOfWeek){
                    if($permanent_exceptions[$temp_date]){
                        $temp_date += 60*60*24;
                        continue;
                    }
                    $permanents_dates[] = $temp_date;
                }
                
                $temp_date += 60*60*24;
            }
        }
        
        $this->m->_db->setQuery(
                    "SELECT DATE_FORMAT(`tasks`.`start`,'%Y-%m-%d') as start "
                    . " , UNIX_TIMESTAMP(start) as timestamp"
                    . " FROM `tasks` "
                    . " WHERE `tasks`.`status` = 1"
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " AND `tasks`.`start` > '".$start."'"
                    . " AND `tasks`.`end` < '".$end."'"
                    . " AND `tasks`.`permanent` = 0"
                                    
                    . " GROUP BY start"
                );
        $data = $this->m->_db->loadObjectList();
        $single_dates = array();
        if($data){
            foreach($data as $item){
                $single_dates[] = strtotime($item->start);
            }
        }
        
        $result = array_merge($permanents_dates,$single_dates);
        $result = array_unique($result);
        
        return $result;
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
    
    public function getEditData($id){
        $id = (int)$id;
        if(!$id) return false;
        
        $this->m->_db->setQuery(
                    "SELECT * FROM `tasks` WHERE `tasks`.`id` = ".$id   
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " LIMIT 1"
                );
        $this->m->_db->loadObject($data);
        
        if(!$data) return false;
        
        return $data;
    }
    
    public function edit($id){
        $this->validation = true;
        //получаем заявку
        $this->m->_db->setQuery(
                    "SELECT `tasks`.* "
                    . " FROM `tasks` "
                    . " WHERE `tasks`.`id` = ".$id
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " LIMIT 1"
                );
        $this->m->_db->loadObject($task);
        
        if(!(int)$_POST['date']){
            $this->validation = false;
            $this->error->message = 'Вы должны ввести дату';
        }
        
        $year = date("Y",strtotime($_POST['date']));
        $month = date("m",strtotime($_POST['date']));
        $day = date("d",strtotime($_POST['date']));
        
        $message = strip_tags(trim($_POST['message']));
        
        $start = $_POST['start'];
        $end = $_POST['end'];
        
        $start_date = $year.'-'.$month.'-'.$day.' '.$start;
        $end_date = $year.'-'.$month.'-'.$day.' '.$end;
        
        /*if(!$message){
            $this->validation = false;
            $this->error->message = 'Вы должны ввести заметку';
        }*/
        
        if(strtotime($end_date) < strtotime($start_date)){
            $this->validation = false;
            $this->error->date = 'Дата окончания не может быть раньше даты начала';
        }
        
        if(!$this->validation){
            return false;
        }
        
        $row->id = $task->id;
        $row->user_id = $this->m->_user->id;
        $row->color = $_POST['color'];
        $row->lesson = $_POST['type'];
        $row->start = $start_date;
        $row->end = $end_date;
        $row->permanent = $_POST['permanent'] ? 1:0;
        if(strtotime($row->start) > time()){
            $row->permanent_update = $row->start;
        }
        
        //$row->permanent_update = $row->permanent ? $row->start : 0;
        $row->message = $message;
        $row->date = date('Y-m-d H:i:s');
        
        if($this->m->_db->updateObject('tasks',$row,'id')){
            xload('class.students');
            $class = new Students($this->m);
            $class->removeStudents($row->id);
            //получаем выбранных студентов
            foreach($_POST['students'] as $item){
                if($item != 0)$students[] = $item;
            }
            $students = array_unique($students);
            foreach($students as $item)$class->addStudent($item,$row->id);
            
            redirect('/tasks/edit/'.$id);
            //redirect('/?date='.date("Y-m-d",strtotime($start)));
        }
    }
    
    public function addNew(){
        $this->validation = true;
        $year = $_GET['year'];
        $month = $_GET['month'];
        $day = $_GET['day'];
        
        $message = strip_tags(trim($_POST['message']));
        
        $start = $_POST['start'];
        $end = $_POST['end'];
        
        $start_date = $year.'-'.$month.'-'.$day.' '.$start;
        $end_date = $year.'-'.$month.'-'.$day.' '.$end;
        
        /*if(!$message){
            $this->validation = false;
            $this->error->message = 'Вы должны ввести заметку';
        }*/
        
        if(strtotime($end_date) < strtotime($start_date)){
            $this->validation = false;
            $this->error->date = 'Дата окончания не может быть раньше даты начала';
        }
        
        if(!$this->validation){
            return false;
        }
        
        $row->user_id = $this->m->_user->id;
        $row->lesson = $_POST['color'];
        $row->lesson = $_POST['type'];
        $row->start = $start_date;
        $row->end = $end_date;
        $row->permanent = $_POST['permanent'] ? 1:0;
        
        $row->permanent_update = $row->start;
        $row->message = $message;
        $row->date = date('Y-m-d H:i:s');
        
        if($this->m->_db->insertObject('tasks',$row,'id')){
            xload('class.students');
            $class = new Students($this->m);
            //получаем выбранных студентов
            foreach($_POST['students'] as $item){
                if($item != 0)$students[] = $item;
            }
            $students = array_unique($students);
            foreach($students as $item)$class->addStudent($item,$row->id);
            
            //redirect('/?date='.date("Y-m-d",strtotime($start)));
            redirect('/?date='.date("Y-m-d",strtotime($start)));
        }else{
            //p($this->m->_db->_sql);
        }
    }
    
    public function getData($date){
        $start = date("Y-m-d 00:00:00",strtotime($date));
        $end = date("Y-m-d 23:59:59",strtotime($date));
        //p(date('N',strtotime($start)));
        
        $this->m->_db->setQuery(
                    "SELECT `tasks`.* "
                    . " , `lessons`.`name` as lessons_name"
                    . " , `permanent_exceptions`.`id` as 'ignore'"
                    . " FROM `tasks` "
                    . " LEFT JOIN `lessons` ON `lessons`.`id` = `tasks`.`lesson`"
                    . " LEFT JOIN `permanent_exceptions` ON `permanent_exceptions`.`task_id` = `tasks`.`id` AND DATE_FORMAT(`permanent_exceptions`.`date`,'%Y-%m-%d') = DATE_FORMAT('".$start."','%Y-%m-%d')"   //проверка на исключение
                    . " WHERE 1 "
                    . " AND ((`tasks`.`start` > '".$start."'"
                    . " AND `tasks`.`end` < '".$end."'"
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " AND `tasks`.`permanent` = 0)"
                
                    . " OR (`tasks`.`permanent` = 1 AND DAYOFWEEK(`tasks`.`start`)-1 = '".date('N',strtotime($start))."')) "
                
                    . " AND `tasks`.`status` = 1"
                    . " ORDER BY `id` DESC"
                );
        $data = $this->m->_db->loadObjectList();
        //p($data);
        
        foreach($data as $key=>$item){
            if($item->ignore) unset($data[$key]);
        }
                        
        return $data;
    }
}
?>
