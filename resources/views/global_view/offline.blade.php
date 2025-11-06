<div id="offline-message" 
style="display:none; 
       position:fixed; 
       top:0; left:0; 
       width:100%; 
       height: 100vh;
       background:#fff; 
       color:#fff; 
       text-align:center; 
       flex-direction:column;
        justify-content: center;
        align-items: center;
       padding:15px; 
       font-weight:600; 
       z-index:999999;">
    <div class="">
        <div class="logo">
            <img style="width: 120px; margin-bottom: 20px; " src="{{ asset('public/images/logo-small.png') }}" alt="">
        </div>
        <div style="display: flex;  align-items: center;"> <img src="{{ asset('public/images/cloud-off.svg') }}" alt="" style="opacity: 0.7;"> <span style="font-size: 20px; color: #555; margin-left: 12px;">You're offline</span></div>
    </div>
</div>



    <script>
        window.addEventListener('load', function() {
            const offlineMessage = document.getElementById('offline-message');
        
            function updateOnlineStatus() {
                if (navigator.onLine) {
                    offlineMessage.style.display = 'none';
                } else {
                    offlineMessage.style.display = 'inline-flex';
                }
            }
        
            window.addEventListener('online', updateOnlineStatus);
            window.addEventListener('offline', updateOnlineStatus);
        
            // Initial check
            updateOnlineStatus();
        });
        </script>