<?php

namespace Modules\Media\Entities;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';
    protected $fillable = ['app_id','path','file_name','created_at','updated_at'];
}
