<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Presenters\TodoPresenter;
use TheHiveTeam\Presentable\HasPresentable;

class Todo extends Model
{
    use HasFactory;


    use HasPresentable;

    protected $presenter = TodoPresenter::class;
    use SoftDeletes;
    protected $casts = [
        'created_at'  => 'date:m-Y-d',
    ];

    protected $dates = ['deleted_at'];
}
