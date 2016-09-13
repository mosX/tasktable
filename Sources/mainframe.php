<?php 
xload('class.deals');
xload('class.activity');

class mainframe {
    var $_title = null;
    var $_head  = null;
    var $_template = null;
    var $_lang = null;
    var $maincontent = null;
    var $templatepath = null;
    var $abstemplatepath = null;
    var $config = null;
    var $_db = null;
    private $_islogin = false;
    var $_user = null;
    public $menu = array();
    public $_ip = null;
    public $adv_id=null;
    public $questions;
    public $unread_message=null;
    public $_controller;
    public $_action;
    public $_scripts = array();
    public $_jsparams = array();
    public $_stylesheet = array();
    public $_cssparams = array();
    
    static $_redis;
    /*public $facebook=array(
        'client_id'     => '668171449879242',
        'secret'  => '588beff74889cb44920e5d17588aff49'
    );
    public $google = array(
        'client_id'     => '993065650218-cmbq8orvdqmtd0caghh76m4t5gbbpedj.apps.googleusercontent.com',
        'secret'  => 'uGgRrwXuRpQfCsNIijoZ_Rkb'
    );*/

    public $platon = array(
        'client_key' => "SAHH758GU7",
        'password' => "xbFJ40c84pzPf8ZFPjYhRwKZCVBtN5Yp"
    );

    function run() {
        $this->setConfig();
        $this->setDB();
        $this->_auth = new xAuth($this);
        $this->_auth->initSession();
        
        $this->parsePath();
        $this->setLang();
        $this->_user = $this->_auth->getUser();
        $this->unread_message=$this->get_unread_message();
        
        if (is_object($this->_user) && $this->_user->id > 0) {
            $this->_islogin = true;
        }
        
        //if($_GET['datatype']== 'ajax')$this->disableTemplate();
        
        //$this->getUniqueVisitor();  //получаем уникальных пользователей
        
        if (isset($_GET["campaign_code"])){
            if((int)$_GET["campaign_code"]){
                setcookie("campaign_code", $_GET["campaign_code"], 0x6FFFFFFF, "/");
            }

            if("registration" == $this->_path[0]){
                redirect("/registration/");
            }else{
                redirect("/");
            }
        }

        $this->page();
        $this->output();
    }
    
    public function redisConnect(){
        $this->_redis = new Redis();
        $this->_redis->connect('127.0.0.1', 6379);
    }

    public function redisDel($name){
        if(!($this->_redis instanceof Redis))
            self::redisConnect();

        return $this->_redis->delete($name);
    }

    public function redisSet($name,$value){
        if(!($this->_redis instanceof Redis))
            self::redisConnect();

        /*if (!(int)$value) {
            self::redisDel($name);
            return true;
        }*/

        return $this->_redis->set($name,$value);
    }

    public function redisGet($name){
        if(!($this->_redis instanceof Redis))
            self::redisConnect();

        return $this->_redis->get($name);
    }
    
    public function get_unread_message(){
         $this->_db->setQuery(
                    "SELECT COUNT(id) as count "
                    . " FROM `message` "
                    . " WHERE `message`.`readed` = 0 "
                    . " AND `message`.`to_id` = ".$this->_user->id
                 );
         $count = $this->_db->loadResult();
         return  $count;
    }
    
    public function domain(){
        return 'sip'.$this->_user->id.'.onepbx.com.ua';
        //return $this->_user->id.'.'.$this->config->siteurl;
    }
    
    private function setFacebookLib(){
        xload('class.lib.facebook.facebook');
        
        $this->facebook = new Facebook(array(
          'appId'  => $this->config->facebookAppId,
          'secret' => $this->config->facebookAppSecret
        ));
        
        //$user->id = $this->m->facebook->getUser(); //users id
        /*$user = $this->facebook->getUser();
        
        if (!$user->id) {
          $loginUrl = $this->facebook->getLoginUrl(array(    
                                'scope' => 'read_stream, friends_likes, email, publish_actions',
                                'redirect_uri' => 'http://optionnew.com/'
                              ));
            echo "<script>top.location.href='" . $loginUrl . "';</script>\n";
            die();
            return false;
          }*/
        
    }
    
