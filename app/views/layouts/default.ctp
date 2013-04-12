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
    echo $html->css('menu');
    echo $html->css('mail');
    echo $html->css('mailview');
    echo $html->css('tablestyles');
    echo $html->css('formstyle');

    echo $html->script('jquery-1.9.1.min.js');
    echo $html->script('http_get.js');
    // echo $html->script('flowplayer-3.2.2.min.js');
    echo $html->script('swfobject.js');
  ?>

  <script>
    function Lang(){
	   if ($(this).val() != "Choose another language") {
	     window.location.href='/users/login/'+$(this).val();
	   }
    }
  	$(function() {
      $("#lang").change(Lang);
      $("#devel_image").click(function(){$(this).slideUp()});
  	 });
  </script>
</head>

<body>

  <header id='header' class="centered">

      <div id="logos" class="divamiddle">
          <a href='http://www.indect-project.eu'><?php echo $html->image("Indect-logo-bare.jpg", array('alt'=>'INDECT', 'title'=>'INDECT','id'=>'logo_indect','class'=>'divamiddle')); ?></a>
          <a href='http://www.uc3m.es'><?php echo $html->image("uc3m_55.png", array('alt'=>'UC3M','title'=>'UC3M','id'=>'logo_uc3m','class'=>'divamiddle')); ?></a>
      </div>

      <h1 id="title" class="divamiddle">ILIP (Indect Lawful Interception Platform)</h1>

      <div id="session_info" class="divamiddle">

        <?php if ($session->read('user')): ?>

        <h2 class="divamiddle">
          <!-- <?php __('User: '); ?> -->
          <span class='divamiddle' style="background-color:rgba(200,200,200,0.3);padding:3px 6px;border-radius:10px;">
            <img src="/img/user2.png" alt="User" class="divamiddle"><?php echo $html->link( $session->read('username'), '/users/cpassword') ?>
          </span>
        </h2>

        <?php endif; ?>

        <div id='menu_login' class='divamiddle'>
            
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

    </header>

  <div id="wrapper" class="centered">

    <nav id='adminmenu' class="centered">
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
      <?php if($this->Session->check("pol")){
            echo '<span>'.$html->link(__('Sessions',true),'/sols/index').'</span>';
            if($this->Session->check("sol")){
              echo '<span>&rarr;</span>';
              echo '<span>'.$html->link(__('Session',true),'/sols/view/'.$this->Session->read('pol')).'</span>';
                if($this->params['controller'] != 'sols'){
                  echo '<span>&rarr;</span>';
                  echo '<span>'.$html->link($this->params['controller'],
                        '/'.$this->params['controller'].'/'.'index').'</span>';
                }
              }
          }else{}?>
    </div>
    
    <div id='content' class="centered">
      <?php
        echo $content_for_layout;
        echo $this->Session->flash();
      ?>
    </div>

<!-- Log Session -->
    <?php 
    // print_r($this->Session->read());
    //     echo 'POL session: '. $this->Session->check("pol");
    //     echo '<br><br>';
    //     print_r($this->params);
    ?>
  
  </div><!-- end Wrapper -->

  <footer id="footer" class="centered">

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