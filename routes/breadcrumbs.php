<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('program', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
    $trail->push('Program', route('home.program'));
});

Breadcrumbs::for('program-detail', function (BreadcrumbTrail $trail, $program) {
    $trail->push('Home', route('home'));
    $trail->push('Program', route('home.program'));
    $trail->push($program->name, route('home.program', $program->slug));
});
