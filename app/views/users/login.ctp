
<script type='text/javascript'>
  $(function() {
      $(".sol").css('minWidth', 200);
      $(".sol").width(180);
      $("h3").css("background-color", "#FF3300");
      $("h3").css("font-size", 14);
  });
</script>


<pre>
<?php 
/*
	$cert_data=openssl_x509_parse($_SERVER['SSL_CLIENT_CERT']);
	print_r($cert_data);
	var_dump($cert_data);
	print_r($cert_data['subject']['UID']);

print_r("<br>**ldap_get_entries = <br>");
print_r($info);
print_r("<br>**ldap_first_entry = <br>");
print_r($entry);
print_r("<br>**ldap_get_atributes = <br>");
print_r($entry_attrs);
print_r("<br>**ldap_get_atributes = <br>");
print_r($entry_attrs_values);
*/
?>
</pre>
<?php if ( $isXplicoRunning == 1) : ?>
  <div id="login" class="shadow-box-bottom">

    <h1><?php __('Please login'); ?></h1>
    
    <?php echo $form->create('User', array('action' => 'login')); ?>
    <?php echo $form->input('userlogin', array('maxlength'=> 25, 'size' => 25, 'label' => __('Username', true), 'required')); ?>
    <?php echo $form->input('password', array('size' => 25, 'label' => __('Password', true))); ?>
    <?php echo $form->submit(__('Validate', true),array('class' => 'cssbutton')); ?>
    <?php echo $form->end(); ?>
    <p><span>Note: </span><?php __('If you want to use a certificate, please close the browser and open it again.'); ?></p>

  </div>

  <?php if ($register) : ?>
    <div id="login" class="shadow-box-bottom">
      <b><a href="/users/register"><?php __('Create an account'); ?></a></b>
    </div>
  <?php endif; ?>
<?php endif; ?>





