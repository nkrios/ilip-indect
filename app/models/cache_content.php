<?php
class CacheContent extends AppModel {
	var $name = 'CacheContent';
	var $primaryKey = 'contentID';
	var $displayField = 'contentHash';
	var $belongsTo=array('Content' => array('className' => 'Content','foreignKey' => 'contentID'));
}
?>
