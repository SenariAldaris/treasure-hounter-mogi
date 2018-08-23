<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Carbon\Carbon;

class PagesController extends Controller
{

  CONST CASE_FREE_LIMIT = 5; //Checks if 5 cases was opened before opening free case
  CONST FREE_CASE_MIN_DEPOSIT_ADD = 10;
  CONST FREE_ADD_COUNT = 5;

    public function index()
    {
        $cases = \DB::table('case')->orderBy('price', 'asc')->get();
        foreach ($cases as $i) {
            $a = \DB::table('last_drops')->where('case_id', $i->id)->get();
            $won = 0;
            foreach ($a as $d) {
                $item = \DB::table('items')->where('id', $d->items)->pluck('price');
                $won += $item;
            }
            $i->won = $won;
        }
        $cases2 = \DB::table('case')->where('price', 0)->get();
        foreach ($cases2 as $i2) {
            $a2 = \DB::table('last_drops')->where('case_id', $i2->id)->get();
            $won2 = 0;
            foreach ($a2 as $d2) {
                $item2 = \DB::table('items')->where('id', $d2->items)->pluck('price');
                $won2 += $item2;
            }
            $i2->won = $won2;
        }

        return view('pages.index', compact('cases','cases2'));
    }

    public function account()
    {
        $count_ref = User::where('ref_use', $this->user->ref_code)->count('id');
        $cases = \DB::table('last_drops')->where('user', $this->user->id)->orderBy('id', 'desc')->get();
        $case = $this->user->open_box;
        $items = [];
        $win = $this->user->win;
        foreach ($cases as $i) {
            $item = \DB::table('items')->where('id', $i->items)->pluck('price');
            if($item == NULL) break;
            $items[] = \DB::table('items')->where('id', $i->items)->first();
        }
        return view('pages.account', compact('count_ref', 'case', 'win', 'items'));
    }

    public function refuse(Request $r)
    {
        $code = \DB::table('users')->where('ref_code', $r->code)->first();
        if ($this->user->ref_use !== NULL) {
            $data = [
                'status' => 0,
                'message' => 'Вы уже активировали код'
            ];
        } else if ($code == NULL) {
            $data = [
                'status' => 0,
                'message' => 'Такого кода не существует'
            ];
        } else if ($this->user->ref_code == $r->code) {
            $data = [
                'status' => 0,
                'message' => 'Нельзя активировать свой код'
            ];
        } else {
            $user = User::find($this->user->id);
            $user->money = $user->money + 10;
            $user->ref_use = $r->code;
            $user->save();
            $data = [
                'status' => 1,
                'message' => 'Вы успешно активировали код!',
                'sum' => $user->money
            ];
        }

        return json_encode($data);
    }

    public function cases($id)
    {
        $case = \DB::table('case')->where('id', $id)->first();
        if ($case !== NULL) {
            $items = \DB::table('items')->where('cases_id', $id)->orderBy('price', 'desc')->get();
            $itemsDemo = \DB::table('items')->where('cases_id', $id)->orderBy('price', 'asc')->get();
            $a = \DB::table('last_drops')->where('case_id', $case->id)->get();
            $won = 0;
            foreach ($a as $d) {
                $item = \DB::table('items')->where('id', $d->items)->pluck('price');
                $won += $item;
            }
              if (Auth::guest()) {

              }else{
                $user = User::find($this->user->id);

                  $created = new Carbon($user->bonus_time_drop);
                  $now = Carbon::now();
                    if($created->diffInHours($now) >= 24){
                      $av = 0;
                  }else{
                    $av =  24 -  $created->diffInHours($now);
                  }

                  $left = $user->free_cases_left;
              }
            return view('pages.case', compact('items', 'itemsDemo', 'case', 'won', 'av', 'left'));
        } else {
            return redirect('/');
        }
    }

