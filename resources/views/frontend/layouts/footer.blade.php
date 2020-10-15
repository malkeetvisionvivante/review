        <section style="margin-top:auto;">
            <footer>
            <div class="container-fluid">
              <div class="row justify-content-center">
                <div class="col-6 col-md-3 order-4 order-md-1">
                @if(strpos(Request::url(), 'home') !== false)
                <a href="{{ url('/') }}"><img src="{{ asset('images/blossom_logo_primary-white.svg')}}" class="img-fluid logo" alt="blossom_logo"></a>
                @else
                <a href="{{ url('/') }}"><img src="{{ asset('images/blossom_logo_primary.svg')}}" class="img-fluid logo" alt="blossom_logo"></a>
                @endif
                  <p class="text-muted mt-md-3">Copyrights 2020<br> All Rights Reserved</p>
                </div>
                <div class="col-12 col-md-6 order-1 order-md-2">
                  <h4>Important Links</h4>
                  <div class="row">
                    <div class="col-6">
                      <ul class="footer-nav pl-0">
                        @if (!Auth::check())
                          @if(strpos(Request::url(), 'home') !== false)
                          <li><a href="#">Sign up</a></li>
                          @else
                          <li><a href="{{ url('/sign-up') }}">Sign up</a></li>
                        @endif
                        @endif
                        <li><a href="{{ url('/about-us') }}">Community Guidelines</a></li>
                        <li><a href="{{ url('/careers') }}">Careers</a></li>
                        <li><a href="{{ url('/help') }}">Help</a></li>
                        <!-- <li><a href="{{ url('/press') }}">Press</a></li>   -->
                        <li><a href="{{ url('/register-your-company') }}">Add your company</a></li>
                      </li>
                    </ul>
                    </div>
                    <div class="col-6">
                      <ul class="footer-nav pl-0">
                          <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                          <li><a href="{{ url('/cookie-policy') }}">Cookie Policy</a></li>
                          <li><a href="{{ url('/terms-conditions') }}">Terms & Conditions</a></li>
                          <!-- <li><a href="{{ url('/user-agreement') }}">User agreement</a></li> -->
                          <!-- <li><a href="{{ url('/other-policies') }}">Other policies</a></li> -->
                      </ul>
                    </div>
                  </div>
              </div>
              <!-- <div class="col-6 col-md-3 order-2 order-md-3">
                
              </div> -->
              <div class="col-6 col-md-3 order-3 order-md-3">
                <!-- <h4>Follow us on</h4>
                 <ul class="social-media pl-0">
                  <li><a href="{{ App\Setting::value('facebook_link') }}" target="_blank" class="pl-0"><i class="fab fa-facebook-f"></i></a></li>
                  <li>
                    <a href="{{ App\Setting::value('twitter_link') }}" target="_blank"><i class="fab fa-twitter"></i></a>
                  </li>
                  <li>
                    <a href="{{ App\Setting::value('linked_in_link') }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                  </li>
                  <li>
                    <a href="{{ App\Setting::value('pinterest_link') }}" target="_blank"><i class="fab fa-pinterest"></i></a>
                  </li>
                  <li>
                    <a href="{{App\Setting::value('instagram_link') }}" target="_blank"><i class="fab fa-instagram"></i></a>
                  </li>
                </ul> -->
              </div>
            </div>
          </footer>
          </section>
          <style>
            .fill-half::before{
                width:47%;
              }
          </style>
           <script>
            $(document).ready(function() {
              $(window).on('scroll', function () {
                  if ($(document).scrollTop()){
                    $(".navbar-outer-div").addClass("shadow-sm bg-white");
                    $(".newsfeed-sticky").addClass("shadow-sm");
                  }
                  else{
                    $(".navbar-outer-div").removeClass("shadow-sm bg-white");
                    $(".newsfeed-sticky").removeClass("shadow-sm");
                  }
                });

                function classOnScroll(){
                let $box = $('.navbar-outer-div'),
                    $scroll = $(window).scrollTop();
                
                if($scroll > 10){
                  if(!$box.hasClass('shadow-sm bg-white')) 
                    $box.addClass('shadow-sm bg-white');
                }
                else
                  $box.removeClass('shadow-sm bg-white');
              }
              //Run on first site run
              classOnScroll();
              //Run on scroll and resize
              $(window).on('scroll resize',classOnScroll);

              // var dataValue = $(".fill-half").attr("data-value");
              // $(".fill-half::before").css("width",dataValue); 
            });
          </script>

<script>
      $("#related__managers").each(function(){
        $(this).owlCarousel({
            loop:false,
            margin:20,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        });
      });
    </script>

<script>
		$(".circle-progress-bar").loading();
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });
	</script>

