<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\News;
use App\Models\Edition;
use App\Models\Category;
use App\Models\CategoryNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{

    //add news form
    public function addNewsForm()
    {
        $categories =
            Category::get();

        $editions =
            Edition::get();
        return view('component.newsForm', [
            'categories' => $categories,
            'editions' => $editions,
        ]);
    }

    //store news
    public function storeNews(Request $request)
    {

        // FormFeild for the news
        $formFields['name'] =
            $request->name;
        $formFields['description'] =
            $request->description;
        $formFields['short_brief'] =
            $request->shortBrief;
        $formFields['author'] =
            Auth::user()->name;

        //get edition id by name
        $edition = Edition::where('name', $request->edition)->get();
        $formFields['edition_id'] =
            $edition[0]->id;

        //get category id by name
        $category = Category::where('name', $request->category)->get();
        $news = News::create($formFields);

        //add to category news table
        $formFields2['news_id'] =
            $news->id;
        $formFields2['category_id'] =
            $category[0]->id;
        CategoryNews::create($formFields2);
    }

    //edit news form
    public function editNewsForm($id)
    {

        $news = News::findorfail($id);

        $selectedCategoriesIds = $news->category->pluck('id')->toarray();

        $categories =
            Category::get();

        $editions =
            Edition::get();

        return view('component.newsForm', [
            'categories' => $categories,
            'editions' => $editions,
            'news' => $news,
            'selectedCategoriesIds' => $selectedCategoriesIds,
        ]);
    }


    //get news
    public function index()
    {
        $news = News::select('*');

        return DataTables::eloquent($news)
            ->make(true);
    }
}
