<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Http;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    

    public function backup()
    {
        $filename = "backup-".date("d-m-Y-H-i-s").".sql";
        $mysqlPath = "mysqldump";

    try{
        $command = "$mysqlPath --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "/" . $filename."  2>&1";
        $returnVar = NULL;
        $output  = NULL;
        exec($command, $output, $returnVar);
        $contents=  file_get_contents(storage_path() . "/" . $filename);

        $response = Http::post('http://104.238.176.133/hms/public/api/importdb', [
            'db' => $contents,
        ]);

        return $response;//ok

     }catch(Exception $e){
        return "0 ".$e->errorInfo; //some error
     }
    }
}
