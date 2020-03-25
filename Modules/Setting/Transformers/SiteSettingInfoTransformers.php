<?php
/**
 * Created by PhpStorm.
 * User: thanh
 * Date: 04/05/2019
 * Time: 15:29
 */
namespace Modules\Setting\Transformers;

use League\Fractal\TransformerAbstract;

class SiteSettingInfoTransformers extends TransformerAbstract
{
    public function transform($data)
    {
        return [
            'logo' => $data->logo?asset($data->logo->value):null,
            'siteName' => $data->siteName->value,
            'smallSiteName' => $data->smallSiteName->value
        ];
    }
}
