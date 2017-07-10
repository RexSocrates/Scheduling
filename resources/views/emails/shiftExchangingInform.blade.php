@component('mail::message')
# 馬偕醫院急診排班系統公告

親愛的 {{ $admin->name }} 您好:
<br>
    {{ $receiver->name }}醫師已經同意{{ $applicant->name }}醫師
將{{ $applicantShift->date }} {{ $applicantShift->location }}院{{ $applicantShift->shiftName }}班
調整至{{$receiverShift->date}} {{ $receiverShift->location }}院{{ $receiverShift->shiftName }}班!

@component('mail::button', ['url' => 'http://localhost:8000/login'])
立即登入系統
@endcomponent

馬偕醫院急診部門排班系統
@endcomponent
