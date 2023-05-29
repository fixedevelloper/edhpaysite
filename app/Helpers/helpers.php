<?php

namespace App\Helpers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravelpkg\Laravelchk\Http\Controllers\LaravelchkController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;

class helpers
{


    public static function upload(string $dir, string $format, $image = null)
    {
        if ($image != null) {
            $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
        } else {
            $imageName = 'def.png';
        }

        return $imageName;
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        if ($image == null) {
            return $old_image;
        }
        if (Storage::disk('public')->exists($dir . $old_image)) {
            Storage::disk('public')->delete($dir . $old_image);
        }
        $imageName = Helpers::upload($dir, $format, $image);
        return $imageName;
    }

    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            $err_keeper[] = ['code' => $index, 'message' => $error[0]];
        }
        return $err_keeper;
    }

    public static function response_formatter($constant, $content = null, $errors = []): array
    {
        $constant = (array)$constant;
        $constant['content'] = $content;
        $constant['errors'] = $errors;
        return $constant;
    }

    public static function file_uploader(string $dir, string $format, $image = null, $old_image = null)
    {
        if ($image == null) return $old_image ?? 'def.png';

        if (isset($old_image)) Storage::disk('public')->delete($dir . $old_image);

        $imageName = \Carbon\Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
        if (!Storage::disk('public')->exists($dir)) {
            Storage::disk('public')->makeDirectory($dir);
        }
        Storage::disk('public')->put($dir . $imageName, file_get_contents($image));

        return $imageName;
    }

    public static function currency_code()
    {
        $currency_code = BusinessSetting::where(['key' => 'currency'])->first()->value??'USD';
        return $currency_code;
    }

    public static function currency_symbol()
    {
        $currency_symbol = Currency::where(['currency_code' => Helpers::currency_code()])->first()->currency_symbol ?? '$';
        return $currency_symbol;
    }

    public static function set_symbol($amount)
    {
        $position = Helpers::get_business_settings('currency_symbol_position');
        if (!is_null($position) && $position == 'left') {
            $string = self::currency_symbol() . '' . number_format($amount, 2);
        } else {
            $string = number_format($amount, 2) . '' . self::currency_symbol();
        }
        return $string;
    }


    public static function remove_invalid_charcaters($str)
    {
        return str_ireplace(['\'', '"', ',', ';', '<', '>', '?'], ' ', $str);
    }

    public static function pagination_limit()
    {
       // $limit = self::get_business_settings('pagination_limit');
        $limit = 10;
        return isset($limit) && $limit > 0 ? $limit : 10;
    }

    public static function delete($full_path)
    {
        if (Storage::disk('public')->exists($full_path)) {
            Storage::disk('public')->delete($full_path);
        }
        return [
            'success' => 1,
            'message' => 'Removed successfully !'
        ];
    }

    public static function pin_check($user_id, $pin)
    {
        $user = User::find($user_id);
        if (Hash::check($pin, $user->password)) {
            return true;
        }else{
            return false;
        }
    }

    public static function get_qrcode($data)
    {
        $qrcode = QrCode::size(70)->generate(json_encode([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'type' => $data['type'] != 0 ? ($data['type'] == 1 ? 'agent' : 'customer') : null,
            'image' => $data['image'] ?? ''
        ]));
        return $qrcode;
    }

    public static function get_qrcode_by_phone($phone)
    {
        $user = User::where('phone', $phone)->first();
        $qrcode = QrCode::size(70)->generate(json_encode([
            'name' => $user['f_name'] . ' ' . $user['l_name'],
            'phone' => $user['phone'],
            'type' => $user['type'] != 0 ? ($user['type'] == 1 ? 'agent' : 'customer') : null,
            'image' => $user['image'] ?? ''
        ]));
        return $qrcode;

    }

    public static function filter_phone($phone) {
        $phone = str_replace([' ', '-'], '', $phone);
        return $phone;
    }

    public static function get_language_name($key)
    {
        $values = Helpers::get_business_settings('language');
        foreach ($values as $value) {
            if ($value['code'] == $key) {
                $key = $value['name'];
            }
        }

        return $key;
    }

    public static function language_load()
    {
        if (\session()->has('language_settings')) {
            $language = \session('language_settings');
        } else {
            $language = BusinessSetting::where('key', 'language')->first();
            \session()->put('language_settings', $language);
        }
        return $language;
    }

    public static function get_cashout_charge($amount)
    {
        if ($amount <= 0) return $amount;
        $charge_in_percent = (float)self::get_business_settings('cashout_charge_percent');
        $charge = ((float)$amount * $charge_in_percent) / 100;
        return $charge;
    }

    public static function get_sendmoney_charge()
    {
        $sendmoney_charge = (float)self::get_business_settings('sendmoney_charge_flat');
        return $sendmoney_charge;
    }

    public static function get_agent_commission($amount)
    {
        if ($amount <= 0) return $amount;
        $commission_in_percent = (float)(self::get_business_settings('agent_commission_percent') ?? 1);
        $commission = ((float)$amount * $commission_in_percent) / 100;
        return $commission;
    }

    public static function get_user_info($user_id)
    {
        $user = User::find($user_id);
        if (isset($user)) {
            return $user;
        }
        return null;
    }

    public static function get_user_id($phone)
    {
        $user_id = User::where('phone', $phone)->first()->id;
        return $user_id;
    }

    public static function get_currency_symbol()
    {
        $currency_symbol = Currency::get()->first();

        if(isset($currency_symbol)) {
            return $currency_symbol->currency_symbol;
        } else {
            return null;
        }
    }

    public static function fund_update($tran_id, $status)
    {
        try {
            $fund = Fund::where('tran_id', $tran_id)->first();
            $fund->status = $status;
            $fund->save();

            return [
                'user_id' => $fund->user_id,
                'amount' => $fund->amount
            ];

        } catch (Exception $e) {
            return null;
        }
    }

    public static function get_admin_id()
    {
        $admin_id = User::where('type', 0)->first()->id??1;
        return $admin_id;
    }

    public static function send_reservation_affectation($data)
    {
        $subject = $data['subject'];
        $user=$data['customer'];
        $data_ = array('name' => $user->name.' '.$user->lastname,'reservation'=>$data['reservation']
           );
        Mail::send(['html' => 'mail.reservation_affectation'], $data_, function ($message) use ($user, $subject) {
            $message->to($user->email, $user->name)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

    }
    public static function send_reservation_init($data)
    {
        $subject = $data['subject'];
        $message_send = $data['message'];
        $user=$data['customer'];
        $data_ = array('name' => $user->name.' '.$user->lastname,'reservation'=>$data['reservation'],
            'content' => $message_send,'prestations'=>$data['prestations']);
        Mail::send(['html' => 'mail.reservation_init'], $data_, function ($message) use ($user, $subject, $message_send) {
            $message->to($user->email, $user->name)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

    }
    public static function send_reservation_active($data)
    {
        $subject = $data['subject'];
        $message_send = $data['message'];
        $customer=$data['customer'];
        $data_ = array('name' => $customer->name.' '.$customer->lastname,'reservation'=>$data['reservation'],
            'content' => $message_send,'prestations'=>$data['prestations']);
        Mail::send(['html' => 'mail.reservation_active'], $data_, function ($message)
        use ($customer, $subject, $message_send) {
            $message->to($customer->email, $customer->name)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

    }
    public static function send_creation_account($data)
    {
        $user=$data['user'];
        $data_ = array('name' => $user->name.' '.$user->lastname,'password'=>$data['password'],
            'user' => $user);
        Mail::send(['html' => 'mail.account'], $data_, function ($message)
        use ($user) {
            $message->to($user->email, $user->name)->subject("Creation du compte");
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });

    }
    public static  function remove_dir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") Helpers::remove_dir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

    public static function file_remover(string $dir, $image)
    {
        if (!isset($image)) return true;

        if (Storage::disk('public')->exists($dir . $image)) Storage::disk('public')->delete($dir . $image);

        return true;
    }

    public static function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $oldValue = env($envKey);
        if (strpos($str, $envKey) !== false) {
            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}", $str);
        } else {
            $str .= "{$envKey}={$envValue}\n";
        }
        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
        return $envValue;
    }

    public static function requestSender()
    {
        $class = new LaravelchkController();
        $response = $class->actch();
        return json_decode($response->getContent(),true);
    }

}

function translate($key)
{
    $local = session()->has('local') ? session('local') : 'en';
    App::setLocale($local);
    $lang_array = include(base_path('resources/lang/' . $local . '/messages.php'));
    $processed_key = ucfirst(str_replace('_', ' ', Helpers::remove_invalid_charcaters($key)));
    if (!array_key_exists($key, $lang_array)) {
        $lang_array[$key] = $processed_key;
        $str = "<?php return " . var_export($lang_array, true) . ";";
        file_put_contents(base_path('resources/lang/' . $local . '/messages.php'), $str);
        $result = $processed_key;
    } else {
        $result = __('messages.' . $key);
    }
    return $result;
}


