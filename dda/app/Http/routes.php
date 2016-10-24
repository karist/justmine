<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
| Route::get('/nerds', 'NerdsController@index');
| Route::get('/nerds/create', 'NerdsController@create');
| Route::post('/nerds', 'NerdsController@store');
| Route::get('/nerds/{id}', 'NerdsController@show');
| Route::get('/nerds/{id}/edit', 'NerdsController@edit');
| Route::put/patch('/nerds/{id}', 'NerdsController@update');
| Route::delete('/nerds/{id}', 'NerdsController@destroy');
|
*/
use App\Stub;
use App\Subbab;
use App\Stubattr;
use App\Template;
use App\Dda;
use App\Levels;
use App\master_kecs;
use App\master_kabs;
use App\master_provs;
use App\Articles;
use App\Baku;
use Stichoza\GoogleTranslate\TranslateClient;

Route::get('/articles/create', ['middleware' => 'auth', 'uses' => 'ArticlesController@create']);
Route::group(['middleware' => ['web']], function(){
  Route::get('/', function () {
      $articles = DB::table('articles')->orderBy('created_at', 'desc')->paginate(1);
      return view('homepg', compact('articles'));
  });
  Route::get('/dda', 'DDAController@index');
  Route::get('/articles', 'ArticlesController@index');

  Route::get('articles/{id}', array(
      'uses'  => 'ArticlesController@show', 
      'as'    => 'articles.show'
      )
  );
  Route::auth();
});

Route::get('admin', ['middleware' => 'admin', 'uses' => 'AdminController@index']);
Route::get('protected', ['middleware' => ['auth', 'admin'], function() {
    return "this page requires that you be logged in and an Admin";
}]);

Route::get('/admin/register', ['middleware' => 'admin', 'uses' => 'RegisterController@index']);
Route::get('/admin/dda', ['middleware' => 'admin', 'uses' => 'AdminController@showDDA']);
Route::get('/admin/user', ['middleware' => 'admin', 'uses' => 'AdminController@showUser']);
Route::get('/admin/user/{id}/edit', ['middleware' => 'admin', 'uses' => 'AdminController@editUser']);
Route::post('/admin/user/{id}', ['middleware' => 'admin', 'uses' => 'RegisterController@update']);
Route::get('/admin/templates', ['middleware' => 'admin', 'uses' => 'AdminController@showTemplates']);
Route::get('/admin/templates/create', ['middleware' => 'admin', 'uses' => 'AdminController@createTemplates']);
Route::post('/admin/templates', ['middleware' => 'admin', 'uses' => 'AdminController@storeTemplates']);
Route::get('/admin/templates', ['middleware' => 'admin', 'uses' => 'AdminController@showTemplates']);
Route::get('/admin/daerah', ['middleware' => 'admin', 'uses' => 'AdminController@showDaerah']);
Route::post('/admin/daerah/add', ['middleware' => 'admin', 'uses' => 'AdminController@addDaerah']);
Route::post('/admin/register', ['middleware' => 'admin', 'uses' => 'RegisterController@register']);

