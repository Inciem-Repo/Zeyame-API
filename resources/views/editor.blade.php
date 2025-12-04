<!DOCTYPE html>
<html id = "fullpage">
   <head>
      <title>Poster Editor</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <link href="
         https://fonts.googleapis.com/css?family=Noto+Sans|Padauk|Concert+One|Hind|Josefin+Sans|Raleway|Nunito+Sans|Oswald|Poppins|Anton|Roboto|Lato|Montserrat|Baloo|Muli" rel="stylesheet">
      <!-- <link href=" http://fonts.webtoolhub.com/font-n17979-kruti-dev-010.aspx" rel="stylesheet"> -->
      <link href=" https://www.dafont.com/stanberry.font" rel="stylesheet">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
      <link rel="stylesheet" href="fonts.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
      <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <script type="text/javascript" src="js/html2canvas.js"></script>
      <script type="text/javascript" src="js/jquery.plugin.html2canvas.js"></script>
      <style>
         .slidecontainer {
         width: 100%;
         }
         .slider {
         -webkit-appearance: none;
         width: 100%;
         height: 25px;
         background: #d3d3d3;
         outline: none;
         opacity: 0.7;
         -webkit-transition: .2s;
         transition: opacity .2s;
         }
         .slider:hover {
         opacity: 1;
         }
         .slider::-webkit-slider-thumb {
         -webkit-appearance: none;
         appearance: none;
         width: 25px;
         height: 25px;
         background: #;
         cursor: pointer;
         }
         .slider::-moz-range-thumb {
         width: 25px;
         height: 25px;
         background: #4CAF50;
         cursor: pointer;
         }
      </style>
      <style>
         body{
         margin:0 !important;
         }
         #target{
         margin:0 !important;
         z-index: 0;
         float:left;
         padding: 0 !important;
         box-shadow: 0px 2px 8px #c2c2c2;
         }
         #myarea{
         outline : 0;
         border:none;
         background-color: transparent;
         }
         .textbox{
         background-color: transparent;
         font-size: 25px;
         border:none;
         outline: none;
         }
         .rightside{
         width: 48%;
         padding-right: 8%;
         }
         .colors,.bkcolors,.shcolors{
         width: 26px;
         height: 26px;
         border: none;
         padding:8px;
         }
         #myRange{
         margin-left: 1%;
         margin-top: 1%;
         display: inline-block;
         width: 93% !important;	
         }
         .sliders{
         margin-left: 1%;
         margin-top: 1%;
         display: inline-block;
         width: 93% !important;	
         }
         .colorpalet{
         margin-left: 0%;
         margin-top: 15px !important;
         width: fit-content;
         /* display: inline; */
         padding-top: 0%;
         }
         .colorbox{
         padding-left: 5px;
         margin-left: 24px;
         }
         .container{
         padding-bottom: 17px;
         background-color: #f7f7f7;
         box-shadow: 0px 2px 8px #c2c2c2;
         }
         .dropdown{
         margin-top: 13px;
         font-size: 17px;
         border-radius: 5px;
         background-color: #dddddd;
         border: none;
         padding: 8px;
         }
         .htu{
         background-color: #f7f7f7;
         padding: 11px;
         border-radius: 5px;
         left: 1%;
         top: 80% !important;
         float: left;
         position: absolute;
         box-shadow: 0px 2px 8px #c2c2c2;
         }
         .mainholder{
         height: 100%;
         padding: 2%;
         }
         .controllers{
         padding-left: 15px;
         }
         .savebtn{
         background-color: #008cff;
         color: white;
         }
         #target{
         width: {{$width}};
         height: {{$height}};
         position: relative;
         margin-top: 3% !important;	
         margin-left: 11% !important;
         background-image: url({{url('../../posterimages')}}/{{$item['ofile']}});
         background-position: center;
         background-repeat: no-repeat;
         background-size: cover;
         }

         @font-face {
         font-family: Kruti;
         src: url(kruti.ttf);
         }
         @font-face {
         font-family: Stanberry;
         src: url(Stanberry.ttf);
         }
         .br-0{
         border-radius : 0px !important;
         }
         .w-100{
         width: 100%;
         height:100%;
         }
         .p-0{
         border: 1px solid #9c2424;
         background-color: brown;
         color: white;
         font-weight: 500;
         border: 1px solid #4f4f4f;
         background-color: #646464;
         font-size: 1.2vw;
         }
         .p-0:hover{
         border: 1px solid #9c2424;
         background-color: white;
         color: black;
         font-weight: 5004caf50;	 
         border: 1px solid #4f4f4f;
         }
         .p-0:focus{
         outline:none !important;
         border:none !important;
         box-shadow:none !important;
         }
         .no-hvr:hover{
         border: 1px solid #9c2424;
         background-color: #9c2424 !important;
         color: white !important;
         font-weight: 500;
         border: 1px solid #4f4f4f;
         background-color: #4f4f4f !important;
         }
         .no-hvr{
         border: 1px solid #9c2424;
         background-color: #9c2424 !important;
         color: white !important;
         font-weight: 500;
         border: 1px solid #4f4f4f;
         background-color: #4f4f4f !important;
         }
         .h-add{
         }
         .fl{
         float:left;
         }
         body{
         overflow:hidden;
         }
         .controlbox{
         opacity:0.9;
         padding: 0;
         box-shadow: 0px 2px 10px black;
         transition:1s;
         }
         .controlbox:hover{
         opacity:1;
         box-shadow: 0px 2px 10px black;
         }
         .themearrow{
         position: absolute;
         top: 2%;
         left: 2%;
         font-size: 29px;
         color: #5f5959;
         }
         .icons{
         margin-left: 11px;
         font-size: 20px;
         }
         ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
         color: #d8d5d5;
         opacity: 1; /* Firefox */
         }
         #image-holder{
         display: block;
         position: fixed;
         top: 0px;
         left: 0px;
         z-index: 1000;
         width: 100%;
         height: 100%;
         background-color: #2d2d2de8;
         text-align: center;
         }
         #showimage{
         margin-top: 2%;
         }
         #closeholder{
         color: white;
         position: absolute;
         float: right;
         right: 0;
         top: 0;
         font-weight: 800;
         font-size: 37px;
         font-family: Muli;
         padding: 1%;
         padding-right: 2%;
         background-color: #00000063;
         padding-left: 2%;
         margin: 1%;
         border-radius: 3px;
         cursor: pointer;
         }
      </style>
   </head>
   <body onload="fontsizeadder(this);" onresize="fontsizeadder(this);" style = "background-image: url('images/background.png');display:none;">
      <div class = "container-fluid">
         <div class = "row">
            <div class = "col-md-8">
            
               <div id = "image-holder" style = "display:none; position:fixed;
                  top: 0;
                  left: 0;z-index:1000;
                  width:100%;
                  height:100%;">
                  <p onclick = "closeholder()" id = "closeholder" style="font-color:white;">X</p>
                  <img id = "showimage" src = ""/>
               </div>

               <form method="POST" enctype="multipart/form-data" action="save.php" id="myForm">
                  <input type="hidden" name="img_val" id="img_val" value="" />
               </form>
               
               <div id="target">
                  <div id = "main_bg" style = "z-index: 0;position: absolute;height: 100%;width:100%;"></div>
                  @if($flag)

                  @if($item['video']==0)
                  <div class="textbox @if(isset($styles[0]['show'])) {{$styles[0]['show']}} @endif @if(isset($styles[0]['centerv'])) {{$styles[0]['centerv']}} @endif @if(isset($styles[0]['centerh'])) {{$styles[0]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[0]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[0]['top']}}px; left: {{$styles[0]['left']}}px;  font-size: @if(isset($styles[0]['font-size'])) {{$styles[0]['font-size']}}px @else 20px @endif" contenteditable><font color="@isset($styles[0]['color']) {{$styles[0]['color']}}  @endisset">{{$styles[0]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[1]['show'])) {{$styles[1]['show']}} @endif @if(isset($styles[1]['centerv'])) {{$styles[1]['centerv']}} @endif @if(isset($styles[1]['centerh'])) {{$styles[1]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[1]['id']}}" style="font-family: arial; z-index: 2;  position: absolute; top: {{$styles[1]['top']}}px; left: {{$styles[1]['left']}}px;  font-size: @if(isset($styles[1]['font-size'])) {{$styles[1]['font-size']}}px @else 40px @endif" contenteditable><font color="@isset($styles[1]['color']) {{$styles[1]['color']}}  @endisset">{{$styles[1]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[2]['show'])) {{$styles[2]['show']}} @endif @if(isset($styles[2]['centerv'])) {{$styles[2]['centerv']}} @endif @if(isset($styles[2]['centerh'])) {{$styles[2]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[2]['id']}}" style="font-family: arial; z-index: 3;  position: absolute; top: {{$styles[2]['top']}}px; left: {{$styles[2]['left']}}px;;  font-size: @if(isset($styles[2]['font-size'])) {{$styles[2]['font-size']}}px @else 40px @endif" contenteditable><font color="@isset($styles[2]['color']) {{$styles[2]['color']}}  @endisset">{{$styles[2]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[3]['show'])) {{$styles[3]['show']}} @endif @if(isset($styles[3]['centerv'])) {{$styles[3]['centerv']}} @endif @if(isset($styles[3]['centerh'])) {{$styles[3]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[3]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[3]['top']}}px; left: {{$styles[3]['left']}}px;  font-size: @if(isset($styles[3]['font-size'])) {{$styles[3]['font-size']}}px @else 27px @endif" contenteditable><font color="@isset($styles[3]['color']) {{$styles[3]['color']}}  @endisset">{{$styles[3]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[5]['show'])) {{$styles[5]['show']}} @endif @if(isset($styles[5]['centerv'])) {{$styles[5]['centerv']}} @endif @if(isset($styles[5]['centerh'])) {{$styles[5]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[5]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[5]['top']}}px; left: {{$styles[5]['left']}}px;  font-size: @if(isset($styles[5]['font-size'])) {{$styles[5]['font-size']}}px @else 27px @endif" contenteditable><font color="@isset($styles[5]['color']) {{$styles[5]['color']}}  @endisset">{{$styles[5]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[7]['show'])) {{$styles[7]['show']}} @endif @if(isset($styles[7]['centerv'])) {{$styles[7]['centerv']}} @endif @if(isset($styles[7]['centerh'])) {{$styles[7]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[7]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[7]['top']}}px; left: {{$styles[7]['left']}}px;  font-size: @if(isset($styles[7]['font-size'])) {{$styles[7]['font-size']}}px @else 27px @endif" contenteditable><font color="@isset($styles[7]['color']) {{$styles[7]['color']}}  @endisset">{{$styles[7]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[8]['show'])) {{$styles[8]['show']}} @endif @if(isset($styles[8]['centerv'])) {{$styles[8]['centerv']}} @endif @if(isset($styles[8]['centerh'])) {{$styles[8]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[8]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[8]['top']}}px; left: {{$styles[8]['left']}}px;  font-size: @if(isset($styles[8]['font-size'])) {{$styles[8]['font-size']}}px @else 28px @endif" contenteditable><font color="@isset($styles[8]['color']) {{$styles[8]['color']}}  @endisset">{{$styles[8]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[9]['show'])) {{$styles[9]['show']}} @endif @if(isset($styles[9]['centerv'])) {{$styles[9]['centerv']}} @endif @if(isset($styles[9]['centerh'])) {{$styles[9]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[9]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[9]['top']}}px; left: {{$styles[9]['left']}}px;  font-size: @if(isset($styles[9]['font-size'])) {{$styles[9]['font-size']}}px @else 29px @endif" contenteditable><font color="@isset($styles[9]['color']) {{$styles[9]['color']}}  @endisset">{{$styles[9]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[10]['show'])) {{$styles[10]['show']}} @endif @if(isset($styles[10]['centerv'])) {{$styles[10]['centerv']}} @endif @if(isset($styles[10]['centerh'])) {{$styles[10]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[10]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[10]['top']}}px; left: {{$styles[10]['left']}}px;  font-size: @if(isset($styles[10]['font-size'])) {{$styles[10]['font-size']}}px @else 210px @endif" contenteditable><font color="@isset($styles[10]['color']) {{$styles[10]['color']}}  @endisset">{{$styles[10]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[11]['show'])) {{$styles[11]['show']}} @endif @if(isset($styles[11]['centerv'])) {{$styles[11]['centerv']}} @endif @if(isset($styles[11]['centerh'])) {{$styles[11]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[11]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[11]['top']}}px; left: {{$styles[11]['left']}}px;  font-size: @if(isset($styles[11]['font-size'])) {{$styles[11]['font-size']}}px @else 211px @endif" contenteditable><font color="@isset($styles[11]['color']) {{$styles[11]['color']}}  @endisset">{{$styles[11]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[12]['show'])) {{$styles[12]['show']}} @endif @if(isset($styles[12]['centerv'])) {{$styles[12]['centerv']}} @endif @if(isset($styles[12]['centerh'])) {{$styles[12]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[12]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[12]['top']}}px; left: {{$styles[12]['left']}}px;  font-size: @if(isset($styles[12]['font-size'])) {{$styles[12]['font-size']}}px @else 212px @endif" contenteditable><font color="@isset($styles[12]['color']) {{$styles[12]['color']}}  @endisset">{{$styles[12]['content']}}</font></div>
                  <img class="@if(isset($styles[4]['show'])) {{$styles[4]['show']}} @endif @if(isset($styles[4]['centerv'])) {{$styles[4]['centerv']}} @endif @if(isset($styles[4]['centerh'])) {{$styles[4]['centerh']}} @endif" src="{{url('/')}}/public/images/ivlogo.png" id="id_{{$styles[4]['id']}}" onclick="dragElement(this);" style="width:150px;height:150px;z-index : 5;overflow : hidden; position : absolute; top: {{$styles[4]['top']}}px; left: {{$styles[4]['left']}}px;"> 
                  <img class="@if(isset($styles[6]['show'])) {{$styles[6]['show']}} @endif @if(isset($styles[6]['centerv'])) {{$styles[6]['centerv']}} @endif @if(isset($styles[6]['centerh'])) {{$styles[6]['centerh']}} @endif" src="{{url('/')}}/public/images/hallmark.png" id="id_{{$styles[6]['id']}}" onclick="dragElement(this);" style="width:100px;height:100px;z-index : 5;overflow : hidden; position : absolute; top: {{$styles[6]['top']}}px; left: {{$styles[6]['left']}}px;">  
                  <img class="@if(isset($styles[13]['show'])) {{$styles[13]['show']}} @endif @if(isset($styles[13]['centerv'])) {{$styles[13]['centerv']}} @endif @if(isset($styles[13]['centerh'])) {{$styles[13]['centerh']}} @endif" src="{{url('/')}}/public/images/change.jpeg" id="id_{{$styles[13]['id']}}" onclick="dragElement(this);" style="width:150px;height:150px;z-index : 5;overflow : hidden; position : absolute; top: {{$styles[13]['top']}}px; left: {{$styles[13]['left']}}px;"> 
