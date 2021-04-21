<?php

namespace App\GraphQL\Mutations;

use App\Events\NewRequest;
use App\Models\Request;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use App\GraphQL\Resolvers\BaseAuthResolver;
use Illuminate\Support\Facades\Auth;

class RequestMutator extends BaseAuthResolver
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
        $user = Auth::user();
        $data['user_id'] = $user->id;

        $request = Request::create($data);

        if ($args->get('priorities')) {
            $request->priorities()->attach($args->get('priorities'));
        }

        broadcast(new NewRequest($request))->toOthers();

        return $this->apiResponse('SUCCESS', 'Created a request.', $request);
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
        $data = $args->except('directive', 'priorities', 'id')->toArray();

        $user = Auth::user();
        $data['user_id'] = $user->id;

        try {
            $request = Request::findOrFail($args->get('id'));
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse('INVALID_REQUEST', 'Request not found.');
        }

        if ($args->get('priorities')) {
            $request->priorities()->sync($args->get('priorities'));
        }

        $request->update($data);

        return $this->apiResponse('SUCCESS', 'Updated a Request.', $request);
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
        $args = collect($args);
        $data = $args->except('directive')->toArray();

        try {
            $request = Request::findOrFail($data['id']);
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse('INVALID_REQUEST', 'Request not found.', $request);
        }

        $request->delete($data);

        return $this->apiResponse('SUCCESS', 'Successfully deleted a request.', $request);
    }
}
