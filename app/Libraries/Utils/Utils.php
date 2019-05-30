<?php

namespace App\Libraries\Utils;

use Illuminate\Http\Request;
use JWTAuth;

class Utils
{
    /**
     * @return \App\Models\User\User|null
     */
    public static function getCurrentUser()
    {
        $user = null;
        /* First of all try to auth though Token */
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
        }

        /* If Token user is not available try to get authorisation through AuthFactory */
        if (!$user) {
            $user = auth()->user();
        }

        return $user;
    }

    /**
     * @return int|null
     */
    public static function getCurrentUserId()
    {
        $curUser = self::getCurrentUser();

        return $curUser ? $curUser->id : null;
    }
}