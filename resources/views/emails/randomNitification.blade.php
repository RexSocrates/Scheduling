@component('mail::message')
# 馬偕醫院急診排班系統公告


親愛的醫師 您好：<br><br>

由於您預約的 {{ $res->date }} {{ $resCateName }}，目前已經有 {{ $amount }} 人預約，超過當班所需人數，<br>
我們將隨機抽取以預選之醫師，將有一定機率無法排上此班，<br>
如有任何問題請與排班人員儘速聯絡，造成不便，敬請見諒，謝謝。<br><br>

【聯絡方式】<br>
{{ $admin->name }}醫師<br>
聯絡信箱：{{ $admin->email }}<br>
<br>
※ 此信件為系統發出信件，請勿直接回覆。若您有問題請向相關人員提出，謝謝！<br>
<br>

@component('mail::button', ['url' => 'http://localhost:8000/login'])
立即登入系統
@endcomponent

馬偕醫院急診部門排班系統
@endcomponent
