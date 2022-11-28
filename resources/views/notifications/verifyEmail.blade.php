@component('mail::message')
    Welcome to largest online marketplace in zambia
    <strong>Name: {{ $data['userData']['fullname'] }}</strong>
    @component('mail::button', ['url' => 'http://127.0.0.1:8000/api/auth/account/verify/' . $data['token']])
        Click here
    @endcomponent
@endcomponent
