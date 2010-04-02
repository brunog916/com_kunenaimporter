<?php
/**
 * Joomla! 1.5 component: Kunena Forum Importer
 *
 * @version $Id: $
 * @author Kunena Team
 * @package Joomla
 * @subpackage Kunena Forum Importer
 * @license GNU/GPL
 *
 * Imports forum data into Kunena
 *
 * @Copyright (C) 2008 - 2009 Kunena Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.com
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');
class KunenaimporterViewImport extends JView {

	function display($tpl = null) {
		$app =& JFactory::getApplication();
		$params =& getKunenaImporterParams();
		$importer =& $this->getModel('import');
		$exporter =& $this->getModel('export_'.$params->get('extforum'));
		$exporter->checkConfig();
		$errormsg = $exporter->getError();
		$messages = $exporter->getMessages();

		if ($errormsg) {
			$status = 'fail';
			$statusmsg = '???';
			$action = '<a href="' . JRoute::_(COM_KUNENAIMPORTER_BASEURL) . '">Check again</a>';
		} else {
			$status = 'success';
			$statusmsg = 'NONE';
			$action = '<a href="' . JRoute::_(COM_KUNENAIMPORTER_BASEURL . '&view=import') . '">Import</a>';
		}

		if (!$errormsg) {
			$options = $exporter->getExportOptions($importer);
			$this->assign('options', $options);
		}
		$this->assign('params', $params);
		$this->assign('errormsg', $errormsg);
		$this->assign('messages', $messages);
		$this->assign('status', $status);
		$this->assign('statusmsg', $statusmsg);
		$this->assign('action', $action);

		if (!$errormsg) {
			JToolBarHelper::custom('import', 'upload', 'upload', JText::_('Import'), false);
		}
		JToolBarHelper::custom('stopimport', 'cancel', 'cancel', JText::_('Cancel'), false);
		$document =& JFactory::getDocument();
		$document->addScriptDeclaration("setTimeout(\"location='".JRoute::_(COM_KUNENAIMPORTER_BASEURL . '&task=import')."'\", 500);");

		parent::display($tpl);
	}
}
?>
