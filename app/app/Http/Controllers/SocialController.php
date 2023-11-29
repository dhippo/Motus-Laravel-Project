<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function index()
    {
        // Récupération des utilisateurs en triant par la date de création
        $users = User::where('id', '!=', auth()->id())->orderBy('created_at', 'desc')->get();
        $friends = Auth::user()->getFriends();
        $friendRequests = Auth::user()->getFriendRequests()->load('sender');
        $sentFriendRequests = Auth::user()->getPendingFriendships();

        return view('social.index', compact('users', 'friends', 'friendRequests', 'sentFriendRequests'));
    }

    public function addFriend(Request $request, User $user)
    {
        $request->user()->befriend($user);
        return redirect()->back()->with('success', 'Demande d\'ami envoyée.');
    }

    public function acceptFriendRequest(Request $request, $senderId)
    {
        $sender = User::find($senderId);
        Auth::user()->acceptFriendRequest($sender);

        return redirect()->back()->with('success', 'Demande d\'ami acceptée.');
    }


    public function showUserProfile($user_id)
    {
        $user = User::with('avatar', 'games.motusWord')->findOrFail($user_id);

        // Récupérer les jeux auxquels l'utilisateur a joué
        $games = $user->games()->with('motusWord')->get();

        return view('social.profile', compact('user', 'games'));
    }

}

