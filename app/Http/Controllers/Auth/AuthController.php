<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Redirect the user to the OAuth Provider.
     *
     * @param $provider
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @param $provider
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);

        return redirect()->route('/');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::whereHas('socialLogin', function ($query) use ($user) {
            $query->where('provider_id', $user->id);
        })->first();

        if ($authUser) {
            return $authUser;
        }

        $social_user = User::where('email', $user->email)->first();

        if (!$social_user) {
            $social_user = User::create([
                'name'     => $user->name,
                'email'    => $user->email,
                'password' => Hash::make(str_random(12))
            ]);
        }

        $social_user->socialLogin()->create([
            'provider' => $provider,
            'provider_id' => $user->id
        ]);

        return $social_user;
    }
}
