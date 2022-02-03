<?php

namespace App\Models\Presenters;
use carbon\carbon;
use TheHiveTeam\Presentable\Presenter;

class TodoPresenter extends Presenter
{
    public function getDateFormated($date)
    {
        return Carbon::parse($date)->format('F j, Y, g:i A');
    }
}
