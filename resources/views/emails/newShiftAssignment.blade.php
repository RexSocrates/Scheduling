@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => 'localhost:8000'])
立即登入系統
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
