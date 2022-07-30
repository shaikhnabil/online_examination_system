<!DOCTYPE html>
<html lang="en">

<head>
  <!--  -->
  <title>Online Examination System</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      font: 400 15px Lato, sans-serif;
      line-height: 1.8;
      color: #818181;
    }

    h2 {
      font-size: 24px;
      text-transform: uppercase;
      color: #303030;
      font-weight: 600;
      margin-bottom: 30px;
    }

    h4 {
      font-size: 19px;
      line-height: 1.375em;
      color: #303030;
      font-weight: 400;
      margin-bottom: 30px;
    }

    .jumbotron {
      background-color: #8548d2;
      color: #f3e9ff;
      padding: 200px 25px;
      font-family: Montserrat, sans-serif;
    }

    .container-fluid {
      padding: 100px 10px;
    }

    .bg-grey {
      background-color: #f6f6f6;
      /*padding: 150px 25px;*/
    }

    .logo-small {
      color: #8548d2;
      font-size: 50px;
    }

    .logo {
      color: #f4511e;
      font-size: 200px;
    }

    .thumbnail {
      padding: 0 0 15px 0;
      border: none;
      border-radius: 0;
    }

    .thumbnail img {
      width: 100%;
      height: 100%;
      margin-bottom: 10px;
    }

    .carousel-control.right,
    .carousel-control.left {
      background-image: none;
      color: #8548d2;
    }

    .carousel-indicators li {
      border-color: #8548d2;
    }

    .carousel-indicators li.active {
      background-color: #8548d2;
    }

    .item h4 {
      font-size: 19px;
      line-height: 1.375em;
      font-weight: 400;
      font-style: italic;
      margin: 70px 0;
    }

    .item span {
      font-style: normal;
    }

    .panel {
      border: 2px outset #8548d2;
      border-radius: 0 !important;
      transition: box-shadow 0.5s;
      text-align: justify;
      text-justify: auto;
      height: 400px;
      font-size: 18px;
      line-height: 30px;
    }

    .panel:hover {
      box-shadow: 5px 0px 40px rgba(0, 0, 0, .2);
    }

    .panel-footer .btn:hover {
      border: 1px solid #f4511e;
      background-color: #fff !important;
      color: #f4511e;
    }

    .panel-heading {
      color: #f3e9ff !important;
      background-color: #8548d2 !important;
      padding: 15px;
      border-bottom: 1px solid transparent;
      border-top-left-radius: 0px;
      border-top-right-radius: 0px;
      border-bottom-left-radius: 0px;
      border-bottom-right-radius: 0px;
    }

    .panel-footer {
      background-color: white !important;
    }

    .panel-footer h3 {
      font-size: 32px;
    }

    .panel-footer h4 {
      color: #aaa;
      font-size: 14px;
    }

    .panel-footer .btn {
      margin: 15px 0;
      background-color: #f4511e;
      color: #fff;
    }

    .navbar {
      margin-bottom: 0;
      background-color: #fff;
      z-index: 9999;
      border-bottom: 1px solid #f3e9ff;
      font-size: 14px !important;
      line-height: 1.42857143 !important;
      letter-spacing: 4px;
      border-radius: 0;
      font-family: Montserrat, sans-serif;
      padding: 10px;
    }

    .navbar li a,
    .navbar .navbar-brand {
      color: #000 !important;
    }

    .navbar-nav li a:hover,
    .navbar-nav li.active a {
      color: #8548d2 !important;
      background-color: #fff !important;
    }

    .navbar-default .navbar-toggle {
      border-color: transparent;
      color: #fff !important;
    }

    footer .glyphicon {
      font-size: 20px;
      margin-bottom: 20px;
      color: #8548d2;
      border-color: transparent;
    }

    .slideanim {
      visibility: hidden;
    }

    .slide {
      animation-name: slide;
      -webkit-animation-name: slide;
      animation-duration: 1s;
      -webkit-animation-duration: 1s;
      visibility: visible;
    }

    .btn {
      padding: 10px 40px;

    }

    @keyframes slide {
      0% {
        opacity: 0;
        transform: translateY(70%);
      }

      100% {
        opacity: 1;
        transform: translateY(0%);
      }
    }

    @-webkit-keyframes slide {
      0% {
        opacity: 0;
        -webkit-transform: translateY(70%);
      }

      100% {
        opacity: 1;
        -webkit-transform: translateY(0%);
      }
    }

    @media screen and (max-width: 768px) {
      .col-sm-4 {
        text-align: center;
        margin: 25px 0;
      }

      .btn-lg {
        width: 100%;
        margin-bottom: 35px;
      }
    }

    @media screen and (max-width: 480px) {
      .logo {
        font-size: 150px;
      }
    }
  </style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<!-- navbar -->
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#myPage">ONLINE EXAM</a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#myPage">HOME</a></li>
          <li><a href="admin/index.php">ADMINISTRATION</a></li>
          <li><a href="news.php">NEWS</a></li>
          <li><a href="#detail">DETAILS</a></li>
          <li><a href="#contact">CONTACT</a></li>
        </ul>
      </div>
    </div>
  </nav>
