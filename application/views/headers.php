<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow p-3 mb-5 bg-white rounded">
  <a class="navbar-brand" href="#">
      <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f5/TOTO_logo.svg/2560px-TOTO_logo.svg.png" style="width:100px" alt="">
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="d-flex flex-row-reverse bd-highlight collapse navbar-collapse" id="navbarSupportedContent">
    
    <div class="row">
				<?php
				if(empty($this->session->userdata('username'))){
				?>
        <a href="<?=base_url('/')?>">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Sign in</button>
        </a>
				<a href="<?=base_url('welcome/registrasi_form')?>">
					<button class="btn btn-outline-primary my-2 my-sm-0 ml-2 mr-3" type="submit">Sign up</button>
				</a>
				<?php }else{ ?>
					<a href="<?=base_url('welcome/logout')?>">
						<button class="btn btn-outline-danger my-2 my-sm-0 ml-2 mr-3" type="submit">Logout</button>
					</a>
				<?php } ?>
			</div>
  </div>
</nav>