Route::group(['middleware' => 'auth'], function() {
  Route::get('/home', function (){
    $kd = Auth::user()->kode_daerah;
    $level = Auth::user()->id_level;
    $lvl = Levels::where('id', '=', $level)->first()->keterangan;
    if($level == 1){
        $daerah = master_provs::where('kode_prov', '=', $kd)->first()->nama_prov;
    } else if ($level == 2 || $level == 3){
        $daerah = master_kabs::where('id', '=', $kd)->first()->nama_kabkot;
    } else {
        $daerah = master_kecs::where('id', '=', $kd)->first()->nama_kec;
    }
    $ddas = Dda::where('user_id','=',$kd)->paginate(10);
    return view('welcomepg', compact('ddas', 'lvl', 'daerah'));
  });
  Route::resource('stubs', 'StubsController');
  Route::resource('admin/baku', 'BakuController');
  Route::resource('templates', 'TemplatesController');
  Route::resource('image', 'ImageController');
  Route::resource('/dda/{id}/entry', 'EntryTableController');
  Route::resource('text', 'TextTemplateController');
  Route::resource('admin/bab', 'BabController');
  Route::resource('/dda/{id}/layout', 'LayoutController');

  Route::get('profile', 'UserController@profile');
  Route::post('profile', 'UserController@update_avatar');
  Route::post('profile/password', 'UserController@update_password');
  Route::get('/petunjuk', 'UserController@getHelp');

  Route::get('/dda/create', 'DDAController@create');
  Route::post('/dda', 'DDAController@store');
  Route::get('/dda/{id}', 'DDAController@show');
  Route::get('/dda/{id}/edit', 'DDAController@edit');
  Route::put('/dda/{id}', 'DDAController@update');
  Route::delete('/dda/{id}', array(
    'uses'  => 'DDAController@destroy', 
    'as'    => 'dda.destroy'));

  Route::post('/articles', 'ArticlesController@store');
  Route::put('/articles/{id}', 'ArticlesController@update');
  Route::delete('/articles/{id}', array(
    'uses'  => 'ArticlesController@destroy', 
    'as'    => 'articles.destroy'));
  Route::get('/articles/{id}/edit', array(
    'uses'  => 'ArticlesController@edit', 
    'as'    => 'articles.edit'));

  Route::get('publikasi', 'PublikasiController@index');
  Route::get('/upload2', 'PublikasiController@create' );
  Route::post('/upload2', 'PublikasiController@store' );

  Route::get('/ajax-translate', function(){
  $tr = new TranslateClient('id', 'en');
  $input_text = Input::get('input_text');
  // $tr->getResponse($input_text);
  return Response::json($tr->translate($input_text));
  });

  Route::get('/ajax-stub', function(){
  $stubname = Input::get('stubname');
  $rincian = Stub::where('stubname','=',$stubname)->get();
  return Response::json($rincian);
  });

  Route::get('/ajax-subbab', function(){
    $id = Input::get('id');
    $subbabs = Subbab::where('bab','=',$id)->get();
    return Response::json($subbabs);
  });

  Route::get('/ajax-temp', function(){
    $id = Input::get('id');
    $temp = Template::where('id','=',$id)->first();
    return Response::json($temp);
  });

  Route::get('/ajax-baku', function(){
    $id = Input::get('id');
    $baku = Baku::where('id','=',$id)->first();
    return Response::json($baku);
  });

  Route::get('/ajax-kota', function(){
    $id = Input::get('id');
    $kabkots = App\master_kabs::where('prov','=',$id)->where('id_kabkot', 'like' , '7%')->get();
    return Response::json($kabkots);
  });

  Route::get('/ajax-kab', function(){
    $id = Input::get('id');
    $kabkots = App\master_kabs::where('prov','=',$id)->where('id_kabkot', 'not like' , '7%')->get();
    return Response::json($kabkots);
  });

  Route::get('/ajax-kabkot', function(){
    $id = Input::get('id');
    $kabkots = App\master_kabs::where('prov','=',$id)->get();
    return Response::json($kabkots);
  });

  Route::get('/ajax-kec', function(){
    $id = Input::get('id');
    $prov = substr($id, 0, 2);
    $kab = substr($id, 2, 2);
    $kecamatans = App\master_kecs::where('prov','=',$prov)->where('kabkot','=',$kab)->get();
    return Response::json($kecamatans);
  });

  Route::get('/desa', function(){
    $kec = Input::get('kec');
    $desas = App\master_desas::where('id','like',$kec.'%')->get();
    return Response::json($desas);
  });

  Route::get('/ajax-temp-ed', function(){
    $id = Input::get('id');
    $temp = Template::where('id','=',$id)->first();
    return Response::json($temp);
  });

  Route::get('/anades', function(){
    $id = Input::get('id');
    $sub = Input::get('sub');
    $result = DB::table('anades')->where('ddaname',$id)->where('subbab', $sub)->first();
    return Response::json($result);
  });

  Route::get('/narasi', function(){
    $id = Input::get('id');
    $bab = Input::get('bab');
    $result = DB::table('narasis')->where('ddaname',$id)->where('bab', $bab)->first();
    return Response::json($result);
  });

  Route::get('/aj', function(){
    $table = Input::get('table');
    $id = Input::get('id');
    $dda = Dda::where('id', '=', $id)->first();
    // $isi = explode(',', $dda->isi);

    $t = Template::where('id', '=', $table)->first();
    $e = json_decode($t->tabtemplate, true);
    $kol = $e['table']['column'];
    $stub = $e['table']['stubname'][0];
    $tahun = $dda->tahun;

    $matches = preg_grep("/tahun/", $kol);
    if ($matches) {
      foreach ($matches as $key=>$value) {
        $a = str_replace('$tahun', $tahun, $value);
        $kol[$key] = eval('return '.$a.';');
      }
      foreach($kol as $key=>$col){
        if(Schema::hasColumn($stub, $table.$col)){
        } else {
          unset($kol[$key]);
        }
      }
      $nama_kolom = array_merge(array($stub),explode(',',$table.implode(','.$table, $kol)));

      $arr = DB::table($stub)
      ->select($nama_kolom)
      // ->where('ddaname', '=', $id)
      ->get();
    } else {
      $nama_kolom = array_merge(array($stub),explode(',',$table.implode(','.$table, $kol)));

      $arr = DB::table($stub)
          ->select($nama_kolom)
          ->where('ddaname', '=', $id)
          ->get();    
    }

    foreach($kol as $key=>$col){
        if(Schema::hasColumn($stub, $tab_id.$col)){
        } else {
          unset($kol[$key]);
        }
    }

    
    return Response::json(str_replace($table, '', json_encode($arr))); // str_replace ($search , $replace , $subject)
  });

  Route::get('/project', function (){
    return view('dda/dda-edit');
  });

  Route::get('/{id}/result/print', 'PrintController@print2file');

  Route::post('dda/{id}/generate', array(
      'uses'  => 'GenController@createPDF', 
      'as'    => 'generate'
      ));

  Route::get('/data', 'DataController@index');
  Route::get('/format', function(){
    return view('formatTable');
  });
});
Route::resource('allform', 'AllFormController');
Route::resource('form', 'FormController');

