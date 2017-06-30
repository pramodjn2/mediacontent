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
		//include_once APPPATH."libraries/twitter-api-php-client/src/twitteroauth.php";
		include_once APPPATH."libraries/twitter-oauth-php-codexworld/twitteroauth.php";
		 //Twitter API Configuration
	    $consumerKey = $this->config->item('tconsumerKey');
        $consumerSecret = $this->config->item('tconsumerSecret');
        $oauthCallback = $this->config->item('toauthCallback');
		
	    //unset token and token secret from session
		$this->session->unset_userdata('token');
		$this->session->unset_userdata('token_secret');
			
		$connection = new TwitterOAuth($consumerKey, $consumerSecret);
	    $request_token = $connection->getRequestToken($oauthCallback);
		//Received token info from twitter
		$_SESSION['token']		 = $request_token['oauth_token'];
		$_SESSION['token_secret']= $request_token['oauth_token_secret'];
		
	//	echo '<pre/>'; print_r($connection); die;
		
		    //Any value other than 200 is failure, so continue only if http code is 200
            if($connection->http_code == '200'){
				
                //Get twitter oauth url
                $twitterUrl = $connection->getAuthorizeURL($requestToken['oauth_token']);
                $data['oauthURL'] = $twitterUrl;
            }else{
                $data['oauthURL'] = base_url().'user_authentication';
                $data['error_msg'] = 'Error connecting to twitter! try again later!';
            }
			
        		  
      
       /* if (isset($_REQUEST['code'])) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }
*/
      
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