<div class="textbox @if(isset($styles[14]['show'])) {{$styles[14]['show']}} @endif @if(isset($styles[14]['centerv'])) {{$styles[14]['centerv']}} @endif @if(isset($styles[14]['centerh'])) {{$styles[14]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[14]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[14]['top']}}px; left: {{$styles[14]['left']}}px;  font-size: @if(isset($styles[14]['font-size'])) {{$styles[14]['font-size']}}px @else 214px @endif" contenteditable><font color="@isset($styles[14]['color']) {{$styles[14]['color']}}  @endisset">{{$styles[14]['content']}}</font></div>
                  @else
                  <div class="textbox @if(isset($styles[0]['show'])) {{$styles[0]['show']}} @endif @if(isset($styles[0]['centerv'])) {{$styles[0]['centerv']}} @endif @if(isset($styles[0]['centerh'])) {{$styles[0]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[0]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[0]['top']}}px; left: {{$styles[0]['left']}}px;  font-size: @if(isset($styles[0]['font-size'])) {{$styles[0]['font-size']}}px @else 20px @endif" contenteditable><font color="@isset($styles[0]['color']) {{$styles[0]['color']}}  @endisset">{{$styles[0]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[1]['show'])) {{$styles[1]['show']}} @endif @if(isset($styles[1]['centerv'])) {{$styles[1]['centerv']}} @endif @if(isset($styles[1]['centerh'])) {{$styles[1]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[1]['id']}}" style="font-family: arial; z-index: 2;  position: absolute; top: {{$styles[1]['top']}}px; left: {{$styles[1]['left']}}px;  font-size: @if(isset($styles[1]['font-size'])) {{$styles[1]['font-size']}}px @else 40px @endif" contenteditable><font color="@isset($styles[1]['color']) {{$styles[1]['color']}}  @endisset">{{$styles[1]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[2]['show'])) {{$styles[2]['show']}} @endif @if(isset($styles[2]['centerv'])) {{$styles[2]['centerv']}} @endif @if(isset($styles[2]['centerh'])) {{$styles[2]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[2]['id']}}" style="font-family: arial; z-index: 3;  position: absolute; top: {{$styles[2]['top']}}px; left: {{$styles[2]['left']}}px;;  font-size: @if(isset($styles[2]['font-size'])) {{$styles[2]['font-size']}}px @else 40px @endif" contenteditable><font color="@isset($styles[2]['color']) {{$styles[2]['color']}}  @endisset">{{$styles[2]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[3]['show'])) {{$styles[3]['show']}} @endif @if(isset($styles[3]['centerv'])) {{$styles[3]['centerv']}} @endif @if(isset($styles[3]['centerh'])) {{$styles[3]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[3]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[3]['top']}}px; left: {{$styles[3]['left']}}px;  font-size: @if(isset($styles[3]['font-size'])) {{$styles[3]['font-size']}}px @else 27px @endif" contenteditable><font color="@isset($styles[3]['color']) {{$styles[3]['color']}}  @endisset">{{$styles[3]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[5]['show'])) {{$styles[5]['show']}} @endif @if(isset($styles[5]['centerv'])) {{$styles[5]['centerv']}} @endif @if(isset($styles[5]['centerh'])) {{$styles[5]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[5]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[5]['top']}}px; left: {{$styles[5]['left']}}px;  font-size: @if(isset($styles[5]['font-size'])) {{$styles[5]['font-size']}}px @else 27px @endif" contenteditable><font color="@isset($styles[5]['color']) {{$styles[5]['color']}}  @endisset">{{$styles[5]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[7]['show'])) {{$styles[7]['show']}} @endif @if(isset($styles[7]['centerv'])) {{$styles[7]['centerv']}} @endif @if(isset($styles[7]['centerh'])) {{$styles[7]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[7]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[7]['top']}}px; left: {{$styles[7]['left']}}px;  font-size: @if(isset($styles[7]['font-size'])) {{$styles[7]['font-size']}}px @else 27px @endif" contenteditable><font color="@isset($styles[7]['color']) {{$styles[7]['color']}}  @endisset">{{$styles[7]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[8]['show'])) {{$styles[8]['show']}} @endif @if(isset($styles[8]['centerv'])) {{$styles[8]['centerv']}} @endif @if(isset($styles[8]['centerh'])) {{$styles[8]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[8]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[8]['top']}}px; left: {{$styles[8]['left']}}px;  font-size: @if(isset($styles[8]['font-size'])) {{$styles[8]['font-size']}}px @else 28px @endif" contenteditable><font color="@isset($styles[8]['color']) {{$styles[8]['color']}}  @endisset">{{$styles[8]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[9]['show'])) {{$styles[9]['show']}} @endif @if(isset($styles[9]['centerv'])) {{$styles[9]['centerv']}} @endif @if(isset($styles[9]['centerh'])) {{$styles[9]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[9]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[9]['top']}}px; left: {{$styles[9]['left']}}px;  font-size: @if(isset($styles[9]['font-size'])) {{$styles[9]['font-size']}}px @else 29px @endif" contenteditable><font color="@isset($styles[9]['color']) {{$styles[9]['color']}}  @endisset">{{$styles[9]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[10]['show'])) {{$styles[10]['show']}} @endif @if(isset($styles[10]['centerv'])) {{$styles[10]['centerv']}} @endif @if(isset($styles[10]['centerh'])) {{$styles[10]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[10]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[10]['top']}}px; left: {{$styles[10]['left']}}px;  font-size: @if(isset($styles[10]['font-size'])) {{$styles[10]['font-size']}}px @else 210px @endif" contenteditable><font color="@isset($styles[10]['color']) {{$styles[10]['color']}}  @endisset">{{$styles[10]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[11]['show'])) {{$styles[11]['show']}} @endif @if(isset($styles[11]['centerv'])) {{$styles[11]['centerv']}} @endif @if(isset($styles[11]['centerh'])) {{$styles[11]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[11]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[11]['top']}}px; left: {{$styles[11]['left']}}px;  font-size: @if(isset($styles[11]['font-size'])) {{$styles[11]['font-size']}}px @else 211px @endif" contenteditable><font color="@isset($styles[11]['color']) {{$styles[11]['color']}}  @endisset">{{$styles[11]['content']}}</font></div>
                  <div class="textbox @if(isset($styles[12]['show'])) {{$styles[12]['show']}} @endif @if(isset($styles[12]['centerv'])) {{$styles[12]['centerv']}} @endif @if(isset($styles[12]['centerh'])) {{$styles[12]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[12]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[12]['top']}}px; left: {{$styles[12]['left']}}px;  font-size: @if(isset($styles[12]['font-size'])) {{$styles[12]['font-size']}}px @else 212px @endif" contenteditable><font color="@isset($styles[12]['color']) {{$styles[12]['color']}}  @endisset">{{$styles[12]['content']}}</font></div>
                  <img class="@if(isset($styles[4]['show'])) {{$styles[4]['show']}} @endif @if(isset($styles[4]['centerv'])) {{$styles[4]['centerv']}} @endif @if(isset($styles[4]['centerh'])) {{$styles[4]['centerh']}} @endif" src="{{url('/')}}/public/images/ivlogo.png" id="id_{{$styles[4]['id']}}" onclick="dragElement(this);" style="width:150px;height:150px;z-index : 5;overflow : hidden; position : absolute; top: {{$styles[4]['top']}}px; left: {{$styles[4]['left']}}px;"> 
                  <img class="@if(isset($styles[13]['show'])) {{$styles[13]['show']}} @endif @if(isset($styles[13]['centerv'])) {{$styles[13]['centerv']}} @endif @if(isset($styles[13]['centerh'])) {{$styles[13]['centerh']}} @endif" src="{{url('/')}}/public/images/change.jpeg" id="id_{{$styles[13]['id']}}" onclick="dragElement(this);" style="width:150px;height:150px;z-index : 5;overflow : hidden; position : absolute; top: {{$styles[13]['top']}}px; left: {{$styles[13]['left']}}px;"> 
