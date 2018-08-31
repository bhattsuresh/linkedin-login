<?php
class LinkedIn{
	
	private $linkedinApiKey = null;							
	private $linkedinApiSecret = null;
	private $callbackURL = null;
	private $linkedinScope = 'r_basicprofile r_emailaddress';
	
	
	public function __construct($apiKey,$ApiSecret,$callbackURL){
		$this->linkedinApiKey = $apiKey;
		$this->linkedinApiSecret = $ApiSecret;
		$this->callbackURL = $callbackURL;

	}
	
	public function process(){
	
	
			if (isset($_GET["oauth_problem"]) && $_GET["oauth_problem"] <> "") {
					return null;
					
			}

			$client = new AuthClient;

			$client->debug = false;
			$client->debug_http = true;
			$client->redirect_uri = $this->callbackURL;

			$client->client_id = $this->linkedinApiKey;
			$application_line = __LINE__;
			$client->client_secret = $this->linkedinApiSecret;

			if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
			  return ('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
						'create an application, and in the line '.$application_line.
						' set the client_id to Consumer key and client_secret with Consumer secret. '.
						'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.
						'necessary permissions to execute the API calls your application needs.';

		
			$client->scope = $this->linkedinScope;
			if (($success = $client->Initialize())) {
			  if (($success = $client->Process())) {

				if (strlen($client->authorization_error)) {
				  $client->error = $client->authorization_error;
				  $success = false;
				} elseif (strlen($client->access_token)) {
				  $success = $client->CallAPI(
								'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 
								'GET', array(
									'format'=>'json'
								), array('FailOnAccessError'=>true), $user);
				}
			  }
			  $success = $client->Finalize($success);
			}
			if ($client->exit) return null;
			if ($success) {
				return $user;
			} else {
				return  $client->error;
			}
	}
}
?>

