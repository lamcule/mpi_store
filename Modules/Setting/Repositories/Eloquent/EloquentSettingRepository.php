<?php
/**
 * Created by PhpStorm.
 * User: VPA
 * Date: 5/2/2019
 * Time: 10:59 AM
 */

namespace Modules\Setting\Repositories\Eloquent;


use App\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Setting\Repositories\SettingRepository;

class EloquentSettingRepository extends EloquentBaseRepository implements SettingRepository
{
    public function all()
    {
        return $this->model->query()->pluck('value', 'key');
    }


    /**
     * func inser
     *
     * @param $arrData
     * @return mixed
     */
    public function bulkInsert($arrData)
    {
        $dataInsert = array();
        foreach ($arrData as $key => $value) {
            array_push($dataInsert, ['key' => $key, 'value' => $value]);
        }

        return $this->model->insert($dataInsert);
    }

    public function destroyOldValue()
    {
        return $this->model->query()->where('key', 'like', 'setting_%')->delete();
    }

    public function getLogo ()
    {
        return $this->model->where('key','setting_logo_path')->get()->first();
    }

    public function getSiteName ()
    {
        return $this->model->where('key', 'setting_site_name')->get()->first();
    }

    public function getSmallSiteName ()
    {
        return $this->model->where('key', 'setting_site_name_small')->get()->first();
    }
}