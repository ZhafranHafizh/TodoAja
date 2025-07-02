<?php

if (!function_exists('getCurrentUser')) {
    function getCurrentUser()
    {
        if (session('user_type') === 'user' && session('user_id')) {
            return \App\Models\User::find(session('user_id'));
        }
        return null;
    }
}

if (!function_exists('isMasterUser')) {
    function isMasterUser()
    {
        return session('user_type') === 'master';
    }
}
