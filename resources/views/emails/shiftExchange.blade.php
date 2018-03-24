@component('mail::message')
# 馬偕醫院急診排班系統公告

親愛的{{ $receiverName }}醫師 您好:
<br>
由於班表調整，
原訂{{ $originalShift->date }} {{ $originalLocation }}院{{ $originalShiftName }}班
<br>
已被調整至{{ $newShift->date }}  {{ $newLocation }}院{{ $newShiftName }}班，
<br>
如果有任何疑問或是狀況，請儘速於3日內提出，謝謝!
<br>
<br>

【聯絡方式】
<br>
{{ $admin->name }}醫師
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
