@extends('site.layouts.account')

@section('title', 'Портфолио')

@section('header')
    @include('site.layouts.partials.headers.default')
@endsection

@section('css')
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
  <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@endsection

@section('account.title.h1', 'Портфолио')

@section('account.content')

<section class="box-admin edit-profile">
  <div class="card-body">


   @if (count($errors) > 0)
       <div class="alert alert-danger">

           <ul>
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   @endif
   </div>
  <div class="header-box-admin">
      <h3>{{ __('Добавить изображения') }}</h3>
  </div>
  <div class="body-box-admin p-0">

    <form action="{{ route('site.account.portfolio.save') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-row align-items-center ml-3">
        <div class="col-sm-3 my-1">
            <input type="text" class="form-control" name="project_name" placeholder="Введите название проекта">
        </div>
        <div class="col-sm-3 my-1">
            <input type="file" class="form-control-file" name="filename" id="file">
        </div>
        <div class="col-sm-3 my-1">
            <input type="text" class="form-control" name="project_link" placeholder="Ссылка на проект">
        </div>
        <div class="col-3 my-1" style="text-align:left">
            <button type="submit" class="btn btn-success">{{ __('Добавить') }}</button>
        </div>
      </div>
    </form>

    <div class="intro-profile pt-5">
      <div class="header-box-admin">
          <h3>{{ __('Добавленные изображения проектов') }}</h3>
      </div>
      <div class="candidate-box">
        <div class="item-list">
          <div class="table-responsive m-1 p-1">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td>{{ __('Название проекта') }}</td>
                    <td>{{ __('Изображение') }}</td>
                    <td>{{ __('Ссылка') }}</td>
                </thead>

                <tbody>
                @foreach($data as $row)
                @if($row)
                  <tr>
                    <td>{{ $row->project_name}}</td>
                    <td>
                      <a data-fancybox="gallery" href="{{ asset('images/portfolio/portfolio_contractor/'.$row->filename) }}">
                          <img class="img-fluid" src="{{ asset('images/portfolio/portfolio_contractor/'.$row->filename) }}" style="height:120px; width:200px"/>
                      </a>
                    </td>
                    @if($row->link)
                      <td>
                        <a href="{{ $row->link }}">{{ __('Перейти на проект') }}</a>
                      </td>
                    @else
                      <td>{{ __('Ссылка не указана исполнителем') }}</td>
                    @endif
                  </tr>
                @endif
                @endforeach
                </tbody>


              </table>
          </div>
        </div>
      </div>
    </div>
  </div>


</section>
@endsection
