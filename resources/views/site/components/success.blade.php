@if (session('success') || session('warning'))
  @if (session('success'))
    <div id="successToast" class="toast-message success-toast">
    <div class="toast-content">
    <img src="{{ asset('site/assets/img/success.svg') }}" alt="Success Icon" class="toast-icon">
    <span class="toast-text">{{ session('success') }}</span>
    <button class="close-toast">&times;</button>
    </div>
    </div>
  @endif

  @if (session('warning'))
    <div id="warningToast" class="toast-message warning-toast">
    <div class="toast-content">
    <img src="{{ asset('site/assets/img/warning.svg') }}" alt="Warning Icon" class="toast-icon">
    <span class="toast-text">{{ session('warning') }}</span>
    <button class="close-toast">&times;</button>
    </div>
    </div>
  @endif

  <script>
    document.addEventListener("DOMContentLoaded", function () {
    var toasts = document.querySelectorAll(".toast-message");
    toasts.forEach(toast => {
      var closeBtn = toast.querySelector(".close-toast");

      // Açılma efekti (yukarıdan kayarak)
      setTimeout(() => {
      toast.style.opacity = "1";
      toast.style.transform = "translateY(0)";
      }, 200);

      // 10 saniye sonra kaybolsun
      setTimeout(() => {
      toast.style.opacity = "0";
      toast.style.transform = "translateY(20px)";
      setTimeout(() => toast.remove(), 500);
      }, 10000);

      // Kullanıcı kapatırsa hemen kaybolsun
      closeBtn.addEventListener("click", function () {
      toast.style.opacity = "0";
      toast.style.transform = "translateY(20px)";
      setTimeout(() => toast.remove(), 500);
      });
    });
    });
  </script>

  <style>
    .toast-message {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: auto;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
    padding: 15px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    z-index: 99999;
    }

    .toast-content {
    display: flex;
    align-items: center;
    gap: 10px;
    }

    .toast-icon {
    width: 24px;
    height: 24px;
    }

    .toast-text {
    font-size: 16px;
    font-weight: 500;
    }

    .close-toast {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    transition: color 0.3s;
    }

    .close-toast:hover {
    color: #000;
    }

   

  

   
   

  </style>
@endif
