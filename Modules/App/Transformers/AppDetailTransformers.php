<?php
/**
 * Created by PhpStorm.
 * User: thanh
 * Date: 25/04/2019
 * Time: 13:40
 */

namespace Modules\App\Transformers;


use League\Fractal\TransformerAbstract;

class AppDetailTransformers extends TransformerAbstract
{
    public function transform($data)
    {
        return [
            'id' => $data->id,
            'title' => $data->title,
            'description' => $data->description,
            'avatar' => $data->avatar ? asset($data->avatar) : null,
            'listImage' => $this->getMediaImage($data->media->all()),
            'iOS' => $this->getIOSInfo($data->appDetail->all()),
            'android' => $this->getAndroidInfo($data->appDetail->all())
        ];
    }

    private function getMediaImage($media)
    {
        $media_arr = [];
        foreach ($media as $value) {
            $media_arr[] = (new MediaImageTransformers())->transform($value);
        }
        return $media_arr;
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
