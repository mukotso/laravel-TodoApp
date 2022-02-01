<?php

namespace App\Models\Presenters;
use carbon\carbon;
use TheHiveTeam\Presentable\Presenter;

class TodoPresenter extends Presenter
{
    public function getCreatedAtAttribute($date)
    {
        return $this->getDateFormated($date);
    }

    public function getUpdatedAtAttribute($date)
    {
        return $this->getDateFormated($date);
    }

    private function getDateFormated($date)
    {
        return Carbon::parse($date)->format(config('app.locale') == 'fr' ? 'F j, Y, g:i a' : 'm/d/Y');
    }
}
