@component('mail::message')
# 馬偕醫院急診排班系統公告

{{ $receiver }}您好
<br>
您收到來自{{ $applicant }} 醫師的換班申請

@component('mail::button', ['url' => 'http://localhost:8000/login'])
立即登入系統
@endcomponent

Thanks,<br>
馬偕醫院急診部門排班系統
@endcomponent
