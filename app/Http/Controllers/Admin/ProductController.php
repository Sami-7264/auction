<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Winner;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Carbon\Carbon;



class ProductController extends Controller
{
    public function all(){
        $pageTitle = 'All Auctions';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::with('user')->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }

    public function pending()
    {
        $pageTitle = 'Pending Auctions';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 0)->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::with('user')->where('status', 0)->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }
    public function live()
    {
        $pageTitle = 'Live Auctions';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 1)->where('started_at', '<', now())->where('expired_at', '>', now())->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::with('user')->where('status', 1)->where('started_at', '<', now())->where('expired_at', '>', now())->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }
    public function upcomming()
    {
        $pageTitle = 'Upcomming Auctions';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 1)->where('started_at', '>', now())->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::with('user')->where('status', 1)->where('started_at', '>', now())->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }
    public function expired()
    {
        $pageTitle = 'Expired Auctions';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 2)->where('expired_at', '<', now())->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::with('user')->where('status', 2)->where('expired_at', '<', now())->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }

    public function cancel()
    {
        $pageTitle = 'Cancelled Auctions';

        if (request()->search) {
            $search = request()->search;
            if ($search) {
                $products = Product::with('user')->where('status', 3)->where('title', 'like', "%$search%")->latest()->paginate(getPaginate(10));
                return view('admin.product.index',compact('pageTitle', 'products'));
            }

        }

        $products = Product::with('user')->where('status', 3)->latest()->paginate(getPaginate(10));
        return view('admin.product.index',compact('pageTitle', 'products'));
    }


    public function approve(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->status = 1;
        $product->save();

        $notify[] = ['success', 'Product Approved Successfully'];
        return back()->withNotify($notify);
    }
    public function reject(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'message' => 'required'
        ]);
        $product = Product::findOrFail($request->id);
        $product->status = 3;
        $product->reason = $request->message;
        $product->save();

        $notify[] = ['success', 'Product Cancelled Successfully'];
        return back()->withNotify($notify);
    }

    public function create()
    {
        $pageTitle = 'Create Auctions';
        $categories = Category::where('status', 1)->get();

        return view('admin.product.create', compact('pageTitle', 'categories'));
    }

    public function edit($id)
    {
        $categories = Category::where('status', 1)->get();
        $product = Product::findOrFail($id);
        $pageTitle = 'Edit Auctions ' .'"'. $product->title . '"';
        return view('admin.product.edit', compact('pageTitle', 'categories', 'product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'category'          => 'required|exists:categories,id',
            'price'             => 'required|numeric|gt:0',
            'market_price'             => 'required|numeric|gt:0',
            'started_at'        => ['required_if:schedule,1','date','after:yesterday','before:expired_at'],
            'expired_at'        => ['required'],
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'specification'       => 'required|array|min:1',
            'specification.*'       => 'required',
            'images.*'          => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);


        $product            = new Product();
        $product->title  = $request->title;
        $product->category_id  = $request->category;
        $product->price = $request->price;
        $product->market_price = $request->market_price;
        $product->bid_complete = 0;
        if ($request->has('started_at')) {
            $startedAt = \Carbon\Carbon::parse($request->started_at)->format('Y-m-d H:i:s');
        } else {
            $startedAt = now()->format('Y-m-d H:i:s');
        }

        if ($request->has('expired_at')) {
            $expiredAt = \Carbon\Carbon::parse($request->expired_at)->format('Y-m-d H:i:s');
        }

        $product->started_at = $startedAt;
        $product->expired_at = $expiredAt;


        $product->short_description = $request->short_description;
        $product->description = $request->description;

        $specificationData = $request->input('specification');

        if (!empty($specificationData)) {
            foreach ($specificationData as $data) {
                if ($data['name'] == null &&  $data['value'] == null) {
                    $notify[] = ['error', 'Specification are empty'];
                    return redirect()->back()->withNotify($notify);
                }

            }
        }

        $product->specification = json_encode($specificationData);

        $product->status    = 1;
        $product->save();

        if($request->images){
            foreach($request->images as $image)
            {
                $newImage           = new Image();
                $newImage->product_id = $product->id;
                try {
                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('product').'/'.$directory;
                    $image = fileUploader($image, $path,getFileSize('product'));
                    $newImage->image = $image;
                    $newImage->path = $directory;
                } catch (\Exception $exp) {

                    $notify[]       = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
                $newImage->save();
            }
        }



        $notify[] = ['success', 'Auctions created successfully'];
        return redirect()->back()->withNotify($notify);
    }

    public function delete(Request $request)
    {
        $image = Image::find($request->id);

        $check = Image::where('product_id', $image->product_id)->count();
        if($check <= 1)
        {
            $notify[] = ['error', 'You can\'t delete all image'];
            return redirect()->back()->withNotify($notify);
        }

        $path                   = getFilePath('product');
        fileManager()->removeFile($path . '/' . $image->path . '/' . $image->image);
        $image->delete();

        $notify[] = ['success', 'Image deleted successfully'];
        return redirect()->back()->withNotify($notify);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'category'          => 'required|exists:categories,id',
            'price'             => 'required|numeric|gt:0',
            'started_at'        => ['required_if:schedule,1','date','after:yesterday','before:expired_at'],
            'expired_at'        => ['required'],
            'short_description' => 'required|string',
            'description'       => 'required|string',
            'specification'       => 'required|array|min:1',
            'specification.*'       => 'required',
            'images.*'          => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        $product                = Product::findOrFail($id);
        $product->title         = $request->title;
        $product->category_id   = $request->category;
        $product->price         = $request->price;
        $product->bid_complete  = 0;
        if ($request->has('started_at')) {
            $startedAt = \Carbon\Carbon::parse($request->started_at)->format('Y-m-d H:i:s');
            $product->started_at = $startedAt;
        } else {
            $startedAt = now()->format('Y-m-d H:i:s');
            $product->started_at = $startedAt;
        }

        if ($request->has('expired_at')) {
            $expiredAt = \Carbon\Carbon::parse($request->expired_at)->format('Y-m-d H:i:s');
            $product->expired_at = $expiredAt;
        }


        $product->short_description = $request->short_description;
        $product->description = $request->description;

        $specificationData = $request->input('specification');

        if (!empty($specificationData)) {
            foreach ($specificationData as $data) {
                if ($data['name'] == null &&  $data['value'] == null) {
                    $notify[] = ['error', 'Specification are empty'];
                    return redirect()->back()->withNotify($notify);
                }

            }
        }

        $product->specification = json_encode($specificationData);


        $product->status    = 1;
        $product->save();


        if($request->images){
            foreach($request->images as $image)
            {
                $newImage           = new Image();
                $newImage->product_id = $product->id;
                try {
                    $directory = date("Y")."/".date("m");
                    $path       = getFilePath('product').'/'.$directory;
                    $image = fileUploader($image, $path,getFileSize('product'));

                    $newImage->image = $image;
                    $newImage->path = $directory;
                } catch (\Exception $exp) {

                    $notify[]       = ['error', 'Couldn\'t upload your image'];
                    return back()->withNotify($notify);
                }
                $newImage->save();
            }
        }


        $notify[] = ['success', 'Auctions updated successfully'];
        return redirect()->back()->withNotify($notify);
    }


    public function productBids($id)
    {
        $product = Product::findOrFail($id);
        $pageTitle = $product->name.' Bids';
        $bids = Bid::where('product_id', $id)->with(['bidder','product.user', 'product'])->latest()->paginate(getPaginate());
        return view('admin.product.bidder_list', compact('pageTitle', 'bids', 'product'));
    }

    public function bidWinner(Request $request)
    {
        $request->validate([
            'bid_id' => 'required'
        ]);

        $bid = Bid::with('user', 'product')->findOrFail($request->bid_id);
        $product = $bid->product;
        $winner = Winner::where('product_id', $product->id)->exists();

        if($winner){
            $notify[] = ['error', 'Winner for this product is already selected'];
            return back()->withNotify($notify);
        }

        if($product->expired_at > now()){
            $notify[] = ['error', 'This product is not expired till now'];
            return back()->withNotify($notify);
        }

        $user = $bid->user;
        $general = gs();

        $winner = new Winner();
        $winner->user_id = $user->id;
        $winner->product_id = $product->id;
        $winner->bid_id = $bid->id;
        $winner->save();

        notify($user, 'BID_WINNER', [
            'product' => $product->name,
            'product_price' => showAmount($product->price),
            'currency' => $general->cur_text,
            'amount' => showAmount($bid->amount),
        ]);

        $notify[] = ['success', 'Winner selected successfully'];
        return back()->withNotify($notify);
    }

    public function winners(){
        $pageTitle = 'All Winners';
        $winners = Winner::with('getProduct', 'getUser', 'getBid')->latest()->paginate(getPaginate());
        return view('admin.product.winners', compact('pageTitle', 'winners'));
    }

    public function deliveredProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);


        $winner = Winner::findOrFail($request->id);
        if($winner->status == 1)
        {
            $notify[] = ['error', 'Product already delivered'];
            return back()->withNotify($notify);
        }
        $winner->status = 1;

        $winner->save();

        $notify[] = ['success', 'Product mark as delivered'];
        return back()->withNotify($notify);

    }
}
