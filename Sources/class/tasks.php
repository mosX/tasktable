<?php
class Tasks{
    protected $_table = 'tasks';

    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
    
    public function getFilledDates(){
        $this->m->_db->setQuery(
                    "SELECT DATE_FORMAT(`tasks`.`start`,'%Y-%m-%d') as start "
                    . " , UNIX_TIMESTAMP(start) as timestamp"
                    . " FROM `tasks` "
                    . " WHERE `tasks`.`status` = 1"
                    . " GROUP BY start"
                );
        $data = $this->m->_db->loadObjectList();
        return $data;
    }
    
    public function addNew(){
        
        $year = $_GET['year'];
        $month = $_GET['month'];
        $day = $_GET['day'];
        
        $message = strip_tags(trim($_POST['message']));
        $start = $_POST['start'];
        $end = $_POST['end'];
        
        $start_date = $year.'-'.$month.'-'.$day.' '.$start;
        $end_date = $year.'-'.$month.'-'.$day.' '.$end;
        
        $row->start = $start_date;
        $row->end = $end_date;
        $row->message = $message;
        $row->date = date('Y-m-d H:i:s');
        
        $this->m->_db->insertObject('tasks',$row);
        //p($this->m->_db->_sql);
    }
    
    public function getData($date){
        $start = date("Y-m-d 00:00:00",strtotime($date));
        $end = date("Y-m-d 23:59:59",strtotime($date));
        
        $this->m->_db->setQuery(
                    "SELECT * FROM `tasks` "
                    . " WHERE `tasks`.`start` > '".$start."'"
                    . " AND `tasks`.`end` < '".$end."'"
                    . " ORDER BY `id` DESC"
                );
        $data = $this->m->_db->loadObjectList();
        
        return $data;
    }
}
?>
