<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\NewsAllDataTable;
use App\DataTables\NewsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\PostImage;
use App\Models\PostTag;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Termwind\render;

class NewsController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(NewsDataTable $dataTable)
    {

        return $dataTable->render('admin.news.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DB::table('categories')->get();
        $tags = DB::table('tags')->get();

        return view('admin.news.create', compact(['categories', 'tags']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp,avif', 'max:2048'],
            'image_caption' => ['nullable', 'max:200', 'string'],
            'image_copyright_link' => ['nullable', 'url'],
            'image_copyright_text' => ['nullable', 'max:180', 'string'],
            'title' => ['required', 'max:250', 'string'],
            'description' => ['required'],
            'status' => ['required', 'in:yes,no'],
            'is_comment' => ['required', 'in:yes,no'],
            'category' => ['required', 'integer'],
            'tag.*' => ['nullable', 'integer']
        ]);

        // add news
        $news = new News();
        $news->title = $request->title;
        $news->description = $request->description;
        $news->status = $request->status == 'yes' ? 1 : 0;
        $news->is_comment = $request->is_comment == 'yes' ? 1 : 0;
        $news->category_id = $request->category;
        $news->author_id = Auth::user()->id;
        $news->save();

        // add images for news
        $post_image = new PostImage();

        $image_data = json_decode($this->uploadImage($request, 'image', '/uploads/news/'));

        $post_image->post_id = $news->id;
        $post_image->image_id = $image_data->id;
        $post_image->image = $image_data->path;
        $post_image->caption = $request->image_caption;
        $post_image->copyright_link = $request->image_copyright_link;
        $post_image->copyright_text = $request->image_copyright_text;
        $post_image->save();


        if ($request->tag != null) {

            // add tags for news
            foreach ($request->tag as $tag) {

                $post_tag = new PostTag();
                $post_tag->post_id = $news->id;
                $post_tag->tag_id = $tag;
                $post_tag->save();
            }
        }

        return redirect()->back()->with(['success' => 'News Added !']);
    }

    /**
     * Display news images
     */
    public function show(string $id)
    {

        $post_images = News::where('author_id', Auth::user()->id)->findOrFail($id);

        return view('admin.news.images', compact('post_images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data = News::where('author_id', Auth::user()->id)->findOrFail($id);
        $categories = Category::all();
        $tags = DB::table('tags')->get();

        return view('admin.news.edit', compact(['data', 'categories', 'tags']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,avif', 'max:2048'],
            'image_caption' => ['nullable', 'max:200', 'string'],
            'image_copyright_link' => ['nullable', 'url'],
            'image_copyright_text' => ['nullable', 'max:180', 'string'],
            'title' => ['required', 'max:250', 'string'],
            'description' => ['required'],
            'status' => ['required', 'in:yes,no'],
            'is_comment' => ['required', 'in:yes,no'],
            'category' => ['required', 'integer'],
            'tag.*' => ['nullable', 'integer'],
            'image_id' => ['required']
        ]);

        // add news
        $news = News::where('author_id', Auth::user()->id)->findOrFail($id);
        $news->title = $request->title;
        $news->description = $request->description;
        $news->status = $request->status == 'yes' ? 1 : 0;
        $news->is_comment = $request->is_comment == 'yes' ? 1 : 0;
        $news->category_id = $request->category;
        $news->author_id = Auth::user()->id;
        $news->update();

        // update images for news
        if ($request->hasFile('image')) {

            $post_image = PostImage::where('post_id', $id)->where('image_id', $request->image_id)->firstOrFail();

            // update image
            $old_path = $post_image->image;
            $new_path = $this->updateImage($request, 'image', '/uploads/news/', $old_path);

            // update db row
            $data = [
                'image' => $new_path,
                'caption' => $request->image_caption,
                'copyright_link' => $request->image_copyright_link,
                'copyright_text' => $request->image_copyright_text
            ];

            DB::table('post_images')->where('post_id', $id)->where('image_id', $request->image_id)->update($data);
        } else {
            // update caption ,cplink ... (when not update file)
            $post_image = PostImage::where('post_id', $id)->where('image_id', $request->image_id)->firstOrFail();

            // update db row
            $data = [
                'caption' => $request->image_caption,
                'copyright_link' => $request->image_copyright_link,
                'copyright_text' => $request->image_copyright_text
            ];

            DB::table('post_images')->where('post_id', $id)->where('image_id', $request->image_id)->update($data);
        }


        // add ,remove tags for news
        $old_tags = PostTag::where('post_id', $id)->get('tag_id');

        // create array with old tags
        $old_tagsArray = array();
        foreach ($old_tags as $ot) {

            array_push($old_tagsArray, $ot->tag_id);
        }

        if ($request->tag != null) {

            foreach ($request->tag as $tag) {

                // check availability and add new tag(if not)
                if (!in_array($tag, $old_tagsArray)) {

                    $post_tag = new PostTag();
                    $post_tag->post_id = $id;
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

            $r_tag = PostTag::where('post_id', $id)->where('tag_id', $t)->firstOrFail();
            DB::table('post_tags')->where('post_id', $id)->where('tag_id', $t)->delete();
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

    // change status (news)
    public function change_status(Request $request)
    {

        $request->validate([
            'value' => 'in:yes,no'
        ]);

        //// check requested user is admin or author
        $condition = Auth::user()->hasRole('admin');
        if ($condition) {

            $data = News::findOrFail($request->id);
        } else {

            $data = News::where('author_id', Auth::user()->id)->findOrFail($request->id);
        }


        $data->status = $request->value == 'yes' ? 1 : 0;
        $data->update();

        return response(['status' => 'success', 'msg' => 'Status Updated !']);
    }

    // news -------------
    public function change_comment(Request $request)
    {

        $request->validate([
            'value' => 'in:yes,no'
        ]);

        //// check requested user is admin or author
        $condition = Auth::user()->hasRole('admin');
        if ($condition) {

            $data = News::findOrFail($request->id);
        } else {

            $data = News::where('author_id', Auth::user()->id)->findOrFail($request->id);
        }

        $data->is_comment = $request->value == 'yes' ? 1 : 0;
        $data->update();

        return response(['status' => 'success', 'msg' => 'Is Comment Updated !']);
    }

    // --------------- Image routes -----------------
    // add new image for news
    public function image_store(Request $request)
    {

        $request->validate([
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp,avif', 'max:2048'],
            'id' => ['required'],
            'image_caption' => ['nullable', 'max:200', 'string'],
            'copyrightLink' => ['nullable', 'url'],
            'copyrightText' => ['nullable', 'max:180', 'string'],
        ]);

        // if not display 404
        if (News::where('author_id', Auth::user()->id)->where('id', $request->id)->first() == null) {

            return response(['status' => 'error', 'msg' => 'Invalid']);
        }

        $post_image = new PostImage();

        $image_data = json_decode($this->uploadImage($request, 'image', '/uploads/news/'));

        $post_image->post_id = $request->id;
        $image_id = $post_image->image_id = $image_data->id;
        $path = $post_image->image = $image_data->path;
        $cap = $post_image->caption = $request->image_caption;
        $post_image->copyright_link = $request->copyrightLink;
        $post_image->copyright_text = $request->copyrightText;
        $post_image->save();

        return response(['status' => 'success', 'msg' => 'Image Added.', 'caption' => $cap, 'path' => $path, 'image_id' => $image_id, 'id' => $request->id]);
    }


    // new image update
    public function image_update(Request $request)
    {

        $request->validate([
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp,avif', 'max:2048'],
            'post_id' => 'required',
            'image_id' => 'required',
            'image_caption' => ['nullable', 'max:200', 'string'],
            'copyrightLink' => ['nullable', 'url'],
            'copyrightText' => ['nullable', 'max:180', 'string'],
        ]);

        $post_image = PostImage::where('post_id', $request->post_id)->where('image_id', $request->image_id)->firstOrFail();

        // update image
        $cap = $request->image_caption;
        $image_id = $request->image_id;
        $data = [];

        if ($request->hasFile('image')) {
            $old_path = $post_image->image;
            $new_path = $this->updateImage($request, 'image', '/uploads/news/', $old_path);

            $data = [
                'image' => $new_path,
                'caption' => $request->image_caption,
                'copyright_link' => $request->copyrightLink,
                'copyright_text' => $request->copyrightText
            ];

            $res = ['status' => 'success', 'msg' => 'Image Updated', 'caption' => $cap, 'path' => $new_path, 'image_id' => $image_id];
        } else {

            $data = [
                'caption' => $request->image_caption,
                'copyright_link' => $request->copyrightLink,
                'copyright_text' => $request->copyrightText
            ];

            $res = ['status' => 'success', 'msg' => 'Image Updated', 'caption' => $cap, 'path' => '', 'image_id' => $image_id];
        }

        DB::table('post_images')->where('post_id', $request->post_id)->where('image_id', $request->image_id)->update($data);

        return response($res);
    }

    // get specific news image details
    public function image_details($post, $image)
    {

        $image = PostImage::where('post_id', $post)->where('image_id', $image)->firstOrFail();

        return $image;
    }

    // delete image
    public function image_delete($post, $image)
    {

        $count = PostImage::where('post_id', $post)->get()->count();

        if ($count == 1) {

            return response(['status' => 'error', 'msg' => 'News must have at least one image.']);
        }

        $check_image = PostImage::where('post_id', $post)->where('image_id', $image)->firstOrFail();

        $this->deleteImage($check_image->image);

        DB::delete('DELETE FROM `post_images` WHERE `post_id` = ? AND `image_id` = ?', [$post, $image]);

        return response(['status' => 'success', 'msg' => 'Deleted !']);
    }

    // change image status
    public function image_status(Request $request)
    {

        $request->validate([
            'post_id' => 'required',
            'image_id' => 'required',
            'status' => ['required', 'in:yes,no']
        ]);

        $image = PostImage::where('post_id', $request->post_id)->where('image_id', $request->image_id)->firstOrFail();

        $status = $request->status == 'yes' ? 1 : 0;
        DB::update('UPDATE `post_images` SET `status` = ? WHERE `post_id` = ? AND `image_id` = ? ', [$status, $request->post_id, $request->image_id]);

        return response(['status' => 'success', 'msg' => 'Status updated !']);
    }
}
