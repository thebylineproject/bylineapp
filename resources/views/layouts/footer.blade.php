
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!--<link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">-->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css"/>
<script type="text/javascript" src="//cdn.datatables.net/v/dt/dt-1.10.22/datatables.min.js"></script>

<style>
	.dropdown-menu-right {
		position: absolute !important;
		padding-top: 0px !important;
		padding-bottom: 5px !important;
	}
	 .canvasjs-chart-credit {
		display: none;
	}
	#chartContainer{
		height: 300px;
		width: 25%;
		float: right;
	}
	.col-md-4.col-form-label {
		padding-left: 0px;
		padding-left: 0px;
		padding-top: 0px;
		padding-bottom: 0px;
	}     
	label span {
		color: red;
	}
	body{
	  background-color: #f1f1f1;
	} 
	.nav-pills .nav-link.active, .nav-pills .show > .nav-link{
	  background-color: #17A2B8;
	}
	#navbarDropdownnoti{
		position: relative;
		top: 2px;
	}
	.dropdown-menu{
	  top: 52px;
	  right: -6px;
	  left: unset;
	  width: 400px;
	  box-shadow: 0px 5px 7px -1px #c1c1c1;
	  padding-bottom: 0px;
	  padding: 0px;
	}
	.dropdown-menu:before{
	  content: "";
	  position: absolute;
	  top: -20px;
	  right: 12px;
	  border:10px solid #343A40;
	  border-color: transparent transparent #343A40 transparent;
	}
	.notifi{
		position:absolute !important;
	}
	.head{
	  padding:5px 15px;
	  border-radius: 3px 3px 0px 0px;
	}
	.footer{
	  padding:5px 15px;
	  border-radius: 0px 0px 3px 3px; 
	}
	.notification-box{
	  padding: 10px 0px; 
	}
	.bg-gray{
	  background-color: #eee;
	}
	.ml-auto > li{
		display:inline-block;	
	}
	#logout_drp{
		width: 200px;
		margin-top: 7px;
		right: 0px;
	}
	.noti_counter{
		position: absolute;
		color: white;
		background: red;
		border-radius: 47%;
		top: 0px;
		padding: 1px;
		font-size: 10px;
		right: 2px;
		min-width: 13px;
		height: 13px;
		text-align: center;
		font-weight: bold;
	}
	@media (max-width: 640px) {
		.dropdown-menu{
		  top: 50px;
		  left: -16px;  
		  width: 290px;
		} 
		.nav{
		  display: block;
		}
		.nav .nav-item,.nav .nav-item a{
		  padding-left: 0px;
		}
		.message{
		  font-size: 13px;
		}
	}
	@media(max-width:414px){
		.mobile-nav-icon{
			float: left;
			width: 32px;
			padding-left: 0px;
			padding-right: 0px;
			margin-top: 11px;
		}
		.mobile-nav-icon span.nav_icon{
			width: 30px;
height: 4px;
margin-bottom: 7px;
display: block;
background-color: #fff;
		}
		.mobile-nav-logo{
			float: left;
width: 210px;
		}
		.mobile-nav-logo a{
			margin-right:0px;
		}
		.mobile-nav-settings{
			float: right;
width: 59px;
padding-right: 0px;
padding-left: 0px;
		}
		.mobile-nav-settings #navbarDropdownnoti{
			top: -4px
		}
		.author_name, .mobile-login-link{
			display:none !important;
		}
	}
</style>
<center>
 <div class="footer_logo">
	<img src="{{ asset('imgs') }}/{{ config('app.app_footer_logo') }}" title="{{ config('app.app_email_title') }}">
