<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payments;
use App\Models\OperationHold;
use DB;
use Storage;
use Illuminate\Support\Facades\Http;
class SettingController extends Controller
{
    //

    public function import(Request $request)
    {

        
        $fileTemp = $request->file('db');
           
        //Storage::putFile('uploadbackup', $request->file('db'));

        $path = $fileTemp->storeAs(
            'uploadbackup', "newdb.gz"
        );
        



       
       // return system("gunzip -c /var/www/html/hms/storage/$path | mysql -u root -phmsrootpassword  hms2");
        
       $file ="/var/www/html/hms/storage/app/$path";
       system("gzip -dc < ".$file." | mysql -u root -phmsrootpassword hms2");

     

        return $path;
    }

    public function backup()
    {
        $filename = "backup-".date("d-m-Y-H-i-s").".sql";
        $mysqlPath = "mysqldump";

    try{
        $command = "$mysqlPath --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " | gzip -c > " . storage_path() . "/" . $filename."  2>&1";
        $returnVar = NULL;
        $output  = NULL;
        exec($command, $output, $returnVar);
        $contents=  file_get_contents(storage_path() . "/" . $filename);

        $response  =  Http::attach('db', $contents, 'db.mysql')->post("http://womanhealth.hospital/api/importdb");

     

        return $response;//ok

     }catch(Exception $e){
        return "0 ".$e->errorInfo; //some error
     }
    }
}
