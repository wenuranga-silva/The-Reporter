<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\VideoDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\PostTag;
use App\Models\Video;
use App\Models\VideoTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VideoDataTable $dataTable)
    {

        return $dataTable->render('admin.video.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = DB::table('categories')->get();
        $tags = DB::table('tags')->get();

        return view('admin.video.create', compact(['categories', 'tags']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'url' => ['required', 'url'],
            'description' => ['required', 'string'],
            'copyright_link' => ['nullable', 'url'],
            'copyright_text' => ['nullable', 'string'],
            'status' => ['required', 'in:yes,no'],
            'category' => ['required', 'integer'],
            'tag.*' => ['nullable', 'integer']
        ]);

        $video = new Video();
        $video->url = $request->url;
        $video->description = $request->description;
        $video->copyright_link = $request->copyright_link;
        $video->copyright_text = $request->copyright_text;
        $video->author = Auth::user()->id;
        $video->status = $request->status == 'yes' ? 1 : 0;
        $video->category_id = $request->category;
        $video->save();

        ////// for adding tag
        if ($request->tag != null) {

            // add tags for news
            foreach ($request->tag as $tag) {

                $post_tag = new VideoTag();
                $post_tag->video_id = $video->id;
                $post_tag->tag_id = $tag;
                $post_tag->save();
            }
        }

        return redirect()->back()->with(['success' => 'News Added !']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $video = Video::where('author', Auth::user()->id)->findOrFail($id);
        $categories = Category::all();
        $tags = DB::table('tags')->get();

        return view('admin.video.edit', compact(['video', 'categories', 'tags']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'url' => ['required', 'url'],
            'description' => ['required', 'string'],
            'copyright_link' => ['nullable', 'url'],
            'copyright_text' => ['nullable', 'string'],
            'status' => ['required', 'in:yes,no'],
            'category' => ['required', 'integer'],
            'tag.*' => ['nullable', 'integer'],
        ]);

        $video = Video::where('author', Auth::user()->id)->findOrFail($id);
        $video->url = $request->url;
        $video->description = $request->description;
        $video->copyright_link = $request->copyright_link;
        $video->copyright_text = $request->copyright_text;
        $video->status = $request->status == 'yes' ? 1 : 0;
        $video->category_id = $request->category;
        $video->update();


        // add ,remove tags for news
        $old_tags = VideoTag::where('video_id', $id)->get('tag_id');

        // create array with old tags
        $old_tagsArray = array();
        foreach ($old_tags as $ot) {

            array_push($old_tagsArray, $ot->tag_id);
        }

        if ($request->tag != null) {

            foreach ($request->tag as $tag) {

                // check availability and add new tag(if not)
                if (!in_array($tag, $old_tagsArray)) {

                    $post_tag = new VideoTag();
                    $post_tag->video_id = $id;
                    $post_tag->tag_id = $tag;
                    $post_tag->save();
                } else {

                    // remove tags which we need - after we can remove unnecessary tags
                    $key = array_search($tag, $old_tagsArray);
                    unset($old_tagsArray[$key]);
                }
            }
        }

        // remove unnecessary tags
        foreach ($old_tagsArray as $t) {

            $r_tag = VideoTag::where('video_id', $id)->where('tag_id', $t)->firstOrFail();
            DB::table('video_tags')->where('video_id', $id)->where('tag_id', $t)->delete();
        }

        return redirect()->back()->with(['success' => 'News Updated !']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /// change video status
    public function change_status(Request $request)
    {

        $request->validate([
            'id' => ['required', 'integer'],
            'value' => ['required', 'in:yes,no'],
        ]);

        //// check requested user is admin or author
        $u = Auth::user();
        $condition = $u->hasRole('admin');
        if ($condition) {

            $video = Video::findOrFail($request->id);
        } else {

            $video = Video::where('author', $u->id)->findOrFail($request->id);
        }

        $video->status = $request->value == 'yes' ? 1 : 0;
        $video->update();

        return response(['status' => 'success', 'msg' => 'Status Updated !']);
    }

    /// add news video for news ->>> form page diplay
    public function add_forNews($news_id)
    {

        $user = Auth::user()->id;
        $news = News::where('author_id', $user)->findOrFail($news_id);
        $video = Video::where('post_id', $news_id)->get();

        if ($video->count() >= 1) {

            $categories = Category::all();
            $tags = DB::table('tags')->get();

            return view('admin.news.video.index', compact(['video' ,'categories' ,'tags']));
        } else {

            $categories = DB::table('categories')->get();
            $tags = DB::table('tags')->get();

            return view('admin.news.video.index', compact(['news' ,'categories' ,'tags']));
        }
    }

    /// store video for news
    public function store_forNews(Request $request)
    {

        $request->validate([
            'url' => ['required', 'url'],
            'description' => ['required', 'string'],
            'copyright_link' => ['nullable', 'url'],
            'copyright_text' => ['nullable', 'string'],
            'status' => ['required', 'in:yes,no'],
            'post' => ['required', 'integer'],
            'category' => ['required', 'integer'],
            'tag.*' => ['nullable', 'integer']
        ]);

        $post = Video::where('post_id', $request->post)->count();

        if ($post >= 1) {

            return redirect()->back()->with(['Error' => 'One news can have only one VIDEO !']);
        }

        $video = new Video();
        $video->url = $request->url;
        $video->description = $request->description;
        $video->copyright_link = $request->copyright_link;
        $video->copyright_text = $request->copyright_text;
        $video->author = Auth::user()->id;
        $video->status = $request->status == 'yes' ? 1 : 0;
        $video->post_id = $request->post;
        $video->category_id = $request->category;
        $video->save();

        /////// for adding tags
        if ($request->tag != null) {

            // add tags for news
            foreach ($request->tag as $tag) {

                $post_tag = new VideoTag();
                $post_tag->video_id = $video->id;
                $post_tag->tag_id = $tag;
                $post_tag->save();
            }
        }

        return redirect()->back()->with(['success' => 'News Added !']);
    }

    /// update video for news
    public function update_forNews(Request $request)
    {

        $request->validate([
            'id' => ['required', 'integer'],
            'url' => ['required', 'url'],
            'description' => ['required', 'string'],
            'copyright_link' => ['nullable', 'url'],
            'copyright_text' => ['nullable', 'string'],
            'status' => ['required', 'in:yes,no'],
            'post' => ['required', 'integer'],
            'category' => ['required', 'integer'],
            'tag.*' => ['nullable', 'integer']
        ]);

        $video = Video::where('author', Auth::user()->id)->where('post_id', $request->post)->findOrFail($request->id);
        $video->url = $request->url;
        $video->description = $request->description;
        $video->copyright_link = $request->copyright_link;
        $video->copyright_text = $request->copyright_text;
        $video->status = $request->status == 'yes' ? 1 : 0;
        $video->post_id = $request->post;
        $video->category_id = $request->category;
        $video->update();


        // add ,remove tags for news
        $id = $request->id;
        $old_tags = VideoTag::where('video_id', $id)->get('tag_id');

        // create array with old tags
        $old_tagsArray = array();
        foreach ($old_tags as $ot) {

            array_push($old_tagsArray, $ot->tag_id);
        }

        if ($request->tag != null) {

            foreach ($request->tag as $tag) {

                // check availability and add new tag(if not)
                if (!in_array($tag, $old_tagsArray)) {

                    $post_tag = new VideoTag();
                    $post_tag->video_id = $id;
                    $post_tag->tag_id = $tag;
                    $post_tag->save();
                } else {

                    // remove tags which we need - after we can remove unnecessary tags
                    $key = array_search($tag, $old_tagsArray);
                    unset($old_tagsArray[$key]);
                }
            }

        }

        // remove unnecessary tags
        foreach ($old_tagsArray as $t) {

            $r_tag = VideoTag::where('video_id', $id)->where('tag_id', $t)->firstOrFail();
            DB::table('video_tags')->where('video_id', $id)->where('tag_id', $t)->delete();
        }


        return redirect()->back()->with(['success' => 'News Updated !']);
    }
}
