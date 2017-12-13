@component('mail::message')
# 馬偕醫院急診部門排班系統

親愛的{{ $a_doctor }}醫師 您好：
<br>

{{ $b_doctor }}醫師同意您提出的換班要求，<br>
系統已將您的{{ $a_date }}班調整至{{ $b_date }}班，<br>
如果有任何疑問或是狀況，<br>
請儘速於3日內提出，謝謝！


<br>
<br>

【聯絡方式】<br>
{{ $b_doctor }}醫師<br>
聯絡信箱：{{ $b_email }}

<br>

{{ $b_doctor }}醫師（排班人員）<br>
聯絡信箱：{{ $b_email }}
<br>


@component('mail::button', ['url' => 'http://localhost:8000'])
登入系統
@endcomponent

※ 此信件為系統發出信件，請勿直接回覆。若您有問題請向相關人員提出，謝謝！<br>
馬偕醫院急診部門排班系統
@endcomponent
