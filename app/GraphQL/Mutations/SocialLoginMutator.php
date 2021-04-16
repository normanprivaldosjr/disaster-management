<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolvers\BaseAuthResolver;
use App\GraphQL\Resolvers\SocialUserResolver;
use App\Models\User;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class SocialLoginMutator extends BaseAuthResolver
{
    /**
     * Return a value for the field.
     *
     * @param  @param  null  $root Always null, since this field has no parent.
     * @param  array<string, mixed>  $args The field arguments passed by the client.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Shared between all fields.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Metadata for advanced query resolution.
     * 
     * @return mixed
     */
    public function resolve($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $credentials = $this->buildCredentials($args, 'social');

        $social = new SocialUserResolver();
        $user = $social->resolveUserByProviderCredentials($credentials['provider'], $credentials['access_token']);

        $response = $this->makeRequest($credentials);

        Auth::setUser($user);

        $user = User::where('id', Auth::user()->id)->firstOrFail();
        $response['user'] = $user;

        return $response;
    }
}
