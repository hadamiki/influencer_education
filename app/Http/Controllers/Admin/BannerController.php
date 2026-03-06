<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function showBannerEdit()
    {
        $banners = Banner::orderBy('id')->get();
        return view('admin.banner_edit', compact('banners'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'images.*' => ['nullable', 'image', 'max:5120'],
            'new_images.*' => ['nullable', 'image', 'max:5120'],
            'delete_ids.*' => ['nullable', 'integer'],
        ]);

        DB::transaction(function () use ($request) {
            $deleteIds = $request->input('delete_ids', []);
            if (!empty($deleteIds)) {
                $targets = Banner::whereIn('id', $deleteIds)->get();
                foreach ($targets as $t) {
                    if ($t->image && Storage::disk('public')->exists($t->image)) {
                        Storage::disk('public')->delete($t->image);
                    }
                    $t->delete();
                }
            }

            $images = $request->file('images', []);
            foreach ($images as $id => $file) {
                if (!$file) continue;

                $banner = Banner::find($id);
                if (!$banner) continue;

                if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                    Storage::disk('public')->delete($banner->image);
                }

                $path = $file->store('images/banner', 'public');
                $banner->update(['image' => $path]);
            }

            $newImages = $request->file('new_images', []);
            foreach ($newImages as $file) {
                if (!$file) continue;

                $path = $file->store('images/banner', 'public');
                Banner::create(['image' => $path]);
            }
        });

        return redirect()->route('admin.show.banner.edit')->with('status', 'バナーを更新しました。');
    }
}