<?php

namespace Modules\App\Entities;

use Illuminate\Database\Eloquent\Model;

class AppDetail extends Model
{
    protected $table = 'app_detail';
    protected $fillable = ['app_id', 'os', 'version', 'path', 'file_name', 'created_at', 'updated_at'];

    public function app()
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }
}