<div class="textbox @if(isset($styles[14]['show'])) {{$styles[14]['show']}} @endif @if(isset($styles[14]['centerv'])) {{$styles[14]['centerv']}} @endif @if(isset($styles[14]['centerh'])) {{$styles[14]['centerh']}} @endif" type="text" onclick="dragElement(this);" id="id_{{$styles[14]['id']}}" style="font-family: arial; z-index: 1;  position: absolute; top: {{$styles[14]['top']}}px; left: {{$styles[14]['left']}}px;  font-size: @if(isset($styles[14]['font-size'])) {{$styles[14]['font-size']}}px @else 214px @endif" contenteditable><font color="@isset($styles[14]['color']) {{$styles[14]['color']}}  @endisset">{{$styles[14]['content']}}</font></div>
                  @endif
                  </div>                  
                  @else
                  @if($item['video']==0)
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_0" style="font-family: arial; z-index: 0; color: gray; position: absolute; top: 1px; left: 12px; font-size: 20px" contenteditable>{{date('jS M Y')}}</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_1" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>4,460</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_2" style="font-family: arial; z-index: 2; color: gray; position: absolute; top: 41px; left: 12px; font-size: 40px" contenteditable>35,680</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_3" style="font-family: arial; z-index: 3; color: gray; position: absolute; top: 61px; left: 12px; font-size: 27px" contenteditable>Address</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_5" style="font-family: arial; z-index: 3; color: gray; position: absolute; top: 61px; left: 12px; font-size: 27px" contenteditable>Number</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_7" style="font-family: arial; z-index: 3; color: gray; position: absolute; top: 81px; left: 12px; font-size: 27px" contenteditable>Address2</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_8" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>Silver</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_9" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>999 Rate</div>
                 <div class="textbox" type="text" onclick="dragElement(this);" id="id_10" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>84 Rate</div>
                 <div class="textbox" type="text" onclick="dragElement(this);" id="id_11" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>75 Rate</div>
                 <div class="textbox" type="text" onclick="dragElement(this);" id="id_12" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>Si.Or.Rate</div>               
                 <img class="" src="{{url('/')}}/public/images/ivlogo.png" id="id_4" onclick="dragElement(this);" style="width:150px;height:150px;z-index : 5;overflow : hidden; position : absolute; top: 61px; left: 12px;">      
                 <img class="" src="{{url('/')}}/public/images/hallmark.png" id="id_6" onclick="dragElement(this);" style="width:100px;height:100px;z-index : 5;overflow : hidden; position : absolute; top: 61px; left: 12px;">     </div>        
                 <img class="" src="{{url('/')}}/public/images/change.jpeg" id="id_13" onclick="dragElement(this);" style="width:150px;height:150px;z-index : 5;overflow : hidden; position : absolute; top: 61px; left: 12px;">    
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_14" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 50px; left: 12px; font-size: 40px" contenteditable>89 Rate</div>

                 @else  
                 <div class="textbox" type="text" onclick="dragElement(this);" id="id_0" style="font-family: arial; z-index: 0; color: gray; position: absolute; top: 1px; left: 12px; font-size: 20px" contenteditable>{{date('jS M Y')}}</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_1" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>4,460</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_2" style="font-family: arial; z-index: 2; color: gray; position: absolute; top: 41px; left: 12px; font-size: 40px" contenteditable>35,680</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_3" style="font-family: arial; z-index: 3; color: gray; position: absolute; top: 61px; left: 12px; font-size: 27px" contenteditable>Address</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_5" style="font-family: arial; z-index: 3; color: gray; position: absolute; top: 61px; left: 12px; font-size: 27px" contenteditable>Number</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_7" style="font-family: arial; z-index: 3; color: gray; position: absolute; top: 81px; left: 12px; font-size: 27px" contenteditable>Address2</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_8" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>Silver</div>
                  <div class="textbox" type="text" onclick="dragElement(this);" id="id_9" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>999 Rate</div>
                 <div class="textbox" type="text" onclick="dragElement(this);" id="id_10" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>84 Rate</div>
                 <div class="textbox" type="text" onclick="dragElement(this);" id="id_11" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>75 Rate</div>
                 <div class="textbox" type="text" onclick="dragElement(this);" id="id_12" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 21px; left: 12px; font-size: 40px" contenteditable>Si.Or.Rate</div>               
                 <img class="" src="{{url('/')}}/public/images/ivlogo.png" id="id_4" onclick="dragElement(this);" style="width:150px;height:150px;z-index : 5;overflow : hidden; position : absolute; top: 61px; left: 12px;">      
                 <img class="" src="{{url('/')}}/public/images/change.jpeg" id="id_13" onclick="dragElement(this);" style="width:150px;height:150px;z-index : 5;overflow : hidden; position : absolute; top: 61px; left: 12px;">     
                     <div class="textbox" type="text" onclick="dragElement(this);" id="id_14" style="font-family: arial; z-index: 1; color: gray; position: absolute; top: 50px; left: 12px; font-size: 40px" contenteditable>89 Rate</div>
 
                </div>        

                  @endif
                  @endif
               </div>
            
            <div class = "col-md-4 ">
               <!--controlbox<p class = "htu" style = "margin-left: 14px;margin-top: 0;margin-top: 4px;"> Double click on an element to add properties on it <br>
                  Double click and drag to move to element<br> Keep elements in the box to have them in picture <br> 
                  throw them outside the box to discard them</p>-->            
               <div class = "controllers" style = "display: block-inline;">
                  <div class = "row h-add">
                     <div class = "col-md-6 p-0">
                        <a href="{{url('/poster')}}" class = "btn p-0 br-0 w-100" style = "margin-top:10px;border:none;" >Back<i class="fa fa-arrow-left icons" aria-hidden="true"></i></a>
                     </div>
                     <div class = "col-md-6 p-0">
                        <label class = "savebtn btn p-0 br-0 w-100" style = "border:none;padding-top: 11px !important;">
                        SAVE POSTER<i class="fa fa-floppy-o icons" aria-hidden="true"></i><input hidden type="submit" value="Save Image" onclick="capture();" style ="" />
                        </label>
                     </div>
                  </div>
                  <div class = "row h-add" style="display:none">
                     <div class = "col-md-6 p-0">
                        <label class = "btn p-0 br-0 w-100" style = "border:none;margin: 0px;padding-top: 11px !important;">UPLOAD IMAGE<i class="fa fa-upload icons" aria-hidden="true"></i><input type='file' onchange	="addimage(this);" hidden/></label>
                     </div>
                     <div class = "col-md-6 p-0">
                        <button class = "btn p-0 br-0 w-100" style = "border:none;" onclick = "addtext();" >ADD TEXT<i class="fa fa-font icons" aria-hidden="true"></i></button>
                     </div>
                  </div>
                  <div class = "row h-add" style="display:none">
                     <div class = "col-md-6 p-0">
                        <select class = "btn p-0 br-0 w-100" style = "border:none; text-align-last: center;" id = "frames" class = "dropdown fontholder" name="fonts" onchange = "addframes(this);">
                           <option value="images/selectshape">SELECT FRAMES</option>
                           <option value="images/innervoice">innervoice</option>
                           <option value="images/wittyfeed">wittyfeed dark</option>
                           <option value="images/wittyfeed_white">wittyfeed light</option>
                           <option value="images/indiakapulse">India Ka Pulse</option>
                           <option value="images/swbh">Sochne Wali Baat hai</option>
                           <option value="images/natkhat">Natkhat Chutkule</option>
                           <option value="images/gyanchand">Gyanchand</option>
                           <option value="images/innervoice_img">Innervoice with Image</option>
                           <option value="images/breakthesilence">Break The Silence</option>
                        </select>
                     </div>
                     <div class = "col-md-6 p-0">
                        <select class = "btn p-0 br-0 w-100" style = "border:none; text-align-last: center;" id = "frames" class = "dropdown fontholder" name="fonts" onchange = "changeRatio(this);">
                           <option value="1">SELECT ASPECT RATIO</option>
                           <option value="1">Standard</option>
                           <option value="2">4:3</option>
                           <option value="3">16:9</option>
                        </select>
                     </div>
                  </div>
                  <!--<div class = "row h-add">-->
                  <!--   <div class = "col-md-4 p-0 no-hvr">-->
                  <!--      <center style = "margin-top: 9%;">TEXT COLOR</center>-->
                  <!--   </div>-->
                  <!--   <div class = "col-md-8 p-0" ">-->
                  <!--      <div class = "col-md-2 p-0 w-100 fl" style = "border-left: none;border-top:none; border-bottom:none; ">-->
                  <!--         <button class = "colors btn p-0 br-0 w-100" style = "border:none;background-color: #ffffff" id="ffffff"></button>-->
                  <!--      </div>-->
                  <!--      <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">-->
                  <!--         <button class = "colors btn p-0 br-0 w-100" style = "border:none;background-color: #046fc2" id="046fc2"></button>-->
                  <!--      </div>-->
                  <!--      <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">-->
                  <!--         <button class = "colors btn p-0 br-0 w-100" style = "border:none;background-color: #ffba01" id="ffba01"></button>-->
                  <!--      </div>-->
                  <!--      <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">-->
                  <!--         <button class = "colors btn p-0 br-0 w-100" style = "border:none;background-color: #000000" id="000000"></button>-->
                  <!--      </div>-->
                  <!--      <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">-->
                  <!--         <button class = "colors btn p-0 br-0 w-100" style = "border:none;background-color: #FF0000" id="FF0000"></button>-->
                  <!--      </div>-->
                  <!--      <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">-->
                  <!--         <button class = "colors btn p-0 br-0 w-100" style = "border:none;background-color: #FFA500" id="FFA500"></button>-->
                  <!--      </div>-->
                  <!--      <div class = "col-md-4 p-0 w-100 fl" style = "border-top:none; border-bottom:none;display:none">-->
                  <!--         <input class = "btn p-0 br-0 w-100 textcolors" style = "border:none;" placeholder = "#000000"/>-->
                  <!--      </div>-->
                  <!--   </div>-->
                  <!--</div>-->
                  <div class="row h-add">
                    <div class="col-md-4 p-0 no-hvr">
                        <center style="margin-top: 9%;">TEXT COLOR</center>
                    </div>
                    <div class="col-md-8 p-0">
                        <div class="col-md-4 p-0 w-100 fl">
                            <input type="color" class="btn p-0 br-0 w-100 textcolors" style="border:none; width: 100%; height: 40px;" id="colorPicker">
                        </div>
                    </div>
                </div>
                  <div class = "row h-add" style="display:none">
                     <div class = "col-md-4 p-0 no-hvr">
                        <center style = "margin-top: 0%;">BACKGROUND COLOR</center>
                     </div>
                     <div class = "col-md-8 p-0">
                        <div class = "col-md-2 p-0 w-100 fl" style = "border-left: none;border-top:none; border-bottom:none;">
                           <button class = "bkcolors btn p-0 br-0 w-100" style = "border:none;background-color: #ffffff"></button>
                        </div>
                        <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">
                           <button class = "bkcolors btn p-0 br-0 w-100" style = "border:none;background-color: #046fc2"></button>
                        </div>
                        <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">
                           <button class = "bkcolors btn p-0 br-0 w-100" style = "border:none;background-color: #ffba01"></button>
                        </div>
                        <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">
                           <button class = "bkcolors btn p-0 br-0 w-100" style = "border:none;background-color: #000000"></button>
                        </div>
                        <div class = "col-md-4 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">
                           <input class = "btn p-0 br-0 w-100" style = "border:none;" placeholder = "#000000"/>
                        </div>
                     </div>
                  </div>
                  <div class = "row h-add" style="display:none">
                     <div class = "col-md-4 p-0 ">
                        <button class = "btn p-0 br-0 w-100" style = "border:none;" onclick = "scale(event)">RESIZE<i class="fa fa-expand icons" aria-hidden="true"></i></button>
                     </div>
                     <div class = "col-md-8 p-0">
                        <input disabled class = "p-0 br-0 w-100 btn sliders" type="range" min="1" max="100" value="100" id="myRange">
                     </div>
                  </div>
                  <div class = "row h-add" >
                     <div class = "col-md-4 p-0">
                        <button class = "btn p-0 br-0 w-100" style = "border:none;" onclick = "fontsize(event);">FONTSIZE<i class="fa fa-text-height icons" aria-hidden="true"></i></button>
                     </div>
                     <div class = "col-md-8 p-0">
                        <input disabled class = "btn p-0 br-0 w-100 sliders" type="text" min="0" max="150" value="0" id="fontsize">
                     </div>
                  </div>
                  <div class = "row h-add" style="display:none">
                     <div class = "col-md-4 p-0">
                        <button onclick = "opacity(event)" class = "btn p-0 br-0 w-100" style = "border:none;">TRANSPARENCY</button>
                     </div>
                     <div class = "col-md-8 p-0">
                        <input disabled class = "btn p-0 br-0 w-100 sliders" type="range" min="0" max="10" value="10" id="opac">
                     </div>
                  </div>
                  <!--<div class = "row h-add" >-->
                  <!--   <div class = "col-md-12 p-0">-->
                  <!--      <select onchange = "fontfamily(this);" class = "btn p-0 br-0 w-100" style = "border:none; text-align-last: center;" name="fonts" onchange = "fontfamily(this);">-->
                  <!--         <option value="Select Font">SELECT FONT</option>-->
                  <!--         <option value="arial">Arial</option>-->
                  <!--         <option value="Roboto">Roboto</option>-->
                  <!--         <option value="Hind">Hindi</option>-->
                  <!--         <option value="Raleway">Raleway</option>-->
                  <!--         <option value="Josefin sans">Josefin</option>-->
                  <!--         <option value="Concert One">Concert One</option>-->
                  <!--         <option value="Montserrat">Montserrat</option>-->
                  <!--         <option value="Baloo">Baloo</option>-->
                  <!--         <option value="Muli">Muli</option>-->
                  <!--         <option value="Kruti">Kruti Dev 010</option>-->
                  <!--         <option value="Stanberry">Stanberry</option>-->
                  <!--      </select>-->
                  <!--   </div>-->
                  <!--</div>-->
                  <div class="row h-add">
                    <div class="col-md-12 p-0">
                        <select id="fontDropdown" onchange="fontfamily(this);" class="btn p-0 br-0 w-100" 
                                style="border:none; text-align-last: center;" name="fonts">
                            <option value="Select Font">SELECT FONT</option>
                        </select>
                    </div>
                </div>
                  <div class = "row h-add" style="display:none">
                     <div class = "col-md-1 p-0 w-100 fl">
                        <button class = "btn p-0 br-0 w-100 bold"  style = "border:none;"><b>B</b></button>	
                     </div>
                     <div class = "col-md-1 p-0 w-100 fl">
                        <button class = "btn p-0 br-0 w-100 italic"  style = "border:none;"><i>I</i></button>
                     </div>
                     <div class = "col-md-1 p-0 w-100 fl">
                        <button class = "btn p-0 br-0 w-100 underline" style = "border:none;"><u>U</u></button>
                     </div>
                     <div class = "col-md-1 p-0 w-100 fl">
                        <button class = "btn p-0 br-0 w-100 leftalign" style = "border:none;"><i class="fa fa-align-left" aria-hidden="true"></i></button>
                     </div>
                     <div class = "col-md-1 p-0 w-100 fl">
                        <button class = "btn p-0 br-0 w-100 rightalign" style = "border:none;"><i class="fa fa-align-right" aria-hidden="true"></i></button>
                     </div>
                     <div class = "col-md-1 p-0 w-100 fl">
                        <button class = "btn p-0 br-0 w-100 centeralign" style = "border:none;"><i class="fa fa-align-center" aria-hidden="true"></i></button>
                     </div>
                     <div class = "col-md-1 p-0 w-100 fl">
                        <button class = "btn p-0 br-0 w-100 justifyalign" style = "border:none;"><i class="fa fa-align-justify" aria-hidden="true"></i></button>
                     </div>
                     <div class = "col-md-5 p-0 w-100 fl">
                        <button class = "btn p-0 br-0 w-100 centerwhole" style = "border:none;">CENTER</button>
                     </div>
                  </div>
                  <div class = "row h-add" >
                     
                     <div class = "col-md-6 p-0 w-100 fl" >
                        <input type="checkbox" class = " p-0 br-0 centerwholev" style = "border:none; margin: 16px;" >VERTICAL CENTER
                     </div>
                     <div class = "col-md-6 p-0 w-100 fl">
                        <input type="checkbox"  class = "p-0 br-0 centerwholeh" style = "border:none;  margin: 16px;">HORIZONTAL CENTER
                     </div>
                  </div>
                  <div class = "row h-add" >
                     <div class = "col-md-12 p-0 w-100 fl">
                        <input type="checkbox"  class = "p-0 br-0 showlook" style = "border:none;  margin: 16px;">SHOW
                     </div>
                  </div>
                  <div class = "row h-add" style="display:none">
                     <div class = "col-md-12 p-0">
                        <select class = "btn p-0 br-0 w-100" style = "border:none; text-align-last: center;" id = "shapes" name="fonts" onchange = "addshape(this);">
                           <option value="selectshape">SELECT SHAPE</option>
                           <option value="images/wittylogo">wittyfeed logo</option>
                           <option value="images/wittyfeed_india_logo">wittyfeed india logo</option>
                           <option value="images/innervoicelogo">Innervoice logo</option>
                           <option value="images/ivlogo">iv logo</option>
                           <option value="images/wflogo">wf logo</option>
                           <option value="Color Layer">TINT</option>
                           <option value="images/quotes">Quotes</option>
                           <option value="square">square</option>
                           <option value="rectangle">rectangle</option>
                           <option value="line">line</option>
                        </select>
                     </div>
                  </div>
                  <div class = "row h-add" style="display:none">
                     <div class = "col-md-4 p-0 no-hvr">
                        <center style = "margin-top: 9%;"  style = "border:none;">SHAPE COLOR</center>
                     </div>
                     <div class = "col-md-8 p-0">
                        <div class = "col-md-2 p-0 w-100 fl" style = "border-left: none;border-top:none; border-bottom:none;">
                           <button class = "shcolors btn p-0 br-0 w-100" style = "border:none;background-color: #ffffff"></button>
                        </div>
                        <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">
                           <button class = "shcolors btn p-0 br-0 w-100" style = "border:none;background-color: #046fc2"></button>
                        </div>
                        <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">
                           <button class = "shcolors btn p-0 br-0 w-100" style = "border:none;background-color: #ffba01"></button>
                        </div>
                        <div class = "col-md-2 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">
                           <button class = "shcolors btn p-0 br-0 w-100" style = "border:none;background-color: #000000"></button>
                        </div>
                        <div class = "col-md-4 p-0 w-100 fl" style = "border-top:none; border-bottom:none;">
                           <input class = "btn p-0 br-0 w-100" style = "border:none; font-color: white" placeholder = "#000000"/>
                        </div>
                     </div>
                  </div>
                  <div class = "row h-add" style="display:none">
                     <div class = "col-md-6 p-0">
                        <button onclick = "picheja();" class = "btn p-0 br-0 w-100" style = "border:none;"><i class="fa fa-chevron-down" style = "margin-right: 11px;font-size: 20px;" aria-hidden="true"></i>SEND BACK</button>
                     </div>
                     <div class = "col-md-6 p-0">
                        <button onclick = "aageaa();" class = "btn p-0 br-0 w-100" style = "border:none;">BRING FRONT<i class="fa fa-chevron-up icons" aria-hidden="true"></i></button>
                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div>
      <script type="text/javascript">
         //////////////////////////////////////////////////ONLOAD FontSIZE adder/////////////////////////////////////////
         
         function fontsizeadder(elem){
         var browserHeight = window.innerHeight;
         var rowHeight = browserHeight / 13;
         console.log(rowHeight);
         var elementArray = document.getElementsByClassName("h-add");
         console.log(elementArray);
         for (var i = 0; i < elementArray.length; ++i)
         elementArray[i].style.height = rowHeight + "px";
         document.getElementsByTagName("BODY")[0].style.display = "block";
         /*	var value = "";
         	for(var i = 1 ; i <= 55; i++){
         		document.getElementById('fontsizer').innerHTML = value + "<option value="+i+">"+i+"</option>";
         		value = value + "<option value="+i+">"+i+"</option>";
         	}
         */
         }
         
         universallayerindex = 0;
         textlayerindex = 0;
         imagelayerindex = 0;
         selectedid = 0;
         
         function picheja(){
         if(document.getElementById(selectedid).style.zIndex >= 1)
         		document.getElementById(selectedid).style.zIndex = parseInt(document.getElementById(selectedid).style.zIndex) - 1; 
         }
         
         
         function aageaa(){
         	document.getElementById(selectedid).style.zIndex = parseInt(document.getElementById(selectedid).style.zIndex) + 1; 
         }
         
         
         ////////////////////////////////////////////////////////////////COLORS TEXT ALIGNMENT///////////////////////////////////////////////////////
        document.getElementById("colorPicker").addEventListener("input", function() {
            let color = this.value;
            document.execCommand("ForeColor", false, color);
        });
         
        //  $(document).ready(function() {
        //   $('.colors').click(function() {
        //  	color = this.style.backgroundColor;
        //     //color = "#"+this.id;
        //      document.execCommand("ForeColor", false, color);
        //   });
           
        //  });
         
         $(document).ready(function() {
           $('.clr').click(function() {
         	color = document.getElementById("textcolorbox").value;
             document.execCommand("ForeColor", false, color);
           });
         });
         $(document).ready(function() {
           $('.bold').click(function() {
             document.execCommand("bold");
           });
         });
         $(document).ready(function() {
           $('.italic').click(function() {
             document.execCommand("italic");
           });
         });
         $(document).ready(function() {
           $('.centerwhole').click(function() {
         	console.log("hellobhai");
         	var elem = document.getElementById(selectedid);
         	console.log(elem);
         	x = elem.offsetWidth;
         	y = elem.offsetHeight;
         	X = (605-x)/2;
         	Y = (605-y)/2;
         	console.log(x,y,X,Y);
         	elem.style.left = X + "px";
         	elem.style.top = Y + "px";
           });
           $('.centerwholev').click(function() {
         	console.log("hellobhai");
         	var elem = document.getElementById(selectedid);
            var position = elem.getBoundingClientRect();
            var cx = elem.offsetLeft;
            var cy = elem.offsetTop;
         	x = elem.offsetWidth;
         	y = elem.offsetHeight;
         	X = cx;
         	Y = (605-y)/2;
         	console.log(x,y,X,Y);
         	elem.style.left = X + "px";
         	elem.style.top = Y + "px";
            if(elem.classList.contains("centerv"))elem.classList.remove("centerv");
            else elem.classList.add("centerv");
           });
           $('.showlook').click(function() {
         	console.log("hellobhai");
         	var elem = document.getElementById(selectedid);
            if(elem.classList.contains("show"))elem.classList.remove("show");
            else elem.classList.add("show");
           });
           $('.centerwholeh').click(function() {
         	console.log("hellobhai");
         	var elem = document.getElementById(selectedid);
            var position = elem.getBoundingClientRect();
            var cx = elem.offsetLeft;
            var cy = elem.offsetTop;
         	x = elem.offsetWidth;
         	y = elem.offsetHeight;
         	X = (605-x)/2;
         	Y = cy;
         	console.log(x,y,X,Y);
         	elem.style.left = X + "px";
         	elem.style.top = Y + "px";
            if(elem.classList.contains("centerh"))elem.classList.remove("centerh");
            else elem.classList.add("centerh");
           });
           
         });
         $(document).ready(function() {
           $('.underline').click(function() {
             document.execCommand("underline");
           });
         });
         $(document).ready(function() {
           $('.leftalign').click(function() {
             document.execCommand('justifyLeft');
           });
         });
         function setbgcolor(color){
         	document.getElementById("main_bg").style.backgroundColor = color;
         }
         $(document).ready(function() {
           $('.centeralign').click(function() {
             document.execCommand('justifyCenter');
           });
         });
         $(document).ready(function() {
           $('.rightalign').click(function() {
             document.execCommand('justifyRight');
           });
         });
         $(document).ready(function() {
           $('.justifyalign').click(function() {
             document.execCommand('justifyFull');
           });
         });
         $(document).ready(function() {
           $('.bkcolors').click(function() {
         	color = this.style.backgroundColor;
             document.getElementById("main_bg").style.backgroundColor = color;
         	console.log(color);
           });
         });
         $(document).ready(function() {
           $('.trybk').click(function() {
         	color = document.getElementById("bkcolorbox").value;;
             document.getElementById("main_bg").style.backgroundColor = color;
         	console.log(color);
           });
         });
         $(document).ready(function() {
           $('.shcolors').click(function() {
         	color = this.style.backgroundColor;
         	//console.log("id_"+selectedid);
             document.getElementById(selectedid).style.backgroundColor = color;
         	console.log(color);
           });
         });
         
         
         //////////////////////////////////////////////////////////////////SCALE/////////////////////////////////////////////////////////
         
         
         function scale(event){
         	document.getElementById("myRange").disabled = false;
         	document.getElementById("myRange").value = 50;
         	var elem = document.getElementById(selectedid);
         	console.log(selectedid);
         	slider = document.getElementById("myRange");
         	//console.log(elem.id);
         	event = document.getElementById("shapes");
         	slider.oninput = function() {
         		if(elem.tagName == "IMG")
         			{
         				elem.style.width = document.getElementById("myRange").value + "%";
         //elem.style.height = document.getElementById("myRange").value + "%";
         				console.log(elem.tagName);
         			}
         		if(elem.tagName == "DIV")
         			{
         				console.log(elem.tagName + elem.value);
         				if(event.value == "circle" || elem.value == "square")
         				{
         				elem.style.width = document.getElementById("myRange").value + "%";
         				console.log(elem.offsetWidth);
         				elem.style.height = elem.offsetWidth;
         				}
         				if(event.value == "line"){
         				elem.style.width = document.getElementById("myRange").value + "%";
         				}
         				if(event.value == "rectangle")
         				{
         				elem.style.width = document.getElementById("myRange").value + "%";
         				console.log(elem.offsetWidth);
         				}
         			}
         	}
         	} 
         	
         
         ////////////////////////////////////////////////////////////////////OPACITY/////////////////////////////////////////////////////////
         
         
         function opacity(event){
         	document.getElementById("opac").disabled = false;
         	document.getElementById("opac").value = 10;
         	var elem = document.getElementById(selectedid);
         	console.log(selectedid);
         	slider = document.getElementById("opac");
         		slider.oninput = function() {			
         			elem.style.opacity = document.getElementById("opac").value / 10;
         		}
         	} 
         	
         
         //////////////////////////////////////////////////////////////FONT FAMILY///////////////////////////////////////////////////////////
         
         
        //  function fontfamily(eleme){
        //  	console.log(eleme);
        //  	var elem = document.getElementById(selectedid);
        //  	console.log(selectedid);
        //  	alert(eleme.value);
        //  	elem.style.fontFamily = eleme.value;
        //  	} 
        
        function fontfamily(eleme) {
            console.log(eleme);
            
            var elem = document.getElementById(selectedid);
            console.log(selectedid);
            
            if (elem && eleme.value !== "Select Font") {
                let selectedFontUrl = $(eleme).find(":selected").val();
                let selectedFontName = $(eleme).find(":selected").data("font");
        
                if (selectedFontUrl) {
                    // Add @font-face dynamically
                    var newStyle = document.createElement('style');
                    newStyle.appendChild(document.createTextNode(`
                        @font-face {
                            font-family: '${selectedFontName}';
                            src: url('${selectedFontUrl}') format('truetype');
                        }
                    `));
                    document.head.appendChild(newStyle);
        
                    // Apply the font-family
                    elem.style.fontFamily = `'${selectedFontName}', sans-serif`;
                }
            }
        }
         
         
         
         ////////////////////////////////////////////////////////////////ADD SHAPE/////////////////////////////////////////////////////////////
         
         
         function addshape(elem){
         	value = document.getElementById("target").innerHTML;
         	if(textlayerindex != 0){
         	for (i = 0; i < universallayerindex; i++) { 
         		console.log(document.getElementById("id_"+i).tagName);
         		if(document.getElementById("id_"+i).tagName == "TEXTAREA")
         			{
         				strings.push(document.getElementById("id_"+i).value);
         				console.log("hello");
         			}
         	}
         	}
         	if(elem.value == "square")
         		{console.log(elem.value);document.getElementById("target").innerHTML = value + "" + '<div src = "" id = "id_'+universallayerindex+'" onclick = "dragElement(this);" style = " height: 50px; width: 50px; z-index : '+universallayerindex+';overflow : hidden; background-color: black; position : absolute;max-width: 500px;max-height: 500px;"/>';}
         	else if(elem.value == "rectangle")
         		{console.log(elem.value);document.getElementById("target").innerHTML = value + "" + '<div src = "" id = "id_'+universallayerindex+'" onclick = "dragElement(this);" style = " height: 50px; width: 100px; z-index : '+universallayerindex+';overflow : hidden; background-color: red; position : absolute;max-width: 500px;max-height: 500px;"/>';}
         	else if(elem.value == "circle")
         		{console.log(elem.value);document.getElementById("target").innerHTML = value + "" + '<div src = "" id = "id_'+universallayerindex+'" onclick = "dragElement(this);" style = " border-radius: 50%; height: 50px; width: 50px; z-index : '+universallayerindex+';overflow : hidden; background-color: red; position : absolute;max-width: 500px;max-height: 500px;"/>';}
         	else if(elem.value == "line")
         		{console.log(elem.value);document.getElementById("target").innerHTML = value + "" + '<div src = "" id = "id_'+universallayerindex+'" onclick = "dragElement(this);" style = " height: 5px; width: 100px; z-index : '+universallayerindex+';overflow : hidden; background-color: red; position : absolute;max-width: 500px;max-height: 500px;"/>';}
         	else if(elem.value == "Color Layer")
         		{selectedid = universallayerindex;console.log(elem.value);document.getElementById("target").innerHTML = value + "" + '<div src = "" id = "id_'+universallayerindex+'" onclick = "dragElement(this);" style = "opacity:0.6;height: 100%; width: 100%; z-index : '+universallayerindex+';overflow : hidden; background-color: black; position : absolute;"/>';}
         	else
         		document.getElementById("target").innerHTML = value + "" + '<img onclick = "dragElement(this);" src = "'+elem.value+'.png" id = "id_'+universallayerindex+'" style = "width: 100%; z-index : '+universallayerindex+';position : absolute;"/>';
         	
         	if(textlayerindex != 0){
         	for (i = 0; i < universallayerindex; i++) {  
         		if(document.getElementById("id_"+i).tagName == "TEXTAREA")
         		document.getElementById("id_"+i).value = strings[i];
         	}
         	}
         	universallayerindex = universallayerindex + 1;
         }
         
         
         //////////////////////////////////////////////////////////////ADD FRAME////////////////////////////////////////////////////////////////
         
         
         function addframes(elem){
         	value = document.getElementById("target").innerHTML;
         	strings = [];
         		if(textlayerindex != 0){
         			for (i = 0; i < universallayerindex; i++) { 
         				console.log(document.getElementById("id_"+i).className);
         				if(document.getElementById("id_"+i).className == "textbox")
         						strings.push(document.getElementById("id_"+i).value);
         			}}
         
         	if(elem.value != 'images/gyanchand'){//not gyanchand add frame
         		document.getElementById("target").innerHTML = value + "" + '<img src = "'+elem.value+'.png" id = "id_'+universallayerindex+'" style = " height: 100%; width: 100%; z-index : '+universallayerindex+';position : absolute;"/>';
         		value = value + '<img src = "'+elem.value+'.png" id = "id_'+universallayerindex+'" style = " height: 100%; width: 100%; z-index : '+universallayerindex+';position : absolute;"/>';
         		universallayerindex++;
         		}
         	
         	if(elem.value == 'images/innervoice'){//done
         		addtext("Muli","white");
         		}
         	
         	if(elem.value == 'images/swbh'){//done
         		addtext("Stanberry","black");
         		}
         	
         	if(elem.value == 'images/natkhat'){//done
         		addtext("kruti","black","800");
         		}
         	if(elem.value == 'images/wittyfeed_white'){//done
         		addtext("Montserrat","black");
         		}
         	if(elem.value == 'images/wittyfeed'){//done
         		addtext("Montserrat","white");
         	}
         	if(elem.value == 'images/indiakapulse'){//done
         		addtext("Raleway","black");
         	}
         	if(elem.value == 'images/gyanchand'){
         		document.getElementById("target").innerHTML = value + "" + '<img src = "'+elem.value+'.png" id = "id_'+universallayerindex+'" style = " height: 100%; width: 100%; z-index : 100;position : absolute;"/>';
         		value = value + "" + '<img src = "'+elem.value+'.png" id = "id_'+universallayerindex+'" style = " height: 100%; width: 100%; z-index : 100;position : absolute;"/>';
         		universallayerindex++
         		document.getElementById("target").innerHTML = value + "" + '<div class = "textbox" type = "text" onclick = "dragElement(this);" id = id_'+universallayerindex+' style = "font-family: baloo;z-index : 100; color: black; position : absolute; top: 50%; left: 29%;" contenteditable>पाठ दर्ज करें</div>';
         		universallayerindex++;
         		}
         	
         	
         	if(elem.value == 'images/quoteoftheday'){
         		document.getElementById("target").innerHTML = value + "" + '<img src = "'+elem.value+'.png" id = "id_'+universallayerindex+'" style = " height: 100%; width: 100%; z-index : 100;position : absolute;"/>';
         		value = value + "" + '<img src = "'+elem.value+'.png" id = "id_'+universallayerindex+'" style = " height: 100%; width: 100%; z-index : 100;position : absolute;"/>';
         		universallayerindex++
         		document.getElementById("target").innerHTML = value + "" + '<div class = "textbox" type = "text" onclick = "dragElement(this);" id = id_'+universallayerindex+' style = "font-family: Muli;z-index : 100; color: white; font-weight: bold; position : absolute; top: 50%; left: 29%;" contenteditable>Enter Your Text</div>';
         		universallayerindex++;
         		}
         
         	if(textlayerindex != 0){
         		for (i = 0; i < universallayerindex; i++) {  
         			if(document.getElementById("id_"+i).className == "textbox")
         				document.getElementById("id_"+i).value = strings[i];
         	}}
         }
         
         //////////////////////////////////////////////////////FONT SIZE///////////////////////////////////////////////////
         
         function fontsize(event){
         	document.getElementById("fontsize").disabled = false;
         	document.getElementById("fontsize").value = 0;
         	var elem = document.getElementById(selectedid);
         	console.log("fontsize change on : " + selectedid);
         	console.log(elem);
         	slider = document.getElementById("fontsize");
         		slider.oninput = function() {
         			elem.style.fontSize = document.getElementById("fontsize").value + "px";
         		}
         	} 
         
         
         ////////////////////////////////////////////////////////////////READ URL////////////////////////////////////////////////////////
         
         function readURL(input) {
         console.log("inside read url");
                     if (input.files && input.files[0]) {
                         var reader = new FileReader();
                         reader.onload = function (e) {
                             document.getElementById('id_'+(universallayerindex - 1)).src = e.target.result;
                         }
                         reader.readAsDataURL(input.files[0]);
                     }
         			imagelayerindex = imagelayerindex + 1;
         			universallayerindex = universallayerindex + 1;
                 }
         var z = 0; 
         
         
         ///////////////////////////////////////////////////////////ADD IMAGE////////////////////////////////////////////////////////
         
         
         function addimage(input){
         	console.log("Image adder");
         	value = document.getElementById("target").innerHTML;
         	strings = [];
         	if(textlayerindex != 0){
         		for (i = 0; i < universallayerindex; i++) { 
         			//console.log(document.getElementById("id_"+i).className);
         			if(document.getElementById("id_"+i).className == "textbox")
         					strings.push(document.getElementById("id_"+i).value);
         	}}
         	
         	document.getElementById("target").innerHTML = value + "" + '<img src = "" id = "id_'+universallayerindex+'" onclick = "dragElement(this);" style = " max-width:100%; max-height:100%;z-index : '+universallayerindex+';overflow : hidden; position : absolute;"/>';
         	
         	if(textlayerindex != 0){
         		for (i = 0; i < universallayerindex; i++) {  
         			if(document.getElementById("id_"+i).className == "textbox")
         				document.getElementById("id_"+i).value = strings[i];
         	}}
         
         	readURL(input);
         }
         
         var textindex = 0;
         
         
         ///////////////////////////////////////////////////////////ADD TEXT/////////////////////////////////////////////////////
         
         
         function addtext(font = "arial",color = "gray",weight = "500"){
         	value = document.getElementById("target").innerHTML;
         	strings = [];
         		if(textlayerindex != 0){
         			for (i = 0; i < universallayerindex; i++) { 
         				console.log(i + " " +document.getElementById("id_"+i).className);
         				if(document.getElementById("id_"+i).className == "textbox")
         						strings.push(document.getElementById("id_"+i).value);
         			}}
         
         	document.getElementById("target").innerHTML = value + "" + '<div class = "textbox" type = "text" onclick = "dragElement(this);" id = id_'+universallayerindex+' style = "font-family: '+font+';z-index : '+universallayerindex+'; color: '+color+'; position : absolute; top: 42%; left: 34%; font-weight: '+weight+'" contenteditable>Put your text here</div>';
         	
         	if(textlayerindex != 0){
         		for (i = 0; i < universallayerindex; i++) {  
         			if(document.getElementById("id_"+i).className == "textbox")
         				document.getElementById("id_"+i).value = strings[i];
         	}}
         	
         	textlayerindex++;
         	universallayerindex = universallayerindex + 1;
         }
         
         
         ////////////////////////////////////////////////////////////////DRAG ELEMENT///////////////////////////////////////////////////
         
         
         function dragElement(elmnt) {
         	selectedid = elmnt.id;
         	console.log(elmnt.id + "this is selected");
            if(elmnt.classList.contains("show"))$(".showlook").prop("checked", true);
            else $(".showlook").prop("checked", false);
            if(elmnt.classList.contains("centerv"))$(".centerwholev").prop("checked", true);
            else $(".centerwholev").prop("checked", false);
            if(elmnt.classList.contains("centerh"))$(".centerwholeh").prop("checked", true);
            else $(".centerwholeh").prop("checked", false);
           var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
           if (document.getElementById(elmnt.id + "header")) {
             /* if present, the header is where you move the DIV from:*/
             document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
           } else {
             /* otherwise, move the DIV from anywhere inside the DIV:*/
         	elmnt.onmousedown = dragMouseDown;
           
         }
         
         function showCoords(event) {
             var x = event.clientX;
             var y = event.clientY;
             return x,y;
         	}
         
         function dragMouseDown(e) {
             e = e || window.event;
             // get the mouse cursor position at startup:
             pos3 = e.clientX;
             pos4 = e.clientY;
             document.onmouseup = closeDragElement;
             // call a function whenever the cursor moves:
             document.onmousemove = elementDrag;
           }
         
           function elementDrag(e) {
             e = e || window.event;
             // calculate the new cursor position:
             pos1 = pos3 - e.clientX;
             pos2 = pos4 - e.clientY;
             pos3 = e.clientX;
             pos4 = e.clientY;
             // set the element's new position:
             elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
             elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
           }
         
           function closeDragElement() {
             /* stop moving when mouse button is released:*/
             document.onmouseup = null;
             document.onmousemove = null;
           }
         }
         
         
         ///////////////////////////////////////////////////////////////CAPTURE FINAL IMAGE///////////////////////////////////////////
         
         
         function capture() {
           
        //  		document.getElementById('fullpage').style.zoom = 3;
        //  		$('#target').html2canvas({
        //  			onrendered: function (canvas) {
        //         //Set hidden field's value to image data (base-64 string)
        //  				$('#img_val').val(canvas.toDataURL("image/jpeg",1.0));
        //         console.log(canvas.toDataURL("image/png",1.0));
        //         //Submit the form manually
        //     document.getElementById("showimage").src = canvas.toDataURL("image/png",1.0);
        //     document.getElementById("image-holder").style.display = "block";
        //  //document.getElementById("myForm").submit();
        //  			}
        //  		});
        //  document.getElementById('fullpage').style.zoom = 1;
        @if($item['video']==0)
        var id0_style=$("#id_0")[0].outerHTML;
        var id1_style=$("#id_1")[0].outerHTML;
        var id2_style=$("#id_2")[0].outerHTML;
        var id3_style=$("#id_3")[0].outerHTML;
        var id4_style=$("#id_4")[0].outerHTML;
        var id5_style=$("#id_5")[0].outerHTML;
        var id6_style=$("#id_6")[0].outerHTML;
        var id7_style=$("#id_7")[0].outerHTML;
        var id8_style=$("#id_8")[0].outerHTML;
        var id9_style=$("#id_9")[0].outerHTML;
        var id10_style=$("#id_10")[0].outerHTML;
        var id11_style=$("#id_11")[0].outerHTML;
        var id12_style=$("#id_12")[0].outerHTML;
        var id13_style=$("#id_13")[0].outerHTML;
        var id14_style=$("#id_14")[0].outerHTML;

        var style=[];
        style.push(id0_style);
        style.push(id1_style);
        style.push(id2_style);
        style.push(id3_style);
        style.push(id4_style);
        style.push(id5_style);
        style.push(id6_style);
        style.push(id7_style);
        style.push(id8_style);
        style.push(id9_style);
        style.push(id10_style);
        style.push(id11_style);
        style.push(id12_style);
         style.push(id13_style);
            style.push(id14_style);


        var id0_content=$("#id_0").html();
        var id1_content=$("#id_1").html();
        var id2_content=$("#id_2").html();
        var id3_content=$("#id_3").html();
        var id4_content=$("#id_4").html();
        var id5_content=$("#id_5").html();
        var id6_content=$("#id_6").html();
        var id7_content=$("#id_7").html();
        var id8_content=$("#id_8").html();
        var id9_content=$("#id_9").html();
        var id10_content=$("#id_10").html();
        var id11_content=$("#id_11").html();
        var id12_content=$("#id_12").html();
        var id13_content=$("#id_13").html();
         var id14_content=$("#id_14").html();
        
        var content=[];
        content.push(id0_content);
        content.push(id1_content);
        content.push(id2_content);
        content.push(id3_content);
        content.push(id4_content);
        content.push(id5_content);
        content.push(id6_content);
        content.push(id7_content);
        content.push(id8_content);
        content.push(id9_content);
        content.push(id10_content);
        content.push(id11_content);
        content.push(id12_content);
        content.push(id13_content);
         content.push(id14_content);

        @else
        var id0_style=$("#id_0")[0].outerHTML;
        var id1_style=$("#id_1")[0].outerHTML;
        var id2_style=$("#id_2")[0].outerHTML;
        var id3_style=$("#id_3")[0].outerHTML;
        var id4_style=$("#id_4")[0].outerHTML;
        var id5_style=$("#id_5")[0].outerHTML;
        var id7_style=$("#id_7")[0].outerHTML;
        var id8_style=$("#id_8")[0].outerHTML;
        var id9_style=$("#id_9")[0].outerHTML;
        var id10_style=$("#id_10")[0].outerHTML;
        var id11_style=$("#id_11")[0].outerHTML;
        var id12_style=$("#id_12")[0].outerHTML;
        var id13_style=$("#id_13")[0].outerHTML;
        var id14_style=$("#id_14")[0].outerHTML;

        var style=[];
        style.push(id0_style);
        style.push(id1_style);
        style.push(id2_style);
        style.push(id3_style);
        style.push(id4_style);
        style.push(id5_style);
        style.push(id7_style);
        style.push(id8_style);
        style.push(id9_style);
        style.push(id10_style);
        style.push(id11_style);
        style.push(id12_style);
        style.push(id13_style);
         style.push(id14_style);


        var id0_content=$("#id_0").html();
        var id1_content=$("#id_1").html();
        var id2_content=$("#id_2").html();
        var id3_content=$("#id_3").html();
        var id4_content=$("#id_4").html();
        var id5_content=$("#id_5").html();
        var id7_content=$("#id_7").html();
        var id8_content=$("#id_8").html();
        var id9_content=$("#id_9").html();
        var id10_content=$("#id_10").html();
        var id11_content=$("#id_11").html();
        var id12_content=$("#id_12").html();
         var id13_content=$("#id_13").html();
           var id14_content=$("#id_14").html();
        
        var content=[];
        content.push(id0_content);
        content.push(id1_content);
        content.push(id2_content);
        content.push(id3_content);
        content.push(id4_content);
        content.push(id5_content);
        content.push(id7_content);
        content.push(id8_content);
        content.push(id9_content);
        content.push(id10_content);
        content.push(id11_content);
        content.push(id12_content);
        content.push(id13_content);
         content.push(id14_content);

        @endif



        $.ajax({
            url: "{{url('/')}}/editorsave", 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify({ id: '{{$id}}',content : JSON.stringify(content),style : JSON.stringify(style) }),
            success: function (result) {
               if(result.success)
                alert("Updated Successfully!");
               else
                  alert("Please try again later!");
                // when call is sucessfull
                },
                error: function (err) {
                  alert("Please try again later!");
                // check the err for error details
                }
        }); // ajax call closing
         	}
         
         
         
         
          ///////////////////////////////////////////////////CLOSE HOLDER///////////////////////////////////////////////////////////////
         
          function closeholder(){
            document.getElementById("image-holder").style.display = "none";
          }
         
         
         ///////////////////////////////////////////////////Ratio Change///////////////////////////////////////////////////////////////
         
         function changeRatio(input){
         if (input.value==="1"){
         document.getElementById('target').style.height = "605px";
         }
         else if(input.value==="2"){
         document.getElementById('target').style.height = "454px";
         }	
         else if (input.value==="3"){
         document.getElementById('target').style.height = "339px";
         }
         }


         
      </script>
      <style type="text/css">
         #target {
         border: 1px solid #CCC;
         padding: 5px;
         margin: 5px;
         }
         h2, h3 {
         color: #003d5d;
         }
         #more {
         font-family: Verdana;
         color: purple;
         background-color: #d8da3d;
         }
      </style>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
       $(document).ready(function() {
            $.ajax({
                url: "{{ route('get.fonts') }}", 
                type: "GET",
                success: function(response) {
                    if (response && response.fonts.length > 0) {
                        let dropdown = $("#fontDropdown");
                        dropdown.empty(); // Clear previous options
                        dropdown.append(`<option value="Select Font">SELECT FONT</option>`); // Add default
                        
                        response.fonts.forEach(font => {
                            dropdown.append(`<option value="${font.href}" data-font="${font.name}">${font.name}</option>`);
                        });
                    } else {
                        console.error("No fonts found in response.");
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching fonts:", xhr);
                }
            });
        });
        </script>
      </div>
   </body>
</html>