Route::resource('translate', 'TranslateController');
Route::resource('/dda/{id}/narasi', 'NarasiController');
Route::resource('/dda/{id}/anades', 'AnadesController');


Route::get('pdfview',array('as'=>'pdfview','uses'=>'ItemController@pdfview'));
Route::get('/{id}/result', array('as'=>'result','uses'=>'ResultController@index'));
Route::get('/{id}/publish', array('as'=>'publish','uses'=>'ResultController@publish'));

Route::get('github', 'PdfController@github');
Route::get('tcpdf', 'PdfController@tcpdf');
Route::get('prince', 'PdfController@prince');
Route::get('timeseries', 'TimeController@index');
Route::get('relation', function(){
  // $comments = App\Subbab::find(1);
  // dd($comments->bab->nama_bab);
    $table = '62';
    $id = '201831';
    $tahun = 2018;
    $dda = Dda::where('id', '=', $id)->first();

    $t = Template::where('id', '=', $table)->first();
    $e = json_decode($t->tabtemplate, true);
    $kol = $e['table']['column'];
    $stub = $e['table']['stubname'][0];
    $matches = preg_grep("/tahun/", $kol);
    if ($matches) {
      foreach ($matches as $key=>$value) {
        $a = str_replace('$tahun', $tahun, $value);
        $kol[$key] = eval('return '.$a.';');
      }
      foreach($kol as $key=>$col){
        if(Schema::hasColumn($stub, $table.$col)){
        } else {
          unset($kol[$key]);
        }
      }
      $nama_kolom = array_merge(array($stub),explode(',',$table.implode(','.$table, $kol)));

      $arr = DB::table($stub)
      ->select($nama_kolom)
      // ->where('ddaname', '=', $id)
      ->get();
    } else {

    }  
    dd($arr);
});

// Route::get('/getPDF', 'PDFController@getPDF');
// Route::get('/convert', 'ConverterController@convert');
// Routes::get('/data', 'DataController@index');
// Route::get('/dda/{content_name}', 'ContentController@show')->middleware('auth');

// Route::post('/stub','TemplatesController@storeStub');
// Route::post('/stub','TemplatesController@storeStub');

// Route::get('/save', 'FOPController@savePDF');
// Route::post('/trial', 'TrialController@store');
// });
// Route::get('/upload', 'ImageController@upload' );
// Route::post('/upload', 'ImageController@store' );
// Route::get('/image', 'ImageController@show' );
// Route::post('/index','ColumnController@send');
// Route::get('/index','ColumnController@show');
// Route::get('/index', function (){
//   return view('index');
// });


// Route::get('/image', 'ImageController@show' );

// Route::get('/login', 'LoginController@getLogin');
// Route::post('/login', 'LoginController@postLogin');



// Route::auth();

// Route::get('/home', 'HomeController@index');

// Route::auth();

// Route::get('/home', 'HomeController@index');

// Route::get('/{id}/result', array('as'=>'result','uses'=>'ResultController@index'));
// Route::get('admin/template', 'BakuController');

// Route::resource('trial', 'TrialController'); // tambah - kurang field
// Route::get('/kolom', function (){ // membuat nested input field
//   return view('kolom');
// });
// Route::get('/welcom', 'WelcomController@index');
Route::get('/coba', 'GenController@createTCPDF');
Route::get('snappy', function(){
  $directory = 'published';
  $files = File::allFiles($directory);
  $pdf = snappyPDF::LoadView('dda', compact('files'));
  // return $pdf->stream();
  return $pdf->download('welcome.pdf');
});