    public function opencase($id, $chance)
    {
        $case = \DB::table('case')->where('id', $id)->first();
        if ($case == NULL) {
            return response()->json(['status' => 0, 'error' => 'Такого кейса не существует']);
        } else {
            if (Auth::guest()) {
                return response()->json(['status' => 0, 'error' => 'Авторизуйтесь!']);
            } else {
                if ($chance == 1) {
                    $chance = $case->x10;
                    $ch = 10;
                } else if ($chance == 2) {
                    $chance = $case->x20;
                    $ch = 20;
                } else if ($chance == 3) {
                    $chance = $case->x30;
                    $ch = 30;
                } else {
                    $chance = 0;
                    $ch = 0;
                }
                if (($case->price + $chance) > $this->user->money) {
                    return response()->json(['status' => 0, 'error' => 'Не достаточно денег на балансе!']);
                } else {
                    /* Тут уже рандомим */
                    $items = \DB::table('items')->where('cases_id', $case->id)->orderBy('price', 'asc')->get();

                    if($case->price == 0){
                      $user = User::find($this->user->id);

                      if($user->free_cases_left <= 0){
                        return response()->json(['status' => 0, 'error' => 'You have 0 free cases!']);
                      }else{
                        if(Carbon::now()->gt(Carbon::yesterday())){
                            $created = new Carbon($user->bonus_time_drop);
                            $now = Carbon::now();
                          if($created->diffInHours($now) >= 24){
                            $user->bonus_time_drop = Carbon::now();
                            $user->free_cases_left = $user->free_cases_left - 1;
                            $user->save();
                          }else{
                          $av =  24 -  $created->diffInHours($now);
                            return response()->json(['status' => 0, 'error' => 'One case per day!']);
                          }
                        }
                      }
                    }

                    $itemsPrice = [];
                      if($case->price == 0){
                        $rand = mt_rand(1, 100);
                        $k = 0;
                        if ($rand >= 50) {
                            foreach ($items as $i) {
                                if ($i->price <= 4) {
                                    $itemsPrice[] = $i;
                                    $k++;
                                }
                            }
                            $rands = mt_rand(0, $k - 1);
                            $item = $itemsPrice[$rands];
                        } else {
                            foreach ($items as $i) {
                                if ($i->price <= 7) {
                                    $itemsPrice[] = $i;
                                    $k++;
                                }
                            }
                            $rands = mt_rand(0, $k - 1);
                            $item = $itemsPrice[$rands];
                        }
                      }else{
                        //ja youtubers tad te vajag shansu lielaku uzlikt.
                        if($this->user->is_yt == 1){
                          $rand = mt_rand(1, 100);
                          $k = 0;
                          if ($rand <= (50 - $ch)) {
                              foreach ($items as $i) {
                                  if ($i->price <= $case->price) {
                                      $itemsPrice[] = $i;
                                      $k++;
                                  }
                              }
                              $rands = mt_rand(0, $k - 1);
                              $item = $itemsPrice[$rands];
                          } else {
                              foreach ($items as $i) {
                                  if ($i->price >= $case->price) {
                                      $itemsPrice[] = $i;
                                      $k++;
                                  }
                              }
                              $rands = mt_rand(0, $k - 1);
                              $item = $itemsPrice[$rands];
                          }
                        }else{
                          $rand = mt_rand(1, 100);
                          $k = 0;
                          if ($rand <= (70 - $ch)) {
                              foreach ($items as $i) {
                                  if ($i->price <= $case->price) {
                                      $itemsPrice[] = $i;
                                      $k++;
                                  }
                              }
                              $rands = mt_rand(0, $k - 1);
                              $item = $itemsPrice[$rands];
                          } else {
                              foreach ($items as $i) {
                                  if ($i->price >= $case->price) {
                                      $itemsPrice[] = $i;
                                      $k++;
                                  }
                              }
                              $rands = mt_rand(0, $k - 1);
                              $item = $itemsPrice[$rands];
                          }
                        }
                      }

                    $user = User::find($this->user->id);
                    $user->money = $user->money - ($case->price + $chance);
                    $user->open_box = $user->open_box + 1;
                    $user->win = $user->win + $item->price;
                    $user->save();
                    $user->money = $user->money + $item->price;
                    $user->save();

                    \DB::table('last_drops')->insertGetId(['user' => $this->user->id, 'items' => $item->id, 'case_id' => $case->id]);

                    return response()->json([
                        'status' => 1,
                        'data' => [
                            'gift' => $item->id,
                            'win_sum' => $item->price,
                            'text' => $item->price . ' рублей',
                            'photo' => $item->img
                        ]
                    ]);
                }
            }
        }
    }

