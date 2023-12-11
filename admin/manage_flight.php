<?php include 'db_connect.php' ?>
<?php 

if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM flight_list where id=".$_GET['id']);
	foreach($qry->fetch_array() as $k => $val){
		$$k = $val;
	}
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<form id="manage-flight">
			<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="" class="control-label">Airline</label>
						<select name="airline" id="airline" class="custom-select browser-default select2">
							<option></option>
							<?php 
							$airline = $conn->query("SELECT * FROM airlines_list order by airlines asc");
							while($row = $airline->fetch_assoc()):
							?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($airline_id) && $airline_id == $row['id'] ? "selected" : '' ?>><?php echo $row['airlines'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group">
						<label for="">Plane No</label>
						<textarea name="plane_no" id="" cols="30" rows="2" class="form-control"><?php echo isset($plane_no) ? $plane_no : '' ?></textarea>
					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<div class="">
						<label for="">Departure Location</label>
						<select name="departure_airport_id" id="departure_location" class="custom-select browser-default select2">
							<option value=""></option>
						<?php
							$airport = $conn->query("SELECT * FROM airport_list order by airport asc");
						while($row = $airport->fetch_assoc()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($departure_airport_id) && $departure_airport_id == $row['id'] ? "selected" : '' ?>><?php echo $row['location'].", ".$row['airport'] ?></option>
						<?php endwhile; ?>
						</select>

					</div>
				</div>
				<div class="col-md-6">
					<div class="">
						<label for="">Arrival Location</label>
						<select name="arrival_airport_id" id="arrival_airport_id" class="custom-select browser-default select2">

							<option value=""></option>

						<?php
							$airport = $conn->query("SELECT * FROM airport_list order by airport asc");
						while($row = $airport->fetch_assoc()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($arrival_airport_id) && $arrival_airport_id == $row['id'] ? "selected" : '' ?>><?php echo $row['location'].", ".$row['airport'] ?></option>
						<?php endwhile; ?>
						</select>

					</div>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<div class="">
						<label for="">Departure Date/Time</label>
						<input type="text" name="departure_datetime" id="departure_datetime" class="form-control datetimepicker" value="<?php echo isset($departure_datetime) ? date("Y-m-d H:i",strtotime($departure_datetime)) : '' ?>">
					</div>
				</div>

				<div class="row form-group">
    <div class="col-md-6">
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="roundtrip" name="roundtrip" <?php echo isset($return_datetime) ? 'checked' : '' ?>>
            <label class="custom-control-label" for="roundtrip">Round-trip</label>
        </div>
    </div>
</div>

				<div class="col-md-6">
					<div class="">
						<label for="">Arrival Date/Time</label>
						<input type="text" name="arrival_datetime" id="arrival_datetime" class="form-control datetimepicker" value="<?php echo isset($arrival_datetime) ? date("Y-m-d H:i",strtotime($arrival_datetime)) : '' ?>">
					</div>
				</div>
			</div>
			<div class="row form-group" id="return_datetime_container" <?php echo isset($return_datetime) ? '' : 'style="display:none;"' ?>>
    <div class="col-md-6">
        <div class="">
            <label for="">Return Date/Time</label>
            <input type="text" name="return_datetime" id="return_datetime" class="form-control datetimepicker" value="<?php echo isset($return_datetime) ? date("Y-m-d H:i",strtotime($return_datetime)) : '' ?>">
        </div>
    </div>
</div>
			<div class="row">
				<div class="col-md-6">
					<div class="">
						<label for="">Seats</label>
						<input name="seats" id="seats" type="number" step="any" class="form-control text-right" value="<?php echo isset($seats_economy) ? $seats_economy : '' ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="">
						<label for="">Price</label>
						<input name="price" id="price" type="number" step="any" class="form-control text-right" value="<?php echo isset($price) ? $price : '' ?>">
					</div>
				</div>
				<div class="col-md-6">
					<div class="">
						<label for="">kilometers</label>
						<input name="kilometers" id="kilometers" type="text" step="any" class="form-control text-right" value="<?php echo isset($kilometers) ? $kilometers : '' ?>">
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script>
    $(document).ready(function(){
        $('.select2').each(function(){
            $(this).select2({
                placeholder: "Please select here",
                width: "100%"
            });
        });

        $('#roundtrip').change(function() {
            if($(this).is(':checked')) {
                $('#return_datetime_container').show();
            } else {
                $('#return_datetime_container').hide();
            }
        });

        $('.datetimepicker').datetimepicker({
            format: 'Y-m-d H:i',
        });

        $('#manage-flight').submit(function(e){
            e.preventDefault();

            // // Basic form validation
            // var airline = $('#airline').val();
            // var planeNo = $('textarea[name="plane_no"]').val();
            // var departureLocation = $('#departure_location').val();
            // var arrivalLocation = $('#arrival_airport_id').val();
            // var departureDateTime = $('#departure_datetime').val();
            // var roundtrip = $('#roundtrip').is(':checked');
            // var arrivalDateTime = $('#arrival_datetime').val();
            // var returnDateTime = $('#return_datetime').val();
    	    // var price = $('#price').val();
			// var kilometers = $('kilometers').val();

            // if (!airline || !planeNo || !departureLocation || !arrivalLocation || !departureDateTime || !price || !kilometers) {
            //     alert('Please fill out all required fields.');
            //     return;
            // }

            start_load();

            $.ajax({
                url: 'ajax.php?action=save_flight',
                method: 'POST',
                data: $(this).serialize(),
                success: function(resp){
                    console.log('Response from server:', resp);
                    if(resp == 1){
                        alert_toast("Flight successfully saved.","success");
                        setTimeout(function(e){
                            location.reload();
                        },1500);
                    }
                }
            });
        });

        $('.datetimepicker').attr('autocomplete','off');
    });
</script>
</script>