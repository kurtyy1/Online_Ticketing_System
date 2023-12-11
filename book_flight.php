<div class="container-fluid">
    <div class="col-lg-12">
        <form action="" id="book-flight" method="POST">
            <input type="hidden" name="flight_id" value="<?php echo $_GET['id'] ?>">
            <div class="form-group row" id="qty">
                <div class="col-md-3">
                    <label for="" class="control-label">Person/s</label>
                    <input type="number" class="form-control text-right" min='0' value="1" id="count" max="<?php echo $_GET['max'] ?>">
                </div>
                <div class="col-md-2">
                    <label for="" class="control-label">&nbsp;</label>
                    <button class="btn btn-primary btn-block" type="button" id="go">Go</button>
                </div>
                <div class="col-md-2">
                    <label for="" class="control-label">&nbsp;</label>
                    <button class="btn btn-secondary btn-block" type="button" data-dismiss="modal">Cancel</button>
                </div>
            </div>
            <div id="row-field" style="display: none">
                <div class="row ">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
// Define PHP variables before the JavaScript block
$from = isset($_GET['from']) ? $_GET['from'] : "";
$to = isset($_GET['to']) ? $_GET['to'] : "";
$departureDate = isset($_GET['departure_date']) ? $_GET['departure_date'] : "";
$returnDate = isset($_GET['return_date']) ? $_GET['return_date'] : "";

?>

<script>

$(document).ready(function() {
    var from = "<?php echo $from; ?>";
    var to = "<?php echo $to; ?>";
    var departureDate = "<?php echo $departureDate; ?>";
    var returnDate = "<?php echo $returnDate; ?>";

    $('#go').click(function() {
        start_load();
        var numberOfPersons = $('#count').val();

        if (numberOfPersons < 1) {
            alert("Please enter a valid number of persons.");
            end_load();
            return false;
        }

        $.ajax({
            url: "get_fields.php?count=" + numberOfPersons,
            success: function(resp) {
                if (resp) {
                    $('#row-field').html(resp);
                    $('#qty').hide();
                    $('#row-field').show();
                    end_load();
                }
            }
        });
    });

    $('#book-flight').submit(function(e) {
        e.preventDefault();

        // Validate each input field before submitting the form
        var isValid = true;
        $('#book-flight input[name^="name"]').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                return false; // exit the loop if any field is empty
            }
        });

        $('#book-flight input[name^="contact"]').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                return false; // exit the loop if any field is empty
            }
        });

        $('#book-flight textarea[name^="address"]').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                return false; // exit the loop if any field is empty
            }
        });

        if (!isValid) {
            alert("Please fill in all fields.");
            return false;
        }

        start_load();
        $.ajax({
            url: 'admin/ajax.php?action=book_flight',
            method: "POST",
            data: $(this).serialize(),
            success: function(resp) {
                if (resp) {
                    // Redirect to ticket.php after successful booking with data
                    var url = 'ticket.php?' +
                        'name=' + encodeURIComponent($('#book-flight input[name="name[]"]').val()) +
                        '&address=' + encodeURIComponent($('#book-flight textarea[name="address[]"]').val()) +
                        '&contact=' + encodeURIComponent($('#book-flight input[name="contact[]"]').val()) +
                        '&from=' + encodeURIComponent(from) +
                        '&to=' + encodeURIComponent(to) +
                        '&departure_date=' + encodeURIComponent(departureDate) +
                        '&return_date=' + encodeURIComponent(returnDate) +
                        '&id=' + encodeURIComponent(resp);

                    window.location.href = url;
                } else {
                    // Handle other cases if needed
                    end_load();
                    alert_toast("Failed to book the flight.", "error");
                }
            }
        });
    });
});
</script>
<style>
    #uni_modal .modal-footer {
        /* display: none */
    }
</style>