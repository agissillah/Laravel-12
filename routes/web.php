<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    if ($request->session()->get('sudah_masuk')) {
        return redirect('/profile');
    }

    return view('login');
});

Route::get('/login', function (Request $request) {
    if ($request->session()->get('sudah_masuk')) {
        return redirect('/profile');
    }

    return view('login');
})->name('login');

Route::post('/masuk', function (Request $request) {
    $request->session()->put('sudah_masuk', true);

    return redirect('/profile');
})->name('masuk');

Route::post('/logout', function (Request $request) {
    $request->session()->forget('sudah_masuk');

    return redirect('/login');
})->name('logout');

Route::get('/profile', function (Request $request) {
    if (! $request->session()->get('sudah_masuk')) {
        return redirect('/login');
    }

    return view('profile', [
        'profile' => [
            'name' => 'Muhammad Aghiitsillah',
            'nickname' => 'Agis',
            'university' => 'Politeknik Elektronika Negeri Surabaya',
            'major' => 'Teknik Informatika',
            'semester' => 'Semester 4',
            'location' => 'Indonesia',
            'bio' => 'Mahasiswa D3 Teknik Informatika, sedang mengikuti program studi di Politeknik Elektronika Negeri Surabaya.',
            'email' => 'magissillah@gmail.com',
            'phone' => '+62 812-1720-4394',
        ],
    ]);
});
