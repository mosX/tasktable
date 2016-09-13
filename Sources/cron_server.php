#!/usr/bin/php5
<?php
$day_of_week = date("N");

if ($day_of_week == 7 || $day_of_week == 1) {
    die();
}

echo date('Y-m-d H:i:s') . " === CRON START\n";

error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
define('DS', DIRECTORY_SEPARATOR);

define('XPATH', "/home/binaryrobot/public_html/www");

ini_set("memory_limit", "256M");

@date_default_timezone_set('Europe/London');

$config = array(
    "host" => "localhost",
    "user" => "root",
    "pass" => "*LyoliK*",
    "db"   => "binobot",
);

require_once(XPATH . DS . 'Sources' . DS . 'class' . DS . 'lib' . DS . 'database.php');
require_once(XPATH . DS . 'Sources' .  DS . 'functions.php');
require_once(XPATH . DS . 'Sources' .DS.'class'.DS.'lib'.DS.'ws'. DS . 'Client.php');

$db = new database($config["host"], $config["user"], $config["pass"], $config["db"], $config["prefix"]);

class RedisClass{
    public function __construct() {
        $this->connect();
    }
    
    public function connect(){
        $this->_redis = new Redis();
        $this->_redis->connect('127.0.0.1', 6379);
    }

    public function del($name){
        if(!($this->_redis instanceof Redis))
            self::connect();

        return $this->_redis->delete($name);
    }

    public function set($name,$value){
        if(!($this->_redis instanceof Redis))
            self::connect();


        return $this->_redis->set($name,$value);
    }

    public function get($name){
        if(!($this->_redis instanceof Redis))
            self::connect();

        return $this->_redis->get($name);
    }
}

echo "<br>";

$cron = new Cron($db);
$cron->init();

echo "<br>";
echo date('Y-m-d H:i:s') . " === CRON END\n";

class Cron{
    protected $_table = 'users';
    private $workdays = 22;
    private $profit;
    private $parents; // массив всех парентов 
    private $serverWS = 'ws://ws.24boption.com:5555';

    public function __construct($db){
        $this->db = $db;
        $this->redis = new RedisClass();
    }
    
    public function countWorkDays($date){
        $days = cal_days_in_month(CAL_GREGORIAN, date("m",strtotime($date)), date("Y",strtotime($date)));
        $first_day = date("N",strtotime(date("Y-m-01",strtotime($date))));
        
        for($i = 1;$i<=$days;$i++){
            if($first_day == 6 || $first_day == 7){
                $dayoff += 1;
            }
            
            if($first_day == 7){
               $first_day = 1;
               continue;
            }
            
            $first_day++;
        }
        $workdays = $days - $dayoff;
        
        return $workdays;
    }
    
    public function updateBalance(){
        foreach($this->active_users as $item){

            $ids[] = $item->uid;
            $uids[$item->uid] = $item->id;
        }

    if(!$ids) return;

        try{
            $this->ws = new WebSocket\Client($this->serverWS, array('timeout' => 10));
            $this->ws->send('{"name":"getUsersID","ids":['.implode(',',$ids).']}');
            $response = json_decode($this->ws->receive());
        }catch(WebSocket\Exception $e){
            echo 'Ошибка подключения вебсокета';
            return false;
        }
/*p('{"name":"getUsersID","ids":['.implode(',',$ids).']}');
p($response[0]);
die('222'); */

        if($response[0]){
            foreach($response[0] as $key=>$item){
        $this->db->setQuery(
            "UPDATE `settings` SET `settings`.`balance` = ".(int)$item
            . " WHERE `settings`.`user_id` = ".(int)$uids[$key]
            . " LIMIT 1"
        );
                $this->db->query();
                
                $this->active_users[$uids[$key]]->balance = (int)$item;
            }
        }
    }
    
    public function init(){ //Инициализация
        $this->active_users = $this->getActiveUsers();   //получаем активных пользователей
//        $this->updateBalance();

        $this->initProfitPercents();
        $this->initDepositProfit();
    }
    
