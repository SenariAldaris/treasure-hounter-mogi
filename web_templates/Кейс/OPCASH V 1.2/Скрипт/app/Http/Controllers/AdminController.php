<?php

namespace App\Http\Controllers;

use App\User;
use App\Cases;
use App\Ticket;
use App\Payments;
use Illuminate\Http\Request;
use App\Items;

class AdminController extends Controller
{
    public function index()
    {
        $drop = \DB::table('last_drops')->orderBy('id', 'desc')->take(20)->get();
        foreach ($drop as $i) {
            $user = User::find($i->user);
            if($user != null){
              $i->username = $user->username;
              $i->user_id = $user->id;

              $i->price = \DB::table('items')->where('id', $i->items)->pluck('price');
              $i->case_price = \DB::table('case')->where('id', $i->case_id)->pluck('price');
            }
        }
        return view('admin.index', compact('drop'));
    }

    public function addCase()
    {
      $number = \DB::table('images')->orderBy('id', 'asc')->get();
        return view('admin.add', compact('number'));
    }
    public function cases()
    {
      $cases = \DB::table('case')->orderBy('price', 'asc')->paginate(100);
        return view('admin.cases', compact('cases'));
    }
    public function caseid($id)
    {
        $case = Cases::find($id);
        return view('admin.case', compact('case'));
    }
    public function casedit(Request $request)
    {
        $case = Cases::find($request->get('id'));
        $case->price_min = $request->get('min');
        $case->price_max = $request->get('max');
        $case->price = $request->get('price');
        $case->x10 = $request->get('x10');
        $case->x20 = $request->get('x20');
        $case->x30 = $request->get('x30');
        $case->items = $request->get('items');
        $case->bad_procent  = $request->get('bad');
        $case->type  = $request->get('type');
        $case->save();
        if($request->get('type') == 'money'){
          $this->generateCase($case->id);
        }else if($request->get('type') == 'gift'){
          $this->generateGift($case->id);
        }
        return redirect('/admin/cases');

    }
    public function users()
    {
      $users = \DB::table('users')->orderBy('id', 'asc')->paginate(100);
        return view('admin.users', compact('users'));
    }
    public function search2(Request $request)
    {
        $users = User::select('users.id',
            'users.username',
            'users.avatar', 'users.money',
            'users.login',
             \DB::raw('COUNT(last_drops.user) as open_box'))->join('last_drops', 'last_drops.user', '=', 'users.id')->where('login', 'LIKE', '%' . $request->get('name') . '%')->orderby('id', 'desc')->paginate(20);
        return view('admin.users', compact('users'));

    }
    public function searchusersname(Request $request)
    {
        $users = User::select('users.id',
            'users.username',
            'users.avatar', 'users.money',
            'users.login',
             \DB::raw('COUNT(last_drops.user) as open_box'))->join('last_drops', 'last_drops.user', '=', 'users.id')->where('username', 'LIKE', '%' . $request->get('name') . '%')->orderby('id', 'desc')->paginate(20);
        return view('admin.users', compact('users'));
    }
    public function givemoney($id, Request $request)
    {
        $user = User::find($id);
        if ($request->get('money')) {
            $user->money += $request->get('money');
            $user->save();
            return redirect('/admin/users');
        }
        return view('admin.givemoney', compact('user'));
    }
    public function userid($id)
    {
        $user = User::find($id);
        return view('admin.user', compact('user'));
    }
    public function userdit(Request $request)
    {
        $user = User::find($request->get('id'));
        $user->money = $request->get('money');
        $user->username = $request->get('username');
        $user->is_admin = $request->get('is_admin');
        $user->is_yt = $request->get('is_yt');
        $user->save();
        return redirect('/admin/users');

    }
    public function ticketsave(Request $request){
      $ticket = Ticket::find($request->get('id'));
      $ticket->name = $request->get('name');
      $ticket->price = $request->get('price');
      $ticket->places = $request->get('places');
      $ticket->jackpot = $request->get('jackpot');
      $ticket->save();
      return redirect('/admin/tickets');
    }
    public function generateCase($case){
        $t = Cases::where('id',$case)->first();
        $items = explode(",", $t->items);

    foreach($items as $item2){
          $t2 = Items::where('price',$item2)->where('cases_id', $case)->get();
      if(count($t2) == null || count($t2) == 0){
          $img = '/uploads/coin-'.$item2.'.svg';
          Items::create([
              'img' => $img,
              'price' => $item2,
              'cases_id' => $t->id
          ]);
        }
      }
        $t33 = Items::where('cases_id', $case)->get();
        foreach ($t33 as $key) {
          if(in_array($key->price, $items) == 1){

          }else{
            $td = Items::where('price',$key->price)->where('cases_id',$t->id)->first();
            $td->delete();
          }
        }
    }

