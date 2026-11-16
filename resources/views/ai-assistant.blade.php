{{-- ============================================================
     WEATHERLIVE-GRID · DRAGGABLE FLOATING AI ASSISTANT v6.0
     Pop-Up Mengambang yang Bisa Ditarik-Tarik (Fully Draggable)
     Pixel-Perfect Studio AI Interface · BMKG & Open-Meteo Verified
     ============================================================ --}}
<div id="wl-ai" v-cloak>

  {{-- 1. DRAGGABLE FLOATING CHAT POPUP WINDOW --}}
  <transition name="ai-pop">
    <div
      v-if="open && !minimized"
      class="ai-float-window"
      :class="{'is-dragging': isDragging, 'is-expanded': isExpanded}"
      :style="panelStyle"
      ref="panelRef"
      role="dialog"
      aria-modal="false"
      aria-label="Weather AI Assistant Draggable Window"
    >
      {{-- DRAGGABLE HEADER (DRAG HANDLE) --}}
      <div class="ai-float-header" @mousedown="startDrag" @dblclick="resetPosition" @touchstart="startDragTouch" title="Klik dan tahan untuk menarik posisi pop-up">
        <div class="ai-header-drag-hint">
          <i class="fas fa-grip-vertical"></i>
        </div>
        <div class="ai-header-brand">
          <div class="ai-avatar-badge">
            <i class="fas fa-brain"></i>
            <span class="ai-online-dot"></span>
          </div>
          <div>
            <div class="ai-title-row">
              <span class="ai-title-text">Weather AI Assistant</span>
              <span class="ai-pro-badge">⚡ BMKG Pro</span>
              <span class="ai-drag-label"><i class="fas fa-arrows-up-down-left-right"></i> Drag</span>
            </div>
            <div class="ai-status-sub">
              <span class="ai-pulse-dot"></span>
              <span>Online · Asisten Cerdas Real-Time Jawa Barat</span>
            </div>
          </div>
        </div>

        <div class="ai-window-controls" @mousedown.stop @touchstart.stop>
          <button class="ai-wbtn" @click="exportChat" v-if="history.length > 1" title="Unduh Transkrip Chat (.txt)">
            <i class="fas fa-file-arrow-down"></i>
          </button>
          <button class="ai-wbtn" @click="clearChat" v-if="history.length > 1" title="Hapus riwayat chat">
            <i class="fas fa-trash-alt"></i>
          </button>
          <button class="ai-wbtn" @click="toggleExpand" :title="isExpanded ? 'Ukuran normal' : 'Perbesar jendela'">
            <i class="fas" :class="isExpanded ? 'fa-compress-alt' : 'fa-expand-alt'"></i>
          </button>
          <button class="ai-wbtn" @click="minimize" title="Perkecil ke floating pill">
            <i class="fas fa-minus"></i>
          </button>
          <button class="ai-wbtn ai-wbtn-close" @click="close" title="Tutup pop-up">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>

      {{-- LIVE ATMOSPHERIC CONTEXT STRIP --}}
      <div class="ai-context-strip">
        <div class="ai-ctx-item"><i class="fas fa-location-dot"></i> @{{ ctxLocation }}</div>
        <span class="ai-ctx-dot">·</span>
        <div class="ai-ctx-item"><i class="fas fa-temperature-half"></i> @{{ ctxTemp }}°C</div>
        <span class="ai-ctx-dot">·</span>
        <div class="ai-ctx-item"><i class="fas fa-cloud-sun"></i> @{{ ctxCond }}</div>
        <button class="ai-ctx-sync-btn" @click="fetchCtx" title="Sinkronkan data cuaca">
          <i class="fas fa-rotate" :class="{'fa-spin': syncingCtx}"></i> SYNC
        </button>
      </div>

      {{-- QUICK CATEGORY CHIPS BAR --}}
      <div class="ai-category-strip">
        <button class="ai-cat-pill" @click="sendQuick('Bagaimana ringkasan kondisi cuaca dan parameter atmosfer di ' + ctxLocation + ' saat ini?')">
          🌧️ Cuaca Realtime
        </button>
        <button class="ai-cat-pill" @click="sendQuick('Rekomendasikan outfit dan pakaian yang cocok untuk kondisi cuaca ' + ctxCond + ' dengan suhu ' + ctxTemp + '°C di ' + ctxLocation + '.')">
          👕 Outfit AI
        </button>
        <button class="ai-cat-pill" @click="sendQuick('Apakah kondisi cuaca saat ini aman dan nyaman untuk olahraga outdoor atau lari pagi?')">
          🏃 Olahraga
        </button>
        <button class="ai-cat-pill" @click="sendQuick('Apakah ada peringatan dini cuaca ekstrem atau potensi bencana BMKG untuk wilayah Jawa Barat hari ini?')">
          ⚠️ BMKG Alert
        </button>
        <button class="ai-cat-pill" @click="sendQuick('Rekomendasikan destinasi wisata dan panduan aktivitas luar ruangan yang cocok dengan cuaca hari ini.')">
          🗺️ Wisata
        </button>
      </div>

      {{-- MESSAGES CHAT BODY --}}
      <div class="ai-chat-scroll" ref="bodyRef">
        {{-- Message Stream --}}
        <div v-for="(msg, i) in history" :key="i" class="ai-message-row" :class="msg.role">
          <div class="ai-msg-icon" v-if="msg.role === 'ai'">
            <i class="fas fa-brain"></i>
          </div>

          <div class="ai-bubble-container">
            <div class="ai-chat-bubble" :class="msg.role">
              <div v-if="msg.error" class="ai-error-box">
                <i class="fas fa-circle-exclamation"></i> @{{ msg.text }}
              </div>
              <div v-else v-html="render(msg.text)"></div>

              {{-- Embedded Weather Card --}}
              <div v-if="msg.card" class="ai-inline-card">
                <div class="ai-card-top">
                  <div>
                    <div class="ai-card-city">@{{ msg.card.city }}</div>
                    <div class="ai-card-desc">@{{ msg.card.condition }}</div>
                  </div>
                  <div class="ai-card-temp">@{{ msg.card.temp }}°C</div>
                </div>
                <div class="ai-card-metrics">
                  <span><i class="fas fa-droplet"></i> @{{ msg.card.humidity }}%</span>
                  <span><i class="fas fa-wind"></i> @{{ msg.card.wind }} m/s</span>
                  <span><i class="fas fa-umbrella"></i> @{{ msg.card.rain ? 'Hujan' : 'Kering' }}</span>
                </div>
              </div>
            </div>

            <div class="ai-bubble-foot">
              <span>@{{ msg.time }}</span>
              <button v-if="msg.role === 'ai' && !msg.error" class="ai-copy-action" @click="copy(msg.text)" title="Salin jawaban">
                <i class="fas fa-copy"></i>
              </button>
              <button v-if="msg.role === 'ai' && !msg.error" class="ai-copy-action" @click="speakText(msg.text)" title="Dengarkan Suara (TTS)">
                <i class="fas fa-volume-high"></i>
              </button>
              <span v-if="msg.provider" class="ai-provider-badge">@{{ msg.provider }}</span>
            </div>
          </div>

          <div class="ai-msg-icon user" v-if="msg.role === 'user'">
            <i class="fas fa-user"></i>
          </div>
        </div>

        {{-- Typing Animated Bubble --}}
        <div v-if="typing" class="ai-message-row ai">
          <div class="ai-msg-icon"><i class="fas fa-brain"></i></div>
          <div class="ai-chat-bubble ai">
            <div class="ai-typing-indicator">
              <div class="ai-dots"><span></span><span></span><span></span></div>
              <span class="ai-typing-text">@{{ typingLabel }}</span>
            </div>
          </div>
        </div>
      </div>

      {{-- QUICK QUESTIONS CHIPS BAR --}}
      <div class="ai-quick-scroll">
        <div class="ai-quick-label">⚡ PERTANYAAN POPULER</div>
        <div class="ai-quick-chips">
          <button class="ai-mini-chip" v-for="s in suggestions" :key="s" @click="sendQuick(s)">
            @{{ s }}
          </button>
        </div>
      </div>

      {{-- INPUT DOCK --}}
      <div class="ai-dock-row">
        <div class="ai-input-wrapper">
          <i class="fas fa-comment-dots ai-input-left-icon"></i>
          <input
            type="text"
            v-model="query"
            @keydown.enter="send"
            :disabled="typing"
            placeholder="Ketik pertanyaan cuaca, outfit, atau destinasi..."
            class="ai-dock-input"
            ref="inputRef"
            autocomplete="off"
          />
          <button class="ai-mic-action" @click="voiceInput" :class="{active: listening}" title="Input Suara">
            <i class="fas" :class="listening ? 'fa-microphone-slash' : 'fa-microphone'"></i>
          </button>
        </div>
        <button class="ai-dock-send" @click="send" :disabled="!query.trim() || typing" title="Kirim Pesan">
          <i class="fas fa-paper-plane"></i>
        </button>
      </div>

      {{-- WINDOW FOOTER --}}
      <div class="ai-window-foot">
        <div class="ai-foot-hint"><i class="fas fa-shield-check"></i> WeatherLive-Grid AI × BMKG Data Engine</div>
        <div class="ai-drag-footer-note">Enkripsi Cerdas · Drag Header untuk Memindahkan</div>
      </div>
    </div>
  </transition>

  {{-- 2. MINIMIZED DRAGGABLE PILL --}}
  <transition name="ai-pill">
    <div
      v-if="open && minimized"
      class="ai-minimized-pill"
      :style="pillStyle"
      @mousedown="startDragPill"
      @touchstart="startDragPillTouch"
      @click="onPillClick"
      title="Klik untuk membuka kembali, atau drag untuk memindahkan"
    >
      <div class="ai-pill-dot"><i class="fas fa-brain"></i><span class="ai-pill-pulse"></span></div>
      <div class="ai-pill-info">
        <div class="ai-pill-name">Weather AI</div>
        <div class="ai-pill-tip">Klik / Drag</div>
      </div>
      <button class="ai-pill-btn-close" @click.stop="close" title="Tutup"><i class="fas fa-times"></i></button>
    </div>
  </transition>

  {{-- 3. FIXED FLOATING FAB BUTTON (TOGGLE) --}}
  <div class="ai-fab-container">
    <div class="ai-fab-badge" v-if="unread > 0 && !open">@{{ unread > 9 ? '9+' : unread }}</div>
    <button
      class="ai-fab-capsule ai-floating-capsule"
      data-open-ai
      :class="{active: open}"
      @click="toggle"
      title="Buka / Tutup AI Weather Assistant"
      aria-label="AI Weather Assistant"
    >
      <div class="ai-fab-icon-wrap">
        <i class="fas fa-brain" v-if="!open"></i>
        <i class="fas fa-times" v-else></i>
        <span class="ai-fab-online-dot" v-if="!open"></span>
      </div>
      <span class="ai-fab-label" v-if="!open">
        <span class="ai-fab-label-main">AI Assistant</span>
        <span class="ai-fab-label-sub">Tanya Cuaca</span>
      </span>
      <span class="ai-fab-glow"></span>
    </button>
  </div>

