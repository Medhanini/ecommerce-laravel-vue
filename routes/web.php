<?php

    Route::get('/{any}', function(){
            return view('landing');
    })->where('any', '.*');