<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index(): string
    {
        return view('sub/contact');
    }

    public function legacy(string $slug): string
    {
        $slug = basename($slug);

        if ($slug === 'contact' || $slug === 'contact_2018_05_02') {
            return $this->index();
        }

        return view('sub/coming_soon', [
            'legacyPath' => 'contact/' . $slug,
        ]);
    }
}
