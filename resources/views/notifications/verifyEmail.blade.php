@component('mail::message')
    Welcome to largest online marketplace in zambia 
    <strong>Name:</strong>
    @component('mail::button',['url'=>'http://127.0.0.1:8000/auth/login'])
    Click here 
    @endcomponent
@endcomponent 