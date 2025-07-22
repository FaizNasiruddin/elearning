<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Chatbot;

class ChatbotController extends Controller
{
    private $botId;
    private $kbId;
    private $pat;
    private $client;

    public function __construct()
    {
         // $this->botId = 'f3056edf-16a8-4ca0-8a3a-2db9624cfeef';
        // $this->kbId  = 'kb-f3ce8a2429';
        // $this->pat   = 'bp_pat_yadf1pJGmkuYblc5Elt7Lvp3T3fUX5DVLHy0';

        $activeBot = Chatbot::where('is_active', 1)->first();

    // Fallback if no active bot is set
    if ($activeBot) {
        $this->botId = $activeBot->bot_id;
        $this->kbId  = $activeBot->kb_id;
        $this->pat   = $activeBot->pat;
    } else {
        // Optional: handle when no bot is active
        $this->botId = null;
        $this->kbId  = null;
        $this->pat   = null;
    }

      
        $this->client = new Client();
    }

   
public function showAdminChatbot()
{
    try {
        $response = $this->client->request('GET', 'https://api.botpress.cloud/v1/files', [
            'headers' => [
                'x-bot-id' => $this->botId,
                'Authorization' => 'Bearer ' . $this->pat,
                'Accept' => 'application/json',
            ],
        ]);

        $files = json_decode($response->getBody(), true);
    } catch (\Exception $e) {
        $files = ['error' => 'Unable to fetch files from Botpress.'];
    }

    // 🔽 Get all chatbots from the table
    $chatbots = Chatbot::all();

    return view('admin-chatbot', [
        'files' => $files['files'] ?? [],
        'chatbots' => $chatbots, // 🔽 Pass to view
    ]);
}

    public function uploadFileChatbot(Request $request)
    {
        $file = $request->file('your_file_input');
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $response = $this->client->request('PUT', 'https://api.botpress.cloud/v1/files', [
            'headers' => [
                'x-bot-id' => $this->botId,
                'Authorization' => 'Bearer ' . $this->pat,
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode([
                'key' => 'kb-' . $this->kbId . '/' . $fileName,
                'size' => $fileSize,
                'index' => true,
                'tags' => [
                    'source' => 'knowledge-base',
                    'kbId' => $this->kbId,
                    'title' => pathinfo($fileName, PATHINFO_FILENAME),
                ]
            ]),
        ]);

        $result = json_decode($response->getBody(), true);
        $uploadUrl = $result['file']['uploadUrl'];

        $this->client->request('PUT', $uploadUrl, [
            'body' => file_get_contents($file->getPathname()),
            'headers' => ['Content-Type' => 'application/octet-stream'],
        ]);

        return back()->with('success', 'File uploaded successfully!');
    }

    public function deleteFileChatbot($id)
    {
        try {
            $this->client->request('DELETE', "https://api.botpress.cloud/v1/files/{$id}", [
                'headers' => [
                    'x-bot-id' => $this->botId,
                    'Authorization' => 'Bearer ' . $this->pat,
                ]
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }

        return back()->with('success', 'File deleted successfully!');
    }


    public function chatbotAdd(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bot_id' => 'required|string',
            'kb_id' => 'required|string',
            'pat' => 'required|string',
            'script_code' => 'nullable|string',
        ]);

        Chatbot::create([
            'name' => $validated['name'],
            'bot_id' => $validated['bot_id'],
            'kb_id' => $validated['kb_id'],
            'pat' => $validated['pat'],
            'script_code' => $validated['script_code'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'New chatbot added successfully!');
    }


    public function chatbotActive($id)
    {
        // Deactivate all
        Chatbot::query()->update(['is_active' => false]);

        // Activate the selected one
        Chatbot::where('id', $id)->update(['is_active' => true]);

        return view('student-teacher');
    }

    
   public function navbar()
    {
        $chatbotScript = Chatbot::where('is_active', true)->first()?->script_code ?? '';
        return view('navbar', compact('chatbotScript'));
    }

}
