<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ImpCategories;
use App\Models\News;
use App\Models\Tag;
use App\Models\Video;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    /// return home page
    public function index()
    {

        $title = 'Home';

        // most viewed posts
        /// get popular news within month
        $date = new DateTime();

        // get previous motnth
        $date = $date->modify('-5 month');

        /// format month
        $date = $date->format('Y-m-d');
        $popular_news = News::where('status', 1)->where('updated_at', '>=', $date)->orderBy('views', 'desc')->limit(8)->get(['id', 'title', 'category_id', 'updated_at', 'author_id']);

        /// recently added news
        $latest_news = News::where('status', 1)->where('updated_at', '>=', $date)->orderBy('created_at', 'desc')->limit(7)->get(['id', 'title', 'category_id', 'description', 'updated_at', 'views']);

        /// get home categories with news
        $category_news = ImpCategories::with(['Category.News' => function ($query) use ($date) {
            $query->where('status', 1)
                ->where('updated_at', '>=', $date)
                ->orderBy('updated_at', 'desc')
                ->limit(6)
                ->select(['id', 'title', 'category_id', 'description', 'updated_at', 'views']);
        }])->get();

        $videos = Video::where('status' ,1)->whereOr('updated_at' ,'>=' ,$date)->orderBy('updated_at' ,'desc')->limit(5)->get(['id' ,'post_id' ,'url' ,'author' ,'updated_at' ,'description']);

        return view('frontend.pages.home', compact([
            'popular_news',
            'latest_news',
            'category_news',
            'title',
            'videos'
        ]));
    }

    //// return post page
    public function getPost($id)
    {

        $title = 'Post';

        $news = News::findOrFail($id);
        /// update view count
        $news->views = $news->views + 1;

        /// disable log for updating views
        $news->disableLogging();
        $news->update();

        // get other similar news
        $liked_news = News::where('status', 1)->where('category_id', $news->category_id)->limit(2)->orderBy('created_at', 'desc')->get(['id', 'title', 'description']);

        // get selected categories
        $categories = ImpCategories::all();

        /// get popular news within month
        $date = new DateTime();

        // get previous motnth
        $date = $date->modify('-1 month');

        /// format month
        $date = $date->format('Y-m-d');
        $popular_news = News::where('status', 1)->where('created_at', '>=', $date)->orderBy('views', 'desc')->limit(5)->get(['id', 'title', 'category_id', 'created_at']);

        return view('frontend.pages.post', compact([
            'news',
            'liked_news',
            'categories',
            'popular_news',
            'title'
        ]));
    }

    //// return video page
    public function getVideo($id) {

        $title = 'Post Video';

        $video = Video::findOrFail($id);

        // get other similar news
        $liked_news = News::where('status', 1)->where('category_id', $video->category_id)->limit(2)->orderBy('created_at', 'desc')->get(['id', 'title', 'description']);

        // get selected categories
        $categories = ImpCategories::all();

        /// get popular news within month
        $date = new DateTime();

        // get previous motnth
        $date = $date->modify('-1 month');

        /// format month
        $date = $date->format('Y-m-d');
        $popular_news = News::where('status', 1)->where('created_at', '>=', $date)->orderBy('views', 'desc')->limit(5)->get(['id', 'title', 'category_id', 'created_at']);

        return view('frontend.pages.video', compact([
            'video',
            'liked_news',
            'categories',
            'popular_news',
            'title'
        ]));
    }


    //// return news related to the specific category
    public function getPostCategory($category_id)
    {

        $category = Category::findOrFail($category_id);
        $results = News::where('status', 1)->where('category_id', $category_id)->orderBy('created_at', 'desc')->paginate(16 ,['id' ,'title' ,'author_id' ,'created_at']);

        $title = $txt = $category->name;

        return view('frontend.pages.search', compact([
            'results',
            'txt',
            'title'
        ]));
    }


    //// return search results
    public function getSearchResult(string $key)
    {

        //// get result from categories and tags
        $search_cat = Category::where('name', 'LIKE', "%$key%")->get(['id', 'name']);

        $search_tag = Tag::where('name', 'LIKE', "%$key%")->get(['id', 'name']);

        $search_result = $search_cat->merge($search_tag);

        //// check is there any search result available
        if (count($search_result) == 0) {

            return response(['status' => 'n', 'search_result' => $search_result]);
        }

        return response(['status' => 'y', 'search_result' => $search_result]);
    }

    //// return search view
    public function search(string $key)
    {

        Validator::make(
            [
                'key' => $key
            ],

            [
                'key' => ['required', 'string', 'max:200']
            ]
        );


        $results = News::where('status', 1)
               ->where(function ($query) use ($key) {
                   $query->where('title', 'LIKE', "%$key%")
                         ->orWhereHas('category', function ($query) use ($key) {
                             $query->where('name', 'LIKE', "%$key%");
                         });
               })
               ->orderBy('created_at', 'desc')
               ->paginate(16 ,['id' ,'title' ,'author_id' ,'created_at']);


        $title = 'Search';
        $txt = $key;


        return view('frontend.pages.search', compact([
            'results',
            'txt',
            'title'
        ]));
    }
}
