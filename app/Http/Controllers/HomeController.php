<?php

namespace App\Http\Controllers;
use App\Models\SocialTwitterAccount;
use App\Models\User;
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
              CURLOPT_URL => 'https://api.twitter.com/2/tweets/search/recent?max_results=30&query='.$searchKeyword.'&tweet.fields=author_id,created_at,referenced_tweets,public_metrics',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer AAAAAAAAAAAAAAAAAAAAABHSUgEAAAAAxdx4BIWRLJOLwWiGFRUJKZIxwmA%3DzjkV4Ybtc5E0ft6EtLqaYYGEYviuo5U5wWemRVOeFK1iOS8KDL'
              ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $result = (json_decode($response));
            $i=0;
            foreach($result as $key => $res){
                foreach($res as $key => $final){
                    //echo "<pre>";print_r($final);
                    if(isset($final->referenced_tweets)){
                            $rid=$final->referenced_tweets[0]->id;
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                              CURLOPT_URL => 'https://api.twitter.com/2/tweets/'.$rid.'?tweet.fields=author_id,created_at,text,public_metrics',
                              CURLOPT_RETURNTRANSFER => true,
                              CURLOPT_ENCODING => '',
                              CURLOPT_MAXREDIRS => 100,
                              CURLOPT_TIMEOUT => 0,
                              CURLOPT_FOLLOWLOCATION => true,
                              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                              CURLOPT_CUSTOMREQUEST => 'GET',
                              CURLOPT_HTTPHEADER => array(
                                'Authorization: Bearer AAAAAAAAAAAAAAAAAAAAABHSUgEAAAAAxdx4BIWRLJOLwWiGFRUJKZIxwmA%3DzjkV4Ybtc5E0ft6EtLqaYYGEYviuo5U5wWemRVOeFK1iOS8KDL',
                                'Cookie: guest_id=v1%3A163392723975046164; personalization_id="v1_qPiVyU/oxA4TY/lTTPFY5A=="'
                              ),
                            ));

                            $response = curl_exec($curl);

                            curl_close($curl);
                            $userResult = json_decode($response);
                           // echo "<pre>";print_r($userResult->data->public_metrics);die;
                            if(isset($userResult->data->public_metrics)){
                            if($userResult->data->public_metrics->retweet_count >= 10 && $userResult->data->public_metrics->like_count >= 100 ){
                                $id = $userResult->data->author_id;
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://api.twitter.com/2/users/'.$id.'?user.fields=profile_image_url',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 100,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'GET',
                                CURLOPT_HTTPHEADER => array(
                                    'Authorization: Bearer AAAAAAAAAAAAAAAAAAAAABHSUgEAAAAAxdx4BIWRLJOLwWiGFRUJKZIxwmA%3DzjkV4Ybtc5E0ft6EtLqaYYGEYviuo5U5wWemRVOeFK1iOS8KDL',
                                    'Cookie: guest_id=v1%3A163392723975046164; personalization_id="v1_qPiVyU/oxA4TY/lTTPFY5A=="'
                                ),
                            ));
                            $response = curl_exec($curl);

                            curl_close($curl);
                            $Finale = json_decode($response,true);
                            //echo "<pre>";print_r($Finale);die;
                            $finalResult[$i]['twitter_id'] =$final->id;;
                            $profileImage = $Finale['data']['profile_image_url'];
                            $finalResult[$i]['users'] = $profileImage;
                            $finalResult[$i]['created_at'] = $userResult->data->created_at;
                            $finalResult[$i]['text'] = $userResult->data->text;
                            $finalResult[$i]['retweets'] = $userResult->data->public_metrics->retweet_count;
                            $finalResult[$i]['likes'] = $userResult->data->public_metrics->like_count;
                        }
                    }

                        
                            
                        
                        
                    }
                    $i++;
                }
            }
        }
      
        //echo "<pre>";print_r($finalResult);die;
        if(isset($finalResult)){
            return view('searchResults')->with('searchresults',$finalResult);
        }
        else{
            $finalResult = [];
            return view('searchResults')->with('searchresults',$finalResult);
        }
    }


}
