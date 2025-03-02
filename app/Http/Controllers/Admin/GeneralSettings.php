<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Navigation;
use App\Models\websiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class GeneralSettings extends Controller
{

    //// routes for nav
    public function nav_index()
    {

        $categories = Category::all(['id', 'name']);
        return view('admin.settings.navigation', compact('categories'));
    }

    // add item to nav
    public function nav_store(Request $request)
    {

        $category = Category::where('id', $request->category)->count();

        if ($category == 0) {

            return response(['status' => 'error', 'msg' => 'Item Not Found !']);
        }

        $nav = Navigation::where('category_id', $request->category)->count();

        if ($nav >= 1) {

            return response(['status' => 'error', 'msg' => 'Item Already Available !']);
        }

        $data = new Navigation();
        $data->category_id = $request->category;
        $data->save();

        return response(['status' => 'success', 'msg' => 'Item Added !', 'id' => $data->id]);
    }

    public function nav_delete(string $id)
    {

        $nav = Navigation::findOrFail($id);

        // get category id to pass
        $cat = $nav->category_id;
        $nav->delete();

        return response(['msg' => 'Deleted !', 'id' => $cat]);
    }

    public function web_index()
    {

        $info = websiteInfo::first();

        return view('admin.settings.websiteInfo', compact('info'));
    }


    public function web_store(Request $request)
    {

        $request->validate([
            'mail' => ['required', 'email'],
            'contact_number' => ['required', 'max_digits:18'],
            'address' => ['required', 'string', 'max:200'],
            'twitter_url' => ['required', 'url'],
            'facebook_url' => ['required', 'url'],
            'youtube_url' => ['required', 'url']
        ]);

        $info = new websiteInfo();
        $info->email = $request->mail;
        $info->tel = $request->contact_number;
        $info->address = $request->address;
        $info->tw_url = $request->twitter_url;
        $info->fb_url = $request->facebook_url;
        $info->yt_url = $request->youtube_url;
        $info->save();

        return redirect()->back()->with(['success' => 'Infomation Updated !']);
    }

    public function web_update(Request $request, string $id)
    {

        $request->validate([
            'mail' => ['required', 'email'],
            'contact_number' => ['required', 'max_digits:18'],
            'address' => ['required', 'string', 'max:200'],
            'twitter_url' => ['required', 'url'],
            'facebook_url' => ['required', 'url'],
            'youtube_url' => ['required', 'url']
        ]);

        $info = websiteInfo::findOrFail($id);
        $info->email = $request->mail;
        $info->tel = $request->contact_number;
        $info->address = $request->address;
        $info->tw_url = $request->twitter_url;
        $info->fb_url = $request->facebook_url;
        $info->yt_url = $request->youtube_url;
        $info->update();

        return redirect()->back()->with(['success' => 'Infomation Updated !']);
    }
}
