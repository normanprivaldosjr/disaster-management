<?php

namespace App\GraphQL\Mutations;

use App\Models\Note;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class NoteMutator
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
        $note = Note::create($data);

        return $note;
    }

    public function update($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        try {
            $args = collect($args);
            $data = $args->except('directive')->toArray();
            $note = Note::findOrFail($data['id']);
            $note->update($data);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException(__('Note not found.'), 400);
        }

        return $note;
    }

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
