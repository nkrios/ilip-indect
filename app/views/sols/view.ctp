
<script type='text/javascript'>

	var cX = 0; var cY = 0; var rX = 0; var rY = 0;
	function UpdateCursorPosition(e){ cX = e.pageX; cY = e.pageY;}
	function UpdateCursorPositionDocAll(e){ cX = event.clientX; cY = event.clientY;}
	if(document.all) { document.onmousemove = UpdateCursorPositionDocAll; }
	else { document.onmousemove = UpdateCursorPosition; }
	function AssignPosition(d) {
		if(self.pageYOffset) {
			rX = self.pageXOffset;
			rY = self.pageYOffset;
		}else if(document.documentElement && document.documentElement.scrollTop) {
			rX = document.documentElement.scrollLeft;
			rY = document.documentElement.scrollTop;
		}else if(document.body) {
			rX = document.body.scrollLeft;
			rY = document.body.scrollTop;
		}

		if(document.all) {
			cX += rX; 
			cY += rY;
		}
		d.style.left = (cX+10) + "px";
		d.style.top = (cY+10) + "px";
	}
	function HideContent(d) {
		// if(d.length < 1) { return; }
		// document.getElementById(d).style.display = "none";
		d.style.display = "none";
	}
	function ShowContent(d) {
		// if(d.length < 1) { return; }
		// var dd = document.getElementById(d);
		console.log(d);
		var dd = d;
		AssignPosition(dd);
		dd.style.display = "block";
	}
	function ReverseContentDisplay(d) {
		if(d.length < 1) { return; }
		var dd = document.getElementById(d);
		AssignPosition(dd);
		if(dd.style.display == "none") { dd.style.display = "block"; }
		else { dd.style.display = "none"; }
	}

	$(function addListeners() {		
		// $('.info-block h3').mouseover(ShowContent($('.info-block h3').nextAll("table")[0]));
		// $('.info-block h3').mouseout(HideContent($('.info-block h3').nextAll("table")[0]));
	});


  	$(function() {
    	//$("#hoff").button();
  		//$("#hon").button();
		if (<?php echo $help; ?>) $("#help_off").hide();
		else $("#help_on").hide();

		$("#hoff, #hon").click(function() {
			$("#help_off").toggle(1000);
			$("#help_on").toggle(500);
		});
  	});

</script>

