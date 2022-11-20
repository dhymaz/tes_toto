<div class='container'>
	<button class="btn btn-success mb-3" data-toggle="modal" data-target="#modal_add">Tambah data</button>
   <div class='row d-flex justify-content-center '>    
		
        <table class="table table-responseive table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Location</th>
                    <th>Color</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
				<?php
				$no = 1;
				if($barang->num_rows() > 0){
				foreach($barang->result() as $val){
				?>
                <tr>
                    <td><?=$no?></td>
                    <td><?=$val->item_name?></td>
                    <td><?=$val->qty?></td>
                    <td><?=$val->location?></td>
                    <td><?=$val->color?></td>
                    <td>
                        <a onclick="return confirm('Apakah anda yakin akan menghapus data ini?')" href="<?=base_url('home/delete/'.$val->id)?>">
                            <button type="button" class="btn btn-danger">Hapus</button>
                        </a>
						<button class="btn btn-info" data-toggle="modal" data-target="#modal_edit_<?=$val->id?>">Edit</button>
                    </td>
                </tr>
				
				<div class="modal" tabindex="-1" id="modal_edit_<?=$val->id?>" role="dialog">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<?=form_open(base_url('home/edit/'.$val->id),'method="post"')?>
						<div class="modal-body">
							<div class='container mt-3'>
									<?php
									if(!empty($this->session->userdata('messege'))){
										echo "<script>alert('".$this->session->userdata('messege')."')</script>";
									}
									?>
									<div class="form-group">
										<label for="exampleInputEmail1">Item Name</label>
										<input type="text" value="<?=$val->item_name?>" class="form-control" id="exampleInputEmail1" name="item_name" aria-describedby="emailHelp" />
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">Qty</label>
										<input type="number" value="<?=$val->qty?>" class="form-control" name="qty" id="exampleInputPassword1" />
									</div>
									<div class="form-group">
										<label for="exampleInputPassword2">Location</label>
										<select class="form-control" name="location" id="location">
											<option value="">--Select Location-</option>
											<option value="Gudang A" <?=$val->location == 'Gudang A'?'selected':'';?>>Gudang A</option>
											<option value="Gudang B" <?=$val->location == 'Gudang B'?'selected':'';?>>Gudang B</option>
										</select>
									</div>
									<div class="form-group">
										<label for="exampleInputPassword1">Color</label>
										<input type="color" value="<?=$val->color?>" class="form-control" name="color" id="exampleInputPassword1"/>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit"  class="btn btn-primary">Save changes</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
							</form>
						</div>
					</div>
				</div>
				
				<?php 
					$no++;
					}
				}else{ 
				?>
				<tr>
					<td colspan="6" class="text-center bg-default">data tidak ditemukan</td>
				</tr>
				<?php } ?>
            </tbody>
        </table>

		<div class="modal" tabindex="-1" id="modal_add" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?=form_open(base_url('home/add'),'method="post"')?>
				<div class="modal-body">
					<div class='container mt-3'>
							<?php
							if(!empty($this->session->userdata('messege'))){
								echo "<script>alert('".$this->session->userdata('messege')."')</script>";
							}
							?>
							<div class="form-group">
								<label for="exampleInputEmail1">Item Name</label>
								<input type="text" class="form-control" id="exampleInputEmail1" name="item_name" aria-describedby="emailHelp" />
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Qty</label>
								<input type="number" class="form-control" name="qty" id="exampleInputPassword1" />
							</div>
							<div class="form-group">
								<label for="exampleInputPassword2">Location</label>
								<select class="form-control" name="location" id="location">
									<option value="">--Select Location-</option>
									<option value="Gudang A">Gudang A</option>
									<option value="Gudang B">Gudang B</option>
								</select>
							</div>
							<div class="form-group">
								<label for="exampleInputPassword1">Color</label>
								<input type="color" class="form-control" name="color" id="exampleInputPassword1"/>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit"  class="btn btn-primary">Save changes</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
					</form>
				</div>
			</div>
		</div>
    </div>
</div>
