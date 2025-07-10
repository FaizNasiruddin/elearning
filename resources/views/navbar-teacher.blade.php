<div class="navbar">
    <a href="" class="logo">
        <img class="logo-image" src="{{ asset('icon/logo.png') }}" alt="Logo">
    </a>
    <br>
    <a href="/teacher-subject" class="{{ Request::is('admin-subject') ? 'selected' : '' }}">
        <div>
            <img class="subject-image" src="{{ asset('icon/book.png') }}" alt="Subject">
            <p>Subject</p>
        </div>
    </a>
    <br>

    <a href="/teacher-content" class="{{ Request::is('teacher-content') ? 'selected' : '' }}">
        <div>
            <img class="subject-image" src="{{ asset('icon/content.png') }}" alt="Content">
            <p>Content</p>
        </div>
    </a>
    <br>
    <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you to logout');">
        @csrf
        <button type="submit">
            <img class="logo-image" src="{{ asset('icon/out.png') }}" alt="Logo">
        </button>
    </form>
    <br>
</div>
<script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/07/02/22/20250702224627-B4D0LC44.js"></script>