</div>

<script>
(function() {
  function mountAiAssistant() {
    var el = document.getElementById('wl-ai');
    if (!el || el.__vue_app__) return;

    if (typeof Vue === 'undefined') {
      setTimeout(mountAiAssistant, 50);
      return;
    }

    var _Vue = Vue;
    var createApp = _Vue.createApp;
    var ref = _Vue.ref;
    var computed = _Vue.computed;
    var onMounted = _Vue.onMounted;
    var nextTick = _Vue.nextTick;

    createApp({
      setup: function() {
        var open        = ref(false);
        var minimized   = ref(false);
        var isExpanded  = ref(false);
        var isDragging  = ref(false);
        var typing      = ref(false);
        var syncingCtx  = ref(false);
        var query       = ref('');
        var history     = ref([]);
        var unread      = ref(1);
        var listening   = ref(false);
        var bodyRef     = ref(null);
        var inputRef    = ref(null);
        var panelRef    = ref(null);

        // Window Coordinates
        var posX = ref(null);
        var posY = ref(null);
        var dragStartX = 0;
        var dragStartY = 0;
        var initPosX   = 0;
        var initPosY   = 0;

        // Pill Coordinates
        var pillX = ref(null);
        var pillY = ref(null);
        var pillDragStartX = 0;
        var pillDragStartY = 0;
        var pillInitPosX   = 0;
        var pillInitPosY   = 0;
        var isPillDragged  = false;

        // Context
        var ctxLocation = ref('Bandung, Jawa Barat');
        var ctxTemp     = ref(28);
        var ctxCond     = ref('Cerah Berawan');

        // Rotating typing labels
        var typingIdx = ref(0);
        var typingLabels = [
          'Menganalisis data atmosfer Jawa Barat...',
          'Membaca sensor BMKG & Open-Meteo...',
          'Menyusun rekomendasi cuaca cerdas...',
          'Memverifikasi parameter mikroklimat...',
        ];
        var typingLabel = computed(function() { return typingLabels[typingIdx.value % typingLabels.length]; });
        var typingTimer = null;

        var suggestions = [
          'Bagaimana cuaca di Bandung sekarang?',
          'Rekomendasi outfit untuk cuaca hari ini.',
          'Apakah aman untuk berkendara ke Lembang?',
          'Prakiraan cuaca 7 hari ke depan.',
          'Apakah cuaca cocok untuk mendaki gunung?',
          'Bandingkan cuaca Jakarta dan Bandung.',
        ];

        // Dynamic style for draggable panel
        var panelStyle = computed(function() {
          if (posX.value === null || posY.value === null) {
            return {
              position: 'fixed',
              bottom: '96px',
              right: '28px',
            };
          }
          return {
            position: 'fixed',
            left: posX.value + 'px',
            top: posY.value + 'px',
            bottom: 'auto',
            right: 'auto',
          };
        });

        // Dynamic style for draggable pill
        var pillStyle = computed(function() {
          if (pillX.value === null || pillY.value === null) {
            return {
              position: 'fixed',
              bottom: '96px',
              right: '28px',
            };
          }
          return {
            position: 'fixed',
            left: pillX.value + 'px',
            top: pillY.value + 'px',
            bottom: 'auto',
            right: 'auto',
          };
        });

        function nowTime() {
          return new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        }

        function scrollBottom() {
          nextTick(function() {
            if (bodyRef.value) {
              bodyRef.value.scrollTo({ top: bodyRef.value.scrollHeight, behavior: 'smooth' });
            }
          });
        }

        function startCycle() {
          typingIdx.value = 0;
          typingTimer = setInterval(function() { typingIdx.value++; }, 1500);
        }
        function stopCycle() { if (typingTimer) clearInterval(typingTimer); }

        function render(text) {
          if (!text) return '';
          var t = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

          // Markdown tables
          t = t.replace(/(?:^|\n)(\|.+?\|\n\|(?:\s*:?-+:?\s*\|)+\n(?:\|.+?\|\n?)+)/g, function(match, tableText) {
            var lines = tableText.trim().split('\n');
            if (lines.length < 3) return match;
            var html = '<div class="ai-table-wrap"><table class="ai-render-table">';
            var headers = lines[0].split('|').slice(1, -1);
            html += '<thead><tr>';
            headers.forEach(function(h) { html += '<th>' + h.trim() + '</th>'; });
            html += '</tr></thead><tbody>';
            for (var r = 2; r < lines.length; r++) {
              var cells = lines[r].split('|').slice(1, -1);
              if (cells.length) {
                html += '<tr>';
                cells.forEach(function(c) { html += '<td>' + c.trim() + '</td>'; });
                html += '</tr>';
              }
            }
            html += '</tbody></table></div>';
            return '\n' + html + '\n';
          });

          // Links [label](url)
          t = t.replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2" class="ai-render-link" target="_blank" rel="noopener">$1</a>');

          // Horizontal rule
          t = t.replace(/(?:^|\n)---\n/g, '<hr class="ai-render-hr">');

          // Inline code `code`
          t = t.replace(/`([^`]+)`/g, '<code class="ai-inline-code">$1</code>');

          // Headings
          t = t.replace(/^### (.*?)$/gm, '<h4 class="ai-render-h">$1</h4>');
          t = t.replace(/^## (.*?)$/gm, '<h3 class="ai-render-h2">$1</h3>');

          // Bold & italic
          t = t.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
          t = t.replace(/\*(.*?)\*/g, '<em>$1</em>');

          // Bullets
          t = t.replace(/^- (.*?)$/gm, '<div class="ai-render-li"><span class="ai-bullet">•</span><span>$1</span></div>');

          // Newlines
          t = t.replace(/\n\n+/g, '<div class="ai-render-p-gap"></div>');
          t = t.replace(/\n/g, '<br>');

          return t;
        }

        function resetPosition() {
          posX.value = null;
          posY.value = null;
          if (window.showToast) window.showToast('AI Assistant', 'Posisi jendela dikembalikan ke sudut default', 'info');
        }

        function fetchCtx() {
          syncingCtx.value = true;
          fetch('/api/ai/context')
            .then(function(r) { return r.json(); })
            .then(function(d) {
              syncingCtx.value = false;
              if (d.success) {
                ctxLocation.value = d.location || ctxLocation.value;
                ctxTemp.value     = d.temp != null ? d.temp : ctxTemp.value;
                ctxCond.value     = d.condition || ctxCond.value;
              }
            })
            .catch(function() {
              syncingCtx.value = false;
            });
        }

        function buildWelcomeMessage() {
          var h = new Date().getHours();
          var greet = h < 5 ? 'Selamat dini hari' : h < 12 ? 'Selamat pagi' : h < 15 ? 'Selamat siang' : h < 18 ? 'Selamat sore' : 'Selamat malam';
          return '**' + greet + '!** ☀️ Saya **Weather AI Assistant** WeatherLive-Grid.\n\n📍 **' + ctxLocation.value + '**: ' + ctxCond.value + ', temperatur saat ini **' + ctxTemp.value + '°C**.\n\nPop-up ini bisa **Anda geser / tarik ke mana saja** di layar. Ada yang ingin Anda rencanakan atau ketahui hari ini? 😊';
        }

        function send() {
          var q = query.value.trim();
          if (!q || typing.value) return;

          history.value.push({ role: 'user', text: q, time: nowTime() });
          query.value = '';
          typing.value = true;
          startCycle();
          scrollBottom();

          var ctx = history.value.slice(-13, -1).map(function(m) {
            return { role: m.role === 'user' ? 'user' : 'assistant', content: m.text };
          });

          var csrfMeta = document.querySelector('meta[name="csrf-token"]');
          var csrf = csrfMeta ? csrfMeta.content : '';

          var controller = new AbortController();
          var timeoutId = setTimeout(function() { controller.abort(); }, 25000);

          fetch('/api/ai/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
            body: JSON.stringify({ message: q, history: ctx, location: ctxLocation.value }),
            signal: controller.signal,
          })
          .then(function(res) {
            clearTimeout(timeoutId);
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.json();
          })
          .then(function(data) {
            stopCycle();
            typing.value = false;
            if (!data.success) throw new Error(data.message || 'Server error');
            var replyText = data.reply || '';
            history.value.push({
              role: 'ai',
              text: '',
              time: nowTime(),
              card: data.weatherCard || null,
              provider: data.mode === 'llm' ? (data.provider || null) : 'WeatherLive AI Engine',
            });
            var idx = history.value.length - 1;
            var ci = 0;
            var chunkSize = Math.max(3, Math.ceil(replyText.length / 50));
            var streamer = setInterval(function() {
              if (ci < replyText.length) {
                history.value[idx].text += replyText.slice(ci, ci + chunkSize);
                ci += chunkSize;
                scrollBottom();
              } else {
                clearInterval(streamer);
                history.value[idx].text = replyText;
                scrollBottom();
              }
            }, 16);
          })
          .catch(function(e) {
            clearTimeout(timeoutId);
            stopCycle();
            typing.value = false;
            var errMsg = e.name === 'AbortError'
              ? 'Permintaan melebihi batas waktu. Periksa koneksi Anda.'
              : 'Gagal terhubung ke AI: ' + e.message;
            history.value.push({ role: 'ai', text: errMsg, time: nowTime(), error: true });
            scrollBottom();
          });
        }

        function sendQuick(txt) {
          query.value = txt;
          send();
        }

        function clearChat() {
          history.value = [{
            role: 'ai',
            text: buildWelcomeMessage(),
            time: nowTime(),
            provider: 'WeatherLive Atmospheric AI'
          }];
        }

        // ==========================================
        // DRAG & DROP LOGIC (PIXEL-PERFECT, NO JUMP)
        // ==========================================
        function initPositionIfNeeded() {
          if (panelRef.value && (posX.value === null || posY.value === null)) {
            var rect = panelRef.value.getBoundingClientRect();
            posX.value = rect.left;
            posY.value = rect.top;
          }
        }

        function startDrag(e) {
          if (e.button !== 0) return;
          if (e.target.closest('.ai-window-controls') || e.target.closest('button')) return;
          e.preventDefault();
          initPositionIfNeeded();
          isDragging.value = true;
          dragStartX = e.clientX;
          dragStartY = e.clientY;
          initPosX = posX.value;
          initPosY = posY.value;

          document.addEventListener('mousemove', onDragMove);
          document.addEventListener('mouseup', onDragEnd);
        }

        function onDragMove(e) {
          if (!isDragging.value) return;
          var deltaX = e.clientX - dragStartX;
          var deltaY = e.clientY - dragStartY;
          var newX = initPosX + deltaX;
          var newY = initPosY + deltaY;

          var elW = panelRef.value ? panelRef.value.offsetWidth : (isExpanded.value ? 560 : 420);
          newX = Math.max(8, Math.min(newX, window.innerWidth - elW - 8));
          newY = Math.max(8, Math.min(newY, window.innerHeight - 80));

          posX.value = newX;
          posY.value = newY;
        }

        function onDragEnd() {
          isDragging.value = false;
          document.removeEventListener('mousemove', onDragMove);
          document.removeEventListener('mouseup', onDragEnd);
        }

        function startDragTouch(e) {
          if (e.touches.length !== 1) return;
          if (e.target.closest('.ai-window-controls') || e.target.closest('button')) return;
          initPositionIfNeeded();
          isDragging.value = true;
          dragStartX = e.touches[0].clientX;
          dragStartY = e.touches[0].clientY;
          initPosX = posX.value;
          initPosY = posY.value;

          document.addEventListener('touchmove', onDragMoveTouch, { passive: false });
          document.addEventListener('touchend', onDragEndTouch);
        }

        function onDragMoveTouch(e) {
          if (!isDragging.value || e.touches.length !== 1) return;
          e.preventDefault();
          var deltaX = e.touches[0].clientX - dragStartX;
          var deltaY = e.touches[0].clientY - dragStartY;
          var newX = initPosX + deltaX;
          var newY = initPosY + deltaY;

          var elW = panelRef.value ? panelRef.value.offsetWidth : (isExpanded.value ? 560 : 420);
          newX = Math.max(8, Math.min(newX, window.innerWidth - elW - 8));
          newY = Math.max(8, Math.min(newY, window.innerHeight - 80));

          posX.value = newX;
          posY.value = newY;
        }

        function onDragEndTouch() {
          isDragging.value = false;
          document.removeEventListener('touchmove', onDragMoveTouch);
          document.removeEventListener('touchend', onDragEndTouch);
        }

        // Pill dragging with click protection
        function startDragPill(e) {
          if (e.button !== 0) return;
          isPillDragged = false;
          if (pillX.value === null) {
            pillX.value = window.innerWidth - 180;
            pillY.value = window.innerHeight - 150;
          }
          pillDragStartX = e.clientX;
          pillDragStartY = e.clientY;
          pillInitPosX = pillX.value;
          pillInitPosY = pillY.value;

          function onPillMove(ev) {
            if (Math.abs(ev.clientX - pillDragStartX) > 4 || Math.abs(ev.clientY - pillDragStartY) > 4) {
              isPillDragged = true;
            }
            pillX.value = Math.max(10, Math.min(pillInitPosX + (ev.clientX - pillDragStartX), window.innerWidth - 160));
            pillY.value = Math.max(10, Math.min(pillInitPosY + (ev.clientY - pillDragStartY), window.innerHeight - 60));
          }
          function onPillUp() {
            document.removeEventListener('mousemove', onPillMove);
            document.removeEventListener('mouseup', onPillUp);
          }
          document.addEventListener('mousemove', onPillMove);
          document.addEventListener('mouseup', onPillUp);
        }

        function startDragPillTouch(e) {
          if (e.touches.length !== 1) return;
          isPillDragged = false;
          if (pillX.value === null) {
            pillX.value = window.innerWidth - 180;
            pillY.value = window.innerHeight - 150;
          }
          pillDragStartX = e.touches[0].clientX;
          pillDragStartY = e.touches[0].clientY;
          pillInitPosX = pillX.value;
          pillInitPosY = pillY.value;

          function onPillTouchMove(ev) {
            if (Math.abs(ev.touches[0].clientX - pillDragStartX) > 4 || Math.abs(ev.touches[0].clientY - pillDragStartY) > 4) {
              isPillDragged = true;
            }
            pillX.value = Math.max(10, Math.min(pillInitPosX + (ev.touches[0].clientX - pillDragStartX), window.innerWidth - 160));
            pillY.value = Math.max(10, Math.min(pillInitPosY + (ev.touches[0].clientY - pillDragStartY), window.innerHeight - 60));
          }
          function onPillTouchEnd() {
            document.removeEventListener('touchmove', onPillTouchMove);
            document.removeEventListener('touchend', onPillTouchEnd);
          }
          document.addEventListener('touchmove', onPillTouchMove, { passive: false });
          document.addEventListener('touchend', onPillTouchEnd);
        }

        function onPillClick() {
          if (isPillDragged) {
            isPillDragged = false;
            return;
          }
          restore();
        }

        function openPanel() {
          open.value = true;
          minimized.value = false;
          unread.value = 0;

          if (history.value.length === 0) {
            history.value.push({
              role: 'ai',
              text: buildWelcomeMessage(),
              time: nowTime(),
              provider: 'WeatherLive Atmospheric AI'
            });
          }
          nextTick(function() {
            scrollBottom();
            if (inputRef.value) inputRef.value.focus();
          });
        }

        function toggle()       { open.value ? close() : openPanel(); }
        function close()        { open.value = false; minimized.value = false; }
        function minimize()     { minimized.value = true; }
        function toggleExpand() { isExpanded.value = !isExpanded.value; }
        function restore()      {
          minimized.value = false;
          nextTick(function() {
            scrollBottom();
            if (inputRef.value) inputRef.value.focus();
          });
        }

        function copy(text) {
          var plain = (text || '').replace(/<[^>]*>/g, '').replace(/\*\*(.*?)\*\*/g, '$1');
          if (navigator.clipboard) navigator.clipboard.writeText(plain);
          if (window.showToast) window.showToast('AI Assistant', 'Jawaban berhasil disalin ✓', 'success');
        }

        function speakText(text) {
          if (!window.speechSynthesis) {
            if (window.showToast) window.showToast('Fitur Suara', 'Browser belum mendukung Text-to-Speech.', 'info');
            return;
          }
          window.speechSynthesis.cancel();
          var plain = (text || '').replace(/<[^>]*>/g, '').replace(/[*_#`]/g, '');
          var utterance = new SpeechSynthesisUtterance(plain);
          utterance.lang = 'id-ID';
          utterance.rate = 1.05;
          window.speechSynthesis.speak(utterance);
        }

        function exportChat() {
          var lines = history.value.map(function(m) {
            var sender = m.role === 'user' ? 'Anda (User)' : 'Weather AI BMKG';
            var plain = (m.text || '').replace(/<[^>]*>/g, '').replace(/[*_#`]/g, '');
            return '[' + m.time + '] ' + sender + ':\n' + plain + '\n';
          }).join('\n========================================\n\n');
          var blob = new Blob([lines], { type: 'text/plain;charset=utf-8' });
          var url = URL.createObjectURL(blob);
          var a = document.createElement('a');
          a.href = url;
          a.download = 'WeatherLive-AI-Chat-' + new Date().toISOString().slice(0, 10) + '.txt';
          a.click();
          if (window.showToast) window.showToast('AI Assistant', 'Transkrip chat berhasil diunduh ✓', 'success');
        }

        function voiceInput() {
          var SR = window.SpeechRecognition || window.webkitSpeechRecognition;
          if (!SR) {
            if (window.showToast) window.showToast('Fitur Suara', 'Browser Anda belum mendukung input suara web.', 'info');
            return;
          }
          var r = new SR();
          r.lang = 'id-ID';
          r.onstart  = function() { listening.value = true; };
          r.onend    = function() { listening.value = false; };
          r.onerror  = function() { listening.value = false; };
          r.onresult = function(e) {
            query.value = e.results[0][0].transcript;
            listening.value = false;
            send();
          };
          r.start();
        }

        function onKeydown(e) {
          if ((e.ctrlKey || e.metaKey) && e.key === '/') {
            e.preventDefault();
            toggle();
          }
          if (e.key === 'Escape' && open.value && !minimized.value) {
            close();
          }
        }

        onMounted(function() {
          fetchCtx();
          document.addEventListener('keydown', onKeydown);

          window.openAiAssistant   = openPanel;
          window.closeAiAssistant  = close;
          window.toggleAiAssistant = toggle;

          var urlParams = new URLSearchParams(window.location.search);
          if (urlParams.get('open_ai') === '1') {
            setTimeout(function() {
              openPanel();
              try {
                var cleanUrl = window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);
              } catch(e) {}
            }, 250);
          }
        });

        return {
          open, minimized, isExpanded, isDragging, typing, syncingCtx, query, history, unread, listening,
          bodyRef, inputRef, panelRef, ctxLocation, ctxTemp, ctxCond,
          typingLabel, suggestions, panelStyle, pillStyle,
          toggle, close, minimize, restore, toggleExpand, onPillClick,
          startDrag, startDragTouch, startDragPill, startDragPillTouch,
          send, sendQuick, clearChat, copy, speakText, exportChat, voiceInput, render, fetchCtx, resetPosition,
        };
      }
    }).mount('#wl-ai');
  }

  // Safe mounting for all browsers & document ready states
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mountAiAssistant);
  } else {
    mountAiAssistant();
  }

  // Global event delegation for modal triggers (FAB, quick buttons)
  document.addEventListener('click', function(e) {
    var trigger = e.target.closest('[data-open-ai], .open-ai-trigger');
    if (trigger && !trigger.closest('#wl-ai')) {
      e.preventDefault();
      if (window.openAiAssistant) {
        window.openAiAssistant();
      } else {
        var fab = document.querySelector('.ai-fab-capsule');
        if (fab) fab.click();
      }
    }
  });
})();
</script>