<!-- header -->
  <div class="jumbotron text-center">
    <h1><b>ONLINE EXAMINATION SYSTEM</b></h1><br>
    <p>The Best Sollution Of Offline Exam</p><br>
    <form>

      <div class="input-group-btn">
        <!-- <a href="login.php"><button type="button" class="btn btn-primary"><i class="fa fa-user-o" aria-hidden="true"></i> Student Login</button></a> -->
        <a href="login.php" class="btn btn-info btn-lg " role="button" aria-pressed="true"><i class="fa fa-user-o" aria-hidden="true"></i> Student Login</a>

      </div>

    </form>
  </div>

  <!-- Container (About Section) -->
  <!-- <div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
      <h2>About Company Page</h2><br>
      <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h4><br>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
      <br><button class="btn btn-default btn-lg">Get in Touch</button>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-signal logo"></span>
    </div>
  </div>
</div> -->

  <!-- <div class="container-fluid bg-grey">
  <div class="row">
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-globe logo slideanim"></span>
    </div>
    <div class="col-sm-8">
      <h2>Our Values</h2><br>
      <h4><strong>MISSION:</strong> Our mission lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</h4><br>
      <p><strong>VISION:</strong> Our vision Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
  </div>
</div> -->

  <!-- Container (Services Section) -->
  <!-- benefits -->
  <div id="services" class="container-fluid text-center">
    <h2>FEATURES</h2>
    <h4>Here's Features of Online Examination System</h4>
    <br>
    <div class="row slideanim">
      <div class="col-sm-4">
        <span class="glyphicon glyphicon-user logo-small"></span>
        <h4>EXAM</h4>
        <p>Multiple users One platform</p>
      </div>

      <div class="col-sm-4">
        <span class="glyphicon glyphicon-file logo-small"></span>
        <h4>WORK</h4>
        <p>Reduces paper work</p>
      </div>
      <div class="col-sm-4">
        <span class="glyphicon glyphicon-leaf logo-small"></span>
        <h4>GREEN</h4>
        <p>Eco-Friendly</p>
      </div>
    </div>
    <br><br>
   

    <!-- Container (Portfolio Section) -->
    <div id="portfolio" class="container-fluid text-center bg-grey">

      <!--  <h2>Portfolio</h2><br>
  <h4>What we have created</h4>
  <div class="row text-center slideanim">
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="paris.jpg" alt="Paris" width="400" height="300">
        <p><strong>Paris</strong></p>
        <p>Yes, we built Paris</p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="newyork.jpg" alt="New York" width="400" height="300">
        <p><strong>New York</strong></p>
        <p>We built New York</p>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="thumbnail">
        <img src="sanfran.jpg" alt="San Francisco" width="400" height="300">
        <p><strong>San Francisco</strong></p>
        <p>Yes, San Fran is ours</p>
      </div>
    </div>
  </div><br> -->

      <h2>Motivational Quotes</h2>
      <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
          <li data-target="#myCarousel" data-slide-to="1"></li>
          <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <div class="item active">
            <h4>“Just believe in yourself. Even if you don’t, pretend that you do and, at some point, you will.”<br><span>― Venus Williams, the first African American tennis player</span></h4>
          </div>
          <div class="item">
            <h4>“Believe in yourself and all that you are. Know that there is something inside you that is greater than any obstacle.”<br><span>― Christian D. Larson, author and teacher</span></h4>
          </div>
          <div class="item">
            <h4>“Everybody is a genius. But if you judge a fish by its ability to climb a tree, it will spend its whole life believing that it is stupid.”<br><span>― Albert Einstein, theoretical physicist</span></h4>
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>

    <!-- Container (Pricing Section) -->
    <div id="detail" class="container-fluid">
      <div class="text-center">
        <h2>Details</h2>
        <h4>Here's information about Online Examination System</h4>
      </div>
      <div class="row slideanim">
        <div class="col-sm-4 col-xs-12">
          <div class="panel panel-default text-center">
            <div class="panel-heading text-center">
              <h1>Admission Test</h1>
            </div>
            <div class="panel-body">
              <p>There are many schools conduct admission test for prospective students.It is one of the entry-level criteria for evaluating eligibility for the admission process.With the help of the this platform,we can define admission tests.Students can attempt such test from any location (home).</p>
            </div>
           
          </div>
        </div>
        <div class="col-sm-4 col-xs-12">
          <div class="panel panel-default text-center">
            <div class="panel-heading text-center">
              <h1>Academic Test</h1>
            </div>
            <div class="panel-body">
              <p>The success of education largely depends on how you are evaluating your students through various new ways of assessments. The focus should be on the practical aspect of the application. Online exams provide you the flexibility to define exam pattern and conduct exams with ease.</p>
            </div>

          </div>
        </div>
        <div class="col-sm-4 col-xs-12">
          <div class="panel panel-default text-center">
            <div class="panel-heading text-center">
              <h1>School Exam</h1>
            </div>
            <div class="panel-body">
              <p>Technology is making a big impact on the way we educate our children. Online examination systems can help schools and instructors conduct exams, which are both efficient and accurate in their delivery of knowledge vital for improving student performance.</p>
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Container (Contact Section) -->
    <div id="contact" class="container-fluid bg-grey">

      <h2 class="text-center">CONTACT</h2>
      <div class="row">
        <div class="col-sm-5">
          <p>Contact us and we'll get back to you within 24 hours.</p>
          <p><span class="glyphicon glyphicon-map-marker"></span> Gujarat, India</p>
          <p><span class="glyphicon glyphicon-phone"></span> +91 7048274907</p>
          <p><span class="glyphicon glyphicon-envelope"></span> onlineexamtest07@gmail.com</p>
        </div>
        <div class="col-sm-7 slideanim">
          <form method="post" id="contact_form">
            <span id="message"></span>
            <div class="row">
              <div class="col-sm-6 form-group">
                <input class="form-control" id="name" name="name" placeholder="Name" type="text" required>
              </div>
              <div class="col-sm-6 form-group">
                <input class="form-control" id="email" name="email" placeholder="Email" type="email" required>
              </div>
              <div class="col-sm-6 form-group">
                <input class="form-control" id="subject" name="subject" placeholder="Subject" type="text" required>
              </div>
            </div>

            <textarea class="form-control" id="message" name="message" placeholder="Message" rows="5"></textarea><br>


            <div class="row">
              <div class="col-sm-6 form-group">
                <!-- <button class="btn btn-default pull-right" name="submit" id="submit_button" value="Send" type="submit">Send</button> -->
                <input type="hidden" name="hidden_id" id="hidden_id" />
                <input type="hidden" name="action" id="action" value="Add" />
                <input type="submit" name="submit" id="submit_button" class="btn btn-default pull-right" value="Send" />
              </div>
            </div>
        </div>
        </form>
      </div>
    </div>

    <!-- Image of location/map -->
    <!-- <img src="/w3images/map.jpg" class="w3-image w3-greyscale-min" style="width:100%"> -->

    <footer class="container text-center"><br>
      <a href="#myPage" title="To Top">
        <span class="glyphicon glyphicon-chevron-up"></span>
      </a>
      <p>Copyright &copy; Online Exam &nbsp; 2021-22</p>
    </footer>

    <script>
      $(document).ready(function() {
        // Add smooth scrolling to all links in navbar + footer link
        $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
          // Make sure this.hash has a value before overriding default behavior
          if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
              scrollTop: $(hash).offset().top
            }, 900, function() {

              // Add hash (#) to URL when done scrolling (default click behavior)
              window.location.hash = hash;
            });
          } // End if
        });

        $(window).scroll(function() {
          $(".slideanim").each(function() {
            var pos = $(this).offset().top;

            var winTop = $(window).scrollTop();
            if (pos < winTop + 600) {
              $(this).addClass("slide");
            }
          });
        });
      })
    </script>

</body>

</html>

<script>
  $(document).ready(function() {
    //request to submit data of contact form
    $('#contact_form').on('submit', function(event) {
      event.preventDefault();

      $.ajax({
        url: "contact_action.php",
        method: "POST",
        data: $(this).serialize(),
        dataType: 'json',
        beforeSend: function() {
          $('#submit_button').attr('disabled', 'disabled');
          $('#submit_button').val('wait...');
        },
        success: function(data) {
          $('#submit_button').attr('disabled', false);
          if (data.error != '') {
            $('#form_message').html(data.error);
            $('#submit_button').val('Send');
          } else {
            //$('#classModal').modal('hide');
            $('#message').html(data.success);
            $('#submit_button').val('Send');
            // dataTable.ajax.reload();
            $('#contact_form').trigger("reset");
            setTimeout(function() {

              $('#message').html('');

            }, 5000);
          }
        }
      })

    });
  });
</script>