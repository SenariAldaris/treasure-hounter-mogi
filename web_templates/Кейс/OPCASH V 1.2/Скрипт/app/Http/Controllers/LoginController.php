<?php


namespace App\Http\Controllers;

use Auth;
use App\User;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function vklogin(Request $r)
    {
       $client_id = '5912599';
        $client_secret = 'gEkbRQVDHPJloXc4wVbh';
        $redirect_uri = 'eddcash.ru';
        if (!is_null($r->code)) {

            $obj = json_decode($this->curl('https://oauth.vk.com/access_token?client_id=' . $client_id . '&client_secret=' . $client_secret . '&redirect_uri=http://' . $redirect_uri . '/login&code=' . $r->code));

            if (isset($obj->access_token)) {

                $info = json_decode($this->curl('https://api.vk.com/method/users.get?user_ids&fields=photo_200&access_token=' . $obj->access_token . '&v=V'), true);



  $user = User::where('login2', $info['response'][0]['uid'])->first();
                if($user == NULL) {
                  if(array_key_exists('photo_200', $info['response'][0])){
                      $photo = $info['response'][0]['photo_200'];
                  }else{
                    $photo = 'http://vk.com/images/camera_200.png';
                  }
                    $user = User::create([
                        'username' => $info['response'][0]['last_name'] . ' ' . $info['response'][0]['first_name'],
                        'avatar' => $photo,
                        'login' => 'id'.$info['response'][0]['uid'],
                        'login2' => $info['response'][0]['uid'],
                        'ref_code' => $this->generate()
                    ]);
                } else {
                  if(array_key_exists('photo_200', $info['response'][0])){
                      $photo = $info['response'][0]['photo_200'];
                  }else{
                    $photo = 'http://vk.com/images/camera_200.png';
                  }
                    $user->username = $info['response'][0]['last_name'] . ' ' . $info['response'][0]['first_name'];
                    $user->avatar = $photo;
                    $user->login = 'id'.$info['response'][0]['uid'];
                    $user->login2 = $info['response'][0]['uid'];
                    $user->save();
                }

                Auth::login($user, true);
                return redirect('/');

            }

        } else {
            return redirect('https://oauth.vk.com/authorize?client_id=' . $client_id . '&display=page&redirect_uri=http://' . $redirect_uri . '/login&scope=friends,photos,status,offline,&response_type=code&v=5.53');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function generate()
    {
        $length = 13;
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
}
