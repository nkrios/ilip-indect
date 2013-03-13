<?php
class Plugin extends AppModel {
	var $name = 'Plugin';
	var $primaryKey = 'pluginID';
	var $displayField = 'pluginName';
	var $hasMany = array('TypesPlugin' => array('className' => 'TypesPlugin','foreignKey' => 'pluginID'));
}
?>
