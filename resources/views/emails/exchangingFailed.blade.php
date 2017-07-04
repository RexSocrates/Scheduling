@component('mail::message')
# 馬偕醫院急診排班系統公告

{{ $applicant }} 您好
<br>
{{ $receiver }} 無法與您更換上班時間

@component('mail::button', ['url' => 'http://localhost:8000/login'])
立即登入系統
@endcomponent

Thanks,<br>
馬偕醫院急診部門排班系統
@endcomponent
