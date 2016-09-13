<?php
$config = array(
    /*"host" => "192.168.0.6",
    "user" => "clickroom",
    "pass" => "qU3JUNahwjMx6VXa",
    "db"   => "clickroom",*/
    
    "host" => "localhost",
    "user" => "root",
    "pass" => "killer1906",
    "db"   => "tasktable",
    
    //'serverWS' => 'ws://ws.lotostrade.com:7777',
    'serverWS' => 'ws://192.168.0.7:5555',
    
    "memcache_host" => '192.168.0.6',

    "basepath" => "z:/home/front2/www/",
    "email" => "support@onepbx.com.ua",
    "sendername" => "Support Team OnePbx.com.ua",
    "smtp_host"  => "localhost",
    
    'admin_access' => array(
        "87.118.126.64",
        "109.236.90.62",
	"144.76.222.3"
    ),

    "xmpp" => array(
        "host" => "webim.qip.ru",
        "port" => 5222,
        "user" => "none",
        "password" => "none",
        "server" => "qip.ru"
        ),

    "minage" =>18,
    "maxage" =>100,
    
    "socket_password" => "ClueCon",
    "socket_port" => "8021",
    "socket_host" => "127.0.0.1",

    'facebook_app_id' => '146541242362162',
    'facebook_secret' => '51bfa115648721b47a0c879213b08d79',
    
    'google_client_id' => '256193964548-k63pdgmhlhgnnhdjo7aa7ib1jo06s8pj.apps.googleusercontent.com',
    'google_client_secret' => 'JrNeHI75B1bZnNonNdrbjpTZ',
    
    'vk_client_id' => '4797457',
    'vk_client_secret' => 'STQ8GZDdy5tNnho7kfBT',
    
    "sitename" => 'Sipuni',
    "siteurl" => 'binobot',
    "siteemail" => 'support@onepbx.com.ua',
    "filesize" => 4 * 1024 * 1024,
    
    'defaultlang' => 'ru',
    'available_languages' => array("en","sv","fi","es","ru","de","pl","zh-chs","da"),
    
    "contact_type" => array(
        "1"=>"Домашний",
        "2"=>"Рабочий",
        "3"=>"Мобильный",
        
        "5"=>"Email",
        "6"=>"Skype",
    ),
    
    "languages" => array(
        "1" => "Русский",
        "2" => "Английский",
        "3" => "Немецкий",
    ),
    
    "quotes" => array(
        1=>'audjpy',
        2=>'audusd',
        3=>'euraud',
        4=>'eurcad',
        5=>'eurgbp',
        6=>'eurjpy',
        7=>'eurusd',
        8=>'gbpjpy',
        9=>'gbpusd',
        10=>'nzdusd',
        11=>'usdcad',
        12=>'usdchf',
        13=>'usdjpy',
        14=>'gbpaud',
        15=>'gbpcad',
        16=>'nzdchf'
    ),
    
    "characters" => array(
                "Тирион Ланнистер"
                ,"Серсея Ланнистер"
                ,"Дейенерис Таргариен"
                ,"Джон Сноу"
                ,"Санса Старк"
                ,"Арья Старк"
                ,"Джорах Мормонт"
                ,"Джейме Ланнистер"
                ,"Сэмвелл Тарли"
                ,"Теон Грейджой"
                ,"Петир Бейлиш"
                ,"Варис"
                ,"Сандор Клиган"
                ,"Бриенна Тарт"
                ,"Тайвин Ланнистер"
                ,"Бронн Черноводный"
                ,"Джоффри Баратеон"
                ,"Бран Старк"
                ,"Кейтилин Старк"
                ,"Станнис Баратеон"
                ,"Миссандея"
                ,"Маргери Тирелл"
                ,"Давос Сиворт"
                ,"Робб Старк"
                ,"Шая"
                ,"Мелисандра"
                ,"Лилли"
                ,"Томмен Баратеон"
                ,"Русе Болтон"
                ,"Тормунд Великанья Смерть"
                ,"Джендри"
                ,"Игритт"
                ,"Рамси Болтон"
                ,"Даарио Нахарис"
                ,"Якен Хгар"
                ,"Джиор Мормонт"
                ,"Талиса Старк"
                ,"Эддард Старк"
                ,"Кхал Дрого"
                ,"Эллария Сэнд"
                ,"Роберт Баратеон"
                ,"Яра Грейджой"
                ,"Визерис Таргариен"
                ),
    
    'monthes'=>array(
        '1'=>'Январь',
        '2'=>'Февраль',
        '3'=>'Март',
        '4'=>'Апрель',
        '5'=>'Май',
        '6'=>'Июнь',
        '7'=>'Июль',
        '8'=>'Август',
        '9'=>'Сентябрь',
        '10'=>'Октябрь',
        '11'=>'Ноябрь',
        '12'=>'Декабрь'
    ),

    'country'=>array(
        'ua'=>'Україна',
        'ru'=>'Россия'
    ),
    
    'currency'=>array(
//        'USD'=>'USD',
        'UAH'=>'UAH'
    ),
);

$this->addCSS('bootstrap.min')->addCSS("main");

$this->preAddJS('jquery')->addJS('bootstrap.min');

?>