    public function stats()
    {
        $users = \DB::table('users')->count();
        $cases = \DB::table('last_drops')->count();
        return response()->json(['users' => $users, 'cases' => $cases]);
    }

    public function last_drop()
    {
        $last_drops = \DB::table('last_drops')->orderBy('id', 'desc')->take(20)->get();
        foreach ($last_drops as $i) {
            $user = User::find($i->user);
            $i->user_id = $user->id;
            $i->user_avatar = $user->avatar;
            $item = \DB::table('items')->where('id', $i->items)->first();
            $i->gift = $item->price;
            $i->gift_img = $item->img;
        }

        return response()->json(['last_drop' => $last_drops]);
    }

    public function last_gift_get()
    {
        $last_drops = \DB::table('last_drops')->orderBy('id', 'desc')->take(1)->get();
        foreach ($last_drops as $i) {
            $user = User::find($i->user);
            $i->user_id = $user->id;
            $i->user_avatar = $user->avatar;
            $item = \DB::table('items')->where('id', $i->items)->first();
            $i->gift = $item->price;
            $i->gift_img = $item->img;
        }

        return response()->json(['last_drop' => $last_drops]);
    }

    public function profile($id)
    {
        $user = User::find($id);
        if (Auth::guest()) {
          $cases = \DB::table('last_drops')->where('user', $user->id)->orderBy('id', 'desc')->get();
          $items = [];
          foreach ($cases as $i) {
              $item = \DB::table('items')->where('id', $i->items)->pluck('price');
              if($item == NULL) break;
              $items[] = \DB::table('items')->where('id', $i->items)->first();
          }
          return view('pages.profile', compact('user', 'items'));
        } else {
            if ($id == $this->user->id) {
                return redirect('/account');
            } else {
                $cases = \DB::table('last_drops')->where('user', $user->id)->orderBy('id', 'desc')->get();
                $items = [];
                foreach ($cases as $i) {
                    $item = \DB::table('items')->where('id', $i->items)->pluck('price');
                    if($item == NULL) break;
                    $items[] = \DB::table('items')->where('id', $i->items)->first();
                }
                return view('pages.profile', compact('user', 'items'));
            }
        }
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function support()
    {
        return redirect('https://vk.com/toxaho31');
    }

    public function reviews()
    {
        return view('pages.reviews');
    }

    public function guarantee()
    {
        return view('pages.quarantee');
    }

    public function acceptkassa(Request $r)
    {
        $user = User::find($r->ik_x_user_id);
        if($user !== NULL) {
          $user->money = $user->money + $r->ik_am;
          if($r->ik_am > self::FREE_CASE_MIN_DEPOSIT_ADD){
            $user->free_cases_left = $user->free_cases_left + self::FREE_ADD_COUNT;
          }
          $user->save();
          \DB::table('last_vvod')->insertGetId(['price' => $r->ik_am, 'user' => $r->ik_x_user_id]);
        }
    }
    public function success(){
        return redirect('/');
    }
    public function terms(){
      return view('pages.terms');
    }

    public function vivod($price, $kosh)
    {
      $zayavka = \DB::table('vivod')->where('user', $this->user->id)->where('status', 0)->count();
      if($this->user->money < $price) {
        $data = [
          'status' => 0,
          'message' => 'Не достаточно денег на балансе'
        ];
      } else if(strlen($kosh) <= 5 || $kosh == '') {
        $data = [
          'status' => 0,
          'message' => 'Попробуйте другой кошелёк!'
        ];
      } else if($zayavka >= 1){
        $data = [
          'status' => 0,
          'message' => 'Дождитесь оформления другой заявки!'
        ];
      } else {
        \DB::table('vivod')->insertGetId(['user' => $this->user->id, 'price' => $price, 'koshel' => $kosh]);
        $user = User::find($this->user->id);
        $user->money = $user->money - $price;
        $user->save();
        $data = [
          'status' => 1,
          'message' => 'Ваша заявка оформлена!',
          'sum' => $user->money,
        ];
      }

      return $data;
    }

}
