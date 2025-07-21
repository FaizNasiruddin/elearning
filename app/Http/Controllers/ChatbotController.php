<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ChatbotController extends Controller
{
    private $botId;
    private $kbId;
    private $pat;
    private $client;

    public function __construct()
    {
        // $this->botId = '55708be4-1cf5-4261-b3b1-6b2f262335cb';
        // $this->kbId  = 'kb-e6698ed6fb';
        // $this->pat   = 'bp_pat_DhPOD9WA2RNlmeOaEA90jWSkZvFYMzebTtvJ';

        $this->botId = 'f3056edf-16a8-4ca0-8a3a-2db9624cfeef';
        $this->kbId  = 'kb-f3ce8a2429';
        $this->pat   = 'bp_pat_yadf1pJGmkuYblc5Elt7Lvp3T3fUX5DVLHy0';
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

        return view('admin-chatbot', [
            'files' => $files['files'] ?? [],
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
}
