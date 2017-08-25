@component('mail::message')
# 馬偕醫院急診排班系統公告

由於預約此時段之人數過多將進行抽籤。
預班資料如下：
預班編號：{{ $$res->resSerial }}<br>
日期：{{ $res->date }}<br>
預班類別：{{ $category }}<br>

@component('mail::button', ['url' => 'http://localhost:8000/login'])
立即登入系統
@endcomponent

馬偕醫院急診部門排班系統
@endcomponent
