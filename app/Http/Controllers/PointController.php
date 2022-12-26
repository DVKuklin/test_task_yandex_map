<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PointController extends Controller
{
    public function createPoint(Request $request) {
        $point = $request->validate([
            'name' => [
                        'required',
                        //Существует ли точка с таким именем у данного пользователя
                        Rule::unique('points')->where(function ($query) {
                            return $query->where('user_id', Auth::id());
                        }),
                    ],
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ],[
            'name.required' => 'Поле Имя является обязательным',
            'name.unique' => 'Точка с таким именем уже существует',
            'latitude.required' => 'Поле Широта является обязательным',
            'latitude.numeric' => 'Значение широты должно быть числом',
            'longitude.required' => 'Поле Долгота является обязательным',
            'longitude.numeric' => 'Значение Долготы должно быть числом',
        ]);


        try{
            Point::create([
                'name' => $point["name"],
                'latitude' => $point["latitude"],
                'longitude' => $point["longitude"],
                'user_id' => Auth::id()
            ]);

            return redirect()->route('page.home')->with('success', 'Точка успешно создана.');

        } catch(Exception $e){
            return redirect()->route('page.home')->withErrors(['Что то пошло не так, точка не создана.']);
        }
    }

    public function updatePoint(Request $request) {
        $point = $request->validate([
            'point_id' => [
                            'required',
                            'integer',
                            //Принадлежит ли точка пользователю
                            Rule::exists('points','id')->where(function ($query) {
                                return $query->where('user_id', Auth::id());
                            })
                        ],
            'name' => [
                        'required',
                        //Существует ли точка с таким именем у данного пользователя
                        Rule::unique('points')->where(function ($query) {
                            return $query->where('user_id', Auth::id());
                        })->ignore($request->point_id),
                      ],
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ],[
            'point_id.required' => 'Что то не так, перезагрузите страницу 1',
            'point_id.integer' => 'Что то не так, перезагрузите страницу 2',
            'point_id.exists' => 'Что то не так, перезагрузите страницу 3',
            'name.required' => 'Поле Имя является обязательным',
            'name.unique' => 'Точка с таким именем уже существует',
            'latitude.required' => 'Поле Широта является обязательным',
            'latitude.numeric' => 'Значение широты должно быть числом',
            'longitude.required' => 'Поле Долгота является обязательным',
            'longitude.numeric' => 'Значение Долготы должно быть числом',
        ]);

        try {
            Point::where('id',$point["point_id"])
                        ->update([
                            'name'=>$point["name"],
                            'latitude'=>$point["latitude"],
                            'longitude'=>$point["longitude"]
                        ]);

            return back()->with('success','Точка успешно изменена.');
            
        } catch(Exception $e)  {
            return back()->withErrors(['Что то пошло не так, точка не изменена.']);
        }

    }

    public function deletePoint(Request $request) {
        $point = $request->validate([
            'point_id' => [
                'required',
                'integer',
                //Принадлежит ли точка пользователю
                Rule::exists('points','id')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })
            ],
        ],[
            'point_id.required' => 'Что то не так, перезагрузите страницу',
            'point_id.integer' => 'Что то не так, перезагрузите страницу',
            'point_id.exists' => 'Что то не так, перезагрузите страницу'
        ]);

        try {
            Point::where('id',$point["point_id"])
                        ->delete();

            return back()->with('success','Точка успешно удалена.');
            
        } catch(Exception $e)  {
            return back()->withErrors(['Что то пошло не так.']);
        }
    }
}
