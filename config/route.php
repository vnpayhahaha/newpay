<?php

use Webman\Route;

Route::options('[{path:.+}]', function ($request) {
    return response('', 204);
});
\app\router\AnnotationProvider::start();
