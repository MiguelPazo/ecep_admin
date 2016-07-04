<?php namespace Ecep\Http\Controllers\Auth;

use Ecep\Helpers\HelperApp;
use Ecep\Http\Controllers\Controller;
use Facebook\Facebook;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * The Guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;
    protected $request;

    public function __construct(Guard $auth, Request $request)
    {
        $this->auth = $auth;
        $this->request = $request;

        $this->middleware('guest', ['except' => ['getLogout', 'postLogin']]);
    }

    public function getLogin()
    {
        ////////////GOOGLE//////////
        $goClient = new \Google_Client();
        $goClient->setAuthConfigFile(storage_path('app/google_client_secret.json'));
        $goClient->getHttpClient()->setDefaultOption('verify', false);
        $goClient->setRedirectUri(HelperApp::baseUrl('/end-point/google-auth'));
        $goClient->addScope(\Google_Service_People::USERINFO_EMAIL);
        $goClient->addScope(\Google_Service_People::USERINFO_PROFILE);

        $loginGoogle = $goClient->createAuthUrl();

        ////////////FACEBOOK//////////
        $stateFacebook = md5(time());
        $params = [
            'response_type' => 'code',
            'client_id' => '202664960116201',
            'redirect_uri' => HelperApp::baseUrl('/end-point/facebook-auth'),
            'state' => $stateFacebook,
            'scope' => 'email,user_birthday,user_about_me'
        ];

        $this->request->session()->put('stateFacebook', $stateFacebook);
        $loginFacebook = 'https://www.facebook.com/dialog/oauth?' . http_build_query($params);

        /////////////TWITTER///////////////
        $oAuth = new Oauth1([
            'consumer_key' => 'neRP7ZdxStCIZ0mjYe2Mjqzr4',
            'consumer_secret' => 'wstPlcQkKh0ZelXoLnswdqtLhBhHAiEcn28X2ghaxDsBBN3enz',
            'token' => '490488989-FL3agfPdi3mQCscdqoGVSnNTovWGhdox2LYzD9Sa',
            'token_secret' => 'DuqeS1Byrwdk5bue3n8eq0LpRCDZNuWbFtzsB8HBRVziQ'
        ]);

        $client = new Client();
        $client->setDefaultOption('verify', false);
        $client->setDefaultOption('auth', 'oauth');
        $client->getEmitter()->attach($oAuth);

        $request = $client->post('https://api.twitter.com/oauth/request_token', [
            'body' => [
                'oauth_callback' => HelperApp::baseUrl('/end-point/twitter-auth')
            ]
        ]);

        $oauth_token = null;
        $response = $request->getBody()->getContents();
        parse_str($response);

        $this->request->session()->put('twitterAuthToken', $oauth_token);

        $loginTwitter = "https://api.twitter.com/oauth/authenticate?oauth_token=$oauth_token";

        ///////////LINKEDIN////////////////
        $stateLinkedin = md5(time());
        $params = [
            'response_type' => 'code',
            'client_id' => '77tkvjzqxkk1w7',
            'redirect_uri' => HelperApp::baseUrl('/end-point/linkedin-auth'),
            'state' => $stateLinkedin,
            'scope' => 'r_basicprofile,r_emailaddress'
        ];

        $this->request->session()->put('stateLinkedin', $stateLinkedin);
        $loginLinkedin = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);

        return view('auth.login')
            ->with('loginTwitter', $loginTwitter)
            ->with('loginLinkedin', $loginLinkedin)
            ->with('loginFacebook', $loginFacebook)
            ->with('loginGoogle', $loginGoogle);
    }

    public function getGoogleLogin()
    {
        $accesToken = $this->request->session()->get('access_token');

        $goClient = new \Google_Client();
        $goClient->getHttpClient()->setDefaultOption('verify', false);
        $goClient->setAuthConfigFile(storage_path('app/google_client_secret.json'));
        $goClient->setAccessType('Bearer');
        $goClient->setAccessToken($accesToken);

        $goPlus = new \Google_Service_Plus($goClient);

        $data = [
            'provider' => 'google',
            'access_token' => $accesToken['access_token'],
            'auth_id' => $goPlus->people->get('me')->getId(),
            'email' => $goPlus->people->get('me')->getEmails()[0]->value,
            'names' => $goPlus->people->get('me')->getName()->givenName,
            'lastnames' => $goPlus->people->get('me')->getName()->familyName,
            'image' => $goPlus->people->get('me')->getImage()->url
        ];

        $urlReturn = $this->loginProvider($data);
        return redirect($urlReturn);
    }

    public function getFacebookLogin()
    {
        $accessToken = $this->request->session()->get('access_token');

        $fb = new Facebook([
            'app_id' => '202664960116201',
            'app_secret' => 'f4fdc5856d06d146e19c81c572c737a6',
            'default_graph_version' => 'v2.5',
            'persistent_data_handler' => 'session'
        ]);

        $response = $fb->get('/me?fields=id,first_name,last_name,email,gender,birthday,locale,timezone,picture', $accessToken);
        $user = $response->getGraphUser();

        $data = [
            'provider' => 'facebook',
            'access_token' => $accessToken,
            'auth_id' => $user->getId(),
            'email' => $user->getEmail(),
            'names' => $user->getFirstName(),
            'lastnames' => $user->getLastName(),
            'image' => $user->getPicture()->getUrl()
        ];

        $urlReturn = $this->loginProvider($data);
        return redirect($urlReturn);
    }

    public function getTwitterLogin()
    {
        $key = $this->request->session()->get('twitterToken');
        $keySecret = $this->request->session()->get('twitterTokenSecret');
        $userId = $this->request->session()->get('twitterUserId');

        $oAuth = new Oauth1([
            'consumer_key' => 'neRP7ZdxStCIZ0mjYe2Mjqzr4',
            'consumer_secret' => 'wstPlcQkKh0ZelXoLnswdqtLhBhHAiEcn28X2ghaxDsBBN3enz',
            'token' => $key,
            'token_secret' => $keySecret
        ]);

        $client = new Client();
        $client->setDefaultOption('verify', false);
        $client->setDefaultOption('auth', 'oauth');
        $client->getEmitter()->attach($oAuth);

        $request = $client->get('https://api.twitter.com/1.1/users/show.json', [
            'query' => [
                'id' => $userId,
                'include_entities' => true
            ]
        ])->json();

        $data = [
            'provider' => 'twitter',
            'token' => $key,
            'token_secret' => $keySecret,
            'auth_id' => $userId,
            'names' => $request['name'],
            'image' => $request['profile_image_url_https']
        ];

        $urlReturn = $this->loginProvider($data);
        return redirect($urlReturn);
    }

    public function getLinkedinLogin()
    {
        $accessToken = $this->request->session()->get('access_token');
        $client = new Client();
        $client->setDefaultOption('verify', false);

        $data = [
            'oauth2_access_token' => $accessToken,
            'format' => 'json'
        ];

        $stringInfo = 'id,first-name,last-name,picture-url,email-address';
        $request = $client->get("https://api.linkedin.com/v1/people/~:($stringInfo)?" . http_build_query($data));

        $response = json_decode($request->getBody()->getContents());

        $data = [
            'provider' => 'linkedin',
            'access_token' => $accessToken,
            'auth_id' => $response->id,
            'email' => $response->emailAddress,
            'names' => $response->firstName,
            'lastnames' => $response->lastName,
            'image' => $response->pictureUrl
        ];

        $urlReturn = $this->loginProvider($data);
        return redirect($urlReturn);
    }

    public function getDnieLogin()
    {
        $names = $this->request->session()->get('dni_name');
        $lastnames = $this->request->session()->get('dni_lastname');


        $data = [
            'provider' => 'dnie',
            'names' => $names,
            'lastnames' => $lastnames,
            'image' => 'http://www.hit4hit.org/img/login/user-icon-6.png'
        ];

        $urlReturn = $this->loginProvider($data);
        return redirect($urlReturn);
    }

    public function loginProvider($data)
    {
        Session::flush();

        $this->request->session()->put('user', true);
        $this->request->session()->put('names', $data['names']);
        $this->request->session()->put('image', $data['image']);

        return HelperApp::baseUrl('/admin');
    }

    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : HelperApp::baseUrl('/admin');
    }

    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/';
    }

    public function getLogout()
    {
        Session::flush();

        return redirect(HelperApp::baseUrl('/'));
    }
}
