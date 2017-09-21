@component('mail::message')
# 馬偕醫院急診排班系統公告

親愛的 {{ $applicant->name }}醫師 您好:
<br>
{{ $receiver->name }}醫師同意您提出的換班要求，
系統已將您的{{ $applicantShift->date }} {{ $applicantShift->location }}院
{{ $applicantShift->shiftName }}班
調整至{{ $receiverShift->date }} {{$receiverShift->location}}院{{$receiverShift->shiftName}}班，
如果有任何疑問或是狀況，請儘速於3日內提出，謝謝!
<br>
<br>

【聯絡方式】
<br>
{{ $receiver->name }}醫師
<br>
聯絡信箱:{{$receiver->email}}
<br>
{{$admin->name}}醫師(排班人員)
<br>
聯絡信箱:{{$admin->email}}
<br>

※ 此信件為系統發出信件，請勿直接回覆。若您有問題請向相關人員提出，謝謝!
<br>

@component('mail::button', ['url' => 'http://localhost:8000/login'])
立即登入系統
@endcomponent

馬偕醫院急診部門排班系統
@endcomponent
