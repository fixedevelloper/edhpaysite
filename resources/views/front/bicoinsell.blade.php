@extends('front.base')

@section('content')
<form method="post" action="https://wallet.advcash.com/sci/">
    <input type="hidden" name="ac_account_email" value="agensic.solution@gmail.com" />
    <input type="hidden" name="ac_sci_name" value="EDHPAY" />
    <input type="text" name="ac_amount" value="1.00" />
    <input type="text" name="ac_currency" value="USD" />
    <input type="text" name="ac_order_id" value="123456789" />
    <input type="text" name="ac_sign" value="a3c82628b1743947fcbbd4b412a22d8eed190bca6d577ccb1f18f656557201b2" />
    <!-- Optional Fields -->
    <input type="hidden" name="ac_success_url" value="https://edhpay.com/callback/payment-succes" />
    <input type="hidden" name="ac_success_url_method" value="GET" />
    <input type="hidden" name="ac_fail_url" value="https://edhpay.com/callback/payment-fail" />
    <input type="hidden" name="ac_fail_url_method" value="GET" />
    <input type="hidden" name="ac_status_url" value="https://edhpay.com/callback/advcash" />
    <input type="hidden" name="ac_status_url_method" value="POST" />
    <input type="text" name="ac_comments" value="Comment" />
    <input type="submit" />
</form>
@endsection
