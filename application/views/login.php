<div class='container'>
    <div class="">
        <div class='row d-flex justify-content-center '>    
            <div class='row mt-3'>
				<?=form_open(base_url('welcome/login'),'method="post"')?>
				<?php
				if(!empty($this->session->userdata('messege'))){
					echo "<script>alert('Data tidak ditemukan')</script>";
				}
				?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="email" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"/>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password"/>
                </div>
                <button type="submit" class="mt-3 btn btn-primary">Submit</button>
            </form>
            </div>
            </div>
        </div>
    </div>
</div>
