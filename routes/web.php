<?php

use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    // Redirect to the admin login page, backpack's default login page
    return redirect()->route('backpack.auth.login');
});










    
