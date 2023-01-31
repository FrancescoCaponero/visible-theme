 <!-- ===============================================   POLICY COOKIE  ============================================ -->
                <!-- ============================================================================================================= -->
                <?php if(!isset($_COOKIE['151_cookie_accepted_'])) { ?>
                <?php// if(1) { ?>
                    <div class="cookie-policy" >
                        <style>
                        .cookie-policy {
                            min-height: 40px;
                            background: #f3f3f3;
                            position: fixed;
                            width: 100%;
                            z-index: 1001;
                            top: 0px;
                            -webkit-transition:  height 0.2s ease-out;
                            -moz-transition: cheight 0.2s ease-out;
                            -o-transition: height 0.2s ease-out;
                            transition: height 0.2s ease-out;
                        }
                        .banner-top {
                            -webkit-transition:  margin-top 0.2s ease-out;
                            -moz-transition: margin-top 0.2s ease-out;
                            -o-transition: margin-top 0.2s ease-out;
                            transition: margin-top 0.2s ease-out;
                        }
                        .cookie-policy .container {padding-bottom: 3px;}
                        .cookie-policy p {color: #333335;font-size: 13px;padding: 10px 0px ;line-height: 18px;}
                        .cookie-policy p a {color: #FFF;font-size: 12px;cursor: pointer;font-weight: 400;}
                         .cookie-policy p a:hover {color: #FFF;}
                        .cookie-policy .btn-link{  padding: 5px 10px;margin: 0px 0px 10px 10px;}
                        </style>
                        <script type="text/javascript">
                           $(function() {
                                $('.banner-top').css('margin-top',$('.cookie-policy').height());
                                $( window ).resize(function() {
                                   $('.banner-top').css('margin-top',$('.cookie-policy').height());
                                });
                                $('#cookie-accepted').click(function(event) {

                                    var today = new Date();
                                    var expire = new Date();
                                    var nDays = 30;
                                    if (nDays==null || nDays==0) nDays=1;
                                    expire.setTime(today.getTime() + 3600000*24*nDays);
                                    document.cookie = '151_cookie_accepted_'+"="+escape('OK')
                                                 + ";expires="+expire.toGMTString();

                                    /*$('.cookie-policy').css('height','0px');
                                    $('.banner-top').css('margin-top','0px');*/
                                    $('.cookie-policy').fadeOut(200);
                                    $('.banner-top').css('margin-top','0px');
                                });
                            });
                        </script>
                        <div class="container" style="text-align:left;color:#ed1941;position:relative;width: 90%;margin: 0 auto" >
                            <?php if(qtrans_getLanguage() == 'it'){ ?>

                                <p style="text-align: center;">Questo sito è impostato per consentire l’utilizzo di tutti i cookie al fine di garantire una migliore navigazione.<br>Se accedi a un qualunque elemento sottostante questo banner acconsenti all’uso dei cookie.</p>
                                <p style="text-align: center;"> <a  class="btn-link" id="cookie-accepted">Ok</a><a href="http://151miglia.it/privacy-policy-2/" class="btn-link" >Visualizza l'informativa completa</a></p>

                            <?php }elseif (qtrans_getLanguage() == 'en') { ?>

                                <p style="text-align: center;">This site is set to allow the use of all cookies in order to ensure a better navigation.<br> If you access to any element below this banner you consent to the use of cookies.</p>
                                <p style="text-align: center;"> <a  class="btn-link" id="cookie-accepted">OK</a><a href="http://151miglia.it/privacy-policy-2/" class="btn-link" >View the full information</a></p>

                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
                <!-- ============================================================================================================= -->
                <!-- ============================================================================================================= -->