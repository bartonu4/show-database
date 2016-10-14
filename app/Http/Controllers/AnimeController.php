<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class AnimeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//

        $results = DB::select('select anime.name,anime.type,anime.part,votes,round(rating,3) as rating,round(bayes,3) as bayes from anime JOIN  votes ON anime.name = votes.name
and anime.part=votes.part and anime.type=votes.type order by bayes DESC ');

        for( $i=0; $i<count($results);$i++)
        {
            $text['name'.$i]= $results[$i]->name;
            $text['type'.$i]= $results[$i]->type;
            $text['part'.$i]= $results[$i]->part;
            $text['vote'.$i]= $results[$i]->votes;
            $text['rating'.$i]= $results[$i]->rating;
            $text['bayes'.$i]= $results[$i]->bayes;





        }
        $name1= 'df';
        $i =1;

        $text['num']=count($results);
       // return $results;
   return \View::make('top',$text);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}
    public  function update_position()
    {
        $results = DB::select('select anime.name,anime.type,anime.part,votes,votes.rating from anime JOIN  votes ON anime.name = votes.name
and anime.part=votes.part and anime.type=votes.type order by votes.rating DESC ');


        for( $i=0; $i<count($results);$i++)
        {

            DB::update('update anime set position ='.($i+1).' where name="'.$results[$i]->name.'" and type="'.$results[$i]->type
                .'" and part='.$results[$i]->part
            );

        }
    }
 public function animation($name,$type,$part)
 {
if(\Auth::check()) {
    $query = 'select anime.name, epcount,anime.type,anime.part,description,position, origins,votes,
genres.genre,studio,image,vote from anime JOIN  votes ON anime.name = votes.name and anime.part=votes.part and anime.type=votes.type  join
genres on anime.name = genres.name and anime.type=genres.type and anime.part = genres.part join user_vote
 on anime.name = user_vote.name and anime.type=user_vote.type and anime.part = user_vote.part
 WHERE anime.name="' . $name . '" and anime.type="' . $type . '" and anime.part="' . $part . '" and id="' . \Auth::user()->id . '"';
}
     else {
         $query = 'select anime.name, epcount,anime.type,anime.part,description,position, origins,votes,
genres.genre,studio,image from anime JOIN  votes ON anime.name = votes.name and anime.part=votes.part and anime.type=votes.type  join
genres on anime.name = genres.name and anime.type=genres.type and anime.part = genres.part
 WHERE anime.name="' . $name . '" and anime.type="' . $type . '" and anime.part=' . $part;
     }
     $results = DB::select($query);
     $genres ="";


     for( $i=0; $i<count($results);$i++)
     {

         if($i==count($results)-1){
             $genres .= $results[$i]->genre.';';
         }
         else{
             $genres .= $results[$i]->genre.', ';
         }
     };
     $results[0]->genre = $genres;
     $text['name']=$results[0]->name;
     $text['epcount']=$results[0]->epcount;
     $text['type']=$results[0]->type;
     $text['part']=$results[0]->part;
     $text['origins']=$results[0]->origins;
     $text['votes']=$results[0]->votes;
     $text['description']=$results[0]->description;
     $text['votes']=$results[0]->votes;
     $text['genre']=$results[0]->genre;
     $text['studio']=$results[0]->studio;
     $text['position']=$results[0]->position;
     $text['image']=$results[0]->image;


     $comments=DB::select('select comment,users.name from comments JOIN users on comments.user_id=users.id WHERE
  comments.name="' . $name . '" and type="' . $type . '" and part=' . $part);
     $text['comment_num']=count($comments);
     for( $i=0; $i<$text['comment_num'];$i++)
     {
         $text['name_'.$i] = $comments[$i]->name;
         $text['comment_'.$i]=$comments[$i]->comment;
     }

    if(\Auth::check()) {
        $text['vote'] = $results[0]->vote;
        $book = DB::select('select choose from bookmarks  WHERE
  name="' . $name . '" and type="' . $type . '" and part=' . $part . ' and user_id=' . \Auth::user()->id);
    }
     if(!empty($book)){

         $text['bookmark']=$book[0]->choose;}
     else{
         $text['bookmark']=3;
     }
   //return $book[0]->choose;
  return view('animation' ,$text);

 }
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function vote()
    {
        $v = \Input::all();
        \Log::info($v);
        $vote = DB::select('select vote from user_vote where id='.\Auth::user()->id.' and name="'.$v['name'].'"and type="'.$v['type'].'"'.
            'and part="'.$v['part'].'"'
        );
        if(empty($vote)){
            DB::statement('insert into user_vote (vote,id,name,part,type) VALUES (
        '.$v['vote'].','
                .\Auth::user()->id.',"'
                .$v['name'].'",'
                .$v['part'].',"'
                .$v['type'].'")');
            $vote = DB::select('select vote from user_vote where id='.\Auth::user()->id.' and name="'.$v['name'].'"and type="'.$v['type'].'"'.
                'and part="'.$v['part'].'"'
            );
        }



        \Log::info($vote);


        //



        $upd='update votes set ';
        $upd_anoth=$upd;
        $end = ' where name="'.$v['name'].'" and type="'.$v['type'].'" and part='.$v['part'];
        \Log::info($vote[0]->vote);
        if($vote[0]->vote>0){
            if($vote[0]->vote!=$v['vote']){
                for($i=1;$i<6;$i++){
                    if($v['vote']==$i){
                        if($v['vote']<$vote[0]->vote) {
                            $upd_anoth = $upd_anoth . ' vote_' . $i . '=vote_' . $i . '+1';
                        }
                        else
                        {
                            $upd_anoth = $upd_anoth . ' ,vote_' . $i . '=vote_' . $i . '+1';
                        }
                    }

                    if($vote[0]->vote==$i)
                    { if($v['vote']<$vote[0]->vote) {
                        $upd_anoth = $upd_anoth.',vote_'.$i.'=vote_'.$i.'-1';
                    }
                    else
                    {
                        $upd_anoth = $upd_anoth.'vote_'.$i.'=vote_'.$i.'-1';
                    }

                    }
                }
                $upd_anoth=$upd_anoth.$end;
                \Log::info($upd_anoth);
                DB::statement($upd_anoth);
            }

        }

       else {
           if ($v['vote'] == 1) {
               $upd = $upd . 'vote_1=vote_1+1';
           } else if ($v['vote'] == 2) {
               $upd = $upd . 'vote_2=vote_2+1';
           } else if ($v['vote'] == 3) {
               $upd = $upd . 'vote_3=vote_3+1';
           } else if ($v['vote'] == 4) {
               $upd = $upd . 'vote_4=vote_4+1';
           } else if ($v['vote'] == 5) {
               $upd = $upd . 'vote_5=vote_5+1';
           }

           $upd = $upd . ' where name="' . $v['name'] . '" and type="' . $v['type'] . '" and part=' . $v['part'];
           \Log::info($upd);
           DB::statement($upd);
       }
        ///calculate rating
        $query_rate='select vote_1,vote_2,vote_3,vote_4,vote_5 from votes WHERE name="'.$v['name'].'" and
part="'.$v['part'].'" and type="'.$v['type'].'"';
        $rate=DB::select($query_rate);
        $rate_array = $rate[0];
        $rating = 0;
        $votes = 0;
        \Log::info($rate_array->{'vote_1'});
        for($i=1;$i<6;$i++){
            $rating +=$rate_array->{'vote_'.$i}*$i;
            $votes +=$rate_array->{'vote_'.$i};
        }
        $average =$rating/$votes;
        $n =40;
        $bayes=($votes/($votes+40))*$average +(30/(30+$votes))*4;
        \Log::info($votes);
/////////////////
        DB::statement('update votes set rating='.$average.', bayes='.$bayes.'WHERE name="'.$v['name'].'" and
part="'.$v['part'].'" and type="'.$v['type'].'"');

    $this->update_position();

       // Log($v);
       // return $v;
    }
	public function show($id)
	{
		//
	}

    /**
     *
     */

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function addComment()
    {


        $text=\Input::all();
       if($text['comment']!='') {
           DB::statement('insert into comments (name,type,part,comment,user_id) values ("'
               . $text["name"] . '","' . $text["type"] . '",' . $text["part"] . ',"' . $text["comment"] . '",'.\Auth::user()->id.')');
       \Log::info("inserted");
       }
        return Redirect::back();


    }
    public function addToBookmarks(){
        $text =\Input::all();
    \Log::info($text);
        $query ='select name from bookmarks where user_id='.\Auth::user()->id.' and name="'.$text['name'].'" and
part="'.$text['part'].'" and type="'.$text['type'].'"';
      $select= DB::select($query);
        \Log::info(count($select));
        \Log::info($query);
        \Log::info($select);
        if(count($select)==0){
            DB::statement('replace into bookmarks (name,type,part,choose,user_id) values ("'
               . $text["name"] . '","' . $text["type"] . '",' . $text["part"] . ',' . $text["l"] . ','.\Auth::user()->id.')');
        }if(count($select)>0){
//            DB::statement('replace  into bookmarks (name,type,part,choose,user_id) values ("'
//               . $text["name"] . '","' . $text["type"] . '",' . $text["part"] . ',' . $text["l"] . ','.\Auth::user()->id.')');
            DB::statement('update bookmarks set choose='.$text['l'].' where user_id='.\Auth::user()->id.' and name="'.$text['name'].'" and
part="'.$text['part'].'" and type="'.$text['type'].'"');
        }


    }
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function profile($id){

        $select = DB::select('select anime.name,anime.type,anime.part,choose,image from bookmarks join anime on bookmarks.name=anime.name
  and bookmarks.type=anime.type and bookmarks.part=anime.part
 WHERE user_id='.\Auth::user()->id);
        $vote = DB::select('select  anime.name,anime.type,anime.part,vote,image from user_vote join anime on user_vote.name=anime.name
  and user_vote.type=anime.type and  user_vote.part=anime.part WHERE id='.\Auth::user()->id);
        $numchoos1=DB::select('select choose from bookmarks where  user_id='.\Auth::user()->id.' and choose=1');
        $numchoos0=DB::select('select choose from bookmarks where  user_id='.\Auth::user()->id.' and choose=0');
        $text['n']=count($select);
        $text['ch1']=count($numchoos1);
        $text['ch0']=count($numchoos0);

        $text['n_v']=count($vote);
        for($i=0;$i<$text['n'];$i++)
        {
         $text['name'.$i]=$select[$i]->name;
         $text['part'.$i]=$select[$i]->part;
         $text['type'.$i]=$select[$i]->type;
         $text['choose'.$i]=$select[$i]->choose;
         $text['img'.$i]=$select[$i]->image;

        }
  for($i=0;$i<$text['n_v'];$i++)
        {

            $text['name_'.$i]=$vote[$i]->name;
         $text['part_'.$i]=$vote[$i]->part;
         $text['type_'.$i]=$vote[$i]->type;
         $text['vote'.$i]=$vote[$i]->vote;
            $text['img_'.$i]=$vote[$i]->image;
        }
   // return $text;
        return view('profile', $text);
    }
	public function update($id){}
	public function deleteItem()
	{
        $del=\Input::all();
        DB::statement('delete from bookmarks WHERE user_id='.\Auth::user()->id.' and name="'.$del['name'].'" and type="'.
            $del['type'].'" and
        part='.$del['part'].' and choose='.$del['choose']);
		return \Redirect::back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
