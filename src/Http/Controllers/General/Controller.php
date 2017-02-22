<?php
/**
 * Copyright (C) Loopeer, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential.
 *
 * User: DengYongBin
 * Date: 15/12/15
 * Time: 下午5:54
 */

namespace Loopeer\QuickCms\Http\Controllers\General;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Loopeer\QuickCms\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    protected $model;

    public function __construct() {
        try {
            $routePath = preg_replace('/(admin\/)|(\/create)|(\/search)|(\/edit)|(\/changeStatus)|(\/detail)|\/{(?!custom_id).*?}/', '',
                Route::getCurrentRoute()->getPath());
            $routePath = str_replace('{custom_id}', Route::getCurrentRoute()->parameter('custom_id'), $routePath);

            if (is_null(Route::getCurrentRoute()->getName())) {
                $routePath = preg_replace('/(\/\d*\/)|(\/)/', '.', $routePath);
            } else {
                $routePath = preg_replace('/(admin.)|(.\w*$)/', '', Route::getCurrentRoute()->getName());
            }
            $reflectionClass = new \ReflectionClass(config('quickCms.general_model_class.' . $routePath));
            $this->model = $reflectionClass->newInstance();
            $this->model->routeName = $routePath;
        } catch (Exception $e) {
            \Log::info($e->getMessage());
        }
        parent::__construct();
    }

    public function search()
    {
        return response()->json(self::generalQuery($this->model));
    }

    public function index()
    {
        $model = $this->model;
        return view('backend::general.index', compact('model'));
    }

    public function store()
    {
        $data = Input::all();
        $model = $this->model;
        if ($data['id']) {
            $model::find($data['id'])->update($data);
        } else {
            $model::create($data);
        }
        return redirect()->to('admin/' . $model->routeName);
    }

    public function create()
    {
        $model = $this->model;
        $data = new $this->model;
        return view('backend::general.create', compact('model', 'data'));
    }

    public function edit($id)
    {
        $model = $this->model;
        $data = $model::find($id);
        return view('backend::general.create', compact('model', 'data'));
    }

    public function destroy($id)
    {
        $model = $this->model;
        return response()->json($model::destroy($id));
    }

    public function show($id)
    {
        $model = $this->model;
        $data = $model::find($id);
        return view('backend::general.detail', compact('model', 'data'));
    }

    public function change($id)
    {
        $model = $this->model;
        $data = $model::find($id);
        $param = Input::all();
        foreach ($param as $key => $value) {
            switch($value) {
                case 'now':
                    $value = Carbon::now();
                    break;
                case 'admin':
                    $value = Auth::admin()->get()->email;
                    break;
                default:
                    break;
            }
            $data->$key = $value;
        }
        return response()->json($data->save());
    }
}