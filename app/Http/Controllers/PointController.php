<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function createPoint(Request $request) {
        $point = $request->validate([
            'name' => 'required|unique:App\Models\Point,name',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ],[
            'name.required' => 'Поле Имя является обязательным',
            'name.unique' => 'Точка с таким имененм уже существует',
            'latitude.required' => 'Поле Широта является обязательным',
            'latitude.numeric' => 'Значение широты должно быть числом',
            'longitude.required' => 'Поле Долгота является обязательным',
            'longitude.numeric' => 'Значение Долготы должно быть числом',
        ]);

        $user_id = Auth::id();
 
        try{
            $res = Point::create([
                'name' => $point["name"],
                'latitude' => $point["latitude"],
                'longitude' => $point["longitude"],
                'user_id' => $user_id
            ]);

            if ($res) {
                return redirect()->route('page.home')->with('success', 'Точка успешно создана.');
            } else {
                return redirect()->route('page.home')->withErrors(['Что то пошло не так, точка не создана.']);
            }


        } catch(Exception $e){
            return redirect()->route('page.home')->withErrors(['Что то пошло не так, точка не создана.']);
        }

    }

    static function getPoints() {
        $user_id = Auth::id();

        $points = Point::where('user_id',$user_id)
                        ->select('id','name','latitude','longitude')
                        ->orderBy('created_at','desc')
                        ->get();

        return $points;
    }

    public function updatePoint(Request $request) {
        $point = $request->validate([
            'point_id' => 'required|integer',
            'name' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ],[
            'point_id.required' => 'Что то не так, перезагрузите страницу',
            'point_id.integer' => 'Что то не так, перезагрузите страницу',
            'name.required' => 'Поле Имя является обязательным',
            'latitude.required' => 'Поле Широта является обязательным',
            'latitude.numeric' => 'Значение широты должно быть числом',
            'longitude.required' => 'Поле Долгота является обязательным',
            'longitude.numeric' => 'Значение Долготы должно быть числом',
        ]);

        // Проверяем есть ли другая точка с таким именем
        $pointWithSameName = Point::where('name',$point["name"])
                                  ->where('user_id',Auth::id())
                                  ->where('id','!=',$point["point_id"])
                                  ->first();

        if ($pointWithSameName) {
            return back()->withErrors(['Точка с таким именем уже существует.']);
        } else {
            try {
                $res = Point::where('id',$point["point_id"])
                            ->update([
                                'name'=>$point["name"],
                                'latitude'=>$point["latitude"],
                                'longitude'=>$point["longitude"]
                            ]);
                if ($res) {
                    return back()->with('success','Точка успешно изменена.');
                } else {
                    return back()->withErrors(['Что то пошло не так, точка не изменена.']);
                }
                
            } catch(Exeption $e)  {
                return back()->withErrors(['Что то пошло не так, точка не изменена.']);
            }
        }


    }

    public function deletePoint(Request $request) {
        $point = $request->validate([
            'point_id' => 'required|integer',
        ],[
            'point_id.required' => 'Что то не так, перезагрузите страницу',
            'point_id.integer' => 'Что то не так, перезагрузите страницу',
        ]);

        try {
            $res = Point::where('id',$point["point_id"])
                        ->delete();

            if ($res) {
                return back()->with('success','Точка успешно удалена.');
            } else {
                return back()->withErrors(['Что то пошло не так, точка не удалена.']);
            }
            
        } catch(Exeption $e)  {
            return back()->withErrors(['Что то пошло не так.']);
        }

    }
}
