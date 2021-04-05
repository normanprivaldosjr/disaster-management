<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OAuthClient extends Model
{
    use HasFactory;

    protected $table = 'oauth_clients';

    public static function getPasswordGrantClient()
    {
        try {
            $client = OAuthClient::where('name', 'like', '%Password Grant Client%')->firstorfail();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Client id and secret does not exist. Make sure you install passport properly.', 400);
        }

        return [
            'client_id' => $client->id,
            'client_secret' => $client->secret,
        ];
    }
}
