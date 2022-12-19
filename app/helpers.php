<?php

if (! function_exists('check_has_value')) {
    function check_has_value($value)
    {
        return $value ? $value : "-";
    }
}

if (! function_exists('user_menu_privileges')) {
    function user_menu_privileges()
    {
        if(auth()->user()) {
           return auth()->user()->userMenuPrivileges; 
        }
        return [];
    }
}

if (! function_exists('user_role_privileges')) {
    function user_role_privileges()
    {
        if(auth()->user()) {
           return auth()->user()->userRolePrivileges; 
        }
        return [];
    }
}
