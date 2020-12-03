<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Instrumen Self Assessment Risiko Covid-19">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="assets/images/favicon_1.ico">

        <title><?php echo $this->config->item('titleheader'); ?> </title>

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>
        
    </head>
    <body background="">

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
            <div class="panel-heading"> 
            	<center><?php echo $this->session->flashdata('message'); ?></center>
                <!-- h3 class="text-center"> Sign In to <strong class="text-custom"><?php echo $this->config->item('titleheader'); ?></strong> </h3> -->
                <center><img src="assets/images/logo-login.png"></center>
            </div> 


            <div class="panel-body">
            <form class="form-horizontal m-t-20" action="login" method="post">
                
                <div class="form-group ">
                    <div class="col-xs-12">
                        <input class="form-control" name="username" id="username" type="text" required="" placeholder="User Scan" value="<?php echo set_value('username'); ?>">    
                        <?php echo form_error('username','<small class="text-danger pl-3">','</small>') ?>                 
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input class="form-control" type="password" name="password" id="password" required="" placeholder="Password Scan" autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <select class="form-control" id="gedung" name="gedung">
                            <option value="0" selected>- Pilih Lokasi -</option>
                            <?php                                                               
                               foreach ($list_lokasi_header as $variant) { 
                                  echo "<option value='".$variant->id_gedung."'>".$variant->nama_gedung."</option>";
                               } 
                            ?>                                                 
                        </select>
                    </div>
                </div>
                

                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                        	<!--
                            <input id="checkbox-signup" type="checkbox">
                            <label for="checkbox-signup">
                                Remember me
                            </label>
                        -->
                        </div>
                        
                    </div>
                </div>
                
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <!-- <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button> -->
                        <button class="btn btn-block text-uppercase waves-effect waves-light" type="submit" style="background-color: orange; color: white">Log In</button>
                    </div>
                </div>

                <!--
                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="page-recoverpw.html" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                    </div>
                </div>
           		 -->
            </form> 
            
            </div>   
            </div>  
            	<!--
                <div class="row">
            	<div class="col-sm-12 text-center">
            		<p>Don't have an account? <a href="page-register.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                        
                </div>
            	</div>
            	-->
        	</div>
        
        

        
    	<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>


        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
	
	</body>
</html>