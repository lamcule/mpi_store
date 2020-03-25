<?php
/**
 * Created by PhpStorm.
 * User: VPA
 * Date: 5/2/2019
 * Time: 10:56 AM
 */

namespace Modules\Setting\Composers;


use Illuminate\View\View;
use Modules\Setting\Repositories\SettingRepository;

class SettingComposer
{
    protected $setting;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->setting = $settingRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('settings', $this->setting->all());
    }

}
