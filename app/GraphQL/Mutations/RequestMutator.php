<?php

namespace App\GraphQL\Mutations;

use App\Models\Request;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RequestMutator
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
        $data = $args->except('directive')->toArray();

        $request = Request::create($data);

        return $request;
    }

    public function update($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        try {
            $args = collect($args);
            $data = $args->except('directive')->toArray();

            $request = Request::findOrFail($data['id']);
            $request->update($data);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException(__('Request not found.'), 400);
        }

        return $request;
    }

    public function delete($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        try {
            $args = collect($args);
            $data = $args->except('directive')->toArray();

            $request = Request::findOrFail($data['id']);
            $request->delete($data);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException(__('Request not found.'), 400);
        }

        return $request;
    }
}
