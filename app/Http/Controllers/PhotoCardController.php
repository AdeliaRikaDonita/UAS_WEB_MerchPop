<?php

namespace App\Http\Controllers;

use App\Models\PhotoCard;

class PhotoCardController extends Controller
{
    public function show(PhotoCard $photoCard)
    {
        $photoCard->load('store');
        $related = PhotoCard::where('store_id', $photoCard->store_id)
            ->where('id', '!=', $photoCard->id)
            ->where('is_active', true)
            ->take(4)->get();

        return view('photocards.show', compact('photoCard', 'related'));
    }
}
