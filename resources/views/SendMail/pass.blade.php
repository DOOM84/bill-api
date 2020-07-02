@component('mail::message')
# Здравствуйте!

Ваш пароль: {!! $pass !!}

С уважением,<br>
{{ config('app.name') }}
@endcomponent
