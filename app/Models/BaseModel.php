<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const CREATED_AT = "create_time";
    const UPDATED_AT = "update_time";
    protected $dateFormat = "U";
    protected $fillable = ["content"];
    protected $primaryKey = "id";
}
