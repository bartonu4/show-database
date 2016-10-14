@extends('app')
@section('content')
<div class="ui page grid">
@if(\Auth::check())
<div class="ui centered row">
<div class="ui nine wide column">
  <div class="ui segment">
<div class="ui list">
  <div class="item">

    <div class="content">
      <div class="header">Просмотренные аниме</div>
@if($ch1==0)
<div class="ui green message">
Добавьте аниме
</div>
@else
      <div class="list">
      @for($i=0;$i<$n;$i++)
      @if(${'choose'.$i}==1)
        <div class="item">
        <form action={{URL::route('del')}} method="post">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" name="name" value="{{ ${'name'.$i} }}">
          <input type="hidden" name="type" value="{{ ${'type'.$i} }}">
          <input type="hidden" name="part" value="{{ ${'part'.$i} }}">
            <input type="hidden" name="choose" value="{{ ${'choose'.$i} }}">
        <button type="submit" class="right floated compact red close ui button">delete</button>
        </form>
         <img class="ui tiny image" src="{{ ${'img'.$i}  }}">
          <div class="content">
            <a class="header" href={{URL::route('anime',['name'=> ${'name'.$i} ,'type'=>${'type'.$i},'part'=>${'part'.$i}])}}>
            {{{ ${'name'.$i} }}}
            </a>
            <div class="description">
            Тип:{{ ${'type'.$i} }}-{{ ${'part'.$i} }}

            </div>
          </div>
        </div>
         <div class="ui divider"></div>
         @endif


@endfor
      </div>
        @endif
    </div>
  </div>
  <div class="item">

    <div class="content">
      <div class="header">Посмотреть</div>
@if($ch0==0)
<div class="ui green message">
Добавьте аниме
</div>
@else
      <div class="list">

      @for($i=0;$i<$n;$i++)




      @if(${'choose'.$i}==0)

        <div class="item">
            <form action={{URL::route('del')}} method="post">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="name" value="{{ ${'name'.$i} }}">
                  <input type="hidden" name="type" value="{{ ${'type'.$i} }}">
                  <input type="hidden" name="part" value="{{ ${'part'.$i} }}">
                  <input type="hidden" name="choose" value="{{ ${'choose'.$i} }}">
                <button type="submit" class="right floated compact red close ui button">delete</button>
                </form>

         <img class="ui tiny image" src="{{ ${'img'.$i}  }}">
          <div class="content">
            <a class="header" href={{URL::route('anime',['name'=> ${'name'.$i} ,'type'=>${'type'.$i},'part'=>${'part'.$i}])}}>
            {{{ ${'name'.$i} }}} {{ ${'type'.$i} }}-{{ ${'part'.$i} }}
            </a>
            <div class="description">Тип:{{ ${'type'.$i} }}-{{ ${'part'.$i} }}</div>
          </div>
        </div>
        <div class="ui divider"></div>
        @endif

@endfor
      </div>
          @endif
    </div>
  </div>

 <div class="item">

    <div class="content">


      <div class="header">Оценки</div>

      <div class="list">

      @for($i=0;$i<$n_v;$i++)






        <div class="item">
        <div class="right floated compact ui segment"><div class="ui prof rating" data-rating="{{  ${'vote'.$i    } }}"></div></div>
          <img class="ui tiny image" src="{{ ${'img_'.$i}  }}">

          <div class="content">
            <a class="header" href={{URL::route('anime',['name'=> ${'name_'.$i} ,'type'=>${'type_'.$i},'part'=>${'part_'.$i}])}}>
            {{{ ${'name_'.$i} }}}
            </a>
            <div class="description">
            Тип:{{ ${'type_'.$i} }}-{{ ${'part_'.$i} }}

            </div>
          </div>
        </div>
        <div class="ui divider"></div>

@endfor
      </div>

    </div>
  </div>

  </div>
</div>
@endif
</div>
</div>
</div>
@endsection