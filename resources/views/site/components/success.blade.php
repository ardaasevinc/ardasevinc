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
      const toasts = document.querySelectorAll(".toast-message");
      toasts.forEach((toast, i) => {
        const closeBtn = toast.querySelector(".close-toast");

        // Açılış
        setTimeout(() => {
        toast.style.opacity = "1";
        toast.style.transform = "translateY(0)";
        }, 100 + i * 80); // birden fazla toasta ufak gecikme

        // Otomatik kapanış
        const hide = () => {
        toast.style.opacity = "0";
        toast.style.transform = "translateY(20px)";
        setTimeout(() => toast.remove(), 450);
        };
        setTimeout(hide, 10000);

        // Kapat butonu güvenli bağlama
        if (closeBtn) {
        closeBtn.addEventListener("click", hide);
        }
      });
      });

    </script>

    <style>
      .toast-message {
      position: fixed;
      bottom: 20px;
      right: 20px;
      /* Cam efekti */
      background: linear-gradient(120deg,
        rgba(255, 255, 255, 0.35),
        rgba(255, 255, 255, 0.15));
      backdrop-filter: blur(15px) saturate(180%);
      -webkit-backdrop-filter: blur(15px) saturate(180%);

      /* Grid yerleşim: ikon | metin | kapat */
      display: grid;
      grid-template-columns: 24px 1fr auto;
      align-items: center;
      gap: 12px;

      /* Kalan stiller */
      padding: 14px 16px 14px 14px;
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, 0.45);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
      z-index: 99999;

      opacity: 0;
      transform: translateY(30px);
      transition: opacity .45s ease, transform .45s ease;
      /* Metin/ikon taşmalarını engelle */
      max-width: min(92vw, 480px);
      box-sizing: border-box;
      }

      .toast-icon {
      width: 24px;
      height: 24px;
      display: block;
      object-fit: contain;
      /* SVG/PNG fark etmez, kaymaz */
      }

      .toast-text {
      margin: 0;
      /* grid’de fazladan boşluk olmasın */
      line-height: 1.25;
      /* dikey hizayı sabitler */
      font-size: 15px;
      font-weight: 600;
      color: #1f2937;
      /* #222 yerine daha nötr koyu gri */
      word-break: break-word;
      /* uzun metin taşmasın */
      }

      .close-toast {
      appearance: none;
      border: 0;
      background: transparent;
      font-size: 20px;
      line-height: 1;
      /* hizalama için kritik */
      cursor: pointer;
      padding: 2px 4px;
      border-radius: 10px;
      opacity: .7;
      transition: opacity .2s ease, transform .15s ease;
      }

      .close-toast:hover {
      opacity: 1;
      transform: scale(1.05);
      }

      /* Birden fazla toast üst üste gelsin, kaymasın */
      .toast-message+.toast-message {
      margin-top: 12px;
      }

      /* Erişilebilirlik: animasyonu azalt */
      @media

    </style>
@endif
