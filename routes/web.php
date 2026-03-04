<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
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
