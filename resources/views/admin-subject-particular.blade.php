<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Details</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
    
    @include('navbar-admin')

    <div class="content">
        <h1 class="title">{{ $subject->name }} (Form {{ $subject->form }})</h1>

        <div class="sort">
            <div>
                <button onclick="location.href='/admin-enroll-student/{{ $subject->id }}'">Enroll Student</button>
                 <button onclick="exportTableToExcel('studentTable', '{{ $subject->name }}_students')">Export to Excel</button>
            </div>
            <div>
                <form method="GET" action="/admin-student" style="margin-bottom: 10px;">
                    <label for="sort">Sort by:</label>
                    <select name="sort" id="sort" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest (Newest First)</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest (Oldest First)</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Username A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Username Z-A</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Export Button -->

        <br>
        <table class="student-list" id="studentTable">
            <tr>
                <th>Full Name</th>
                <th>IC Number</th>
                <th>Form</th>
                <th></th>
            </tr>
            @foreach($subject->students as $enrolledStudent)
                <tr>
                    <td>{{ $enrolledStudent->fullname }}</td>
                    <td>{{ $enrolledStudent->username }}</td>
                    <td>{{ $enrolledStudent->form }}</td>
                    <td class="last-column">
                        <form class="buttonCol" action="/deleteEnrolledStudent" method="POST">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $enrolledStudent->id }}">
                            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                            <button class="deletebtn" type="submit"></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

<script>
function exportTableToExcel(tableID, subjectName = '') {
    const table = document.getElementById(tableID);
    const clonedTable = table.cloneNode(true);

    // Optional: remove the last column from every row (e.g., the buttons)
    for (let row of clonedTable.rows) {
        row.deleteCell(row.cells.length - 1);
    }

    // Get current date in DD-MM-YYYY format
    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const yyyy = today.getFullYear();
    const formattedDate = `${dd}-${mm}-${yyyy}`;

    // Generate filename like Subject-student-DD-MM-YYYY.xls
    const filename = `${subjectName}-${formattedDate}.xls`;

    @verbatim
    const html = `
        <html xmlns:o="urn:schemas-microsoft-com:office:office" 
              xmlns:x="urn:schemas-microsoft-com:office:excel" 
              xmlns="http://www.w3.org/TR/REC-html40">
        <head>
            <!--[if gte mso 9]>
            <xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>
            <x:Name>Sheet1</x:Name>
            <x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions>
            </x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>
            <![endif]-->
        </head>
        <body>
            ${clonedTable.outerHTML}
        </body>
        </html>
    `;
    @endverbatim

    const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    const downloadLink = document.createElement("a");

    downloadLink.download = filename;

    const url = URL.createObjectURL(blob);
    downloadLink.href = url;

    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>
    
</body>
</html>
