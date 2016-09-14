<?php
class Registration{
    
    public function __construct(mainframe & $mainframe){
        $this->m = $mainframe;
    }
    
   public function registrate(){
        if($_SERVER['REQUEST_METHOD'] !='POST') return;
        
        $this->validation = true;
                
        $row = new stdClass;
        
        $row->firstname = $this->checkFirstname($_POST['firstname']);
        $row->lastname = $this->checkLastname($_POST['lastname']);        
        $row->email = $this->checkEmail($_POST['email']);
        
        $row->password = $this->checkPassword($_POST['password']);
        $this->checkConfPassword($_POST['password'],$_POST['conf_password']);
        
        $row->date = date('Y-m-d H:i:s');
        
        if ($this->validation === false) {
            return false;
        }

        makeHtmlSafe($row);
                        
        if (!$this->m->_db->insertObject('users', $row, 'id')) {
            return;
        }
        
        //$_POST["email"] = $row->email;
        //$_POST["password"] = $this->pswrd;
        
        $this->m->_auth->login($row->email,$this->pswrd,'/');
    }
    
    private function checkConfPassword($password,$password2){
        $password = trim($password);
        if($password != $password2 || strlen($password2) == 0){
            $this->error->password2 = "Пароли не совпадают";
            $this->validation = false;
            return false;
        }
    }
    private function checkPassword($password){
        $password = trim($password);
        
        if (empty($password) || strlen($password) < 4 || strlen($password) > 40) {
            $this->error->password = "Недопустимая длинная пароля";
            $this->validation = false;
            return false;
        }else if(!preg_match('/^([a-z0-9])+$/i',$password)){
            $this->error->password = "Вы использовали недопустимые символы";
            $this->validation = false;
            return false;
        }
        $this->pswrd = $password;
        $salt   = makePassword(16);
        $crypt  = md5(md5($password) . $salt);
        $password  = $crypt . ':' . $salt;

        return $password;
    }
    
    
    public function checkEmail($email){
        $email = strtolower(trim($email));
        
        if (empty($email) || !is_email($email) || strlen($email) > 140 ) {
            $this->error->email = "Вы не ввели имел либо не коректная длинна";
            $this->json = '{"status":"error","message":"Вы не ввели имел либо не коректная длинна"}';
            $this->validation = false;
            return false;
        }else {
            $this->m->_db->setQuery( "SELECT `id`"
                        . " FROM `users` "
                        . " WHERE `users`.`email` = '".$email."'"  
                        
                        . " LIMIT 1;"
                    );
            $result = $this->m->_db->loadObjectList();  
            
            if(!empty($result)){
                
                    $this->error->email = "Данные имейл уже занят";
                
                
                $this->json = '{"status":"error","message":"Данный имейл уже зарегестрирован"}';
                $this->validation = false;
                return false;
            }
        }
        $this->json = '{"status":"success"}';

        return $email;
    }
    
    private function checkLastname($lastname){
        $lastname = strip_tags(trim($lastname));
        
        if(!$lastname || strlen($lastname) > 40 || strlen($lastname) < 4){
            $this->error->lastname = "Вы не ввели фамилию, либо не коректная длина";
            $this->validation = false;
            return false;
        }
        return $lastname;
    }
    private function checkFirstname($name){
        $name = strip_tags(trim($name));
        
        if(!$name || strlen($name) > 40 || strlen($name) < 2){
            $this->error->firstname = "Вы не ввели Имя, либо не коректная длина";
            $this->validation = false;
            return false;
        }
        return $name;
    }
}
?>