<style>
#wl-ai {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  -webkit-font-smoothing: antialiased;
  --ai-win-bg:      rgba(10, 22, 42, 0.95);
  --ai-header-bg:   rgba(14, 28, 54, 0.98);
  --ai-surface:     rgba(17, 36, 68, 0.85);
  --ai-border:      rgba(56, 189, 248, 0.22);
  --ai-text-main:   #f1f5f9;
  --ai-text-muted:  #94a3b8;
  --ai-accent:      #38bdf8;
  --ai-user-grad:   linear-gradient(135deg, #1d4ed8, #0284c7);
  --ai-shadow:      0 24px 70px rgba(0, 0, 0, 0.75), 0 0 0 1px rgba(56, 189, 248, 0.25);
}

/* DRAGGABLE FLOATING WINDOW */
.ai-float-window {
  position: fixed;
  width: 420px;
  max-width: calc(100vw - 20px);
  height: 590px;
  max-height: 84vh;
  display: flex;
  flex-direction: column;
  background: var(--ai-win-bg);
  backdrop-filter: blur(24px) saturate(180%);
  -webkit-backdrop-filter: blur(24px) saturate(180%);
  border: 1px solid var(--ai-border);
  border-radius: 24px;
  box-shadow: var(--ai-shadow);
  z-index: 999998;
  overflow: hidden;
  user-select: auto;
  transition: width 0.25s, height 0.25s, box-shadow 0.25s;
}

