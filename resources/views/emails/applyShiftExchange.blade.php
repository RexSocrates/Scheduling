@component('mail::message')
# 馬偕醫院急診排班系統公告

親愛的 {{ $receiverName }}醫師 您好:
<br>
    {{ $applicant->name }}醫師向您提出換班要求，
希望能與您{{ $receiverShift->date }} {{ $receiverShiftLocation }}院
 {{ $receiverShiftName }}班
調整至{{ $applicantShift->date }} {{ $applicantShiftLocation }}院
{{ $applicantShiftName }}班，
同意與否請至排班系統網站中確認，如果有任何疑問或是狀況，請儘速於3日內提出，謝謝!
<br>
<br>

【聯絡方式】
<br>
{{ $applicant->name }}醫師
<br>
聯絡信箱:{{ $applicant->email }}

<br>

{{ $admin->name }}醫師(排班人員)
<br>
聯絡信箱:{{ $admin->email }}

<br>
※ 此信件為系統發出信件，請勿直接回覆。若您有問題請向相關人員提出，謝謝!
<br>

@component('mail::button', ['url' => 'http://localhost:8000/login'])
立即登入系統
@endcomponent

馬偕醫院急診部門排班系統
@endcomponent
