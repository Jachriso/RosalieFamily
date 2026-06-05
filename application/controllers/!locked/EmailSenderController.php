<?php
class EmailSender extends Starter
{
	private $mail;

	function __construct() {
        $this->init();
    }

    private function init()
    {
    	global $starter;
		
		require_once LIBRARY_PATH . '/phpmailer/class.phpmailer.php' ;

		$this->mail = new PHPMailer(true); //New instance, with exceptions enabled

		$this->mail->AddReplyTo($starter->mailer['sender']);
		$this->mail->From     = $starter->mailer['sender'];
		$this->mail->FromName = $starter->mailer['name'];
	}

	public function sendEmail($a_data)
	{
    	global $starter;
		
		$s_tpl_file = $a_data['tpl'];
		$s_action = $a_data['action'];

		$to = $a_data['destinataire'];

		$this->mail->Subject = ($a_data['subject']);

		if(!$starter->b_curl) $s_template 		= 	file_get_contents($s_tpl_file) ;
		else		 $s_template 		= 	$starter->utils->curl_load($s_tpl_file) ;

		ob_start();
  		print eval('?>'. $s_template);
  		$s_template = ob_get_contents();
  		ob_end_clean();
		
		$s_template = preg_replace("#{HTTP_ROOT}#", $starter->HTTP_ROOT, $s_template);
		
		// controller
		switch($s_action){
			
			default :

			break;
			
			case 'forgot_pass' :
			
				$s_template  = str_replace('{PWDLINK}', $starter->HTTP_ROOT . $starter->s_lang .  '/' . $starter->mods['forgot_password']['referer'] . '/reset/' . $a_data['link'], $s_template);
			break;
			
			case 'subscribe' :

				$s_template = preg_replace("#{CONFIRMATION}#", $a_data['link'], $s_template);
				
			break;

			case 'subscribe-demand' :
							
				$s_template = preg_replace("#{EMAIL}#", $a_data['EMAIL'], $s_template);
				
			break;

			case 'subscribe-forbiden' :
				
			break;

			case 'support-demand' :
				
				$s_template = preg_replace("#{EMAIL}#", $a_data['EMAIL'], $s_template);
				$s_template = preg_replace("#{SUBJECT}#", ($a_data['SUBJECT']), $s_template);
				$s_template = preg_replace("#{MESSAGE}#", ($a_data['MESSAGE']), $s_template);

			break;

			case 'new-resa' :
				
				$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
				$s_template = preg_replace("#{NOM}#", ($a_data['NOM']), $s_template);

			break;

			case 'update-resa' :
				
				$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
				$s_template = preg_replace("#{NOM}#", ($a_data['NOM']), $s_template);

			break;

			case 'new-trajet' :
				
				$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
				$s_template = preg_replace("#{DESTINATION}#", ($a_data['DESTINATION']), $s_template);
				//$s_template = preg_replace("#{ACTIVITE}#", ($a_data['ACTIVITE']), $s_template);
				$s_template = preg_replace("#{JOUR}#", ($a_data['JOUR']), $s_template);
				$s_template = preg_replace("#{HEURE}#", ($a_data['HEURE']), $s_template);

			break;

			case 'new-covoit' :
				
				$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
				$s_template = preg_replace("#{PRENOMCHILD}#", ($a_data['PRENOMCHILD']), $s_template);
				$s_template = preg_replace("#{DESTINATION}#", ($a_data['DESTINATION']), $s_template);
				//$s_template = preg_replace("#{ACTIVITE}#", ($a_data['ACTIVITE']), $s_template);
				$s_template = preg_replace("#{JOUR}#", ($a_data['JOUR']), $s_template);
				$s_template = preg_replace("#{HEURE}#", ($a_data['HEURE']), $s_template);

			break;

			case 'covoit-demand' :
				
				$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
				$s_template = preg_replace("#{PRENOMCHILD}#", ($a_data['PRENOMCHILD']), $s_template);
				$s_template = preg_replace("#{DESTINATION}#", ($a_data['DESTINATION']), $s_template);
				$s_template = preg_replace("#{JOUR}#", ($a_data['JOUR']), $s_template);
				$s_template = preg_replace("#{CONFIRMATION}#", ($a_data['CONFIRMATION']), $s_template);
				$s_template = preg_replace("#{NAME}#", ($a_data['NAME']), $s_template);
				$s_template = preg_replace("#{ADDRSTART}#", ($a_data['ADDRSTART']), $s_template);

				break;

			case 'covoit-demand-cond' :
				
				$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
				$s_template = preg_replace("#{PRENOMCHILD}#", ($a_data['PRENOMCHILD']), $s_template);
				$s_template = preg_replace("#{DESTINATION}#", ($a_data['DESTINATION']), $s_template);
				$s_template = preg_replace("#{JOUR}#", ($a_data['JOUR']), $s_template);
				$s_template = preg_replace("#{CONFIRMATION}#", ($a_data['CONFIRMATION']), $s_template);
				$s_template = preg_replace("#{NAME}#", ($a_data['NAME']), $s_template);
				$s_template = preg_replace("#{ADDRSTART}#", ($a_data['ADDRSTART']), $s_template);

			break;

			case 'covoit-confirmation' :
				
				$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
				$s_template = preg_replace("#{PRENOMCHILD}#", ($a_data['PRENOMCHILD']), $s_template);
				$s_template = preg_replace("#{DESTINATION}#", ($a_data['DESTINATION']), $s_template);
				$s_template = preg_replace("#{ADDRSTART}#", ($a_data['ADDRSTART']), $s_template);
				$s_template = preg_replace("#{JOUR}#", ($a_data['JOUR']), $s_template);
				//$s_template = preg_replace("#{HEURE}#", ($a_data['HEURE']), $s_template);
				$s_template = preg_replace("#{NAME}#", ($a_data['NAME']), $s_template);

			break;

			case 'covoit-confirmation-cond' :
				
				$s_template = preg_replace("#{PRENOMCHILD}#", ($a_data['PRENOMCHILD']), $s_template);
				$s_template = preg_replace("#{DESTINATION}#", ($a_data['DESTINATION']), $s_template);
				$s_template = preg_replace("#{NAME}#", ($a_data['NAME']), $s_template);

			break;

			case 'adherent-demand' :
			
			$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
			$s_template = preg_replace("#{PRENOMCHILD}#", ($a_data['PRENOMCHILD']), $s_template);
			$s_template = preg_replace("#{EMAIL}#", ($a_data['EMAIL']), $s_template);
			$s_template = preg_replace("#{CONFIRMATION}#", ($a_data['CONFIRMATION']), $s_template);
			$s_template = preg_replace("#{NAME}#", ($a_data['NAME']), $s_template);
			$s_template = preg_replace("#{STRUCTURE}#", ($a_data['STRUCTURE']), $s_template);

			break;
			
			case 'adherent-confirmation' :
			
			$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
			$s_template = preg_replace("#{ASSO}#", ($a_data['ASSO']), $s_template);
			$s_template = preg_replace("#{CONFIRMATION}#", ($a_data['CONFIRMATION']), $s_template);

			break;
			
			case 'confirm-trajet' :
			
			$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
			$s_template = preg_replace("#{DESTINATION}#", ($a_data['DESTINATION']), $s_template);
			$s_template = preg_replace("#{PRENOMCHILD}#", ($a_data['PRENOMCHILD']), $s_template);

			break;
			
			case 'confirm-prisenecharge' :
			
			$s_template = preg_replace("#{PRENOM}#", ($a_data['PRENOM']), $s_template);
			$s_template = preg_replace("#{PRENOMCHILD}#", ($a_data['PRENOMCHILD']), $s_template);

			break;

												/*case 'sharing' :

													$to = $_POST['form_email_receiver'];
													
													$s_template = preg_replace("#{SENDER}#", $_POST['form_email_sender'], $s_template);
													$s_template = preg_replace("#{URI}#", $_POST['form_uri'], $s_template);
													$s_template = preg_replace("#{MESSAGE}#", $_POST['form_comment'], $s_template);
													$mail->Subject	  = $starter->_get_lexique("Un contenu peut vous intÃ©resser");
													
												break;*/
		}

		// sender
		try {				
			
			$this->mail->IsSMTP(false);
			$this->mail->CharSet = 'UTF-8';
			//$mail->IsSMTP(); 
			if($starter->bdebug ) {
				$this->mail->SMTPDebug = true;
			}else{
				$this->mail->SMTPDebug = false;
			}
			$this->mail->SMTPSecure = $starter->mailer['secure'];
			$this->mail->SMTPAuth   = $starter->mailer['smtp_auth'];
			$this->mail->Port       = $starter->mailer['port'];
			$this->mail->Host       = $starter->mailer['host'];
			$this->mail->Username   = $starter->mailer['username'];
			$this->mail->Password   = $starter->mailer['password'];

			if(isset($a_data['attachment']) && is_file($a_data['attachment']))
                $this->mail->AddAttachment($a_data['attachment']); 
            
            if(is_array($to)){
	            foreach($to AS $key => $val){
					$this->mail->AddAddress($val);
				}
			}else{
				$this->mail->AddAddress($to);
			}

			$this->mail->AltBody    = strip_tags($s_template);
			$this->mail->WordWrap   = 80;
			$this->mail->MsgHTML($s_template);
			$this->mail->IsHTML(true);
			$this->mail->Send();
			$a_output['response_code'] = 0 ;
			$a_output['response_message'] 	= $starter->_get_lexique("L'e-mail a été envoyé avec succès");

		} catch (phpmailerException $e) {
			if($starter->bdebug ) {
				echo $e->errorMessage();
			}
			
			$a_output['response_code'] = 1 ;
			$a_output['response_message'] 	= $starter->_get_lexique("Une erreur est survenue lors de l'envoi de l'e-mail");
			$_SESSION['WARNING'] 			= array(
				'type' => 'success',
				'title' => $starter->_get_lexique("Envoie d'email"),
				'content' => array($starter->_get_lexique("L'e-mail a été envoyé avec succès"))
			);
		}
		return $a_output;
		exit();
	}
}?>