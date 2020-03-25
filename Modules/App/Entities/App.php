<?php

namespace Modules\App\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Entities\Media;

class App extends Model
{
    protected $table = 'apps';
    protected $fillable = ['title', 'description', 'avatar', 'user_id', 'status', 'created_at', 'updated_at'];

    public function appDetail()
    {
        return $this->hasMany(AppDetail::class, 'app_id', 'id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'app_id', 'id');
    }
}
