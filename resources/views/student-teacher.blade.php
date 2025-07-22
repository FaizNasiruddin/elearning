

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
            </tr>
        @endforeach
    </tbody>
</table>
    </div>
