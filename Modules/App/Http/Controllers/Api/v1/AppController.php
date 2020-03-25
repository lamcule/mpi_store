<?php
/**
 * Created by PhpStorm.
 * User: thanh
 * Date: 25/04/2019
 * Time: 10:48
 */

namespace Modules\App\Http\Controllers\Api\v1;


use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Modules\App\Repositories\AppDetailRepository;
use Modules\App\Repositories\AppRepository;
use Modules\App\Transformers\AppDetailTransformers;
use Modules\App\Transformers\ListAppTransformers;

class AppController extends BaseController
{
    private $app;
    private $appDetail;

    public function __construct(AppRepository $app, AppDetailRepository $appDetail)
    {
        $this->app = $app;
        $this->appDetail = $appDetail;
    }

    public function listApp() {

        $data = $this->app->all();

        return $this->response->collection($data, new ListAppTransformers);
    }

    public function appDetail (Request $request) {
        $data = $this->app->find($request->id);
//        dd($data);
        return $this->response->item($data, new AppDetailTransformers);
    }
}
