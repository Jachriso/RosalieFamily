<?php 
class Send_to_friend extends Starter
{
    public $a_data = array();    
    public $a_include_pages = array();
    public $s_form_shareduri = '';
    public $a_fields = '';

	function __construct() {
        $this->initVars();
    }

    private function initVars()
    {
    	$this->s_form_shareduri = (isset($_GET['shareduri']) ? htmlentities($_GET['shareduri']) : '');
		$this->requestContent();
    }

    private function requestContent()
    {
    	global $starter;
    	$this->a_fields = array(	
			'form_email_sender'	=> 
				array(
					"fieldname"		=> "form_email_sender",
					"type"			=> "text",
					"verif"			=>	array("mandatory"),
					"label"			=>	$starter->_get_lexique('Votre e-mail'),
					"default_value"	=>	$starter->_get_lexique('Votre e-mail'),
					"maxlength"		=>	255,
					"error_label"	=>	$starter->_get_lexique("Saisie de l'e-mail incorrecte"),
					"preg_pattern"	=>	$starter->preg_pattern_email,
				),
				
			'form_email_receiver'	=> 
				array(
					"fieldname"		=> "form_email_receiver",
					"type"			=> "text",
					"verif"			=>	array("mandatory"),
					"label"			=>	$starter->_get_lexique('E-mail du destinataire'),
					"default_value"	=>	$starter->_get_lexique('E-mail du destinataire'),
					"maxlength"		=>	255,
					"error_label"	=>	$starter->_get_lexique("Saisie de l'e-mail incorrecte"),
					"preg_pattern"	=>	$starter->preg_pattern_email,		
				),
				
			'form_comment'	=> 
				array(
					"type"			=> "text",
					"label"			=>	$starter->_get_lexique('Votre message'),
				),
		);
    	if($starter->utils->is__countable($_POST) && count($_POST) > 0)
		{
			require_once LIBRARY_PATH . '/form_checker.class.php' ;
			$starter->checkForm = new form_checker($this->a_fields);

			// output
			if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0)
			{
				$this->a_data['response_code'] = 1 ;
				$this->a_data['response_errors'] = $starter->checkForm->a_errors;	
				$this->a_data['response_message'] = $starter->_get_lexique("Saisie de l'e-mail incorrecte");	
			}
			else
			{
				require_once LIBRARY_PATH . '/phpmailer/class.phpmailer.php' ;
				
				$mail = new PHPMailer(true); //New instance, with exceptions enabled
				$s_result = '' ;
				$s_tpl_file = dirname(__FILE__) . '/../views/email/index.php';

				if(!$starter->b_curl) 
					$s_template = file_get_contents($s_tpl_file) ;
				else		 
					$s_template = $starter->utils->curl_load($s_tpl_file) ;
				
				ob_start();
				print eval('?>'. $s_template);
				$s_template = ob_get_contents();
				ob_end_clean();
				
				$s_action = "sharing";
					
				require_once APPLICATION_PATH . '/modules/email_sender/controllers/index.php' ;
				
				$s_html = '<div class="overlay_container">' . $starter->_get_lexique("Votre e-mail a bien été envoyé.") . '</div>';
				$this->a_data['response_message'] = $s_html ;
				$this->a_data['response_code'] = 0 ;
			}
			$this->view("json");
		}else
			$this->view();
    }

    public function view($type = ''){
    	global $starter;
		// VIEWS
		//return array(1,1,1,$this->s_include,1,1);
		if($type == "json"){
			echo json_encode($this->a_data);
			exit ;
		}else{
			$this->a_include_pages[] = '/views/' . (is_file(APPLICATION_PATH . '/views/' . $starter->s_template . '/' . $starter->s_display . '/header.php') ? $starter->s_display : 'default') . '/header.php' ;
			$this->a_include_pages[] = '/modules/send_to_friend/views/' . (is_file(APPLICATION_PATH .'/modules/special/send_to_friend/views/' . $starter->s_template . '/' . $starter->s_display . '/index.php') ? $starter->s_display : 'default') . '/index.php' ;
			$this->a_include_pages[] = '/views/' . (is_file(APPLICATION_PATH . '/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_display : 'default') . '/footer.php' ;	
		}
    }
}
?>
