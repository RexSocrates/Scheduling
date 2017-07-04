@component('mail::message')
# 馬偕醫院急診排班系統公告

您好
排班人員已將下列兩班的醫師進行更換
<br>
{{ $shift1 }}
<br>
{{ $shift2 }}

@component('mail::button', ['url' => 'http://localhost:8000/login'])
立即登入系統
@endcomponent

Thanks,<br>
馬偕醫院急診部門排班系統
@endcomponent
