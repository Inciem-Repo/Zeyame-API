<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Poster;
use Intervention\Image\Facades\Image;
use App\Models\PosterItems;
use App\Models\SearchCategory;
use App\Models\User;
use App\Models\Font;
use App\Models\Gallery;
use App\Models\Customer;
use App\Models\Goldrate;
use App\Models\Download;
use App\Models\DownloadHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ViewCategoryController extends Controller
{

    function jsonslider()
    {
        $data = array();
        $files = Gallery::where('file', '!=', '')->get();
        foreach ($files as $file) {
            $path = "https://posterzeyame.com/categoryimages/" . $file->file;
            array_push($data, $path);
        }
        return response($data, 200);
    }
    function jsonslidernew()
    {
        $data = array();
        $files = Gallery::where('file', '!=', '')->get();
        $key = "img";
        foreach ($files as $file) {
            $path = "https://posterzeyame.com/categoryimages/" . $file->file;
            $data[] = [
                $key => $path,
            ];
        }
        return response($data, 200);
    }
    function index()
    {
        $data = array();
        $data['data'] = Category::get();
        return view('category', $data);
    }
    function jsonlogin(Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);

        $token = $user->createToken('api_token')->plainTextToken;
        $data['user'] = $user;
        $data['customer'] = Customer::where('email', $user['username'])->first();
        $data['success'] = true;
        $data['message'] = "Login Successfully!..";
        $data['token'] = $token;
        return response($data, 200);
    }
    function jsoncat(Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $customer = Customer::where('email', $user['username'])->first();
        $usercat = explode(',', $customer->category);
        $data = array();
        $cat = Category::get();
        foreach ($cat as $item) {
            if (in_array($item->name, $usercat)) {
                $data['data'][] = [
                    "id" => $item->id,
                    "name" => $item->name,
                    "file" => $item->file,
                    "date" => $item->date
                ];
            }
        }

        return response($data, 200);
    }
    function poster(Request $request, $id = 0)
    {
        $query = Poster::query();

        // Filter by category if $id is provided
        if ($id != 0) {
            $query->where('category', '=', $id);
        }

        // Search by poster ID if provided
        if ($request->has('search_id') && !empty($request->search_id)) {
            $query->where('id', $request->search_id);
        }

        // Sorting by ID (asc/desc)
        $sortOrder = $request->get('sort', 'asc'); // Default: ascending
        $query->orderBy('id', $sortOrder);

        // Paginate results
        $posters = $query->paginate(15);

        // Pass filter values to the view
        return view('poster', ['data' => $posters, 'search_id' => $request->search_id, 'sort' => $sortOrder]);
    }
    function jsonposter($id = 0, Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $data = array();
        $poster = Poster::where('id', '!=', '0');
        if ($id != 0) {
            $poster->where('category', '=', $id);
        }
        $poster = $poster->orderBy('id', 'desc')->paginate(15);
        $data['data'] = $poster;
        return response($data, 200);
    }
    function jsonlogo($id = 0, Request $request)
    {

        $poster = Customer::where('email', '=', $id);
        $poster = $poster->first();

        $name = "/www/wwwroot/posterzeyame.com/uploads/" . $poster['file'];
        $fp = fopen($name, 'rb');

        header("Content-Type: image/png");
        header("Content-Length: " . filesize($name));

        fpassthru($fp);
    }
    function jsongoldrate($id = 0, Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $data = array();
        $gold_rate = Goldrate::where('customerid', $id)->OrderBy('id', 'desc')->first();
        $data['data'] = $gold_rate;
        return response($data, 200);
    }
    function jsongoldrateupdate($id = 0, Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $data = array();
        $data['customerid'] = $id;
        $silver_rate = 0;
        if (isset($request->silver_rate) && $request->silver_rate != '') {
            $silver_rate = (float)$request->silver_rate;
        }
        $nine_rate = 0;
        if (isset($request->nine_rate) && $request->nine_rate != '') {
            $nine_rate = (float)$request->nine_rate;
        }
        $nineone_rate = 0;
        if (isset($request->nineone_rate) && $request->nineone_rate != '') {
            $nineone_rate = (float)$request->nineone_rate;
        }
        $eight_rate = 0;
        if (isset($request->eight_rate) && $request->eight_rate != '') {
            $eight_rate = (float)$request->eight_rate;
        }
        $seven_rate = 0;
        if (isset($request->seven_rate) && $request->seven_rate != '') {
            $seven_rate = (float)$request->seven_rate;
        }
        $silver_ornament_rate = 0;
        if (isset($request->silver_ornament_rate) && $request->silver_ornament_rate != '') {
            $silver_ornament_rate = (float)$request->silver_ornament_rate;
        }
        $price = (float)$request->price;
        $data['rate'] = $price;
        $price = $price * 8;
        $data['eightgram'] = $price;
        $data['date'] = date('d-m-Y');
        $data['silver_rate'] = $silver_rate;
        $data['nine_rate'] = $nine_rate;
        $data['nineone_rate'] = $nineone_rate;
        $data['eight_rate'] = $eight_rate;
        $data['seven_rate'] = $seven_rate;
        $data['silver_ornament_rate'] = $silver_ornament_rate;
        GoldRate::create($data);
        $data['success'] = "Gold Rate updated successfully..";
        return response($data, 200);
    }
    function editor($id)
    {

        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        $posteritems = PosterItems::where('p_poster_id', $id)->orderBy('p_type_index', 'asc')->get();
        $data['styles'] = array();
        $data['flag'] = true;
        $index = 0;
        $data['styles'][0]['left'] = '12';
        $data['styles'][0]['top'] = '1';
        $data['styles'][0]['content'] = date('jS M Y');
        $data['styles'][0]['type'] = 'text';
        $data['styles'][0]['id'] = 0;

        $data['styles'][1]['left'] = '12';
        $data['styles'][1]['top'] = '21';
        $data['styles'][1]['content'] = '4,460';
        $data['styles'][1]['type'] = 'text';
        $data['styles'][1]['id'] = 1;

        $data['styles'][2]['left'] = '12';
        $data['styles'][2]['top'] = '41';
        $data['styles'][2]['content'] = '35,680';
        $data['styles'][2]['type'] = 'text';
        $data['styles'][2]['id'] = 2;

        $data['styles'][3]['left'] = '12';
        $data['styles'][3]['top'] = '61';
        $data['styles'][3]['content'] = 'Address';
        $data['styles'][3]['type'] = 'text';
        $data['styles'][3]['id'] = 3;

        $data['styles'][4]['left'] = '12';
        $data['styles'][4]['top'] = '81';
        $data['styles'][4]['content'] = '';
        $data['styles'][4]['type'] = 'image';
        $data['styles'][4]['id'] = 4;

        $data['styles'][5]['left'] = '12';
        $data['styles'][5]['top'] = '111';
        $data['styles'][5]['content'] = 'Number';
        $data['styles'][5]['type'] = 'text';
        $data['styles'][5]['id'] = 5;

        $data['styles'][6]['left'] = '12';
        $data['styles'][6]['top'] = '141';
        $data['styles'][6]['content'] = '';
        $data['styles'][6]['type'] = 'image';
        $data['styles'][6]['id'] = 6;

        $data['styles'][7]['left'] = '12';
        $data['styles'][7]['top'] = '81';
        $data['styles'][7]['content'] = 'Address2';
        $data['styles'][7]['type'] = 'text';
        $data['styles'][7]['id'] = 7;

        $data['styles'][8]['left'] = '12';
        $data['styles'][8]['top'] = '91';
        $data['styles'][8]['content'] = 'Silver';
        $data['styles'][8]['type'] = 'text';
        $data['styles'][8]['id'] = 8;

        $data['styles'][9]['left'] = '18';
        $data['styles'][9]['top'] = '101';
        $data['styles'][9]['content'] = '999 Rate';
        $data['styles'][9]['type'] = 'text';
        $data['styles'][9]['font-size'] = '16';
        $data['styles'][9]['id'] = 9;

        $data['styles'][10]['left'] = '18';
        $data['styles'][10]['top'] = '121';
        $data['styles'][10]['content'] = '84 Rate';
        $data['styles'][10]['type'] = 'text';
        $data['styles'][10]['font-size'] = '16';
        $data['styles'][10]['id'] = 10;

        $data['styles'][11]['left'] = '21';
        $data['styles'][11]['top'] = '131';
        $data['styles'][11]['content'] = '75 Rate';
        $data['styles'][11]['type'] = 'text';
        $data['styles'][11]['font-size'] = '16';
        $data['styles'][11]['id'] = 11;

        $data['styles'][12]['left'] = '21';
        $data['styles'][12]['top'] = '141';
        $data['styles'][12]['content'] = 'Sil.orn.Rate';
        $data['styles'][12]['type'] = 'text';
        $data['styles'][12]['font-size'] = '16';
        $data['styles'][12]['id'] = 12;

        $data['styles'][13]['left'] = '12';
        $data['styles'][13]['top'] = '81';
        $data['styles'][13]['content'] = '';
        $data['styles'][13]['type'] = 'image';
        $data['styles'][13]['id'] = 13;

        $data['styles'][14]['left'] = '21';
        $data['styles'][14]['top'] = '131';
        $data['styles'][14]['content'] = '89 Rate';
        $data['styles'][14]['type'] = 'text';
        $data['styles'][14]['font-size'] = '16';
        $data['styles'][14]['id'] = 14;

        foreach ($posteritems as $key => $itme) {
            $index = $itme['p_type_index'];
            $data['styles'][$index][$itme['p_style']] = $itme['p_style_value'];
            $data['styles'][$index]['content'] = strip_tags($itme['p_content']);
            $data['styles'][$index]['type'] = $itme['p_type'];
            $data['styles'][$index]['id'] = $index;
        }
        $data['width'] = '605px';
        $data['height'] = '605px';

        $image_path = '../../posterimages/' . $data['item']['ofile'];
        // $newimage_path='posterimages/test.jpg';
        $img = Image::make(public_path($image_path));
        $original_width = $img->width();
        $original_height = $img->height();

        $new_height = 605;
        $scale_factor = $new_height / $original_height;
        $new_width = (int)($original_width * $scale_factor);

        $data['width'] = $new_width . "px";

        if (count($data['styles']) == 0) {
            $data['flag'] = false;
        }
        return view('editor', $data);
    }
    function generate($id, $res)
    {
        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        // $name="testing.jpg";
        $image_path = '../../posterimages/' . $data['item']['ofile'];
        // $newimage_path='posterimages/test.jpg';
        $img = Image::make(public_path($image_path));
        $img->resize($res, $res);
        $width = $img->width();
        $height = $img->height();
        $posteritems = PosterItems::where('p_poster_id', $id)->orderBy('p_type_index', 'asc')->get();
        $styles = array();
        foreach ($posteritems as $key => $itme) {
            $index = $itme['p_type_index'];
            $styles[$index][$itme['p_style']] = $itme['p_style_value'];
            $styles[$index]['content'] = strip_tags($itme['p_content']);
            $styles[$index]['type'] = $itme['p_type'];
            $styles[$index]['id'] = $index;
            $styles[$index]['category'] = $data['item']['category'];
        }

        if ($posteritems->count() > 0) {
            if (isset($styles{
                0}['content'])) {
                $styles{
                    0}['content'] = date('jS M Y');
            }
            $jname = 'Zeyame Poster';
            $font = "arial.ttf";
            if (isset($customer->id)) {
                $user_lang = User::where('id', $customer->id)->first();
                $lang_type = Font::where('id', $user_lang['lang_id'])->first();
                $font = $lang_type['value'];
                $jname = $customer->name;
                $gold_rate = Goldrate::where('customerid', $customer->id)->OrderBy('id', 'desc')->first();
                if (isset($gold_rate->rate)) {
                    if (isset($styles{
                        1}['content'])) $styles{
                        1}['content'] = $gold_rate->rate;
                    if (isset($styles{
                        2}['content'])) $styles{
                        2}['content'] = $gold_rate->eightgram;
                    if (isset($styles{
                        8}['content'])) $styles{
                        8}['content'] = $gold_rate->silver_rate;
                    if (isset($styles{
                        9}['content'])) $styles{
                        9}['content'] = $gold_rate->nine_rate;
                    if (isset($styles{
                        10}['content'])) $styles{
                        10}['content'] = $gold_rate->eight_rate;
                    if (isset($styles{
                        11}['content'])) $styles{
                        11}['content'] = $gold_rate->seven_rate;
                    if (isset($styles{
                        14}['content'])) $styles{
                        14}['content'] = $gold_rate->eightnine;
                    if (isset($styles{
                        12}['content'])) $styles{
                        12}['content'] = $gold_rate->silver_ornament_rate;
                } else {
                }
                if (isset($styles{
                    7}['content'])) {
                    $styles{
                        7}['content'] = $customer->address2;
                }
                if (isset($styles{
                    3}['content'])) {
                    // if(isset($styles{3}['category'])&&$styles{3}['category']==2){
                    $styles{
                        3}['content'] = $customer->address;
                    //}else{
                    //    $styles{3}['content'] = $customer->address.'|'.$customer->phone;
                    //}
                }
                if (isset($styles{
                    5}['content'])) {
                    $styles{
                        5}['content'] = $customer->phone;
                }
                if (isset($styles{
                    4}['content'])) {
                    $styles{
                        4}['content'] = '../../uploads/' . $customer->file;
                }
            }
            if (isset($styles{
                4}['content']) && $styles{
                4}['content'] == '') {
                $styles{
                    4}['content'] = 'images/ivlogo.png';
            }

            if (isset($styles{
                0}['show']) && $styles{
                0}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    0}['centerh']) && $styles{
                    0}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    0}['centerv']) && $styles{
                    0}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    0}['left']) && isset($styles{
                    0}['top']) && isset($styles{
                    0}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    0}['left'], $styles{
                    0}['top'], $styles{
                    0}['content'], '', isset($styles{
                    0}['color']) ? $styles{
                    0}['color'] : '', isset($styles{
                    0}['font-size']) ? $styles{
                    0}['font-size'] : '', $properties);
            }
            if (isset($styles{
                1}['show']) && $styles{
                1}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    1}['centerh']) && $styles{
                    1}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    1}['centerv']) && $styles{
                    1}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    1}['left']) && isset($styles{
                    1}['top']) && isset($styles{
                    1}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    1}['left'], $styles{
                    1}['top'], $styles{
                    1}['content'], '', isset($styles{
                    1}['color']) ? $styles{
                    1}['color'] : '', isset($styles{
                    1}['font-size']) ? $styles{
                    1}['font-size'] : '', $properties);
            }
            if (isset($styles{
                2}['show']) && $styles{
                2}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    2}['centerh']) && $styles{
                    2}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    2}['centerv']) && $styles{
                    2}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    2}['left']) && isset($styles{
                    2}['top']) && isset($styles{
                    2}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    2}['left'], $styles{
                    2}['top'], $styles{
                    2}['content'], '', isset($styles{
                    2}['color']) ? $styles{
                    2}['color'] : '', isset($styles{
                    2}['font-size']) ? $styles{
                    2}['font-size'] : '', $properties);
            }
            if (isset($styles{
                7}['show']) && $styles{
                7}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    7}['centerh']) && $styles{
                    7}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    7}['centerv']) && $styles{
                    7}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    7}['left']) && isset($styles{
                    7}['top']) && isset($styles{
                    7}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    7}['left'], $styles{
                    7}['top'], $styles{
                    7}['content'], '', isset($styles{
                    7}['color']) ? $styles{
                    7}['color'] : '', isset($styles{
                    7}['font-size']) ? $styles{
                    7}['font-size'] : '', $properties);
            }
            if (isset($styles{
                8}['show']) && $styles{
                8}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    8}['centerh']) && $styles{
                    8}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    8}['centerv']) && $styles{
                    8}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    8}['left']) && isset($styles{
                    8}['top']) && isset($styles{
                    8}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    8}['left'], $styles{
                    8}['top'], $styles{
                    8}['content'], '', isset($styles{
                    8}['color']) ? $styles{
                    8}['color'] : '', isset($styles{
                    8}['font-size']) ? $styles{
                    8}['font-size'] : '', $properties);
            }
            if (isset($styles{
                9}['show']) && $styles{
                9}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    9}['centerh']) && $styles{
                    9}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    9}['centerv']) && $styles{
                    9}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    9}['left']) && isset($styles{
                    9}['top']) && isset($styles{
                    9}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    9}['left'], $styles{
                    9}['top'], $styles{
                    9}['content'], '', isset($styles{
                    9}['color']) ? $styles{
                    9}['color'] : '', isset($styles{
                    9}['font-size']) ? $styles{
                    9}['font-size'] : '', $properties);
            }
            if (isset($styles{
                10}['show']) && $styles{
                10}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    10}['centerh']) && $styles{
                    10}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    10}['centerv']) && $styles{
                    10}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    10}['left']) && isset($styles{
                    10}['top']) && isset($styles{
                    10}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    10}['left'], $styles{
                    10}['top'], $styles{
                    10}['content'], '', isset($styles{
                    10}['color']) ? $styles{
                    10}['color'] : '', isset($styles{
                    10}['font-size']) ? $styles{
                    10}['font-size'] : '', $properties);
            }
            if (isset($styles{
                11}['show']) && $styles{
                11}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    11}['centerh']) && $styles{
                    11}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    11}['centerv']) && $styles{
                    11}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    11}['left']) && isset($styles{
                    11}['top']) && isset($styles{
                    11}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    11}['left'], $styles{
                    11}['top'], $styles{
                    11}['content'], '', isset($styles{
                    11}['color']) ? $styles{
                    11}['color'] : '', isset($styles{
                    11}['font-size']) ? $styles{
                    11}['font-size'] : '', $properties);
            }
            if (isset($styles{
                12}['show']) && $styles{
                12}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    12}['centerh']) && $styles{
                    12}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    12}['centerv']) && $styles{
                    12}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    12}['left']) && isset($styles{
                    12}['top']) && isset($styles{
                    12}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    12}['left'], $styles{
                    12}['top'], $styles{
                    12}['content'], '', isset($styles{
                    12}['color']) ? $styles{
                    12}['color'] : '', isset($styles{
                    12}['font-size']) ? $styles{
                    12}['font-size'] : '', $properties);
            }
            if (isset($styles{
                3}['show']) && $styles{
                3}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    3}['centerh']) && $styles{
                    3}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    3}['centerv']) && $styles{
                    3}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    3}['left']) && isset($styles{
                    3}['top']) && isset($styles{
                    3}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    3}['left'], $styles{
                    3}['top'], $styles{
                    3}['content'], '', isset($styles{
                    3}['color']) ? $styles{
                    3}['color'] : '', isset($styles{
                    3}['font-size']) ? $styles{
                    3}['font-size'] : '', $properties);
            }
            if (isset($styles{
                4}['show']) && $styles{
                4}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    4}['centerh']) && $styles{
                    4}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    4}['centerv']) && $styles{
                    4}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    4}['left']) && isset($styles{
                    4}['top']) && isset($styles{
                    4}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'image', $styles{
                    4}['left'], $styles{
                    4}['top'], $styles{
                    4}['content'], '', isset($styles{
                    4}['color']) ? $styles{
                    4}['color'] : '', isset($styles{
                    4}['font-size']) ? $styles{
                    4}['font-size'] : '', $properties);
            }
            if (isset($styles{
                5}['show']) && $styles{
                5}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    5}['centerh']) && $styles{
                    5}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    5}['centerv']) && $styles{
                    5}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    5}['left']) && isset($styles{
                    5}['top']) && isset($styles{
                    5}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    5}['left'], $styles{
                    5}['top'], $styles{
                    5}['content'], '', isset($styles{
                    5}['color']) ? $styles{
                    5}['color'] : '', isset($styles{
                    5}['font-size']) ? $styles{
                    5}['font-size'] : '', $properties);
            }
            if (isset($styles{
                6}['show']) && $styles{
                6}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                $styles{
                    6}['content'] = 'images/hallmark.png';
                if (isset($styles{
                    6}['centerh']) && $styles{
                    6}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    6}['centerv']) && $styles{
                    6}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    6}['left']) && isset($styles{
                    6}['top']) && isset($styles{
                    6}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'imagehall', $styles{
                    6}['left'], $styles{
                    6}['top'], $styles{
                    6}['content'], '', isset($styles{
                    6}['color']) ? $styles{
                    6}['color'] : '', isset($styles{
                    6}['font-size']) ? $styles{
                    6}['font-size'] : '', $properties);
            }
        }

        return $img->response('jpg');

        // for($i=1;$i<2;$i++){
        //     $img->text('18th Nov 2021', $x+$i, $y+$i, function($font) {  
        //         $font->file(public_path('fonts/arial.ttf'));  
        //         $font->size($GLOBALS['fontsize']);  
        //         //$font->weight(500);  
        //         $font->color('#808080');  
        //         $font->align('left');  
        //         $font->valign('top');  
        //         $font->angle(0);  
        //     }); 
        // }


        //$img->save(public_path($newimage_path));
        // $image=$img->encode('jpg');
        // $headers = [
        //     'Content-Type' => 'image/jpeg',
        //     'Content-Disposition' => 'attachment; filename='. $name,
        // ]; 

        // return response()->stream(function() use ($image) {
        //     echo $image;
        // }, 200, $headers); 

        //return view('generate',$data);
    }
    function generatecpy($id)
    {
        $data = [];
        $posters = Poster::where("poster_cpy", $id)->get();

        foreach ($posters as $poster) {
            if ($poster->ofile) {
                // Check if the file is stored in S3 or local
                if (Storage::disk('s3')->exists('poster/' . $poster->ofile)) {
                    // If only the file name is stored, generate the S3 URL
                    $poster->file_url = Storage::disk('s3')->url('poster/' . $poster->ofile);
                    $poster->storage_flag = 's3';
                } else {
                    // Assume file is stored locally in `posterimages/`
                    $poster->file_url = asset('../posterimages/' . $poster->ofile);
                    $poster->storage_flag = 'local';
                }
            } else {
                $poster->file_url = null;
                $poster->storage_flag = 'none'; // No file available
            }
        }

        $data['data'] = $posters;
        $data['id'] = $id;

        return view('generatecpy', $data);
    }
    public function create($id)
    {
        return view('postercreate', ['id' => $id]);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // $imagePath = $request->file('image_path')->store('posterimages', 'public');

        $destinationPath = base_path('../posterimages');
        // Get the original file name
        $image = $request->file('image_path');
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Move image to custom storage path
        $image->move($destinationPath, $imageName);
        //  $data=array();

        $data = Poster::find($id); // Fetch existing record

        if ($data) {
            $newData = $data->toArray(); // Convert model to array
            $newData['ofile'] = $imageName;
            $newData['date'] = date('d-m-Y');
            $newData['poster_cpy'] = $id;

            $newPoster = Poster::create($newData); // Insert new record


            $posterItems = PosterItems::where('p_poster_id', $id)->get();

            foreach ($posterItems as $item) {
                $newPosterItem = $item->replicate(); // Clone the item
                $newPosterItem->p_poster_id = $newPoster->id; // Assign to new poster
                $newPosterItem->save(); // Save new item
            }
        }
        return redirect()->route('generatecpy', ['id' => $id])->with('success', 'Poster uploaded successfully');
    }
    function jsongenerate($id, $res, Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $customer = Customer::where('email', $user['username'])->first();
        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        // $name="testing.jpg";
        $image_path = '../../posterimages/' . $data['item']['ofile'];
        // $newimage_path='posterimages/test.jpg';
        $img = Image::make(public_path($image_path));
        $img->resize($res, $res);
        $width = $img->width();
        $height = $img->height();
        $posteritems = PosterItems::where('p_poster_id', $id)->orderBy('p_type_index', 'asc')->get();
        $styles = array();
        foreach ($posteritems as $key => $itme) {
            $index = $itme['p_type_index'];
            $styles[$index][$itme['p_style']] = $itme['p_style_value'];
            $styles[$index]['content'] = strip_tags($itme['p_content']);
            $styles[$index]['type'] = $itme['p_type'];
            $styles[$index]['id'] = $index;
            $styles[$index]['category'] = $data['item']['category'];
        }

        if ($posteritems->count() > 0) {
            if (isset($styles{
                0}['content'])) {
                $styles{
                    0}['content'] = date('jS M Y');
            }
            $jname = 'Zeyame Poster';
            $font = "arial.ttf";
            if (isset($customer->id)) {
                $user_lang = User::where('id', $customer->id)->first();
                $lang_type = Font::where('id', $user_lang['lang_id'])->first();
                $font = $lang_type['value'];
                $jname = $customer->name;
                $gold_rate = Goldrate::where('customerid', $customer->id)->OrderBy('id', 'desc')->first();
                if (isset($gold_rate->rate)) {
                    if (isset($styles{
                        1}['content'])) $styles{
                        1}['content'] = $gold_rate->rate;
                    if (isset($styles{
                        2}['content'])) $styles{
                        2}['content'] = $gold_rate->eightgram;
                    if (isset($styles{
                        8}['content'])) $styles{
                        8}['content'] = $gold_rate->silver_rate;
                    if (isset($styles{
                        9}['content'])) $styles{
                        9}['content'] = $gold_rate->nine_rate;
                    if (isset($styles{
                        10}['content'])) $styles{
                        10}['content'] = $gold_rate->eight_rate;
                    if (isset($styles{
                        11}['content'])) $styles{
                        11}['content'] = $gold_rate->seven_rate;
                    if (isset($styles{
                        12}['content'])) $styles{
                        12}['content'] = $gold_rate->silver_ornament_rate;
                } else {
                }
                if (isset($styles{
                    7}['content'])) {
                    $styles{
                        7}['content'] = $customer->address2;
                }
                if (isset($styles{
                    3}['content'])) {
                    // if(isset($styles{3}['category'])&&$styles{3}['category']==2){
                    $styles{
                        3}['content'] = $customer->address;
                    //}else{
                    //    $styles{3}['content'] = $customer->address.'|'.$customer->phone;
                    //}
                }
                if (isset($styles{
                    5}['content'])) {
                    $styles{
                        5}['content'] = $customer->phone;
                }
                if (isset($styles{
                    4}['content'])) {
                    $styles{
                        4}['content'] = '../../uploads/' . $customer->file;
                }
            }
            if (isset($styles{
                4}['content']) && $styles{
                4}['content'] == '') {
                $styles{
                    4}['content'] = 'images/ivlogo.png';
            }

            if (isset($styles{
                0}['show']) && $styles{
                0}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    0}['centerh']) && $styles{
                    0}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    0}['centerv']) && $styles{
                    0}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    0}['left']) && isset($styles{
                    0}['top']) && isset($styles{
                    0}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    0}['left'], $styles{
                    0}['top'], $styles{
                    0}['content'], '', isset($styles{
                    0}['color']) ? $styles{
                    0}['color'] : '', isset($styles{
                    0}['font-size']) ? $styles{
                    0}['font-size'] : '', $properties);
            }
            if (isset($styles{
                1}['show']) && $styles{
                1}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    1}['centerh']) && $styles{
                    1}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    1}['centerv']) && $styles{
                    1}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    1}['left']) && isset($styles{
                    1}['top']) && isset($styles{
                    1}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    1}['left'], $styles{
                    1}['top'], $styles{
                    1}['content'], '', isset($styles{
                    1}['color']) ? $styles{
                    1}['color'] : '', isset($styles{
                    1}['font-size']) ? $styles{
                    1}['font-size'] : '', $properties);
            }
            if (isset($styles{
                2}['show']) && $styles{
                2}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    2}['centerh']) && $styles{
                    2}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    2}['centerv']) && $styles{
                    2}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    2}['left']) && isset($styles{
                    2}['top']) && isset($styles{
                    2}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    2}['left'], $styles{
                    2}['top'], $styles{
                    2}['content'], '', isset($styles{
                    2}['color']) ? $styles{
                    2}['color'] : '', isset($styles{
                    2}['font-size']) ? $styles{
                    2}['font-size'] : '', $properties);
            }
            if (isset($styles{
                7}['show']) && $styles{
                7}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    7}['centerh']) && $styles{
                    7}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    7}['centerv']) && $styles{
                    7}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    7}['left']) && isset($styles{
                    7}['top']) && isset($styles{
                    7}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    7}['left'], $styles{
                    7}['top'], $styles{
                    7}['content'], '', isset($styles{
                    7}['color']) ? $styles{
                    7}['color'] : '', isset($styles{
                    7}['font-size']) ? $styles{
                    7}['font-size'] : '', $properties);
            }
            if (isset($styles{
                8}['show']) && $styles{
                8}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    8}['centerh']) && $styles{
                    8}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    8}['centerv']) && $styles{
                    8}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    8}['left']) && isset($styles{
                    8}['top']) && isset($styles{
                    8}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    8}['left'], $styles{
                    8}['top'], $styles{
                    8}['content'], '', isset($styles{
                    8}['color']) ? $styles{
                    8}['color'] : '', isset($styles{
                    8}['font-size']) ? $styles{
                    8}['font-size'] : '', $properties);
            }
            if (isset($styles{
                9}['show']) && $styles{
                9}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    9}['centerh']) && $styles{
                    9}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    9}['centerv']) && $styles{
                    9}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    9}['left']) && isset($styles{
                    9}['top']) && isset($styles{
                    9}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    9}['left'], $styles{
                    9}['top'], $styles{
                    9}['content'], '', isset($styles{
                    9}['color']) ? $styles{
                    9}['color'] : '', isset($styles{
                    9}['font-size']) ? $styles{
                    9}['font-size'] : '', $properties);
            }
            if (isset($styles{
                10}['show']) && $styles{
                10}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    10}['centerh']) && $styles{
                    10}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    10}['centerv']) && $styles{
                    10}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    10}['left']) && isset($styles{
                    10}['top']) && isset($styles{
                    10}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    10}['left'], $styles{
                    10}['top'], $styles{
                    10}['content'], '', isset($styles{
                    10}['color']) ? $styles{
                    10}['color'] : '', isset($styles{
                    10}['font-size']) ? $styles{
                    10}['font-size'] : '', $properties);
            }
            if (isset($styles{
                11}['show']) && $styles{
                11}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    11}['centerh']) && $styles{
                    11}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    11}['centerv']) && $styles{
                    11}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    11}['left']) && isset($styles{
                    11}['top']) && isset($styles{
                    11}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    11}['left'], $styles{
                    11}['top'], $styles{
                    11}['content'], '', isset($styles{
                    11}['color']) ? $styles{
                    11}['color'] : '', isset($styles{
                    11}['font-size']) ? $styles{
                    11}['font-size'] : '', $properties);
            }
            if (isset($styles{
                12}['show']) && $styles{
                12}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    12}['centerh']) && $styles{
                    12}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    12}['centerv']) && $styles{
                    12}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    12}['left']) && isset($styles{
                    12}['top']) && isset($styles{
                    12}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    12}['left'], $styles{
                    12}['top'], $styles{
                    12}['content'], '', isset($styles{
                    12}['color']) ? $styles{
                    12}['color'] : '', isset($styles{
                    12}['font-size']) ? $styles{
                    12}['font-size'] : '', $properties);
            }
            if (isset($styles{
                3}['show']) && $styles{
                3}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    3}['centerh']) && $styles{
                    3}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    3}['centerv']) && $styles{
                    3}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    3}['left']) && isset($styles{
                    3}['top']) && isset($styles{
                    3}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    3}['left'], $styles{
                    3}['top'], $styles{
                    3}['content'], '', isset($styles{
                    3}['color']) ? $styles{
                    3}['color'] : '', isset($styles{
                    3}['font-size']) ? $styles{
                    3}['font-size'] : '', $properties);
            }
            if (isset($styles{
                4}['show']) && $styles{
                4}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    4}['centerh']) && $styles{
                    4}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    4}['centerv']) && $styles{
                    4}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    4}['left']) && isset($styles{
                    4}['top']) && isset($styles{
                    4}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'image', $styles{
                    4}['left'], $styles{
                    4}['top'], $styles{
                    4}['content'], '', isset($styles{
                    4}['color']) ? $styles{
                    4}['color'] : '', isset($styles{
                    4}['font-size']) ? $styles{
                    4}['font-size'] : '', $properties);
            }
            if (isset($styles{
                5}['show']) && $styles{
                5}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    5}['centerh']) && $styles{
                    5}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    5}['centerv']) && $styles{
                    5}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    5}['left']) && isset($styles{
                    5}['top']) && isset($styles{
                    5}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    5}['left'], $styles{
                    5}['top'], $styles{
                    5}['content'], '', isset($styles{
                    5}['color']) ? $styles{
                    5}['color'] : '', isset($styles{
                    5}['font-size']) ? $styles{
                    5}['font-size'] : '', $properties);
            }
            if (isset($styles{
                6}['show']) && $styles{
                6}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                $styles{
                    6}['content'] = 'images/hallmark.png';
                if (isset($styles{
                    6}['centerh']) && $styles{
                    6}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    6}['centerv']) && $styles{
                    6}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    6}['left']) && isset($styles{
                    6}['top']) && isset($styles{
                    6}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'imagehall', $styles{
                    6}['left'], $styles{
                    6}['top'], $styles{
                    6}['content'], '', isset($styles{
                    6}['color']) ? $styles{
                    6}['color'] : '', isset($styles{
                    6}['font-size']) ? $styles{
                    6}['font-size'] : '', $properties);
            }
        }
        return $img->response('jpg');
    }
    function jsongeneratebase($id, $res, Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $customer = Customer::where('email', $user['username'])->first();
        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        // $name="testing.jpg";
        $image_path = '../../posterimages/' . $data['item']['ofile'];
        // $newimage_path='posterimages/test.jpg';
        $img = Image::make(public_path($image_path));
        $img->resize($res, $res);
        $width = $img->width();
        $height = $img->height();
        $posteritems = PosterItems::where('p_poster_id', $id)->orderBy('p_type_index', 'asc')->get();
        $styles = array();
        foreach ($posteritems as $key => $itme) {
            $index = $itme['p_type_index'];
            $styles[$index][$itme['p_style']] = $itme['p_style_value'];
            $styles[$index]['content'] = strip_tags($itme['p_content']);
            $styles[$index]['type'] = $itme['p_type'];
            $styles[$index]['id'] = $index;
            $styles[$index]['category'] = $data['item']['category'];
        }

        if ($posteritems->count() > 0) {
            if (isset($styles{
                0}['content'])) {
                $styles{
                    0}['content'] = date('jS M Y');
            }
            $jname = 'Zeyame Poster';
            $font = "arial.ttf";
            if (isset($customer->id)) {
                $user_lang = User::where('id', $customer->id)->first();
                $lang_type = Font::where('id', $user_lang['lang_id'])->first();
                $font = $lang_type['value'];
                $jname = $customer->name;
                $gold_rate = Goldrate::where('customerid', $customer->id)->OrderBy('id', 'desc')->first();
                if (isset($gold_rate->rate)) {
                    if (isset($styles{
                        1}['content'])) $styles{
                        1}['content'] = $gold_rate->rate;
                    if (isset($styles{
                        2}['content'])) $styles{
                        2}['content'] = $gold_rate->eightgram;
                    if (isset($styles{
                        8}['content'])) $styles{
                        8}['content'] = $gold_rate->silver_rate;
                    if (isset($styles{
                        9}['content'])) $styles{
                        9}['content'] = $gold_rate->nine_rate;
                    if (isset($styles{
                        10}['content'])) $styles{
                        10}['content'] = $gold_rate->eight_rate;
                    if (isset($styles{
                        11}['content'])) $styles{
                        11}['content'] = $gold_rate->seven_rate;
                    if (isset($styles{
                        12}['content'])) $styles{
                        12}['content'] = $gold_rate->silver_ornament_rate;
                } else {
                }
                if (isset($styles{
                    7}['content'])) {
                    $styles{
                        7}['content'] = $customer->address2;
                }
                if (isset($styles{
                    3}['content'])) {
                    // if(isset($styles{3}['category'])&&$styles{3}['category']==2){
                    $styles{
                        3}['content'] = $customer->address;
                    //}else{
                    //    $styles{3}['content'] = $customer->address.'|'.$customer->phone;
                    //}
                }
                if (isset($styles{
                    5}['content'])) {
                    $styles{
                        5}['content'] = $customer->phone;
                }
                if (isset($styles{
                    4}['content'])) {
                    $styles{
                        4}['content'] = '../../uploads/' . $customer->file;
                }
            }
            if (isset($styles{
                4}['content']) && $styles{
                4}['content'] == '') {
                $styles{
                    4}['content'] = 'images/ivlogo.png';
            }
            if (isset($styles{
                0}['show']) && $styles{
                0}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    0}['centerh']) && $styles{
                    0}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    0}['centerv']) && $styles{
                    0}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    0}['left']) && isset($styles{
                    0}['top']) && isset($styles{
                    0}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    0}['left'], $styles{
                    0}['top'], $styles{
                    0}['content'], '', isset($styles{
                    0}['color']) ? $styles{
                    0}['color'] : '', isset($styles{
                    0}['font-size']) ? $styles{
                    0}['font-size'] : '', $properties);
            }
            if (isset($styles{
                1}['show']) && $styles{
                1}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    1}['centerh']) && $styles{
                    1}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    1}['centerv']) && $styles{
                    1}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    1}['left']) && isset($styles{
                    1}['top']) && isset($styles{
                    1}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    1}['left'], $styles{
                    1}['top'], $styles{
                    1}['content'], '', isset($styles{
                    1}['color']) ? $styles{
                    1}['color'] : '', isset($styles{
                    1}['font-size']) ? $styles{
                    1}['font-size'] : '', $properties);
            }
            if (isset($styles{
                2}['show']) && $styles{
                2}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    2}['centerh']) && $styles{
                    2}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    2}['centerv']) && $styles{
                    2}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    2}['left']) && isset($styles{
                    2}['top']) && isset($styles{
                    2}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    2}['left'], $styles{
                    2}['top'], $styles{
                    2}['content'], '', isset($styles{
                    2}['color']) ? $styles{
                    2}['color'] : '', isset($styles{
                    2}['font-size']) ? $styles{
                    2}['font-size'] : '', $properties);
            }
            if (isset($styles{
                7}['show']) && $styles{
                7}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    7}['centerh']) && $styles{
                    7}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    7}['centerv']) && $styles{
                    7}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    7}['left']) && isset($styles{
                    7}['top']) && isset($styles{
                    7}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    7}['left'], $styles{
                    7}['top'], $styles{
                    7}['content'], '', isset($styles{
                    7}['color']) ? $styles{
                    7}['color'] : '', isset($styles{
                    7}['font-size']) ? $styles{
                    7}['font-size'] : '', $properties);
            }
            if (isset($styles{
                8}['show']) && $styles{
                8}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    8}['centerh']) && $styles{
                    8}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    8}['centerv']) && $styles{
                    8}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    8}['left']) && isset($styles{
                    8}['top']) && isset($styles{
                    8}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    8}['left'], $styles{
                    8}['top'], $styles{
                    8}['content'], '', isset($styles{
                    8}['color']) ? $styles{
                    8}['color'] : '', isset($styles{
                    8}['font-size']) ? $styles{
                    8}['font-size'] : '', $properties);
            }
            if (isset($styles{
                9}['show']) && $styles{
                9}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    9}['centerh']) && $styles{
                    9}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    9}['centerv']) && $styles{
                    9}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    9}['left']) && isset($styles{
                    9}['top']) && isset($styles{
                    9}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    9}['left'], $styles{
                    9}['top'], $styles{
                    9}['content'], '', isset($styles{
                    9}['color']) ? $styles{
                    9}['color'] : '', isset($styles{
                    9}['font-size']) ? $styles{
                    9}['font-size'] : '', $properties);
            }
            if (isset($styles{
                10}['show']) && $styles{
                10}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    10}['centerh']) && $styles{
                    10}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    10}['centerv']) && $styles{
                    10}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    10}['left']) && isset($styles{
                    10}['top']) && isset($styles{
                    10}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    10}['left'], $styles{
                    10}['top'], $styles{
                    10}['content'], '', isset($styles{
                    10}['color']) ? $styles{
                    10}['color'] : '', isset($styles{
                    10}['font-size']) ? $styles{
                    10}['font-size'] : '', $properties);
            }
            if (isset($styles{
                11}['show']) && $styles{
                11}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    11}['centerh']) && $styles{
                    11}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    11}['centerv']) && $styles{
                    11}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    11}['left']) && isset($styles{
                    11}['top']) && isset($styles{
                    11}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    11}['left'], $styles{
                    11}['top'], $styles{
                    11}['content'], '', isset($styles{
                    11}['color']) ? $styles{
                    11}['color'] : '', isset($styles{
                    11}['font-size']) ? $styles{
                    11}['font-size'] : '', $properties);
            }
            if (isset($styles{
                12}['show']) && $styles{
                12}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    12}['centerh']) && $styles{
                    12}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    12}['centerv']) && $styles{
                    12}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    12}['left']) && isset($styles{
                    12}['top']) && isset($styles{
                    12}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    12}['left'], $styles{
                    12}['top'], $styles{
                    12}['content'], '', isset($styles{
                    12}['color']) ? $styles{
                    12}['color'] : '', isset($styles{
                    12}['font-size']) ? $styles{
                    12}['font-size'] : '', $properties);
            }
            if (isset($styles{
                3}['show']) && $styles{
                3}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    3}['centerh']) && $styles{
                    3}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    3}['centerv']) && $styles{
                    3}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    3}['left']) && isset($styles{
                    3}['top']) && isset($styles{
                    3}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    3}['left'], $styles{
                    3}['top'], $styles{
                    3}['content'], '', isset($styles{
                    3}['color']) ? $styles{
                    3}['color'] : '', isset($styles{
                    3}['font-size']) ? $styles{
                    3}['font-size'] : '', $properties);
            }
            if (isset($request->nulllogo)) {
            } else {
                if (isset($styles{
                    4}['show']) && $styles{
                    4}['show'] == 'show') {
                    $properties = array();
                    $properties['centerh'] = false;
                    $properties['centerv'] = false;
                    $properties['font'] = $font;
                    if (isset($styles{
                        4}['centerh']) && $styles{
                        4}['centerh'] == 'centerh') $properties['centerh'] = true;
                    if (isset($styles{
                        4}['centerv']) && $styles{
                        4}['centerv'] == 'centerv') $properties['centerv'] = true;
                    if (isset($styles{
                        4}['left']) && isset($styles{
                        4}['top']) && isset($styles{
                        4}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'image', $styles{
                        4}['left'], $styles{
                        4}['top'], $styles{
                        4}['content'], '', isset($styles{
                        4}['color']) ? $styles{
                        4}['color'] : '', isset($styles{
                        4}['font-size']) ? $styles{
                        4}['font-size'] : '', $properties);
                }
            }

            if (isset($styles{
                5}['show']) && $styles{
                5}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    5}['centerh']) && $styles{
                    5}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    5}['centerv']) && $styles{
                    5}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    5}['left']) && isset($styles{
                    5}['top']) && isset($styles{
                    5}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    5}['left'], $styles{
                    5}['top'], $styles{
                    5}['content'], '', isset($styles{
                    5}['color']) ? $styles{
                    5}['color'] : '', isset($styles{
                    5}['font-size']) ? $styles{
                    5}['font-size'] : '', $properties);
            }
            if (isset($styles{
                6}['show']) && $styles{
                6}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                $styles{
                    6}['content'] = 'images/hallmark.png';
                if (isset($styles{
                    6}['centerh']) && $styles{
                    6}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    6}['centerv']) && $styles{
                    6}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    6}['left']) && isset($styles{
                    6}['top']) && isset($styles{
                    6}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'imagehall', $styles{
                    6}['left'], $styles{
                    6}['top'], $styles{
                    6}['content'], '', isset($styles{
                    6}['color']) ? $styles{
                    6}['color'] : '', isset($styles{
                    6}['font-size']) ? $styles{
                    6}['font-size'] : '', $properties);
            }
        }
        if (isset($request->nulllogo)) {
            // $x=$styles{4}['left'];
            // $y=$styles{4}['top'];
            // $x=intval(($width*$x)/595);
            // $y=intval(($height*$y)/595);
            // $icon=public_path($styles{4}['content']);
            // $logo = Image::make($icon);
            // $iwidth = $logo->width();
            // $iheight = $logo->height();

            // if($iwidth>=$iheight){
            //     $nwidth=100;
            //     $nheight=$nwidth*$iheight/$iwidth;
            //     $nwidth=(100-$nheight)+$nwidth;
            //     $nheight=(100-$nheight)+$nheight;
            //     $nwidth=(100-$nheight)+$nwidth;
            // }else{
            //     $nheight=100;
            //     $nwidth=$nheight*$iwidth/$iheight;
            //     $nheight=(100-$nwidth)+$nheight;
            //     $nwidth=(100-$nwidth)+$nwidth;

            // }
            // $width=intval(($width*$nwidth)/595);
            // $height=intval(($height*$nheight)/595);

            return response(['data' => (string)$img->encode('data-url')], 200);
        } else {
            return response(['data' => (string)$img->encode('data-url')], 200);
        }

        return response(['data' => (string)$img->encode('data-url')], 200);
    }
    function jsongeneratedirect($id, $res, $userid)
    {
        $user = User::where('id', $userid)->first();
        $customer = Customer::where('email', $user['username'])->first();
        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        // $name="testing.jpg";
        $image_path = '../../posterimages/' . $data['item']['ofile'];
        // $newimage_path='posterimages/test.jpg';
        $img = Image::make(public_path($image_path));
        $img->resize($res, $res);
        $width = $img->width();
        $height = $img->height();
        $posteritems = PosterItems::where('p_poster_id', $id)->orderBy('p_type_index', 'asc')->get();
        $styles = array();
        foreach ($posteritems as $key => $itme) {
            $index = $itme['p_type_index'];
            $styles[$index][$itme['p_style']] = $itme['p_style_value'];
            $styles[$index]['content'] = strip_tags($itme['p_content']);
            $styles[$index]['type'] = $itme['p_type'];
            $styles[$index]['id'] = $index;
            $styles[$index]['category'] = $data['item']['category'];
        }

        if ($posteritems->count() > 0) {
            if (isset($styles{
                0}['content'])) {
                $styles{
                    0}['content'] = date('jS M Y');
            }
            $jname = 'Zeyame Poster';
            $font = "arial.ttf";
            if (isset($customer->id)) {
                $user_lang = User::where('id', $customer->id)->first();
                $lang_type = Font::where('id', $user_lang['lang_id'])->first();
                $font = $lang_type['value'];
                $jname = $customer->name;
                $gold_rate = Goldrate::where('customerid', $customer->id)->OrderBy('id', 'desc')->first();
                if (isset($gold_rate->rate)) {
                    if (isset($styles{
                        1}['content'])) $styles{
                        1}['content'] = $gold_rate->rate;
                    if (isset($styles{
                        2}['content'])) $styles{
                        2}['content'] = $gold_rate->eightgram;
                } else {
                }
                if (isset($styles{
                    7}['content'])) {
                    $styles{
                        7}['content'] = $customer->address2;
                }
                if (isset($styles{
                    3}['content'])) {
                    // if(isset($styles{3}['category'])&&$styles{3}['category']==2){
                    $styles{
                        3}['content'] = $customer->address;
                    //}else{
                    //    $styles{3}['content'] = $customer->address.'|'.$customer->phone;
                    //}

                }
                if (isset($styles{
                    5}['content'])) {
                    $styles{
                        5}['content'] = $customer->phone;
                }
                if (isset($styles{
                    4}['content'])) {
                    // $styles{4}['content'] = '../../uploads/'.$customer->file;
                    $styles{
                        4}['content'] = 'images/ivlogo.png';
                }
            }
            if (isset($styles{
                4}['content']) && $styles{
                4}['content'] == '') {
                $styles{
                    4}['content'] = 'images/ivlogo.png';
            }
            if (isset($styles{
                0}['show']) && $styles{
                0}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    0}['centerh']) && $styles{
                    0}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    0}['centerv']) && $styles{
                    0}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    0}['left']) && isset($styles{
                    0}['top']) && isset($styles{
                    0}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    0}['left'], $styles{
                    0}['top'], $styles{
                    0}['content'], '', isset($styles{
                    0}['color']) ? $styles{
                    0}['color'] : '', isset($styles{
                    0}['font-size']) ? $styles{
                    0}['font-size'] : '', $properties);
            }
            if (isset($styles{
                1}['show']) && $styles{
                1}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    1}['centerh']) && $styles{
                    1}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    1}['centerv']) && $styles{
                    1}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    1}['left']) && isset($styles{
                    1}['top']) && isset($styles{
                    1}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    1}['left'], $styles{
                    1}['top'], $styles{
                    1}['content'], '', isset($styles{
                    1}['color']) ? $styles{
                    1}['color'] : '', isset($styles{
                    1}['font-size']) ? $styles{
                    1}['font-size'] : '', $properties);
            }
            if (isset($styles{
                2}['show']) && $styles{
                2}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    2}['centerh']) && $styles{
                    2}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    2}['centerv']) && $styles{
                    2}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    2}['left']) && isset($styles{
                    2}['top']) && isset($styles{
                    2}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    2}['left'], $styles{
                    2}['top'], $styles{
                    2}['content'], '', isset($styles{
                    2}['color']) ? $styles{
                    2}['color'] : '', isset($styles{
                    2}['font-size']) ? $styles{
                    2}['font-size'] : '', $properties);
            }
            if (isset($styles{
                7}['show']) && $styles{
                7}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    7}['centerh']) && $styles{
                    7}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    7}['centerv']) && $styles{
                    7}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    7}['left']) && isset($styles{
                    7}['top']) && isset($styles{
                    7}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    7}['left'], $styles{
                    7}['top'], $styles{
                    7}['content'], '', isset($styles{
                    7}['color']) ? $styles{
                    7}['color'] : '', isset($styles{
                    7}['font-size']) ? $styles{
                    7}['font-size'] : '', $properties);
            }
            if (isset($styles{
                8}['show']) && $styles{
                8}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    8}['centerh']) && $styles{
                    8}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    8}['centerv']) && $styles{
                    8}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    8}['left']) && isset($styles{
                    8}['top']) && isset($styles{
                    8}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    8}['left'], $styles{
                    8}['top'], $styles{
                    8}['content'], '', isset($styles{
                    8}['color']) ? $styles{
                    8}['color'] : '', isset($styles{
                    8}['font-size']) ? $styles{
                    8}['font-size'] : '', $properties);
            }
            if (isset($styles{
                9}['show']) && $styles{
                9}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    9}['centerh']) && $styles{
                    9}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    9}['centerv']) && $styles{
                    9}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    9}['left']) && isset($styles{
                    9}['top']) && isset($styles{
                    9}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    9}['left'], $styles{
                    9}['top'], $styles{
                    9}['content'], '', isset($styles{
                    9}['color']) ? $styles{
                    9}['color'] : '', isset($styles{
                    9}['font-size']) ? $styles{
                    9}['font-size'] : '', $properties);
            }
            if (isset($styles{
                10}['show']) && $styles{
                10}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    10}['centerh']) && $styles{
                    10}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    10}['centerv']) && $styles{
                    10}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    10}['left']) && isset($styles{
                    10}['top']) && isset($styles{
                    10}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    10}['left'], $styles{
                    10}['top'], $styles{
                    10}['content'], '', isset($styles{
                    10}['color']) ? $styles{
                    10}['color'] : '', isset($styles{
                    10}['font-size']) ? $styles{
                    10}['font-size'] : '', $properties);
            }
            if (isset($styles{
                11}['show']) && $styles{
                11}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    11}['centerh']) && $styles{
                    11}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    11}['centerv']) && $styles{
                    11}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    11}['left']) && isset($styles{
                    11}['top']) && isset($styles{
                    11}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    11}['left'], $styles{
                    11}['top'], $styles{
                    11}['content'], '', isset($styles{
                    11}['color']) ? $styles{
                    11}['color'] : '', isset($styles{
                    11}['font-size']) ? $styles{
                    11}['font-size'] : '', $properties);
            }
            if (isset($styles{
                12}['show']) && $styles{
                12}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    12}['centerh']) && $styles{
                    12}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    12}['centerv']) && $styles{
                    12}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    12}['left']) && isset($styles{
                    12}['top']) && isset($styles{
                    12}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    12}['left'], $styles{
                    12}['top'], $styles{
                    12}['content'], '', isset($styles{
                    12}['color']) ? $styles{
                    12}['color'] : '', isset($styles{
                    12}['font-size']) ? $styles{
                    12}['font-size'] : '', $properties);
            }
            if (isset($styles{
                3}['show']) && $styles{
                3}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    3}['centerh']) && $styles{
                    3}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    3}['centerv']) && $styles{
                    3}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    3}['left']) && isset($styles{
                    3}['top']) && isset($styles{
                    3}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    3}['left'], $styles{
                    3}['top'], $styles{
                    3}['content'], '', isset($styles{
                    3}['color']) ? $styles{
                    3}['color'] : '', isset($styles{
                    3}['font-size']) ? $styles{
                    3}['font-size'] : '', $properties);
            }
            if (isset($styles{
                4}['show']) && $styles{
                4}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    4}['centerh']) && $styles{
                    4}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    4}['centerv']) && $styles{
                    4}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    4}['left']) && isset($styles{
                    4}['top']) && isset($styles{
                    4}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'image', $styles{
                    4}['left'], $styles{
                    4}['top'], $styles{
                    4}['content'], '', isset($styles{
                    4}['color']) ? $styles{
                    4}['color'] : '', isset($styles{
                    4}['font-size']) ? $styles{
                    4}['font-size'] : '', $properties);
            }
            if (isset($styles{
                5}['show']) && $styles{
                5}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    5}['centerh']) && $styles{
                    5}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    5}['centerv']) && $styles{
                    5}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    5}['left']) && isset($styles{
                    5}['top']) && isset($styles{
                    5}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    5}['left'], $styles{
                    5}['top'], $styles{
                    5}['content'], '', isset($styles{
                    5}['color']) ? $styles{
                    5}['color'] : '', isset($styles{
                    5}['font-size']) ? $styles{
                    5}['font-size'] : '', $properties);
            }
            if (isset($styles{
                6}['show']) && $styles{
                6}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                $styles{
                    6}['content'] = 'images/hallmark.png';
                if (isset($styles{
                    6}['centerh']) && $styles{
                    6}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    6}['centerv']) && $styles{
                    6}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    6}['left']) && isset($styles{
                    6}['top']) && isset($styles{
                    6}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'imagehall', $styles{
                    6}['left'], $styles{
                    6}['top'], $styles{
                    6}['content'], '', isset($styles{
                    6}['color']) ? $styles{
                    6}['color'] : '', isset($styles{
                    6}['font-size']) ? $styles{
                    6}['font-size'] : '', $properties);
            }
        }
        return $img->response('jpg');
    }
    function jsongeneratedirectapp($id, $res, $userid)
    {
        $user = User::where('id', $userid)->first();
        $customer = Customer::where('email', $user['username'])->first();
        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        // $name="testing.jpg";
        $image_path = '../../posterimages/' . $data['item']['ofile'];
        // $newimage_path='posterimages/test.jpg';
        $img = Image::make(public_path($image_path));
        $img->resize($res, $res);
        $width = $img->width();
        $height = $img->height();
        $posteritems = PosterItems::where('p_poster_id', $id)->orderBy('p_type_index', 'asc')->get();
        $styles = array();
        foreach ($posteritems as $key => $itme) {
            $index = $itme['p_type_index'];
            $styles[$index][$itme['p_style']] = $itme['p_style_value'];
            $styles[$index]['content'] = strip_tags($itme['p_content']);
            $styles[$index]['type'] = $itme['p_type'];
            $styles[$index]['id'] = $index;
            $styles[$index]['category'] = $data['item']['category'];
        }

        if ($posteritems->count() > 0) {
            if (isset($styles{
                0}['content'])) {
                $styles{
                    0}['content'] = date('jS M Y');
            }
            $jname = 'Zeyame Poster';
            $font = "arial.ttf";
            if (isset($customer->id)) {
                $user_lang = User::where('id', $customer->id)->first();
                $lang_type = Font::where('id', $user_lang['lang_id'])->first();
                $font = $lang_type['value'];
                $jname = $customer->name;
                $gold_rate = Goldrate::where('customerid', $customer->id)->OrderBy('id', 'desc')->first();
                if (isset($gold_rate->rate)) {
                    if (isset($styles{
                        1}['content'])) $styles{
                        1}['content'] = $gold_rate->rate;
                    if (isset($styles{
                        2}['content'])) $styles{
                        2}['content'] = $gold_rate->eightgram;
                    if (isset($styles{
                        8}['content'])) $styles{
                        8}['content'] = $gold_rate->silver_rate;
                    if (isset($styles{
                        9}['content'])) $styles{
                        9}['content'] = $gold_rate->nine_rate;
                    if (isset($styles{
                        10}['content'])) $styles{
                        10}['content'] = $gold_rate->eight_rate;
                    if (isset($styles{
                        11}['content'])) $styles{
                        11}['content'] = $gold_rate->seven_rate;
                    if (isset($styles{
                        12}['content'])) $styles{
                        12}['content'] = $gold_rate->silver_ornament_rate;
                } else {
                }
                if (isset($styles{
                    7}['content'])) {
                    $styles{
                        7}['content'] = $customer->address2;
                }
                if (isset($styles{
                    3}['content'])) {

                    // if(isset($styles{3}['category'])&&$styles{3}['category']==2){
                    $styles{
                        3}['content'] = $customer->address;

                    //}else{
                    //    $styles{3}['content'] = $customer->address.'|'.$customer->phone;
                    //}
                }
                if (isset($styles{
                    5}['content'])) {
                    $styles{
                        5}['content'] = $customer->phone;
                }
                if (isset($styles{
                    4}['content'])) {
                    $styles{
                        4}['content'] = '../../uploads/' . $customer->file;
                }
            }
            if (isset($styles{
                4}['content']) && $styles{
                4}['content'] == '') {
                $styles{
                    4}['content'] = 'images/ivlogo.png';
            }
            if (isset($styles{
                0}['show']) && $styles{
                0}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    0}['centerh']) && $styles{
                    0}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    0}['centerv']) && $styles{
                    0}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    0}['left']) && isset($styles{
                    0}['top']) && isset($styles{
                    0}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    0}['left'], $styles{
                    0}['top'], $styles{
                    0}['content'], '', isset($styles{
                    0}['color']) ? $styles{
                    0}['color'] : '', isset($styles{
                    0}['font-size']) ? $styles{
                    0}['font-size'] : '', $properties);
            }
            if (isset($styles{
                1}['show']) && $styles{
                1}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    1}['centerh']) && $styles{
                    1}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    1}['centerv']) && $styles{
                    1}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    1}['left']) && isset($styles{
                    1}['top']) && isset($styles{
                    1}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    1}['left'], $styles{
                    1}['top'], $styles{
                    1}['content'], '', isset($styles{
                    1}['color']) ? $styles{
                    1}['color'] : '', isset($styles{
                    1}['font-size']) ? $styles{
                    1}['font-size'] : '', $properties);
            }
            if (isset($styles{
                2}['show']) && $styles{
                2}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    2}['centerh']) && $styles{
                    2}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    2}['centerv']) && $styles{
                    2}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    2}['left']) && isset($styles{
                    2}['top']) && isset($styles{
                    2}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    2}['left'], $styles{
                    2}['top'], $styles{
                    2}['content'], '', isset($styles{
                    2}['color']) ? $styles{
                    2}['color'] : '', isset($styles{
                    2}['font-size']) ? $styles{
                    2}['font-size'] : '', $properties);
            }
            if (isset($styles{
                7}['show']) && $styles{
                7}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    7}['centerh']) && $styles{
                    7}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    7}['centerv']) && $styles{
                    7}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    7}['left']) && isset($styles{
                    7}['top']) && isset($styles{
                    7}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    7}['left'], $styles{
                    7}['top'], $styles{
                    7}['content'], '', isset($styles{
                    7}['color']) ? $styles{
                    7}['color'] : '', isset($styles{
                    7}['font-size']) ? $styles{
                    7}['font-size'] : '', $properties);
            }
            if (isset($styles{
                8}['show']) && $styles{
                8}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    8}['centerh']) && $styles{
                    8}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    8}['centerv']) && $styles{
                    8}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    8}['left']) && isset($styles{
                    8}['top']) && isset($styles{
                    8}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    8}['left'], $styles{
                    8}['top'], $styles{
                    8}['content'], '', isset($styles{
                    8}['color']) ? $styles{
                    8}['color'] : '', isset($styles{
                    8}['font-size']) ? $styles{
                    8}['font-size'] : '', $properties);
            }
            if (isset($styles{
                9}['show']) && $styles{
                9}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    9}['centerh']) && $styles{
                    9}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    9}['centerv']) && $styles{
                    9}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    9}['left']) && isset($styles{
                    9}['top']) && isset($styles{
                    9}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    9}['left'], $styles{
                    9}['top'], $styles{
                    9}['content'], '', isset($styles{
                    9}['color']) ? $styles{
                    9}['color'] : '', isset($styles{
                    9}['font-size']) ? $styles{
                    9}['font-size'] : '', $properties);
            }
            if (isset($styles{
                10}['show']) && $styles{
                10}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    10}['centerh']) && $styles{
                    10}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    10}['centerv']) && $styles{
                    10}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    10}['left']) && isset($styles{
                    10}['top']) && isset($styles{
                    10}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    10}['left'], $styles{
                    10}['top'], $styles{
                    10}['content'], '', isset($styles{
                    10}['color']) ? $styles{
                    10}['color'] : '', isset($styles{
                    10}['font-size']) ? $styles{
                    10}['font-size'] : '', $properties);
            }
            if (isset($styles{
                11}['show']) && $styles{
                11}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    11}['centerh']) && $styles{
                    11}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    11}['centerv']) && $styles{
                    11}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    11}['left']) && isset($styles{
                    11}['top']) && isset($styles{
                    11}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    11}['left'], $styles{
                    11}['top'], $styles{
                    11}['content'], '', isset($styles{
                    11}['color']) ? $styles{
                    11}['color'] : '', isset($styles{
                    11}['font-size']) ? $styles{
                    11}['font-size'] : '', $properties);
            }
            if (isset($styles{
                12}['show']) && $styles{
                12}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    12}['centerh']) && $styles{
                    12}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    12}['centerv']) && $styles{
                    12}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    12}['left']) && isset($styles{
                    12}['top']) && isset($styles{
                    12}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    12}['left'], $styles{
                    12}['top'], $styles{
                    12}['content'], '', isset($styles{
                    12}['color']) ? $styles{
                    12}['color'] : '', isset($styles{
                    12}['font-size']) ? $styles{
                    12}['font-size'] : '', $properties);
            }
            if (isset($styles{
                3}['show']) && $styles{
                3}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;

                if (isset($styles{
                    3}['centerh']) && $styles{
                    3}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    3}['centerv']) && $styles{
                    3}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    3}['left']) && isset($styles{
                    3}['top']) && isset($styles{
                    3}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    3}['left'], $styles{
                    3}['top'], $styles{
                    3}['content'], '', isset($styles{
                    3}['color']) ? $styles{
                    3}['color'] : '', isset($styles{
                    3}['font-size']) ? $styles{
                    3}['font-size'] : '', $properties);
            }
            if (isset($styles{
                4}['show']) && $styles{
                4}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    4}['centerh']) && $styles{
                    4}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    4}['centerv']) && $styles{
                    4}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    4}['left']) && isset($styles{
                    4}['top']) && isset($styles{
                    4}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'image', $styles{
                    4}['left'], $styles{
                    4}['top'], $styles{
                    4}['content'], '', isset($styles{
                    4}['color']) ? $styles{
                    4}['color'] : '', isset($styles{
                    4}['font-size']) ? $styles{
                    4}['font-size'] : '', $properties);
            }
            if (isset($styles{
                5}['show']) && $styles{
                5}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    5}['centerh']) && $styles{
                    5}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    5}['centerv']) && $styles{
                    5}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    5}['left']) && isset($styles{
                    5}['top']) && isset($styles{
                    5}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    5}['left'], $styles{
                    5}['top'], $styles{
                    5}['content'], '', isset($styles{
                    5}['color']) ? $styles{
                    5}['color'] : '', isset($styles{
                    5}['font-size']) ? $styles{
                    5}['font-size'] : '', $properties);
            }
            if (isset($styles{
                6}['show']) && $styles{
                6}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                $styles{
                    6}['content'] = 'images/hallmark.png';
                if (isset($styles{
                    6}['centerh']) && $styles{
                    6}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    6}['centerv']) && $styles{
                    6}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    6}['left']) && isset($styles{
                    6}['top']) && isset($styles{
                    6}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'imagehall', $styles{
                    6}['left'], $styles{
                    6}['top'], $styles{
                    6}['content'], '', isset($styles{
                    6}['color']) ? $styles{
                    6}['color'] : '', isset($styles{
                    6}['font-size']) ? $styles{
                    6}['font-size'] : '', $properties);
            }
        }
        return $img->response('jpg');
    }
    function jsongeneratedirectappedit($id, $res, $userid)
    {
        $user = User::where('id', $userid)->first();
        $customer = Customer::where('email', $user['username'])->first();
        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        // $name="testing.jpg";
        $image_path = '../../posterimages/' . $data['item']['ofile'];
        // $newimage_path='posterimages/test.jpg';
        $img = Image::make(public_path($image_path));
        $img->resize($res, $res);
        $width = $img->width();
        $height = $img->height();
        $posteritems = PosterItems::where('p_poster_id', $id)->orderBy('p_type_index', 'asc')->get();
        $styles = array();
        foreach ($posteritems as $key => $itme) {
            $index = $itme['p_type_index'];
            $styles[$index][$itme['p_style']] = $itme['p_style_value'];
            $styles[$index]['content'] = strip_tags($itme['p_content']);
            $styles[$index]['type'] = $itme['p_type'];
            $styles[$index]['id'] = $index;
            $styles[$index]['category'] = $data['item']['category'];
        }

        if ($posteritems->count() > 0) {
            if (isset($styles{
                0}['content'])) {
                $styles{
                    0}['content'] = date('jS M Y');
            }
            $jname = 'Zeyame Poster';
            $font = "arial.ttf";
            if (isset($customer->id)) {
                $user_lang = User::where('id', $customer->id)->first();
                $lang_type = Font::where('id', $user_lang['lang_id'])->first();
                $font = $lang_type['value'];
                $jname = $customer->name;
                $gold_rate = Goldrate::where('customerid', $customer->id)->OrderBy('id', 'desc')->first();
                if (isset($gold_rate->rate)) {
                    if (isset($styles{
                        1}['content'])) $styles{
                        1}['content'] = $gold_rate->rate;
                    if (isset($styles{
                        2}['content'])) $styles{
                        2}['content'] = $gold_rate->eightgram;
                    if (isset($styles{
                        8}['content'])) $styles{
                        8}['content'] = $gold_rate->silver_rate;
                    if (isset($styles{
                        9}['content'])) $styles{
                        9}['content'] = $gold_rate->nine_rate;
                    if (isset($styles{
                        10}['content'])) $styles{
                        10}['content'] = $gold_rate->eight_rate;
                    if (isset($styles{
                        11}['content'])) $styles{
                        11}['content'] = $gold_rate->seven_rate;
                    if (isset($styles{
                        12}['content'])) $styles{
                        12}['content'] = $gold_rate->silver_ornament_rate;
                } else {
                }
                if (isset($styles{
                    7}['content'])) {
                    $styles{
                        7}['content'] = $customer->address2;
                }
                if (isset($styles{
                    3}['content'])) {

                    // if(isset($styles{3}['category'])&&$styles{3}['category']==2){
                    $styles{
                        3}['content'] = $customer->address;

                    //}else{
                    //    $styles{3}['content'] = $customer->address.'|'.$customer->phone;
                    //}
                }
                if (isset($styles{
                    5}['content'])) {
                    $styles{
                        5}['content'] = $customer->phone;
                }
                if (isset($styles{
                    4}['content'])) {
                    $styles{
                        4}['content'] = '../../uploads/' . $customer->file;
                }
            }
            if (isset($styles{
                4}['content']) && $styles{
                4}['content'] == '') {
                $styles{
                    4}['content'] = 'images/ivlogo.png';
            }
            if (isset($styles{
                0}['show']) && $styles{
                0}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    0}['centerh']) && $styles{
                    0}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    0}['centerv']) && $styles{
                    0}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    0}['left']) && isset($styles{
                    0}['top']) && isset($styles{
                    0}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    0}['left'], $styles{
                    0}['top'], $styles{
                    0}['content'], '', isset($styles{
                    0}['color']) ? $styles{
                    0}['color'] : '', isset($styles{
                    0}['font-size']) ? $styles{
                    0}['font-size'] : '', $properties);
            }
            if (isset($styles{
                1}['show']) && $styles{
                1}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    1}['centerh']) && $styles{
                    1}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    1}['centerv']) && $styles{
                    1}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    1}['left']) && isset($styles{
                    1}['top']) && isset($styles{
                    1}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    1}['left'], $styles{
                    1}['top'], $styles{
                    1}['content'], '', isset($styles{
                    1}['color']) ? $styles{
                    1}['color'] : '', isset($styles{
                    1}['font-size']) ? $styles{
                    1}['font-size'] : '', $properties);
            }
            if (isset($styles{
                2}['show']) && $styles{
                2}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    2}['centerh']) && $styles{
                    2}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    2}['centerv']) && $styles{
                    2}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    2}['left']) && isset($styles{
                    2}['top']) && isset($styles{
                    2}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    2}['left'], $styles{
                    2}['top'], $styles{
                    2}['content'], '', isset($styles{
                    2}['color']) ? $styles{
                    2}['color'] : '', isset($styles{
                    2}['font-size']) ? $styles{
                    2}['font-size'] : '', $properties);
            }
            if (isset($styles{
                7}['show']) && $styles{
                7}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    7}['centerh']) && $styles{
                    7}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    7}['centerv']) && $styles{
                    7}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    7}['left']) && isset($styles{
                    7}['top']) && isset($styles{
                    7}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    7}['left'], $styles{
                    7}['top'], $styles{
                    7}['content'], '', isset($styles{
                    7}['color']) ? $styles{
                    7}['color'] : '', isset($styles{
                    7}['font-size']) ? $styles{
                    7}['font-size'] : '', $properties);
            }
            if (isset($styles{
                8}['show']) && $styles{
                8}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    8}['centerh']) && $styles{
                    8}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    8}['centerv']) && $styles{
                    8}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    8}['left']) && isset($styles{
                    8}['top']) && isset($styles{
                    8}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    8}['left'], $styles{
                    8}['top'], $styles{
                    8}['content'], '', isset($styles{
                    8}['color']) ? $styles{
                    8}['color'] : '', isset($styles{
                    8}['font-size']) ? $styles{
                    8}['font-size'] : '', $properties);
            }
            if (isset($styles{
                9}['show']) && $styles{
                9}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    9}['centerh']) && $styles{
                    9}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    9}['centerv']) && $styles{
                    9}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    9}['left']) && isset($styles{
                    9}['top']) && isset($styles{
                    9}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    9}['left'], $styles{
                    9}['top'], $styles{
                    9}['content'], '', isset($styles{
                    9}['color']) ? $styles{
                    9}['color'] : '', isset($styles{
                    9}['font-size']) ? $styles{
                    9}['font-size'] : '', $properties);
            }
            if (isset($styles{
                10}['show']) && $styles{
                10}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    10}['centerh']) && $styles{
                    10}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    10}['centerv']) && $styles{
                    10}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    10}['left']) && isset($styles{
                    10}['top']) && isset($styles{
                    10}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    10}['left'], $styles{
                    10}['top'], $styles{
                    10}['content'], '', isset($styles{
                    10}['color']) ? $styles{
                    10}['color'] : '', isset($styles{
                    10}['font-size']) ? $styles{
                    10}['font-size'] : '', $properties);
            }
            if (isset($styles{
                11}['show']) && $styles{
                11}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    11}['centerh']) && $styles{
                    11}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    11}['centerv']) && $styles{
                    11}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    11}['left']) && isset($styles{
                    11}['top']) && isset($styles{
                    11}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    11}['left'], $styles{
                    11}['top'], $styles{
                    11}['content'], '', isset($styles{
                    11}['color']) ? $styles{
                    11}['color'] : '', isset($styles{
                    11}['font-size']) ? $styles{
                    11}['font-size'] : '', $properties);
            }
            if (isset($styles{
                12}['show']) && $styles{
                12}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    12}['centerh']) && $styles{
                    12}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    12}['centerv']) && $styles{
                    12}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    12}['left']) && isset($styles{
                    12}['top']) && isset($styles{
                    12}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    12}['left'], $styles{
                    12}['top'], $styles{
                    12}['content'], '', isset($styles{
                    12}['color']) ? $styles{
                    12}['color'] : '', isset($styles{
                    12}['font-size']) ? $styles{
                    12}['font-size'] : '', $properties);
            }
            if (isset($styles{
                3}['show']) && $styles{
                3}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;

                if (isset($styles{
                    3}['centerh']) && $styles{
                    3}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    3}['centerv']) && $styles{
                    3}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    3}['left']) && isset($styles{
                    3}['top']) && isset($styles{
                    3}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    3}['left'], $styles{
                    3}['top'], $styles{
                    3}['content'], '', isset($styles{
                    3}['color']) ? $styles{
                    3}['color'] : '', isset($styles{
                    3}['font-size']) ? $styles{
                    3}['font-size'] : '', $properties);
            }
            // if(isset($styles{4}['show'])&&$styles{4}['show']=='show'){
            //     $properties=array();
            //     $properties['centerh']=false;
            //     $properties['centerv']=false;
            //     $properties['font']=$font;
            //     if(isset($styles{4}['centerh'])&&$styles{4}['centerh']=='centerh')$properties['centerh']=true;
            //     if(isset($styles{4}['centerv'])&&$styles{4}['centerv']=='centerv')$properties['centerv']=true;
            //     if(isset($styles{4}['left'])&&isset($styles{4}['top'])&&isset($styles{4}['content']))$img=$this->addItems($jname,$width,$height,$img,'image',$styles{4}['left'],$styles{4}['top'],$styles{4}['content'],'',isset($styles{4}['color'])?$styles{4}['color']:'',isset($styles{4}['font-size'])?$styles{4}['font-size']:'',$properties); 
            // }    
            if (isset($styles{
                5}['show']) && $styles{
                5}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    5}['centerh']) && $styles{
                    5}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    5}['centerv']) && $styles{
                    5}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    5}['left']) && isset($styles{
                    5}['top']) && isset($styles{
                    5}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    5}['left'], $styles{
                    5}['top'], $styles{
                    5}['content'], '', isset($styles{
                    5}['color']) ? $styles{
                    5}['color'] : '', isset($styles{
                    5}['font-size']) ? $styles{
                    5}['font-size'] : '', $properties);
            }
            if (isset($styles{
                6}['show']) && $styles{
                6}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                $styles{
                    6}['content'] = 'images/hallmark.png';
                if (isset($styles{
                    6}['centerh']) && $styles{
                    6}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    6}['centerv']) && $styles{
                    6}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    6}['left']) && isset($styles{
                    6}['top']) && isset($styles{
                    6}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'imagehall', $styles{
                    6}['left'], $styles{
                    6}['top'], $styles{
                    6}['content'], '', isset($styles{
                    6}['color']) ? $styles{
                    6}['color'] : '', isset($styles{
                    6}['font-size']) ? $styles{
                    6}['font-size'] : '', $properties);
            }
        }
        return $img->response('jpg');
    }
    function jsongeneratedirectappvideo($id, $res, $userid)
    {
        $user = User::where('id', $userid)->first();
        $customer = Customer::where('email', $user['username'])->first();
        $data = array();
        $data['item'] = Poster::find($id);
        $path = $data['item']['dfile'];
        // return $path;
        if (!Storage::disk('out')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('out')->get($path);
        return Storage::disk('out')->download($path);
        //$type = \File::mimeType($path);

        // $response = Response::make($file, 200);
        // $response->header("Content-Type", $type);
        // // $response->header("Accept-Ranges", 'bytes');
        //  //$response->header("Content-Length", 51265590);
        //  // $response->header("Content-Disposition" ,"attachment");  //Triggers Download

        // return $response;
    }
    function jsongeneratedirectdownload($id, $res, $userid)
    {
        $user = User::where('id', $userid)->first();
        $customer = Customer::where('email', $user['username'])->first();
        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        // $name="testing.jpg";
        $image_path = '../../posterimages/' . $data['item']['ofile'];
        // $newimage_path='posterimages/test.jpg';
        $img = Image::make(public_path($image_path));
        $img->resize($res, $res);
        $width = $img->width();
        $height = $img->height();
        $posteritems = PosterItems::where('p_poster_id', $id)->orderBy('p_type_index', 'asc')->get();
        $styles = array();
        foreach ($posteritems as $key => $itme) {
            $index = $itme['p_type_index'];
            $styles[$index][$itme['p_style']] = $itme['p_style_value'];
            $styles[$index]['content'] = strip_tags($itme['p_content']);
            $styles[$index]['type'] = $itme['p_type'];
            $styles[$index]['id'] = $index;
            $styles[$index]['category'] = $data['item']['category'];
        }

        if ($posteritems->count() > 0) {
            if (isset($styles{
                0}['content'])) {
                $styles{
                    0}['content'] = date('jS M Y');
            }
            $jname = 'Zeyame Poster';
            $font = "arial.ttf";
            if (isset($customer->id)) {
                $user_lang = User::where('id', $customer->id)->first();
                $lang_type = Font::where('id', $user_lang['lang_id'])->first();
                $font = $lang_type['value'];
                $jname = $customer->name;
                $gold_rate = Goldrate::where('customerid', $customer->id)->OrderBy('id', 'desc')->first();
                if (isset($gold_rate->rate)) {
                    if (isset($styles{
                        1}['content'])) $styles{
                        1}['content'] = $gold_rate->rate;
                    if (isset($styles{
                        2}['content'])) $styles{
                        2}['content'] = $gold_rate->eightgram;
                    if (isset($styles{
                        8}['content'])) $styles{
                        8}['content'] = $gold_rate->silver_rate;
                    if (isset($styles{
                        9}['content'])) $styles{
                        9}['content'] = $gold_rate->nine_rate;
                    if (isset($styles{
                        10}['content'])) $styles{
                        10}['content'] = $gold_rate->eight_rate;
                    if (isset($styles{
                        11}['content'])) $styles{
                        11}['content'] = $gold_rate->seven_rate;
                    if (isset($styles{
                        12}['content'])) $styles{
                        12}['content'] = $gold_rate->silver_ornament_rate;
                } else {
                }
                if (isset($styles{
                    7}['content'])) {
                    $styles{
                        7}['content'] = $customer->address2;
                }
                if (isset($styles{
                    3}['content'])) {
                    // if(isset($styles{3}['category'])&&$styles{3}['category']==2){
                    $styles{
                        3}['content'] = $customer->address;
                    //}else{
                    //    $styles{3}['content'] = $customer->address.'|'.$customer->phone;
                    //}
                }
                if (isset($styles{
                    5}['content'])) {
                    $styles{
                        5}['content'] = $customer->phone;
                }
                if (isset($styles{
                    4}['content'])) {
                    $styles{
                        4}['content'] = '../../uploads/' . $customer->file;
                }
            }
            if (isset($styles{
                4}['content']) && $styles{
                4}['content'] == '') {
                $styles{
                    4}['content'] = 'images/ivlogo.png';
            }
            if (isset($styles{
                0}['show']) && $styles{
                0}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    0}['centerh']) && $styles{
                    0}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    0}['centerv']) && $styles{
                    0}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    0}['left']) && isset($styles{
                    0}['top']) && isset($styles{
                    0}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    0}['left'], $styles{
                    0}['top'], $styles{
                    0}['content'], '', isset($styles{
                    0}['color']) ? $styles{
                    0}['color'] : '', isset($styles{
                    0}['font-size']) ? $styles{
                    0}['font-size'] : '', $properties);
            }
            if (isset($styles{
                1}['show']) && $styles{
                1}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    1}['centerh']) && $styles{
                    1}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    1}['centerv']) && $styles{
                    1}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    1}['left']) && isset($styles{
                    1}['top']) && isset($styles{
                    1}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    1}['left'], $styles{
                    1}['top'], $styles{
                    1}['content'], '', isset($styles{
                    1}['color']) ? $styles{
                    1}['color'] : '', isset($styles{
                    1}['font-size']) ? $styles{
                    1}['font-size'] : '', $properties);
            }
            if (isset($styles{
                2}['show']) && $styles{
                2}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    2}['centerh']) && $styles{
                    2}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    2}['centerv']) && $styles{
                    2}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    2}['left']) && isset($styles{
                    2}['top']) && isset($styles{
                    2}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    2}['left'], $styles{
                    2}['top'], $styles{
                    2}['content'], '', isset($styles{
                    2}['color']) ? $styles{
                    2}['color'] : '', isset($styles{
                    2}['font-size']) ? $styles{
                    2}['font-size'] : '', $properties);
            }
            if (isset($styles{
                7}['show']) && $styles{
                7}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    7}['centerh']) && $styles{
                    7}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    7}['centerv']) && $styles{
                    7}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    7}['left']) && isset($styles{
                    7}['top']) && isset($styles{
                    7}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    7}['left'], $styles{
                    7}['top'], $styles{
                    7}['content'], '', isset($styles{
                    7}['color']) ? $styles{
                    7}['color'] : '', isset($styles{
                    7}['font-size']) ? $styles{
                    7}['font-size'] : '', $properties);
            }
            if (isset($styles{
                8}['show']) && $styles{
                8}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    8}['centerh']) && $styles{
                    8}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    8}['centerv']) && $styles{
                    8}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    8}['left']) && isset($styles{
                    8}['top']) && isset($styles{
                    8}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    8}['left'], $styles{
                    8}['top'], $styles{
                    8}['content'], '', isset($styles{
                    8}['color']) ? $styles{
                    8}['color'] : '', isset($styles{
                    8}['font-size']) ? $styles{
                    8}['font-size'] : '', $properties);
            }
            if (isset($styles{
                9}['show']) && $styles{
                9}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    9}['centerh']) && $styles{
                    9}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    9}['centerv']) && $styles{
                    9}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    9}['left']) && isset($styles{
                    9}['top']) && isset($styles{
                    9}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    9}['left'], $styles{
                    9}['top'], $styles{
                    9}['content'], '', isset($styles{
                    9}['color']) ? $styles{
                    9}['color'] : '', isset($styles{
                    9}['font-size']) ? $styles{
                    9}['font-size'] : '', $properties);
            }
            if (isset($styles{
                10}['show']) && $styles{
                10}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    10}['centerh']) && $styles{
                    10}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    10}['centerv']) && $styles{
                    10}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    10}['left']) && isset($styles{
                    10}['top']) && isset($styles{
                    10}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    10}['left'], $styles{
                    10}['top'], $styles{
                    10}['content'], '', isset($styles{
                    10}['color']) ? $styles{
                    10}['color'] : '', isset($styles{
                    10}['font-size']) ? $styles{
                    10}['font-size'] : '', $properties);
            }
            if (isset($styles{
                11}['show']) && $styles{
                11}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    11}['centerh']) && $styles{
                    11}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    11}['centerv']) && $styles{
                    11}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    11}['left']) && isset($styles{
                    11}['top']) && isset($styles{
                    11}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    11}['left'], $styles{
                    11}['top'], $styles{
                    11}['content'], '', isset($styles{
                    11}['color']) ? $styles{
                    11}['color'] : '', isset($styles{
                    11}['font-size']) ? $styles{
                    11}['font-size'] : '', $properties);
            }
            if (isset($styles{
                12}['show']) && $styles{
                12}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                if (isset($styles{
                    12}['centerh']) && $styles{
                    12}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    12}['centerv']) && $styles{
                    12}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    12}['left']) && isset($styles{
                    12}['top']) && isset($styles{
                    12}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    12}['left'], $styles{
                    12}['top'], $styles{
                    12}['content'], '', isset($styles{
                    12}['color']) ? $styles{
                    12}['color'] : '', isset($styles{
                    12}['font-size']) ? $styles{
                    12}['font-size'] : '', $properties);
            }
            if (isset($styles{
                3}['show']) && $styles{
                3}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    3}['centerh']) && $styles{
                    3}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    3}['centerv']) && $styles{
                    3}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    3}['left']) && isset($styles{
                    3}['top']) && isset($styles{
                    3}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    3}['left'], $styles{
                    3}['top'], $styles{
                    3}['content'], '', isset($styles{
                    3}['color']) ? $styles{
                    3}['color'] : '', isset($styles{
                    3}['font-size']) ? $styles{
                    3}['font-size'] : '', $properties);
            }
            if (isset($styles{
                4}['show']) && $styles{
                4}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    4}['centerh']) && $styles{
                    4}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    4}['centerv']) && $styles{
                    4}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    4}['left']) && isset($styles{
                    4}['top']) && isset($styles{
                    4}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'image', $styles{
                    4}['left'], $styles{
                    4}['top'], $styles{
                    4}['content'], '', isset($styles{
                    4}['color']) ? $styles{
                    4}['color'] : '', isset($styles{
                    4}['font-size']) ? $styles{
                    4}['font-size'] : '', $properties);
            }
            if (isset($styles{
                5}['show']) && $styles{
                5}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                if (isset($styles{
                    5}['centerh']) && $styles{
                    5}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    5}['centerv']) && $styles{
                    5}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    5}['left']) && isset($styles{
                    5}['top']) && isset($styles{
                    5}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'text', $styles{
                    5}['left'], $styles{
                    5}['top'], $styles{
                    5}['content'], '', isset($styles{
                    5}['color']) ? $styles{
                    5}['color'] : '', isset($styles{
                    5}['font-size']) ? $styles{
                    5}['font-size'] : '', $properties);
            }
            if (isset($styles{
                6}['show']) && $styles{
                6}['show'] == 'show') {
                $properties = array();
                $properties['centerh'] = false;
                $properties['centerv'] = false;
                $properties['font'] = $font;
                $styles{
                    6}['content'] = 'images/hallmark.png';
                if (isset($styles{
                    6}['centerh']) && $styles{
                    6}['centerh'] == 'centerh') $properties['centerh'] = true;
                if (isset($styles{
                    6}['centerv']) && $styles{
                    6}['centerv'] == 'centerv') $properties['centerv'] = true;
                if (isset($styles{
                    6}['left']) && isset($styles{
                    6}['top']) && isset($styles{
                    6}['content'])) $img = $this->addItems($jname, $width, $height, $img, 'imagehall', $styles{
                    6}['left'], $styles{
                    6}['top'], $styles{
                    6}['content'], '', isset($styles{
                    6}['color']) ? $styles{
                    6}['color'] : '', isset($styles{
                    6}['font-size']) ? $styles{
                    6}['font-size'] : '', $properties);
            }
        }
        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename=' . $user->username,
        ];
        $img->encode('jpg');
        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename=' . $user->name . ".jpeg",
        ];
        return response()->stream(function () use ($img) {
            echo $img;
        }, 200, $headers);
    }
    function demo($id)
    {
        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        return view('generate', $data);
    }
    function editorsave(Request $request)
    {
        $data = array();
        $data['success'] = true;
        $data['id'] = $request->id;
        $data['style'] = json_decode($request->style);
        $data['content'] = json_decode($request->content);
        PosterItems::where('p_poster_id', $data['id'])->delete();
        foreach ($data['style'] as $key => $item) {

            if ($key == 4) {
                $this->itemadd($key, 'image', 'left', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'image', 'top', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'image', 'centerv', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'image', 'centerh', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'text', 'show', $item, $data['content'][$key], $data['id']);
            } else {
                $this->itemadd($key, 'text', 'left', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'text', 'top', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'text', 'color', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'text', 'font-size', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'text', 'centerv', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'text', 'centerh', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'text', 'show', $item, $data['content'][$key], $data['id']);
                $this->itemadd($key, 'text', 'font-family', $item, $data['content'][$key], $data['id']);
            }
        }
        return response($data, 200);
    }
    function itemadd($key, $main, $type, $style, $content, $pid)
    {
        $value = "";
        if ($type == 'color') {
            preg_match('/color=\"(.*?)\"/', $style, $matches);
            if (count($matches)) {
                $value = trim(str_replace('color=', '', $matches[0]));
                $value = trim(str_replace('"', '', $value));
            }
        }
        if ($type == 'left' || $type == 'top' || $type == 'font-size') {

            preg_match('/' . $type . ': [0-9]*/', $style, $matches);
            if (count($matches)) {
                $value = trim(str_replace($type . ': ', '', $matches[0]));
                if ($value == '') {
                    preg_match('/' . $type . ':  [0-9]*/', $style, $matches);
                    if (count($matches)) {
                        $value = trim(str_replace($type . ': ', '', $matches[0]));
                    }
                }
            }
        }
        if ($type == 'show') {
            preg_match('#\b(show)\b#', $style, $matches);
            if (count($matches)) {
                $value = $type;
            }
        }
        if ($type == 'centerv') {
            preg_match('#\b(centerv)\b#', $style, $matches);
            if (count($matches)) {
                $value = $type;
            }
        }
        if ($type == 'centerh') {
            preg_match('#\b(centerh)\b#', $style, $matches);
            if (count($matches)) {
                $value = $type;
            }
        }
        if ($type == 'font-family') {
            preg_match('#\bfont-family\s*:\s*([^;]+)#', $style, $matches);
            if (count($matches)) {
                $value = $matches[1];

                // Remove the comma and 'sans-serif'
                $value = str_replace([',', 'sans-serif'], '', $value);
            }
        }
        $index_value = $key;
        preg_match('/id_[0-9]*/', $style, $matches);
        if (count($matches)) {
            $index_value = trim(str_replace('id_', '', $matches[0]));
        }
        $poster_item = new PosterItems();
        $poster_item->p_type = $main;
        $poster_item->p_style = $type;
        $poster_item->p_style_value = $value;
        $poster_item->p_content = strip_tags($content);
        $poster_item->p_poster_id = $pid;
        $poster_item->p_type_index = $index_value;
        $poster_item->save();
        return;
    }
    function additems($jname, $width, $height, $img, $type, $x, $y, $content, $icon, $color, $fontsize, $properties)
    {
        //watermark
        $xx = ($width * 297) / 595;
        $GLOBALS['width'] = $width;
        $yy = ($height * 297) / 595;

        $GLOBALS['font'] = public_path('fonts/arial.ttf');
        if (isset($properties['font'])) {
            $GLOBALS['font'] = public_path('fonts/' . $properties['font']);
        }


        $img->text($jname, $xx, $yy, function ($font) {
            $font->file($GLOBALS['font']);
            $fontsize = ($GLOBALS['width'] * 30) / 595;
            $font->size($fontsize);
            // $font->weight(500);  
            $font->color(array(192, 192, 192, 0.1));
            $font->align('center');
            $font->valign('top');
            $font->angle(0);
        });

        if ($type == "text") {
            $x = ($width * intVal($x)) / 595;
            $y = ($height * intVal($y)) / 595;
            $flag_font = 'left';
            if ($properties['centerv']) {
                $y = $height / 2;
                $flag_font = 'center';
            }
            if ($properties['centerh']) {
                $x = $width / 2;
                $flag_font = 'center';
            }
            $GLOBALS['fontsize'] = $fontsize ? (($height * $fontsize) / 595) : (($height * 20) / 595);
            $GLOBALS['color'] = $color ? $color : '#000000';
            $GLOBALS['flag_font'] = $flag_font;
            $img->text($content, $x, $y, function ($font) {
                $font->file($GLOBALS['font']);
                $font->size($GLOBALS['fontsize']);
                //$font->weight(500);  
                $font->color($GLOBALS['color']);
                $font->align($GLOBALS['flag_font']);
                $font->valign('top');
                $font->angle(0);
            });
        }
        if ($type == "image") {
            $GLOBALS['content'] = $content;
            $flag_font = 'top-left';
            if ($x == '') $x = 0;
            if ($y == '') $y = 0;
            if ($properties['centerv']) {
                $y = $height / 2;
                $flag_font = 'center';
            }
            if ($properties['centerh']) {
                $x = $width / 2;
                $flag_font = 'center';
            }
            $GLOBALS['flag_font'] = $flag_font;
            $x = intval(($width * $x) / 595);
            $y = intval(($height * $y) / 595);
            if ($icon == '') {
                $icon = public_path($GLOBALS['content']);
                $logo = Image::make($icon);
                $iwidth = $logo->width();
                $iheight = $logo->height();

                if ($iwidth >= $iheight) {
                    $nwidth = 150;
                    $nheight = $nwidth * $iheight / $iwidth;
                    $nwidth = (150 - $nheight) + $nwidth;
                    $nheight = (150 - $nheight) + $nheight;
                    $nwidth = (150 - $nheight) + $nwidth;
                } else {
                    $nheight = 150;
                    $nwidth = $nheight * $iwidth / $iheight;
                    $nheight = (150 - $nwidth) + $nheight;
                    $nwidth = (150 - $nwidth) + $nwidth;
                }
                // $nwidth=(150-$nwidth)+$nwidth;
                // $nheight=(150-$nheight)+$nheight;
                $width = intval(($width * $nwidth) / 595);
                $height = intval(($height * $nheight) / 595);
                $logo->resize($width, $height);
            }
            $img->insert($logo, $GLOBALS['flag_font'], $x, $y);
        }
        if ($type == "imagehall") {
            $GLOBALS['content'] = $content;
            $flag_font = 'top-left';
            if ($x == '') $x = 0;
            if ($y == '') $y = 0;
            if ($properties['centerv']) {
                $y = $height / 2;
                $flag_font = 'center';
            }
            if ($properties['centerh']) {
                $x = $width / 2;
                $flag_font = 'center';
            }
            $GLOBALS['flag_font'] = $flag_font;
            $x = intval(($width * $x) / 595);
            $y = intval(($height * $y) / 595);
            if ($icon == '') {
                $icon = public_path($GLOBALS['content']);
                $logo = Image::make($icon);
                $iwidth = $logo->width();
                $iheight = $logo->height();

                if ($iwidth >= $iheight) {
                    $nwidth = 100;
                    $nheight = $nwidth * $iheight / $iwidth;
                    $nwidth = (100 - $nheight) + $nwidth;
                    $nheight = (100 - $nheight) + $nheight;
                    $nwidth = (100 - $nheight) + $nwidth;
                } else {
                    $nheight = 100;
                    $nwidth = $nheight * $iwidth / $iheight;
                    $nheight = (100 - $nwidth) + $nheight;
                    $nwidth = (100 - $nwidth) + $nwidth;
                }
                // $nwidth=(150-$nwidth)+$nwidth;
                // $nheight=(150-$nheight)+$nheight;
                $width = intval(($width * $nwidth) / 595);
                $height = intval(($height * $nheight) / 595);
                $logo->resize($width, $height);
            }
            $logo->opacity(10);
            $img->insert($logo, $GLOBALS['flag_font'], $x, $y);
        }

        return $img;
    }
    function jsondownload(Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $download_history = DownloadHistory::where('customer', $user['id']);
        if ($request->name != '') {
            $download_history->where('poster', $request->name);
        }
        $download_history = $download_history->paginate(20);
        $data['data'] = $download_history;
        $total = 0;
        $totaldb = Download::where('customerid', $user['id'])->first();
        if (isset($totaldb['downloads'])) {
            $total = $totaldb['downloads'];
        }
        $downloads = DownloadHistory::where('customer', $user['id'])->count();
        $remain = intval($total) - intval($downloads);
        $data['remain'] = $remain;
        return response($data, 200);
    }
    function jsoncatvtwo(Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $customer = Customer::where('email', $user['username'])->first();
        $usercat = explode(',', $customer->ecategorymultiple);
        $data = array();
        $cat = Category::where('cat_id', '0')->get();
        if (isset($request->cat_id) && $request->cat_id != '') {
            $cat = Category::where('cat_id', $request->cat_id)->get();
        }
        $data = array();
        foreach ($cat as $item) {
            if (in_array($item->id, $usercat)) {
                $id = $item->id;
                $postera = Poster::select('dfile as dfile', 'video', 'id', DB::raw("'' as name"), 'ofile as file', 'date', DB::raw("'poster' as type"), DB::raw("$id as catid"))->where('ecategorymultiple', 'like', '%,' . $id . ',%');
                $poster = category::select(DB::raw("'' as dfile"), DB::raw("0 as video"), 'id', 'name', 'file', 'date', DB::raw("'category' as type"), DB::raw("0 as catid"))->where('cat_id', '=', $id)->union($postera)->orderBy('id', 'desc')->paginate(40);
                $data[] = [
                    "id" => $item->id,
                    "name" => $item->name,
                    "file" => $item->file,
                    "date" => $item->date,
                    "values" => $poster,
                    "dfile" => $item->dfile,
                    "video" => $item->video,

                ];
            }
        }
        if (isset($request->cat_id) && $request->cat_id != '') {
            // if(count($data)==0){
            $item = Category::where('id', $request->cat_id)->first();
            $id = $item->id;
            $postera = Poster::select('dfile as dfile', 'video', 'id', DB::raw("'' as name"), 'ofile as file', 'date', DB::raw("'poster' as type"), DB::raw("$id as catid"))->where('ecategorymultiple', 'like', '%,' . $id . ',%');
            $poster = category::select(DB::raw("'' as dfile"), DB::raw("0 as video"), 'id', 'name', 'file', 'date', DB::raw("'category' as type"), DB::raw("0 as catid"))->where('cat_id', '=', $id)->union($postera)->orderBy('id', 'desc')->paginate(40);
            $data[] = [
                "id" => $item->id,
                "name" => $item->name,
                "file" => $item->file,
                "date" => $item->date,
                "values" => $poster,
                "dfile" => $item->dfile,
                "video" => $item->video,

            ];
            //}
        }

        if (count($data) == 0) {
            $data = ['message' => 'List is Empty'];
        }



        return response($data, 200);
    }
    function jsoncatvtwodet(Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $customer = Customer::where('email', $user['username'])->first();
        $usercat = explode(',', $customer->ecategorymultiple);
        $data = array();
        $cat = Category::where('cat_id', '0')->get();
        if (isset($request->cat_id) && $request->cat_id != '') {
            $cat = Category::where('cat_id', $request->cat_id)->get();
        }
        $data = array();

        if (isset($request->cat_id) && $request->cat_id != '') {
            // if(count($data)==0){
            $item = Category::where('id', $request->cat_id)->first();
            $id = $item->id;
            $postera = Poster::select('dfile as dfile', 'video', 'id', DB::raw("'' as name"), 'ofile as file', 'date', DB::raw("'poster' as type"))->where('ecategorymultiple', 'like', '%,' . $id . ',%')->orderBy('id', 'desc');
            $poster = category::select(DB::raw("'' as dfile"), DB::raw("0 as video"), 'id', 'name', 'file', 'date', DB::raw("'category' as type"))->where('cat_id', '=', $id)->orderBy('id', 'desc')->union($postera)->paginate(20);
            $data = [
                "id" => $item->id,
                "name" => $item->name,
                "file" => $item->file,
                "date" => $item->date,
                "values" => $poster,
                "dfile" => $item->dfile,
                "video" => $item->video,

            ];
            //}
        }

        if (count($data) == 0) {
            $data = ['message' => 'List is Empty'];
        }



        return response($data, 200);
    }

    function jsoncatvtwo7(Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $customer = Customer::where('email', $user['username'])->first();
        $usercat = explode(',', $customer->ecategorymultiple);
        $data = array();
        $cat = Category::where('cat_id', '0')->get();
        if (isset($request->cat_id) && $request->cat_id != '') {
            $cat = Category::where('cat_id', $request->cat_id)->get();
        }
        $data = array();
        foreach ($cat as $item) {
            if (in_array($item->id, $usercat)) {
                $id = $item->id;
                $postera = Poster::select('id', 'video', DB::raw("'' as name"), 'ofile as file', 'date', DB::raw("'poster' as type"), DB::raw("$id as catid"))->where('ecategorymultiple', 'like', '%,' . $id . ',%');
                $poster = category::select('id', DB::raw("0 as video"), 'name', 'file', 'date', DB::raw("'category' as type"), DB::raw("0 as catid"))->where('cat_id', '=', $id)->union($postera)->orderBy('id', 'desc')->paginate(40);
                $data[] = [
                    "id" => $item->id,
                    "name" => $item->name,
                    "file" => $item->file,
                    "date" => $item->date,
                    "values" => $poster,

                ];
            }
        }
        if (isset($request->cat_id) && $request->cat_id != '') {
            // if(count($data)==0){
            $item = Category::where('id', $request->cat_id)->first();
            $id = $item->id;
            $postera = Poster::select('id', 'video', DB::raw("'' as name"), 'ofile as file', 'date', DB::raw("'poster' as type"), DB::raw("$id as catid"))->where('ecategorymultiple', 'like', '%,' . $id . ',%');
            $poster = category::select('id', DB::raw("0 as video"), 'name', 'file', 'date', DB::raw("'category' as type"), DB::raw("0 as catid"))->where('cat_id', '=', $id)->union($postera)->orderBy('id', 'desc')->paginate(40);
            $data[] = [
                "id" => $item->id,
                "name" => $item->name,
                "file" => $item->file,
                "date" => $item->date,
                "values" => $poster,

            ];
            //}
        }

        if (count($data) == 0) {
            $data = ['message' => 'List is Empty'];
        }



        return response($data, 200);
    }
    function jsoncatvtwodet7(Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $customer = Customer::where('email', $user['username'])->first();
        $usercat = explode(',', $customer->ecategorymultiple);
        $data = array();
        $cat = Category::where('cat_id', '0')->get();
        if (isset($request->cat_id) && $request->cat_id != '') {
            $cat = Category::where('cat_id', $request->cat_id)->get();
        }
        $data = array();

        if (isset($request->cat_id) && $request->cat_id != '') {
            // if(count($data)==0){
            $item = Category::where('id', $request->cat_id)->first();
            $id = $item->id;
            $postera = Poster::select('id', DB::raw("'' as name"), 'ofile as file', 'date', DB::raw("'poster' as type"))->where('ecategorymultiple', 'like', '%,' . $id . ',%')->orderBy('id', 'desc');
            $poster = category::select('id', 'name', 'file', 'date', DB::raw("'category' as type"))->where('cat_id', '=', $id)->orderBy('id', 'desc')->union($postera)->paginate(20);
            $data = [
                "id" => $item->id,
                "name" => $item->name,
                "file" => $item->file,
                "date" => $item->date,
                "values" => $poster,

            ];
            //}
        }

        if (count($data) == 0) {
            $data = ['message' => 'List is Empty'];
        }



        return response($data, 200);
    }
    function ffmpeg(Request $request)
    {
        $data = array();
        $video = '../../videos/test.mp4';
        $image = '../../videos/test.png';
        $output = '../../videos/output.mp4';
        exec("ffmpeg -i " . $video . " -i " . $image . " -filter_complex overlay " . $output);
        $data['test'] = "done";
        return response($data, 200);
    }
    function jsongeneratebasevideo($id, $res, Request $request)
    {
        if ($request->username == '' && $request->password == '') return response(['success' => false, 'message' => 'Invalid'], 200);
        $user = User::where('username', $request->username)->where('password', $request->password)->first();
        if ($user === null) return response(['success' => false, 'message' => 'Invalid username and password!'], 200);
        $customer = Customer::where('email', $user['username'])->first();
        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        // $name="testing.jpg";
        $video = '../../posterimages/' . $data['item']['ofile'];
        $image = '../../uploads/' . $customer->file;
        $output = '../../posterimagestemp/' . $data['item']['ofile'];

        // $newimage_path='posterimages/test.jpg';
        exec("ffmpeg -i " . $video . " -i " . $image . " -filter_complex overlay " . $output);
        $data['success'] = true;

        return response(['data' => $data], 200);
    }
    function editorjson($id)
    {

        $data = array();
        $data['item'] = Poster::find($id);
        $data['id'] = $id;
        $posteritems = PosterItems::where('p_poster_id', $id)->orderBy('p_type_index', 'asc')->get();
        $data['styles'] = array();
        $data['flag'] = true;
        $index = 0;
        $data['styles'][0]['left'] = '12';
        $data['styles'][0]['top'] = '1';
        $data['styles'][0]['content'] = date('jS M Y');
        $data['styles'][0]['type'] = 'text';
        $data['styles'][0]['id'] = 0;

        $data['styles'][1]['left'] = '12';
        $data['styles'][1]['top'] = '21';
        $data['styles'][1]['content'] = '4,460';
        $data['styles'][1]['type'] = 'text';
        $data['styles'][1]['id'] = 1;

        $data['styles'][2]['left'] = '12';
        $data['styles'][2]['top'] = '41';
        $data['styles'][2]['content'] = '35,680';
        $data['styles'][2]['type'] = 'text';
        $data['styles'][2]['id'] = 2;

        $data['styles'][3]['left'] = '12';
        $data['styles'][3]['top'] = '61';
        $data['styles'][3]['content'] = 'Address';
        $data['styles'][3]['type'] = 'text';
        $data['styles'][3]['id'] = 3;

        $data['styles'][4]['left'] = '12';
        $data['styles'][4]['top'] = '81';
        $data['styles'][4]['content'] = '';
        $data['styles'][4]['type'] = 'image';
        $data['styles'][4]['id'] = 4;

        $data['styles'][5]['left'] = '12';
        $data['styles'][5]['top'] = '111';
        $data['styles'][5]['content'] = 'Number';
        $data['styles'][5]['type'] = 'text';
        $data['styles'][5]['id'] = 5;

        $data['styles'][6]['left'] = '12';
        $data['styles'][6]['top'] = '141';
        $data['styles'][6]['content'] = '';
        $data['styles'][6]['type'] = 'image';
        $data['styles'][6]['id'] = 6;

        $data['styles'][7]['left'] = '12';
        $data['styles'][7]['top'] = '81';
        $data['styles'][7]['content'] = 'Address2';
        $data['styles'][7]['type'] = 'text';
        $data['styles'][7]['id'] = 7;

        $data['styles'][8]['left'] = '12';
        $data['styles'][8]['top'] = '91';
        $data['styles'][8]['content'] = 'Silver';
        $data['styles'][8]['type'] = 'text';
        $data['styles'][8]['id'] = 8;

        $data['styles'][9]['left'] = '18';
        $data['styles'][9]['top'] = '101';
        $data['styles'][9]['content'] = '999 Rate';
        $data['styles'][9]['type'] = 'text';
        $data['styles'][9]['font-size'] = '16';
        $data['styles'][9]['id'] = 9;

        $data['styles'][10]['left'] = '18';
        $data['styles'][10]['top'] = '121';
        $data['styles'][10]['content'] = '84 Rate';
        $data['styles'][10]['type'] = 'text';
        $data['styles'][10]['font-size'] = '16';
        $data['styles'][10]['id'] = 10;

        $data['styles'][11]['left'] = '21';
        $data['styles'][11]['top'] = '131';
        $data['styles'][11]['content'] = '75 Rate';
        $data['styles'][11]['type'] = 'text';
        $data['styles'][11]['font-size'] = '16';
        $data['styles'][11]['id'] = 11;

        $data['styles'][12]['left'] = '21';
        $data['styles'][12]['top'] = '141';
        $data['styles'][12]['content'] = 'Sil.orn.Rate';
        $data['styles'][12]['type'] = 'text';
        $data['styles'][12]['font-size'] = '16';
        $data['styles'][12]['id'] = 12;

        $data['styles'][13]['left'] = '12';
        $data['styles'][13]['top'] = '81';
        $data['styles'][13]['content'] = '';
        $data['styles'][13]['type'] = 'image';
        $data['styles'][13]['id'] = 13;

        foreach ($posteritems as $key => $itme) {
            $index = $itme['p_type_index'];
            $data['styles'][$index][$itme['p_style']] = $itme['p_style_value'];
            $data['styles'][$index]['content'] = strip_tags($itme['p_content']);
            // $data['styles'][$index]['type']=$itme['p_type'];
            $data['styles'][$index]['id'] = $index;
        }
        $data['styles'][0]['content'] = date('jS M Y');
        $data['width'] = '605';
        $data['height'] = '605';

        $image_path = '../../posterimages/' . $data['item']['ofile'];
        // $newimage_path='posterimages/test.jpg';
        $img = Image::make(public_path($image_path));
        $data['original_width'] = $img->width();
        $data['original_height'] = $img->height();

        // $new_height=605;
        // $scale_factor = $new_height / $original_height;
        // $new_width = (int)($original_width * $scale_factor);

        //  $data['width']=$new_width."px";

        if (count($data['styles']) == 0) {
            $data['flag'] = false;
        }

        return response(['data' => $data], 200);
    }
}
