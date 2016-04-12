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
        $fb = new Facebook([
            'app_id' => '202664960116201',
            'app_secret' => 'f4fdc5856d06d146e19c81c572c737a6',
            'default_graph_version' => 'v2.5',
            'persistent_data_handler' => 'session'
        ]);


        $helper = $fb->getRedirectLoginHelper();
        $accessToken = $helper->getAccessToken();
        $oAuth2Client = $fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        $tokenMetadata->validateAppId('202664960116201');
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        }

        $this->request->session()->put('access_token', $accessToken);

        return redirect(HelperApp::baseUrl('/auth/facebook-login'));
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
}
