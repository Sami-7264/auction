<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }


    public function badgeData(){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--danger">'.trans('Inactive').'</span>';
        }
        elseif($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Active').'</span>';
        }

        return $html;
    }
}
