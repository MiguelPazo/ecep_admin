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
use Symfony\Component\Debug\Exception\FatalErrorException;

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
        ////////////GEMALTO CF//////////
        $stateGemalto = md5(time());
        $params = [
            'response_type' => 'code',
            'client_id' => 'ecep_admin',
            'redirect_uri' => HelperApp::baseUrl('/end-point/gemalto-auth'),
            'state' => $stateGemalto,
            'scope' => 'openid'
        ];

        $this->request->session()->put('stateGemalto', $stateGemalto);
        $loginGemalto = 'https://idp.reniec.gemalto.com/idp/frontcontroller/openidconnect/authorize?' . http_build_query($params);

        /////////SAFE LAYER MOBILE ID//////////
        $stateSafelayer = md5(time());

        $params = [
            'response_type' => 'code',
            'client_id' => '1980955644384241',
            'redirect_uri' => HelperApp::baseUrl('/end-point/safe-layer'),
            'acr_values' => 'urn:safelayer:tws:policies:authentication:flow:mobileid:crossdevice',
            'state' => $stateSafelayer,
            'scope' => 'urn:safelayer:eidas:full_identity urn:safelayer:eidas:authn_details'
        ];

        $this->request->session()->put('stateSafelayer', $stateSafelayer);
        $loginSafelayer = 'https://trustedx-sfly01.safelayer.com/trustedx-authserver/eidas-provider/oauth?' . http_build_query($params);

        /////////SAFE LAYER USER/PASSWORD//////////
        $stateSafelayerPass = md5(time());

        $params = [
            'response_type' => 'code',
            'client_id' => '1980955644384241',
            'redirect_uri' => HelperApp::baseUrl('/end-point/safe-layer'),
            'acr_values' => 'urn:safelayer:tws:policies:authentication:flow:basic:password',
            'state' => $stateSafelayerPass,
            'scope' => 'urn:safelayer:eidas:full_identity urn:safelayer:eidas:authn_details'
        ];

        $this->request->session()->put('stateSafelayer', $stateSafelayerPass);
        $loginSafelayerPass = 'https://trustedx-sfly01.safelayer.com/trustedx-authserver/eidas-provider/oauth?' . http_build_query($params);

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
        $loginTwitter = '#';

        try {
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
        } catch (\Exception $ex) {
            Log::error($ex->getMessage() . "\n" . $ex->getTraceAsString());
        }

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
            ->with('loginGemalto', $loginGemalto)
            ->with('loginSafelayer', $loginSafelayer)
            ->with('loginSafelayerPass', $loginSafelayerPass)
            ->with('loginTwitter', $loginTwitter)
            ->with('loginLinkedin', $loginLinkedin)
            ->with('loginFacebook', $loginFacebook)
            ->with('loginGoogle', $loginGoogle);
    }

    public function getGemaltoLogin()
    {
        $accessToken = $this->request->session()->get('access_token');
        $refreshToken = $this->request->session()->get('refresh_token');
        $idToken = $this->request->session()->get('id_token');

        $client = new Client();
        $client->setDefaultOption('verify', false);

        $uInfoEndpoint = 'https://idp.reniec.gemalto.com/idp/frontcontroller/openidconnect/userinfo';

        $request = $client->createRequest('GET', $uInfoEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);
        $response = json_decode($client->send($request)->getBody()->getContents(), true);

        $data = [
            'provider' => 'gemalto',
            'access_token' => $accessToken,
            'auth_id' => $response['sub'],
            'names' => array_key_exists('given_name', $response) ? $response['given_name'] : null,
            'lastnames' => array_key_exists('family_name', $response) ? $response['family_name'] : null,
            'birthdate' => array_key_exists('birthdate', $response) ? $response['birthdate'] : null,
            'gender' => array_key_exists('gender', $response) ? $response['gender'] : null,
            'country' => array_key_exists('country', $response) ? $response['country'] : null,
            'state' => array_key_exists('state', $response) ? $response['state'] : null,
            'city' => array_key_exists('city', $response) ? $response['city'] : null,
            'street' => array_key_exists('street', $response) ? $response['street'] : null,
            'email' => array_key_exists('email', $response) ? $response['email'] : null,
            'image' => null,
            'all' => $response
        ];

        $urlReturn = $this->loginProvider($data);
        return redirect($urlReturn);
    }

    public function getSafelayerLogin()
    {
        $accessToken = $this->request->session()->get('access_token');

        $client = new Client();
        $client->setDefaultOption('verify', false);

        $uInfoEndpoint = 'https://trustedx-sfly01.safelayer.com/trustedx-resources/openid/v1/users/me';

        $request = $client->createRequest('GET', $uInfoEndpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken
            ]
        ]);

        $response = json_decode($client->send($request)->getBody()->getContents(), true);
        $idpLogOut = 'https://trustedx-sfly01.safelayer.com/trustedx-authserver/eidas-provider/logout?redirect_uri=' . HelperApp::baseUrl('/end-point/safe-layer');

        $data = [
            'provider' => 'safelayer',
            'access_token' => $accessToken,
            'auth_id' => $response['sub'],
            'names' => array_key_exists('first_name', $response) ? $response['first_name'] : null,
            'lastnames' => array_key_exists('last_name', $response) ? $response['last_name'] : null,
            'country' => array_key_exists('authn_details', $response) ? $response['authn_details']['locationCountryName'] : null,
            'city' => array_key_exists('authn_details', $response) ? $response['authn_details']['locationTimezone'] : null,
            'email' => array_key_exists('email', $response) ? $response['email'] : null,
            'all' => $response
        ];

        $urlReturn = $this->loginProvider($data, $idpLogOut);
        return redirect($urlReturn);
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
            'image' => $goPlus->people->get('me')->getImage()->url,
            'all' => null
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
            'image' => $user->getPicture()->getUrl(),
            'all' => null
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

        $response = $client->get('https://api.twitter.com/1.1/users/show.json', [
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
            'names' => $response['name'],
            'image' => $response['profile_image_url_https'],
            'all' => $response
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

        $request = $client->createRequest('GET', "https://api.linkedin.com/v1/people/~:($stringInfo)?" . http_build_query($data), []);
        $response = json_decode($client->send($request)->getBody()->getContents());

        $data = [
            'provider' => 'linkedin',
            'access_token' => $accessToken,
            'auth_id' => $response->id,
            'email' => $response->emailAddress,
            'names' => $response->firstName,
            'lastnames' => $response->lastName,
            'image' => $response->pictureUrl,
            'all' => $response
        ];

        $urlReturn = $this->loginProvider($data);
        return redirect($urlReturn);
    }

    public function loginProvider($data, $idpLogOut = null)
    {
        Session::flush();

        $this->request->session()->put('user', true);
        $this->request->session()->put('names', $data['names']);
        $this->request->session()->put('image', array_key_exists('image', $data) ? $data['image'] : HelperApp::baseUrl('/img/user.jpg'));
        $this->request->session()->put('data', json_encode($data));

        if ($idpLogOut) {
            $this->request->session()->put('idpLogout', $idpLogOut);
        }

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
        $idpLogout = $this->request->session()->pull('idpLogout');

        Session::flush();

        if ($idpLogout) {
            return redirect()->to($idpLogout);
        } else {
            return redirect()->to(HelperApp::baseUrl('/'));
        }
    }
}
