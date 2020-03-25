<?php
/**
 * Created by PhpStorm.
 * User: thanh
 * Date: 25/04/2019
 * Time: 14:11
 */

namespace Modules\App\Transformers;


use League\Fractal\TransformerAbstract;

class MediaImageTransformers extends TransformerAbstract
{
    public function transform($data)
    {
        return [
            'image' => $data->path ? asset($data->path) : null
        ];
    }
}
