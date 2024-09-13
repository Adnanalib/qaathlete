<?php

namespace App\Http\Controllers;

use App\DataTables\SearchAthleteCoachDataTable;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\View as BladeView;

class LandingController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return redirect()->route('login');
    }
    public function download()
    {
        if(config('qr.isEnabled') == 'true'){
            $contents = file_get_contents(auth()->user()->qr_image_url);
            $headers = [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="image.jpg"'
            ];
            return response($contents, 200, $headers);
        }
        return response()->download(public_path(Storage::url(auth()->user()->qr_image_url)));
    }
    public function dashboard()
    {
        return redirect(getCurrentUserHomeUrl());
    }
    public function settings()
    {
        return view('settings');
    }
    public function search(SearchAthleteCoachDataTable $dataTable, Request $request)
    {
        BladeView::share('search',$request->search);
        return $dataTable->render('search-athlete-coach');
    }

}
