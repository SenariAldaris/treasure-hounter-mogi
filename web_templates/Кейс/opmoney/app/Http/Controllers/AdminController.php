<?php
/**
 * Created by PhpStorm.
 * User: ToXaHo
 * Date: 09.10.2016
 * Time: 14:17
 */

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

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
        return view('admin.add');
    }

    public function addCasePost(Request $r)
    {
        \DB::table('case')->insertGetId([
            'price_min' => $r->minPrice,
            'price_max' => $r->maxPrice,
            'price' => $r->Price,
            'x10' => $r->x10,
            'x20' => $r->x20,
            'x30' => $r->x30,
            'img' => $r->img
        ]);

        return redirect('/admin/addCase');
    }

    public function addItem()
    {
        $cases = \DB::table('case')->orderBy('id', 'asc')->get();
        return view('admin.addItem', compact('cases'));
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
      $a = \DB::table('last_vvod')->orderBy('id', 'desc')->take(20)->get();
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

    public function close($id)
    {
      \DB::table('vivod')->where('id', $id)->update(['status' => 1]);
      return redirect('/admin/lastvivod');
    }
}
