<?php
/*
TODO mainframe exseptions
 * TODO tasks delete permanent exsceptions.
 * TODO отображение перманент в тот же день если уже была проверка и была создана разовая заявка
  */
class Tasks{
    protected $_table = 'tasks';

    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
    
    public function clearPermanent($id){
        $id = (int)$id;
        $date = date('Y-m-d 00:00:00',strtotime($_GET['date']));
        
        if(!$id){
            echo '{"status":"error","message":"Не верный айди"}';
            return false;
        }
        
        //получаем запись для проверки и получения предыдущих дней
        $this->m->_db->setQuery(
                    "SELECT `tasks`.* "
                    . " FROM `tasks` "
                    . " WHERE `tasks`.`id` = ".$id
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " AND `tasks`.`permanent` = 1"
                    . " LIMIT 1"
                );
        $this->m->_db->loadObject($data);
        
        if(!$data){
            echo '{"status":"error","message":"Данные не были найдены"}';
            return false;
        }
        
        $this->setPastPermanentDates($data,$date);
        //p($dates);
        
        $this->m->_db->setQuery(
                    "UPDATE `tasks` "
                    . " SET `tasks`.`status` = 0"
                    . " WHERE `tasks`.`id` = ".$id
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " AND `tasks`.`permanent` = 1"
                    . " LIMIT 1"
                );
        if($this->m->_db->query()){
            echo '{"status":"success"}';
        }else{
            echo '{"status":"error"}';
        }
    }
    
    public function setPastPermanentDates($data,$date){
        //foreach($data as $item)$ids[] = $item->id;
        
        //получаем исключения
        $this->m->_db->setQuery(
                    "SELECT `permanent_exceptions`.* "
                    . " , UNIX_TIMESTAMP(`permanent_exceptions`.`date`) as timestamp"
                    . " FROM `permanent_exceptions`"
                    . " WHERE `permanent_exceptions`.`task_id` = ".$data->id
                    . " AND `permanent_exceptions`.`date` < '".$date."'"
                );
        $exseptions_tmp = $this->m->_db->loadObjectList();
        foreach($exseptions_tmp as $item){
            $exseptions[$item->timestamp][$item->task_id] = $item;
        }
        
        //получаем день недели начала 
        $dayOfWeek = date("N",strtotime($data->start));
        //$temp_date = strtotime(date("Y-m-d",strtotime($data->permanent_update)));
        $temp_date = strtotime(date("Y-m-d 00:00:00",strtotime($data->permanent_update) - 60*60*24)); //отнимаем что бы в вайле первым делом прибавить

        while($temp_date < strtotime($date)){
            $temp_date += 60*60*24;
            $upd_timestamp =  strtotime($item->permanent_update);
            if(date("N",$temp_date) != $dayOfWeek) continue;
            //if($exseptions[$temp_date]) continue;       //улучшить систему исключений тут


            if(date("Y-m-d",$temp_date) == date("Y-m-d",$upd_timestamp)){                       //если тот же день
                $end_date = date(date("Y",$upd_timestamp).'-'.date("m",$upd_timestamp).'-'.date("d",$upd_timestamp).' H:i:s',strtotime($item->end));                    

                if(date("Y-m-d H:i:s",$upd_timestamp) > $end_date) continue;
            }

            if($exseptions[$temp_date][$item->id]) continue;
            
            //if(date("N",$temp_date) == $dayOfWeek && date("Y-m-d",$temp_date) != date("Y-m-d",$temp_date) && !$exseptions[$temp_date]){                
            //if(date("N",$temp_date) == $dayOfWeek && date("Y-m-d",$temp_date) != date("Y-m-d",strtotime($data->permanent_update)) && !$exseptions[$temp_date]){
                //добавляем в задачи поле
                $row = new stdClass();
                $row->user_id = $data->user_id;
                $row->message = $data->message;
                $row->lesson = $data->lesson;
                $row->color = $data->color;
                $row->permanent = 0;
                $row->start = date("Y-m-d ".date("H",strtotime($data->start)).":".date("i",strtotime($data->start)).":00",$temp_date);
                $row->end = date("Y-m-d ".date("H",strtotime($data->end)).":".date("i",strtotime($data->end)).":00",$temp_date);

                $row->date = date("Y-m-d H:i:s");
                $row->status = 1;

                $this->m->_db->insertObject('tasks',$row);
            //} 
            //$temp_date += 60*60*24;
        }
    }
    
