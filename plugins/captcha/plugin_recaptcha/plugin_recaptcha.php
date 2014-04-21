<?php
if(!defined('_EXEC')) die('No direct access!');
class plugin_recaptcha extends Plugin_CaptchaPlugin
{
	public function getHTML()
	{
		$publicKey = $this->database->Config->recaptcha_publicKey->value;
		$useSSL = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off';
		
		$theme = $this->database->Config->recaptcha_theme->value;
		$js = '<script>var RecaptchaOptions = { theme: \''. $theme .'\'};</script>' . "\n";
		return $js . recaptcha_get_html($publicKey, null, $useSSL);
	}
	
	public function checkCode()
	{
		$privateKey = $this->database->Config->recaptcha_privateKey->value;
		if(!isset($_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']))
			return false;
		$response = recaptcha_check_answer($privateKey, $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
		return $response->is_valid;
	}
}
