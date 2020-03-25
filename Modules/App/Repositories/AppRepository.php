<?php
/**
 * Created by PhpStorm.
 * User: GEM
 * Date: 4/23/2019
 * Time: 4:26 PM
 */

namespace Modules\App\Repositories;

use Modules\App\Entities\App;
use Prettus\Repository\Eloquent\BaseRepository;

class AppRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        $app = App::class;
        return $app;
    }

    public function searchApp($title)
    {
        return $this->model->query()
            ->where('title', 'like', "%$title%")
            ->orderBy('title', 'desc')
            ->get();
    }
}
