<?php namespace Ecep\Http\Controllers\Auth;

use Ecep\Helpers\HelperApp;
use Ecep\Http\Controllers\Controller;
use Facebook\Facebook;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Http\Request;

class EndpointController extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $code = $request->get('code');
        $error = $request->get('error');

        if ($error != null) {
            return 'ocurrio un error!';
        } else if ($code == null) {
            return redirect(HelperApp::baseUrl('/'));
        }
    }

    public function getGoogleAuth()
    {
        $code = $this->request->get('code');
        $goClient = new \Google_Client();
        $goClient->setAuthConfigFile(storage_path('app/google_client_secret.json'));
        $goClient->getHttpClient()->setDefaultOption('verify', false);
        $goClient->setRedirectUri(HelperApp::baseUrl('/end-point/google-auth'));
        $goClient->addScope(\Google_Service_People::USERINFO_EMAIL);
        $goClient->addScope(\Google_Service_People::USERINFO_PROFILE);

        $goClient->authenticate($code);
        $this->request->session()->put('access_token', $goClient->getAccessToken());

        return redirect(HelperApp::baseUrl('/auth/google-login'));
    }

    public function getFacebookAuth()
    {
        $stateFacebook = $this->request->session()->get('stateFacebook');
        $code = $this->request->get('code');
        $state = $this->request->get('state');

        if ($stateFacebook == $state) {
            $client = new Client();
            $client->setDefaultOption('verify', false);

            $request = $client->post('https://graph.facebook.com/v2.3/oauth/access_token', [
                'body' => [
                    'client_id' => '202664960116201',
                    'redirect_uri' => HelperApp::baseUrl('/end-point/facebook-auth'),
                    'client_secret' => 'f4fdc5856d06d146e19c81c572c737a6',
                    'code' => $code
                ]
            ]);

            $response = json_decode($request->getBody()->getContents());
            $this->request->session()->put('access_token', $response->access_token);

            return redirect(HelperApp::baseUrl('/auth/facebook-login'));
        } else {
            echo 'error state';
        }
    }

    public function getLinkedinAuth()
    {
        $stateLinkedin = $this->request->session()->get('stateLinkedin');
        $code = $this->request->get('code');
        $state = $this->request->get('state');

        if ($stateLinkedin == $state) {
            $client = new Client();
            $client->setDefaultOption('verify', false);

            $request = $client->post('https://www.linkedin.com/uas/oauth2/accessToken', [
                'body' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => HelperApp::baseUrl('/end-point/linkedin-auth'),
                    'client_id' => '77tkvjzqxkk1w7',
                    'client_secret' => 'eg9cZVD2csqqY02F'
                ]
            ]);

            $response = json_decode($request->getBody()->getContents());
            $this->request->session()->put('access_token', $response->access_token);

            return redirect(HelperApp::baseUrl('/auth/linkedin-login'));
        } else {
            echo 'error state';
        }
    }

    public function getTwitterAuth()
    {
        $authToken = $this->request->get('oauth_token');
        $authVerifier = $this->request->get('oauth_verifier');

        if ($authToken == $this->request->session()->get('twitterAuthToken')) {
            $oAuth = new Oauth1([
                'consumer_key' => 'neRP7ZdxStCIZ0mjYe2Mjqzr4',
                'consumer_secret' => 'wstPlcQkKh0ZelXoLnswdqtLhBhHAiEcn28X2ghaxDsBBN3enz',
                'token' => $authToken
            ]);

            $client = new Client();
            $client->setDefaultOption('verify', false);
            $client->setDefaultOption('auth', 'oauth');
            $client->getEmitter()->attach($oAuth);

            $request = $client->post('https://api.twitter.com/oauth/access_token', [
                'body' => [
                    'oauth_verifier' => $authVerifier
                ]
            ]);

            $oauth_token = null;
            $oauth_token_secret = null;
            $user_id = null;
            $screen_name = null;

            $response = $request->getBody()->getContents();
            parse_str($response);

            $this->request->session()->put('twitterToken', $oauth_token);
            $this->request->session()->put('twitterTokenSecret', $oauth_token_secret);
            $this->request->session()->put('twitterUserId', $user_id);
            $this->request->session()->put('twitterScreenName', $screen_name);

            return redirect(HelperApp::baseUrl('/auth/twitter-login'));
        } else {
            echo 'error token';
        }
    }

    public function getDnieAuth()
    {
        $wData = array_key_exists('HTTP_RENIECSUBJECTDN', $_SERVER);

        if ($wData) {
            $givename = 'GIVENNAME';
            $surname = 'SURNAME';
            $subject = $_SERVER['HTTP_RENIECSUBJECTDN'];
            $name = substr($subject, strpos($subject, $givename) + strlen($givename) + 1);
            $name = substr($name, 0, strpos($name, ','));
            $lastname = substr($subject, strpos($subject, $surname) + strlen($surname) + 1);
            $lastname = substr($lastname, 0, strpos($lastname, ','));

            $this->request->session()->put('dni_name', $name);
            $this->request->session()->put('dni_lastname', $lastname);

            return redirect(HelperApp::baseUrl('/auth/dnie-login'));

        } else {
            echo 'NO HAY INFO DEL CERTIFICADO';
        }
    }

    public function getGemaltoAuth()
    {
        $stateGemalto = $this->request->session()->get('stateGemalto');
        $code = $this->request->get('code');
        $state = $this->request->get('state');

        if ($stateGemalto == $state) {
            $client = new Client();
            $client->setDefaultOption('verify', false);
            $tokenEndpoint = 'https://idp.reniec.gemalto.com/idp/frontcontroller/openidconnect/token';

            $request = $client->createRequest('POST', $tokenEndpoint, [
                'auth' => [
                    'ecep_admin',
                    '12345678'
                ],
                'body' => [
                    'grant_type' => 'authorization_code',
                    'code' => $code,
                    'redirect_uri' => HelperApp::baseUrl('/end-point/gemalto-auth'),
                    'client_id' => 'ecep_admin'
                ]
            ]);

            $response = json_decode($client->send($request)->getBody()->getContents());

            $this->request->session()->put('access_token', $response->access_token);
            $this->request->session()->put('refresh_token', $response->refresh_token);
            $this->request->session()->put('id_token', $response->id_token);

            return redirect(HelperApp::baseUrl('/auth/gemalto-login'));
        } else {
            Log::error('State esperado: ' . $stateGemalto);
            Log::error('State recivido: ' . $state);
            echo 'error state';
        }
    }
}
