<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelModel extends Model
{
    use SoftDeletes;
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';

    protected $fillable = [
        'level_kode',
        'level_nama',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}
