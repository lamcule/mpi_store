<?php
/**
 * Created by PhpStorm.
 * User: GEM
 * Date: 4/23/2019
 * Time: 4:27 PM
 */

namespace Modules\App\Repositories;


use Modules\App\Entities\AppDetail;
use Prettus\Repository\Eloquent\BaseRepository;

class AppDetailRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        $appDetail = AppDetail::class;
        return $appDetail;
    }

    public function getAppDetail($app_id, $os)
    {
        return $this->model->query()
            ->where('app_id', $app_id)
            ->where('os', $os)
            ->get();
    }
}