</div>
</center>
	<script>
        function openNav() {
            $("#mySidenav").toggle();
        }
    </script>
	<script src="//cdn.tiny.cloud/1/cur38c577ohpv15d5ho0wx9sb0sfubcjo19yk61xojn915mf/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
		tinymce.init({
			/*selector: 'textarea.create_submission',
			height: 100,
			plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
			toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
			toolbar_mode: 'floating',
			tinycomments_mode: 'embedded',
			tinycomments_author: 'Author name',*/
		});
	</script>
	<script type="text/javascript">
        tinymce.init({
            selector: 'textarea.create_submission',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'//tinymcespellchecker a11ychecker linkchecker
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | a11ycheck | help',
            //content_css: '//www.tiny.cloud/css/codepen.min.css'
        });
		/*tinymce.init({
			selector: 'textarea.create_submission',  // change this value according to your HTML
			plugin: 'a_tinymce_plugin',
			a_plugin_option: true,
			a_configuration_option: 400
		});*/
    </script>
    <script src="{{ asset('js/submission.js')}}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $( function() {
           $('.datepicker').datepicker({ dateFormat: "yy-mm-dd" });
        });
    </script>
    <script type="text/javascript">
		$(document).ready(function () {
			$('#amount').keyup(function () {
				var regex = new RegExp(/[^0-9.]/g);
				var containsNonNumeric = this.value.match(regex);
				if (containsNonNumeric) {
					this.value = this.value.replace(regex, '');
				}
				$('#amount').val(number_format(this.value));
			});
			$('#amount').keypress(function () {
				var regex = new RegExp(/[^0-9.]/g);
				var containsNonNumeric = this.value.match(regex);
				if (containsNonNumeric) {
					this.value = this.value.replace(regex, '');
				}
				$('#amount').val(number_format(this.value));
			});
			$('#fundraising_goal').keyup(function () {
				var regex = new RegExp(/[^0-9.]/g);
				var containsNonNumeric = this.value.match(regex);
				if (containsNonNumeric) {
					this.value = this.value.replace(regex, '');
				}
				$('#fundraising_goal').val(number_format(this.value));
			});
			$('#fundraising_goal').keypress(function () {
				var regex = new RegExp(/[^0-9.]/g);
				var containsNonNumeric = this.value.match(regex);
				if (containsNonNumeric) {
					this.value = this.value.replace(regex, '');
				}
				$('#fundraising_goal').val(number_format(this.value));
			});
			
			/*Password Validation*/
            $('#password, #password_confirm').on('keyup', function () {
				var lCaseAlphabetic = /^(?=.*[a-z])/;
				var uCaseAlphabetic = /^(?=.*[A-Z])/;
				var nCaseAlphabetic = /^(?=.*[0-9])/;
				var nCaseAlphabetic = /^(?=.*[0-9])/;
				var sCase = /^(?=.*[@!#$%^&+=]).*$/;
				var msg1 = '';
				var msg2 = '';
				var msg3 = '';
				var msg4 = '';
				var msg5 = '';
				var count = 0
				if (lCaseAlphabetic.test($(this).val()) == false) {
					msg1 = '1 lowercase, ';
					count = 1
				}
				if (uCaseAlphabetic.test($(this).val()) == false) {
					msg2 = '1 uppercase, ';
					count = 1
				}
				if (nCaseAlphabetic.test($(this).val()) == false) {
					msg3 = '1 numeric, ';
					count = 1
				}
				if (sCase.test($(this).val()) == false) {
					msg4 = '1 special character, ';
					count = 1
				}
				if (this.value.length < 10) {
					msg5 = ' 10 characters in length. ';
					count = 1
				}
				if (count == 1) {
					$('#passwordError').html('<span style="color:red;">Password must have at least ' + msg1 + ' ' + msg2 + ' ' + msg3 + ' ' + msg4 + ' ' + msg5 + '</span>');					
					$('#submit_button').prop('disabled', true);
				} else {
					$('#passwordError').html('Password must be 10 characters in length and contain uppercase, lowercase, numeric and special characters.');					
					$('#submit_button').prop('disabled', false);
				}
			});
		});
		function number_format(user_input){
			var filtered_number = user_input.replace(/[^0-9.]/gi, '');
			var length = filtered_number.length;
			var breakpoint = 1;
			var formated_number = '';
	
			for (i = 1; i <= length; i++) {
				if (breakpoint > 3) {
					breakpoint = 1;
					formated_number = ',' + formated_number;
				}
				var next_letter = i + 1;
				formated_number = filtered_number.substring(length - i, length - (i - 1)) + formated_number;
	
				breakpoint++;
			}
	
			return formated_number;
		}
		function readNoti(){
			var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            	url: APP_URL + '/readNotifications',
				type: 'POST',
				data: {"user_id": userID, "_token": token,},
				success: function(data){}
            });
		}
		function getNotificationsCounter(){
			var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            	url: APP_URL + '/getNotificationsCounter',
				type: 'POST',
				data: {"user_id": userID, "_token": token,},
				success: function(data){
					if(data == '0'){
						$('#noti_counter').hide();
					}else{
						$('#noti_counter').show();
						$('#noti_counter').html(data);
					}
				}
            });
		}
		function getNotifications(){
			var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
            	url: APP_URL + '/getNotifications',
				type: 'POST',
				data: {"user_id": userID, "_token": token,},
				success: function(data){
					$('#noti_result_data').html(data);
				}
            });
		}
		function request_status(status, request_id){
			var token = $("meta[name='csrf-token']").attr("content");
			
			if(status == 'Accepted'){var msg = 'Do you really want to accept this request?';}
			if(status == 'Denied'){var msg = 'Do you really want to deny this request?';}
						
			if (confirm(msg)) {
				$.ajax({
					url: APP_URL + '/fundraising/request_status',
					type: 'POST',
					data: {"status": status, "request_id": request_id, "_token": token,},
					success: function(data){
						location.reload();
					}
				});
			}
		}
		function countChar(val, maxLength) {
			var len	= val.value.length;
			if (len >= maxLength) {
				val.value = val.value.substring(0, maxLength);
				$('#charNum').text(0);
			} else {
				$('#charNum').text(maxLength - len);
			}
		}
		function countChar2(val, maxLength) {
			var len	= val.value.length;
			if (len >= maxLength) {
				val.value = val.value.substring(0, maxLength);
				$('#charNum2').text(0);
			} else {
				$('#charNum2').text(maxLength - len);
			}
		}
		$(document).ready(function(){
			$('#noti_counter').hide();
			@guest
			@else
				setInterval(function(){
					getNotificationsCounter();
					getNotifications();
				}, 3000);
			@endguest
		});
	</script>
	@stack('scripts')
</body>
</html>