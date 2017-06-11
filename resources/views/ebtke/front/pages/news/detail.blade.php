@extends('ebtke.front.layout.master')

@section('pageheadtitle')
    {{ $detail_news['meta_title'] or '' }}
@stop

@section('seo')
    <meta name="keywords" content="{{ $detail_news['meta_keyword'] or '' }}" />
    <meta name="description" content="{{ $detail_news['meta_description'] or '' }}" />
@stop

@section('content')



<!-- 
    ____ ___  _   _ _____ _____ _   _ _____ 
   / ___/ _ \| \ | |_   _| ____| \ | |_   _|
  | |  | | | |  \| | | | |  _| |  \| | | |  
  | |__| |_| | |\  | | | | |___| |\  | | |  
   \____\___/|_| \_| |_| |_____|_| \_| |_|  
                                            
-->

@if(isset($detail_news) && !empty($detail_news))
<section id="desktop">
	<!-- Begin page header-->
    <div class="container detail--header default-large-banner-section">
    	<div class="row">
    		<div id="desktop-breadcrumb-menu" class="col-md-12">
    			<a href="{{ route('MainPage') }}" class="breadcrumb text-gray">Home</a>
                <a href="{{ route('landingNews') }}" class="breadcrumb text-gray">News</a>
                <a href="{{ route('detailNews',$detail_news['slug']) }}" class="breadcrumb text-gray">{{ $detail_news['title'] or '' }}</a>
    		</div>
            <div class="col-md-12">
                <h3 class="latestnews__title text-center">{{ $detail_news['title'] or '' }}</h3>
                
            </div>
            <!--
               ____    _    _   _ _   _ _____ ____
              | __ )  / \  | \ | | \ | | ____|  _ \
              |  _ \ / _ \ |  \| |  \| |  _| | |_) |
              | |_) / ___ \| |\  | |\  | |___|  _ <
              |____/_/   \_\_| \_|_| \_|_____|_| \_\

            -->
            <div class="col-md-12">
                <div class="w3-content w3-display-container">
                    <img class="mySlides" src="{{ $detail_news['thumbnail_url'] or '' }}" style="width:100%">

                    <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
                    <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
                </div>
            </div>

            
    	</div>
    </div>
    <div class="container style--texteditor">

        <div class="default-content">
            {!! $detail_news['introduction'] or '' !!}
            {!! $detail_news['description'] or '' !!}
        </h3>
        </div>
    </div>
</section>
@endif

<!-- 
      _    _     ____   ___    _     ___ _  _______ 
     / \  | |   / ___| / _ \  | |   |_ _| |/ / ____|
    / _ \ | |   \___ \| | | | | |    | || ' /|  _|  
   / ___ \| |___ ___) | |_| | | |___ | || . \| |___ 
  /_/   \_\_____|____/ \___/  |_____|___|_|\_\_____|
                                                    
-->

@if(isset($detail_news['related']) && !empty($detail_news['related']))
<section id="desktop">
    <!-- Begin page header-->
    <div class="container">
        <hr/>
        <div class="detail-also-like-title">
            <h1>You might also like</h1>
        </div>
        @foreach($detail_news['related'] as $key=> $related)
        
        <div id="related__news" class="col-md-4">
            <img src="{{ $related['related_thumbnail_url'] }}" class="img-responsive">
            <p>
                <a href="{{ route('detailNews',$related['related_slug']) }}">
                    <h4>{{ $related['related_title'] }}</h4>
                </a>
            </p>
            <ul>
                <li>{{ $related['related_day_ago'] }}</li>
                <li>{{ $related['related_view'] }} Views</li>
            </ul>
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection

@section('scripts')
<script>
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
      showDivs(slideIndex += n);
    }

    function showDivs(n) {
      var i;
      var x = document.getElementsByClassName("mySlides");
      if (n > x.length) {slideIndex = 1}    
      if (n < 1) {slideIndex = x.length}
      for (i = 0; i < x.length; i++) {
         x[i].style.display = "none";  
      }
      x[slideIndex-1].style.display = "block";  
    }
</script>
@stop