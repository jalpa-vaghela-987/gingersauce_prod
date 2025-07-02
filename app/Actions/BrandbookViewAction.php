<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;
use App\BrandBookCreator\BrandBookHelper;

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
        $bb_version =   $this->data->bb_version;
        if($bb_version == 1){
            return route('brandbook.my').'/view/'.$this->data->id;
        } elseif($bb_version == 2){
            return route('brandbook.my').'/view-new/'.$this->data->id;
        } else {
            return route('brandbook.my').'/view-v3/'.$this->data->id;
        }
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'brandbooks';
    }
}
