<?php
/**
 * Created by PhpStorm.
 * User: thanh
 * Date: 25/04/2019
 * Time: 15:57
 */

namespace Modules\App\Transformers;


use League\Fractal\TransformerAbstract;

class MobileOSDetailTransformers extends TransformerAbstract
{
    public function transform ($data) {
        return [
            'os' => $data->os,
            'version' => $data->version,
            'path' => $data->path ? ($data->os == 'iOS' ? $data->path : asset($data->path)) : null
        ];
    }
}
