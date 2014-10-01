<?php

$installer = $this;

$installer->startSetup();

$installer->run("
				
-- DROP TABLE IF EXISTS {$this->getTable('banners')};
CREATE TABLE {$this->getTable('banners')} (                                 
   `banners_id` int(11) unsigned NOT NULL auto_increment,  
   `title` varchar(255) NOT NULL default '',               
   `bannerimage` varchar(255) NOT NULL default '',         
   `filethumbgrid` text,                                   
   `link` varchar(255) default NULL,                       
   `target` varchar(255) default NULL,                     
   `textblend` varchar(255) default NULL,                  
   `content` text NOT NULL,    
   `sort_order` int(11) default '0',
   `status` smallint(6) NOT NULL default '0',              
   `created_time` datetime default NULL,                   
   `update_time` datetime default NULL,                    
   PRIMARY KEY  (`banners_id`)                             
 ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- DROP TABLE IF EXISTS {$this->getTable('banners_store')};
CREATE TABLE {$this->getTable('banners_store')} (                                
 `banners_id` int(11) NOT NULL,                               
 `store_id` smallint(5) unsigned NOT NULL,                    
 PRIMARY KEY  (`banners_id`,`store_id`),                      
 KEY `FK_BANNERS_STORE_STORE` (`store_id`)                    
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Banners Stores';
");


$installer->endSetup();

?>