    private function getLastMonth(){
        $last_month = date('m',strtotime('-1 month'));
        $day = (int)date('d');
        
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, 2, date('Y'));
        $days_in_last_month = cal_days_in_month(CAL_GREGORIAN, $last_month, date('Y'));
        
        $days_array[] = date("Y-m-d",strtotime(date('Y-'.$last_month.'-'.$day)));
        
        if($day == $days_in_month && $days_in_last_month > $day){  //последний день в месяце
            while($day < 31){   //написать цикл добавления в массив
                $day++;
                $days_array[] = date('Y-m-d',strtotime(date('Y-'.$last_month.'-'.$day)));
            }
        }
       
        return $days_array;
    }
    
    private function getUids(){
        foreach($this->active_users as $item){
            $uids[] = $item->uid;
        }
        return $uids;
    }
    
    private function getDeposits($uids){
        //получаем все депозиты
        
        
        //получаем информацию по пользователям что бы узнать trade_days
        $this->db->setQuery(
                    "SELECT `settings`.* "
                    . " , u.`parent`"
                    . " , `users`.`trade_days`"
                    . " FROM `settings` "
                    . " LEFT JOIN `users` u ON u.`id` = `settings`.`user_id`"
                    . " LEFT JOIN `users` ON `users`.`id` = u.`parent`"
                    . " WHERE `settings`.`uid` IN (".implode(',',$uids).")"
                );
        $users = $this->db->loadObjectlist('uid');
        
        //$date = strtotime(date('Y-m-d 23:59:59',strtotime(end($this->getLastMonth()))));
        
        
        $this->db->setQuery(
                    "SELECT `deposits`.* "
                    . " FROM `deposits` "
                    . " WHERE `deposits`.`uid` IN (".implode(',',$uids).")"
                    . " AND `deposits`.`status` = 0"
                );
        $deposits = $this->db->loadObjectList();
        return $deposits;
    }
    
    private function initDepositProfit(){
        $uids = $this->getUids();
        
        $this->db->setQuery(    //получаем информацию по пользователям что бы узнать trade_days
                    "SELECT `settings`.* "
                    . " , u.`parent`"
                    . " , `users`.`trade_days`"
                    . " FROM `settings` "
                    . " LEFT JOIN `users` u ON u.`id` = `settings`.`user_id`"
                    . " LEFT JOIN `users` ON `users`.`id` = u.`parent`"
                    . " WHERE `settings`.`uid` IN (".implode(',',$uids).")"
                );
        $users = $this->db->loadObjectlist('uid');
        $this->deposits = $this->getDeposits($uids);
        
        $date = strtotime(date("Y-m-d 23:59:59",strtotime('-30 days',time())));   //30 дней назад
//  p(date("Y-m-d H:i:s",$date));
        
        if(!$this->deposits) return;
        
        foreach($this->deposits as $item){
        if(!(int)$item->date) continue;
            if(date("Y-m-d",strtotime($item->date)) == date("Y-m-d",$date) && $item->amount > 0){
                $todays[] = $item;
                $todays_sum = $item->amount;
            }

        if(strtotime($item->date) < strtotime(date("Y-m-d 00:00:00",$date)) && $item->amount > 0){  //депозиты меньше текущей даты
                $ids[] = $item->id;
                $plus[$item->uid][] = $item;
                $sum_plus[$item->uid] += $item->amount;
            }
            
            if($item->amount < 0){
                $ids[] = $item->id;
                $minus[$item->uid][] = $item;
                $sum_minus[$item->uid] += $item->amount;
            }
        }

        if(!$todays) return;
        //для каждого из сегодняшних депозитов проводим манипуляции
        foreach($todays as $item){

            if($updated[$item->uid]){   //если у данного юзера уже были депозиты сегодня
                $profit = (int)(($item->amount / 22) * $users[$item->uid]->trade_days);

            }else{
                $profit = ($sum_plus[$item->uid] + $item->amount - $sum_minus[$item->uid]) /10;
                $profit = (int)(($profit / 22) * $users[$item->uid]->trade_days);
            }

        if($profit <= 0) continue;  //если прибыли нету то берем следующего
                                        
                if($updated[$item->uid] == 1){    //если это второй депозит то просто обновляем его
                    $this->db->setQuery(
                                "UPDATE `deposits` "
                                . " SET `deposits`.`status` = 1 "
                                . " , `deposits`.`profit` = ".(int)$profit
                                . " WHERE `deposits`.`id` = ".$item->id
                                . " LIMIT 1"
                            );
                    $this->db->query();
                }else{
                    $updated[$item->uid] = 1;   //ставим статус что обновлять ничегоне надо кроме самого себя

                    //обновляем все депозиты до даты и этот тоже и так же ВСЕ выводы
                    $this->db->setQuery(
                                "UPDATE `deposits` "
                                . " SET `deposits`.`status` = 1 "
                                . " WHERE `deposits`.`id` = ".$item->id
                                . " OR `deposits`.`date` < '".date("Y-m-d 00:00:00",$date)."'"
                                . " OR `deposits`.`amount` < 0"
                            );
                    $this->db->query();
                  }  
                    //обновляем сумму профита
                    $this->db->setQuery(
                                "UPDATE `deposits` SET `deposits`.`profit` = ".(int)$profit
                                . " WHERE `deposits`.`id` = ".$item->id
                                . " LIMIT 1"
                            );
                    $this->db->query();

            //обновляем виртуал баланс паренту
                    $this->db->setQuery(
                                "UPDATE `users` "
                                . " SET `users`.`virtual_balance` =  `users`.`virtual_balance` + ".(int)$profit
                                . " WHERE `users`.`id` = ".$users[$item->uid]->parent
                                . " LIMIT 1"
                            );
                    $this->db->query();

            //Обновляем trade_days = 0 пользователю
                    $this->m->_db->setQuery(
                                "UPDATE `users` "
                                . " SET `users`.`trade_days` =  0 "
                                . " WHERE `users`.`id` = ".$users[$item->uid]->user_id
                                . " LIMIT 1"
                            );
                    $this->m->_db->query();
                    
                    
                    //обновляем логи

                    $logs = new stdClass();
                    $logs->amount = (int)$profit;
                    $logs->user_id = $users[$item->uid]->parent;
                    $logs->deposit_id = $item->id;
                    $logs->from = $users[$item->uid]->user_id;
                    $logs->type = 2;
                    $logs->date = date("Y-m-d H:i:s");
                    $this->db->insertObject('logs',$logs);                
            
        }
        
        //обновляем статус депозитам и выводам
        /*foreach($users as $item){
            $this->m->_db->setQuery(
                        "UPDATE `depsits` SET `deposits`.`status` = 1"
                        . " WHERE ``"
                    );
        }*/
        
        /*foreach($uids as $item){
            $profit = ($sum_plus[$item] - $sum_minus[$item]) /10;
            $profit = (int)(($profit / 22) * $users[$item]->trade_days);
            
            //записуем пользователю
            $this->db->setQuery(
                        "UPDATE `users` SET `users`.`virtual_balance` = `users`.`virtual_balance` + ".$profit
                        . " WHERE `users`.`id` = ".$users[$item]->parent
                        . " LIMIT 1"
                    );
            $this->db->query();
        }*/
    }
  
    private function initProfitPercents(){
        $this->workdays = $this->countWorkDays(date('Y-m-d',time()));   //считаем количество рабочих дней

        foreach($this->active_users as $item){  //формируем массив у кого какой парент
            $this->getParentIds($item->id);
        }

//  die(p($this->parents));

        foreach($this->parents as $item2){
            $ids[] = $item2;
        }
        $ids = array_unique($ids);  //узнаем айдишники парентов
        
        $this->partners = $this->getPartners($ids);   //получаем одним запросом всех партнеров для активных пользователей
        
        //бежим еще раз по пользователям и начисляем им что там положено
        foreach($this->active_users as $item){
//      if($item->id == 25) continue; //TODO убрать
//      if($item->active_users < 10) continue;

//      if($this->partners[$this->parents[$item->id]]->active_users == 0) continue;
//p($this->partners[$this->parents[$item->id]]->active_users);
//            $this->setPartnersProfit($this->parents[$item->id],$item->balance, 0,$item->id);

            $this->setPartnersProfit($this->parents[$item->id],$item->setting_balance, 0,$item->id);
        }
        //обновить виртуал баланс и заинсертить в базу транзакцию c коментом
        
        $this->updateProfits();        
    }
    
    private function updateProfits(){

        foreach($this->profit as $user_id=>$user){
        $amount = 0;
            foreach($user as $item){
                $amount += $item['amount'];

        //обновляем логи
                $logs = new stdClass();
                $logs->amount = $item['amount'];
                $logs->user_id = $user_id;
                $logs->from = $item['parent'];
                $logs->type = 1;
                $logs->date = date("Y-m-d H:i:s");
                $this->db->insertObject('logs',$logs);
            }

            $this->db->setQuery(    //обвновляум
                        "UPDATE `users` "
                        . " SET `users`.`virtual_balance` = `users`.`virtual_balance` + ".$amount
            . " , `users`.`trade_status` = 0"
                        . " WHERE `users`.`id` = ".$user_id
                        . " LIMIT 1"
                    );  
            $this->db->query();
        }
    }
    
    private function getPercents($active_users){
        if($active_users >= 156250){
            $percents = 7.1;
        }else if($active_users < 156250 && $active_users >= 31250){
            $percents = 7;
        }else if($active_users < 31250 && $active_users >= 6250){
            $percents = 6.8;
        }else if($active_users < 6250 && $active_users >= 1250){
            $percents = 6.5;
        }else if($active_users < 1250 && $active_users >= 250){
            $percents = 6;
        }else if($active_users < 250 && $active_users >= 50){
            $percents = 5;
        }else if($active_users < 50 && $active_users >= 10){
            $percents = 3;
        }else{
        return 0;
    }

        return $percents;
    }
    
    private function setPartnersProfit($parent_id, $balance, $percent, $main_id){
        if(!$parent_id) return false;

    if($this->partners[$parent_id]->active_users > 0){  
            $current_percents = $this->getPercents($this->partners[$parent_id]->active_users);  //получаем процент нашего парента
    }

        $profit_percents = $current_percents - $percent ;
        if($profit_percents <= 0) return;

        $profit_percents = rand($profit_percents*7 , $profit_percents*10) / 10;

        $profit = (int)((($balance/100) * $profit_percents)/$this->workdays);

        $this->profit[$parent_id][] = array('parent'=>$main_id,'amount'=>$profit,'profit_percent'=>$profit_percents,'current_percent'=>$current_percents);
        
        $this->setPartnersProfit($this->parents[$parent_id],$balance, $current_percents,$main_id);   //переходим к следующему
    }
    
    private function getPartners($ids){
        $this->db->setQuery(
                    "SELECT `users`.* "
                    . " FROM `users` "
                     ." WHERE `users`.`id` IN (".implode(',',$ids).")"
                );
        $users = $this->db->loadObjectList('id');
        
        return $users;
    }
    
    private function getParentIds($id){
        $data = json_decode($this->redis->get($id));
        if($id == 0) return $parents;
        $this->parents[$id] = key($data);
        
        $this->getParentIds($this->parents[$id]);
    }
    
    private function getActiveUsers(){
        $this->db->setQuery(
                    "SELECT `users`.* "
                    . " , `settings`.`uid`"
            . " , `settings`.`balance` as setting_balance"
                    . " , (SELECT SUM(`deposits`.`amount`) FROM `deposits` WHERE `deposits`.`uid` = `settings`.`uid`) as deposits"
                    . " FROM `users` "
                    . " LEFT JOIN `settings` ON `settings`.`user_id` = `users`.`id`"
                    . " WHERE `trade_status` = 1"
                );
        $data = $this->db->loadObjectList('id');
        return $data;
    }
}        

?>