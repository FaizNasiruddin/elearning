<!-- 🟦 NAVBAR -->
<div class="navbar">
    {{-- Logo --}}
    <div class="section1s">
        <a href="/student-subject" class="logo" style="padding:5px;">
            <img class="logo-image" src="{{ asset('icon/logo.png') }}" alt="Logo">
        </a>
    </div>
    <br>
  {{-- Logout --}}
    <div class="section2">
        <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you want to logout?');">
            @csrf
            <button type="submit" class="logout-button">
                <img class="subject-image" src="{{ asset('icon/out.png') }}" alt="Logout">
            </button>
        </form>
    </div>
</div>


<!-- <script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/07/16/21/20250716215322-ALRRML93.js"></script> -->
    

<script src="https://cdn.botpress.cloud/webchat/v3.2/inject.js" defer></script>
<script src="https://files.bpcontent.cloud/2025/07/21/08/20250721083208-29XU28DV.js" defer></script>
    