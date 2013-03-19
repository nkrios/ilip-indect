<!DOCTYPE html>
<html>
<head>
  <?php echo $this->Html->charset('utf-8'); ?>
  <meta name="author" content="ILIP - Indect - UC3M">
  <meta name='description' content='ILIP (Indect Lawful Interception Platform)'>
  <meta name='keywords' content='ilip,decoder,internet,ip,traffic,interception,pcap'>

  <?php if (isset($refresh_time)):  ?>
      <!-- <meta http-equiv="refresh" content="<?php echo $refresh_time ?>"> -->
  <?php endif; ?>
  <title>ILIP (Indect Lawful Interception Platform): <?php echo $title_for_layout;?></title>
  <?php 
    echo $html->css('style');
    echo $html->css('mail');
    echo $html->css('webimages');
    //echo $html->css('themes/ui-darkness/jquery-ui-custom.css');
    //echo $html->css('themes/ui-darkness/jquery-ui-1.10.0.custom.min.css');
    //echo $html->script('jquery.js');
    echo $html->script('jquery-1.9.1.min.js');
    // echo $html->script('jquery-ui-custom.min.js');
    //echo $html->script('jquery-ui-1.10.1.custom.min.js');
    echo $html->script('http_get.js');
    // echo $html->script('jquery.tools-1.2.7.min.js');
    // echo $html->script('flowplayer-3.2.2.min.js');
    echo $html->script('swfobject.js');
  ?>

  <?php if (!isset($menu_left)) {
    $menu_left = array(
      'active' => '0',
      'sections' => array(
        array(
          'name' => __('Info', true),
          'sub' => array(
            array('name' => __('About', true), 'link' => '/users/about'),
            array('name' => __('Wiki', true), 'link' => 'http://wiki.xplico.org'),
            array('name' => __('Forum', true), 'link' => 'http://forum.xplico.org'),
            array('name' => __('Licenses', true), 'link' => '/users/licenses')
            )
          )
        )
      );
    }
  ?>
  <script type="text/javascript">
    function Lang(){
	   if ($(this).val() != "Choose another language") {
	     window.location.href='/users/login/'+$(this).val();
	   }
    }
  	$(function() {
  	 $("#lang").change(Lang);
    	// 	$("#accordion").accordion({
    	// 	    autoHeight: false,
    	// 	    collapsible: true,
    	// 	    active: <?php echo $menu_left['active']; ?>,
    	//             icons: {
     //    			header: "ui-icon-circle-arrow-e",
     //   				headerSelected: "ui-icon-circle-arrow-s"
    	// 		}
    	// 	});
      $("#devel_image").click(function(){$(this).slideUp()});
  	 });
  </script>
</head>

<body>

  <div id="wrapper">

    <header id='header'><!-- #header: holds the logo and top links -->

      <div id="title">
        <div>
          <a href='http://www.indect-project.eu'><?php echo $html->image("Indect-logo-bare.jpg", array('alt'=>'INDECT', 'title'=>'INDECT','id'=>'logo_indect')); ?></a>
          <a href='http://www.uc3m.es'><?php echo $html->image("uc3m_55.png", array('alt'=>'UC3M','title'=>'UC3M','id'=>'logo_uc3m')); ?></a>
        </div>
        
        <h1>ILIP (Indect Lawful Interception Platform)</h1>

      </div>

      <div id="session_info">

        <?php if ($session->read('user')): ?>

        <h2><?php __('User: '); ?><span><?php echo $html->link( $session->read('username'), '/users/cpassword') ?></span></h2>

        <?php endif; ?>

        <div id='menu_login'>
            
          <?php if ($session->read('user')): ?>

            <?php if ($session->check('admin')):  ?>
               <?php echo $html->link(__('Admin',true),'/admins')?>
            <?php endif; ?>
              <?php echo $html->link(__('Logout',true),'/users/logout')?>
            <?php else: ?>
              <?php echo $html->link(__('Login',true),'/users/login')?>

          <?php endif; ?>

        </div>

      </div>

    </header><!-- #header end -->

    <nav id='adminmenu' ><!-- navigation -->
      <ul class="menu">
        <?php foreach ($menu_left['sections'] as $section): ?>
            
              <li><a href="#"><?php echo $section['name']; ?></a>

                <ul>
                  <?php foreach ($section['sub'] as $submenu): ?>
                    <li><?php echo $html->link($submenu['name'], $submenu['link']) ?></li>
                  <?php endforeach; ?>
                </ul>

              </li>

        <?php endforeach; ?>
      </ul>
    </nav>

    
    <div id="navigation-bar">
    	<span><?php echo $html->link(__('Session',true),'/sols/view/')?></span>
    	<span>&rarr;</span>
    	<span><?php echo $html->link(__('Session',true),'/sols/view/')?></span>
    </div>
    

    <div id='content'>
      <?php
        echo $this->Session->flash();
        echo $content_for_layout;
      ?>
    </div>


  </div><!-- end Wrapper -->

  <footer id="footer">

    <div id="footer_links">
      
      <ul>

        <li><?php echo $html->link('(Powered by Xplico)','http://www.xplico.org') ?></li>

        <?php if ($session->read('user')): ?>

          <?php if (isset($menu_bare)):  ?>

             <?php foreach ($menu_bare as $mb_elem): ?>
               <li><?php echo $html->link($mb_elem['label'], $mb_elem['link']); ?></li>
             <?php endforeach; ?>

          <?php endif; ?>

          <?php if ($session->check('admin')):?>
             <li><?php echo $html->link(__('Admin', true), '/admins') ?></li>
          <?php endif; ?>

          <li><?php echo $html->link(__('Help', true), '/users/help') ?></li>
          <li><?php echo $html->link(__('Forum', true), 'http://forum.xplico.org') ?></li>
          <li><?php echo $html->link(__('Wiki', true), 'http://wiki.xplico.org') ?></li>
          <li><?php echo $html->link(__('Licenses', true), '/users/licenses') ?></li>

        <?php else: ?>
          <li><?php echo $html->link(__('Licenses', true), '/users/licenses') ?></li>
          <!-- <li><?php //echo $html->link(__('Register', true), '/users/register') ?></li> -->
        <?php endif; ?>
      </ul>
    </div>

    <div id="language_box">
        <select id="lang">
          <option>Choose another language</option>
          <option value="ara">Arabic</option>
          <option value="zh_cn">Chinese</option>
          <option value="zh_tw">Chinese (Taiwan)</option>
          <option value="deu">German</option>
          <option value="eng">English</option>
          <option value="fre">French</option>
          <option value="hin">Hindi</option>
          <option value="ita">Italian</option>
          <option value="jpn">Japanese</option>
          <option value="por">Portuguese</option>
          <option value="pt_br">Portuguese (Brazil)</option>
          <option value="rus">Russian</option>
          <option value="spa">Spanish</option>
          <option value="tur">Turkish</option>
        </select>
    </div>

  </footer>

</body>
</html>
