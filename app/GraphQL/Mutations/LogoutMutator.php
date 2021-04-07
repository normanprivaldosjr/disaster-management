<?php

namespace App\GraphQL\Mutations;

use App\Exceptions\AuthenticationException;
use App\GraphQL\Resolvers\BaseAuthResolver;
use App\Models\AuditTrail;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LogoutMutator extends BaseAuthResolver
{
    /**
     * @param $rootValue
     * @param array                                                    $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext|null $context
     * @param \GraphQL\Type\Definition\ResolveInfo                     $resolveInfo
     *
     * @throws \Exception
     *
     * @return array
     */
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        if (!Auth::guard('api')->check()) {
            throw new AuthenticationException('Not Authenticated', 'Not Authenticated');
        }

        $user = Auth::guard('api')->user();

        Auth::guard('api')->user()->token()->revoke();

        AuditTrail::log($user->id, 'Logged out');

        return [
            'status'  => 'TOKEN_REVOKED',
            'message' => __('Your session has been terminated'),
        ];
    }
}
