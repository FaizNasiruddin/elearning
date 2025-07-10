<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class ChatbotController extends Controller
{
    public function showAdminChatbot(){
       $botId = '31ec012b-3685-4b49-94a5-1072b83cd95f';
       $pat = 'bp_pat_q0E8SvtxmjQH2vb3VhzPt4CvPXNNK8bCGUB6';

    $client = new \GuzzleHttp\Client();

    try {
        $response = $client->request('GET', 'https://api.botpress.cloud/v1/files', [
            'headers' => [
                'x-bot-id'      => $botId,
                'Authorization' => 'Bearer ' . $pat,
                'Accept'        => 'application/json',
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

    // public function uploadFileChatbot(Request $request)
    // {
    //    $file = $request->file('your_file_input'); 
    //     $client = new Client(); 
    //     $response = $client->request('PUT', 'https://api.botpress.cloud/v1/bots/31ec012b-3685-4b49-94a5-1072b83cd95f/knowledge/files', [ 
    //         'headers' => [ 
    //             'Authorization' => 'Bearer bp_pat_WRXk7pXePD2apnQ6jD82S5IMEFHZab2tmMiE', 
    //             'Accept'        => 'application/json', 
    //         ], 
    //         'multipart' => [ 
    //             [ 
    //                 'name'     => 'file', 
    //                 'contents' => fopen($file->getPathname(), 'r'), 
    //                 'filename' => $file->getClientOriginalName(), 
    //             ], 
    //         ], 
    //     ]); 
    //     return json_decode($response->getBody(), true); 


    //     $file = $request->file('your_file_input'); 
    //     $client = new Client(); 
    
    //     // Step 1: Create the file in Botpress and get the upload URL 
    //     $botId = '31ec012b-3685-4b49-94a5-1072b83cd95f'; 
    //     $pat = 'bp_pat_q0E8SvtxmjQH2vb3VhzPt4CvPXNNK8bCGUB6'; 
    //     $fileName = $file->getClientOriginalName(); 
    //     $fileSize = $file->getSize(); 
    
    //     $response = $client->request('PUT', 'https://api.botpress.cloud/v1/files', [ 
    //         'headers' => [ 
    //             'x-bot-id' => $botId, 
    //             'Authorization' => 'Bearer ' . $pat, 
    //             'Content-Type' => 'application/json', 
    //         ], 
    //         'body' => json_encode([ 
    //             'key' => $fileName, 
    //             'size' => $fileSize, 
    //             'index' => true // Set to true to index for Knowledge Base 
    //         ]), 
    //     ]); 
    
    //     $result = json_decode($response->getBody(), true); 
    //     $uploadUrl = $result['file']['uploadUrl']; 

    //     // Step 2: Upload the file content to the uploadUrl 
    //     $client->request('PUT', $uploadUrl, [ 
    // 'body' => file_get_contents($file->getPathname()), 
    // 'headers' => [ 
    //     'Content-Type' => 'application/octet-stream', 
    // ], 
    //     ]); 
    
    //     return response()->json(['success' => true, 'message' => 'File uploaded to Botpress Knowledge Base!']); 

      public function uploadFileChatbot(Request $request)
        {
            $file = $request->file('your_file_input');
            $client = new Client();

            $botId = '31ec012b-3685-4b49-94a5-1072b83cd95f';
            $kbId  = 'kb-0f0bb658c5';
            $pat   = 'bp_pat_q0E8SvtxmjQH2vb3VhzPt4CvPXNNK8bCGUB6';

            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();

            // Step 1: Register the file with Botpress and tag it to KB
            $response = $client->request('PUT', 'https://api.botpress.cloud/v1/files', [
                'headers' => [
                    'x-bot-id'      => $botId,
                    'Authorization' => 'Bearer ' . $pat,
                    'Content-Type'  => 'application/json',
                ],
                'body' => json_encode([
                    'key'   => 'kb-' . $kbId . '/' . $fileName, // mimic directory structure
                    'size'  => $fileSize,
                    'index' => true,
                    'tags'  => [
                        'source' => 'knowledge-base',
                        'kbId'   => $kbId,
                        'title'  => pathinfo($fileName, PATHINFO_FILENAME)
                    ]
                ]),
            ]);

            $result = json_decode($response->getBody(), true);
            $uploadUrl = $result['file']['uploadUrl'];

            // Step 2: Upload raw binary file content to signed URL
            $client->request('PUT', $uploadUrl, [
                'body' => file_get_contents($file->getPathname()),
                'headers' => [
                    'Content-Type' => 'application/octet-stream',
                ],
            ]);

            return response()->json([
                'success'  => true,
                'message'  => 'File uploaded and linked to Botpress Knowledge Base!',
                'filename' => $fileName
            ]);
        }

    public function deleteFileChatbot($id)
    {
        $botId = '31ec012b-3685-4b49-94a5-1072b83cd95f';
        $pat   = 'bp_pat_q0E8SvtxmjQH2vb3VhzPt4CvPXNNK8bCGUB6';

        $client = new \GuzzleHttp\Client();
        try {
            $client->request('DELETE', "https://api.botpress.cloud/v1/files/{$id}", [
                'headers' => [
                    'x-bot-id' => $botId,
                    'Authorization' => 'Bearer ' . $pat,
                ]
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }

        return back()->with('success', 'File deleted successfully!');
    }

}
