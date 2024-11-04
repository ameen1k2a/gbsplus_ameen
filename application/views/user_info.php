<?php require(APPPATH . 'views/partials/header.php'); ?>
<br>
<div class="table-wrapper">
    <div class="table-title">
        <div class="row">
            <div class="col-sm-6">
                <h2>User <b>Information</b></h2>
            </div>
        </div>
    </div>

    <!-- User Info Section -->
    <?php if (!empty($user)) : ?>
        <div class="user-info">
            <ul class="list-group list-group-dark">
                <li class="list-group-item list-group-item-dark"><strong>Name:</strong> <?php echo $user->name; ?></li>
                <li class="list-group-item list-group-item-dark"><strong>Email:</strong> <?php echo $user->email; ?></li>
                <li class="list-group-item list-group-item-dark"><strong>Phone:</strong> <?php echo $user->phone; ?></li>
                <li class="list-group-item list-group-item-dark"><strong>Address:</strong> <?php echo $user->address; ?></li>
            </ul>
        </div>
    <?php else : ?>
        <p class="text-danger">No user information found.</p>
    <?php endif; ?>
</div>

<?php require(APPPATH . 'views/partials/footer.php'); ?>
