@extends('layouts.app')

@section('content')
<style type="text/css">
  .bg {
  background: url('/images/indonesie31.gif') no-repeat center center;
  position: fixed;
  width: 100%;
  height: 350px; /*same height as jumbotron */
  top:0;
  left:0;
  z-index: -1;
}

.jumbotron {
  background: url('/images/indonesie31.gif') no-repeat center center;
  height: 350px;
  color: gray;
  text-shadow: #444 0 1px 1px;
  background:transparent;
}
</style>

<div class="container">
  <div class="bg">
  </div>
  <div class="jumbotron">
    <h1>Daerah Dalam Angka</h1>
    <p>Kompilasi berbagai statistik daerah dalam satu buku...</p>
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 center-block">
      <a href="dda" type="button" class="btn btn-info btn-block">
        <span class="glyphicon glyphicon-search"></span> Telusuri DDA
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-4">
<!--       <div id="feeds"> 
          <a class="feed" href="http://jquery.com/blog/feed/">jQuery Blog</a> 
          <a class="feed" href="http://www.learningjquery.com/feed/">Learning jQuery</a> 
      </div>  -->
      <!-- start feedwind code -->
      <script type="text/javascript">
        document.write('\x3Cscript type="text/javascript" src="' + ('https:' == document.location.protocol ? 'https://' : 'http://') + 'feed.mikle.com/js/rssmikle.js">\x3C/script>');
      </script>
      <script type="text/javascript">(function() {var params = {rssmikle_url: "http://bps.go.id/index.php/site/rsspublikasi",rssmikle_frame_width: "300",rssmikle_frame_height: "250",frame_height_by_article: "0",rssmikle_target: "_blank",rssmikle_font: "Arial, Helvetica, sans-serif",rssmikle_font_size: "12",rssmikle_border: "off",responsive: "off",rssmikle_css_url: "",text_align: "left",text_align2: "left",corner: "off",scrollbar: "on",autoscroll: "on",scrolldirection: "up",scrollstep: "3",mcspeed: "20",sort: "Off",rssmikle_title: "off",rssmikle_title_sentence: "",rssmikle_title_link: "",rssmikle_title_bgcolor: "#0066FF",rssmikle_title_color: "#FFFFFF",rssmikle_title_bgimage: "",rssmikle_item_bgcolor: "#FFFFFF",rssmikle_item_bgimage: "",rssmikle_item_title_length: "55",rssmikle_item_title_color: "#0066FF",rssmikle_item_border_bottom: "on",rssmikle_item_description: "on",item_link: "off",rssmikle_item_description_length: "150",rssmikle_item_description_color: "#666666",rssmikle_item_date: "gl1",rssmikle_timezone: "Etc/GMT",datetime_format: "%b %e, %Y %l:%M %p",item_description_style: "text+tn",item_thumbnail: "full",item_thumbnail_selection: "auto",article_num: "15",rssmikle_item_podcast: "off",keyword_inc: "",keyword_exc: ""};feedwind_show_widget_iframe(params);})();
      </script>
      <div style="font-size:10px; text-align:center; width:300px;">
        <a href="http://feed.mikle.com/" target="_blank" style="color:#CCCCCC;">RSS Feed Widget</a>
      </div>
    </div>
    <div class="col-sm-4">
      @foreach($articles as $article)
        <h4>
          <a href="{{ route('articles.show', array($article->id)) }}">{{ $article->title }}</a>
        </h4>
        <h6>{{ $article->created_at }}</h6>
        <p> {!! substr(html_entity_decode($article->text),0,150) !!}<br>
          <a href="{{ url('articles/'.$article->id) }}">Selengkapnya...</a>
        </p>
      @endforeach
      <div class="pagination pull-right"> {!! $articles->links() !!} </div>
    </div>
    <div class="col-sm-4">
      <h4><a href="http://bps.go.id">Badan Pusat Statistik</a></h4>
      <p>(BPS - Statistics Indonesia)</p>
      <p>Jl. Dr. Sutomo 6-8 Jakarta 10710 Indonesia</p>
      <p>Telp (62-21) 3841195, 3842508, 3810291</p>
      <p>Faks (62-21) 3857046</p>
      <p>Mailbox : bpshq@bps.go.id</p>
    </div>
  </div>
</div>
@endsection
