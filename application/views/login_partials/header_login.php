<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title ?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

	<meta name="csrf-token-name" content="<?php echo $this->security->get_csrf_token_name(); ?>">
	<meta name="csrf-token-hash" content="<?php echo $this->security->get_csrf_hash(); ?>">

	<style type="text/css">
		.image-container{
		    background: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg') center no-repeat;
		    background-size: cover;
		    height: 100vh;
		}

		.form-container{
		    background-color: #555555;
		    display: flex;
		    justify-content: center;
		}

		.form-box{
		    display: flex;
		    flex-direction: column;
		    justify-content: center;
		    min-height: 100vh;
		}

		.form-box h4{
		    font-weight: bold;
		    color: #fff;
		}

		.form-box .form-input {
		    position: relative;
		}

		.form-box .form-input input{
		    width: 100%;
		    height: 40px;
		    margin-bottom: 20px;
		    border: none;
		    border-radius: 5px;
		    outline: none;
		    background: white;
		    padding-left: 45px;
		}

		.form-box .form-input span{
		    position: absolute;
		    top: 8px;
		    padding-left: 20px;
		    color: #777;
		}

		.form-box .form-input input::placeholder{
		    padding-left: 0px;
		}

		.form-box .form-input input:focus,
		.form-box .form-input input:valid{
		    border-bottom: 2px solid #dc3545;
		}

		.form-box input[type="checkbox"]:not(:checked) + label:before{
		    background: transparent;
		    border: 2px solid #fff;
		    width: 15px;
		    height: 15px;
		}

		.form-box .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before{
		    background-color: #dc3545;
		    border: 0px;
		}

		.form-box button[type="submit"]{
		    border: none;
		    cursor: pointer;
		    width: 150px;
		    height: 40px;
		    border-radius: 5px;
		    background-color: #fff;
		    color: #000;
		    font-weight: bold;
		    transition: 0.5s;
		}

		.form-box button[type="submit"]:hover{
		    -webkit-box-shadow: 0px 9px 10px -2px rgba(0,0,0,0.55);
		    -moz-box-shadow: 0px 9px 10px -2px rgba(0,0,0,0.55);
		    box-shadow: 0px 9px 10px -2px rgba(0,0,0,0.55);
		}

		.forget-link, .register-link, .login-link{
		    color: #fff;
		    font-weight: bold;
		}

		.forget-link:hover, .register-link:hover, .login-link:hover{
		    color: #292525;
		}

		.form-box .btn-social{
		    color: #fff;
		    border: 0;
		    margin-bottom: 10px;
		}

		.form-box .btn-facebook{
		    background: #4866a8;
		}

		.form-box .btn-google{
		    background: #da3f34
		}

		.form-box .btn-twitter{
		    background: #33ccff;
		}

		.form-box .btn-facebook:hover{
		    color: #fff;
		    background: #3d5785;
		}

		.form-box .btn-google:hover{
		    background: #bf3b31;
		    color: #fff;
		}

		.form-box .btn-twitter:hover{
		    background: #2eb7e5;
		    color: #fff;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			