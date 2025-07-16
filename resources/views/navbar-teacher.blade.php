<div class="navbar">
<div class="section1s" >
        <div>
                <img class="logo-image" src="{{ asset('icon/logo.png') }}" alt="Logo">
            </div>
    <a href="/teacher-subject" class="{{ Request::is('teacher-subject') ? 'selected' : '' }}">
        <div>
            <img class="subject-image" src="{{ asset('icon/book.png') }}" alt="Subject">
            <p>Subject</p>
        </div>
    </a>

    <a href="/teacher-content" class="{{ Request::is('teacher-content') ? 'selected' : '' }}">
        <div>
            <img class="subject-image" src="{{ asset('icon/content.png') }}" alt="Content">
            <p>Content</p>
        </div>
    </a>
    </div>

    <div class="section2">
        <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you want to logout?');">
            @csrf
            <button type="submit" class="logout-button">
                <div>
                    <img class="subject-image" src="{{ asset('icon/out.png') }}" alt="Logout">
                </div>
            </button>
        </form>
    </div>
</div>

<!-- {{-- Botpress script --}}
<script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/07/02/22/20250702224627-B4D0LC44.js"></script> -->