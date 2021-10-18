@extends('layouts.app')
   
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    <p>Improve the search relevancy</p>
                    <p>Enter 2 to 3 keywords(comma seperated) that will be used to serach inspirational tweets.</p>

                    <a href="#">or edit all the search parameters in the settings</a>
                    <form action="{{route('searchresults')}}" method="post">
                        @csrf
                    <div class="form-group">
                    <input class="form-control" type="text" name="searchkey" id="searchkey" placeholder="company culture,teamwork,team management">
                    </div>    
                    <div class="btn-group">
                        <input name="searchtweet" value= "searchtweet" id="searchtweet" class="btn btn-primary" type="submit"></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
//         $("#searchtweet").click(function(){
//         var searchKeyword= $("#searchkey").val();
//         $.ajax({
//           url: "/searchKeywords",
//           data:{searchKeyword:searchKeyword},
//           success: function(result){
//             alert(result.redirect);
//             // console.log(result);
//             // window.location.replace('searchresults'); 
              
//           }
//         });
//     });

    });

</script>
