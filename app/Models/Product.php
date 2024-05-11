<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getWishlist()
    {
        return $this->hasOne(Wishlist::class, 'product_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(
            get:fn () => $this->badgeData(),
        );
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }


    public function badgeData(){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--warning">'.trans('Pending').'</span>';
        }
        elseif($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Active').'</span>';
        }elseif($this->status == 2)
        {
            $html = '<span class="badge badge--danger">'.trans('Expired').'</span>';
        }elseif($this->status == 3)
        {
            $html = '<span class="badge badge--danger">'.trans('Cancel').'</span>';
        }elseif($this->status == 4)
        {
            $html = '<span class="badge badge--success">'.trans('Delivered').'</span>';
        }

        return $html;
    }


}
