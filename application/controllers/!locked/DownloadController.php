<?php 
class DownloadController extends Starter
{
    private $a_files = array();
    private $new_filename = '';
    private $s_file = '';
    private $s_form_file = '';
    private $s_form_type = '';
    private $s_type = '';
    private $s_file_todl = '';
    private $a_download = array();
    private $archive = '';

	function __construct() {
    }

    public function loadDownload()
    {
    	global $starter;

    	$this->s_form_file = htmlentities($_GET['file']);
    	$this->s_form_type = htmlentities($_GET['type']);

		if($this->s_form_type == 'zip'){
	    	if(isset($_POST) && $starter->utils->is__countable($_POST) && count($_POST) > 0 && !empty($_POST['file'])){
				require_once LIBRARY_PATH . "/zip.lib.php"  ;
				$zip = new zipfile () ;
				$_a_download = json_decode(($_POST['file']));
				$_a_download = $_a_download[0];
				$this->a_download = implode(',',$_a_download->index);

				foreach($_a_download as $key => $val)
				{
					if(!is_numeric($val))
					{
						$starter->utils->not_found_page() ;
						break;
					}
				}
				
				if($starter->isApi ){
					$_data = array();
					$_data['download_id'] = $this->a_download;
				
					// CRL code
					$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getList', $_data);
					$this->a_download = $curlApiRequest;
				}else{
					$a_data_query = array(
						'download_id' => array($this->a_download,PDO::PARAM_STR),
					);
					$s_query ="
						SELECT download_path, download_id
						FROM download
						WHERE online = 1
						AND download_id IN (:download_id)";
				 
					$this->a_download = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');
				}
				foreach($this->a_download as $key => $val)
				{
					$file = dirname(__FILE__)  . '/../../secure/' . $val['download_path'];
					if(is_file($file))
					{
						$fo = fopen($file,'r') ;
						$contenu = fread($fo, filesize($file)) ;
						fclose($fo) ;
						$zip->addfile($contenu, $val['download_path']) ;

						if($starter->isApi ){
							$_data = array();
							$_data['download_item'] = intval($val['download_id']);
							$_data['download_user'] = $_SESSION['user_info']['user_id'];
							$_data['download_date'] = date("Y-m-d");
						
							// CRL code
							$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=setStat', $_data);
						}else{
							$a_data_query = array(
								'download_item' => array(intval($val['download_id']),PDO::PARAM_INT),
								'download_user' => array($_SESSION['user_info']['user_id'],PDO::PARAM_INT),
								'download_date' => array(date("Y-m-d"),PDO::PARAM_STR),
							);

							$s_query ="
								INSERT INTO stats_downloads
								SET download_item = :download_item,
								download_user = :download_user,
								download_date = :download_date,";
							$a_query = array(
								"request"		=> "INSERT INTO stats_downloads",
								"fields"		=> array('download_item', 'download_user', 'download_date'),
								"values"		=> array(':download_item', ':download_user', ':download_date')
							);
							$starter->database->prepare_query($s_query,$a_data_query, '', '', $a_query);
						}
					}
					$this->archive = $zip->file() ;
				}
			}
		}elseif($this->s_form_type == 'doc'){
			$s_filename = isset($_GET['doc']) ? htmlentities($_GET['doc']) : '';
			$s_rep = isset($_GET['bp']) ? htmlentities($_GET['bp']) : '';
			$s_path = preg_replace('#.html#','',$this->s_form_file) ;
			$this->s_file = APPLICATION_PATH . '/../secure/' . $s_path . '/' . (!empty($s_rep) ? $s_rep . '/' : '') . $s_filename ;

			$s_pattern = "#^[_a-zA-Z0-9-]*.[a-z]*$#";

			if(empty($s_filename) || !file_exists($this->s_file) || !preg_match($s_pattern, $s_filename)) 
				$starter->utils->not_found_page();
			
			$this->new_filename = $s_filename;
		}else{
	    	switch($this->s_form_type){	    	
	    		default :
	    		case '' :
	    		case 'download' :
			    	$a_data_query = array(
			    		'download_path' => array($this->s_form_file,PDO::PARAM_STR),
					);
					$s_query = "
						SELECT download_id, download_file_name
						FROM download
						WHERE online = 1
						AND archive = 0
						AND download_path = :download_path";

					$a_files = $starter->database->prepare_query($s_query,$a_data_query);
					$s_file_todl = $a_files['download_file_name'];
				break;
			}

			if(!$a_files) 
				$starter->utils->not_found_page();

			if($starter->extranet)
			{
				$a_data_query = array(
					'download_item' => array(intval($a_files['download_id']),PDO::PARAM_INT),
					'download_user' => array($_SESSION['user_info']['user_id'],PDO::PARAM_INT),
					'download_date' => array(date("Y-m-d"),PDO::PARAM_STR),
				);	
				$s_query ="
					INSERT INTO stats_downloads
					SET download_item = :download_item,
					download_user = :download_user,
					download_date = :download_date";
				$a_query = array(
					"request"		=> "INSERT INTO stats_downloads",
					"fields"		=> array('download_item', 'download_user', 'download_date'),
					"values"		=> array(':download_item', ':download_user', ':download_date')
				);
				$starter->database->prepare_query($s_query,$a_data_query,'','',$a_query);
			}
			
			$s_filename = $this->s_form_file ;
			if(empty($s_filename)) 
				$starter->utils->not_found_page() ;
			$s_pattern = "#^[_a-zA-Z0-9-]*.[a-z]*$#";

			if(!preg_match($s_pattern, $s_filename)) 
				$starter->utils->not_found_page() ;

			$this->s_file = APPLICATION_PATH . '/../secure/' . $s_filename ;
			if(!file_exists($this->s_file)) $starter->utils->not_found_page() ;

			$this->new_filename = (!empty($s_file_todl) ? $s_file_todl : $s_filename);
		}
		$this->view();
    }

    public function view(){

    	header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		if($this->s_type == 'zip')
			header('Content-Disposition: attachment; filename=archive.zip');
		else
			header('Content-Disposition: attachment; filename='.basename($this->new_filename));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		if($this->s_type == 'zip')
			echo $archive;
		else{
			header('Content-Length: ' . filesize($this->s_file));
			readfile($this->s_file);
		}
		exit;
    }
}
?>
