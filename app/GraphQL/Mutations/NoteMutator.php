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
        $user = Auth::user();
        $data['user_id'] = $user->id;
        $note = Note::create($data);

        return $this->apiResponse('SUCCESS', 'Created a note.', $note);
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
    public function update($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
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
     * @param $rootValue
     * @param array                                                    $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext|null $context
     * @param \GraphQL\Type\Definition\ResolveInfo                     $resolveInfo
     *
     * @throws \Exception
     *
     * @return array
     */
    public function delete($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        try {
            $args = collect($args);
            $data = $args->except('directive')->toArray();

            $note = Note::findOrFail($data['id']);
            $note->delete($data);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException(__('Note not found.'), 400);
        }

        return $note;
    }
}
