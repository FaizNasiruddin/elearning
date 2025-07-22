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

    
{!! $chatbot !!}