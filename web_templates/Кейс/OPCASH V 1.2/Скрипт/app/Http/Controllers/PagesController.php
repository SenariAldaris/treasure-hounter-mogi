<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Gifts;
use Auth;
use Carbon\Carbon;

class PagesController extends Controller
{

  CONST CASE_FREE_LIMIT = 5; //Checks if 5 cases was opened before opening free case
  CONST FREE_CASE_MIN_DEPOSIT_ADD = 10; //Skolko nado deneg vvesti na sait chtobi poluchitj shanci na free keisi(FREE_ADD_COUNT)
  CONST FREE_ADD_COUNT = 5; //Skolko free keisov dobavitj pri popolnenii
  const merchant_id = '41333'; //free-kassa
  const merchant_secret_1 = 'x7sqbyb9'; //free-kassa
  const merchant_secret_2 = 'ubqn0zfr'; //free-kassa
  const REFERALL_ADD_PROCENT = 5; //Pri popolnenii skolko procentov poluchit referal

//Pay function called after deposit
  public function pay(Request $request){
    $amount = $request->ik_am;
    $type = $request->pm;
    if((int)$amount < 1){
        $amount = 99;
    }
    $int_id =  \DB::table('payments')->insertGetId([
        'amount' => (int)$amount,
        'user' => $this->user->id,
        'time' => time(),
        'status' => 0,
      ]);
    $orderID = $int_id;

    $sign = md5(self::merchant_id.':'.$amount.':'.self::merchant_secret_1.':'.$orderID);
    if($type == 'qiwi'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=63';
    }else if($type == 'card'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=94';
    }else if($type == 'mts'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=84';
    }else if($type == 'biline'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=83';
    }else if($type == 'mega'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=82';
    }else if($type == 'tele2'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=132';
    }
    //$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru';
      return redirect($url);
  }
  function getIP() {
  if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
  return $_SERVER['REMOTE_ADDR'];
  }
//Return function for free-kassa
  public function getPayment(Request $request){
    if (!in_array($this->getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98'))) {
	  return "Ip nneatbilst";
    }

  $sign = md5(self::merchant_id.':'.$request->AMOUNT.':'.self::merchant_secret_2.':'.$request->MERCHANT_ORDER_ID);

    if($sign != $request->SIGN){
      return "Signi neatbilst";
    }
  $payment=   \DB::table('payments')
    ->where('id', $request->MERCHANT_ORDER_ID)->first();
    if(count($payment) == 0){
        return "Neatrada bd";
    }else{
        if($payment->status != 0){
            return "Status nav 0";
        }else{
            if($payment->amount != $request->AMOUNT){
                return "Summa neatbilst";
            }else{
              $user = User::where('id', $payment->user)->first();
              $user->money = $user->money + $payment->amount;

              if($payment->amount >= self::FREE_CASE_MIN_DEPOSIT_ADD){
                $user->free_cases_left = $user->free_cases_left + self::FREE_ADD_COUNT;
              }
              $user->save();

              $te = User::where('ref_code', $user->ref_use)->first();
              if(count($te) == null ||count($te) == 0){

              }else{
                $bon = (self::REFERALL_ADD_PROCENT/100)*$payment->amount;
                $te->money =   $te->money + $bon;
                $te->save();
              }
              \DB::table('payments')
              ->where('id', $payment->id)
              ->update(['status' => 1]);
                return 'success';
            }
        }
    }
  }
//Main page
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
        $tickets = \DB::table('ticket')->orderBy('price', 'asc')->get();
        return view('pages.index', compact('cases','cases2','tickets'));
    }
//User account
    public function account()
    {
        $count_ref = User::where('ref_use', $this->user->ref_code)->count('id');
        $cases = \DB::table('last_drops')->where('user', $this->user->id)->orderBy('id', 'desc')->get();
        $case = $this->user->open_box;
        $items = [];
        $win = $this->user->win;
        $mo = \DB::table('payments')->where('user', $this->user->id)->where('status', 1)->get();
        $gifts = \DB::table('last_gifts')->where('user', $this->user->id)->get();
        $mo2 = \DB::table('last_vvod')->where('user', $this->user->id)->get();
        $vivod = \DB::table('vivod')->where('user', $this->user->id)->get();
        foreach ($cases as $i) {
            $user = User::find($i->user);
            if($user != null){
              $i->price = \DB::table('items')->where('id', $i->items)->pluck('price');
              $i->case_price = \DB::table('case')->where('id', $i->case_id)->pluck('price');
              $i->name = \DB::table('case')->where('id', $i->case_id)->pluck('name');
            }
        }
        foreach ($gifts as $i2) {
            $user2 = User::find($i2->user);
            if($user2 != null){
              $i2->img = \DB::table('case')->where('id', $i2->case_id)->pluck('img');
            }
        }
        foreach ($cases as $i) {
            $item = \DB::table('items')->where('id', $i->items)->pluck('price');
            if($item == NULL) break;
            $items[] = \DB::table('items')->where('id', $i->items)->first();
        }
        return view('pages.account', compact('count_ref', 'case', 'win', 'items','cases','mo', 'mo2','vivod','gifts'));
    }

