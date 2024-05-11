<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Category;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Product;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;

class SiteController extends Controller
{
    public function index(){
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','/')->first();
        return view($this->activeTemplate . 'home', compact('pageTitle','sections'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $request->session()->regenerateToken();

        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug,$id)
    {
        $policy = Frontend::where('id',$id)->where('data_keys','policy_pages.element')->firstOrFail();
        $pageTitle = $policy->data_values->title;
        return view($this->activeTemplate.'policy',compact('policy','pageTitle'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function allBlog()
    {
        $pageTitle = 'Blog';
        $blogs = Frontend::where('data_keys', 'blog.element')->orderBy('id', 'desc')->paginate(getPaginate(8));
        return view($this->activeTemplate.'blog',compact('pageTitle', 'blogs'));
    }

    public function categoryProduct($id)
    {
        $category = Category::findOrFail($id);
        $pageTitle = 'Product of '.$category->name;
        $products = Product::with('getWishlist')->where('category_id', $category->id)->whereIn('status', [1,2])->orderBy('id', 'desc')->paginate(getPaginate(8));

        $categories = Category::where('status', 1)->inRandomOrder()->limit(8)->get();

        $productMaxPrice = Product::whereIn('status', [1,2])->orderBy('price', 'desc')->first()->price;
        $productMaxPrice = intval($productMaxPrice);
        return view($this->activeTemplate.'products',compact('pageTitle', 'products', 'categories', 'productMaxPrice'));
    }

    public function allProduct()
    {
        $pageTitle = 'Browse Auctions';
        $products = Product::with('getWishlist')->where('status', 1)->orderBy('id', 'desc')->paginate(getPaginate(8));

        $categories = Category::where('status', 1)->inRandomOrder()->limit(8)->get();

        $productMaxPrice = Product::whereIn('status', [1,2])->orderBy('price', 'desc')->first()->price;
        $productMaxPrice = intval($productMaxPrice);

        return view($this->activeTemplate.'products',compact('pageTitle', 'products', 'categories', 'productMaxPrice'));
    }

    public function fetchProductData(Request $request)
    {
        $search = $request->input('search');
        $shortBy = $request->input('shortBy');
        $categories = $request->input('categories', []);
        $min = $request->input('min');
        $max = $request->input('max');

        $query = Product::with(['getWishlist','productImages'])->whereIn('status', [1, 2]);

        if (!empty($categories)) {
            $query->whereIn('category_id', $categories);
        }

        if ($min !== null && $max !== null) {
            $query->whereBetween('price', [$min, $max]);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%");
            });
        }

        if ($shortBy) {
            if ($shortBy === 'name') {
                $products = Product::with(['getWishlist','productImages'])->whereIn('status', [1, 2])->orderBy('title', 'asc')->get();

            } elseif ($shortBy === 'date') {
                $products = Product::with(['getWishlist','productImages'])->whereIn('status', [1, 2])->orderBy('id', 'desc', 'NUMERIC')->get();

            } elseif ($shortBy === 'price') {
                $products = Product::with(['getWishlist','productImages'])->whereIn('status', [1, 2])->orderBy('price', 'asc', 'NUMERIC')->get();

            }
        }else{
            $products = $query->whereHas('category', function ($query) {
                $query->where('status', 1);
            })->get();
        }



        $categories = Category::where('status', 1)->inRandomOrder()->limit(8)->get();
        $productMaxPrice = Product::whereIn('status', [1,2])->orderBy('price', 'desc')->first()->price;
        $productMaxPrice = intval($productMaxPrice);

        $view = View::make($this->activeTemplate .'render_product', compact('products', 'categories', 'productMaxPrice'))->render();

        return response()->json([
            'html' => $view
        ]);

    }

    public function productDetails($slug, $id)
    {
        $product = Product::with(['user', 'bids', 'bids.bidder', 'productImages'])->where('id', $id)->whereIn('status', [1,2])->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(6)->get();
        $pageTitle = $product->title;

        return view($this->activeTemplate.'product_details', compact('pageTitle', 'product', 'relatedProducts'));
    }


    public function blogDetails($slug,$id){
        $blog = Frontend::where('id',$id)->where('data_keys','blog.element')->firstOrFail();
        $newBlogs = Frontend::whereNot('id',$id)->where('data_keys','blog.element')->latest()->limit(4)->get();
        $pageTitle = 'Blog Details';
        return view($this->activeTemplate.'blog_details',compact('blog','pageTitle', 'newBlogs'));
    }

    public function blogSearch(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $blogs = Frontend::where('data_keys', 'blog.element')
                            ->where('data_values->title', 'like', '%' . $searchTerm . '%')
                            ->get();

        $results = [
            'blogs' => $blogs
        ];
        return response()->json($results);
    }


    public function cookieAccept(){
        $general = gs();
        Cookie::queue('gdpr_cookie',$general->site_name , 43200);
        return back();
    }

    public function cookiePolicy(){
        $pageTitle = 'Cookie Policy';
        $cookie = Frontend::where('data_keys','cookie.data')->first();
        return view($this->activeTemplate.'cookie',compact('pageTitle','cookie'));
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 255, 255, 255);
        $bgFill    = imagecolorallocate($image, 28, 35, 47);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }
}
