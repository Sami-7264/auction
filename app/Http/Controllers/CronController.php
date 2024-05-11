<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Product;
use App\Models\User;
use App\Models\Winner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function winners()
    {
        $products = Product::where('status', 1)->where('expired_at', '<', now())->take(20)->get();

        foreach($products as $product)
        {
            $heightBid = Bid::where('product_id', $product->id)->orderBy('price', 'desc')->first();
            $winner = User::findOrFail($heightBid->bidder_id);
            $bids = Bid::whereNot('id', $heightBid->id)->where('product_id', $product->id)->where('product_creator_id', $product->user_id)->get();

            if($product->user_id != 0)
            {
                $owner = User::findOrFail($product->user_id);
                $owner->balance += $heightBid->price;
                $owner->save();


                notify($owner, 'AUCTION_ENDED_OWNER_NOTIFICATION', [
                    'auction_owner' => $owner->fullname,
                    'auction_product_name' => $product->title,
                    'winner_bid_price' => showAmount($heightBid->price, 2),
                    'winner_name' => $winner->fullname,
                    'auction_concluded_date' => now(),
                    'total_bids' => ($bids->count() + 1),
                    'link' => route('product.details', ['slug' => Str::slug($product->title), 'id' => $product->id])
                ]);

            }

            if($winner)
            {
                notify($winner, 'AUCTION_WINNER_NOTIFICATION', [
                    'auction_product_name' => $product->title,
                    'winner_bid_price' => showAmount($heightBid->price, 2),
                    'winner_name' => $winner->fullname,
                    'auction_concluded_date' => now(),
                    'total_bids' => ($bids->count() + 1),
                    'link' => route('product.details', ['slug' => Str::slug($product->title), 'id' => $product->id])
                ]);
            }

            foreach($bids as $bidder)
            {
                $participant = User::findOrFail($bidder->bidder_id);

                $participant->balance += $bidder->price;
                $participant->save();


                notify($participant, 'NON_WINNER_AUCTION_NOTIFICATION', [
                    'participant_name' => $participant->fullname,
                    'auction_product_name' => $product->title,
                    'winner_bid_price' => showAmount($heightBid->price, 2),
                    'winner_name' => $winner->fullname,
                    'auction_concluded_date' => now(),
                    'total_bids' => ($bids->count() + 1),
                    'link' => route('product.details', ['slug' => Str::slug($product->title), 'id' => $product->id])
                ]);
            }

            $winnerData = new Winner();
            $winnerData->user_id = $winner->id;
            $winnerData->product_id = $product->id;
            $winnerData->product_owner_id = $product->user_id;
            $winnerData->bid_id = $heightBid->id;
            $winnerData->status = 0;
            $winnerData->save();


            $product->status = 2;
            $product->save();


        }


    }


}