    public function generateGift($case){
        $t = Cases::where('id',$case)->first();
        $items = explode(",", $t->items);

    foreach($items as $item2){
      $aca = substr($item2,-1);

      if($aca == 'g'){
        $t1213 = Items::where('price','12345')->where('cases_id', $case)->get();
          if(count($t1213) == null || count($t1213) == 0){
            $img = '/uploads/gift-'.$item2.'.png';
            Items::create([
                'img' => $img,
                'price' => 12345,
                'cases_id' => $t->id
            ]);
          }
      }else{
            $t2 = Items::where('price',$item2)->where('cases_id', $case)->get();
        if(count($t2) == null || count($t2) == 0){
            $img = '/uploads/coin-'.$item2.'.svg';
            Items::create([
                'img' => $img,
                'price' => $item2,
                'cases_id' => $t->id
            ]);
          }
      }
      $t33 = Items::where('cases_id', $case)->get();
      foreach ($t33 as $key) {
        $aca = substr($item2,-1);

        if($aca == 'g'){

        }else{
          if(in_array($key->price, $items) == 1){

          }else{
            $td = Items::where('price',$key->price)->where('cases_id',$t->id)->first();
            $td->delete();
          }
        }
      }
      }
    }
    public function addCasePost(Request $r)
    {
        $id = \DB::table('case')->insertGetId([
            'price_min' => $r->minPrice,
            'price_max' => $r->maxPrice,
            'price' => $r->Price,
            'x10' => $r->x10,
            'x20' => $r->x20,
            'x30' => $r->x30,
            'img' => $r->img,
            'items' => $r->items,
            'bad_procent' => $r->bad,
            'type' => $r->type
        ]);
        if($r->type == 'money'){
            $this->generateCase($id);
        }else if($r->get('type') == 'gift'){
          $this->generateGift($id);
        }
        return redirect('/admin/addCase');
    }

    public function tickets(){
      $tickets = \DB::table('ticket')->orderBy('id', 'asc')->paginate(100);
      return view('admin.tickets', compact('tickets'));
    }

    public function ticket($id)
    {
        $ticket = Ticket::find($id);
        return view('admin.ticket', compact('ticket'));
    }

    public function addItem()
    {
        $cases = \DB::table('case')->orderBy('id', 'asc')->get();
        $number = \DB::table('images')->orderBy('id', 'asc')->get();
        return view('admin.addItem', compact('cases','number'));
    }

    public function addItemPost(Request $r)
    {
        \DB::table('items')->insertGetId([
            'img' => $r->img,
            'price' => $r->price,
            'cases_id' => $r->case
        ]);
        return redirect('/admin/addItem');
    }

    public function lastvvod()
    {
      $a = \DB::table('payments')->orderBy('id', 'desc')->where('status', 1)->take(20)->get();
      foreach ($a as $b) {
        $u = User::find($b->user);
        $b->name = $u->username;
        $b->name_id = $u->id;
      }

      return view('admin.lastvvod', compact('a'));
    }

    public function vivod()
    {
      $a = \DB::table('vivod')->where('status', 0)->orderBy('id', 'desc')->get();
      foreach ($a as $b) {
        $u = User::find($b->user);
        $b->name = $u->username;
        $b->name_id = $u->id;
      }

      return view('admin.vivod', compact('a'));
    }
    public function vivodgifts()
    {
      $a = \DB::table('last_gifts')->where('status', 2)->orderBy('id', 'desc')->get();
      foreach ($a as $b) {
        $u = User::find($b->user);
        $b->name = $u->username;
        $b->name_id = $u->id;
      }

      return view('admin.vivodgifts', compact('a'));
    }

    public function close($id)
    {
      \DB::table('vivod')->where('id', $id)->update(['status' => 1]);
      return redirect('/admin/lastvivod');
    }
    public function closegift($id)
    {
      \DB::table('last_gifts')->where('id', $id)->update(['status' => 3]);
      return redirect('/admin/vivodgifts');
    }
}
