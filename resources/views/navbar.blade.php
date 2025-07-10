<!-- 🟦 NAVBAR -->
<div class="navbar">
    <a href="/student-subject" class="logo">
        <img class="logo-image" src="{{ asset('icon/logo.png') }}" alt="Logo">
    </a>
    <br>
    <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you to logout');">
        @csrf
        <button type="submit">
            <img class="logo-image" src="{{ asset('icon/out.png') }}" alt="Logo">
        </button>
    </form>
    <!-- <br>
    <a href="/student-profile">
        <div>
            <img class="student-image" src="{{ asset('icon/student-red.png') }}" alt="Student">
            <p>Student</p>
        </div>
    </a>
    <br>
    <a href="/student-subject">
        <div>
            <img class="subject-image" src="{{ asset('icon/book-red.png') }}" alt="Subject">
            <p>Subject</p>
        </div>
    </a>
    <br> -->
</div>

<!-- In your <head> tag -->
<!-- <script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script> -->
<!-- <style>
  #webchat .bpWebchat {
    position: unset;
    width: 100%;
    height: 100%;
    max-height: 100%;
    max-width: 100%;
  }

  #webchat .bpFab {
    display: none;
  }
</style> -->

<!-- <div id="webchat" style="width: 500px; height: 500px;"></div>  -->

<!-- In your <body> tag -->
<!-- <script>
  window.botpress.on("webchat:ready", () => {
    window.botpress.open();
  });

  window.botpress.init({
    botId: "31ec012b-3685-4b49-94a5-1072b83cd95f",
    clientId: "fcc9b9f4-6883-4596-8d89-fc3ecbc4842b",
    selector: "#webchat",

    // ✅ ADD THESE TWO
    userId: "{{ auth()->check() ? auth()->user()->id : 'guest_' . Str::random(6) }}",
    customData: {
      name: "{{ auth()->check() ? auth()->user()->name : 'Faiz' }}"
    }
  });
</script> -->

<script src="https://cdn.botpress.cloud/webchat/v3.1/inject.js" defer></script>
<script src="https://files.bpcontent.cloud/2025/07/02/22/20250702224627-B4D0LC44.js" defer></script>
    