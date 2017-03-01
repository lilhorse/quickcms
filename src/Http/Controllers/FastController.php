<?php
/**
 * Copyright (C) Loopeer, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential.
 *
 * User: DengYongBin
 * Date: 17/02/15
 * Time: 下午5:54
 */

namespace Loopeer\QuickCms\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class FastController extends BaseController
{

    public function search(Model $model)
    {
        return response()->json(self::generalQuery($model));
    }

    public function index(Model $model)
    {
        return view('backend::general.index', compact('model'));
    }

    public function create(Model $model)
    {
        $data = new $model;
        return view('backend::general.create', compact('model', 'data'));
    }

    public function store(Model $model = null)
    {
        $data = Input::all();
        $data['id'] ? $model::find($data['id'])->update($data) : $model::create($data);
        return redirect()->to('admin/' . $model->route);
    }

    public function show(Model $model, $id)
    {
        $data = $model::find($id);
        return view('backend::general.detail', compact('model', 'data'));
    }

    public function edit(Model $model, $id)
    {
        $data = $model::find($id);
        return view('backend::general.create', compact('model', 'data'));
    }

    public function update(Model $model, $id)
    {
        $param = Input::all();
        foreach ($param as $key => $value) {
            switch($value) {
                case 'now':
                    $param[$key] = Carbon::now();
                    break;
                case 'admin':
                    $param[$key] = Auth::admin()->get()->email;
                    break;
                default:
                    break;
            }
        }
        return response()->json($model::find($id)->update($param));
    }

    public function destroy(Model $model, $id)
    {
        return response()->json($model::destroy($id));
    }

}