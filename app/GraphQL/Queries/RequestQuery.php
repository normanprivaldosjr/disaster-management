<?php

namespace App\GraphQL\Queries;

use App\Models\Request;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RequestQuery
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
    public function newRequestCount($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $count = Request::byStatus(1)->get()->count();

        return $count;
    }
}
