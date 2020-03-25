<?php
/**
 * Created by PhpStorm.
 * User: thanh
 * Date: 25/04/2019
 * Time: 11:05
 */

namespace Modules\App\Transformers;


use League\Fractal\TransformerAbstract;

class ListAppTransformers extends TransformerAbstract
{
    public function transform($data)
    {
        return [
            'id' => $data->id,
            'title' => $data->title,
            'description' => $data->description,
            'avatar' => $data->avatar ? asset($data->avatar) : null,
            'iOS' => $this->getIOSInfo($data->appDetail->all()),
            'android' => $this->getAndroidInfo($data->appDetail->all())
        ];
    }

    private function getIOSInfo($mobile)
    {
        foreach ($mobile as $item) {
            if ($item->os == 'iOS') {
                return (new MobileOSDetailTransformers())->transform($item);
            }
        }
    }

    private function getAndroidInfo($mobile)
    {
        foreach ($mobile as $item) {
            if ($item->os == 'android') {
                return (new MobileOSDetailTransformers())->transform($item);
            }
        }
    }
}
