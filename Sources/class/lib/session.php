<?php
/**
* Session database table class
*/
class xSession extends DBTable {
    /** @var int Primary key */
    var $session_id               = null;
    /** @var string */
    var $time                     = null;
    /** @var string */
    var $userid                   = null;
    /** @var string */
    var $usertype                 = null;
    /** @var string */
    var $username                 = null;
    /** @var time */
    var $gid                      = null;
    /** @var int */
    var $guest                    = null;
    /** @var string */
    var $_session_cookie          = null;
    /** @var string */
    var $ip                       = null;
    /** @var string */
    var $user_agent               = null;
    

    /**
    * @param database A database connector object
    */
    function __construct(mainframe & $mainframe) {
        $this->m = $mainframe;
        $this->DBTable( 'x_session', 'session_id', $this->m->_db );
    }
        

	/**
	 * @param string Key search for
	 * @param mixed Default value if not set
	 * @return mixed
	 */
	function get( $key, $default=null ) {
		return getParam( $_SESSION, $key, $default );
	}

	/**
	 * @param string Key to set
	 * @param mixed Value to set
	 * @return mixed The new value
	 */
	function set( $key, $value ) {
		$_SESSION[$key] = $value;
		return $value;
	}

	/**
	 * Sets a key from a REQUEST variable, otherwise uses the default
	 * @param string The variable key
	 * @param string The REQUEST variable name
	 * @param mixed The default value
	 * @return mixed
	 */
	function setFromRequest( $key, $varName, $default=null ) {
		if (isset( $_REQUEST[$varName] )) {
			return Session::set( $key, $_REQUEST[$varName] );
		} else if (isset( $_SESSION[$key] )) {
			return $_SESSION[$key];
		} else {
			return Session::set( $key, $default );
		}
	}

	/**
	 * Insert a new row
	 * @return boolean
	 */
    function insert() {
        $ret = $this->m->_db->insertObject( $this->_tbl, $this );

        if( !$ret ) {
            $this->_error = strtolower(get_class( $this ))."::".__STORE_FAILED." <br />" . $this->m->_db->stderr();
            return false;
        } else {
            return true;
        }
    }

	/**
	 * Update an existing row
	 * @return boolean
	 */
    function update( $updateNulls=false ) {
       
        $ret = $this->m->_db->updateObject( $this->_tbl, $this, 'session_id', $updateNulls );
        
        if( !$ret ) {
            $this->_error = strtolower(get_class( $this ))."::".__STORE_FAILED." <br />" . $this->m->_db->stderr();
            return false;
        } else {
            return true;
        }
    }

	/**
	 * Generate a unique session id
	 * @return string
	 */
    function generateId() {
        $failsafe = 20;
        $randnum = 0;

        while ($failsafe--) {
            $randnum = md5( uniqid( microtime(), 1 ) );
            $new_session_id = xAuth::sessionCookieValue( $randnum );
            
            if ($randnum != '') {
                $query = "SELECT $this->_tbl_key"
                       . "\n FROM $this->_tbl"
                       . "\n WHERE $this->_tbl_key = " . $this->m->_db->Quote( $new_session_id )
                       ;
                $this->m->_db->setQuery( $query );
                if(!$result = $this->m->_db->query()) {
                    die( $this->m->_db->stderr( true ));
                }
                
                if ($this->m->_db->getNumRows($result) == 0) {
                    break;
                }
            }
        }
        
        $this->_session_cookie = $randnum;
        $this->session_id 		= $new_session_id;
    }

	/**
	 * @return string The name of the session cookie
	 */
    function getCookie() {
        return $this->_session_cookie;
    }

	/**
	 * Purge lapsed sessions
	 * @return boolean
	 */
    function purge( $inc=1800, $and='' ) {
        global $mainframe;

        //if ($inc == 'core') {
            $past_logged    = time() - 6000; //1800
            $past_guest     = time() - 7200;

            $query = "DELETE FROM $this->_tbl"
            . "\n WHERE "
            // purging expired logged sessions
            . "\n ( time < '" . (int)$past_logged . "' "
            . "\n AND (gid = 1 OR gid = 2)"
            . "\n ) OR "
            . "\n ( time < '" . (int)$past_guest . "' "
            . "\n AND guest = 0"
            . "\n AND (gid = 0 OR gid > 2)"
            . "\n ) OR "
            // purging expired guest sessions
            . "\n ( time < '" . (int)$past_guest . "' "
            . "\n AND guest = 1"
            . "\n )"
            ;
        //} else {
        // kept for backward compatability
        //    $past = time() - $inc;
        //    $query = "DELETE FROM $this->_tbl"
        //           . "\n WHERE ( time < '" . (int) $past . "' )"
        //           . $and
        //           ;
        //}
            $this->m->_db->setQuery($query);

            return $this->m->_db->query();
    }
    
	function delete() {
		$query = "DELETE FROM $this->_tbl"
		       . "\n WHERE $this->_tbl_key = " . $this->m->_db->Quote( $this->session_id )
		       . "\n LIMIT 1;"
		       ;
		
		$this->m->_db->setQuery( $query );

		if ($this->m->_db->query()) {
			return true;
		} else {
			$this->_error = $this->m->_db->getErrorMsg();
			return false;
		}
	}
}
?>