<div id="help_off">

  <?php echo $this->Session->flash(); ?>

  <?php 
  	//we don't want it to show because after adding the plugin manager the values are wrong. Show the content size left, instead
  	$pbar = false;
  ?>
   <?php if ($pbar) : ?>
    	<script type="text/javascript">
    	$(function() {
    		$("#progressbar").progressbar({
    			value: <?php echo $est_time_perc; ?>
    		});
    	});
    	</script>
   <?php endif ?>

   <div><!-- Upper block -->

  <div class="solinfo">
    
    <h2 class="shadow-box-bottom"><?php __('Session Data'); ?></h2>
     
    <?php if ($pbar) : ?>

       <div id="progressbar"></div>
       <div id="progressbar_et"><?php __('E.T.'); ?>: <?php echo $est_time; ?> sec</div>

    <?php elseif($dec_tot > 0) : //added to show the contents left instead of the progress bar?>
      <div id="progressbar_et"><?php __('Data size being analyzed'); ?>: <?php echo $dec_tot; ?> bytes</div>       
    
    <?php endif ?>

    <table class="shadow-box-bottom">
      <tr>
          <th><?php __('Case and Session name'); ?></th>
          <td><?php echo $html->link($sol['Pol']['name'], '/pols/view/' .$sol['Pol']['id']).' -> '.$sol['Sol']['name']; ?></td>
        </tr>
        <tr>
          <th><?php __('Cap. Start Time'); ?></th>
          <td><?php echo $sol['Sol']['start_time']; ?></td>
        </tr>
        <tr>
           <th><?php __('Cap. End Time'); ?></th>
           <td><?php echo $sol['Sol']['end_time']; ?></td>
        </tr>
        <tr>
          <th><?php __('Status'); ?></th>
          <td><?php echo $sol['Sol']['status']; ?></td>
        </tr>	
        <tr>
          <th><?php __('Hosts'); ?></th>
          <td>
            <?php if (empty($hosts)): ?>
              <span>---</span>
            <?php else : ?>
              <span id='hosts'>
                <?php 
                  echo $form->create('host', array('url' => array('controller' => 'sols', 'action' => 'host')));
                  $hosts[0] = __('View all hosts', true);
                  echo $form->select('host', $hosts, $hosts[0]);
                  echo $form->end(__('Filter', true));
                ?>
              </span>
            <?php endif; ?>
          </td>        
      </tr>   
      
    </table>
  
  </div>

  <div id='pcap_upload' class="pcap_input">

    <?php if (!$live) : ?>

      <h2 class="shadow-box-bottom"><?php __('Pcap set'); ?></h2>

      <table class="shadow-box-bottom">

        <tr>

          <td>
      
          <?php if ($last_sol == 1): ?>

            <?php if (!$register): ?>
              <h4><?php echo $html->link(__('SFTP uploading', true), 'sftp://'.env('HOST').'/opt/xplico/pol_'.$sol['Pol']['id'].'/sol_'.$sol['Sol']['id'].'/new/'); ?> <?php __('big pcap files'); ?>.</h4>
            <?php endif; ?>
          </td>
        <tr>
          <td>

            <h4><?php __('Add new pcap file'); ?>.</h4>
              <?php
                echo $form->create(__('Sols', true), array('action' => 'pcap', 'type' => 'file'));
                echo $form->file('File', array('label' => __('File', true)));
                echo $form->end(__('Upload', true));
              ?>

            <?php else: ?>     
               <span><?php __('Not possible to add new pcap files.'); ?></span>
            
          <?php endif; ?>

          <?php if ($register): ?>
                <button id="hon" type="button" style="float: right;"><?php __('Rules'); ?></button>
          <?php endif; ?>
        </td>
      </tr>
      <tr>
        <td>
          <h4><?php echo $html->link(__('List', true), '/inputs/index'); ?> <?php __('of all pcap files'); ?>.</h4>

            <?php else : ?>
            
              <h2><?php __('Live'); ?></h2>
          
              <div>
                <?php if ($livestop) : ?>
          	       <!-- To-do: display, just for info puropouses, the interface name that is currently sniffing.-->
                  <?php __('Listening at interface'); ?>: <?php echo $interff; ?>
                  <?php echo $form->create('/sol', array ('action' => 'livestop')); ?>
                  <?php echo $form->end('Stop'); ?>
                <?php else : ?>
                  <?php echo $form->create('sol', array ('action' => 'live'));?>
                  <?php __('Interface'); ?>:
                  <?php  echo $form->select('Interface.Type', array($interface,null,null,'Choose adaptor')); ?>
                <?php echo $form->end(__('Start', true)); ?>
              </div>
          
          <?php endif ?>
        
        <?php endif ?>

        </td>
      </tr>

    </table>

  </div>

  </div><!-- end of upper block -->

  <div id="statistic_panel">

    <table class="shadow-box-bottom">

    <tbody>
      
      <tr>
        <th>Graph</th>
          
          <td>
            <div class="info-block shadow-box-bottom">
              <h3><?php __('Dns - Arp - Icmpv6'); ?></h3>
              <table>
                <tr>
                  <th><?php __('DNS res'); ?></th>
                  <td><?php echo $dns_num; ?></td>
                </tr>
                <tr>
                  <th><?php __('ARP/ICMPv6'); ?></th>
                  <td><?php echo $arp_num.'/'.$icmpv6_num; ?></td>
                </tr>
              </table>
            </div>

        </td>
      </tr>

      <tr>
        <th>Web</th>

        <td>
          <div class="info-block shadow-box-bottom">
          <h3><?php __('Feed (RSS & Atom)'); ?></h3>
          <table>
          <tr>
            <th><?php __('Number'); ?></th>
            <td><?php echo $feed_num; ?></td>
          </tr>
          </table>
          </div>
        </td>

      </tr>

      <tr>

        <th>Mail</th>

        <td>
          <div class="info-block shadow-box-bottom">
          <h3><?php __('Emails'); ?></h3>
          <table>
            <tr>
            <th><?php __('Received'); ?></th>
            <td><?php echo $eml_received ?></td>
            </tr>
              <tr>
            <th><?php __('Sent'); ?></th>
            <td><?php echo $eml_sended ?></td>
            </tr>
              <tr>
            <th><?php __('Unreaded'); ?></th>
            <td><?php echo $eml_unread.'/'.$eml_total ?></td>
            </tr>
          </table>
          </div>

          <div class="info-block shadow-box-bottom">
            <h3><?php __('Web Mail'); ?></h3>
            <table>
              <tr>
              <th><?php __('Total'); ?></th>
              <td><?php echo $webmail_num; ?></td>
              </tr>
              <tr>
              <th><?php __('Received'); ?></th>
              <td><?php echo $webmail_receiv; ?></td>
              </tr>
                <tr>
              <th><?php __('Sent'); ?></th>
              <td><?php echo $webmail_sent; ?></td>
              </tr>
           </table>
         </div>
        </td>

      </tr>
      <tr>

        <th>VoIP</th>

        <td>      
          <div class="info-block shadow-box-bottom">  
          <h3><?php __('SIP'); ?></h3>
          <table>
            <tr>
            <th><?php __('Calls'); ?></th>
            <td><?php echo $sip_calls ?></td>
          </tr>
          </table>
          </div>
        </td>

      </tr>

      <tr>

        <th>Share</th>

        <td>
          <div class="info-block shadow-box-bottom">
            <h3><?php __('FTP - TFTP - HTTP file'); ?></h3>
            <table>
              <tr>
              <th><?php __('Connections'); ?></th>
              <td><?php echo $ftp_num." - ".$tftp_num; ?></td>
              </tr>
                <tr>
              <th><?php __('Downloaded'); ?></th>
              <td><?php echo $ftp_down." - ".$tftp_down; ?></td>
              </tr>
                <tr>
              <th><?php __('Uploaded'); ?></th>
              <td><?php echo $ftp_up." - ".$tftp_up; ?></td>
              </tr>
                <th><?php __('HTTP'); ?></th>
              <td><?php echo $httpfile_num; ?></td>
              </tr>
            </table>
          </div>
       
          <div class="info-block shadow-box-bottom">
            <h3><?php __('Printed files'); ?></h3>
            <table>
              <tr>
              <th><?php __('Pdf'); ?></th>
              <td><?php echo $pjl_num; ?></td>
            </tr>
            </table>
          </div>
  
          <div class="info-block shadow-box-bottom">
          <h3><?php __('MMS'); ?></h3>
          <table>
            <tr>
            <th><?php __('Number'); ?></th>
            <td><?php echo $mms_num; ?></td>
            </tr>
              <tr>
            <th><?php __('Contents'); ?></th>
            <td><?php echo $mms_cont; ?></td>
            </tr>
              <tr>
            <th><?php __('Video'); ?></th>
            <td><?php echo $mms_video; ?></td>
            
            </tr>
              <tr>
                <th><?php __('Images'); ?></th>
            <td><?php echo $mms_image; ?></td>
          </tr>
          </table>
          </div>
        </td>

      </tr>

      <tr>

        <th>Chat</th>

        <td>
          <div class="info-block shadow-box-bottom">
          <h3><?php __('IRC/Paltalk Exp/Msn'); ?></h3>
          <table>
            <tr>
              <th><?php __('Server'); ?></th>
              <td><?php echo $irc_num; ?></td>
            </tr>
            <tr>
              <th><?php __('Channels'); ?></th>
              <td><?php echo $irc_chnl_num.'/'.$paltalk_exp_num.'/'.$msn_num; ?></td>
            </tr>
          </table>
         </div>

          <div class="info-block shadow-box-bottom">
          <h3><?php __('NNTP'); ?></h3>
          <table>
            <tr>
            <th><?php __('Groups'); ?></th>
            <td><?php echo $nntp_grp; ?></td>
            </tr>
            <tr>
            <th><?php __('Articles'); ?></th>
            <td><?php echo $nntp_artcl; ?></td>
          </tr>
          </table>
          </div>

          <div class="info-block shadow-box-bottom">
            <h3><?php __('Facebook Chat / Paltalk'); ?></h3>
            <table>
              <tr>
              <th><?php __('Users'); ?></th>
              <td><?php echo $fbc_users; ?></td>
              </tr>
              <tr>
              <th><?php __('Chats'); ?></th>
              <td><?php echo $fbc_chats.'/'.$paltalk_num; ?></td>
            </tr>
            </table>
          </div>
        </td>
      </tr>

      <tr>

        <th>Shell</th>

        <td>   
          <div class="info-block shadow-box-bottom">        
            <h3><?php __('Telnet'); ?></h3>
            <table>
              <tr>
              <th><?php __('Connections'); ?></th>
              <td><?php echo $telnet_num; ?></td>
            </tr>
            </table>
          </div>

          <div class="info-block shadow-box-bottom">
          <h3><?php __('Syslog'); ?></h3>
          <table>
            <tr>
            <th><?php __('Logs'); ?></th>
            <td><?php echo $syslog_num; ?></td>
          </tr>
         </table>
         </div>
        </td>

      </tr>

      <tr>
         <th>Undecoded</th>
        <td>   
          <div class="info-block shadow-box-bottom">
          <h3><?php __('Undecoded'); ?></h3>
          <table>
            <tr>
            <th><?php __('Text flows'); ?></th>
            <td><?php echo $text_num; ?></td>
          </tr>
         </table>
      </div>
        </td>

      </tr>

    </tbody>
  </table>

</div>

<div id="help_on">
  <div class="sol">
    <h3><?php __('Rules'); ?></h3>
    <ul>
      <li><?php __('All data will be deleted at'); ?>: 00:00 GMT</li>
      <li><?php __('Max pcap file size'); ?>: 5MB.<?php __(' Larger files will be rejected. There is no limit on how many packets the capture file contains.'); ?></li>
      <li><?php __('Total pcap size limit'); ?>: 10MB</li>
      <li><?php __("While the decoded data are not shared, we make no claims that your data is not viewable by other users. For now, if you want to protect sensitive data in your capture files, don't use the free XplicoDemo service."); ?></li>
      <li><?php __("We recommend using Firefox 3.x, Safari 4.x or greater, or Google Chrome."); ?>
    </ul> 
    <button id="hoff" type="button"><?php __('Ok'); ?></button>
  </div>
</div>
