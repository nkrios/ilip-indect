<?php
class Content extends AppModel {
	var $name = 'Content';
	var $primaryKey = 'contentID';
	var $displayField = 'caseCategory';
	var $hasOne = array('CacheContent' => array('className' => 'CacheContent','foreignKey' => 'contentID'));
}
?>