.ai-float-window.is-expanded {
  width: 580px;
  height: 690px;
  max-height: 90vh;
}

.ai-float-window.is-dragging {
  user-select: none;
  cursor: grabbing !important;
  box-shadow: 0 32px 90px rgba(0, 0, 0, 0.9), 0 0 0 2px var(--ai-accent);
  transition: none !important;
  will-change: left, top;
}

@media (max-width: 480px) {
  .ai-float-window {
    width: auto !important;
    left: 8px !important;
    right: 8px !important;
    bottom: 84px !important;
    top: auto !important;
    height: 76vh !important;
    max-height: 76vh !important;
    border-radius: 20px;
  }
}

/* HEADER (DRAG HANDLE) */
.ai-float-header {
  padding: 12px 16px;
  background: var(--ai-header-bg);
  border-bottom: 1px solid var(--ai-border);
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: grab;
  user-select: none;
  flex-shrink: 0;
  transition: background 0.2s;
}
.ai-float-header:active {
  cursor: grabbing;
}
.ai-float-header:hover {
  background: rgba(18, 36, 68, 0.98);
}

.ai-header-drag-hint {
  color: var(--ai-text-muted);
  font-size: 14px;
  opacity: 0.5;
  display: flex;
  align-items: center;
  transition: opacity 0.2s;
}
.ai-float-header:hover .ai-header-drag-hint {
  opacity: 1;
  color: var(--ai-accent);
}

