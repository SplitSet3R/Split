@extends('layouts.app')
@section('styles')
<link rel="stylesheet" type="text/css" href="css/legacy/images.css"/>
<link rel="stylesheet" type="text/css" href="css/legacy/typography.css"/>
<link rel="stylesheet" type="text/css" href="css/legacy/expenses.css"/>
@endsection
@section('scripts')
<script src="https://use.fontawesome.com/156688d0a4.js"></script>
@endsection
@section('content')
<div class="container main-content">
    <div class="row">
      <div class="jumbotron" style="background-image: url('images/gathering.jpg');" >
        <br>
        <br>
        <br>
   <div class="container" style="font-family:courier;color:white;background: rgba(33, 33, 33, .9);">
        <br>
      <div>
          <!-- way to direct back to dashboard from split.app -->
          <a href="dashboard" style="text-decoration: none !important; color: white;"><h1>Split</h1></a>
            <hr>
         <p style="font-size:18px;">Track shared expenses as well as your own -- all in one place.</p>
         <!--<p><a class="btn btn-lg" href="signup.php" role="button">Learn more &raquo;</a></p>-->
     </div>
      <br>
   </div>
   <br>
   <br>
 </div>
   <!-- Example row of columns -->
   <div class="row">
       <div class="col-md-4">
         <img src="images/thinking.png" class="front-page-images">
       </div>
       <div class="col-md-4">
         <img src="images/restaurant.png" class="front-page-images">
       </div>
       <div class="col-md-4">
         <img src="images/coffee.png" class="front-page-images">
       </div>
   </div>
   <hr>

</div>
@endsection
