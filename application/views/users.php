<?php require(APPPATH . 'views/partials/header.php'); ?>

<div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Manage <b>Users</b></h2>
                    </div>
                    <div class="col-sm-6">
                        <a href="#addUserModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
                        <a href="#deleteUserModal" class="btn btn-danger delete_selected" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>                        
                    </div>
                </div>
            </div>
			<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
            </table>
           
        </div>
    </div>   
<?php require(APPPATH . 'views/partials/footer.php'); ?>