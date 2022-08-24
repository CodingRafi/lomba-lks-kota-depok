<?php

namespace App\Http\Controllers;

use App\Models\UserVote;
use App\Models\User;
use App\Models\Poll;
use App\Models\Pilihan;
use App\Http\Requests\StoreUserVoteRequest;
use App\Http\Requests\UpdateUserVoteRequest;
use Illuminate\Http\Request;

class UserVoteController extends Controller
{
    public function choice($poll_id, $choice_id, Request $request){
        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];

        $user = User::where('api_token', $token)->first();

        $poll = Poll::find($poll_id);
        $pilihan = Pilihan::find($choice_id);

        $userVote = UserVote::where('user_id', $user->id)->where('poll_id', $poll_id)->count();

        if($userVote > 0){
            return response()->json([
                'code' => 422,
                'message' => 'already voted'
            ], 422);
        }else{
            if($poll->deadline < now()){
                return response()->json([
                    'code' => 422,
                    'message' => 'voting deadline'
                ], 422);
            }else{
                if($pilihan){
                    UserVote::create([
                        'user_id' => $user->id,
                        'poll_id' => $poll_id,
                        'pilihan_id' => $choice_id
                    ]);
        
                    return response()->json([
                        'message' => 'voting success'
                    ], 200);
                }else{
                    return response()->json([
                        'code' => 422,
                        'message' => 'invalid choice'
                    ], 422);
                }
            }
        }


        
    }
}
