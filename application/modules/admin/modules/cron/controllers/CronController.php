<?php
class Crontab
{
	private		$_dbIni							= 'db.ini';
	private		$db_host						= '';
	private 	$db_login						= '';
	private 	$db_pwd							= '';
	private 	$db_name						= '';
	private 	$db_encode						= '';
	private 	$db_port						= '3306';
	public 		$db_type						= '';
	private 	$db_request						= '';	
	public	 	$db_prefixe						= '';
	public 		$database							;
	private 	$feed;
	private 	$APPLICATION_PATH				= '';
	private 	$APPLICATION_ENV				= '';
	private 	$init							= true;

	function __construct() {
		if(!isset($_SESSION['user_info'])){
			$this->APPLICATION_PATH = dirname( __FILE__ ) . '/../../../../../../application';
			$this->APPLICATION_ENV = 'staging';
			$this->init = false;
		}
        $this->init();
    }

    private function init()
    {
    	if(!$this->init){
	    	$o_parser 			= parse_ini_file($this->APPLICATION_PATH . '/configs/' . $this->_dbIni, true);
			$this->db_host 		= (isset($o_parser[$this->APPLICATION_ENV]['resources.db.params.host']) && !empty($o_parser[$this->APPLICATION_ENV]['resources.db.params.host']) ? $o_parser[$this->APPLICATION_ENV]['resources.db.params.host'] : '');
			$this->db_login		= (isset($o_parser[$this->APPLICATION_ENV]['resources.db.params.username']) && !empty($o_parser[$this->APPLICATION_ENV]['resources.db.params.username']) ? $o_parser[$this->APPLICATION_ENV]['resources.db.params.username'] : '');
			$this->db_pwd 		= (isset($o_parser[$this->APPLICATION_ENV]['resources.db.params.password']) && !empty($o_parser[$this->APPLICATION_ENV]['resources.db.params.password']) ? $o_parser[$this->APPLICATION_ENV]['resources.db.params.password'] : '');
			$this->db_name 		= (isset($o_parser[$this->APPLICATION_ENV]['resources.db.params.dbname']) && !empty($o_parser[$this->APPLICATION_ENV]['resources.db.params.dbname']) ? $o_parser[$this->APPLICATION_ENV]['resources.db.params.dbname'] : '');
			$this->db_encode		= (isset($o_parser[$this->APPLICATION_ENV]['resources.db.params.encode']) && !empty($o_parser[$this->APPLICATION_ENV]['resources.db.params.encode']) ? $o_parser[$this->APPLICATION_ENV]['resources.db.params.encode'] : '');
			$this->db_prefixe	= (isset($o_parser[$this->APPLICATION_ENV]['resources.db.params.prefixe']) && !empty($o_parser[$this->APPLICATION_ENV]['resources.db.params.prefixe']) ? $o_parser[$this->APPLICATION_ENV]['resources.db.params.prefixe'] : ''); 
			$this->db_port	= (isset($o_parser[$this->APPLICATION_ENV]['resources.db.params.port']) && !empty($o_parser[$this->APPLICATION_ENV]['resources.db.params.port']) ? $o_parser[$this->APPLICATION_ENV]['resources.db.params.port'] : ''); 
			$this->db_type	= (isset($o_parser[$this->APPLICATION_ENV]['resources.db.params.dbtype']) && !empty($o_parser[$this->APPLICATION_ENV]['resources.db.params.dbtype']) ? $o_parser[$this->APPLICATION_ENV]['resources.db.params.dbtype'] : ''); 

	    	$this->dbConnexion($this->db_host, $this->db_login, $this->db_pwd, $this->db_name, $this->db_port, $this->db_encode, $this->db_type);
	    }
    	$this->run();
    }

    private function dbConnexion($mysql_host, $mysql_login, $mysql_pwd, $mysql_db, $mysql_port, $mysql_encode = 'utf8', $dbtype = 'mysql')
	{
		$this->feed = null;
		try{
            $this->feed = new PDO($dbtype.":host=" . $mysql_host . ";dbname=" . $mysql_db, $mysql_login, $mysql_pwd);
            $this->feed->exec("set names " . $mysql_encode);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
	}

	private function prepare_query($s_query, $a_values = array(),$s_type = 'single', $_field = '', $aquery= array())
	{
		$_logvars = '';

		$preparedQuery = $this->feed->prepare($s_query);
		if(!empty($a_values) && count($a_values) > 0){
			foreach($a_values as $key => $val){
				$_logvars .= ' ' . $key . ' : ' . $val[0] . '<br>';
				$preparedQuery->bindValue(':' . $key, $val[0], $val[1]);
			}
		}

		$preparedQuery->execute() or exit(print_r($preparedQuery->errorInfo()));
		
		if($s_type == 'single')
			$result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
		
		return $result;
	}

    private function run()
    {
    	$a_data_query = array(
			'ao_end' => array(date('Y-m-d'),PDO::PARAM_STR),
		);
					
		$s_query ="
			UPDATE aos
			SET	ao_status = 2,
			ao_clos = :ao_end
			WHERE ao_end < :ao_end
			AND ao_end != 1";
		if(!isset($_SESSION['user_info'])){				
			$runquery = $this->prepare_query($s_query, $a_data_query);
		}else{
			$runquery = $starter->prepare_query($s_query, $a_data_query);
		}
    }
    
}
?>