    public function remove($id,$date){
        $id = (int)$id;
        
        //проверяем или есть
        $this->m->_db->setQuery(
                    "SELECT `tasks`.`id` "
                    . " , `tasks`.`permanent`"
                    . " FROM `tasks` "
                    . " WHERE `tasks`.`id` = ".$id
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
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
            $row->date = date("Y-m-d",strtotime($_GET['date']));
            $row->created = date('Y-m-d H:i:s');

            if($this->m->_db->insertObject('permanent_exceptions',$row)){
                echo '{"status":"success"}';
            }else{                
                echo '{"status":"error"}';
            }
        }else{
            $this->m->_db->setQuery(
                        "UPDATE `tasks` SET `tasks`.`status` = 0"
                        . " WHERE `tasks`.`id` = ".$id
                        . " LIMIT 1"
                    );
            if($this->m->_db->query()){
                echo '{"status":"success"}';        
            }else{
                p($this->m->_db->_sql);
                echo '{"status":"error"}';
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
                    . " , `tasks`.`id`"
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
        //$permanent_exceptions = $this->m->_db->loadObjectList('timestamp');
        $permanent_exceptions_tmp = $this->m->_db->loadObjectList();
        foreach($permanent_exceptions_tmp as $item){
            $permanent_exceptions[$item->timestamp][$item->task_id] = $item;
        }
        
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
                    
                    
                    //бегаем в цикле по искючениям и смотрим или есть для нашего таска в єтот день исключение
                    if($permanent_exceptions[$temp_date][$item->id]){
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
        
        /*foreach($result as $item){
            p(date("Y-m-d",$item));    
        }*/
        
        
        return $result;
    }
    
    /*public function getLessonsList(){
        $this->m->_db->setQuery(
                    "SELECT `lessons`.* "
                    . " FROM `lessons`"
                    . " WHERE `lessons`.`user_id` = ".$this->m->_user->id
                );
        $data  = $this->m->_db->loadObjectList();
        
        return $data;
    }*/
    
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
        
        if(strtotime($end_date) < strtotime($start_date)){
            $this->validation = false;
            $this->error->date = 'Дата окончания не может быть раньше даты начала';
        }
        
        if(!$this->validation){
            return false;
        }
        //p($_POST);
        if($_POST['permanent']){
            //получаем текущий день недели
            $tempDay = date("N",strtotime($start_date));
            $tempTimestamp = strtotime($start_date);
            
            do{
                //p(date('Y-m-d',$tempTimestamp));
                if($_POST['permanent'][date("N",$tempTimestamp)]){
                    $this->addTaskElement($tempTimestamp, $start, $end);
                }
                $tempTimestamp += 60*60*24;
            }while($tempDay != date("N",$tempTimestamp));
            
            return true;            
            //redirect('/?date='.date("Y-m-d",strtotime($start)));
        }else{
            if($this->addTaskElement(strtotime($start_date), $start, $end,0)){
                //redirect('/?date='.date("Y-m-d",strtotime($start)));
                return true;
            }
        }
        return false;
    }
    
    public function addTaskElement($timestamp, $start, $end, $permanent = 1){
        
        $row->user_id = $this->m->_user->id;
        $row->color = $_POST['color'];
        $row->lesson = $_POST['type'];
        $row->start = date("Y-m-d ".$start,$timestamp);
        $row->end = date("Y-m-d ".$end,$timestamp);
        $row->permanent = $permanent;
        
        $row->permanent_update = $row->start;
        $row->message = strip_tags(trim($_POST['message']));
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
        }
        
        return true;
    }
    
    public function getData($date){
        $start = date("Y-m-d 00:00:00",strtotime($date));
        $end = date("Y-m-d 23:59:59",strtotime($date));
        //p(date('N',strtotime($start)));
        
        $this->m->_db->setQuery(
                    "SELECT `tasks`.* "
                    . " , `lessons`.`name` as lessons_name"
                    . " , `permanent_exceptions`.`id` as 'ignore'"
                    . " , `tasks`.`start` as test_start"
                    . " , DATE_FORMAT(`tasks`.`permanent_update`,'%Y:%m:%d') as test_upd"
                    . " FROM `tasks` "
                    . " LEFT JOIN `lessons` ON `lessons`.`id` = `tasks`.`lesson`"
                    . " LEFT JOIN `permanent_exceptions` ON `permanent_exceptions`.`task_id` = `tasks`.`id` AND DATE_FORMAT(`permanent_exceptions`.`date`,'%Y-%m-%d') = DATE_FORMAT('".$start."','%Y-%m-%d')"   //проверка на исключение
                    . " WHERE 1 "
                    . " AND ("
                            ."("
                                ."`tasks`.`start` > '".$start."'"
                                . " AND `tasks`.`end` < '".$end."'"
                                . " AND `tasks`.`permanent` = 0"
                            .") OR ( "
                                ." ( "
                                    . "`tasks`.`permanent` = 1 AND DAYOFWEEK(`tasks`.`start`)-1 = '".date('N',strtotime($start))."'"    //тот же день недели и перманент
                                    //. " AND `tasks`.`permanent_update` < '".$start."'"
                                    . " AND `tasks`.`permanent_update` < '".$end."'"
                                    . " AND ( " //если тот же день
                                        ."( DATE_FORMAT(`tasks`.`permanent_update`,'%H:%i:%s') < DATE_FORMAT(`tasks`.`end`,'%H:%i:%s') AND DATE_FORMAT(`tasks`.`permanent_update`,'%Y-%m-%d') = '".date("Y-m-d",strtotime($date))."')"
                                        ."OR"   //если не тот же день
                                        ."(DATE_FORMAT(`tasks`.`permanent_update`,'%Y-%m-%d') != '".date("Y-m-d",strtotime($date))."') "
                                    ." )"
                                    
                                .")"
                            .")"

                    .") "
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " AND `tasks`.`status` = 1"
                    . " ORDER BY `id` DESC"
                );
        $data = $this->m->_db->loadObjectList();
                        
        foreach($data as $key=>$item){
            if($item->ignore) unset($data[$key]);
        }
                        
        return $data;
    }
}
?>
