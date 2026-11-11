<?php

namespace App\View\Composers;

use App\Support\DummyMusic;
use Illuminate\View\View;

class AppLayoutComposer
{
    public function compose(View $view): void
    {
        $view->with([
            'currentUser' => auth()->user() ?? DummyMusic::user(),
            'library' => DummyMusic::library(),
            'nowPlaying' => DummyMusic::nowPlaying(),
        ]);
    }
}
