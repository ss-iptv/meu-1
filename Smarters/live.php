<?php
/*
 * @ PHP 5.6
 * @ Decoder version : 1.0.0.1
 */

if (!isset($_POST["dateFullData"])) {
    echo "    <!DOCTYPE html>\r\n    <html lang=\"en\">\r\n        <head>\r\n            <!-- google font link -->\r\n            <link href=\"https://fonts.googleapis.com/css?family=Open+Sans|Raleway\" rel=\"stylesheet\">\r\n            <!-- google font link -->\r\n            <link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\">\r\n            <link href=\"https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css\" rel=\"stylesheet\">\r\n            <script type=\"text/javascript\" src=\"js/jquery-1.11.2.min.js\"></script>\r\n        </head>\r\n        <body>\r\n            <form method=\"POST\" id=\"FormSubmit\" action=\"\">\r\n                <input type=\"hidden\" name=\"dateFullData\" id=\"InputFieldId\" value=\"\">\r\n            </form>\r\n            <script type=\"text/javascript\">\r\n                var currentTime = new Date();\r\n                var getDate = currentTime.getDate();\r\n                var getMonth = currentTime.getMonth() < 12 ? currentTime.getMonth() + 1 : 1;\r\n                var getFullYear = currentTime.getFullYear();\r\n                var getHours = currentTime.getHours();\r\n                var getMinutes = currentTime.getMinutes();\r\n                var getSeconds = currentTime.getSeconds();\r\n                var dateDatatosent = getDate + '-' + getMonth + '-' + getFullYear + ' ' + getHours + ':' + getMinutes + \":\" + getSeconds;\r\n                \$(\"#InputFieldId\").val(dateDatatosent);\r\n                var infputfieldvalue = \$(\"#InputFieldId\").val();\r\n                if (infputfieldvalue != '')\r\n                {\r\n                    \$(\"#FormSubmit\").submit();\r\n                }\r\n            </script>\r\n        </body>\r\n    </html>\r\n\r\n\r\n\r\n    ";
} else {
    include "includes/header.php";
    if ($checkLicense["status"] != "Active") {
        echo "<script>window.location.href = 'oops.php';</script>";
        exit;
    }
    $CurrentPcDateTime = new DateTime($_POST["dateFullData"]);
    $CurrentTime = $CurrentPcDateTime->getTimestamp();
    if ($ShiftedTimeEPG != "0") {
        $CurrentTime = strtotime($ShiftedTimeEPG . " hours", $CurrentTime);
    }
    $FinalCategoriesArray = array();
    $FinalChannelsArray = array();
    $FinalChannelsArrayWithEpg = array();
    $GetLiveStreamCateGories = webtvpanel_CallApiRequest($hostURL . $bar . "player_api.php?username=" . $username . "&password=" . $password . "&action=get_live_categories");
    if ($GetLiveStreamCateGories) {
        $FinalCategoriesArray = $GetLiveStreamCateGories;
    }
    include "includes/sideNav.php";
    echo "<script src='https://content.jwplatform.com/libraries/fgbTqCCh.js'></script>\r\n<script>\r\n function confirmparent(categoryID = '',onload = '')\r\n{\r\n  if(onload == 1)\r\n  {\r\n    \$('.main-fullContainer').addClass('hideOnLoad');\r\n    /*\$('.no-reultcontainer').removeClass('hideOnLoad');*/\r\n    \$('#fullLoader').addClass('hideOnLoad');\r\n    \$('.chanelLoader').hide();\r\n    \$('#fullLoader').addClass('hideOnLoad');\r\n    \$('.chanels').html(\"\")\r\n    \$('.liveEPG').html('').hide();\r\n    \$('#player-wrapper').addClass('noResult');\r\n    \$('#player-wrapper').html('');\r\n  }\r\n /* alert(\"Alert from function is \"+categoryID);*/\r\n  \$(\"#confirmpasswordbtn\").data('categoryID',categoryID);\r\n  \$('#confirmparentPopup').modal('show');\r\n\r\n  \r\n  \r\n}\r\n\r\n  var reconnectInt;\r\n  function getData(\$categoryID = '')\r\n{\r\n  if(reconnectInt !== null || reconnectInt !== undefined)\r\n          {\r\n            clearInterval(reconnectInt);\r\n          } \r\n  removeSearchSec();\r\n  \$('.chanels').html('');\r\n  \$('.chanelLoader').show().removeClass('hideOnLoad');\r\n   jQuery.ajax({\r\n            type:\"POST\",\r\n            url:\"includes/ajax-control.php\",\r\n            dataType:\"text\",\r\n            data:{\r\n            action:'getStreamsFromID',\r\n            categoryID:\$categoryID,\r\n            hostURL: \"";
    echo $XCStreamHostUrl . $bar;
    echo "\"\r\n            },  \r\n              success:function(response2){ \r\n                \$getStreamsfromCategory = response2;\r\n                \$('.chanelLoader').hide();\r\n                \$('#fullLoader').addClass('hideOnLoad');\r\n                \r\n                \$('.chanels').html(\$getStreamsfromCategory);\r\n                var StreamId = \$('.Playclick').first().find('.streamId').val();\r\n                var StreamType = \$('.Playclick').first().find('.streamId').data('streamtype');\r\n                \$('.Playclick').first().addClass('playingChanel');\r\n                \$(document).find(\".rippler\").rippler({\r\n    effectClass      :  'rippler-effect'\r\n    ,effectSize      :  0      // Default size (width & height)\r\n    ,addElement      :  'div'   // e.g. 'svg'(feature)\r\n    ,duration        :  400\r\n  });\r\n\r\n                \$Videolink = \"";
    echo $XCStreamHostUrl . $bar . "live/" . $username . "/" . $password;
    echo "/\"+StreamId+\".m3u8\"\r\n                getVideoLinkAjax(\$Videolink);\r\n                getEPGdata(StreamId);\r\n              }\r\n            })\r\n}\r\n\r\n\r\nfunction getEPGdata(\$streamID = '')\r\n{\r\n  \$('.liveEPG').html('').hide();\r\n  \$('.epgloader').removeClass('hideOnLoad');\r\n\r\n  var CurrentTime = \$(\"#CurrentTime\").val();\r\n  jQuery.ajax({\r\n            type:\"POST\",\r\n            url:\"includes/epgdata.php\",\r\n            dataType:\"text\",\r\n            data:{\r\n            action:'GetEpgDataByStreamid',\r\n            StreamId:\$streamID,\r\n            CurrentTime:CurrentTime,\r\n            hostURL : \"";
    echo $XCStreamHostUrl . $bar;
    echo "\" \r\n            },  \r\n            success:function(response){\r\n              if(response != \"0\")\r\n              {\r\n\r\n                 \r\n\r\n               \$('.liveEPG').show().html(response);\r\n               \$('.epgloader').addClass('hideOnLoad');\r\n               if(\$(document).find('.NowPlayingActive').length >= 1)\r\n               {\r\n\r\n                var scroll = \$(document).find('.NowPlayingActive').offset().top;\r\n                var scrollHolder = \$(document).find('.liveEPG').offset().top;\r\n                scroll = scroll-scrollHolder;\r\n               \r\n                \$(document).find('.tab-pane.active').animate({\r\n                  scrollTop: (scroll-100)\r\n                },500); \r\n               \r\n               }\r\n               \r\n                \r\n                                  \r\n                                     \r\n              }\r\n            }\r\n          });\r\n}\r\n\r\nfunction getVideoLinkAjax(\$Videolink = \"\", FailCounter = \"\")\r\n{\r\n    //console.log(\$Videolink);\r\n    \$('.Loadicon').remove();\r\n    \$LiveVideoLink = \$Videolink;\r\n    if(reconnectInt !== null || reconnectInt !== undefined)\r\n          {\r\n            clearInterval(reconnectInt);\r\n          } \r\n    var player = jwplayer('player-wrapper');\r\n    // Set up the player with an HLS stream that includes timed metadata\r\n    player.setup({\r\n      \"file\": \$LiveVideoLink,\r\n      \"width\":\"100%\",\r\n      \"aspectratio\": \"16:9\"              \r\n    });\r\n    player.on('play',function(){\r\n      counter = 0;\r\n      clearInterval(reconnectInt);\r\n    })\r\n     player.on('error', function() {\r\n    /*var PlayerDIvSelector = \$('#player-wrapper');\r\n    PlayerDIvSelector.html('');\r\n    PlayerDIvSelector.attr('class', '');\r\n    PlayerDIvSelector.css('text-align', 'center');\r\n    PlayerDIvSelector.html('<img src=\"webtv/images/roundloader.gif\" alt=\"tv image\">');*/\r\n        var showText = 1;\r\n              var PlayerDIvSelector = \$('#player-wrapper');\r\n              PlayerDIvSelector.html('');\r\n              PlayerDIvSelector.attr('class', '');\r\n              PlayerDIvSelector.css('text-align', 'center');\r\n              PlayerDIvSelector.html('<div class=\"erroronplayer\"><span>Playback error, reconnects in 5s ('+showText+'/5)</span></div>');\r\n\r\n                \r\n                console.log('Stream connection lose reconnecting ' +showText +\" Time\");\r\n                console.log(\$(document).find('.jw-title-primary').text() + \$(document).find('.jw-title-secondary').text());\r\n            reconnectLoop(\$LiveVideoLink,FailCounter);\r\n            return false;\r\n      \r\n     \r\n    });\r\n}\r\n\r\nfunction reconnectLoop(Link,FailCounter)\r\n{\r\n\r\n\r\n  var counter = 0;\r\n      if(FailCounter == \"new\")\r\n            {\r\n              counter = 0;\r\n            } \r\n            console.log(counter);\r\n            \r\n            reconnectInt = setInterval(function()\r\n            {\r\n              counter++;\r\n              if(counter < 5)\r\n              {\r\n                var player = jwplayer(\"player-wrapper\").setup({\r\n                  \"file\": Link,\r\n                  \"width\": \"100%\",\r\n                  \"aspectratio\": \"16:9\"\r\n                });\r\n                player.on('play', function() {\r\n                  counter = 0;\r\n                  clearInterval(reconnectInt);\r\n                });\r\n                player.on('error', function(){\r\n                  var showText = Number(counter)+Number(1);\r\n                    var PlayerDIvSelector = \$('#player-wrapper');\r\n                    PlayerDIvSelector.html('');\r\n                    PlayerDIvSelector.attr('class', '');\r\n                    PlayerDIvSelector.css('text-align', 'center');\r\n                    PlayerDIvSelector.html('<div class=\"erroronplayer\"><span>Playback error, reconnects in 5s ('+showText+'/5)</span></div>');\r\n\r\n                      //counter = Number(counter)+Number(1);\r\n                      console.log('Stream connection lose reconnecting ' +counter +\" Time\");\r\n                      console.log(\$(document).find('.jw-title-primary').text() + \$(document).find('.jw-title-secondary').text());\r\n                      })\r\n              }\r\n              else\r\n              {\r\n                \r\n                  clearInterval(reconnectInt);\r\n                  counter = 0;\r\n                  var PlayerDIvSelector = \$('#player-wrapper');\r\n                  PlayerDIvSelector.html('');\r\n                  PlayerDIvSelector.attr('class', '');\r\n                  PlayerDIvSelector.css('text-align', 'center');\r\n                  PlayerDIvSelector.html('<div class=\"erroronplayer\"><span>Sorry, this video can not be played.<br> Please try again or pick another video.</span></div>');\r\n              }\r\n              \r\n            },5000);\r\n              \r\n}\r\n\$(document).ready(function(){\r\n  \$(\".showbtn\").click(function(e){\r\n      e.preventDefault();\r\n      var currenteye = \$(this).data('currenteye');\r\n      var InputID = \$(this).attr('href')\r\n      var faid = \$(this).data('faid');\r\n      if(currenteye == \"hide\")\r\n      {\r\n        \$(this).data('currenteye','show');\r\n        \$(InputID).attr('type','password');\r\n        \$(\"#\"+faid).removeClass(\"fa fa-eye\");\r\n        \$(\"#\"+faid).addClass(\"fa fa-eye-slash\");\r\n      }\r\n      else\r\n      {\r\n        \$(this).data('currenteye','hide')\r\n        \$(InputID).attr('type','text');\r\n        \$(\"#\"+faid).removeClass(\"fa fa-eye-slash\");\r\n        \$(\"#\"+faid).addClass(\"fa fa-eye\");\r\n      }\r\n  });\r\n  \r\n  \$('#confirmpasswordbtn').click(function(){\r\n    \$(\"#parentPass\").removeClass('addredborder');    \r\n    var parentPass = \$(\"#parentPass\").val();\r\n    var categoryid = \$(this).data('categoryID');\r\n    if(parentPass == \"\")\r\n    {\r\n      \$(\"#parentPass\").addClass('addredborder');\r\n    }\r\n    else\r\n    {\r\n      \$('#checkingprocess2').removeClass('hideOnLoad');\r\n      jQuery.ajax({\r\n      type:\"POST\",\r\n      url:\"includes/ajax-control.php\",\r\n      dataType:\"text\",\r\n      data:{\r\n        action:'confirm_parentpassword',\r\n        parentPass:parentPass\r\n      },  \r\n        success:function(response2){ \r\n          \$('#checkingprocess2').addClass('hideOnLoad');\r\n           if(response2 != 0)\r\n           {\r\n              \$('#parentPass').val('');\r\n              \$('#confirmparentPopup').modal('hide');   \r\n               getData(categoryid);        \r\n           }\r\n           else\r\n           {\r\n              swal({\r\n                  title: 'Error!',\r\n                  text: 'Invalid PIN !!!',\r\n                  icon: 'warning'\r\n                 });\r\n           }             \r\n        }\r\n      });\r\n    }\r\n      \r\n  });\r\n\r\n\r\n\r\n  \$('#SearchData').keypress(function (e) {\r\n   var key = e.which;\r\n   if(key == 13)  // the enter key code\r\n    {\r\n        callSearchFun(); \r\n    }\r\n  });  \r\n\r\n  var omLoadCategoryID = \$(document).find('.onloadCallCategory').data('categoryid');\r\n  var parentControlData = \$(document).find('.onloadCallCategory').data('pcon');\r\n  if(parentControlData == 1)\r\n  {\r\n      confirmparent(omLoadCategoryID,1);\r\n  }\r\n  else\r\n  {\r\n    getData(omLoadCategoryID);\r\n  }  \r\n  \$( document ).on(\"click\", \".Playclick\", function(){\r\n        \$('.epgloader').removeClass('hideOnLoad');\r\n        \$('liveEPG').html('');\r\n        var StreamId = \$(this).find('.streamId').val();\r\n        var StreamType = \$(this).find('.streamId').data('streamtype');\r\n        \$('.Playclick').removeClass('playingChanel');\r\n        \$(this).addClass('playingChanel');\r\n\r\n        \$Videolink = \"";
    echo $XCStreamHostUrl . $bar . "live/" . $username . "/" . $password;
    echo "/\"+StreamId+\".m3u8\"\r\n        getVideoLinkAjax(\$Videolink);  \r\n        getEPGdata(StreamId);\r\n         var scroll1 = \$(document).find('.video-player1').offset().top;\r\n                \$('body, html').animate({\r\n                  scrollTop: (scroll1-100)\r\n                },500); \r\n     });\r\n\r\n  /*jwplayer(\"player-wrapper\").setup({\r\n        //flashplayer: \"player.swf\",\r\n        file: \"\",\r\n        \r\n    });*/\r\n\r\n     \$( document ).on(\"click\", \"#SearchBtn\", function(){\r\n             callSearchFun();\r\n        });\r\n\r\n     \$( document ).on(\"click\", \".clearSearch\", function(){\r\n            removeSearchSec();\r\n        });\r\n});\r\n\r\n\r\nfunction callSearchFun()\r\n{\r\n  \$('#noResultFound').remove();\r\n   var SearchData = \$(\"#SearchData\").val();   \r\n   if(SearchData != \"\")\r\n   {\r\n      \$('.streamList').addClass('hideOnLoad');\r\n      var moive_namesearch = \$('.serch_key');\r\n      filter = SearchData.toUpperCase();\r\n      CustomIndex = 0;\r\n      moive_namesearch.each(function( index ) {\r\n        if (\$( this ).val().toUpperCase().indexOf(filter) > -1) {\r\n          \$(\".\"+\$(this).data('parentliclass')).removeClass('hideOnLoad');\r\n          CustomIndex = 1;\r\n        }\r\n      });  \r\n      if(CustomIndex == 0)\r\n      {\r\n          \$('.channels-ul').append('<li id=\"noResultFound\">No Result Found!!')\r\n      }\r\n      \$('#search').removeClass('open');\r\n      \$('.clearSearch').removeClass('hideOnLoad');\r\n\r\n   }\r\n   else\r\n   {\r\n      swal('Digite a palavra-chave para pesquisa.',{button: false});\r\n      setTimeout(function(){swal.close();},2000);\r\n   }\r\n}\r\n\r\n\r\nfunction removeSearchSec()\r\n{\r\n   \$('#SearchData').val(''); \r\n   \$('#noResultFound').remove();\r\n   \$('.clearSearch').addClass('hideOnLoad'); \r\n   \$('.streamList').removeClass('hideOnLoad'); \r\n}\r\n\r\n  </script>\r\n\r\n\r\n<style type=\"text/css\">\r\n  .PlayerLoader .erroronplayer {\r\n      position: relative;\r\n      top: 150px;\r\n  }\r\n   .addredborder\r\n  {\r\n    border:1px solid red !important;\r\n  }\r\n\r\n  .modal-backdrop {\r\n      z-index: 1040 !important;\r\n  }\r\n  .modal-dialog {\r\n      z-index: 1100 !important;\r\n  }\r\n\r\n  .in {\r\n    background: rgba(0, 0, 0, 0.95);\r\n    }\r\n\r\n    button#UpdateParentPassword {\r\n        position: relative;\r\n        top: 18px;\r\n    }\r\n    .commoncs2, .commoncs2:focus, .commoncs2:active\r\n    {\r\n        background: transparent;\r\n        color: #000 !important;\r\n        padding: 0;\r\n        box-shadow: none;\r\n        outline: none;\r\n        border: 0;\r\n        border-bottom: 1px solid #000;\r\n        border-radius: 0;\r\n    }\r\n    .commoncs2::-webkit-input-placeholder {\r\n        color: #000 !important;\r\n      }\r\n  a.showbtn {\r\n      top: -22px;\r\n      position: relative;\r\n      left: 94%;\r\n  } \r\n\r\n  a.popsbtn {\r\n    top: -32px;\r\n}\r\n</style>\r\n<div class=\"modal fade\" id=\"confirmparentPopup\" role=\"dialog\" data-backdrop=\"static\" data-keyboard=\"false\">\r\n    <div class=\"modal-dialog\">\r\n    \r\n      <!-- Modal content-->\r\n      <div class=\"modal-content\">\r\n        <div class=\"modal-header\">\r\n          <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>\r\n          <h4 class=\"modal-title\">Confirmar Senha</h4>\r\n        </div>\r\n        <div class=\"modal-body\">\r\n          <input type=\"password\" id=\"parentPass\" class=\"form-control commoncs2\" placeholder=\"Enter PIN\" value=\"\"  >\r\n          <a href=\"#parentPass\" data-currenteye=\"show\" data-faid=\"fappass\" class=\"showbtn popsbtn\" ><i class=\"fa fa-eye-slash\" id=\"fappass\" aria-hidden=\"true\"></i></a>\r\n        </div>\r\n        <div class=\"modal-footer\">\r\n          <button type=\"button\" id=\"confirmpasswordbtn\" class=\"btn btn-primary\">Confirmar <i class=\"fa fa-spin fa-spinner hideOnLoad\" id=\"checkingprocess2\"></i></button>\r\n          <button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Fechar</button>\r\n        </div>\r\n      </div>\r\n      \r\n    </div>\r\n  </div>\r\n<div class=\"container-fluid\">\r\n  <center id=\"fullLoader\"><img src=\"images/roundloader.gif\"><p class=\"text-center\">CARREGANDO</p></center>\r\n<input type=\"hidden\" id=\"CurrentTime\" value=\"";
    echo $CurrentTime;
    echo "\" data-temp=\"";
    echo date("Y M d h:i A", $CurrentTime);
    echo "\">\r\n        <!-- Live Channels -->\r\n        <div class=\"col-sm-5\">\r\n          <h2 style=\"margin-top: 30px;\">Canais ao vivo <span class=\"clearSearch hideOnLoad rippler rippler-default\">Clear Search</span></h2>\r\n\r\n          <div class=\"channel-list\">\r\n            <div class=\"chanelLoader hideOnLoad\">\r\n              <center><img src=\"images/roundloader.gif\"><p class=\"text-center\">CARREGANDO CANAIS</p></center>\r\n            </div>\r\n            <ul class=\"free-wall chanels channels-ul\">\r\n            \r\n            </ul>\r\n          </div>\r\n        </div>\r\n        <!-- /Live Channels -->\r\n        <!-- Video Player -->\r\n        <div class=\"col-sm-7\">\r\n          <div class=\"video-player1\">\r\n            <div id=\"player-wrapper\" style=\"text-align: center;\">\r\n\r\n                        <center class=\"PlayerLoader\">\r\n                             <div class=\"Loadicon\" role=\"button\" tabindex=\"0\" aria-label=\"Loading\"><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"jw-svg-icon jw-svg-icon-buffer\" viewBox=\"0 0 240 240\" focusable=\"false\"><path id=\"PloaderIcon\" d=\"M120,186.667a66.667,66.667,0,0,1,0-133.333V40a80,80,0,1,0,80,80H186.667A66.846,66.846,0,0,1,120,186.667Z\"></path></svg></div> \r\n                             <!-- <img src=\"images/loader_new.gif\"> -->\r\n                        </center> \r\n\r\n                    </div>\r\n                \r\n                      </div>\r\n                    </div>\r\n\r\n                    <!-- EPG -->\r\n        \r\n        <div class=\"col-sm-7\">\r\n          <div class=\"playlist\">\r\n            <div class=\"epgloader hideOnLoad\">\r\n              <center><img src=\"images/roundloader.gif\"><p class=\"text-center\">CARREGANDO EPG</p></center>\r\n            </div>\r\n            <div class=\"liveEPG\">\r\n            </div>\r\n          </div>\r\n        </div>\r\n        <!-- /EPG -->\r\n        \r\n        <div class=\"clearfix\"></div>\r\n        <!-- List of Channels -->\r\n        <div class=\"col-sm-5 hide\">\r\n          <h2 style=\"margin-top: 30px;\">TV/All/By Numbers</h2>\r\n          <div class=\"channel-list\">\r\n            <ul class=\"free-wall\">\r\n              <li id=\"video1\">\r\n                <span class=\"number\">1</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>Mega</label>\r\n              </li>\r\n\r\n              <li id=\"video2\">\r\n                <span class=\"number\">2</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>A1</label>\r\n              </li>\r\n\r\n              <li id=\"video3\">\r\n                <span class=\"number\">3</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>Channel 1</label>\r\n              </li>\r\n\r\n              <li id=\"video4\">\r\n                <span class=\"number\">4</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>Global Channel</label>\r\n              </li>\r\n\r\n              <li>\r\n                <span class=\"number\">5</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>Channel Mega</label>\r\n              </li>\r\n\r\n              <li>\r\n                <span class=\"number\">6</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>Super Stop</label>\r\n              </li>\r\n\r\n              <li>\r\n                <span class=\"number\">7</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>Example Channel</label>\r\n              </li>\r\n\r\n              <li>\r\n                <span class=\"number\">8</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>A1</label>\r\n              </li>\r\n\r\n              <li>\r\n                <span class=\"number\">9</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>Mega Channel</label>\r\n              </li>\r\n\r\n              <li>\r\n                <span class=\"number\">10</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>Custom Channel</label>\r\n              </li>\r\n\r\n              <li>\r\n                <span class=\"number\">11</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>Tune Up</label>\r\n              </li>\r\n\r\n              <li>\r\n                <span class=\"number\">12</span>\r\n                <i class=\"fa fa-television\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-star\" aria-hidden=\"true\"></i>\r\n                <i class=\"fa fa-repeat\" aria-hidden=\"true\"></i>\r\n                <label>One Channel</label>\r\n              </li>\r\n            </ul>\r\n          </div>\r\n        </div>\r\n        <!-- /List of Channels -->\r\n        \r\n\r\n        \r\n                </div>\r\n      ";
    include "includes/footer.php";
}

?>