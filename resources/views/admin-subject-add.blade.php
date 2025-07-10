<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}" />
</head>
<body>
    <div class="add">

        

        <form action="/addSubject" method="POST">
            @csrf
            <input type="text" name="subjectname" placeholder="Subject Name" value="{{ old('subjectname') }}">
            <br>

            <select name="subjectteacher">
                <option value="">-- Select Teacher --</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('subjectteacher') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->fullname }}
                    </option>
                @endforeach
            </select>
            <br>

            <select id="subject" name="subjectform">
                <option value="">-- Select Form --</option>
                <option value="1" {{ old('subjectform') == '1' ? 'selected' : '' }}>Form 1</option>
                <option value="2" {{ old('subjectform') == '2' ? 'selected' : '' }}>Form 2</option>
                <option value="3" {{ old('subjectform') == '3' ? 'selected' : '' }}>Form 3</option>
                <option value="4" {{ old('subjectform') == '4' ? 'selected' : '' }}>Form 4</option>
                <option value="5" {{ old('subjectform') == '5' ? 'selected' : '' }}>Form 5</option>
            </select>
            <br>

            <input type="color" name="subjectcolor" value="{{ old('subjectcolor') ?? '#000000' }}">
            <br>
            <br>

            <button>Add Subject</button>
        </form>

        {{-- Show validation errors if any --}}
        @if ($errors->any())
        <br>
            <div class="alert alert-danger" >
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>