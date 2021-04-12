<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolvers\BaseAuthResolver;
use App\Models\Group;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class GroupMutator extends BaseAuthResolver
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
    public function create($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $args = collect($args);
        $data = $args->except('directive', 'user')->toArray();

        $user = Auth::user();

        $group = Group::create($data);
        $group->users()->attach($user->id, ['creator' => 1]);

        return $group;
    }

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
    public function join($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        $args = collect($args);
        $group = null;

        $user = Auth::user();

        try {
            $group = Group::findOrFail($args->get('group_id'));
            $group->users()->attach($user->id);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException(__('Group not found.'), 400);
        }

        return $group;
    }
}
