<!-- /* Projects main page - project list*/ -->
<?php $this->load->view('backend/header'); ?>
<?php $this->load->view('backend/sidebar'); ?>
      <div class="page-wrapper">
            <div class="message"></div>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><i class="fa fa-university" aria-hidden="true"></i> Projects</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Projects</li>
                    </ol>
                </div>
            </div>
            <?php
/*            $startDate = strtotime('2015-06-21');
            $endDate = strtotime('2015-08-01');
            for($i = $startDate; $i <= $endDate; $i = strtotime('+1 day', $i))
                        echo date('Y-m-d',$i);*/
/*                if($result == "Friday"){  
                   echo date("Y-m-d", strtotime($i)). " ".$result."<br>";
                } */
           ?>
            <div class="container-fluid">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <?php if($this->session->userdata('user_type')=='EMPLOYEE'){ ?>
                        
                        <?php } else { ?>
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Project </a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Projects/All_Tasks" class="text-white"><i class="" aria-hidden="true"></i>  Task List</a></button>
                        <button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><a href="<?php echo base_url(); ?>Projects/Field_visit" class="text-white"><i class="" aria-hidden="true"></i>  Field Visit</a></button>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Client Project List                        
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Project Title</th>
                                                <th>Client Name </th>
                                                <th>Contact Number </th>
                                                <th>Status </th>
                                                <th>Start Date </th>
                                                <th>End Date </th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Project Title</th>
                                                <th>Client Name </th>
                                                <th>Contact Number </th>
                                                <th>Status </th>
                                                <th>Start Date </th>
                                                <th>End Date </th>
                                                <th>Action </th>
                                            </tr>
                                        </tfoot>
                                        <!-- Script updated 10/15/2024 -->
                                        <tbody>
                                        <?php foreach($projects as $value): ?>
                                        <tr>
                                            <td><?php echo $value->pro_name ? substr($value->pro_name, 0, 50) . '....' : ''; ?></td>
                                            <td><?php echo $value->client_name; ?></td>
                                            <td><?php echo $value->contact_no; ?></td>
                                            <td><?php echo $value->pro_status; ?></td>
                                            <td><?php echo $value->pro_start_date ? date('jS \of F Y', strtotime($value->pro_start_date)) : ''; ?></td>
                                            <td><?php echo $value->pro_end_date ? date('jS \of F Y', strtotime($value->pro_end_date)) : ''; ?></td>
                                            <td class="jsgrid-align-center">
                                                <a href="view?P=<?php echo $value->id ? base64_encode($value->id) : ''; ?>" title="Edit" class="btn btn-sm btn-info waves-effect waves-light"><i class="fa fa-pencil-square-o"></i></a>
                                                <a href="javascript:void(0);" title="Delete" onclick="confirmDelete('<?php echo $value->id ? base64_encode($value->id) : ''; ?>')" class="btn btn-sm btn-info waves-effect waves-light projectdelet"><i class="fa fa-trash-o"></i></a>

                                            <script>
                                            function confirmDelete(proid) {
                                                var password = prompt("Please enter your password to delete this project:");
                                                if (password != null && password != "") {
                                                    window.location.href = "pDelet?D=" + proid + "&password=" + encodeURIComponent(password);
                                                }
                                            }
                                            </script>

                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <!-- sample modal content -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel1"><i class="fa fa-braille"></i> Add Project</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form method="post" action="Add_Projects" id="btnSubmit" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                           <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Project Title</label>
                                                <input type="text" name="protitle" class="form-control" id="recipient-name1" minlength="8" maxlength="250" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Status</label>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="prostatus" required>
                                                    <option value="upcoming">Upcoming</option>
                                                    <option value="complete">Complete</option>
                                                    <option value="ongoing">Ongoing</option>
                                                </select>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Project Start Date</label>
                                                <input type="date" name="startdate" class="form-control datepicker" id="recipient-name1" placeholder="">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Project End Date</label>
                                                <input type="date" name="enddate" class="form-control datepicker" id="recipient-name1" required placeholder="">
                                            </div>
                                            </div>                                            
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h1 class="m-b-0 text-themecolor text-center" style="margin-bottom: 40px;">Client Information Sheet</h1>
                                                </div>
                                                <div class="col-md-12">
                                                    <h3 class="m-b-0 text-themecolor text-left" style="margin-bottom: 20px;">PERSONAL INFORMATION</h3>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Full Name</label>
                                                        <input type="text" name="clientname" class="form-control" id="recipient-name1" placeholder="Client Full Name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Birthday</label>
                                                        <input type="date" name="dob" class="form-control" id="recipient-name1" placeholder="Date of birth">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Age</label>
                                                        <input type="number" name="age" class="form-control" id="recipient-name1" placeholder="Enter Digit">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Gender</label>
                                                        <select class="form-control custom-select" id="recipient-name1" name="gender">
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Religion</label>
                                                        <select class="form-control custom-select" name="religion" id="recipient-name1">
                                                            <option value="Roman Catholic">Roman Catholic</option>
                                                            <option value="Born Again Christian">Born Again Christian</option>
                                                            <option value="Muslim">Muslim</option>
                                                            <option value="INC">INC</option>
                                                            <option value="Mormons">Mormons</option>
                                                            <option value="Seventh day adventist">Seventh day adventist</option>
                                                            <option value="Jehove witneses">Jehova's witneses</option>
                                                            <option value="Protestant">Protestant</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Marital Status</label>
                                                        <select class="form-control custom-select" name="maritalstatus">
                                                            <option value="single">Single</option>
                                                            <option value="married">Married</option>
                                                            <option value="divorced">Divorced</option>
                                                            <option value="widowed">Widowed</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Nationality</label>
                                                        <select class="form-control custom-select" name="nationality" id="recipient-name1">
                                                            <option value="Filipino">Filipino</option>
                                                            <option value="American">American</option>
                                                            <option value="Chinese">Chinese</option>
                                                            <option value="Japanese">Japanese</option>
                                                            <option value="Korean">Korean</option>
                                                            <option value="Indian">Indian</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Occupation</label>
                                                        <input type="text" name="occupation" class="form-control" id="recipient-name1" placeholder="Job/Position">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <h3 class="m-b-0 text-themecolor text-center" style="margin-bottom: 20px;">ADDRESS AND CONTACT INFORMATION</h3>
                                                </div>
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Baranggay/Street</label>
                                                    <input type="text" name="brgy" class="form-control" id="recipient-name1" placeholder="input details">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">City/Municipality</label>
                                                    <input type="text" name="mun" class="form-control" id="recipient-name1" placeholder="input details">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Province/Region</label>
                                                    <input type="text" name="prov" class="form-control" id="recipient-name1" placeholder="input details">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Postal Code</label>
                                                    <input type="text" name="zip" class="form-control" id="recipient-name1" placeholder="input details">
                                                </div>
                                                </div>
                                                <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Contact Number</label>
                                                            <input type="text" name="contactno" class="form-control" id="recipient-name1" placeholder="Contact Number">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Email</label>
                                                            <input type="email" name="clientemail" class="form-control" id="recipient-name1" placeholder="Email">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Emergency Contact Person</label>
                                                            <input type="text" name="emergencycontactperson" class="form-control" id="recipient-name1" placeholder="Emergency Contact Person">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Emergency Contact Number</label>
                                                            <input type="text" name="emergencycontactnumber" class="form-control" id="recipient-name1" placeholder="Emergency Contact Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                        <!-- /.modal -->    
<?php $this->load->view('backend/footer'); ?>