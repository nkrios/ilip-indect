<?php
class TypesPlugin extends AppModel {
	var $name = 'TypesPlugin';
	var $useTable = 'typesPlugins';
	var $primaryKey = 'ruleID';
	var $displayField = 'type';

	// To do a JOIN with 'Plugin' Table using pluginID
	var $belongsTo = array('Plugin' => array('className' => 'Plugin','foreignKey' => 'pluginID'));
}
?>