    public function getUniqueVisitor(){
        
        $this->activity = new Activity($this);
        
        $this->activity->visitorUID = $_COOKIE["advuid"];

        if(!$this->activity->visitorUID){  //seting Uids Cookies
            $this->activity->visitorUID = $this->activity->addVisitor();
        }else{      //updating activity time
            
            $this->activity->addActivity();
            $this->activity->updActivity($this->activity->visitorUID);
        }
    }
    
    public function get4Info(){
        $this->_db->setQuery(
                    "SELECT `quotes`.`bid`"
                    . " ,`quotes`.`create_date` as date,`stock`.`title` FROM `quotes` "
                    . " LEFT JOIN `stock` ON `stock`.`id` = `quotes`.`type`"
                    . " ORDER BY `quotes`.`create_date` DESC"
                    . " LIMIT 10"
                );
        return $this->_db->loadObjectList();
    }
    
    protected function page(){
        $needlogged = array("historygames");
        if (isset($this->_path[0]) && in_array($this->_path[0], $needlogged) && !$this->_islogin) {
            redirect("/signin/");
        }
        
        if(!empty($this->_path['0'])){
            $this->_controller = str_replace('-', '_', $this->_path['0']);
            if (!empty($this->_path['1'])) {
                $this->_action = str_replace('-', '_', $this->_path['1']);
            } else {
                $this->_action = 'index';
            }
        } else {
            $this->_action = 'index';
            $this->_controller = 'index';
        }

        xload('class.lib.model');
        
        if (file_exists(XPATH_SOURCES . DS . 'Controllers' .  DS . $this->_controller . 'Controller.php')) {
            
            $objName = $this->_controller . 'Controller';
            
            require_once XPATH_SOURCES . DS . 'Controllers' . DS . $this->_controller . 'Controller.php';
            $actName = $this->_action . 'Action';
            
            if (method_exists($objName,$actName)) {
                
                //$this->controller = new $objName(&$this);
                $this->controller = new $objName($this);
                ob_start();
                    $this->controller->$actName();
                    unset($this->controller);
                    $this->maincontent = ob_get_contents();
                ob_end_clean();
                //die($this->maincontent);
                return;
            } 
        } 
        
        $this->_controller = 'error';
        $this->_action = 'index';
        
        require_once XPATH_SOURCES . DS .'Controllers'. DS . 'errorController.php';
        
        $this->controller = new errorController($this);
        ob_start();
            $this->controller->indexAction();
            unset($this->controller);
            $this->maincontent = ob_get_contents();
        ob_end_clean();
        
    }
    
    public function disableTemplate(){
        $this->_template = '';
    }
    
    function output() {
        if ($this->_controller == 'error') {
            header('HTTP/1.0 404 Not Found');
        }
        
        if ($this->_template === '') {
            echo $this->maincontent;
        } elseif (!empty($this->_template)) {
            include(XPATH_TEMPLATE_FRONT . DS . 'templates' . DS . $this->_template . '.php');
        } else {
            include(XPATH_TEMPLATE_FRONT . DS . 'templates' . DS . 'template.php');
        }
    }
    
    public function setDescription($description) {
        $this->_description = strip_tags($description);
    }
    
    public function setKeywords($keywords) {
        $this->_keywords = strip_tags($keywords);
    }
    
    function showPathway() {
        if (count($this->_pathway)) {
            echo "<div class=\"pathway\">";
            $delimiter = isset($this->pathdelimiter) ? $this->pathdelimiter : " >> ";
            foreach ($this->_pathway as $pathelement) {
                $elements[] = "<a href=\"".$pathelement[1]."\">".$pathelement[0]."</a>";
            }
            echo implode($delimiter, $elements);
            echo "</div>";
        }
    }
    
    public function setTemplate($template, $flag = false){
        $this->_template = $template;
        
        if ($flag == true) {
            $this->_title = null;
            $this->_scripts = array();
            $this->_stylesheet = array();
        }
    }
    
    public function setTitle($title) {
        if (!empty($this->_title))
            $this->_title = strip_tags($title) . " - " . $this->_title;
        else
            $this->_title = strip_tags($title);
    }
    
    public function header() {
        echo "<title>" . $this->_title . "</title>\n"
             . ($this->_description != null ? "<meta name=\"description\" content=\"" . $this->_description . "\" />\n" : "")
             . ($this->_keywords != null ? "<meta name=\"keywords\" content=\"" . $this->_keywords . "\" />\n" : "")
             ;
        
        if (is_array($this->_head) && count($this->_head)) echo implode("\n", $this->_head)."\n";
    }
    
