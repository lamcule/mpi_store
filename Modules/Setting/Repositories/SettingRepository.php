<?php
/**
 * Created by PhpStorm.
 * User: VPA
 * Date: 5/2/2019
 * Time: 11:00 AM
 */

namespace Modules\Setting\Repositories;


use App\Repositories\BaseRepository;

interface SettingRepository extends BaseRepository
{
    public function bulkInsert($arrData);

    public function destroyOldValue();

    public function getLogo ();

    public function getSiteName ();

    public function getSmallSiteName ();
}