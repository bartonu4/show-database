@extends('app')

@section('content')

<div class="ui page grid">

<div class="row"></div><div class="centered row"><h3>{{$name}}</h3></div><div class="row"></div>
<div class="centered row">
<div class="four wide column">
<div class="column">

<div class="ui card">
 <div class="image">
  <img src={{$image}}> </div>
  <div class="content">

   </div>
    @if(\Auth::check()) <div class="content extra">Голосование:<div class="ui rating" data-rating="{{$vote}}" data-token="{{csrf_token()}}">
    <input type="hidden" value="{{$name}}" name="anime">
    <input type="hidden" value="{{$part}}" name="part">
    <input type="hidden" value="{{$type}}" name="type">
    </div>
     </div>
     @else
     <div class="content extra">
     Голосование:
     <div class="ui red message">
     Авторизируйтесь, чтобы проголосовать
     </div>
     </div>
     @endif
      </div>
     </div>

 </div>
      <div class="five wide column">
      <div class="ui segment">

      <div class="ui divided list">
      <div class="item"><div class="content"><div class="header">Жанр:</div><div class="description">{{$genre}}</div></div></div>
      <div class="item"><div class="content"><div class="header">Тип:</div><div class="description">@if($epcount>0){{$type}}-{{$part}} ({{$epcount}} эп.)@else {{$type}} @endif</div></div></div>
      <div class="item"><div class="content"><div class="header">Cтудия:</div><div class="description">{{$studio}}</div></div></div>
      <div class="item"><div class="content"><div class="header">Снято по:</div><div class="description">{{$origins}}</div></div></div>
      </div>

      <div class="ui green list">

      <div class="item"><div class="content"><div class="header">Место в рейтинге:</div><div class="description">{{$position}}</div></div></div>
      <div class="item"><div class="content"><div class="header">Кол. голосов:</div><div class="description">{{$votes}}</div></div></div>
      </div>


</div>
<div class="ui segment" id="bookmark">
@if(\Auth::check())
<input type="hidden" value="{{$name}}" name="nu4">

      <button class="ui labeled blue button" onclick="submitForm()">Добавить в</button>
<div class="ui selection floated dropdown">
    <input type="hidden" name="gender">

    <div class="default text">Список</div>
    <i class="dropdown icon"></i>
    <div class="menu">
      <div class="item" data-value="1">Просмотренные</div>
      <div class="item" data-value="0">Посмотреть</div>
    </div>
  </div>

     @if($bookmark==1)

 <div class="ui green message" >
 Добавлено в Просмотренные
 </div>
 @elseif($bookmark==0)
  <div class="ui green message">
  Добавлено в Посмотреть
  </div>

  @endif
  @else
 <div class="ui red message">
     Авторизируйтесь, чтобы добавить в списки
     </div>
@endif
      </div>
      </div>



</div>
<div class="two wide centered row">
<div class="nine wide column">
<div class="ui segment">
{{$description}}
</div></div></div>
<div class="four wide centered row">
<div class="nine wide column">
<div class="ui segment comments">
<h3 class="ui dividing header">Комментарии</h3>
@for( $i=0;$i<$comment_num;$i++)

  <div class="comment">
    <a class="avatar">
         <img src="/images/matt.jpg" style="height: 30px">
       </a>
    <div class="content">
      <a class="author">  {{ ${'name_'.$i} }}</a>

      <div class="text">
       {{ ${'comment_'.$i} }}
      </div>
      <div class="actions">
        <a class="reply active">Reply</a>
      </div>

    </div>
  </div>
  @endfor
  <form class="ui reply form" method="post" action="{{route('addcom')}}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="name" value="{{ $name }}">
  <input type="hidden" name="type" value="{{ $type }}">
  <input type="hidden" name="part" value="{{ $part }}">
      <div class="field">

        <textarea name="comment"></textarea>
      </div>
      @if(\Auth::check())
      <button type="submit" class="ui blue labeled submit icon button">
        <i class="icon edit"></i> Add Reply
      </button>
      @else
<div class="ui red message">
     Авторизируйтесь, чтобы добавить в оставить комментарий
     </div>
      @endif
    </form>

</div>

</div>

</div>


</div>



@endsection