<?php

namespace App\GraphQL\Resolvers;

use App\Exceptions\AuthenticationException;
use App\Models\OAuthClient;
use Illuminate\Http\Request;

/**
 * Class BaseAuthResolver.
 */
class BaseAuthResolver
{
    /**
     * @param array  $args
     * @param string $grantType
     *
     * @return mixed
     */
    public function buildCredentials(array $args = [], $grantType = 'password')
    {
        $args = collect($args);
        $credentials = $args->except('directive')->toArray();

        $client = OAuthClient::getPasswordGrantClient();

        $credentials['client_id'] = $args->get('client_id', $client['client_id']);
        $credentials['client_secret'] = $args->get('client_secret', $client['client_secret']);
        $credentials['grant_type'] = $grantType;

        return $credentials;
    }

    /**
     * @param array $credentials
     *
     * @throws AuthenticationException
     *
     * @return mixed
     */
    public function makeRequest(array $credentials)
    {
        $request = Request::create('oauth/token', 'POST', $credentials, [], [], [
            'HTTP_Accept' => 'application/json',
        ]);
        $response = app()->handle($request);
        $decodedResponse = json_decode($response->getContent(), true);

        if ($response->getStatusCode() != 200) {
            if ($decodedResponse['message'] === 'The provided authorization grant (e.g., authorization code, resource owner credentials) or refresh token is invalid, expired, revoked, does not match the redirection URI used in the authorization request, or was issued to another client.') {
                throw new AuthenticationException(__('Authentication exception'), __('Incorrect username or password'));
            }

            throw new AuthenticationException(__($decodedResponse['error']), __($decodedResponse['message']));
        }

        return $decodedResponse;
    }

    /**
     * @param string $status
     * @param string $message
     * @param object $data
     *
     * @return mixed
     */
    public function apiResponse(string $status, string $message = '', object $data = null)
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ];
    }
}
