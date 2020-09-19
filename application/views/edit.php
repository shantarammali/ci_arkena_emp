<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Employee</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Employee Edit Form</h2>
  <div class="row">
     <?php 
         if ($this->session->flashdata('error')) {
                  ?>
                  <div class="alert alert-danger">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                      <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
                  </div>
                  <?php
                  $this->session->unset_userdata('error');
                  $this->session->unset_userdata('success');
                 } ?>

              <?php       
               if ($this->session->flashdata('success')) {
                ?>
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php
                $this->session->unset_userdata('error');
                $this->session->unset_userdata('success');
                }

            ?>
    <div class="col-sm-offset-2 col-sm-6">
  <?php echo form_open_multipart('home/edit/'.$employee->id, ['id' => 'employee_form']); ?>
    <div class="form-group">
      <label for="name">Name:</label>
      <?php echo form_input('name',($employee->name)?$employee->name:set_value('name'),'class="form-control" placeholder="Enter Name"' );?>
      <?php echo form_error('name','<div class="error" style="color:red">','</div>');?>
    </div>

     <div class="form-group">
      <label for="address">Address:</label>
      <?php 
      $options = array(
    'name' => 'address',
    'rows' => '4',
    'cols' => '5',
    'class'=>'form-control',
    'value'=>($employee->address)?$employee->address:set_value('address')
    
);
      echo form_textarea($options);?>
      <?php echo form_error('address','<div class="error" style="color:red">','</div>');?>
      
    </div>

     <div class="form-group">
      <label for="email">Email:</label>
      <?php echo form_input('email',($employee->email)?$employee->email:set_value('email'),'class="form-control" placeholder="Enter Employee Email"');?>
      <?php //echo form_input('email',($reset)?"":set_value('email'),'class="form-control" placeholder="Enter Email"' );?>
      <?php echo form_error('email','<div class="error" style="color:red">','</div>');?>
      
    </div>

     <div class="form-group">
      <label for="phone">Phone:</label>
      <?php echo form_input('phone',($employee->phone)?$employee->phone:set_value('phone'),'class="form-control" placeholder="Enter Phone"' );?>
      <?php echo form_error('phone','<div class="error" style="color:red">','</div>');?>
      
    </div>

     <div class="form-group">
      <label for="dob">DOB:</label>
     <?php  echo form_input(['name'=>'dob','value'=>($employee->dob)?$employee->dob:set_value('dob'),'type'=>'date','class'=>'form-control','placeholder'=>'Enter DOB']); ?>
      
      
    </div>
    <div class="form-group">
          <?php if($employee->image!=''){ ?>
          <img src="<?php echo base_url('images/'.$employee->image); ?>" height=100 width=100>
          <?php echo form_input('old_image', $employee->image,'class="hidden"');?>
          <?php } ?>
          <?php echo form_label('Upload Image','',['class'=>"col-sm-3 control-label"]); ?>
          <?php echo form_input(['class'=>'form-control','type'=>'file','name'=>'image']) ;?>
                     
    </div>    


    <?php echo form_submit('Add','submit','class="btn btn-primary"'); ?>
    <?php echo anchor(base_url().'home','Listing','class="btn btn-info pull-right"'); ?>
  <?php echo form_close();?>
</div>
</div>
</div>

</body>
</html>
