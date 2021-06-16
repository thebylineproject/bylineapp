@extends('front_site.layouts.header')

@section('title', 'HOMEPAGE'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content') 
<!-- ======= Hero Section ======= -->
<section id="hero" class="hero d-flex align-items-center">
  <div class="container-fluid">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200"> <img src="{{ asset('imgs/byline_white_icon.svg') }}" class="img-fluid" alt="" /> </div>
        <div class="col-lg-8 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">WHERE SMALL LEADS BECOME BIG STORIES</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">With the disappearance of hometown publications, local
stories that have national impact go unseen and unheard.
Simply put, under the existing journalistic framework,
culturally significant local stories are often stifled.  <br />
            <br />
            As recipients of the Google Innovation Fund, Okayplayer was
tasked with innovating around these issues and their effects. <br />
            <br />
            From this, The Byline Project was born.</h2>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Hero -->

<main id="main"> 
  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container-fluid">
      <div class="container" data-aos="fade-up">
        <div class="row gx-0 persent_num"> <img src="{{ asset('imgs/laptop_img-01.jpg') }}" class="hidden_laptop" alt="" />
          <div class="col-lg-3 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h2>47%</h2>
              <p>Of newsroom staff have been cut nationwide.</p>
            </div>
          </div>
          <div class="col-lg-3 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h2>1,800</h2>
              <p>Newspapers have closed. The surviving newspapers lack investigative reporting resources.</p>
            </div>
          </div>
          <div class="col-lg-3 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h2>3 Million</h2>
              <p>People living in local news deserts, without access to critical information relevant to their community.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- End About Section --> 
  
  <section id="values" class="values">
    <div class="container" data-aos="fade-up">
      <div class="row">
        <div class="col-lg-12">
          <div class="video" data-aos="fade-up" data-aos-delay="200">
          <div style="padding:60% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/558174000?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="The Byline Project"></iframe></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  

  <!-- ======= Values Section ======= 
  <section id="values" class="values">
    <div class="container" data-aos="fade-up">
      <header class="section-header">
        <h2>WHY WE CREATED <br>
          THIS, IN 8-10 WORDS.</h2>
      </header>
      <div class="row">
        <div class="col-lg-7">
          <div class="video" data-aos="fade-up" data-aos-delay="200">
            <video class="video-fluid" autoplay loop muted controls>
              <source src="https://mdbootstrap.com/img/video/animation-intro.mp4" type="video/mp4" />
            </video>
          </div>
        </div>
        <div class="col-lg-4 offset-md-1 float-md-end">
          <div class="video_text text-right" data-aos="fade-up" data-aos-delay="400">
            <h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</h3>
          </div>
        </div>
        <div class="col-lg-12 mt-4 mt-lg-0 text-center"> <a href="#about" class="btn-call-action scrollto d-inline-flex align-items-center justify-content-center align-self-center"> <span>Call to Action</span> </a> </div>
      </div>
    </div>
  </section>-->
  <!-- End Values Section --> 
  
  <!-- ======= Side by Side Section ======= -->
  <section class="side-by-side who-we-created gray_bg">
    <div class="container-fluid" data-aos="fade-up">
      <div class="row">
        <div class="col-md-6 side-with_img_top"> <img class="img-fluid" src="{{ asset('imgs/girl-with-laptop.jpg') }}"> </div>
      </div>
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="container">
            <div class="col-md-8 offset-md-2">
              <div class="section-heading">
                <p><strong>The Byline Project</strong> is a digital platform that empowers local storytellers to report on issues affecting their communities by connecting journalists to financial support from a broader digital audience.</p>
              </div>
            </div>
            <div class="col-lg-8 mt-4 offset-md-2 mt-lg-0 text-left"> <a href="{{ route('create_pitch') }}" class="btn-call-action scrollto d-inline-flex align-items-center justify-content-center align-self-center"> <span>START PITCHING</span> </a> </div>
          </div>
        </div>
        <div class="col-md-6 side-with_img"> <img src="{{ asset('imgs/girl-with-laptop.jpg') }}" class="img-fluid" alt="" /> </div>
      </div>
    </div>
  </section>
  <!-- End Side by Side  Section 1 --> 
  
  <!-- ======= Combine imgs Section ======= -->
  <section id="counts" class="combine_imgs">
    <div class="container-fluid text-center" data-aos="fade-right"> <img src="{{ asset('imgs/combine_pic_1.jpg') }}" class="img-fluid hide_mob" alt="" />
      <div class="show-mob"> <img src="{{ asset('imgs/thebylineproject-landing-15.jpg') }}" class="img-fluid" alt="" /> <img src="{{ asset('imgs/thebylineproject-landing-14.jpg') }}" class="img-fluid" alt="" /> <img src="{{ asset('imgs/girl-on-chair.jpg') }}" class="img-fluid" alt="" /> </div>
    </div>
  </section>
  <!-- End Combine imgs Section --> 
  
  <!-- ======= Features Section ======= -->
  <section id="features" class="features">
    <div class="container text-center" data-aos="fade-up">
      <div class="col-md-12">
      <div class="quote_img"> <h3 style="font-family: Q;">&#8220;We’ve heard loud and clear from journalists across North America that there is a huge need for bootstrapped and under-funded publishers and journalists to be more empowered to produce quality local journalism that represents the whole of their communities. This is what makes the Byline Project really stand out,&#8221;</h3> <span>- LaToya Drake, Head of Media Representation at Google.</span></div>
          </div>
      <div class="row">
        <div class="col-lg-12"> <img src="{{ asset('imgs/lcd.png') }}" class="img-fluid" alt="" /> </div>
      </div>
      <!-- / row --> 
    </div>
  </section>
  <!-- End Features Section --> 
  
  
  <!-- ======= Side by Side Section 2 ======= -->
  <section class="side-by-side who-we-created">
    <div class="container-fluid" data-aos="fade-up">
      <div class="row align-items-center">
        <div class="col-md-6 side-with_img"> <img src="{{ asset('imgs/women-with-phone.jpg') }}" class="img-fluid" alt="" /> </div>
        <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="container">
            <div class="col-md-12">
              <div class="section-heading">
                <h4>The  process  begins  with  the  initial  step  of  receiving pitches from writers, photographers, and creators. The  moment  a  story  goes  live,  the  online  community can  financially  support  the  content  they  find  valuable through direct-to-reporter tipping.</h4>
              </div>
            </div>
            <div class="col-lg-12 mt-4 mob_view_img mt-lg-0 text-center"> <img src="{{ asset('imgs/phone-view.png') }}" class="img-fluid" alt="" /> </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Side by Side Section 2 --> 
  
  <!-- ======= Combine imgs Section ======= -->
  <section id="counts" class="combine_imgs">
    <div class="container-fluid text-center" data-aos="fade-left"> <img src="{{ asset('imgs/combine_pic_2.jpg') }}" class="img-fluid hide_mob" alt="" />
      <div class="show-mob"> <img src="{{ asset('imgs/thebylineproject-landing-11.jpg') }}" class="img-fluid" alt="" /> <img src="{{ asset('imgs/camra_img.jpg') }}" class="img-fluid" alt="" /> <img src="{{ asset('imgs/bw_1.jpg') }}" class="img-fluid" alt="" /> </div>
    </div>
  </section>
  <!-- End Combine imgs Section --> 
  
  <!-- ======= Google Wants Section ======= 
  <section class="google_wants gray_bg">
    <div class="container-fluid">
      <div class="container" data-aos="fade-up">
        <div class="col-md-9 text-left">
          <div class="section-heading">
            <h2>WHAT GOOGLE WANTS, IN 8-10 WORDS</h2>
          </div>
        </div>
        <div class="col-md-6">
          <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </h4>
          <img src="{{ asset('imgs/quote_rip.svg') }}" class="img-fluid quote_rip" alt="" /> </div>
      </div>
      <div class="girl_img"> <img src="{{ asset('imgs/girl-with-laptop.png') }}" data-aos="fade-left" class="img-fluid" alt="" /> </div>
    </div>
  </section>-->
  <!-- End Google Wants Section --> 
  
  <!-- ======= Create This Section ======= -->
  <section class="create_this">
    <div class="container" data-aos="fade-bottom">
      <div class="row">
        <div class="col-md-6 text-left">
          <div class="section-heading">
            <h2>FREE OPEN-SOURCE<br />
            SOFTWARE DESIGNED<br />
            FOR LOCAL NEWS<br />
            PUBLISHERS.</h2>
          </div>
        </div>
        <div class="col-md-5 offset-md-1"> <img src="{{ asset('imgs/code_img.png') }}" class="img-fluid code_img" alt="" />
          <h4>The Byline Project can be installedvia any WordPress platform, for free.
          <br /><br />
          With The Byline Project, Okayplayer hopes to plant the seeds for an innovative community-driven local news landscape on our own pages, while giving you the tools to do the same on yours.
          </h4>
          <ul class="app_icons">
            <li> <a href="#"><img src="{{ asset('imgs/apple_icon.svg') }}" alt="" /></a> </li>
            <li> <a href="#"><img src="{{ asset('imgs/playstore_icon.svg') }}" alt="" /></a> </li>
            <li> <a href="#"><img src="{{ asset('imgs/window_icon.svg') }}" alt="" /></a> </li>
            <li> <a href="#"><img src="{{ asset('imgs/linux_icon.svg') }}" alt="" /></a> </li>
          </ul>
          <div class="col-lg-8 mt-4 mt-lg-0 text-left"> <a href="https://github.com/thebylineproject/bylineapp" target="_blank" class="btn-call-action scrollto d-inline-flex align-items-center justify-content-center align-self-center"> <span>INSTALL NOW</span> </a> </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Google Wants Section --> 
  
</main>
<!-- End #main --> 
<script src="https://player.vimeo.com/api/player.js"></script>
@endsection