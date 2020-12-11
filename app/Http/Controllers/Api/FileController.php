<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use App\Document;
use App\Models\FormMultipleUpload;
use App\Models\PortfolioLink;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class FileController extends Controller
{
  public function index()
  {
        $user = auth()->user();

        $accountPage = 'tenders';
        $user_id = $user->id;
        $data = FormMultipleUpload::where('user_id', $user_id)->get();
      return response()->json([
          'data'=>$data,
          'user'=>$user,
          'accountPage'=>$accountPage
      ]);

  }





  public function save(Request $request){

        $user = auth()->user();
        $validationMessages = [
            'project_link' => 'Неверный формат ссылки: попробуйте добавить https:// или http://. Пример: https://example.uz',
            'project_name'=>'Введите название проекта',
            'filename.*' => 'Файл должен быть картинкой',

        ];

        $validatedData = Validator::make($request->all(), [
          'project_link' => 'regex:#(http[s]?):\/\/#',
          'project_name' => 'required',
          'filename' => 'required',
          'filename.*' => 'image|max:4098',
      ], $validationMessages)->validate();

      if($request->hasFile('filename')){
            $image = $request->file('filename');
            $name = $image->getClientOriginalName();
            $image->move(public_path().'/images/portfolio/portfolio_contractor', $name);
      }
      $upload_model = new FormMultipleUpload;
      $upload_model -> project_name = $request -> project_name;
      $upload_model -> filename = $name;
      $upload_model -> user_id = $user->id;
      $upload_model -> link = $request->project_link;
      $upload_model -> slug = $user->slug;
      $upload_model->save();
      return response()->json([
          'success'=>'Файл успешно добавлен',

      ]);

  }


  }
