<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index() {
        $product = Products::all();
        return response()->json(['data'=> $product], 200);
    }
    public function productsById($id)
    {
        $products = Products::find($id)->get(['title', 'cod'])[0];
        return $products;
    }
    public function usersById($id)
    {
        $users = User::find($id)->get(['name', 'email'])[0];
        return $users;
    }

    public function orders() {

        $order_array = [];

        $orders = Orders::get(['user_id', 'products_id', 'id', 'total_price'])->toArray();

        foreach ($orders as $key => $val) {

            $users = User::find($val['user_id'])->get(['name', 'email'])[0]->toArray();
            $result = array_merge($val,$users);
            array_push($order_array, $result);

        }
        return $order_array;

        return response()->json(['data'=> $order_array], 200);
    }
    public function find($id) {

        $pieces = explode(",", $id);

        $product = Products::find($pieces);

        if (count($product) >= 2) {
            return response()->json($product, 200);
        }


        return response()->json($product[0], 200);
    }
    public function create(Request $request) {
        function utf8ize( $mixed ) {
            if (is_array($mixed)) {
                foreach ($mixed as $key => $value) {
                    $mixed[$key] = utf8ize($value);
                }
            } elseif (is_string($mixed)) {
                return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
            }
            return $mixed;
        }
        if($image = $request->file('image')) {
            $image_path = $image->getPathname();

            $filename = time().'_'.preg_replace('/\s+/', '_', strtolower($this->translit($image->getClientOriginalName())));

            $tmp = $image->storeAs('app/public/uploads', $filename, 'tmp');
        }

        $products = Products::create([
            'image'  => $request->image,
            'title' => $request->title,
            'desc' => $request->desc,
            'price' => $request->price,
            'cod' => $request->cod,
            'manufacturer' => $request->manufacturer,
            'country' => $request->country,
            'view' => $request->view,
            'substance' => $request->substance,
            'recipe' => $request->recipe,
            'exception' => $request->exception,
            'slug' => Str::slug($request->title),
        ]);
        return response()->json($products, 200);
    }
    public function createOrder(Request $request) {

        $order = Orders::create([
            'user_id'  => $request->user_id,
            'products_id' => $request->products_id,
            'total_price' => $request->total_price,
        ]);
        return response()->json($order, 200);
    }
    public function update(Request $request, $id) {

        $products = Products::find($id);

        $products->update([
            'image' => $request->image == $products->image ? $products->image : $request->image,
            'title' => $request->title,
            'desc' => $request->desc,
            'price' => $request->price,
            'cod' => $request->cod,
            'manufacturer' => $request->manufacturer,
            'country' => $request->country,
            'view' => $request->view,
            'substance' => $request->substance,
            'recipe' => $request->recipe,
            'exception' => $request->exception,
            'slug' => Str::slug($request->title),
        ]);

        return response()->json($products, 200);
    }

    public function destroy($id) {
        $products = Products::find($id);

        Storage::disk(config('site.upload_disk'))->delete("uploads/".$products->image);
        $products->delete();
    }

    public function orederDestroy($id) {
        $order = Orders::find($id);

        $order->delete();
        return $id;
    }

    public function translit($str)
    {
        $tr = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
            "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
            "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
            "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
            "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
            "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
            "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
            "ы"=>"yi","ь"=>"'","э"=>"e","ю"=>"yu","я"=>"ya",
            " "=>"_","?"=>"_","/"=>"_","\\"=>"_",
            "*"=>"_",":"=>"_","*"=>"_","\""=>"_","<"=>"_",
            ">"=>"_","|"=>"_"
        );
        return strtr($str,$tr);
    }




}
