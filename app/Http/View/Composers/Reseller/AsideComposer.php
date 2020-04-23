<?php

namespace App\Http\View\Composers\Reseller;

use Illuminate\View\View;

class AsideComposer
{
    /**
     * Aside Tab
     */
    public $asideTab = [
        [
            'title' => 'Account',
            'id' => 'account',
            'view' => 'reseller.aside.account',
        ],
    ];

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('asideTab', $this->asideTab);
    }
}