    public function konkurs()
    {
        return view('pages.konkurs');
    }
//Referall code checking
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
            $user2 = User::where('ref_code', $r->code)->first();
            $user2->money = $user2->money + 5;
            $user2->save();
            $data = [
                'status' => 1,
                'message' => 'Вы успешно активировали код!',
                'sum' => $user->money
            ];
        }

        return json_encode($data);
    }
    //Gifts page
        public function gifts($id)
        {
            $case = \DB::table('case')->where('id', $id)->where('type','gift')->first();
            if ($case !== NULL) {
                $items = \DB::table('items')->where('cases_id', $id)->orderBy('price', 'desc')->get();
                $itemsDemo = \DB::table('items')->where('cases_id', $id)->orderBy('price', 'asc')->get();
                $a = \DB::table('last_drops')->where('case_id', $case->id)->get();
                $won = 0;
                foreach ($a as $d) {
                    $item = \DB::table('items')->where('id', $d->items)->pluck('price');
                    $won += $item;
                }
                return view('pages.case', compact('items', 'itemsDemo', 'case', 'won'));
            } else {
                return redirect('/');
            }
        }

//Case page
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
//Function called when opening case
    public function opencase($id, $chance)
    {
        $case = \DB::table('case')->where('id', $id)->first();
        $config = \DB::table('site_settings')->where('id', 1)->first();
        if ($case == NULL) {
            return response()->json(['status' => 0, 'error' => 'Такого кейса не существует']);
        } else {
            if (Auth::guest()) {
                return response()->json(['status' => 0, 'error' => 'Авторизуйтесь!']);
            } else {
                if ($chance == 1) {
                    $chance = $case->x10;
                    $ch = 5; //10 defoult
                } else if ($chance == 2) {
                    $chance = $case->x20;
                    $ch = 10; //20 defoult
                } else if ($chance == 3) {
                    $chance = $case->x30;
                    $ch = 20; //30 defoult
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
                        return response()->json(['status' => 0, 'error' => 'У Вас нет бесплатных кейсов.Пополняя баланс сайта на сумму от 20 рублей и более Вы получаете 1 открытие бесплатного кейса.']);
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
                        $item = $this->getProcentFree($case);
                    }else{
                      $prok = $case->bad_procent;
                      $item = $this->getProcent($case,$prok,$ch);
                    }
                    $user = User::find($this->user->id);
                    $user->money = $user->money - ($case->price + $chance);
                    $user->open_box = $user->open_box + 1;
                    $user->win = $user->win + $item->price;
                    $user->save();

                    if($item->price == 12345){
                      Gifts::create([
                          'case_id' => $case->id,
                          'user' => $user->id,
                          'username' => $user->username,
                          'login' => $user->login,
                          'status' => 0,
                          'name' => $case->name,
                          'price' => $case->price_max
                      ]);
                    \DB::table('last_drops')->insertGetId(['user' => $this->user->id, 'items' => $item->id, 'case_id' => $case->id]);
                        return response()->json([
                            'status' => 1,
                            'data' => [
                                'gift' => $item->id,
                                'win_sum' => 0,
                                'text' => $case->name.' получите его в аккунте',
                                'photo' => $item->img
                            ]
                        ]);
                    }else{
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
    }
    public function sell(Request $r){
    $gift =  Gifts::where('id',$r->item)->first();
    $user3 = User::where('id',$r->user)->first();
      if($gift == null){
        return response()->json(['success' => false, 'error' => 'Gift doesnt exist']);
      }else{
        if($user3->id == $gift->user){
          if($gift->status == 0){
            $price = $gift->price / 2;
            $user3->money = $user3->money + $price;
            $user3->save();
            $gift->status = 1;
            $gift->save();
                return response()->json(['success' => true, 'error' => 'Gift sold!']);
          }
        }
      }
    }
    public function send(Request $r){
    $gift =  Gifts::where('id',$r->item)->first();
    $user3 = User::where('id',$r->user)->first();
      if($gift == null){
        return response()->json(['success' => false, 'error' => 'Gift doesnt exist']);
      }else{
        if($user3->id == $gift->user){
          if($gift->status == 0){
            $gift->status = 2;
            $gift->save();
                return response()->json(['success' => true, 'error' => 'Gift sent!']);
          }
        }
      }
    }
    public function getProcent($case,$prok,$ch){
        $items = \DB::table('items')->where('cases_id', $case->id)->orderBy('price', 'asc')->get();
        $rand = mt_rand(1, 100);
        $k = 0;
        if ($rand <= ($prok - $ch)) {
            foreach ($items as $i) {
                if ($i->price <= $case->price) {
                    $itemsPrice[] = $i;
                    $k++;
                }
            }
            $rands = mt_rand(0, $k - 1);
            $item = $itemsPrice[$rands];
            return $item;
        } else {
            foreach ($items as $i) {
                if ($i->price >= $case->price) {
                    $itemsPrice[] = $i;
                    $k++;
                }
            }
            $rands = mt_rand(0, $k - 1);
            $item = $itemsPrice[$rands];
            return $item;
        }
    }

    public function getProcentFree($case){
        $items = \DB::table('items')->where('cases_id', $case->id)->orderBy('price', 'asc')->get();
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
            return $item;
        } else {
            foreach ($items as $i) {
                if ($i->price <= 7) {
                    $itemsPrice[] = $i;
                    $k++;
                }
            }
            $rands = mt_rand(0, $k - 1);
            $item = $itemsPrice[$rands];
            return $item;
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
        return redirect('https://vk.com/');
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
          $te = User::where('ref_code', $user->ref_use)->first();
          if(count($te) == null || count($te) == 0){

          }else{
            $bon = (self::REFERALL_ADD_PROCENT/100)*$r->ik_am;
            $te->money =   $te->money + $bon;
            $te->save();
          }
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
