<div class="row">

	<!-- Employee Notifications -->
	<div class="col-sm-12 col-md-7 col-lg-7" id="employeeNotification"></div>

</div>


<script type="text/javascript">

	$(document).ready(function(){

		/*Employee Notifications*/
		window.ct.loadPartialView('Dashboard/getEmployeeNotifications/',true, false).then(function(responseData){
			$('#employeeNotification').append(responseData);
		});

	});
</script>