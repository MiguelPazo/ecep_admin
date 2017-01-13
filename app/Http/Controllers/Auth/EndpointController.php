<?php namespace Ecep\Http\Controllers\Auth;

use Ecep\Helpers\HelperApp;
use Ecep\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EndpointController extends Controller
{
    private $request;
    private $error;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->error = $request->get('error');
    }

    public function getGemaltoAuth()
    {
        if (!$this->error) {
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
                return redirect()->to(HelperApp::baseUrl('/'));
            }
        } else {
            return redirect()->to(HelperApp::baseUrl('/'));
        }
    }

    public function getSafeLayer()
    {
        if (!$this->error) {
            $stateSafeLayer = $this->request->session()->get('stateSafelayer');
            $code = $this->request->get('code');
            $state = $this->request->get('state');

            if ($state && $stateSafeLayer == $state) {
                $client = new Client();
                $client->setDefaultOption('verify', false);
                $tokenEndpoint = 'https://trustedx-sfly01.safelayer.com/trustedx-authserver/oauth/eidas-provider/token';

                $request = $client->createRequest('POST', $tokenEndpoint, [
                    'auth' => [
                        '1980955644384241',
                        'd37eb21c07172ee0634e69555e641b212'
                    ],
                    'body' => [
                        'grant_type' => 'authorization_code',
                        'code' => $code,
                        'redirect_uri' => HelperApp::baseUrl('/end-point/safe-layer')
                    ]
                ]);

                $response = json_decode($client->send($request)->getBody()->getContents());

                $this->request->session()->put('access_token', $response->access_token);

                return redirect(HelperApp::baseUrl('/auth/safelayer-login'));
            } else {
                Log::error('State esperado: ' . $stateSafeLayer);
                Log::error('State recivido: ' . $state);
                return redirect()->to(HelperApp::baseUrl('/'));
            }
        } else {
            return redirect()->to(HelperApp::baseUrl('/'));
        }
    }

    public function getGoogleAuth()
    {
        if (!$this->error) {
            $code = $this->request->get('code');

            $goClient = new \Google_Client();
            $goClient->setAuthConfigFile(storage_path('app/google_client_secret.json'));
            $goClient->getHttpClient()->setDefaultOption('verify', false);
            $goClient->setRedirectUri(HelperApp::baseUrl('/end-point/google-auth'));
            $goClient->addScope(\Google_Service_People::USERINFO_EMAIL);
            $goClient->addScope(\Google_Service_People::USERINFO_PROFILE);

            $goClient->authenticate($code);
            dd($goClient->getAccessToken());
            $this->request->session()->put('access_token', $goClient->getAccessToken());

            return redirect(HelperApp::baseUrl('/auth/google-login'));
        } else {
            return redirect()->to(HelperApp::baseUrl('/'));
        }
    }

    public function getFacebookAuth()
    {
        if (!$this->error) {
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
                return redirect()->to(HelperApp::baseUrl('/'));
            }
        } else {
            return redirect()->to(HelperApp::baseUrl('/'));
        }
    }

    public function getLinkedinAuth()
    {
        if (!$this->error) {
            $stateLinkedin = $this->request->session()->get('stateLinkedin');
            $code = $this->request->get('code');
            $state = $this->request->get('state');

            if ($stateLinkedin == $state) {
                $client = new Client();
                $client->setDefaultOption('debug', true);
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
                return redirect()->to(HelperApp::baseUrl('/'));
            }
        } else {
            return redirect()->to(HelperApp::baseUrl('/'));
        }
    }

    public function getTwitterAuth()
    {
        if (!$this->error) {
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
                return redirect()->to(HelperApp::baseUrl('/'));
            }
        } else {
            return redirect()->to(HelperApp::baseUrl('/'));
        }
    }
}