.ai-header-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  flex: 1;
  min-width: 0;
}
.ai-avatar-badge {
  width: 38px;
  height: 38px;
  border-radius: 12px;
  background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 16px;
  position: relative;
  flex-shrink: 0;
  box-shadow: 0 4px 14px rgba(14, 165, 233, 0.4);
}
.ai-online-dot {
  position: absolute;
  bottom: -1px;
  right: -1px;
  width: 10px;
  height: 10px;
  background: #22c55e;
  border-radius: 50%;
  border: 2px solid var(--ai-header-bg);
}

.ai-title-row {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-wrap: nowrap;
}
.ai-title-text {
  font-size: 14px;
  font-weight: 800;
  color: var(--ai-text-main);
  letter-spacing: -0.01em;
  white-space: nowrap;
}
.ai-pro-badge {
  font-size: 9.5px;
  font-weight: 800;
  padding: 2px 7px;
  border-radius: 6px;
  background: rgba(34, 197, 94, 0.15);
  border: 1px solid rgba(34, 197, 94, 0.4);
  color: #4ade80;
  white-space: nowrap;
}
.ai-drag-label {
  font-size: 9.5px;
  font-weight: 700;
  padding: 2px 6px;
  border-radius: 5px;
  background: rgba(56, 189, 248, 0.12);
  color: var(--ai-accent);
  display: inline-flex;
  align-items: center;
  gap: 3px;
  opacity: 0.85;
}
.ai-status-sub {
  font-size: 10.5px;
  color: var(--ai-text-muted);
  display: flex;
  align-items: center;
  gap: 6px;
  margin-top: 1px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.ai-pulse-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #22c55e;
  box-shadow: 0 0 8px #22c55e;
  animation: aiPulse 2s infinite;
  flex-shrink: 0;
}
@keyframes aiPulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.4; transform: scale(0.85); }
}

