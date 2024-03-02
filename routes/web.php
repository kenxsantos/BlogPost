<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home.index', []);
// })->name('home.index');

// Route::get('/contact', function () {
//     return view('home.contact');
// })->name('home.contact');

Route::get('/', [HomeController::class, 'home'])
    ->name('home.index');
Route::get('/contact', [HomeController::class, 'contact'])
    ->name('home.contact');
Route::get('/single', AboutController::class);  
    
    
    
Route::resource('posts', PostController::class);




// Route::get('/posts', function () use($posts) {
//     // dd(request()->all());
//     dd((int)request()->input('page', 1));
//     return view('post.index', ['posts' => $posts]);
// });

// Route::get('/posts/{post}/edit', function ($id){
//     $post = BlogPost::findOrFail($id); // Fetch the post using the $id parameter
//     return view('post.edit', ['post' => $post]);
// })
// ->name('post.show');
// Route::get('/recent-post/{days_ago?}', function($daysAgo =20){
//     return 'Post from ' . $daysAgo . ' Days Ago';
// })->name('post.recent.index')->middleware('auth');



// Route::prefix('/fun')->name('fun.')->group(function () use($posts){
//     Route::get('/responses', function () use($posts){       
//         return response($posts, 201)
//             ->header('Content-Type', 'application/json')
//             ->cookie('MY_COOKIE', 'Ken', 3600);
//     })
//     ->name('response');
    
//     Route::get('/redirect', function () {
//         return redirect('/contact');
//     })
//     ->name('redirect');
    
//     Route::get('/back', function () {
//         return back();
//     })
//     ->name('back');
    
//     Route::get('/named-route', function () {
//         return redirect()->route('post.show', ['id' => 1]);
//     })
//     ->name('named-route');
    
//     Route::get('/away', function () {
//         return redirect()->away('https://www.1google.com');
//     })
//     ->name('away');
    
//     Route::get('/json', function () use($posts){
//         return response()->json($posts);
//     })
//     ->name('json');
    
//     Route::get('/download', function (){
//         return response()->download(public_path('/eleven.jpg'), 'eleven.jpg');
//     })
//     ->name('download');
// });