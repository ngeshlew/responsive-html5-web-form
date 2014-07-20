<?php 
error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

//If the form is submitted
if(isset($_POST['submitted'])) {
	
	// require a name from user
	if(trim($_POST['name']) === '') {
		$nameErr =  'Forgot your name!'; 
		$hasError = true;
	} else {
		$name = trim($_POST['name']);
	}
	
	// need valid email
	if(trim($_POST['email']) === '')  {
		$emailErr = 'Forgot to enter in your e-mail address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailErr = 'Invalid Email Address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
	
	// need valid website
	if(trim($_POST['url']) === '')  {
		$websiteErr = 'Forgot to enter in your website.';
		$hasError = true;
	} else if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
  		$websiteErr = "Invalid URL"; 
		$hasError = true;
	} else {
		$email = trim($_POST['url']);
	}
		
	// we need at least some content
	if(trim($_POST['message']) === '') {
		$commentError = 'You forgot to enter a message!';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['message']));
		} else {
			$comments = trim($_POST['message']);
		}
	}
		
	// upon no failure errors let's email now!
	if(!isset($hasError)) {
		
		$emailTo = 'ngugilewis@gmail.com';
		$subject = 'Submitted message from '.$name;
		$sendCopy = trim($_POST['sendCopy']);
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		  $success = mail($emailTo, $subject, $body, $headers);
        
        // set our boolean completion value to TRUE
		$emailSent = true;
	}
}
?>

<!doctype html>
<html lang="en">
<head>
	<title>Contact Us</title>
	
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="Lewis Kang'ethe Ngugi">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- For all browsers -->
	<link href="global.css" media="screen" rel="stylesheet" type="text/css" />
    <link type="text/css" href="style.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Oxygen&effect=anaglyph|Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <script src="jquery.min.js"></script>
	
	<script type="text/javascript">
	
			
	  $(document).bind('autofocus_ready', function() {
		if (!("autofocus" in document.createElement("input"))) {
		  $("#name").focus();
			}
		});
	
		// feature detect
		var supportsRequired = 'required' in document.createElement('input');

		// loop through required attributes
		$('[required]').each(function () {
			if (!supportsRequired) {
				var self = $(this);
				self.removeAttr('required').addClass('required');
			}
			});
	 </script>
</head>
<body>
	<div class="responsive-square">
			<?php if(isset($emailSent) && $emailSent == true) { ?>
                <p class="info">Your email was sent. Huzzah!</p>
            <?php } else { ?>
		
	
<form action="index.php" method="post" class="dark">
    <h1>Contact Form 
        <span>Please fill all the texts in the fields.</span>
    </h1>
					<?php if(isset($hasError)) { ?>
                        <span class="alert">Error submitting the form</span>
                    <?php } ?>
				
    <label>
        <span>Your Name :</span>
        <input class="name" id="name" type="text" name="name" placeholder="Your Full Name" value="<?php if(isset($_POST['name'])) echo $_POST['name'];?>" autofocus required/>
	 </label>
		<?php if($nameErr != '') { ?><span class="error"><?php echo $nameErr;?></span> <?php } ?>
	
    
	<label>
        <span>Your Email :</span>
        <input class="email" id="email" type="email" name="email" placeholder="Valid Email Address" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" required />
    </label>
		<?php if($emailErr != '') { ?><span class="error"><?php echo $emailErr;?></span>	<?php } ?>
	
        
    <label>
        <span>Your Website :</span>
        <input class="url" id="url" type="url" name="url" required placeholder="Valid Website Url" pattern="https?://.+" value="<?php if(isset($_POST['url']))  echo $_POST['url'];?>">
    </label>
	<?php if($websiteErr != '') { ?><span class="error"><?php echo $websiteErr ;?></span>	<?php } ?>
	
    <label>
        <span>Message :</span>
        <textarea class="message" id="message" name="message" placeholder="Enter your comment" required><?php if(isset($_POST['message'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['message']); } else { echo $_POST['message']; } } ?></textarea>
	</label> 		
		<?php if($commentError != '') { ?><span class="error"><?php echo $commentError;?></span><?php } ?>
			
	<label>
        <span>&nbsp;</span> 
		
        <button name="submit" type="submit" class="subbutton">Send</button>
		<input type="hidden" name="submitted" id="submitted" value="true" />
    </label>    
</form>
		<?php } ?>
</div>
	<!-- End #contact -->
	
<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	$(document).ready(function() {
		$('form').submit(function() {
			$('form.dark .error').remove();
			var hasError = false;
			if ($('[required]').each(function() == true) {
				if($.trim($(this).val()) == '') {
					var labelText = $(this).prev('label').text();
					$(this).parent().append('< class="error">Your forgot to enter your '+labelText+'.</p>');
					$(this).addClass('inputError');
					hasError = true;
				} else if($(this).hasClass('email')) {
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
					if(!emailReg.test($.trim($(this).val()))) {
						var labelText = $(this).prev('label').text();
						$(this).parent().append('<p class="error">Sorry! You\'ve entered an invalid '+labelText+'.</p>');
						$(this).addClass('inputError');
						hasError = true;
					}
				}
			});
			if(!hasError) {
				var formInput = $(this).serialize();
				$.post($(this).attr('action'),formInput, function(data){
					$('form.dark').slideUp("fast", function() {				   
						$(this).before('<p class="tick"><strong>Thanks!</strong> Your email has been delivered. Cheers!</p>');
					});
				});
			}
			
			return false;	
		});
	});
	//-->!]]>
</script>
</body>
</html>
