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
        $data = $args->except('directive')->toArray();

        $user = Auth::user();

        $group = Group::create($data);
        $group->users()->attach($user->id, ['creator' => 1]);

        return $this->apiResponse('SUCCESS', 'Created a group.', $group);
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
        $data = $args->except('directive', 'group_id')->toArray();

        $user = Auth::user();

        try {
            $group = Group::findOrFail($args->get('group_id'));
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse('INVALID_REQUEST', 'Group not found.');
        }

        $is_creator = $group->users()->where('creator', '=', 1)
            ->where('user_id', '=', $user->id)
            ->count();

        if (!$is_creator) {
            return $this->apiResponse('INVALID_REQUEST', 'You are not allowed to edit this group.');
        }

        $group->update($data);

        return $this->apiResponse('SUCCESS', 'Updated a group.', $group);
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
    public function join($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $args = collect($args);

        $user = Auth::user();

        try {
            $group = Group::findOrFail($args->get('group_id'));
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse('INVALID_REQUEST', 'Group not found.');
        }

        $is_member = $group->users()->where('user_id', '=', $user->id)->count();

        if ($is_member) {
            return $this->apiResponse('INVALID_REQUEST', 'You have already joined this group.');
        }

        $group->users()->attach($user->id);

        return $this->apiResponse('SUCCESS', 'Joined a group', $group);
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
    public function leave($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $args = collect($args);
        $group = null;

        $user = Auth::user();

        try {
            $group = Group::findOrFail($args->get('group_id'));
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse('INVALID_REQUEST', 'Group not found.');
        }

        $is_member = $group->users()->where('user_id', '=', $user->id)->count();

        if (!$is_member) {
            return $this->apiResponse('INVALID_REQUEST', 'You have already left this group.');
        }

        $group->users()->detach($user->id);

        return $this->apiResponse('SUCCESS', 'Left a group.', $group);
    }
}
