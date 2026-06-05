<?php 
if($this->isApi ){
	$_data = array();
	$curlApiRequest = $this->sendCurlRequest($this->ApiUri . '?ctrl=GeneralConfig&rquest=get_conf', $_data);
	$this->meta = $curlApiRequest;
}
else{   
	$s_query = "
		SELECT config_meta_title, config_meta_description, config_meta_image, config_template, config_home, detail_title, detail_description, lang 
		FROM config AS t0
		INNER JOIN config_detail AS t1
		ON t1.detail_config = t0.config_id";

	$_a_general_config = $this->database->prepare_query($s_query, array(), '', 'lang');

	if(!isset($_a_general_config[$this->i_lang]))
		$this->meta =  $_a_general_config[1];
	else
		$this->meta =  $_a_general_config[$this->i_lang];
}
?>