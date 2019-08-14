<?php
class Medma_Removeallorder_Adminhtml_RemoveallorderController extends Mage_Adminhtml_Controller_action
{
	public function indexAction()
	{
		/*-------find all sales table -------*/
		$salesEntitiesConf = array_merge(
    		Mage::getSingleton('core/config')->init()->getXpath('global/models/sales_entity/entities//table'),
    		Mage::getSingleton('core/config')->init()->getXpath('global/models/sales_resource/entities//table')
		);
		/* -------- getting connection with core resources-----*/
		$resource = Mage::getSingleton('core/resource');
		$connection = $resource->getConnection('core_write');

		foreach($salesEntitiesConf as $table)
		{
	    	$table = $resource->getTableName($table);
    		if ($connection->isTableExists($table))
			{
	        	try
				{
					/*----- truncate table ----*/
            		$connection->truncateTable($table);
        		}
				catch(Exception $e)
				{
            		Mage::getSingleton('adminhtml/session')->addError($this->__('An error occured please try again'));
					$this->_redirectReferer('*/*/');return;
        		}
    		}
		}
		Mage::getSingleton('adminhtml/session')->addSuccess($this->__('All order removed successfully.'));
		$this->_redirectReferer('*/*/');
	}
}
