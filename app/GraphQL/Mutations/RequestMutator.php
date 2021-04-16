<?php

namespace App\GraphQL\Mutations;

use App\Events\NewRequest;
use App\Models\Request;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RequestMutator
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
    public function create($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $args = collect($args);
        $data = $args->except('directive', 'priorities')->toArray();

        $request = Request::create($data);

        if ($args->get('priorities')) {
            $request->priorities()->attach($args->get('priorities'));
        }

        broadcast(new NewRequest($request))->toOthers();

        return $request;
    }

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
    public function update($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $args = collect($args);
        $data = $args->except('directive', 'priorities')->toArray();

        try {
            $request = Request::findOrFail($data['id']);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException(__('Request not found.'), 400);
        }

        if ($args->get('priorities')) {
            $request->priorities()->sync($args->get('priorities'));
        }

        $request->update($data);

        return $request;
    }

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
    public function delete($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
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
