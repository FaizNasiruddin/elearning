<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
     @if(session('role') === 'teacher')
        @include('navbar-teacher')
    @elseif(session('role') === 'admin')
        @include('navbar-admin')
    @endif

    <div class="content">
        <form action="/uploadFileChatbot" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="your_file_input" required>
            <button type="submit">Upload</button>
        </form>
       <br>
         @if(session('success'))
    <p class="alert alert-success">{{ session('success') }}</p>
@endif
      @php
    use Illuminate\Support\Str;

    $allowedExtensions = ['.pdf', '.txt', '.xls', '.xlsx', '.doc', '.docx'];

    $uploadedFiles = collect($files)->filter(function ($file) use ($allowedExtensions) {
        $key = strtolower($file['key']); // Normalize case
        foreach ($allowedExtensions as $ext) {
            if (Str::endsWith($key, $ext)) {
                return true;
            }
        }
        return false;
    });
@endphp

        @if($uploadedFiles->count())
            <table>
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Size (KB)</th>
                        <th>Uploaded At</th>
                        <th>Title</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploadedFiles as $file)
                        <tr>
                            <td>{{ $file['key'] }}</td>
                            <td>{{ round($file['size'] / 1024, 2) }}</td>
                            <td>{{ \Carbon\Carbon::parse($file['createdAt'])->format('Y-m-d H:i') }}</td>
                            <td>{{ $file['tags']['title'] ?? '-' }}</td>
                            <td class="buttonCol last-column">
                                <form method="POST" action="/deleteKnowledgeBase/{{ $file['id'] }}" onsubmit="return confirm('Are you sure you want to delete this file?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="deletebtn" type="submit"></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No PDF, TXT, or Excel files uploaded.</p>
        @endif
        <br>
      

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<br>
 <a 
  href="https://sso.botpress.cloud/login" 
  target="_blank" 
  style="display: inline-block; padding: 10px 20px; background-color: #1e40af; color: #fff; text-decoration: none; border-radius: 5px;">
  Open Knowledge Base in Botpress Studio
</a>


<h3>Add New Chatbot</h3>

<div class="contents-add">
<form action="/chatbotsAdd" method="POST">
    @csrf

    <label for="name">Chatbot Name:</label><br>
    <input type="text" name="name" required><br><br>

    <label for="bot_id">Bot ID:</label><br>
    <input type="text" name="bot_id" required><br><br>

    <label for="kb_id">Knowledge Base ID (kb_id):</label><br>
    <input type="text" name="kb_id" required><br><br>

    <label for="pat">PAT Token:</label><br>
    <input type="text" name="pat" required><br><br>

    <label for="script_code">Chatbot Script:</label><br>
    <textarea name="script_code" rows="6" cols="80" placeholder="<script>...</script>"></textarea><br><br>

    <button type="submit">Save Chatbot</button>
</form>
</div>

<h2>All Chatbots</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Bot ID</th>
            <th>Knowledge Base ID</th>
            <th>Token (PAT)</th>
            <th>Is Active?</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($chatbots as $chatbot)
            <tr>
                <td>{{ $chatbot->id }}</td>
                <td>{{ $chatbot->bot_id }}</td>
                <td>{{ $chatbot->kb_id }}</td>
                <td>{{ $chatbot->pat }}</td>
                <td>{{ $chatbot->is_active ? 'Yes' : 'No' }}</td>
                <td>
                    @if (!$chatbot->is_active)
                        <form action="/activeChatbot/{{$chatbot->id}}" method="POST">
                            @csrf
                            <button type="submit">Set Active</button>
                        </form>
                    @else
                        <strong>Active</strong>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    </div>




</body>
</html>

<!-- 31ec012b-3685-4b49-94a5-1072b83cd95f
bp_pat_WRXk7pXePD2apnQ6jD82S5IMEFHZab2tmMiE -->