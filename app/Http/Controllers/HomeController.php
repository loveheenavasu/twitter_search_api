<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }
    
    public function adminHome()
    {
        return view('adminHome');
    }

    public function searchresults(Request $request)
    {
        $searchKeyword=$request->searchkey;
        $searchKeyword= str_replace(" ","%20",$searchKeyword);
        //$date = date('Y-m-d',strtotime("+1 days")).'T'.date('H:i').':00-00:00';
        if(!empty($searchKeyword)){
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.twitter.com/1.1/search/tweets.json?count=100&result_type=popular&q='.$searchKeyword.' ',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer AAAAAAAAAAAAAAAAAAAAAFQZUgEAAAAA8oIog9q1aP6gYIBM1bObD5nblAM%3DJkG6VjIIkIQSIXZ1xXAjysMqwsJeoXxvWJzJvtggW1oqXhJ4YM'
              ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $result = (json_decode($response));
            if(isset($result->statuses)){
                $allResult = $result->statuses;
                $j = 0;
                $finalResult = [];
                foreach($allResult as $key => $res){
                    if($res->retweet_count>= 10 && $res->favorite_count >= 100)
                    {
                        $finalResult[$j]['created_at'] = $res->created_at;
                        $finalResult[$j]['tweet_id'] = $res->id;
                        $finalResult[$j]['text'] = $res->text;
                        $finalResult[$j]['retweets'] = $res->retweet_count;
                        $finalResult[$j]['likes'] = $res->favorite_count;
                        $finalResult[$j]['users'] = $res->user->profile_image_url;
                    }
                    $j++;
                } 
            }
        }
        if(isset($finalResult)){
            return view('searchResults')->with('searchresults',$finalResult);
        }
        else{
            echo "nothing";
        }
    }

    
}
