<?php
class Tasks{
    protected $_table = 'tasks';

    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
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
                    . " FROM `tasks` "
                    . " WHERE `tasks`.`status` = 1"
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " AND `tasks`.`permanent` = 1"
                    . " AND `tasks`.`status` = 1"
                    . " GROUP BY start"
                );
        $permanents = $this->m->_db->loadObjectList();        
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
        
        if(!$message){
            $this->validation = false;
            $this->error->message = 'Вы должны ввести заметку';
        }
        
        if(strtotime($end_date) < strtotime($start_date)){
            $this->validation = false;
            $this->error->date = 'Дата окончания не может быть раньше даты начала';
        }
        
        if(!$this->validation){
            return false;
        }
        
        $row->user_id = $this->m->_user->id;
        $row->start = $start_date;
        $row->end = $end_date;
        $row->permanent = $_POST['permanent'] ? 1:0;
        
        $row->permanent_update = $row->permanent ? $row->start : 0;
        $row->message = $message;
        $row->date = date('Y-m-d H:i:s');
        
        if($this->m->_db->insertObject('tasks',$row)){
            redirect('/?date='.date("Y-m-d",strtotime($start)));
        }
    }
    
    public function getData($date){
        $start = date("Y-m-d 00:00:00",strtotime($date));
        $end = date("Y-m-d 23:59:59",strtotime($date));
        //p(date('N',strtotime($start)));
        
        $this->m->_db->setQuery(
                    "SELECT * "
                    . " FROM `tasks` "
                    . " WHERE 1 "
                    . " AND (`tasks`.`start` > '".$start."'"
                    . " AND `tasks`.`end` < '".$end."'"
                    . " AND `tasks`.`user_id` = ".$this->m->_user->id
                    . " AND `tasks`.`permanent` = 0)"
                
                    . " OR (`tasks`.`permanent` = 1 AND DAYOFWEEK(`tasks`.`start`)-1 = '".date('N',strtotime($start))."') "
                
                    . " AND `tasks`.`status` = 1"
                    . " ORDER BY `id` DESC"
                );
        $data = $this->m->_db->loadObjectList();
        //p($data);
        
        return $data;
    }
}
?>