    protected function setConfig() {
        include(XPATH_SOURCES . DS . 'configs' . DS . 'config.php');
        
        foreach($config as $k => $v) {
            $this->config->$k = $v;
        }
    }
    
    protected function setDB() {
        xload('class.lib.database');
        $this->_db = new database($this->config->host, $this->config->user, $this->config->pass, $this->config->db, $this->config->prefix);
    }

    public function add_to_history($user_id = null, $type = null, $action = null, $value = null) {
        $history->user_id = (int)$user_id;
        if (!empty($type))
            $history->type = $type;
        
        if (!empty($action))
            $history->action = $action;
        
        if (!empty($value))
            $history->value = $value;
        
        $history->ip          = $_SERVER["REMOTE_ADDR"];
        $history->user_agent  = $_SERVER["HTTP_USER_AGENT"];
        $refcookiename = "999be3440691882c7227dfad792c7833";//md5("refcookiename-keygames");
        $history->cookie      = $_COOKIE[$refcookiename];
        $history->date        = date("Y-m-d H:i:s");
        if ($this->_db->insertObject("history", $history))
            return true;
        
        return false;
    }
    
    protected function parsePath() {
        $REQUEST_URI = $_SERVER["REQUEST_URI"];
        if (!empty($_SERVER['QUERY_STRING']))
            $REQUEST_URI = str_replace('?' . $_SERVER['QUERY_STRING'], '', $_SERVER["REQUEST_URI"]);
        
        if (substr($REQUEST_URI, -1) != '/' && 'GET' == $_SERVER['REQUEST_METHOD']) {
            @header('HTTP/1.1 301 Moved Permanently');
            //@header('Location: ' . $REQUEST_URI . '/' . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
            redirect($REQUEST_URI . '/' . (!empty($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
            die();
        }
        
        $path = explode('/', strtolower($REQUEST_URI));
        
        array_shift($path);

        if (empty($path[count($path)-1]))
            array_pop($path);
        if (in_array($path[0], $this->config->available_languages)) {
            $this->_lang = $path[0];
            array_shift($path);
        } elseif (!isset($_COOKIE['lang'])) {
            //$this->_lang = self::getLangByIP();
            $this->_lang = $this->config->defaultlang;
        } else {
            $this->_lang = $_COOKIE['lang'];
        }
        setcookie('lang', $this->_lang, 0, '/');
        
        $this->_path = $path;
    }
    
    //если язык не был указан то узнаем язык по АйПи пользователя
    protected function getLangByIP(){
        $this->_ip = $_SERVER["REMOTE_ADDR"];
        $int = self::ip2int($this->_ip);
        
        $country_id = 0;
        
        $query = "SELECT * FROM (SELECT * FROM net_euro WHERE begin_ip <= $int ORDER BY begin_ip DESC LIMIT 1) AS t WHERE end_ip >= $int";
        $this->_db->setQuery($query);
        $country_id = $this->_db->loadResult();
        
        if (empty($country_id)) {
            $query = "SELECT country_id FROM (SELECT * FROM net_country_ip WHERE begin_ip <= $int ORDER BY begin_ip DESC LIMIT 1) AS t WHERE end_ip >= $int";
            $this->_db->setQuery($query);
            $country_id  = $this->_db->loadResult();
        }
        
        $query = "SELECT lang FROM net_country WHERE id = '" . $country_id . "' LIMIT 1";
        $this->_db->setQuery($query);
        $lang = $this->_db->loadResult();
        
        if (empty($lang)) {
            $lang = $this->config->defaultlang;
        }
        
        return $lang;
    }
    
    //переводим АйПи в числовое представление для поиска по базе
    private function ip2int($ip){
        $part = explode(".", $ip);
        $int = 0;
        if (count($part) == 4) {
            $int = $part[3] + 256 * ($part[2] + 256 * ($part[1] + 256 * $part[0]));
        }
        return $int;
    }
    
    protected function setLang() {
        
        /*putenv('LC_ALL=ru_RU');
        p(setlocale(LC_ALL, 'ru_RU'));
        p(setlocale(LC_ALL, ''));
        p(setlocale(LC_ALL, 'Russian_Russia.1251'));
        //p(setlocale(LC_ALL, 'Russian_Russia.65001'));
        echo setlocale(LC_ALL, 'russian');
        echo setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
        //bindtextdomain("messages", "./locale");
        p(bindtextdomain("messages", XPATH_TEMPLATE_FRONT . DS . 'locale' . DS));
        textdomain("messages");*/
        
        /*
        //setlocale (LC_ALL,"russian");
        //setlocale (LC_ALL,"");
        $locale = 'ru_RU';
        putenv('LANG='.$locale);
        setlocale(LC_ALL,"");
        setlocale(LC_MESSAGES,$locale);
        setlocale(LC_CTYPE,$locale);
        
        //putenv("LANG=ru_RU");
        
        bindtextdomain ("messages", XPATH_TEMPLATE_FRONT . DS . 'locale');
        textdomain ("messages");
        bind_textdomain_codeset("messages", "UTF-8");*/
        
        //setlocale(LC_MESSAGES, $this->_lang . '_' . strtoupper($this->_lang) . '.UTF-8');
        
        putenv("LC_MESSAGES=".$this->_lang . '_' . strtoupper($this->_lang) . '.UTF-8');
        
        bindtextdomain('messages', XPATH_TEMPLATE_FRONT . DS . 'locale' . DS);
        bind_textdomain_codeset('messages', 'UTF-8');
        textdomain('messages');
    }
    
    function islogin() {
        return $this->_islogin;
    }

    function module($name='') {
        if (!empty($name) && file_exists(XPATH_TEMPLATE_FRONT . DS . 'modules' .  DS . $name . '.php')) {
            require_once(XPATH_TEMPLATE_FRONT .DS. 'modules' .  DS . $name . '.php');
        } elseif(!empty($name) && file_exists(XPATH_TEMPLATE .DS. 'modules' .  DS . $name . '.php')){
            require_once(XPATH_TEMPLATE . DS . 'modules' .  DS . $name . '.php');
        }
    }

    function addHeadTag($tag) {
        $this->_head[] = $tag;
    }
    
    public function js() {
        $links = null;
        foreach($this->_scripts as $key => $item) {
            if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'js' . DS . $item . '.js')) {
                if ($this->_jsparams[$key] == null) {
                    $links .= '<script src="/html/js/' . $item . '.js" type="text/javascript" /></script>';
                } else {
                    $links .= '<script src="/html/js/' . $item . '.js?' . $this->_jsparams[$key] . '" type="text/javascript" /></script>';
                }
            }
        }
        return $links;
    }
    
    public function addJS($jsfile, $jsparam = null) {
        if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'js' . DS . $jsfile . '.js')) {
            array_push($this->_scripts, $jsfile);
            array_push($this->_jsparams, $jsparam);
        }
        return $this;
    }
    
    public function delJS($jsfile) {
        if (in_array($jsfile,$this->_scripts)) {
            unset($this->_scripts[array_search($jsfile, $this->_scripts)]);
        }
        return $this;
    }


    public function preAddJS($jsfile, $jsparam = null) {
        if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'js' . DS . $jsfile . '.js')) {
            array_unshift($this->_scripts, $jsfile);
            array_unshift($this->_jsparams, $jsparam);
        }
        return $this;
    }
    
    public function addCSS($name,$version=null) {
        if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $name . '.css')) {
            array_push($this->_stylesheet, $name);
            array_unshift($this->_cssparams, $version);
        }
        return $this;
    }

    public function delCSS($name) {
        if (in_array($name,$this->_stylesheet)) {
            unset($this->_stylesheet[array_search($name, $this->_stylesheet)]);
        }
        return $this;
    }

    public function preAddCSS($name, $version=null){
        if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $name . '.css')) {
            array_unshift($this->_stylesheet, $name);
            array_unshift($this->_cssparams, $version);
        }
        return $this;
    }
    
    //�?зменить что бы само определяло с какой папки тянуть ЦССК�?
    public function css($flag = false){
        $links = null;
        $data = null;
        //если нужно просто вывести добавленные файлы
        if ($flag == false) {
            foreach($this->_stylesheet as $key=>$file) {
                if (file_exists(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $file . '.css')) {
                    $links .= '<link href="/html/css/' . $file . '.css'. ($this->_cssparams[$key] ? '?'.$this->_cssparams[$key] :''). '" rel="stylesheet" type="text/css" />';
                }
            }
            return $links;
        //если нужно обьеденить и ужать в один файл выбранные файлы
        } else {
            if(!file_exists(XPATH_TEMPLATE_FRONT . DS . 'css' . DS .$this->_controller.DS.$this->_action.'.css')){
                foreach($this->_stylesheet as $file){
                    if (file_exists(XPATH_TEMPLATE_FRONT . '/css/' . $file . '.css')) {
                        $content = file_get_contents(XPATH_TEMPLATE_FRONT . '/css/' . $file . '.css');
                    }
                    //начинаем парсить контент и уберать лишнее
                    $start = strlen($content);
                    
                    $data .= $content;
                    
                    $end = strlen($content);
                }
                
                if(!is_dir(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $this->_controller)) {
                    mkdir(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $this->_controller, 0700);
                }
                file_put_contents(XPATH_TEMPLATE_FRONT . DS . 'css' . DS . $this->_controller . DS . $this->_action . '.css', $data);
            }
            
            $links = '<link href="/html/css/' . $this->_controller . '/' . $this->_action . '.css" rel="stylesheet" type="text/css" />';
            return $links;
            
        }
    }
}


