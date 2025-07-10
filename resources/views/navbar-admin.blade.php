<div class="navbar">
    <a href="" class="logo">
        <img class="logo-image" src="{{ asset('icon/logo.png') }}" alt="Logo">
    </a>
    <br>
    <br>
    <a href="/admin-student" class="{{ Request::is('admin-student') ? 'selected' : '' }}">
        <div>
            <img class="student-image" src="{{ asset('icon/student.png') }}" alt="Student">
            <p>Student</p>
        </div>
    </a>
    <br>
    <a href="/admin-teacher" class="{{ Request::is('admin-teacher') ? 'selected' : '' }}">
        <div>
            <img class="student-image" src="{{ asset('icon/teacher.png') }}" alt="Teacher">
            <p>Teacher</p>
        </div>
    </a>
    <br>
    <a href="/admin-subject" class="{{ Request::is('admin-subject') ? 'selected' : '' }}">
        <div>
            <img class="subject-image" src="{{ asset('icon/book.png') }}" alt="Subject">
            <p>Subject</p>
        </div>
    </a>
    <br>
    <a href="/admin-content" class="{{ Request::is('admin-content') ? 'selected' : '' }}">
        <div>
            <img class="subject-image" src="{{ asset('icon/content.png') }}" alt="Content">
            <p>Content</p>
        </div>
    </a>
    <br>
    <a href="/admin-chatbot" class="{{ Request::is('admin-content') ? 'selected' : '' }}">
        <div>
            <img class="subject-image" src="{{ asset('icon/chat.png') }}" alt="Content">
            <p>Chatbot</p>
        </div>
    </a>
    <br>
    <form action="/logout" method="POST" onsubmit="return confirm('Are you sure you to logout');">
        @csrf
        <button type="submit">
            <img class="logo-image" src="{{ asset('icon/out.png') }}" alt="Logo">
        </button>
    </form>
</div>

<script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
<script src="https://files.bpcontent.cloud/2025/07/10/04/20250710041832-ZAWIASSH.js"></script>
