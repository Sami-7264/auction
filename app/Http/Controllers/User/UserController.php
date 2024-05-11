<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\AdminNotification;
use App\Models\Bid;
use App\Models\Deposit;
use App\Models\Form;
use App\Models\Product;
use App\Models\Review;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Winner;
use App\Models\Wishlist;
use App\Models\Withdrawal;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function home()
    {
        $pageTitle = 'Dashboard';
        $user = auth()->user();
        $totalDeposit = Deposit::where('user_id', $user->id)->where('status',1)->sum('amount');
        $totalTransaction = Transaction::where('user_id', $user->id)->sum('amount');
        $supportTicketCount = SupportTicket::where('user_id', $user->id)->count();
        $bid['total_bid'] = Bid::where('bidder_id', $user->id)->count();
        $bid['total_bid_pirce'] = Bid::where('bidder_id', $user->id)->sum('price');
        $winProduct = Winner::where('user_id', $user->id)->count();

        $product['pending'] = Product::where('user_id', $user->id)->where('status', 0)->count();
        $product['live'] = Product::where('user_id', $user->id)->where('status', 1)->where('started_at', '<', now())->where('expired_at', '>', now())->count();
        $product['cancel'] = Product::where('user_id', $user->id)->where('status', 3)->count();
        $product['total'] = Product::where('user_id', $user->id)->count();

        $product['auction_complete'] = Winner::where('product_owner_id', $user->id)->count();

        $withdraw['total'] = Withdrawal::where('user_id', $user->id)->where('status', 1)->sum('amount');
        $withdraw['pending'] = Withdrawal::where('user_id', $user->id)->where('status', 2)->sum('amount');
        $withdraw['cancel'] = Withdrawal::where('user_id', $user->id)->where('status', 3)->sum('amount');

        $deposits = Deposit::selectRaw("SUM(amount) as amount, MONTHNAME(created_at) as month_name, MONTH(created_at) as month_num")
            ->whereYear('created_at', date('Y'))
            ->whereStatus(1)
            ->where('user_id', $user->id)
            ->groupBy('month_name', 'month_num')
            ->orderBy('month_num')
            ->get();
        $depositsChart['labels'] = $deposits->pluck('month_name');
        $depositsChart['values'] = $deposits->pluck('amount');


        $bidsReport = Bid::selectRaw("SUM(price) as amount, MONTHNAME(created_at) as month_name, MONTH(created_at) as month_num")
            ->whereYear('created_at', date('Y'))
            ->where('bidder_id', $user->id)
            ->groupBy('month_name', 'month_num')
            ->orderBy('month_num')
            ->get();
        $bidChart['labels'] = $bidsReport->pluck('month_name');
        $bidChart['values'] = $bidsReport->pluck('amount');

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'depositsChart', 'bidChart', 'user', 'totalDeposit', 'totalTransaction', 'supportTicketCount', 'bid', 'winProduct', 'product', 'withdraw'));
    }

    public function depositHistory(Request $request)
    {
        $pageTitle = 'Deposit History';
        $deposits = auth()->user()->deposits();
        if ($request->search) {
            $deposits = $deposits->where('trx',$request->search);
        }
        $deposits = $deposits->with(['gateway'])->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm()
    {
        $general = gs();
        $ga = new GoogleAuthenticator();
        $user = auth()->user();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate.'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user,$request->code,$request->key);
        if ($response) {
            $user->tsc = $request->key;
            $user->ts = 1;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user = auth()->user();
        $response = verifyG2fa($user,$request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts = 0;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator deactivated successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request)
    {
        $pageTitle = 'Transactions';
        $remarks = Transaction::distinct('remark')->orderBy('remark')->get('remark');
        $transactions = Transaction::where('user_id',auth()->id());

        if ($request->search) {
            $transactions = $transactions->where('trx',$request->search);
        }

        if ($request->type) {
            $transactions = $transactions->where('trx_type',$request->type);
        }

        if ($request->remark) {
            $transactions = $transactions->where('remark',$request->remark);
        }

        $transactions = $transactions->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.transactions', compact('pageTitle','transactions','remarks'));
    }

    public function kycForm()
    {
        if (auth()->user()->kv == 2) {
            $notify[] = ['error','Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == 1) {
            $notify[] = ['error','You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form = Form::where('act','kyc')->first();
        return view($this->activeTemplate.'user.kyc.form', compact('pageTitle','form'));
    }

    public function kycData()
    {
        $user = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate.'user.kyc.info', compact('pageTitle','user'));
    }

    public function kycSubmit(Request $request)
    {
        $form = Form::where('act','kyc')->first();
        $formData = $form->form_data;
        $formProcessor = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);
        $user = auth()->user();
        $user->kyc_data = $userData;
        $user->kv = 2;
        $user->save();

        $notify[] = ['success','KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);

    }


    public function attachmentDownload($fileHash)
    {
        $filePath = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general = gs();
        $title = slug($general->site_name).'- attachments.'.$extension;
        $mimetype = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData()
    {
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries = json_decode(file_get_contents(resource_path('views/includes/country.json')));
        $user = auth()->user();
        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate.'user.user_data', compact('pageTitle','user','mobileCode','countries'));
    }

    public function userDataSubmit(Request $request)
    {

        $user = auth()->user();

        $countryData = (array)json_decode(file_get_contents(resource_path('views/includes/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes = implode(',',array_column($countryData, 'dial_code'));
        $countries = implode(',',array_column($countryData, 'country'));


        if ($user->reg_step == 1) {
            return to_route('user.home');
        }
        $request->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'mobile' => 'required|regex:/^([0-9]*)$/',
            'mobile_code' => 'required|in:'.$mobileCodes,
            'country_code' => 'required|in:'.$countryCodes,
            'country' => 'required|in:'.$countries,
        ]);



        $exist = User::whereNot('id', $user->id)->where('mobile',$request->mobile_code.$request->mobile)->first();
        if ($exist) {
            $notify[] = ['error', 'The mobile number already exists'];
            return back()->withNotify($notify)->withInput();
        }

        $user->country_code = $user->country_code == null ? $request->country_code : $user->country_code;
        $user->mobile = $user->mobile == null ? $request->mobile_code.$request->mobile : $user->mobile;

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->address = [
            'country'=>$request->country,
            'address'=>$request->address,
            'state'=>$request->state,
            'zip'=>$request->zip,
            'city'=>$request->city
        ];
        $user->reg_step = 1;
        $user->save();

        $notify[] = ['success','Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);

    }

    public function bid(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $user = auth()->user();



        if($user->balance  < $request->price)
        {
            $notify[] = ['error', 'You do not have sufficient balance'];
            return redirect()->back()->withNotify($notify);
        }

        if($product->price  > $request->price)
        {
            $notify[] = ['error', 'Your bidding price is lower then product price.'];
            return redirect()->back()->withNotify($notify);
        }

        if($product->status == 0 || $product->status == 2 || $product->status == 3){
            $notify[] = ['error', 'Bidding not possible now'];
            return redirect()->back()->withNotify($notify);
        }

        if($product->user_id == $user->id)
        {
            $notify[] = ['error', 'You can not bid your auction'];
            return redirect()->back()->withNotify($notify);
        }

        $check = Bid::where('bidder_id', $user->id)->where('product_id', $product->id)->first();

        if($check)
        {
            if(intval($check->price) >= intval($request->price))
            {
                $notify[] = ['error', 'Update your bid price to a higher amount to participate again.'];
                return redirect()->back()->withNotify($notify);
            }

            $updateAmount = (intval($request->price) - intval($check->price));
            $user->balance -= $updateAmount;
            $user->save();

            $check->price = $request->price;
            $check->save();

            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->amount = $updateAmount;
            $transaction->post_balance = $user->balance;
            $transaction->charge = 0;
            $transaction->trx_type = '-';
            $transaction->details = 'Subtracted for updating the previous bid';
            $transaction->trx = getTrx();
            $transaction->remark = 'bid';
            $transaction->save();


            $notify[] = ['success', 'Your bid price has been successfully updated.'];
            return redirect()->back()->withNotify($notify);
        }




        $bid = new Bid();
        $bid->product_id = $request->product_id;
        $bid->bidder_id = $user->id;
        $bid->product_creator_id = $product->user_id != 0 ? $product->user_id : 0;
        $bid->price = $request->price;
        $bid->save();

        $user->balance -= $request->price;
        $user->save();

        $product->bid_count += 1;
        $product->save();

        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $request->price;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type = '-';
        $transaction->details = 'Subtracted for a new bid';
        $transaction->trx = getTrx();
        $transaction->remark = 'bid';
        $transaction->save();

        if($product->user_id == 0){
            $adminNotification = new AdminNotification();
            $adminNotification->user_id = $user->id;
            $adminNotification->title = 'A user has placed a bid on your product.';
            $adminNotification->click_url = urlPath('admin.product.bidder.list',$product->id);
            $adminNotification->save();
        }



        $notify[] = ['success', 'Bid successfully done'];
        return redirect()->back()->withNotify($notify);
    }

    public function biddingHistory()
    {
        $user = auth()->user();
        $pageTitle = 'Bidding History';
        $bids = Bid::with(['product', 'product.user'])->where('bidder_id', $user->id)->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.bidding_history', compact('pageTitle','bids'));
    }
    public function winningHistory()
    {
        $user = auth()->user();
        $pageTitle = 'Winning History';
        $winners = Winner::with(['getProduct', 'getProduct.user', 'getBid'])->where('user_id', $user->id)->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.winning_history', compact('pageTitle','winners'));
    }

    public function auctionWishlist()
    {
        $user = auth()->user();
        $pageTitle = 'Wishlist';
        $wishlists = Wishlist::with('getProduct')->where('user_id', $user->id)->orderBy('id','desc')->paginate(getPaginate());
        return view($this->activeTemplate.'user.wishlist', compact('pageTitle','wishlists'));
    }

    public function wishlist(Request $request)
    {
        $user = auth()->user();

        if($user)
        {
            $check = Wishlist::where('product_id', $request->product_id)->first();

            if($check)
            {
                $check->delete();
                $wishlistCount = Wishlist::where('user_id', $user->id)->count();
                return response()->json(['status' => 'Successfully removed', 'statusCode' => 1, 'wishlistCount' => $wishlistCount]);
            }else{
                $wishlist = new Wishlist();
                $wishlist->user_id = $user->id;
                $wishlist->product_id = $request->product_id;
                $wishlist->save();
                $wishlistCount = Wishlist::where('user_id', $user->id)->count();
                return response()->json(['status' => 'Successfully added to wishlist', 'statusCode' => 2, 'wishlistCount' => $wishlistCount]);
            }
        }else{
            return response()->json(['status' => 'Something wrong', 'statusCode' => 3]);
        }


    }

    public function deleteWishList($id)
    {
        $user = auth()->user();
        $wishList = Wishlist::where('user_id', $user->id)->where('id', $id)->first();
        $wishList->delete();
        $notify[] = ['success', 'Your wishlist successfully deleted.'];
        return redirect()->back()->withNotify($notify);
    }

    public function review(Request $request)
    {
        $request->validate([
            'rating'            => 'required|integer|min:1|max:5',
            'message'           => 'required'
        ]);

        $user = auth()->user();

        $product = Product::findOrFail($request->product_id);

        if($product->user_id != 0)
        {
            if($user->id == $product->user_id){
                $notify[] = ['error','You can\'t review your own profile'];
                return redirect()->back()->withNotify($notify);
            }

            $result = Winner::where('user_id', $user->id)
                ->where('product_owner_id', $product->user_id)
                ->get()->count();

            if($result ==  0)
            {
                $notify[] = ['error','You are not allow to review'];
                return redirect()->back()->withNotify($notify);
            }

            $check = Review::where('user_id', $user->id)->where('merchant_id', $product->user_id)->count();
            if($check > 0)
            {
                $notify[] = ['error','You have already given a review'];
                return redirect()->back()->withNotify($notify);
            }

            $review = new Review();
            $review->user_id = $user->id;
            $review->merchant_id = $product->user_id;
            $review->rating = $request->rating;
            $review->message = $request->message;
            $review->save();

            $productOwner = User::findOrFail($request->buyer_id);

            if($productOwner->review_count == 0)
            {
                $productOwner->avg_review = $request->rating;
                $productOwner->review_count += 1;
                $productOwner->save();
            }else{
                $total_star = $productOwner->avg_review * $productOwner->review_count;
                $avg_star = ($total_star + $request->rating) / ($productOwner->review_count + 1);
                $productOwner->avg_review = $avg_star;
                $productOwner->review_count += 1;
                $productOwner->save();
            }

            $notify[] = ['success','Review successfully done'];
            return redirect()->back()->withNotify($notify);

        }
        else
        {

            $result = Winner::where('user_id', $user->id)
                            ->where('product_owner_id', 0)
                            ->get()->count();

            if($result ==  0)
            {
                $notify[] = ['error','You are not allow to review'];
                return redirect()->back()->withNotify($notify);
            }

            $check = Review::where('user_id', $user->id)->where('merchant_id', 0)->count();

            if($check > 0)
            {
                $notify[] = ['error','You have already given a review'];
                return redirect()->back()->withNotify($notify);
            }

            $review = new Review();
            $review->user_id = $user->id;
            $review->merchant_id = $product->user_id;
            $review->rating = $request->rating;
            $review->message = $request->message;
            $review->save();

            $notify[] = ['success','Review successfully done'];
            return redirect()->back()->withNotify($notify);
        }

    }

}