.ai-window-controls {
  display: flex;
  align-items: center;
  gap: 4px;
  flex-shrink: 0;
}
.ai-wbtn {
  width: 28px;
  height: 28px;
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.08);
  color: var(--ai-text-muted);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  font-size: 11px;
  transition: all 0.2s;
}
.ai-wbtn:hover {
  background: rgba(56, 189, 248, 0.15);
  border-color: var(--ai-accent);
  color: #fff;
}
.ai-wbtn-close:hover {
  background: rgba(239, 68, 68, 0.2);
  border-color: #ef4444;
  color: #ef4444;
}

/* LIVE CONTEXT STRIP */
.ai-context-strip {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 7px 16px;
  background: rgba(8, 16, 30, 0.9);
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  font-size: 11px;
  color: var(--ai-text-muted);
  flex-shrink: 0;
  overflow-x: auto;
  white-space: nowrap;
  scrollbar-width: none;
}
.ai-context-strip::-webkit-scrollbar { display: none; }
.ai-ctx-item {
  display: flex;
  align-items: center;
  gap: 5px;
  font-weight: 600;
  color: var(--ai-text-main);
}
.ai-ctx-item i { color: var(--ai-accent); }
.ai-ctx-dot { color: rgba(255, 255, 255, 0.2); }
.ai-ctx-sync-btn {
  margin-left: auto;
  background: rgba(56, 189, 248, 0.12);
  border: 1px solid rgba(56, 189, 248, 0.35);
  border-radius: 999px;
  color: var(--ai-accent);
  font-size: 10px;
  font-weight: 700;
  padding: 2px 8px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 4px;
  transition: all 0.2s;
}
.ai-ctx-sync-btn:hover {
  background: rgba(56, 189, 248, 0.25);
  color: #fff;
}

/* CATEGORY TOPICS STRIP */
.ai-category-strip {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  background: rgba(10, 20, 38, 0.75);
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
  overflow-x: auto;
  white-space: nowrap;
  flex-shrink: 0;
  scrollbar-width: none;
}
.ai-category-strip::-webkit-scrollbar { display: none; }
.ai-cat-pill {
  display: inline-flex;
  align-items: center;
  padding: 4px 10px;
  border-radius: 999px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  color: rgba(255, 255, 255, 0.85);
  font-size: 11px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  white-space: nowrap;
}
.ai-cat-pill:hover {
  background: rgba(56, 189, 248, 0.18);
  border-color: rgba(56, 189, 248, 0.45);
  color: #fff;
  transform: translateY(-1px);
}

/* MESSAGES CHAT SCROLL */
.ai-chat-scroll {
  flex: 1;
  overflow-y: auto;
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 14px;
  scrollbar-width: thin;
  scrollbar-color: rgba(56, 189, 248, 0.25) transparent;
}
.ai-chat-scroll::-webkit-scrollbar { width: 5px; }
.ai-chat-scroll::-webkit-scrollbar-thumb {
  background: rgba(56, 189, 248, 0.25);
  border-radius: 10px;
}

.ai-message-row {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  animation: aiFadeIn 0.25s ease-out;
}
@keyframes aiFadeIn {
  from { opacity: 0; transform: translateY(8px); }
  to   { opacity: 1; transform: translateY(0); }
}
.ai-message-row.user {
  flex-direction: row-reverse;
}