class xNav {
    public $total = 0;
    public $start = 0;
    public $limit = 10;
    public $page  = 1;
    public $url   = "";
    public $_prev = "< Назад";
    public $_next = "Вперед >";


    public function __construct($url, $total=0, $method="") {
            $this->total = $total;

            $this->parseUrl($url, $method);

            $this->page = (int)$_GET['page'] ? (int)$_GET['page'] : 1;

            $this->start = ($this->page-1)*$this->limit;
            
            if ($this->start > $total) { 
                $this->page = 1;
                $this->start = ($this->page-1)*$this->limit;
            }
            
    }

    public function showPages() {
            $total_pages = ceil($this->total/$this->limit);

            if ($total_pages>10) {
                $pages_del = array("...");
                if ($this->page<9) {
                    $pages = array_merge(range(1,10), $pages_del, range($total_pages-1, $total_pages));
                }elseif ($this->page+8>$total_pages) {
                    $pages = array_merge(range(1,2), $pages_del, range($total_pages-9, $total_pages));
                }else{
                    $pages = array_merge(range(1,2), $pages_del, range($this->page-5, $this->page+5), $pages_del, range($total_pages-1, $total_pages));
                }
            }elseif ($total_pages>0){ 
                $pages = range(1,$total_pages);
            }else {
                $pages = array(1);
                $total_pages = 1;
            }

            $str = "";

            if ($this->page==1) {
                $str .= '<a onClick="return false;" class="navpages prev" href="">'.$this->_prev.'</a>';
            }else{
                $str .= '<a class="navpages prev active" href="'.$this->url.'limit='.$this->limit.'&page='.($this->page-1).'">'.$this->_prev.'</a>';
            }

            for($i=0; $i < count($pages);  $i++) {
                if ($pages[$i]=="...") {
                    $str .= " <span> " . $pages[$i]  . " </span> ";
                }
                elseif ($pages[$i]==$this->page) {
                    $str .= '<a onClick="return false" class="navpages pages active" href="">'.$pages[$i].'</a>';
                }
                else {
                    $str .= '<a class="navpages pages" href="'.$this->url.'limit='.$this->limit.'&page='.$pages[$i].'">'.$pages[$i].'</a>';
                }
            }

            if ($this->page==$total_pages) {
                $str .= '<a onClick="return false" class="navpages next" href="">'.$this->_next.'</a>';
            }
            else {
                $str .= '<a class="navpages next active" href="'.$this->url.'limit='.$this->limit.'&page='.($this->page+1).'">'.$this->_next.'</a>';
            }
            return $str;
    }

    function parseUrl($url,$method) {
            $str = array();
            if ($method == "GET") {
                foreach($_GET as $k=>$v) {
                    if ($k=="limit" || $k=="page") continue;
                    if (is_array($v)) {
                        foreach($v as $ky => $val) {
                                $str[] = $k."[".$ky."]=".$val;
                        }
                    }
                    else
                    $str[] = $k."=".$v;
                }
                if (count($str)) {
                    $this->url = $url."?".implode("&",$str);
                }else{
                    $this->url = $url;
                }
            }else $this->url = $url;
            
            strpos($this->url,'?') ? $this->url .= '&' : $this->url .= '?';
            
            
            if (isset($_GET["limit"])) $this->limit = getParam($_GET, "limit",10);
    }
}
?>