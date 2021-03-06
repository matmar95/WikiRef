<!DOCTYPE html>
<?php
error_reporting(0);
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />

    <title>WikiRef</title>

    <script>
        var username = "<?php echo $_SESSION['username'];?>";
    </script>

    <!-- BOOTSTRAP LINK/SCRIPT--><!-- JQuery code-->
    <!--<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- DS3 -->
    <script src="https://d3js.org/d3.v4.min.js"></script>

    <!-- Link to w3school -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Font link icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Link to OpenMaps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.1.0/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.1.0/dist/leaflet.js"></script>


    <!-- CUSTOM LINK/SCRIPT-->
    <!-- Custom JS location -->
    <script src="Script/indexJS.min.js"></script>
    <!-- Custom CSS location -->
    <link rel="stylesheet" href="CSS/indexCSS.min.css">
    <link rel="stylesheet" href="CSS/Hover-master/css/hover-min.css">


    <!-- link for Graph -->
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,600,200italic,600italic&subset=latin,vietnamese' rel='stylesheet' type='text/css'>
    <script src="http://phuonghuynh.github.io/js/bower_components/d3/d3.min.js"></script>
    <script src="http://phuonghuynh.github.io/js/bower_components/d3-transform/src/d3-transform.js"></script>
    <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/extarray.js"></script>
    <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/misc.js"></script>
    <script src="http://phuonghuynh.github.io/js/bower_components/cafej/src/micro-observer.js"></script>
    <script src="http://phuonghuynh.github.io/js/bower_components/microplugin/src/microplugin.js"></script>
    <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/bubble-chart.js"></script>
    <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/central-click/central-click.js"></script>
    <script src="http://phuonghuynh.github.io/js/bower_components/bubble-chart/src/plugins/lines/lines.js"></script>

    <!--<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>-->
    <script>
        $(document).ajaxSend(function(event, request, settings) {
            $('.se-pre-con').show();
        });
        $(document).ajaxComplete(function(event, request, settings) {
            $('.se-pre-con').fadeOut();
        });

        var annote;

        function loadAnnotations() {
            annote = $('#containerAll').annotator();
            Annotator.Plugin.storeMyResult = function (element) {
                return {
                    pluginInit: function () {
                        this.annotator
                            .subscribe("annotationCreated", function (annotation) {
                                console.info("The annotation: %o has just been created!", annotation);
                                var objAnnotation = annotation;
                                delete objAnnotation.highlights;
                                objAnnotation.page = pageName;
                                stringedJSON = JSON.stringify(objAnnotation);
                                console.info(stringedJSON);
                                $.ajax({
                                    type: "POST",
                                    url: "annotator/annotator.php?operation=create",
                                    datatype: "json",
                                    data: {
                                        annotation: stringedJSON,
                                    },
                                    success: function(data){
                                        console.log(data);
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                })
                            })
                            .subscribe("annotationUpdated", function (annotation) {
                                console.log("The annotation: %o has just been updated!", annotation);
                                var objAnnotation = annotation;
                                delete objAnnotation.highlights;
                                objAnnotation.page = pageName;
                                stringedJSON = JSON.stringify(objAnnotation);
                                console.info(stringedJSON);
                                $.ajax({
                                    type: "POST",
                                    url: "annotator/annotator.php?operation=update",
                                    datatype: "json",
                                    data: {
                                        annotation: stringedJSON,
                                    },
                                    success: function(data){
                                        console.log(data);
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                })
                            })
                            .subscribe("annotationDeleted", function (annotation) {
                                console.log("The annotation: %o has just been deleted!", annotation);
                                var objAnnotation = annotation;
                                delete objAnnotation.highlights;
                                objAnnotation.page = pageName;
                                stringedJSON = JSON.stringify(objAnnotation);
                                console.info(stringedJSON);
                                $.ajax({
                                    type: "POST",
                                    url: "annotator/annotator.php?operation=delete",
                                    datatype: "json",
                                    data: {
                                        annotation: stringedJSON,
                                    },
                                    success: function(data){
                                        console.log(data);
                                    },
                                    error: function(data){
                                        console.log(data);
                                    }
                                })
                            })
                    }
                }
            };

            annote.annotator('addPlugin', 'storeMyResult');

            annote.annotator('addPlugin', 'Permissions', {
                user: username,
                permissions: {
                    'read':   [username],
                    'update': [username],
                    'delete': [username],
                    'admin':  [username]
                },
                showEditPermissionsCheckbox: false
            });

            console.log("Loading annotation");
            var objData;
            $.ajax({
                url: "annotator/annotator.php?operation=search",
                datatype: "json",
                data: {
                    page: pageName,
                    user: username
                },
                success: function(data){

                    objData = JSON.parse(data);
                    console.log(data);
                    annote.annotator("loadAnnotations", objData);
                }
            });
        }

    </script>
</head>

<script>
    window.onerror = function (message, url, lineNumber) {
        if (message == "Uncaught Error: Map container is already initialized."){

        }
        return true;
    };
</script>

<!--Sidenav for annotator and login data-->
<div id="mySidenav" class="sidenav">
    <a style="font-size: 50px;">Profile</a>
    <h5 id="sidenavName"><?php if(isset($_SESSION['name'])){print_r($_SESSION['name']);}?></h5>
    <h5 id="sidenavSurname"><?php if(isset($_SESSION['surname'])){print_r($_SESSION['surname']);}?></h5>
    <label id="labelOnOff"class="switch">
        <input type="checkbox" id="ciuchino" onclick="loadAnnotations()">
        <div class="slider round"><span id="checkAnnotation" style=" padding-left: 50px;">Annotator</span></div>
    </label>
    <script>
        $('#ciuchino').change(function() {
            if(!$(this).is(':checked'))
                window.location.reload();
        })
    </script>
    <a  href="#" onclick="closeSession()"><i class="fa fa-sign-out" aria-hidden="true" style="font-size: 25px;">Log out</i></a>
</div>

<body id="body" class="normalBackground" data-target=".navbar" data-offset="50">

<!--Class for loader icon-->
<div class="se-pre-con"></div>

<!-- fixed-top navbar -->
<nav id="navbar-complete"class="navbar navbar-default navbar-fixed-top">
    <div  class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">            </button>
            <a id="navbar-brand" class="navbar-brand hvr-grow" href="index.php">WikiRef</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <?php
            if(isset($_SESSION['username'])){
                ?>
                <a href="#" class="fa fa-sign-in hvr-grow" id="iconLogin" data-toggle="modal" data-target="#modalLogin" style=" display: none"></a>
                <a href="#" class="fa fa-bars hvr-grow" id="iconMenu" onclick="openNav()" aria-hidden="true" style=" display: "></a>
                <?php
            } else {
                ?>
                <a href="#" class="fa fa-sign-in hvr-grow" id="iconLogin" data-toggle="modal" data-target="#modalLogin" style=" display: "></a>
                <a href="#" class="fa fa-bars hvr-grow" id="iconMenu" onclick="openNav()" aria-hidden="true" style=" display: none"></a>
                <?php
            }
            ?>

            <ul id="navList" class="nav navbar-nav">
                <li class="hvr-grow" id="liTitle" style="display: none"><a href="#topPage" id="barTitle"></a></li>
                <li class="hvr-grow" id="liGraph" style="display: none"><a href="#" id="iconGraph" data-toggle="modal" data-target="#modalGraph"><i class="fa fa-bar-chart" style="color: white"></i></a></li>
                <script>
                    $("#iconGraph").one( "click", function() {
                        createGraphic()
                    });
                </script>
                <li class="hvr-grow" id="liTube"  style="display: none"><a href="#" data-toggle="modal" data-target="#modalYouTube"><i class="fa fa-youtube-play" aria-hidden="true" style="color:#CC181E;"></i></a></li>
                <li class="hvr-grow" id="liTwit"  style="display: none"><a href="#rowTwitter"><i class="fa fa-twitter" style=" color:#1DA1F2" aria-hidden="true"></i></a></li>
                <li class="hvr-grow" id="liMap"   style="display: none"><a href="#rowMap" data-toggle="modal" data-target="#modalMap"><i class="fa fa-map-marker" style="color:#0000FF; aria-hidden="true"></i></a></li>
            </ul>

            <div class="col-sm-3 col-md-3 pull-right">
                <div id="searchNavForm" class="form" >
                    <div id="inputNav" class="input-group" style="padding-top: 2px; padding-bottom: 4px;">
                        <input type="text" class="form-control" placeholder="Search" name="searchNav" id="searchNav">
                        <script>
                            $(document).ready(function(){
                                $('#searchNav').keypress(function(e){
                                    if(e.keyCode==13){
                                        $('#navSearchButton').click();
                                    }
                                });
                            });
                        </script>
                        <div class="input-group-btn">
                            <button id="navSearchButton" onclick="reloadSearch(document.getElementById('searchNav').value)" class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!--/.nav-collapse -->
    </div>
</nav>

<div id="main">
    <div id="topPage"></div>

    <!-- modal login/register-->
    <div class="container">
        <div class="modal fade bs-modal-sm" id="modalLogin">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" id="modalDialog">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" id="buttonCloseModal">&times;</button>
                        <br>
                        <ul id="myTab" class="nav nav-tabs fluid">
                            <li class="active" style="width: 50%">
                                <a href="#signin" data-toggle="tab">Sign In</a>
                            </li>
                            <li class="" style="width: 50%;">
                                <a href="#signup" data-toggle="tab">Register</a>
                            </li>
                        </ul>
                        <div class="modal-body">
                            <div id="myTabContent" class="tab-content">

                                <!-- LOGIN -->
                                <div class="tab-pane fade active in" id="signin">
                                    <form action="javascript:0">
                                        <!-- Text input-->
                                        <label class="control-label">User:</label>
                                        <input id="userLogin"  type="text" class="form-control" placeholder="Username" required="">
                                        <!-- Password input-->
                                        <label class="control-label">Password:</label>
                                        <input required="" id="passwordLogin"  class="form-control" type="password" placeholder="********" class="input-medium">

                                        <!-- Button -->
                                        <label class="control-label" id="loginMessage"></label>
                                        <button id="buttonLogin" class="btn btn-success" onclick="loginUser()">Sign In</button>
                                    </form>
                                </div>

                                <!-- SIGN UP -->
                                <div class="tab-pane fade" id="signup">
                                    <form action="javascript:0">
                                        <!-- Text input-->
                                        <label class="control-label">Name:</label>
                                        <input id="name" class="form-control" type="text" placeholder="Name" class="input-large" required="">

                                        <!-- Text input-->
                                        <label class="control-label">Surname:</label>
                                        <input id="surname" class="form-control" type="text" placeholder="Surname" class="input-large" required="">

                                        <!-- Text input-->
                                        <label class="control-label">User:</label>
                                        <input id="userSignUp" class="form-control" type="text" placeholder="User"  required="">

                                        <!-- Password input-->
                                        <label class="control-label">Password:</label>
                                        <input id="password1" class="form-control" type="password" placeholder="********" class="input-large" required="" onkeyup="checkPass()">

                                        <!-- Reenter Password-->
                                        <label class="control-label" for="reenterpassword">Re-Enter Password:</label>
                                        <input id="password2" class="form-control" type="password" placeholder="********" class="input-large" required="" onkeyup="checkPass()">
                                        <!-- Button -->
                                        <label class="control-label" id="registerMessage"></label>
                                        <button id="buttonSignUp" class="btn btn-success" onclick="registerUser()">Sign Up</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal graphic-->
    <div class="container">
        <div class="modal fade bs-modal-sm" id="modalGraph">
            <div class="modal-dialog modal-sm" style="width: 50%; height: auto;">
                <div class="modal-content" id="modalDialogGraph">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" id="buttonCloseModalGraph" style="font-size: 30px;">&times;</button>
                        <h1 style="text-align: center; letter-spacing: 3px; color: rgba(0, 0, 0, 0.55);">Bubble Chart</h1>
                        <h4 style="text-align: center; color: rgba(0, 0, 0, 0.55);">Number of result retriven from APIs</h4>
                        <br>
                        <div id="bodyModalGraph"  class="modal-body">
                            <div class="bubbleChart"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal YouTube-->
<div class="container">
    <div class="modal fade bs-modal-sm" id="modalYouTube">
        <div class="modal-dialog modal-sm" style="width: 70%; height:auto;">
            <div class="modal-content" id="modalDialogYouTube">
                <div class="modal-header" id="headerYouTube">
                    <button type="button" class="close" data-dismiss="modal" id="buttonCloseModalTube" onclick="closeModalTube();" style="font-size: 30px;">&times;</button>

                    <h1 id="h2Tube" style="text-align: center; letter-spacing: 3px; color: #CC181E"></h1>
                    <div class="modal-body " id="bodyYouTube">
                        <div class="w3-content w3-display-container text-center" id="YouTube"></div>
                        <script>
                            $('#modalYouTube').on("hidden.bs.modal", function(e){
                                closeModalTube();
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal OpenMap-->
<div class="container">
    <div class="modal fade bs-modal-lg" id="modalMap">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modalDialogMap">
                <div class="modal-header">
                    <button style="font-size: 30px" type="button" class="close" data-dismiss="modal" id="buttonCloseModalMap">&times;</button>
                    <h2 id="h2Maps" style="text-align: center; letter-spacing: 3px; color: #207AD1"></h2>

                    <div id="bodyModalMap"  class="modal-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(window).on("shown.bs.modal", function(e){
        map.invalidateSize();
    })
</script>

<!-- content -->
<div id="containerLanding" class="container-fluid">
    <div id="resultDefault" class="row scroll-pane" style="display: none;">
        <div id="landingImg" class="container col-md-9" style="text-align: center">
        </div>
        <div id="defaultResult" class="container col-md-3"></div>
    </div>
</div>

<div id="containerResultSearch" class="container-fluid scroll-pane" style="display:none;"></div>
<?php
if(isset($_GET['page'])) {
    if ($_GET['page'] != "") {
        ?>
        <script>
            var pageName = "<?php echo $_GET['page'];?>";
            getSelectedTerm(pageName.replace(/%i20/g, '%20'));
        </script>
        <?php
    }
}
?>
<!--Main container for Wikipedia Twitter and CrossRef-->
<div id="containerAll" class="container-fluid" style="display:">
    <div id="colAll" class="col-md-9">
        <div id="rowWiki" class="row"></div>
        <div id="rowTwitter" class="row" style="display:">
            <h1 id="titleTwit" style="margin-top:40px; display: none;">#Tweets</h1>
            <div class="container-fluid pre-scrollable text-left" id="containerTwit"></div>
        </div>
    </div>
    <div id="colCrossRef" class="col-md-3 scroll-pane" style="display:">
        <div class="container-fluid well pre-scrollable text-left " id="containerCross"></div>
    </div>
</div>
</div>
<script src="http://assets.annotateit.org/annotator/v1.2.10/annotator-full.min.js"></script>
<link rel="stylesheet" href="http://assets.annotateit.org/annotator/v1.2.10/annotator.min.css">
</body>
</html>