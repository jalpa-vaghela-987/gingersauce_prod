<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class BrandbookViewAction extends AbstractAction
{
    public function getTitle()
    {
        return 'View';
    }

    public function getIcon()
    {
        return 'voyager-eye';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-warning pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('brandbook.my').'/view/'.$this->data->id;
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'brandbooks';
    }
}
