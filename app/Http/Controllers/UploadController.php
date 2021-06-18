<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class UploadController extends Controller
{
//    public function upload(Request $request)
//    {
//
//        $image = $request->file('image');
//        $image_path = $image->getPathname();
//
//        $filename = time().'_'.preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
//
//        $tmp = $image->storeAs('app/public/uploads', $filename, 'tmp');
//
//        $upload = Products::create([
//           'image'  => $filename
//        ]);
//
//        return response()->json($upload, 200);
//
//    }
    public function byIdUpload(Request $request)
    {
        if($image = $request->file('image')) {
        $image_path = $image->getPathname();

        $filename = time().'_'.preg_replace('/\s+/', '_',
                strtolower($this->translit($image->getClientOriginalName())));

        $tmp = $image->storeAs('app/public/uploads', $filename, 'tmp');
        }

        return response()->json($filename ?? '', 200);
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
            "ы"=>"yi","ь"=>"'","э"=>"e","ю"=>"yu","я"=>"ya"
        ," "=>"_","?"=>"_","/"=>"_","\\"=>"_",
            "*"=>"_",":"=>"_","*"=>"_","\""=>"_","<"=>"_",
            ">"=>"_","|"=>"_"
        );
        return strtr($str,$tr);
    }
}
