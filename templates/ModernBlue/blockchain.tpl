<!-- Content -->
<div class="widget-main-title">Bitcoin Deposit</div>

<div class="widget-content">
<p>Please send <strong>{$amount}</strong> BTC to <br /><strong>{$account}</strong></p>
<img style="margin:5px" id="qrsend" src="{$blockchain_root}qr?data=bitcoin:{$account}%3Famount={$amount}%26label=User-{$user_info.username}&size=125" alt=""/>
</div>




<!-- End Content -->