<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_Authentication extends CI_Controller
{
    function __construct() {
        parent::__construct();
        // Load user model
        $this->load->model('user');
    	$this->load->library('Facebook');
		  // Load linkedin config
        $this->load->config('linkedin');

    }
    
    public function index(){
		//echo '<pre/>'; print_r($_SERVER); die;
        // Include the google api php libraries
        $userData = array();
		/* gmail */
		include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
        include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
        //Gmail API Configuration
        $clientId = $this->config->item('gclientId');
        $clientSecret = $this->config->item('gclientSecret');
		$redirectUrl = $this->config->item('goauthCallback');
		
  	   // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to codexworld.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

		/* facebook */
		 $data['fbauthUrl'] =  $this->facebook->login_url();
		 
		 /* linkedin */
		include_once APPPATH."libraries/linkedin-oauth-client/http.php";
        include_once APPPATH."libraries/linkedin-oauth-client/oauth_client.php";
		$data['linkedinoauthURL'] = base_url().$this->config->item('linkedin_redirect_url').'?oauth_init=1';
		 
		/* twitter*/
		include_once APPPATH."libraries/twitter-oauth-php-codexworld/twitteroauth.php";
		
		 //Twitter API Configuration
	    $consumerKey = $this->config->item('tconsumerKey');
        $consumerSecret = $this->config->item('tconsumerSecret');
        $oauthCallback = $this->config->item('toauthCallback');
		
		
	   //Get existing token and token secret from session
		$sessToken = $this->session->userdata('token');
		$sessTokenSecret = $this->session->userdata('token_secret');
		
		//Get status and user info from session
		$sessStatus = $this->session->userdata('status');
		$sessUserData = $this->session->userdata('userData');
		
		$this->session->unset_userdata('token');
			$this->session->unset_userdata('token_secret');
			
			//Fresh authentication
			$connection = new TwitterOAuth($consumerKey, $consumerSecret);
			$requestToken = $connection->getRequestToken($oauthCallback);
			
			//Received token info from twitter
			$this->session->set_userdata('token',$requestToken['oauth_token']);
			$this->session->set_userdata('token_secret',$requestToken['oauth_token_secret']);
			
			//Any value other than 200 is failure, so continue only if http code is 200
			if($connection->http_code == '200'){
				//redirect user to twitter
				$twitterUrl = $connection->getAuthorizeURL($requestToken['oauth_token']);
				$data['twitteroauthURL'] = $twitterUrl;
			}else{
				$data['twitteroauthURL'] = base_url().'user_authentication';
				$data['error_msg'] = 'Error connecting to twitter! try again later!';
			}	
		
       $data['authUrl'] = $gClient->createAuthUrl();
       $this->load->view('login',$data);
    }
    
    public function logout() {
        $this->session->unset_userdata('token');
        $this->session->unset_userdata('userData');
        $this->session->sess_destroy();
        redirect('/user_authentication');
    }
}