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
            'bio' => 'Mahasiswa yang antusias belajar dan berkembang di bidang teknologi.',
            'email' => 'magissillah@gmail.com',
            'phone' => '+62 812-1720-4394',
        ],
    ]);
});
