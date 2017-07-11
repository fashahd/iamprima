<div class="container">
    <div id="profile-page" class="section">
        <!-- profile-page-content -->
        <div id="profile-page-content" class="row">
            <!-- profile-page-sidebar-->
            <div id="profile-page-sidebar" class="col s12 m12 l4">
                <!-- Profile About  -->
                <div class="card light-blue">
                    <figure class="card-profile-image">
                        <div id="imgContainer">
                            <form enctype="multipart/form-data" action="user/uploadProfile" method="post" name="image_upload_form" id="image_upload_form">
                                <div id="imgArea" class="card-avatar">
                                    <img src="<?php echo $gambar?>" alt="profile image" class="circle z-depth-2 responsive-img activator">
                                    <div class="progressBar">
                                        <div class="bar"></div>
                                        <div class="percent">0%</div>
                                    </div>
                                    <div id="imgChange">
                                        <input type="file" accept="image/*" name="image_upload_file" id="image_upload_file">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </figure>
                    <div class="card-content white-text">
                        <span class="card-title"><?php echo $name ?></span>
                        <p><?php echo $role_name ?></p>
                    </div>                  
                </div>
                <!-- Profile About  -->

            </div>
            <!-- profile-page-sidebar-->

            <!-- profile-page-wall -->
            <form id="formNewPassword">
                <div class="col s12 m12 l6">
                    <div class="card">
                        <div class="col s12">
                            <div class="card-content">
                                <h4 class="header">Change Password</h4>
                                <div class="input-field col s12">
                                    <input id="oldPassword" type="password" class="validate" required>
                                    <label for="oldPassword">Password Lama</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="newPassword" type="password" class="validate" required>
                                    <label for="newPassword">Password Baru</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="reNewPassword" type="password" class="validate" required>
                                    <label for="reNewPassword">Verifikasi Password Baru</label>
                                </div>
                                <button class="btn cyan" type="submit">Ganti Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!--/ profile-page-wall -->

        </div>
    </div>
</div>