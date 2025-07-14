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
       @php
            use Illuminate\Support\Str;

            $kbId = 'kb-0f0bb658c5';
            $allowedExtensions = ['.pdf', '.txt', '.xls', '.xlsx'];

            $uploadedFiles = collect($files)->filter(function ($file) use ($kbId, $allowedExtensions) {
                if (!isset($file['tags']['kbId']) || $file['tags']['kbId'] !== $kbId) {
                    return false;
                }

                $key = $file['key'];
                foreach ($allowedExtensions as $ext) {
                    if (Str::endsWith(strtolower($key), $ext)) {
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
        @if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif
    </div>

   
</body>
</html>

<!-- 31ec012b-3685-4b49-94a5-1072b83cd95f
bp_pat_WRXk7pXePD2apnQ6jD82S5IMEFHZab2tmMiE -->