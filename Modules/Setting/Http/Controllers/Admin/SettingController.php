<?php

namespace Modules\Setting\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Setting\Repositories\SettingRepository;
use function compact;
use function dd;
use function public_path;
use function redirect;
use function strtolower;
use function ucfirst;
use function view;

class SettingController extends Controller
{

    private $repoSetting;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->repoSetting = $settingRepository;

    }

    public function index()
    {
        $settings = $this->repoSetting->all();
        return view('setting::admin.index', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $arrData = $request->all();

        $validator = Validator::make($request->all(), [
            'setting_logo_path' => 'image|mimes:png'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        if ($request->hasFile('setting_logo_path')) {
            $logo = $request->file('setting_logo_path');
            $name = "logo" . '.' . $logo->getClientOriginalExtension(); //get the  file extention
            $destinationPath = public_path('images');
            $logo->move($destinationPath, $name);
            $arrData['setting_logo_path'] = '/images/' . $name;
        } else {
            $setting = $this->repoSetting->findByAttributes(['key' => 'setting_logo_path']);
            $arrData['setting_logo_path'] = $setting->value;
        }

        $arrData['setting_site_name'] = !$arrData['setting_site_name'] ?: ucwords($arrData['setting_site_name']);
        $arrData['setting_site_name_small'] = !$arrData['setting_site_name_small'] ?: ucfirst(strtolower($arrData['setting_site_name_small']));

        //delete key old
        $this->repoSetting->destroyOldValue();

        unset($arrData['_token']);
        $this->repoSetting->bulkInsert($arrData);

        return redirect()->route('admin.setting.settings.index');
    }



}
