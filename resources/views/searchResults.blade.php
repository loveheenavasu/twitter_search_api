@extends('layouts.app')
<style type="text/css">
 .nav_li{
    padding-right: 9px;
}

.column {
  float: left;
  width: 25%;
  padding: 0 10px;
}
 
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-4">
        	<div class="tweets-inspiration">
        		<h4>Tweets Inspirations for me</h4>
                <p>Use these relevant inspirations for your next tweets! Our AI engine selected these for you based on your Twitter account.</p>
                <a href="#">Edit my personalized feed</a>
            </div>
            <div class="tweet-head-btns text-right">
            	<button type="button" class="btn btn-primary mr-2" id="back" name="back">Back</button>
                <button type="button" class="btn btn-primary" onclick="window.location.reload(true);">
                	<i class="fa fa-refresh"></i> Refresh</button>
            </div>
       	</div> 
        @if(!empty($searchresults))
        <div class="row twitter-card-sec">
	        @foreach($searchresults as $result)
	        	<div class="column col-lg-4">
				    <div class="card twitter-card  mb-4 ">
			            <div class="card-header d-flex justify-content-between align-items-center p-2">
			                <div class="tweet-img"><img src="{{$result['users']}}" width="50" height="50"> </div>
			                <div class="card-header-details d-flex align-items-center">
				                <span>{{date("Y-m-d", strtotime($result['created_at'])) }}</span> 
				                <span>{{$result['tweet_id'] }}</span> 
				                <div class="card-icon">
				                	<i class="fa fa-star" aria-hidden="true"></i>
				                </div>
				                <div class="card-icon">
				                	<i class="fa fa-star" aria-hidden="true"></i>
				                </div>
			            	</div>
			                
			            </div>
			            <div class="card-body p-3">
			                <p class="card-text">
			                  {{$result['text']}}
			                </p>
			            </div>
			            <div class="card-footer p-2 d-flex justify-content-between align-items-center">
			            	@php 
			            		if ($result['likes'] > 999 && $result['likes'] <= 999999) {
								    $likes = floor($result['likes'] / 1000) . ' K';
									} elseif ($result['likes'] > 999999) {
									    $likes = floor($result['likes'] / 1000000) . ' M';
									} else {
									    $likes = $result['likes'];
									}
								if ($result['retweets'] > 999 && $result['retweets'] <= 999999) {
								    $retweets = floor($result['retweets'] / 1000) . ' K';
									} elseif ($result['retweets'] > 999999) {
									    $retweets = floor($result['retweets'] / 1000000) . ' M';
									} else {
									    $retweets = $result['retweets'];
									}	

			            	@endphp
			            	<div class="footer-links d-flex align-items-center">
				            	<a href="#" class="card-link"><i class="fa fa-heart"></i>{{$likes}}</a>
				                <a href="#" class="card-link"><i class="fa fa-retweet"></i>{{$retweets}}</a>
			            	</div>
			                <div class="btn-group">
			                      <button  class="btn btn-primary" type="submit">Edit & Tweet </button> 
			                      <div class="dropdown d-flex align-items-center pr-2">
			                          <i class="fa fa-ellipsis-v" data-toggle="dropdown">
			                          </i>
			                          <!-- <div class="dropdown-menu">
			                              <a target="_new" class="dropdown-item"
			                                 href="">more</a>
			                                 <a class="dropdown-item"
			                                 href="">more</a>
			                              <button class="dropdown-item" type="button"></button>
			                          </div> -->
			                      </div>
			                </div>
			            </div>
			    	</div>
				</div>	
			@endforeach
		</div>
		@else
		<div class="row twitter-card-sec2">	
			<h3 class="contant_box_404">
			No Result Found
			</h3>
		</div>	
		@endif 
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		$("#back").click(function(){
		window.location = "{{ url('/home') }}";
	});
	});
</script>