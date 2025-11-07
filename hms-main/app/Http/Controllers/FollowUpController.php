<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use robertogallea\LaravelPython\Services\LaravelPython;

class FollowUpController extends Controller
{
    //

    public function sendMessage($number,$body) {
        

        // curl requrest "http://104.238.176.133:5000/?phone=+9647518775861&message=hello"
        
        $ch = curl_init();

// set URL and other appropriate options
// encode the message
$body = urlencode($body);

curl_setopt($ch, CURLOPT_URL, "http://104.238.176.133:5000/?phone=$number&message=$body");
curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);

return "done";

    }

}
