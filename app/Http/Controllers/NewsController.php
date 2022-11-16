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
            'news' => new News,
            'selectedCategoriesIds' => [],
        ]);
    }

    //store news
    public function storeNews(Request $request)
    {

        $categoriesArr = explode(',', $request->category);

        // FormFeild for the news
        $formFields['name'] =
            $request->name;
        $formFields['description'] =
            $request->description;
        $formFields['short_brief'] =
            $request->shortBrief;

        if (Auth::check()) {
            $formFields['author'] =
                Auth::user()->name;
        } else {
            $formFields['author'] = 'Guest';
        }

        $formFields['edition_id'] =
            $request->edition;

        $news = News::create($formFields);

        $news->category()->sync($categoriesArr);
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

    //update news
    public function updateNews(Request $request, $id)
    {
        $categoriesArr = explode(',', $request->category);


        $news = News::findorfail($id);

        // FormFeild for the news
        $formFields['name'] =
            $request->name;
        $formFields['description'] =
            $request->description;
        $formFields['short_brief'] =
            $request->shortBrief;

        if (Auth::check()) {
            $formFields['author'] =
                Auth::user()->name;
        } else {
            $formFields['author'] = 'Guest';
        }


        $formFields['edition_id'] =
            $request->edition;

        $news->update($formFields);

        $news->category()->sync($categoriesArr);
    }



    //get news
    public function index()
    {
        $news = News::select('*');

        return DataTables::eloquent($news)
            ->make(true);
    }
}
