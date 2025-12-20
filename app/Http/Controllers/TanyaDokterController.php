<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class TanyaDokterController extends Controller
{
    // 1. TAMPILKAN HALAMAN & LIST DOKTER
    public function index()
    {
        // Ambil semua dokter
        $doctors = Doctor::all()->map(function($doc) {
            return [
                'id' => $doc->id,
                'name' => $doc->name,
                'specialist' => $doc->specialist,
                'avatar' => substr($doc->name, 4, 1), // Ambil huruf depan nama
                'status' => 'online', // Nanti bisa dibikin logic real online/offline
            ];
        });

        return view('page.tanya-dokter.index', compact('doctors'));
    }

    // 2. API: AMBIL PESAN (GET)
    public function getMessages($doctorId)
    {
        $userId = Auth::id();

        // Cari conversation
        $conversation = Conversation::where('user_id', $userId)
            ->where('doctor_id', $doctorId)
            ->first();

        if (!$conversation) {
            return response()->json([]); // Belum ada chat
        }

        // Ambil pesan
        $messages = $conversation->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($msg) {
                return [
                    'text' => $msg->message,
                    'sender' => $msg->sender_type, // 'user' atau 'doctor'
                    'time' => $msg->created_at->format('H:i'),
                ];
            });

        return response()->json($messages);
    }

    // 3. API: KIRIM PESAN (POST)
    public function sendMessage(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required',
            'message' => 'required|string'
        ]);

        $userId = Auth::id();

        // Cari atau Buat Conversation Baru
        $conversation = Conversation::firstOrCreate(
            ['user_id' => $userId, 'doctor_id' => $request->doctor_id]
        );

        // Simpan Pesan
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_type' => 'user', // Karena ini controller sisi User
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json(['status' => 'success', 'time' => $message->created_at->format('H:i')]);
    }
}