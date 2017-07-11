<div class="container">
    <div id="profile-page" class="section">
        <!-- profile-page-content -->
        <div id="profile-page-content" class="row">

            <!-- profile-page-wall -->
            <div id="profile-page-wall" class="col s12 m12 l8">
                <!-- profile-page-wall-share -->
                <div id="profile-page-wall-share" class="row">
                    <div class="col s12">
                        <ul class="tabs tab-profile z-depth-1 light-blue">
                            <li class="tab col s3">
                                <a class="white-text waves-effect waves-light" href="#" onClick="showProfile('personal')">
                                    Personal
                                </a>
                            </li>
                            <li class="tab col s3">
                                <a class="white-text waves-effect waves-light" href="#" onClick="showProfile('apparel')">
                                    Apparel
                                </a>
                            </li>
                            <li class="tab col s3">
                                <a class="white-text waves-effect waves-light" href="#" onClick="showProfile('health')">
                                    Health
                                </a>
                            </li>
                            <li class="tab col s3">
                                <a class="white-text waves-effect waves-light" href="#" onClick="showProfile('pb')">
                                    PB
                                </a>
                            </li>               
                        </ul>
                    </div>
                </div>
                <!--/ profile-page-wall-share -->

                <!-- profile-page-wall-posts -->
                <div id="profile-page-wall-posts"class="row">
                    <div class="col s12">
                        <!-- medium -->
                        <div id="profile-page-wall-post" class="">
                            <div class="" id="profileAjax">
                                <?php echo $formProfile ?>
                            </div>                                            
                        </div>
                    </div>                  
                </div>
                <!--/ profile-page-wall-posts -->

            </div>
            <!--/ profile-page-wall -->

        </div>
    </div>
</div>