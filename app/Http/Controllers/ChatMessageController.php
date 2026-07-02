<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    // Buyer: Get all chat messages for logged-in user
    public function index()
    {
        $userId = Auth::id();
        $messages = ChatMessage::with(['product', 'order'])
            ->where('user_id', $userId)
            ->oldest() // Sort oldest first so they render top-to-bottom in chat timeline
            ->get()
            ->map(function ($msg) {
                return $this->formatMessage($msg);
            });

        return response()->json($messages);
    }

    // Buyer: Send a chat message
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        if (empty($request->message) && empty($request->product_id) && empty($request->order_id)) {
            return response()->json(['error' => 'Pesan tidak boleh kosong.'], 422);
        }

        $userId = Auth::id();

        $msg = ChatMessage::create([
            'user_id' => $userId,
            'sender_id' => $userId,
            'message' => $request->message,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'is_read' => false
        ]);

        return response()->json($this->formatMessage($msg->load(['product', 'order'])));
    }

    // Buyer: Mark all incoming admin messages as read
    public function markAsRead()
    {
        $userId = Auth::id();
        
        // Mark messages sent by admin to this user as read
        ChatMessage::where('user_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // Admin: Render main chat management screen
    public function adminIndex()
    {
        return view('admin.chats.index');
    }

    // Admin: Get list of users with chat history (sorted by latest activity)
    public function adminUsers()
    {
        $users = User::where('role', 'user')
            ->whereHas('chatMessages')
            ->get()
            ->map(function ($user) {
                $latestMessage = ChatMessage::where('user_id', $user->id)
                    ->latest()
                    ->first();
                
                $unreadCount = ChatMessage::where('user_id', $user->id)
                    ->where('sender_id', $user->id) // sent by the customer
                    ->where('is_read', false)
                    ->count();

                $latestMsgText = '';
                if ($latestMessage) {
                    $latestMsgText = $latestMessage->message;
                    if ($latestMessage->sender_id !== $user->id) {
                        $latestMsgText = 'Anda: ' . $latestMsgText;
                    }
                }

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar ? asset('storage/' . $user->avatar) : null,
                    'avatar_initial' => strtoupper(substr($user->name, 0, 1)),
                    'latest_message' => $latestMsgText,
                    'latest_message_time' => $latestMessage ? $latestMessage->created_at->diffForHumans() : '',
                    'latest_message_timestamp' => $latestMessage ? $latestMessage->created_at->timestamp : 0,
                    'unread_count' => $unreadCount,
                ];
            })
            ->sortByDesc('latest_message_timestamp')
            ->values();

        return response()->json($users);
    }

    // Admin: Get chat history with a specific user
    public function adminMessages($userId)
    {
        $messages = ChatMessage::with(['product', 'order'])
            ->where('user_id', $userId)
            ->oldest()
            ->get()
            ->map(function ($msg) {
                return $this->formatMessage($msg);
            });

        return response()->json($messages);
    }

    // Admin: Send response to a specific user
    public function adminStore(Request $request, $userId)
    {
        $request->validate([
            'message' => 'nullable|string',
            'product_id' => 'nullable|exists:products,id',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        if (empty($request->message) && empty($request->product_id) && empty($request->order_id)) {
            return response()->json(['error' => 'Pesan tidak boleh kosong.'], 422);
        }

        $adminId = Auth::id();

        $msg = ChatMessage::create([
            'user_id' => $userId,
            'sender_id' => $adminId,
            'message' => $request->message,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'is_read' => false
        ]);

        return response()->json($this->formatMessage($msg->load(['product', 'order'])));
    }

    // Admin: Mark user's incoming messages as read
    public function adminMarkAsRead($userId)
    {
        // Mark messages sent by customer to admin as read
        ChatMessage::where('user_id', $userId)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    // Helper: Formatter for JSON responses
    private function formatMessage($msg)
    {
        $productData = null;
        if ($msg->product) {
            $productData = [
                'id' => $msg->product->id,
                'name' => $msg->product->name,
                'price' => 'Rp ' . number_format($msg->product->price, 0, ',', '.'),
                'image_url' => $msg->product->imageUrl(),
                'url' => route('product.show', $msg->product->id)
            ];
        }

        $orderData = null;
        if ($msg->order) {
            $orderUrl = route('order.detail', $msg->order->id);
            if (Auth::check() && Auth::user()->role === 'admin') {
                $orderUrl = route('admin.order.detail', $msg->order->id);
            }

            $orderData = [
                'id' => $msg->order->id,
                'status' => $msg->order->statusIndo(),
                'status_raw' => $msg->order->status,
                'total_price' => 'Rp ' . number_format($msg->order->total_price, 0, ',', '.'),
                'date' => $msg->order->created_at->format('d M Y H:i'),
                'url' => $orderUrl
            ];
        }

        return [
            'id' => $msg->id,
            'user_id' => $msg->user_id,
            'sender_id' => $msg->sender_id,
            'is_from_admin' => $msg->sender_id !== $msg->user_id,
            'message' => $msg->message,
            'product' => $productData,
            'order' => $orderData,
            'is_read' => $msg->is_read,
            'time' => $msg->created_at->format('H:i'),
            'date_group' => $msg->created_at->translatedFormat('d F Y'),
            'timestamp' => $msg->created_at->timestamp,
        ];
    }
}
