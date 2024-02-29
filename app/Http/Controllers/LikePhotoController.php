<?php

namespace App\Http\Controllers;

use App\Models\LikesPhoto;
use Illuminate\Http\Request;

class LikePhotoController extends Controller
{
    public function like(Request $request)
    {
        $request->validate([
            'photo_id' => ['required', 'exists:photos,id'],
        ]);

        if (!LikesPhoto::where('photo_id', $request->photo_id)->where('user_id', auth()->user()->id)->exists()) {
            LikesPhoto::create([
                'photo_id' => $request->photo_id,
                'user_id' => auth()->user()->id
            ]);
        }

        return redirect()->route('photo.index', $request->photo_id);
    }

    public function unlike(Request $request)
    {
        $request->validate([
            'photo_id' => ['required', 'exists:photos,id'],
        ]);

        LikesPhoto::where('photo_id', $request->photo_id)->where('user_id', auth()->user()->id)->delete();
        return redirect()->route('photo.index', $request->photo_id);
    }
}
