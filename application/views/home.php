<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<body>

<h2>Employee Table</h2>


<div class="container">
	<p><?php echo anchor('home/add','Add Employee','class="btn btn-info pull-right"');?></p>
			
            <br>
             <div class="row">
             	<div class="col-sm-10">
             	<?php echo form_open('home');?>
             	<?php echo form_input('search_employee_name',($reset)?'':set_value('search_employee_name'),'class="form-control" placeholder="Enter Employee Name"');?>
             	<?php echo form_error('search_employee_name','<div class="error" style="color:red">','</div>');?> <br>
             	<?php echo form_submit('filter','Search','class="btn btn-primary"'); ?>

             	<?php echo form_close(); ?>
             	
               </div>


           </div>
              <hr>
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
		<div class="row">
			<div class="col-sm-10">
		<table>
		  <tr>
		    <th>Id</th>
		    <th>Name</th>
		    <th>Address</th>
		    <th>Email</th>
		    <th>Phone</th>
		    <th>Image</th>
		    <th>Operation</th>
		  </tr>
		  <?php  if(empty($employees)) {
		                         echo "<tr style='background-color:white'><td style='border: 1px white'>No data Found</td></tr>";
		                       }
		      else { 
		     	foreach($employees as $employee) { ?>
		  <tr>
		    <td><?php echo $employee->id ; ?></td>
		   <td><?php echo $employee->name ; ?></td>
		    <td><?php echo $employee->address ; ?></td>
		    <td><?php echo $employee->email ; ?></td>
		      <td><?php echo $employee->phone ; ?></td>
		    <td><img src="<?php echo base_url('images/'.$employee->image); ?>" alt="" width=50 height=50></td>
		  
		    <td>
		    	<?php echo anchor(base_url().'home/edit/'.$employee->id,'Edit','class="btn btn-info"'); ?>
		    	<?php echo anchor(base_url('home/delete/'.$employee->id),'Delete',['class'=>'btn btn-info',   'onclick'=>"return confirm('Are you sure want activate this record')"]); ?>
		    	
		    </td>
		  </tr>
		  <?php 
			}
		}
		  ?>
		  
		</table>
		<p class="pull-right"><?php echo $links; ?></p>
		</div>
		</div>
</div>

</body>
</html>
