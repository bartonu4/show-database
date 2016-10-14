@extends('app')

@section('content')
<div class="ui page grid">
<div class="row"></div><div class="centered row"><div class="h3">Рейтинг аниме</div></div><div class="row"></div><div class="row"></div>
<div class="twelve wide centered column"><div class="ui segment">

                       <table class="ui table">
                       <thead>
                       <tr>
                       <th>
                       Наименование
                       </th>
                       <th>Часть</th>
                       <th>Количество голосов</th>
                       <th>Средний бал</th>
                       <th>Рейтинг</th>
                       </tr>
                       </thead>
                       <tbody>
@for($i=0;$i<$num;$i++)
<tr>
<td><a href={{URL::route('anime',['name'=> ${'name'.$i} ,'type'=>${'type'.$i},'part'=>${'part'.$i}])}}>{{{ ${'name'.$i} }}}</a></td>
<td>{{{ ${'type'.$i}.'-'.${'part'.$i}  }}}</td>
<td>{{{ ${'vote'.$i} }}}</td>
<td>{{{ ${'rating'.$i} }}}</td>
<td>{{{ ${'bayes'.$i} }}}</td>




</tr>
@endfor
                       </tbody>
                       </table>

                       </div></div>


</div>
@endsection