.ai-msg-icon {
  width: 32px;
  height: 32px;
  border-radius: 10px;
  background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 13px;
  flex-shrink: 0;
  box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
}
.ai-msg-icon.user {
  background: linear-gradient(135deg, #475569, #334155);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

.ai-bubble-container {
  display: flex;
  flex-direction: column;
  max-width: 84%;
}
.ai-message-row.user .ai-bubble-container {
  align-items: flex-end;
}

.ai-chat-bubble {
  padding: 12px 15px;
  border-radius: 18px;
  font-size: 13px;
  line-height: 1.55;
  color: var(--ai-text-main);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
  word-break: break-word;
}
.ai-chat-bubble.ai {
  background: var(--ai-surface);
  border: 1px solid rgba(56, 189, 248, 0.18);
  border-top-left-radius: 4px;
}
.ai-chat-bubble.user {
  background: var(--ai-user-grad);
  border: 1px solid rgba(56, 189, 248, 0.3);
  border-top-right-radius: 4px;
  color: #fff;
}

/* Rich Markdown & Table Formatting */
.ai-table-wrap {
  margin: 10px 0;
  overflow-x: auto;
  border-radius: 12px;
  border: 1px solid rgba(56, 189, 248, 0.25);
  background: rgba(4, 12, 26, 0.7);
}
.ai-render-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 11.5px;
  color: var(--ai-text-main);
  text-align: left;
}
.ai-render-table th {
  background: rgba(14, 165, 233, 0.15);
  color: var(--ai-accent);
  padding: 8px 12px;
  font-weight: 700;
  border-bottom: 1px solid rgba(56, 189, 248, 0.2);
  white-space: nowrap;
}
.ai-render-table td {
  padding: 7px 12px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}
.ai-render-table tr:last-child td {
  border-bottom: none;
}
.ai-render-link {
  color: var(--ai-accent);
  text-decoration: underline;
  font-weight: 600;
  transition: opacity 0.2s;
}
.ai-render-link:hover {
  opacity: 0.8;
}
.ai-render-hr {
  border: none;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  margin: 12px 0 8px;
}
.ai-inline-code {
  background: rgba(14, 165, 233, 0.15);
  color: #7dd3fc;
  padding: 1px 5px;
  border-radius: 4px;
  font-family: monospace;
  font-size: 11px;
}
.ai-render-h2 {
  font-size: 14px;
  font-weight: 800;
  color: #38bdf8;
  margin: 8px 0 4px;
}
.ai-render-p-gap {
  height: 8px;
}

.ai-render-h {
  font-size: 13.5px;
  font-weight: 800;
  color: var(--ai-accent);
  margin-bottom: 6px;
  margin-top: 2px;
}
.ai-render-li {
  display: flex;
  align-items: flex-start;
  gap: 6px;
  margin-bottom: 4px;
}
.ai-bullet {
  color: var(--ai-accent);
  font-weight: 700;
}

.ai-error-box {
  color: #fca5a5;
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
}

/* Embedded Weather Card in Chat */
.ai-inline-card {
  margin-top: 10px;
  background: rgba(8, 18, 36, 0.85);
  border: 1px solid rgba(56, 189, 248, 0.3);
  border-radius: 14px;
  padding: 10px 14px;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.35);
}
.ai-card-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  padding-bottom: 6px;
  margin-bottom: 6px;
}
.ai-card-city { font-weight: 800; font-size: 12.5px; color: #fff; }
.ai-card-desc { font-size: 11px; color: var(--ai-accent); }
.ai-card-temp { font-size: 20px; font-weight: 900; color: #fff; font-family: 'Space Grotesk', sans-serif; }
.ai-card-metrics {
  display: flex;
  gap: 12px;
  font-size: 11px;
  color: var(--ai-text-muted);
}
.ai-card-metrics span { display: inline-flex; align-items: center; gap: 4px; }
.ai-card-metrics i { color: var(--ai-accent); }

.ai-bubble-foot {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-top: 4px;
  font-size: 10.5px;
  color: var(--ai-text-muted);
  padding: 0 4px;
}
.ai-copy-action {
  background: none;
  border: none;
  color: var(--ai-text-muted);
  cursor: pointer;
  padding: 2px 4px;
  font-size: 10.5px;
  border-radius: 4px;
  transition: color 0.2s;
}
.ai-copy-action:hover { color: var(--ai-accent); }
.ai-provider-badge {
  font-size: 9px;
  padding: 1px 6px;
  border-radius: 4px;
  background: rgba(255, 255, 255, 0.06);
  color: var(--ai-text-muted);
}

/* TYPING INDICATOR */
.ai-typing-indicator {
  display: flex;
  align-items: center;
  gap: 8px;
}
.ai-dots {
  display: flex;
  gap: 4px;
}
.ai-dots span {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: var(--ai-accent);
  animation: aiDotBounce 1.4s infinite ease-in-out;
}
.ai-dots span:nth-child(1) { animation-delay: -0.32s; }
.ai-dots span:nth-child(2) { animation-delay: -0.16s; }
@keyframes aiDotBounce {
  0%, 80%, 100% { transform: scale(0); opacity: 0.4; }
  40% { transform: scale(1); opacity: 1; }
}
.ai-typing-text {
  font-size: 11.5px;
  color: var(--ai-accent);
  font-style: italic;
}

/* QUICK QUESTIONS HORIZONTAL BAR */
.ai-quick-scroll {
  padding: 6px 14px 8px;
  background: rgba(8, 16, 32, 0.7);
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  flex-shrink: 0;
}
.ai-quick-label {
  font-size: 9.5px;
  font-weight: 800;
  letter-spacing: 0.05em;
  color: var(--ai-accent);
  margin-bottom: 5px;
}
.ai-quick-chips {
  display: flex;
  gap: 6px;
  overflow-x: auto;
  white-space: nowrap;
  scrollbar-width: none;
}
.ai-quick-chips::-webkit-scrollbar { display: none; }
.ai-mini-chip {
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 10px;
  color: rgba(255, 255, 255, 0.85);
  font-size: 11px;
  padding: 4px 10px;
  cursor: pointer;
  white-space: nowrap;
  transition: all 0.2s;
}
.ai-mini-chip:hover {
  background: rgba(56, 189, 248, 0.15);
  border-color: var(--ai-accent);
  color: #fff;
}

/* INPUT DOCK */
.ai-dock-row {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 14px;
  border-top: 1px solid var(--ai-border);
  background: var(--ai-header-bg);
  flex-shrink: 0;
}
.ai-input-wrapper {
  flex: 1;
  position: relative;
  display: flex;
  align-items: center;
}
.ai-input-left-icon {
  position: absolute;
  left: 12px;
  color: var(--ai-text-muted);
  font-size: 13px;
  pointer-events: none;
}
.ai-dock-input {
  width: 100%;
  background: rgba(255, 255, 255, 0.06);
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-radius: 14px;
  color: var(--ai-text-main);
  font-size: 12.5px;
  font-family: inherit;
  padding: 10px 38px 10px 34px;
  outline: none;
  transition: all 0.2s;
}
.ai-dock-input:focus {
  border-color: var(--ai-accent);
  background: rgba(255, 255, 255, 0.09);
  box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
}
.ai-dock-input::placeholder { color: var(--ai-text-muted); }
.ai-dock-input:disabled { opacity: 0.5; }

.ai-mic-action {
  position: absolute;
  right: 8px;
  background: none;
  border: none;
  color: var(--ai-text-muted);
  cursor: pointer;
  font-size: 14px;
  padding: 6px;
  transition: all 0.2s;
}
.ai-mic-action:hover, .ai-mic-action.active {
  color: var(--ai-accent);
  transform: scale(1.15);
}

.ai-dock-send {
  width: 38px;
  height: 38px;
  border-radius: 12px;
  background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
  border: none;
  color: #fff;
  cursor: pointer;
  font-size: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  flex-shrink: 0;
  box-shadow: 0 4px 14px rgba(14, 165, 233, 0.35);
}
.ai-dock-send:hover:not(:disabled) {
  transform: scale(1.08);
  box-shadow: 0 6px 18px rgba(14, 165, 233, 0.55);
}
.ai-dock-send:disabled {
  opacity: 0.4;
  cursor: not-allowed;
  box-shadow: none;
}

.ai-window-foot {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 6px 14px;
  font-size: 10px;
  color: var(--ai-text-muted);
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  background: rgba(6, 14, 28, 0.95);
  flex-shrink: 0;
}
.ai-foot-hint { display: flex; align-items: center; gap: 4px; }
.ai-foot-hint i { color: #22c55e; }
.ai-drag-footer-note { opacity: 0.75; font-size: 9.5px; }

/* DRAGGABLE MINIMIZED PILL */
.ai-minimized-pill {
  position: fixed;
  display: flex;
  align-items: center;
  gap: 10px;
  background: var(--ai-header-bg);
  border: 1px solid var(--ai-accent);
  border-radius: 50px;
  padding: 8px 14px 8px 10px;
  cursor: grab;
  z-index: 999998;
  box-shadow: 0 14px 40px rgba(0, 0, 0, 0.6), 0 0 20px rgba(56, 189, 248, 0.35);
  user-select: none;
  transition: transform 0.2s, box-shadow 0.2s;
}
.ai-minimized-pill:active { cursor: grabbing; }
.ai-minimized-pill:hover { transform: scale(1.04); }

.ai-pill-dot {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-size: 13px;
  position: relative;
  flex-shrink: 0;
}
.ai-pill-pulse {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 8px;
  height: 8px;
  background: #22c55e;
  border-radius: 50%;
  border: 2px solid var(--ai-header-bg);
}
.ai-pill-name { font-size: 12.5px; font-weight: 800; color: var(--ai-text-main); line-height: 1.1; }
.ai-pill-tip { font-size: 9.5px; color: var(--ai-accent); font-weight: 600; }
.ai-pill-btn-close {
  background: none;
  border: none;
  color: var(--ai-text-muted);
  cursor: pointer;
  font-size: 12px;
  padding: 4px;
  transition: color 0.2s;
}
.ai-pill-btn-close:hover { color: #ef4444; }

/* FIXED FLOATING FAB CAPSULE BUTTON */
.ai-fab-container {
  position: fixed;
  bottom: 24px;
  right: 24px;
  z-index: 999999;
}
@media (max-width: 480px) {
  .ai-fab-container { bottom: 18px; right: 16px; }
}

.ai-fab-capsule {
  position: relative;
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 7px 18px 7px 8px;
  border-radius: 999px;
  background: linear-gradient(135deg, #1e40af 0%, #2563eb 50%, #0284c7 100%);
  border: 1.5px solid rgba(56, 189, 248, 0.45);
  cursor: pointer;
  color: #fff;
  box-shadow: 0 10px 30px rgba(37, 99, 235, 0.45), 0 0 20px rgba(56, 189, 248, 0.35);
  transition: transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.25s;
  outline: none;
  user-select: none;
}
.ai-fab-capsule:hover {
  transform: translateY(-3px) scale(1.03);
  box-shadow: 0 14px 40px rgba(37, 99, 235, 0.6), 0 0 28px rgba(56, 189, 248, 0.5);
}
.ai-fab-capsule:active { transform: scale(0.97); }
.ai-fab-capsule.active {
  background: linear-gradient(135deg, #374151, #1f2937);
  border-color: rgba(255, 255, 255, 0.2);
  padding: 8px;
  border-radius: 50%;
  width: 52px;
  height: 52px;
  justify-content: center;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
}

.ai-fab-icon-wrap {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  position: relative;
  flex-shrink: 0;
  box-shadow: inset 0 0 8px rgba(255, 255, 255, 0.2);
}
.ai-fab-online-dot {
  position: absolute;
  bottom: 0;
  right: 0;
  width: 9px;
  height: 9px;
  background: #22c55e;
  border-radius: 50%;
  border: 1.5px solid #1e40af;
  box-shadow: 0 0 6px #22c55e;
}

.ai-fab-label {
  display: flex;
  flex-direction: column;
  text-align: left;
  line-height: 1.15;
}
.ai-fab-label-main {
  font-size: 12.5px;
  font-weight: 800;
  letter-spacing: -0.01em;
  color: #ffffff;
}
.ai-fab-label-sub {
  font-size: 10px;
  color: #7dd3fc;
  font-weight: 600;
}

@media (max-width: 480px) {
  .ai-fab-capsule {
    padding: 7px;
    border-radius: 50%;
    width: 52px;
    height: 52px;
    justify-content: center;
  }
  .ai-fab-label { display: none; }
}

.ai-fab-glow {
  position: absolute;
  inset: -4px;
  border-radius: 999px;
  border: 1.5px solid rgba(56, 189, 248, 0.4);
  animation: aiFabGlow 2.5s ease-in-out infinite;
  pointer-events: none;
}
@keyframes aiFabGlow {
  0%, 100% { transform: scale(1); opacity: 0.6; }
  50% { transform: scale(1.08); opacity: 0; }
}

.ai-fab-badge {
  position: absolute;
  top: -4px;
  right: -4px;
  background: #ef4444;
  color: #fff;
  font-size: 10px;
  font-weight: 800;
  min-width: 18px;
  height: 18px;
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 4px;
  box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6);
  z-index: 2;
  animation: bounce 2s infinite;
}

/* ANIMATION TRANSITIONS */
.ai-pop-enter-active {
  transition: opacity 0.28s cubic-bezier(0.175, 0.885, 0.32, 1.275), transform 0.28s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.ai-pop-leave-active {
  transition: opacity 0.18s ease, transform 0.18s ease;
}
.ai-pop-enter-from {
  opacity: 0;
  transform: scale(0.92) translateY(18px);
}
.ai-pop-leave-to {
  opacity: 0;
  transform: scale(0.94) translateY(14px);
}

.ai-pill-enter-active {
  transition: opacity 0.25s, transform 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.ai-pill-leave-active { transition: opacity 0.15s; }
.ai-pill-enter-from { opacity: 0; transform: scale(0.85); }
.ai-pill-leave-to   { opacity: 0; }

#wl-ai[v-cloak] { display: none; }
</style>
