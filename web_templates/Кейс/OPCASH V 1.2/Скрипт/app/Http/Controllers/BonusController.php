<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Hour;
use App\Winner;
use App\Places;
use App\Ticket;
use App\Cont;
use App\Cases;
use App\Items;
use App\TicketWinner;
use DB;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class BonusController extends Controller
{
  const ADD_BONUS_MONEY = 10; //Dobovlenie deneg pri nazhatii knopki free
  const HOUR_BAD_PROCENT = 70; //% vipadenie dropa menshe HOUR_MINUS iz bezplatnogo keisa kazhdij chas
  const HOUR_MINUS = 300; //Jesli HOUR_BAD_PROCENT vipadajet togda menshe etoi summi vipadet drop esli vishe HOUR_BAD_PROCENT vipadet drop vishe HOUR_MINUS


  public function addbonus(Request $request){
    if(!Auth::check()){
      return Redirect::to('/login');
    }else{
      if($request->ajax()){
          $user2 = User::where('login', Auth::user()->login)->first();
        if(Carbon::now()->gt(Carbon::yesterday())){
            $created = new Carbon($user2->bonus_time);
            $now = Carbon::now();
        if($created->diffInHours($now) >= 24){
          $user2->money =   $user2->money + self::ADD_BONUS_MONEY;
          $user2->bonus_time = Carbon::now();
          $user2->save();
          return response()->json(['status' => 'success', 'status' => 'success']);
        }else{
        $av =  24 -  $created->diffInHours($now);
            return response()->json(['status' => 'false', 'hoursleft' => $av]);
        }
      }
    }
  }
  }


    public function hour(){

      $winner = Hour::orderBy(\DB::raw('RAND()'))->take(1)->first();
      if($winner == null){
          return response()->json(['status' => 'false','limit' => 'no_players']);
      }else{
        $money = array(10, 10,200,10,50,20,200,300,20,100,10);
        $rand = mt_rand(1, 100);
                    $k = 0;
        if ($rand <= self::HOUR_BAD_PROCENT) {
          foreach ($money as $i) {
            if ($i <= self::HOUR_MINUS) {
              $itemsPrice[] = $i;
              $k++;
            }
          }
            $rands = mt_rand(0, $k - 1);
            $item = $itemsPrice[$rands];
        }else{
          foreach ($money as $i) {
              if ($i >= self::HOUR_MINUS) {
                  $itemsPrice[] = $i;
                  $k++;
              }
          }
          $rands = mt_rand(0, $k - 1);
          $item = $itemsPrice[$rands];
        }
        Winner::create([
            'user_id' => $winner->user_id,
            'amount' => $item
        ]);
          $user = User::where('id', $winner->user_id)->first();
          $user->money = $user->money + $item;
          $user->save();
          $this->hour_delete_all();
            return response()->json(['status' => 'true']);
      }
    }

    public function hour_delete_all(){
        Hour::truncate();
    }
//Hour bonus system
    public function bonus(){
      if(!Auth::check()){return Redirect::to('/login');}
      $players = Hour::all();
      $v2 = Winner::orderBy('id','desc')->take(1)->first();
      if(count($v2) <= 0 || $v2 == null){
        Winner::create([
            'user_id' => $this->user->id,
            'amount' => 100
        ]);
      }
      $winner = User::where('id', $v2->user_id)->first();
      $all = count($players);
      return view('pages.bonus',compact('players','winner','all','v2'));

    }
    //Hour bonus join
    public function hour_join(Request $request){
      if($request->ajax()){
      if(Auth::check()){
        $user = Hour::where('user_id', $this->user->id)->first();
        if($this->user->open_box < 10){return response()->json(['status' => 'false','limit' => 'true' ]);}
            if($user == NULL) {
              $user = Hour::create([
                  'user_id' => $this->user->id,
                  'avatar' => $this->user->avatar,
                  'username' => $this->user->username,
                  'login' => $this->user->login,
              ]);
                return response()->json(['status' => 'true']);
            }else{
                  return response()->json(['status' => 'false','joined' => 'true' ]);
            }
      }else{
          return response()->json(['status' => 'false','login' => 'true' ]);
      }
    }
  }
//Ticket system
  public function ticket($id){
    if(!Auth::check()){return Redirect::to('/login');}
      $ticket = \DB::table('ticket')->where('id', $id)->first();
      if($ticket == null){  return Redirect::to('/');}
      $places = \DB::table('ticket_places')->where('ticket', $id)->get();
      $taken = \DB::table('ticket_places')->where('ticket', $id)->orderBy('updated_at','desc')->get();
      $us = \DB::table('ticket_places')->where('user','!=', '0')->where('ticket', $id)->get();
      $playing = count($us);
      $v2 = TicketWinner::orderBy('id','desc')->where('ticket', $id)->take(1)->first();
      if(count($v2) <= 0 || $v2 == null){
        TicketWinner::create([
          'user' => 1,
          'ticket' => $id,
          'winning_ticket' => 1
        ]);
      }
      $this->generateGame($id);
      $winner = User::where('id', $v2->user)->first();
          return view('pages.ticket',compact('ticket','places','playing','taken','winner','v2'));
  }
  //Ticket join
  public function setplace(Request $request){
      if(Auth::check()){
        $us = \DB::table('ticket_places')->where('user','!=', '0')->where('ticket', $request->id)->get();
        $playing = count($us);
          $user = User::where('id', $request->user)->first();
          $ticket= Ticket::where('id', $request->id)->first();
          $place = Places::where('ticket', $request->id)->where('place',$request->place)->first();
          if($user->money < $ticket->price){
              return response()->json(['status' => 'false','message' => 'No money' ]);
          }else{
            if($place == null){return response()->json(['status' => 'false','message' => 'Place dosnt exist. Reload page!' ]);}
            if($place->user == null){

              $place->user = $user->id;
              $place->user_avatar = $user->avatar;
              $place->username = $user->username;
              $place->save();
              $user->money = $user->money - $ticket->price;
              $user->save();
              if($playing >= $ticket->places - 1){
                $this->getWinnerTicket($request->id);
              }
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'false','message' => 'Place taken. Reload page!' ]);
            }
          }
      }else{
        return response()->json(['status' => 'false','message' => 'Login!' ]);
      }
  }
  //Call this function to crate table in database //checks if place is created and if not create or delete eow from db
    public function generateGame($ticket){
        $t = Places::where('ticket',$ticket)->get();
        $tick = Ticket::where('id',$ticket)->first();
        for ($i=1; $i <= $tick->places; $i++) {
            $t2 = Places::where('ticket',$ticket)->where('place',$i)->get();
          if(count($t2) == null || count($t2) == 0){
            Places::create([
                'ticket' => $ticket,
                'place' => $i,
                'user' => null,
                'user_avatar' => null,
                'username' => null
            ]);
          }else{
            if(count($t) > $tick->places){
                foreach ($t as $key) {
                  if($key->place > $tick->places){
                    $td = Places::where('ticket',$ticket)->where('place',$key->place)->first();
                    $td->delete();
                  }
                }
            }
          }
        }
    }

    public function getContestants(){
      $users = User::where('id', '>' , 0)->get();
      foreach ($users as $use) {
        $mo = \DB::table('payments')->where('user', $use->id)->where('status', 1)->sum('amount');
        $mo2 = \DB::table('last_vvod')->where('user', $use->id)->sum('price');
        if($mo >= 300 && $use->open_box >= 15 || $mo2 >= 300 && $use->open_box >= 15){
          $t = Cont::where('user_id', $use->id)->first();
          if(count($t) == null || count($t) == 0 ){
            Cont::create([
                'user_id' => $use->id,
                'user_name' => $use->username,
                'login' => $use->login,
                'boxes_opened' => $use->open_box
            ]);
          }
        }
      }
    }
    public function contests()
    {
      if(!Auth::check()){
        return Redirect::to('/login');
      }else{
        $contestants = Cont::where('id', '>', 0)->get();
        $mo = \DB::table('payments')->where('user', $this->user->id)->where('status', 1)->sum('amount');
        $mo2 = \DB::table('last_vvod')->where('user', $this->user->id)->sum('price');
        $ce = \DB::table('users')->where('id', $this->user->id)->sum('open_box');
          return view('pages.contests',compact('contestants','mo','mo2','ce'));
      }
    }

    public function getContestWinner(){
          $winner = Cont::orderBy(\DB::raw('RAND()'))->where('id', '>', 0)->take(1)->first();
          if($winner == null){

          }else{
              return response()->json(['name' => $winner->username,'id' => $winner->login]);
          }
    }
    public function clearContest(){
        Cont::truncate();
    }
    //Gets the winner of tickets
  public function getWinnerTicket($ticket){
    $winner = Places::orderBy(\DB::raw('RAND()'))->where('ticket',$ticket)->take(1)->first();
    $tick = Ticket::where('id',$ticket)->first();
    $t = Places::where('ticket',$ticket)->get();
    if($winner == null){
        return response()->json(['status' => 'false','limit' => 'no_players']);
    }else{
      TicketWinner::create([
          'user' => $winner->user,
          'ticket' => $winner->ticket,
          'winning_ticket' => $winner->place
      ]);
        $user = User::where('id', $winner->user)->first();
        $user->money = $user->money + $tick->jackpot;
        $user->save();
        foreach ($t as $tik) {
          $tik->user = null;
          $tik->username = null;
          $tik->user_avatar = null;
          $tik->save();
        }
        //  return response()->json(['status' => 'true']);
    }
  }

}
