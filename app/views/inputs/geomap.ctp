
<script language="text/javascript">
    function popupVetrina(whatopen) {
      newWindow = window.open(whatopen, 'popup_vetrina', 'width=520,height=550,scrollbars=yes,toolbar=no,resizable=yes,menubar=no');
      return false;
    }
</script>

<div class="sols">
	<h2><?php __('Geographical and temporal representation'); ?></h2>
	<table>

		<tr>
			<th><?php __('Pcap file'); ?></th>
			<th><?php __('GeoMap file'); ?></th>
		</tr>

		<?php foreach ($inputs as $input): ?>
		<tr>
			<td><?php echo $input['Input']['filename']; ?></td>
		    <td><a href="#" onclick="popupVetrina('/inputs/kml_file/<?php echo $input['Input']['id']; ?>','scrollbar=auto'); return false"><?php echo $input['Input']['filename'] . '.kml'; ?></a></td>
		</tr>
		<?php endforeach; ?>

	</table>
</div>
