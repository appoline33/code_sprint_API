<?php

\Illuminate\Support\Facades\Route::get('/import',[ \App\Controller\ImportController::class, 'import']);
\Illuminate\Support\Facades\Route::get('/import/products',[ \App\Controller\ImportController::class, 'importProduct']);
