<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePollRequest;
use App\Http\Requests\UpdatePollRequest;
use App\Models\Pilihan;
use App\Models\Poll;
use App\Models\User;
use App\Models\UserVote;
use Illuminate\Http\Request;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $polls = Poll::all();

        return response()->json([
            'polls' => $polls,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePollRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePollRequest $request)
    {
        $poll = Poll::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
        ]);

        foreach ($request->pilihan as $pilihan) {
            Pilihan::create([
                'poll_id' => $poll->id,
                'nama' => $pilihan,
            ]);
        }

        return response()->json([
            'message' => 'Berhasil Menambahkan Poll Baru',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        // 1. jumlah vote yang telah di pilih
        $votes = UserVote::where('poll_id', $id)->count();

        // 2. jumlah pilihan dalam vote
        $poll = Poll::find($id);

        $pilihans = [];
        foreach ($poll->pilihan as $key => $pilihan) {
            $sigleVote = UserVote::where('pilihan_id', $pilihan->id)->count();
            if ($sigleVote > 0) {
                $pilihans[] = [
                    'nama' => $pilihan->nama,
                    'presentasi' => $sigleVote * 100 / $votes,
                ];
            } else {
                $pilihans[] = [
                    'nama' => $pilihan->nama,
                    'presentasi' => 0,
                ];
            }
        }

        $token = $request->header('Authorization');
        $token = explode(' ', $token)[1];

        $user = User::where('api_token', $token)->first();
        $userVote = UserVote::where('user_id', $user->id)->where('poll_id', $id)->count();

        if ($user->role == 'admin') {
            return response()->json([
                'is_voted' => true,
                'poll' => $poll,
                'pilihans' => $pilihans,
            ], 200);
        }

        if ($userVote > 0) {
            return response()->json([
                'is_voted' => true,
                'poll' => $poll,
                'pilihans' => $pilihans,
            ], 200);
        } else {
            $pilihans = $poll->pilihan;
            return response()->json([
                'is_voted' => false,
                'poll' => $poll,
                'pilihans' => $pilihans,
            ], 200);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function edit(Poll $poll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePollRequest  $request
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePollRequest $request, Poll $poll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Poll  $poll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Poll $poll)
    {
        Pilihan::where('poll_id', $poll->id)->delete();
        $poll->delete();

        return response()->json([
            'message' => 'Berhasil Menghapus poll',
        ], 200);
    }
}
