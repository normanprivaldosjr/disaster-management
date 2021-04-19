<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolvers\BaseAuthResolver;
use App\Models\Note;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class NoteMutator extends BaseAuthResolver
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
        $data['user_id'] = $user->id;
        $note = Note::create($data);

        return $this->apiResponse('SUCCESS', 'Created a note.', $note);
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
        $data = $args->except('directive')->toArray();
        $user = Auth::user();

        try {
            $note = Note::findOrFail($data['id']);
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse('INVALID_REQUEST', 'Note not found.');
        }
        $is_creator = $note->user()->where('id', '=', $user->id)->count();

        if (!$is_creator) {
            return $this->apiResponse('INVALID_REQUEST', 'You are not allowed to edit this note.');
        }

        $note->update($data);
        
        return $this->apiResponse('SUCCESS', 'Updated a note.', $note);
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
            $note = Note::findOrFail($data['id']);
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse('INVALID_REQUEST', 'Note not found.', $note);
        }

        $note->delete($data);

        return $this->apiResponse('SUCCESS', 'Successfully deleted a note.', $note);
    }
}
