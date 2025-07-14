<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">

    <style>
        #loadingScreen {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(255, 255, 255, 0.85);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .spinner {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            margin-top: 20px;
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>
    {{-- Loading Screen --}}
    <div id="loadingScreen">
        <div class="spinner"></div>
        <div class="loading-text">Connecting to API...</div>
    </div>

    {{-- Navbar --}}
    <div class="navbar">
        <div class="section1">
            <div>
            <img class="logo-image" src="{{ asset('icon/logo.png') }}" alt="Logo">

            </div>

        <a href="/admin-student" class="{{ Request::is('admin-student') ? 'selected' : '' }}">
            <div>
                <img class="student-image" src="{{ asset('icon/student.png') }}" alt="Student">
                <p>Student</p>
            </div>
        </a>

        <a href="/admin-teacher" class="{{ Request::is('admin-teacher') ? 'selected' : '' }}">
            <div>
                <img class="student-image" src="{{ asset('icon/teacher.png') }}" alt="Teacher">
                <p>Teacher</p>
            </div>
        </a>

        <a href="/admin-subject" class="{{ Request::is('admin-subject') ? 'selected' : '' }}">
            <div>
                <img class="subject-image" src="{{ asset('icon/book.png') }}" alt="Subject">
                <p>Subject</p>
            </div>
        </a>

        <a href="/admin-content" class="{{ Request::is('admin-content') ? 'selected' : '' }}">
            <div>
                <img class="subject-image" src="{{ asset('icon/content.png') }}" alt="Content">
                <p>Content</p>
            </div>
        </a>

        <a href="/admin-chatbot" class="{{ Request::is('admin-chatbot') ? 'selected' : '' }}">
            <div>
                <img class="subject-image" src="{{ asset('icon/chat.png') }}" alt="Chatbot">
                <p>Chatbot</p>
            </div>
        </a>
        </div>
        <div class="section2">
<form action="/logout" method="POST" onsubmit="return confirm('Are you sure you want to logout?');">
                @csrf
                <button type="submit" class="logout-button">
                    <img class="logout-image" src="{{ asset('icon/out.png') }}" alt="Logout">
                </button>
            </form>
        </div>
            
    </div>

    {{-- Botpress Scripts --}}
    <script src="https://cdn.botpress.cloud/webchat/v3.0/inject.js"></script>
    <script src="https://files.bpcontent.cloud/2025/07/10/04/20250710041832-ZAWIASSH.js"></script>

    {{-- Loader Script --}}
    <script>
        // Show loading when chatbot link is clicked
        document.querySelectorAll('a[href="/admin-chatbot"]').forEach(link => {
            link.addEventListener('click', function () {
                document.getElementById('loadingScreen').style.display = 'flex';
            });
        });

        // Show loading immediately on chatbot page load
        document.addEventListener("DOMContentLoaded", () => {
            if (window.location.pathname === '/admin-chatbot') {
                document.getElementById('loadingScreen').style.display = 'flex';
            }
        });

        // Hide loader once fully loaded
        window.addEventListener("load", () => {
            document.getElementById('loadingScreen').style.display = 'none';
        });
    </script>
</body>
</html>
