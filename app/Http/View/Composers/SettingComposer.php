<?php

namespace App\Http\View\Composers;

use App\Repository\SettingsRepository;
use App\Setting;
use Illuminate\View\View;

class SettingComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $settings = Setting::all()->groupBy('name')->map(function ($item) {
            return $item->last()->value;
        })->toArray();
        foreach($settings as $key => $val) {
            $view->with($key, $val);
        }
    }
}
