<?php
/**
 * Created by PhpStorm.
 * User: GEM
 * Date: 4/23/2019
 * Time: 4:28 PM
 */

namespace Modules\Media\Repositories;


use Modules\Media\Entities\Media;
use Prettus\Repository\Eloquent\BaseRepository;

class MediaRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        $media = Media::class;
        return $media;
    }

    public function insertMedia($data)
    {
        return $this->model->insert($data);
    }
}
