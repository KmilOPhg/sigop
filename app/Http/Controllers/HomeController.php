<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Factory|View|RedirectResponse
     *
     * verificar el rol del usuario autenticado y redirigirlo a la vista correspondiente
     */
    public function index()
    {
        if(Auth::check()) {
            $user = Auth::user();

            if($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            if($user->hasRole('editor')) {
                return redirect()->route('editor.dashboard');
            }
            return view('home');
        }
        return redirect('/login');
    }

    public function adminDashboard() {
        return view('admin.dashboard');
    }

    public function editorDashboard() {
        return view('editor.dashboard');
    }
}
