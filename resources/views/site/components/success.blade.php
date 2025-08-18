@if (session('success') || session('warning'))
    @if (session('success'))
    <div class="toast-message toast-success">
      <img src="{{ asset('site/assets/img/success.svg') }}" alt="Success Icon" class="toast-icon">
      <span class="toast-text">{{ session('success') }}</span>
      <button class="close-toast" aria-label="Kapat">&times;</button>
    </div>
    @endif

      @if (session('warning'))
      <div class="toast-message toast-warning">
      <img src="{{ asset('site/assets/img/warning.svg') }}" alt="Warning Icon" class="toast-icon">
      <span class="toast-text">{{ session('warning') }}</span>
      <button class="close-toast" aria-label="Kapat">&times;</button>
      </div>
    @endif

      <script>
        document.addEventListener("DOMContentLoaded", function () {
        const toasts = document.querySelectorAll(".toast-message");
        toasts.forEach((toast, i) => {
          const closeBtn = toast.querySelector(".close-toast");

          setTimeout(() => {
          toast.style.opacity = "1";
          toast.style.transform = "translateY(0)";
          }, 100 + i * 80);

          const hide = () => {
          toast.style.opacity = "0";
          toast.style.transform = "translateY(20px)";
          setTimeout(() => toast.remove(), 450);
          };

          setTimeout(hide, 10000);

          if (closeBtn) closeBtn.addEventListener("click", hide);
        });
        });
      </script>

      <style>
        .toast-message {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: grid;
        grid-template-columns: 24px 1fr auto;
        align-items: center;
        gap: 12px;
        padding: 14px 16px 14px 14px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.25);
        z-index: 99999;
        max-width: min(92vw, 480px);
        box-sizing: border-box;
        backdrop-filter: blur(15px) saturate(180%);
        -webkit-backdrop-filter: blur(15px) saturate(180%);
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.45s ease, transform 0.45s ease;

        background: linear-gradient(120deg, rgba(255, 255, 255, 0.35), rgba(255, 255, 255, 0.15));
        color: #1f2937;
        }

        .toast-icon {
        width: 24px;
        height: 24px;
        object-fit: contain;
        }

        .toast-text {
        font-size: 15px;
        font-weight: 600;
        line-height: 1.25;
        word-break: break-word;
        color: inherit;
        }

        .close-toast {
        appearance: none;
        border: 0;
        background: transparent;
        font-size: 20px;
        line-height: 1;
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

        .toast-message+.toast-message {
        margin-top: 12px;
        }

        /* Tema uyumu */
        @media (prefers-color-scheme: dark) {
        .toast-message {
          background: linear-gradient(120deg, rgba(30, 30, 30, 0.6), rgba(0, 0, 0, 0.4));
          border-color: rgba(255, 255, 255, 0.2);
          color: #f3f4f6;
        }

        .toast-text {
          color: #f3f4f6;
        }
        }

        /* Tip renkleri */
        .toast-success {
        border-left: 5px solid #22c55e;
        }

        .toast-warning {
        border-left: 5px solid #facc15;
        }

        @media (prefers-reduced-motion: reduce) {
        .toast-message {
          transition: none;
        }
        }
    </style>
@endif
