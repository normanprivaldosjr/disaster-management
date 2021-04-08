<?php

namespace App\GraphQL\Resolvers;

use App\Models\SocialProvider;
use App\Models\User;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialUserResolver implements SocialUserResolverInterface
{
    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken): ?Authenticatable
    {
        $social = null;

        // Check if Social Login is valid.
        try {
            $social = Socialite::driver($provider)->userFromToken($accessToken);
        } catch (\Exception $e) {
            throw new \Exception(__('Invalid Provider or Token. Please try relogin again.'), 400);
        }

        // Find or Create a user.
        try {
            $user = User::whereHas('socialProviders', function ($query) use ($provider, $social) {
                $query->where('provider', Str::lower($provider))->where('provider_id', $social->getId());
            })->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $user = User::where('email', $social->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $social->getName(),
                    'email' => $social->getEmail(),
                    'password' => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                    'avatar' => $social->getAvatar(),
                ]);
            }

            SocialProvider::create([
                'user_id' => $user->id,
                'provider' => $provider,
                'provider_id' => $social->getId(),
            ]);
        }

        return $user;
    }
}
