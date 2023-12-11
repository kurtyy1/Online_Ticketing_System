
<?php include 'db_connect.php'; ?>

<style>
   
</style>

<div class="container-fluid">

	<div class="row">
		<div class="col-lg-12">
			
		</div>
	</div>

	<div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
				<?php echo "Welcome back ".($_SESSION['login_type'] == 3 ? "Dr. ".$_SESSION['login_name'].','.$_SESSION['login_name_pref'] : $_SESSION['login_name'])."!" ?>
									
				</div>
				<hr>
				<div class="row">
				<div class="container-fluid">
    <!-- Monitoring section -->
    <div class="col-lg-12 mb-3">
        <div class="card monitoring-card">
            <div class="card-body">
                <h5 class="card-title monitoring-title">Booked Today</h5>
                <?php
              $query = "SELECT COUNT(*) as total FROM booked_flight";
              $result = mysqli_query($conn, $query);

              if ($result) {
                $row = mysqli_fetch_assoc($result);
                $total_booked = $row['total'];
              } else {
                echo "Error executing the query: " . mysqli_error($conn);
              }   
				
                ?>
                <p class="card-text monitoring-info">Total Bookings Today: <strong><?php echo $total_booked; ?></strong></p>
            </div>
        </div>
    </div>
				</div>
			</div>
			
		</div>
		</div>
	</div>

</div>



<script>
	
</script>