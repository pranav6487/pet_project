<?php
global $global_params;
global $page_params;
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex">

    <title>Feedback</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo CSS_URL.PAGE_LANDING_CSS_BOOTSTRAP;?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo CSS_URL.PAGE_LANDING_CSS_AGENCY;?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo FONT_AWESOME_URL.PAGE_FONTAWESOME_CSS; ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
        div.stars {
            //width: 270px;
            display: inline-block;
          }

          input.star { display: none; }

          label.star {
            float: right;
            padding: 10px;
            font-size: 36px;
            color: #444;
            transition: all .2s;
          }

          input.star:checked ~ label.star:before {
            content: '\f005';
            color: #FD4;
            transition: all .25s;
          }

          input.star-5:checked ~ label.star:before {
            color: #FE7;
            text-shadow: 0 0 20px #952;
          }

          input.star-1:checked ~ label.star:before { color: #F62; }

          label.star:hover { transform: rotate(-15deg) scale(1.3); }

          label.star:before {
            content: '\f006';
            font-family: FontAwesome;
          }
    </style>
</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <a class="navbar-brand page-scroll" href="#page-top">Feedback</a>
            </div>
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Feedback Section -->
    <section id="feedbackFrm" class="<?php echo $dispFeedBackFrm; ?>" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">How was your experience</h2>
                    <h3 class="section-subheading text-muted">Your feedback is important for us. We value your views which helps us serve you better</h3>
                </div>
            </div>
            <div class="row text-center">
                <p class="text-muted">Please give your rating for the below parameters based on your experience with us. It would take less than 60 seconds</p>
                <div class="col-lg-12" id="ambienceRating">
                    <h4 class="service-heading">Ambience & Atmosphere</h4>
                    <p class="text-muted">
                        <div class="stars">
                              <input class="star star-5" id="ambience-5" type="radio" name="ambience" value = "5" />
                              <label class="star star-5" for="ambience-5"></label>
                              <input class="star star-4" id="ambience-4" type="radio" name="ambience" value = "4" />
                              <label class="star star-4" for="ambience-4"></label>
                              <input class="star star-3" id="ambience-3" type="radio" name="ambience" value = "3" />
                              <label class="star star-3" for="ambience-3"></label>
                              <input class="star star-2" id="ambience-2" type="radio" name="ambience" value = "2" />
                              <label class="star star-2" for="ambience-2"></label>
                              <input class="star star-1" id="ambience-1" type="radio" name="ambience" value = "1" />
                              <label class="star star-1" for="ambience-1"></label>
                      </div>
                    </p>
                    <p class="help-block text-danger hide" id="ambienceError">Please select a rating</p>
                </div>
                <div class="col-lg-12" id="foodQualityRating">
                    <h4 class="service-heading">Quality of Food</h4>
                    <p class="text-muted">
                        <div class="stars">
                              <input class="star star-5" id="foodQuality-5" type="radio" name="foodQuality" value = "5" />
                              <label class="star star-5" for="foodQuality-5"></label>
                              <input class="star star-4" id="foodQuality-4" type="radio" name="foodQuality" value = "4" />
                              <label class="star star-4" for="foodQuality-4"></label>
                              <input class="star star-3" id="foodQuality-3" type="radio" name="foodQuality" value = "3" />
                              <label class="star star-3" for="foodQuality-3"></label>
                              <input class="star star-2" id="foodQuality-2" type="radio" name="foodQuality" value = "2" />
                              <label class="star star-2" for="foodQuality-2"></label>
                              <input class="star star-1" id="foodQuality-1" type="radio" name="foodQuality" value = "1" />
                              <label class="star star-1" for="foodQuality-1"></label>
                      </div>
                    </p>
                    <p class="help-block text-danger hide" id="foodQualityError">Please select a rating</p>
                </div>
                <div class="col-lg-12" id="staffFriendlyRating">
                    <h4 class="service-heading">Friendliness of Staff</h4>
                    <p class="text-muted">
                        <div class="stars">
                              <input class="star star-5" id="staffFriendly-5" type="radio" name="staffFriendly" value = "5" />
                              <label class="star star-5" for="staffFriendly-5"></label>
                              <input class="star star-4" id="staffFriendly-4" type="radio" name="staffFriendly" value = "4" />
                              <label class="star star-4" for="staffFriendly-4"></label>
                              <input class="star star-3" id="staffFriendly-3" type="radio" name="staffFriendly" value = "3" />
                              <label class="star star-3" for="staffFriendly-3"></label>
                              <input class="star star-2" id="staffFriendly-2" type="radio" name="staffFriendly" value = "2" />
                              <label class="star star-2" for="staffFriendly-2"></label>
                              <input class="star star-1" id="staffFriendly-1" type="radio" name="staffFriendly" value = "1" />
                              <label class="star star-1" for="staffFriendly-1"></label>
                      </div>
                    </p>
                    <p class="help-block text-danger hide" id="staffFriendlyError">Please select a rating</p>
                </div>
                <div class="col-lg-12" id="cleanlinessRating">
                    <h4 class="service-heading">Cleanliness</h4>
                    <p class="text-muted">
                        <div class="stars">
                              <input class="star star-5" id="cleanliness-5" type="radio" name="cleanliness" value = "5" />
                              <label class="star star-5" for="cleanliness-5"></label>
                              <input class="star star-4" id="cleanliness-4" type="radio" name="cleanliness" value = "4" />
                              <label class="star star-4" for="cleanliness-4"></label>
                              <input class="star star-3" id="cleanliness-3" type="radio" name="cleanliness" value = "3" />
                              <label class="star star-3" for="cleanliness-3"></label>
                              <input class="star star-2" id="cleanliness-2" type="radio" name="cleanliness" value = "2" />
                              <label class="star star-2" for="cleanliness-2"></label>
                              <input class="star star-1" id="cleanliness-1" type="radio" name="cleanliness" value = "1" />
                              <label class="star star-1" for="cleanliness-1"></label>
                      </div>
                    </p>
                    <p class="help-block text-danger hide" id="cleanlinessError">Please select a rating</p>
                </div>
                <div class="col-lg-12" id="serviceSpeedRating">
                    <h4 class="service-heading">Speed of Service</h4>
                    <p class="text-muted">
                        <div class="stars">
                              <input class="star star-5" id="serviceSpeed-5" type="radio" name="serviceSpeed" value = "5" />
                              <label class="star star-5" for="serviceSpeed-5"></label>
                              <input class="star star-4" id="serviceSpeed-4" type="radio" name="serviceSpeed" value = "4" />
                              <label class="star star-4" for="serviceSpeed-4"></label>
                              <input class="star star-3" id="serviceSpeed-3" type="radio" name="serviceSpeed" value = "3" />
                              <label class="star star-3" for="serviceSpeed-3"></label>
                              <input class="star star-2" id="serviceSpeed-2" type="radio" name="serviceSpeed" value = "2" />
                              <label class="star star-2" for="serviceSpeed-2"></label>
                              <input class="star star-1" id="serviceSpeed-1" type="radio" name="serviceSpeed" value = "1" />
                              <label class="star star-1" for="serviceSpeed-1"></label>
                      </div>
                    </p>
                    <p class="help-block text-danger hide" id="serviceSpeedError">Please select a rating</p>
                </div>
                <div class="col-lg-12" id="recommendRating">
                    <h4 class="service-heading">How likely are you to refer a friend to Restaurant</h4>
                    <p class="text-muted">
                        <div class="form-group">
                            <select class="form-control" id="recommend">
                                <option value="">0 = Most unlikely to 10 = Most likely</option>
                                <option value ="0">0</option>
                                <option value ="1">1</option>
                                <option value ="2">2</option>
                                <option value ="3">3</option>
                                <option value ="4">4</option>
                                <option value ="5">5</option>
                                <option value ="6">6</option>
                                <option value ="7">7</option>
                                <option value ="8">8</option>
                                <option value ="9">9</option>
                                <option value ="10">10</option>
                            </select>
                        </div>
                    </p>
                    <p class="help-block text-danger hide" id="recommendError">Please select a rating</p>
                </div>
                <div class="col-lg-12">
                    <h4 class="service-heading">Any comments & suggestions (optional)</h4>
                    <div class="form-group">
                        <textarea id="comments" placeholder="Comments & Suggesstions" class="form-control" style="height:200px;"></textarea>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div id="success"></div>
                    <input type="hidden" id="bookingId" name="bookingId" value="<?php echo $pageArgs['bid']; ?>"/>
                    <button class="btn btn-xl" type="submit" id="sbmtFeedBack">Submit</button>
                </div>
            </div>
        </div>
    </section>
    
    <section id="thankYou" class="hide">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Thank you for your feedback</h2>
                    <h3 class="section-subheading text-muted">We appreciate your time. Your valuable inputs will help us serve you better</h3>
                </div>
            </div>
        </div>
    </section>
    
    <section id="error" class="<?php echo $dispError; ?>" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Error</h2>
                    <h3 class="section-subheading text-muted" id="feedbackErrTxt"><?php echo $errorText; ?> </h3>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <span class="copyright">Copyright &copy; www.ManageMyResto.com 2016</span>
                </div>
                <!-- <div class="col-md-4">
                    <span class="copyright">Copyright &copy; www.managemyresto.com 2016</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div> -->
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="<?php echo JS_URL.PAGE_LANDING_JS_JQUERY; ?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo JS_URL.PAGE_LANDING_JS_BOOTSTRAP; ?>"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="<?php echo JS_URL.PAGE_LANDING_JS_CLASSIE; ?>"></script>
    <script src="<?php echo JS_URL.PAGE_LANDING_JS_CBPANIMATEDHEADER; ?>"></script>

    <!-- Contact Form JavaScript -->
    <script src="<?php echo JS_URL.PAGE_LANDING_JS_JQBOOTSTRAPVALIDATION; ?>"></script>
    <script src="<?php echo JS_URL.PAGE_LANDING_JS_CONTACTME; ?>"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo JS_URL.PAGE_LANDING_JS_AGENCY; ?>"></script>

</body>

</html>
