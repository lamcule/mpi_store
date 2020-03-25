<?php
/**
 * Created by PhpStorm.
 * User: thanh
 * Date: 04/05/2019
 * Time: 14:50
 */

namespace Modules\Setting\Http\Controllers\Api\v1;

use App\Http\Controllers\BaseController;
use Modules\Setting\Repositories\SettingRepository;
use Modules\Setting\Transformers\SiteSettingInfoTransformers;

class SettingController extends BaseController
{
    private $setting;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->setting = $settingRepository;

    }

    public function getSettingInfo()
    {
        $data = new \stdClass();
        $data->logo = $this->setting->getLogo();
        $data->siteName = $this->setting->getSiteName();
        $data->smallSiteName = $this->setting->getSmallSiteName();
        return $this->response->item($data, new SiteSettingInfoTransformers());
    }
}